<?php
/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

use App\Libraries\ImageOptimizer;
?>
<?= $this->extend('layouts/admin') ?>

<?= $this->section('styles') ?>
<style>
.media-card { position:relative; border:1px solid var(--card-border); border-radius:8px; overflow:hidden; background:var(--card-bg); transition:border-color .15s; }
.media-card:hover { border-color: var(--accent); }
.media-thumb { height:130px; overflow:hidden; background:var(--body-bg); display:flex; align-items:center; justify-content:center; }
.media-thumb img { width:100%; height:100%; object-fit:cover; display:block; transition:transform .2s; }
.media-card:hover .media-thumb img { transform:scale(1.04); }
.media-meta { padding:.5rem .6rem; }
.media-name { font-size:.7rem; font-weight:500; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:var(--text-primary); }
.media-info { font-size:.65rem; color:var(--text-muted); margin-top:.15rem; }
.media-actions { display:flex; gap:.3rem; padding:.4rem .6rem; border-top:1px solid var(--card-border); }
.badge-webp { background:rgba(99,102,241,.15); color:var(--accent); font-size:.6rem; padding:.15rem .4rem; border-radius:3px; font-weight:600; }
.variants-row { display:flex; gap:.25rem; flex-wrap:wrap; margin-top:.25rem; }
.var-chip { font-size:.6rem; padding:.1rem .35rem; border-radius:3px; background:rgba(100,116,139,.15); color:var(--text-muted); cursor:pointer; transition:background .15s; }
.var-chip:hover { background:rgba(99,102,241,.2); color:var(--accent); }
.btn-xs { padding:.2rem .45rem; font-size:.72rem; }
/* Upload drop zone */
.drop-zone { border:2px dashed var(--card-border); border-radius:10px; padding:1.5rem; text-align:center; transition:border-color .2s, background .2s; cursor:pointer; }
.drop-zone.dragover { border-color:var(--accent); background:rgba(99,102,241,.05); }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- ── Upload Card ─────────────────────────────────────────────── -->
<div class="card mb-4">
    <div class="card-header py-3 px-4 d-flex align-items-center justify-content-between">
        <h6 class="mb-0">Upload & Optimise</h6>
        <span class="badge-webp" style="font-size:.7rem;padding:.25rem .6rem;">Auto → WebP · 4 sizes</span>
    </div>
    <div class="card-body p-4">
        <div class="row g-3 align-items-end mb-3">
            <div class="col-md-5">
                <label class="form-label">Images <small class="text-muted">(JPEG, PNG, WebP, GIF · max 8 MB each)</small></label>
                <div class="drop-zone" id="dropZone">
                    <i class="bi bi-cloud-upload d-block mb-1" style="font-size:1.6rem;color:var(--text-muted);"></i>
                    <div class="text-muted small">Drag & drop or <span style="color:var(--accent);cursor:pointer;" id="dropZoneBrowse">browse</span></div>
                    <div id="dropZoneFileName" class="mt-1 text-muted" style="font-size:.75rem;"></div>
                    <input type="file" id="mediaFileInput" accept="image/*" multiple style="display:none;">
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label">Folder</label>
                <select id="uploadFolder" class="form-select form-select-sm">
                    <?php foreach ($folders as $f): ?>
                    <option value="<?= esc($f) ?>" <?= $currentFolder === $f ? 'selected' : '' ?>><?= esc(ucfirst($f)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Alt Text <small class="text-muted">(applied to all)</small></label>
                <input type="text" id="uploadAltText" class="form-control form-control-sm" placeholder="Describe the images…">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary btn-sm w-100" id="uploadBtn" disabled>
                    <i class="bi bi-upload me-1"></i> Upload All
                </button>
            </div>
        </div>

        <!-- Queue -->
        <div id="uploadQueue" style="display:none;" class="mb-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="small text-muted" id="queueLabel"></span>
                <button type="button" class="btn btn-xs btn-outline-secondary" id="clearQueueBtn">Clear</button>
            </div>
            <div id="queueList" style="display:flex;flex-wrap:wrap;gap:.5rem;"></div>
        </div>

        <!-- Rejected files (pre-upload validation) -->
        <div id="rejectedWrap" style="display:none;" class="mb-2">
            <div class="d-flex align-items-center gap-1 mb-1">
                <i class="bi bi-exclamation-triangle" style="color:#f59e0b;font-size:.8rem;"></i>
                <small class="fw-semibold" style="color:#f59e0b;font-size:.72rem;">Skipped — cannot upload:</small>
            </div>
            <ul id="rejectedList" style="margin:0;padding-left:1.2rem;"></ul>
        </div>

        <!-- Overall progress -->
        <div id="bulkProgressWrap" style="display:none;">
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="progress flex-grow-1" style="height:6px;">
                    <div class="progress-bar bg-primary" id="bulkProgressBar" style="width:0%;transition:width .3s;"></div>
                </div>
                <small id="bulkProgressLabel" class="text-muted" style="white-space:nowrap;font-size:.72rem;"></small>
            </div>
            <!-- Per-file errors from server -->
            <div id="bulkErrorWrap" style="display:none;margin-top:.5rem;">
                <div class="d-flex align-items-center gap-1 mb-1">
                    <i class="bi bi-x-circle" style="color:#ef4444;font-size:.8rem;"></i>
                    <small class="fw-semibold" style="color:#ef4444;font-size:.72rem;">Upload errors:</small>
                </div>
                <ul id="bulkErrorList" style="margin:0;padding-left:1.2rem;color:#ef4444;"></ul>
            </div>
        </div>

        <div class="p-2 rounded" style="background:rgba(99,102,241,.08); font-size:.75rem; color:var(--text-muted);">
            <i class="bi bi-info-circle me-1" style="color:var(--accent);"></i>
            Every upload is <strong style="color:var(--text-primary);">auto-converted to WebP</strong> and saved in 4 responsive sizes:
            <strong style="color:var(--text-primary);">th</strong> 240 px ·
            <strong style="color:var(--text-primary);">sm</strong> 480 px ·
            <strong style="color:var(--text-primary);">md</strong> 800 px ·
            <strong style="color:var(--text-primary);">lg</strong> 1440 px.
            Images smaller than a size are not upscaled.
        </div>
    </div>
</div>

<!-- ── Repair Notice ──────────────────────────────────────────── -->
<?php if (! empty($brokenCount)): ?>
<div class="alert d-flex align-items-center justify-content-between gap-3 py-2 px-3 mb-3"
     style="background:rgba(234,179,8,.12);border:1px solid rgba(234,179,8,.35);border-radius:8px;">
    <div style="font-size:.82rem;">
        <i class="bi bi-exclamation-triangle me-1" style="color:#ca8a04;"></i>
        <strong><?= (int)$brokenCount ?> file<?= $brokenCount !== 1 ? 's are' : ' is' ?> missing size &amp; variant data</strong>
        — uploaded before variant tracking was enabled.
    </div>
    <form method="post" action="/admin/media/repair-variants" style="margin:0;flex-shrink:0;">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn-sm btn-warning py-1">
            <i class="bi bi-wrench me-1"></i>Repair Now
        </button>
    </form>
</div>
<?php endif; ?>

<!-- ── Folder Filter ───────────────────────────────────────────── -->
<div class="d-flex gap-2 mb-4 flex-wrap align-items-center">
    <span class="text-muted small me-1">Filter:</span>
    <a href="/admin/media" class="btn btn-sm <?= $currentFolder === 'all' ? 'btn-primary' : 'btn-outline-secondary' ?>">All</a>
    <?php foreach ($folders as $f): ?>
    <a href="/admin/media?folder=<?= esc($f) ?>" class="btn btn-sm <?= $currentFolder === $f ? 'btn-primary' : 'btn-outline-secondary' ?>">
        <?= esc(ucfirst($f)) ?>
    </a>
    <?php endforeach; ?>
    <span class="ms-auto text-muted small"><?= count($files) ?> file<?= count($files) !== 1 ? 's' : '' ?></span>
</div>

<!-- ── Media Grid ─────────────────────────────────────────────── -->
<?php if (! empty($files)): ?>
<div class="row g-3">
    <?php foreach ($files as $file):
        $variants  = json_decode($file['variants'] ?? '{}', true) ?: [];
        $thumbFile = $variants['th']['file'] ?? $variants['sm']['file'] ?? $file['filename'];
        $thumbUrl  = '/uploads/media/' . $file['folder'] . '/' . $thumbFile;
        $primaryUrl = '/uploads/media/' . $file['folder'] . '/' . $file['filename'];
        $totalSize  = array_sum(array_column($variants, 'size'));
    ?>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
        <div class="media-card">
            <div class="media-thumb">
                <img src="<?= esc($thumbUrl) ?>" alt="<?= esc($file['alt_text'] ?? '') ?>" loading="lazy">
            </div>
            <div class="media-meta">
                <div class="media-name" title="<?= esc($file['original_name'] ?? $file['filename']) ?>">
                    <?= esc($file['original_name'] ?? $file['filename']) ?>
                </div>
                <div class="media-info d-flex align-items-center gap-1 flex-wrap">
                    <span class="badge-webp">WebP</span>
                    <?php if ($file['width']): ?>
                    <span><?= $file['width'] ?>×<?= $file['height'] ?></span>
                    <?php endif; ?>
                    <?php if ($totalSize): ?>
                    <span><?= ImageOptimizer::humanSize($totalSize) ?> total</span>
                    <?php endif; ?>
                </div>
                <?php if (! empty($variants)): ?>
                <div class="variants-row">
                    <?php foreach (['th', 'sm', 'md', 'lg'] as $key):
                        if (! isset($variants[$key])) continue;
                        $v = $variants[$key];
                        $vUrl = '/uploads/media/' . $file['folder'] . '/' . $v['file'];
                    ?>
                    <span class="var-chip" title="<?= $v['w'] ?>×<?= $v['h'] ?> · <?= ImageOptimizer::humanSize($v['size']) ?>"
                          onclick="copyUrl('<?= esc($vUrl) ?>', this)">
                        <?= $key ?> <?= $v['w'] ?>w
                    </span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="media-actions">
                <button type="button" class="btn btn-xs btn-outline-secondary flex-grow-1"
                        onclick="copyUrl('<?= esc($primaryUrl) ?>', this)" title="Copy primary URL">
                    <i class="bi bi-clipboard" style="font-size:.7rem;"></i> Copy URL
                </button>
                <form action="/admin/media/delete/<?= (int)$file['id'] ?>" method="post"
                      onsubmit="return confirm('Delete this image and all its variants?');" style="margin:0;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-xs btn-outline-danger" title="Delete all variants">
                        <i class="bi bi-trash" style="font-size:.7rem;"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="text-center py-5 text-muted">
    <i class="bi bi-images d-block mb-3" style="font-size:3rem;opacity:.25;"></i>
    No files yet. Upload one above.
</div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// ── State ─────────────────────────────────────────────────────
var _queueFiles  = [];  // Array of File objects
var _uploading   = false;

var ALLOWED_EXTS = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
var MAX_BYTES    = 8 * 1024 * 1024; // 8 MB

function getCsrfToken() {
    var match = document.cookie.match(/(?:^|;\s*)csrf_cookie_name=([^;]*)/);
    return match ? decodeURIComponent(match[1]) : '<?= csrf_hash() ?>';
}

const dropZone   = document.getElementById('dropZone');
const fileInput  = document.getElementById('mediaFileInput');
const uploadBtn  = document.getElementById('uploadBtn');
const queueWrap  = document.getElementById('uploadQueue');
const queueList  = document.getElementById('queueList');
const queueLabel = document.getElementById('queueLabel');
const clearBtn   = document.getElementById('clearQueueBtn');
const bulkWrap   = document.getElementById('bulkProgressWrap');
const bulkBar    = document.getElementById('bulkProgressBar');
const bulkLabel  = document.getElementById('bulkProgressLabel');

// ── File selection helpers ────────────────────────────────────
function getExt(name) {
    return name.split('.').pop().toLowerCase();
}

function validateFile(f) {
    var ext = getExt(f.name);
    if (!ALLOWED_EXTS.includes(ext)) {
        return 'Unsupported format .' + ext.toUpperCase() + ' — allowed: JPG, PNG, WebP, GIF';
    }
    if (f.size > MAX_BYTES) {
        return 'File too large (' + (f.size / 1048576).toFixed(1) + ' MB) — max 8 MB';
    }
    return null; // valid
}

function addFiles(files) {
    var rejected = [];
    Array.from(files).forEach(function(f) {
        var err = validateFile(f);
        if (err) {
            rejected.push({ name: f.name, reason: err });
        } else {
            _queueFiles.push(f);
        }
    });
    renderQueue();
    if (rejected.length) {
        showRejected(rejected);
    }
}

function showRejected(list) {
    var wrap = document.getElementById('rejectedWrap');
    var ul   = document.getElementById('rejectedList');
    ul.innerHTML = '';
    list.forEach(function(r) {
        var li = document.createElement('li');
        li.style.cssText = 'font-size:.72rem;color:#ef4444;margin-bottom:.2rem;';
        li.textContent = r.name + ' — ' + r.reason;
        ul.appendChild(li);
    });
    wrap.style.display = '';
}

function renderQueue() {
    if (_queueFiles.length === 0) {
        queueWrap.style.display = 'none';
        uploadBtn.disabled = true;
        document.getElementById('dropZoneFileName').textContent = '';
        dropZone.style.borderColor = '';
        return;
    }
    queueLabel.textContent = _queueFiles.length + ' file' + (_queueFiles.length !== 1 ? 's' : '') + ' queued';
    queueWrap.style.display = '';
    uploadBtn.disabled = false;
    dropZone.style.borderColor = 'var(--accent)';
    document.getElementById('dropZoneFileName').textContent = _queueFiles.length + ' file' + (_queueFiles.length !== 1 ? 's' : '') + ' selected';
    queueList.innerHTML = '';
    _queueFiles.forEach(function(f, i) {
        var chip = document.createElement('div');
        chip.id  = 'qfile-' + i;
        chip.style.cssText = 'display:inline-flex;align-items:center;gap:.3rem;font-size:.72rem;padding:.2rem .5rem;border-radius:4px;background:rgba(100,116,139,.12);color:var(--text-muted);max-width:200px;';
        chip.innerHTML = '<span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:150px;" title="' + f.name + '">' + f.name + '</span>'
            + '<span class="q-status"></span>';
        queueList.appendChild(chip);
    });
}

// ── Browse & drop ─────────────────────────────────────────────
dropZone.addEventListener('click', function() { fileInput.click(); });

fileInput.addEventListener('change', function() {
    addFiles(this.files);
    this.value = '';
});

['dragenter','dragover'].forEach(function(ev) {
    dropZone.addEventListener(ev, function(e) { e.preventDefault(); this.classList.add('dragover'); });
});
['dragleave','drop'].forEach(function(ev) {
    dropZone.addEventListener(ev, function(e) { this.classList.remove('dragover'); });
});
dropZone.addEventListener('drop', function(e) {
    e.preventDefault();
    addFiles(e.dataTransfer.files);
});

// ── Clear queue ───────────────────────────────────────────────
clearBtn.addEventListener('click', function() {
    _queueFiles = [];
    renderQueue();
    bulkWrap.style.display = 'none';
    document.getElementById('rejectedWrap').style.display = 'none';
});

// ── Upload All ────────────────────────────────────────────────
uploadBtn.addEventListener('click', function() {
    if (_uploading || _queueFiles.length === 0) return;
    _uploading = true;
    uploadBtn.disabled = true;
    clearBtn.disabled  = true;
    bulkBar.style.width = '0%';
    bulkLabel.textContent = '';
    bulkWrap.style.display = '';
    document.getElementById('bulkErrorList').innerHTML = '';
    document.getElementById('bulkErrorWrap').style.display = 'none';

    var folder  = document.getElementById('uploadFolder').value;
    var altText = document.getElementById('uploadAltText').value.trim();
    var total   = _queueFiles.length;
    var done    = 0;
    var errors  = 0;

    function markChip(chip, st, ok, msg) {
        if (ok) {
            if (chip) chip.style.background = 'rgba(34,197,94,.1)';
            if (st) { st.textContent = '✓'; st.style.color = 'var(--accent)'; }
        } else {
            if (chip) chip.style.background = 'rgba(239,68,68,.1)';
            if (st) { st.textContent = '✗'; st.style.color = '#ef4444'; }
            if (msg) {
                var li = document.createElement('li');
                li.style.cssText = 'font-size:.72rem;margin-bottom:.15rem;';
                li.innerHTML = '<strong>' + (chip ? chip.querySelector('span').textContent : '') + '</strong> — ' + msg;
                document.getElementById('bulkErrorList').appendChild(li);
                document.getElementById('bulkErrorWrap').style.display = '';
            }
        }
    }

    function uploadNext(index) {
        if (index >= total) {
            bulkBar.style.width = '100%';
            bulkLabel.textContent = done + ' uploaded' + (errors ? ', ' + errors + ' failed' : ' — all done!');
            _uploading = false;
            if (done > 0) {
                setTimeout(function() { window.location.reload(); }, 1200);
            } else {
                clearBtn.disabled = false;
            }
            return;
        }
        var f    = _queueFiles[index];
        var chip = document.getElementById('qfile-' + index);
        var st   = chip ? chip.querySelector('.q-status') : null;
        if (st) { st.textContent = '⏳'; st.style.color = ''; }

        var fd = new FormData();
        fd.append('media_file', f);
        fd.append('folder', folder);
        if (altText) fd.append('alt_text', altText);
        fd.append('<?= csrf_token() ?>', getCsrfToken());

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/media/upload-ajax');
        xhr.onload = function() {
            try {
                var res = JSON.parse(xhr.responseText);
                if (res.success) {
                    done++;
                    markChip(chip, st, true, null);
                } else {
                    errors++;
                    markChip(chip, st, false, res.error || 'Upload failed');
                }
            } catch(e) {
                errors++;
                markChip(chip, st, false, 'Server error (HTTP ' + xhr.status + ')');
            }
            var pct = Math.round((index + 1) / total * 100);
            bulkBar.style.width = pct + '%';
            bulkLabel.textContent = (index + 1) + ' / ' + total;
            uploadNext(index + 1);
        };
        xhr.onerror = function() {
            errors++;
            markChip(chip, st, false, 'Network error');
            var pct = Math.round((index + 1) / total * 100);
            bulkBar.style.width = pct + '%';
            bulkLabel.textContent = (index + 1) + ' / ' + total;
            uploadNext(index + 1);
        };
        xhr.send(fd);
    }

    uploadNext(0);
});

// ── Copy URL ─────────────────────────────────────────────────
function copyUrl(url, el) {
    var full = window.location.origin + url;
    navigator.clipboard.writeText(full).then(function() {
        var orig = el ? el.innerHTML : '';
        if (el) { el.innerHTML = '<i class="bi bi-check2"></i> Copied!'; }
        setTimeout(function() { if (el) el.innerHTML = orig; }, 1500);
    });
}
</script>
<?= $this->endSection() ?>
