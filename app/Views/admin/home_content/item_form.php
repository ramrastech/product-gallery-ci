<?php
/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */
$isEdit   = $item !== null;
$action   = $isEdit
    ? '/admin/home-content/item/update/' . $item['id']
    : '/admin/home-content/item/create/' . $section;
$backUrl  = '/admin/home-content/section/' . $section;
?>
<?= $this->extend('layouts/admin') ?>
<?= $this->section('styles') ?>
<style>
.img-add-tabs  { display:flex; gap:0; border:1px solid var(--card-border); border-radius:8px; overflow:hidden; }
.img-add-tab   { flex:1; padding:.45rem; font-size:.75rem; border:none; background:transparent; color:var(--text-muted); cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center; gap:.3rem; }
.img-add-tab:not(:last-child)  { border-right:1px solid var(--card-border); }
.img-add-tab.active            { background:var(--accent); color:#fff; }
.img-add-tab:hover:not(.active){ background:rgba(99,102,241,.1); color:var(--text-primary); }
.picker-item:hover { border-color: var(--accent) !important; }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="<?= $backUrl ?>" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to <?= esc($label) ?>
    </a>
</div>

<div class="card" style="max-width:720px;">
    <div class="card-header py-2 px-3">
        <small class="text-muted">Section: <strong><?= esc($label) ?></strong></small>
    </div>
    <div class="card-body">
        <form method="post" action="<?= $action ?>">
            <?= csrf_field() ?>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Icon <small class="text-muted">(Bootstrap icon class, e.g. bi-star)</small></label>
                    <input type="text" name="icon" class="form-control form-control-sm"
                           value="<?= esc($item['icon'] ?? '') ?>" placeholder="bi-star">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control form-control-sm"
                           value="<?= esc($item['title'] ?? '') ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Subtitle</label>
                    <input type="text" name="subtitle" class="form-control form-control-sm"
                           value="<?= esc($item['subtitle'] ?? '') ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Body / Description</label>
                    <textarea name="body" class="form-control form-control-sm" rows="4"><?= esc($item['body'] ?? '') ?></textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Image</label>

                    <?php if (!empty($item['image_url'])): ?>
                    <div class="mb-2 d-flex align-items-center gap-2">
                        <img src="<?= esc($item['image_url']) ?>" alt="Current"
                             style="height:56px;width:84px;object-fit:cover;border-radius:6px;border:1px solid #dee2e6;">
                        <span class="form-text">Current image. Upload or pick a new one to replace.</span>
                    </div>
                    <?php endif; ?>

                    <div class="img-add-tabs mb-2">
                        <button type="button" class="img-add-tab active" data-panel="hc-tab-upload">
                            <i class="bi bi-upload"></i> Upload
                        </button>
                        <button type="button" class="img-add-tab" data-panel="hc-tab-library">
                            <i class="bi bi-images"></i> Library
                        </button>
                        <button type="button" class="img-add-tab" data-panel="hc-tab-url">
                            <i class="bi bi-link-45deg"></i> URL
                        </button>
                    </div>

                    <div id="hc-tab-upload">
                        <div class="d-flex align-items-center gap-2">
                            <input type="file" id="hcFileInput" class="form-control form-control-sm"
                                   accept="image/jpeg,image/png,image/webp" style="max-width:260px;">
                            <span id="hcUploadStatus" class="form-text"></span>
                        </div>
                        <div class="form-text text-muted mt-1">Uploaded to media library · auto-converted to WebP</div>
                    </div>
                    <div id="hc-tab-library" style="display:none;">
                        <button type="button" class="btn btn-sm btn-outline-secondary w-100" id="hcOpenPickerBtn">
                            <i class="bi bi-images me-1"></i> Browse Media Library
                        </button>
                    </div>
                    <div id="hc-tab-url" style="display:none;">
                        <div class="d-flex gap-2">
                            <input type="text" id="hcExtUrlInput" class="form-control form-control-sm"
                                   placeholder="https://example.com/image.jpg">
                            <button type="button" class="btn btn-sm btn-primary" id="hcAddExtUrlBtn" style="white-space:nowrap;">Add</button>
                        </div>
                    </div>

                    <input type="hidden" name="image_url" id="hcImageUrl" value="<?= esc($item['image_url'] ?? '') ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-select form-select-sm">
                        <option value="1" <?= ($item['is_active'] ?? 1) == 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= ($item['is_active'] ?? 1) == 0 ? 'selected' : '' ?>>Hidden</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-check-lg me-1"></i> <?= $isEdit ? 'Update Item' : 'Add Item' ?>
                </button>
                <a href="<?= $backUrl ?>" class="btn btn-outline-secondary btn-sm">Cancel</a>
            </div>
        </form>
    </div>
</div>

<!-- Media Library Picker Modal -->
<div class="modal fade" id="hcPickerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="background:var(--card-bg);border-color:var(--card-border);">
            <div class="modal-header py-2 px-4" style="border-color:var(--card-border);">
                <h6 class="modal-title mb-0">Media Library</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:invert(1);"></button>
            </div>
            <div class="modal-body px-4 py-3" id="hcPickerBody" style="min-height:70vh;">
                <div class="text-center text-muted py-5"><span class="spinner-border spinner-border-sm me-2"></span> Loading…</div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
document.body.appendChild(document.getElementById('hcPickerModal'));

function getCsrfToken() {
    var match = document.cookie.match(/(?:^|;\s*)csrf_cookie_name=([^;]*)/);
    return match ? decodeURIComponent(match[1]) : '<?= csrf_hash() ?>';
}

document.querySelectorAll('.img-add-tab[data-panel]').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.img-add-tab[data-panel]').forEach(function(b) { b.classList.remove('active'); });
        this.classList.add('active');
        ['hc-tab-upload','hc-tab-library','hc-tab-url'].forEach(function(id) { document.getElementById(id).style.display = 'none'; });
        document.getElementById(this.dataset.panel).style.display = '';
    });
});

function hcSetUrl(url) {
    if (!url) return;
    document.getElementById('hcImageUrl').value = url;
    document.getElementById('hcFileInput').value = '';
}

document.getElementById('hcFileInput').addEventListener('change', function() {
    var file = this.files[0]; if (!file) return;
    var status = document.getElementById('hcUploadStatus');
    status.textContent = 'Uploading…'; status.style.color = '';
    var fd = new FormData();
    fd.append('media_file', file); fd.append('folder', 'general');
    fd.append('<?= csrf_token() ?>', getCsrfToken());
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/admin/media/upload-ajax');
    xhr.onload = function() {
        try { var res = JSON.parse(xhr.responseText);
            if (res.success) { hcSetUrl(res.url); status.textContent = '✓ Uploaded'; status.style.color = 'var(--accent)'; }
            else { status.textContent = 'Error: ' + (res.error || 'Failed.'); status.style.color = '#ef4444'; }
        } catch(e) { status.textContent = 'Upload error.'; }
    };
    xhr.send(fd);
});

document.getElementById('hcAddExtUrlBtn').addEventListener('click', function() {
    var url = document.getElementById('hcExtUrlInput').value.trim();
    if (url) hcSetUrl(url);
});

document.getElementById('hcOpenPickerBtn').addEventListener('click', function() {
    bootstrap.Modal.getOrCreateInstance(document.getElementById('hcPickerModal')).show();
    hcLoadPicker('general');
});

function hcLoadPicker(folder) {
    var body = document.getElementById('hcPickerBody');
    body.innerHTML = '<div class="text-center text-muted py-5"><span class="spinner-border spinner-border-sm me-2"></span> Loading…</div>';
    fetch('/admin/media/picker?folder=' + encodeURIComponent(folder || 'general'), { headers: {'X-Requested-With':'XMLHttpRequest'} })
    .then(function(r) { return r.text(); })
    .then(function(html) { document.getElementById('hcPickerBody').innerHTML = html; })
    .catch(function() { document.getElementById('hcPickerBody').innerHTML = '<div class="text-center text-muted py-5">Failed to load.</div>'; });
}

document.getElementById('hcPickerBody').addEventListener('click', function(e) {
    var folder = e.target.closest('.picker-folder');
    if (folder) { hcLoadPicker(folder.dataset.folder); return; }
    var item = e.target.closest('.picker-item');
    if (item) { hcSetUrl(item.dataset.url); bootstrap.Modal.getInstance(document.getElementById('hcPickerModal'))?.hide(); }
});

document.getElementById('hcPickerBody').addEventListener('change', function(e) {
    if (e.target.id !== 'pickerFileInput') return;
    var file = e.target.files[0]; if (!file) return;
    var msg = this.querySelector('#pickerUploadMsg'), bar = this.querySelector('#pickerProgressBar'), progress = this.querySelector('#pickerUploadProgress');
    if (progress) progress.style.display = '';
    if (msg) msg.textContent = 'Uploading ' + file.name + '…';
    var fd = new FormData();
    fd.append('media_file', file); fd.append('folder', 'general');
    fd.append('<?= csrf_token() ?>', getCsrfToken());
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/admin/media/upload-ajax');
    xhr.upload.addEventListener('progress', function(ev) { if (ev.lengthComputable && bar) bar.style.width = Math.round(ev.loaded/ev.total*100)+'%'; });
    xhr.onload = function() {
        try { var res = JSON.parse(xhr.responseText);
            if (res.success) { hcSetUrl(res.url); bootstrap.Modal.getInstance(document.getElementById('hcPickerModal'))?.hide(); }
            else if (msg) msg.textContent = 'Error: ' + (res.error || 'Failed.');
        } catch(e) { if (msg) msg.textContent = 'Error.'; }
    };
    xhr.send(fd);
});
</script>
<?= $this->endSection() ?>
