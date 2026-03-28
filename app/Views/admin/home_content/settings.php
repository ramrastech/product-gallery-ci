<?php
/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */
$s = fn(string $key) => esc($settings[$key] ?? '');

/**
 * Renders the Upload | Library | URL tab image picker for a settings field.
 * The hidden <input name="$name"> is what gets POSTed.
 */
$imgPicker = function(string $name, string $label, string $colClass = 'col-md-6') use ($settings): void {
    $id  = 'img_' . $name;
    $cur = esc($settings[$name] ?? '');
    ?>
    <div class="<?= $colClass ?>">
        <label class="form-label"><?= $label ?></label>
        <div id="prev_<?= $id ?>" class="mb-2" <?= $cur ? '' : 'style="display:none;"' ?>>
            <img src="<?= $cur ?>" style="height:56px;max-width:120px;object-fit:cover;border-radius:6px;border:1px solid var(--card-border);" alt="">
        </div>
        <div class="img-add-tabs mb-2">
            <button type="button" class="img-add-tab active" data-pg="<?= $id ?>" data-panel="<?= $id ?>-upload"><i class="bi bi-upload"></i> Upload</button>
            <button type="button" class="img-add-tab" data-pg="<?= $id ?>" data-panel="<?= $id ?>-library"><i class="bi bi-images"></i> Library</button>
            <button type="button" class="img-add-tab" data-pg="<?= $id ?>" data-panel="<?= $id ?>-url"><i class="bi bi-link-45deg"></i> URL</button>
        </div>
        <div id="<?= $id ?>-upload" data-pg-panel="<?= $id ?>">
            <div class="d-flex align-items-center gap-2">
                <input type="file" class="form-control form-control-sm img-upload-input" data-target="<?= $id ?>"
                       accept="image/jpeg,image/png,image/webp" style="max-width:230px;">
                <span id="status_<?= $id ?>" class="form-text"></span>
            </div>
            <div class="form-text text-muted mt-1">Auto-converted to WebP · saved to library</div>
        </div>
        <div id="<?= $id ?>-library" data-pg-panel="<?= $id ?>" style="display:none;">
            <button type="button" class="btn btn-sm btn-outline-secondary w-100 img-lib-btn" data-target="<?= $id ?>">
                <i class="bi bi-images me-1"></i> Browse Media Library
            </button>
        </div>
        <div id="<?= $id ?>-url" data-pg-panel="<?= $id ?>" style="display:none;">
            <div class="d-flex gap-2">
                <input type="text" id="url_<?= $id ?>" class="form-control form-control-sm" placeholder="https://… or /uploads/…" value="<?= $cur ?>">
                <button type="button" class="btn btn-sm btn-outline-secondary flex-shrink-0 img-url-set-btn" data-target="<?= $id ?>">Set</button>
            </div>
        </div>
        <input type="hidden" name="<?= $name ?>" id="<?= $id ?>" value="<?= $cur ?>">
    </div>
    <?php
};
?>
<?= $this->extend('layouts/admin') ?>
<?= $this->section('styles') ?>
<style>
.img-add-tabs { display:flex; gap:0; border:1px solid var(--card-border); border-radius:8px; overflow:hidden; }
.img-add-tab  { flex:1; padding:.4rem; font-size:.72rem; border:none; background:transparent; color:var(--text-muted); cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center; gap:.3rem; }
.img-add-tab:not(:last-child)  { border-right:1px solid var(--card-border); }
.img-add-tab.active            { background:var(--accent); color:#fff; }
.img-add-tab:hover:not(.active){ background:rgba(99,102,241,.1); color:var(--text-primary); }
.picker-item:hover { border-color: var(--accent) !important; }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="/admin/home-content" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Home Content
    </a>
</div>

<form method="post" action="/admin/home-content/settings/save">
    <?= csrf_field() ?>

    <!-- Hero -->
    <div class="card mb-4">
        <div class="card-header py-2"><strong class="small">Hero Section</strong></div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Eyebrow Text</label>
                <input type="text" name="hero_eyebrow" class="form-control form-control-sm" value="<?= $s('hero_eyebrow') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Accent Text</label>
                <input type="text" name="hero_accent_text" class="form-control form-control-sm" value="<?= $s('hero_accent_text') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Title Line 1</label>
                <input type="text" name="hero_title_line1" class="form-control form-control-sm" value="<?= $s('hero_title_line1') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Title Line 2</label>
                <input type="text" name="hero_title_line2" class="form-control form-control-sm" value="<?= $s('hero_title_line2') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">CTA Primary Text</label>
                <input type="text" name="hero_cta_primary_text" class="form-control form-control-sm" value="<?= $s('hero_cta_primary_text') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">CTA Primary URL</label>
                <input type="text" name="hero_cta_primary_url" class="form-control form-control-sm" value="<?= $s('hero_cta_primary_url') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">CTA Secondary Text</label>
                <input type="text" name="hero_cta_secondary_text" class="form-control form-control-sm" value="<?= $s('hero_cta_secondary_text') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">CTA Secondary URL</label>
                <input type="text" name="hero_cta_secondary_href" class="form-control form-control-sm" value="<?= $s('hero_cta_secondary_href') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Video URL</label>
                <input type="text" name="hero_video_url" class="form-control form-control-sm" value="<?= $s('hero_video_url') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Trust Badges <small class="text-muted">(comma-separated)</small></label>
                <input type="text" name="hero_trust_badges" class="form-control form-control-sm" value="<?= $s('hero_trust_badges') ?>">
            </div>
            <?php $imgPicker('hero_poster_url', 'Poster Image') ?>
            <?php $imgPicker('hero_frame_image_url', 'Frame Image') ?>
        </div>
    </div>

    <!-- Story / About Snippet -->
    <div class="card mb-4" id="story">
        <div class="card-header py-2"><strong class="small">Story Section</strong></div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Eyebrow</label>
                <input type="text" name="story_eyebrow" class="form-control form-control-sm" value="<?= $s('story_eyebrow') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Heading</label>
                <input type="text" name="story_heading" class="form-control form-control-sm" value="<?= $s('story_heading') ?>">
            </div>
            <div class="col-12">
                <label class="form-label">Body Paragraph 1</label>
                <textarea name="story_body_1" class="form-control form-control-sm" rows="3"><?= $s('story_body_1') ?></textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Body Paragraph 2</label>
                <textarea name="story_body_2" class="form-control form-control-sm" rows="3"><?= $s('story_body_2') ?></textarea>
            </div>
            <?php $imgPicker('story_main_image_url', 'Main Image') ?>
            <?php $imgPicker('story_accent_image_url', 'Accent Image') ?>
            <div class="col-md-4">
                <label class="form-label">Badge Number</label>
                <input type="text" name="story_badge_num" class="form-control form-control-sm" value="<?= $s('story_badge_num') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Badge Label</label>
                <input type="text" name="story_badge_label" class="form-control form-control-sm" value="<?= $s('story_badge_label') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Check Items <small class="text-muted">(newline-separated)</small></label>
                <textarea name="story_checks" class="form-control form-control-sm" rows="3"><?= $s('story_checks') ?></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">CTA Button Text</label>
                <input type="text" name="story_cta_text" class="form-control form-control-sm" value="<?= $s('story_cta_text') ?>" placeholder="View Our Product Range">
            </div>
            <div class="col-md-6">
                <label class="form-label">CTA Button URL</label>
                <input type="text" name="story_cta_url" class="form-control form-control-sm" value="<?= $s('story_cta_url') ?>" placeholder="/products">
            </div>
        </div>
    </div>

    <!-- Featured Products -->
    <div class="card mb-4" id="featured">
        <div class="card-header py-2"><strong class="small">Featured Products Section</strong></div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Eyebrow</label>
                <input type="text" name="featured_eyebrow" class="form-control form-control-sm" value="<?= $s('featured_eyebrow') ?>" placeholder="Showcase">
            </div>
            <div class="col-md-6">
                <label class="form-label">Heading</label>
                <input type="text" name="featured_heading" class="form-control form-control-sm" value="<?= $s('featured_heading') ?>" placeholder="Featured Products">
            </div>
            <div class="col-md-6">
                <label class="form-label">CTA Link Text</label>
                <input type="text" name="featured_cta_text" class="form-control form-control-sm" value="<?= $s('featured_cta_text') ?>" placeholder="View All">
            </div>
            <div class="col-md-6">
                <label class="form-label">CTA Link URL</label>
                <input type="text" name="featured_cta_url" class="form-control form-control-sm" value="<?= $s('featured_cta_url') ?>" placeholder="/products">
            </div>
        </div>
    </div>

    <!-- Section Headings -->
    <div class="card mb-4">
        <div class="card-header py-2"><strong class="small">Section Headings</strong></div>
        <div class="card-body row g-3">
            <?php foreach ([
                'capabilities_eyebrow' => 'Capabilities Eyebrow',
                'capabilities_heading' => 'Capabilities Heading',
                'capabilities_subtext' => 'Capabilities Subtext',
                'categories_eyebrow'   => 'Categories Eyebrow',
                'categories_heading'   => 'Categories Heading',
                'categories_cta_text'  => 'Categories CTA Text',
                'categories_cta_url'   => 'Categories CTA URL',
                'markets_eyebrow'      => 'Markets Eyebrow',
                'markets_heading'      => 'Markets Heading',
                'materials_eyebrow'    => 'Materials Eyebrow',
                'materials_heading'    => 'Materials Heading',
                'whyus_eyebrow'        => 'Why Us Eyebrow',
                'whyus_heading'        => 'Why Us Heading',
            ] as $key => $label): ?>
            <div class="col-md-6">
                <label class="form-label"><?= $label ?></label>
                <input type="text" name="<?= $key ?>" class="form-control form-control-sm" value="<?= $s($key) ?>">
            </div>
            <?php endforeach; ?>
            <div class="col-12">
                <label class="form-label">Materials Body</label>
                <textarea name="materials_body" class="form-control form-control-sm" rows="3"><?= $s('materials_body') ?></textarea>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="card mb-4">
        <div class="card-header py-2"><strong class="small">CTA Banner</strong></div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Eyebrow</label>
                <input type="text" name="cta_eyebrow" class="form-control form-control-sm" value="<?= $s('cta_eyebrow') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Title</label>
                <input type="text" name="cta_title" class="form-control form-control-sm" value="<?= $s('cta_title') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Subtitle</label>
                <input type="text" name="cta_subtitle" class="form-control form-control-sm" value="<?= $s('cta_subtitle') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Note</label>
                <input type="text" name="cta_note" class="form-control form-control-sm" value="<?= $s('cta_note') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">WhatsApp Button Text</label>
                <input type="text" name="cta_whatsapp_text" class="form-control form-control-sm" value="<?= $s('cta_whatsapp_text') ?>" placeholder="Chat on WhatsApp">
            </div>
            <div class="col-md-4">
                <label class="form-label">Browse Button Text</label>
                <input type="text" name="cta_browse_text" class="form-control form-control-sm" value="<?= $s('cta_browse_text') ?>" placeholder="Browse Our Range">
            </div>
            <div class="col-md-4">
                <label class="form-label">Browse Button URL</label>
                <input type="text" name="cta_browse_url" class="form-control form-control-sm" value="<?= $s('cta_browse_url') ?>" placeholder="/products">
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-sm">
        <i class="bi bi-check-lg me-1"></i> Save Settings
    </button>
</form>

<!-- Shared Library Picker Modal -->
<div class="modal fade" id="settingsPickerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="background:var(--card-bg);border-color:var(--card-border);">
            <div class="modal-header py-2 px-4" style="border-color:var(--card-border);">
                <h6 class="modal-title mb-0">Media Library</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:invert(1);"></button>
            </div>
            <div class="modal-body px-4 py-3" id="settingsPickerBody" style="min-height:70vh;">
                <div class="text-center text-muted py-5"><span class="spinner-border spinner-border-sm me-2"></span> Loading…</div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
document.body.appendChild(document.getElementById('settingsPickerModal'));
var _settingsPickerTarget = null;

function getCsrfToken() {
    var match = document.cookie.match(/(?:^|;\s*)csrf_cookie_name=([^;]*)/);
    return match ? decodeURIComponent(match[1]) : '<?= csrf_hash() ?>';
}

// ── Generic: set image value + show preview ───────────────────
function imgSet(id, url) {
    if (!url) return;
    document.getElementById(id).value = url;
    var prev = document.getElementById('prev_' + id);
    if (prev) {
        prev.querySelector('img').src = url;
        prev.style.display = '';
    }
    var st = document.getElementById('status_' + id);
    if (st) { st.textContent = '✓ Set'; st.style.color = 'var(--accent)'; setTimeout(function() { st.textContent = ''; }, 2000); }
}

// ── Tab switching ─────────────────────────────────────────────
document.querySelectorAll('.img-add-tab[data-pg]').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var pg = this.dataset.pg;
        document.querySelectorAll('.img-add-tab[data-pg="' + pg + '"]').forEach(function(b) { b.classList.remove('active'); });
        this.classList.add('active');
        document.querySelectorAll('[data-pg-panel="' + pg + '"]').forEach(function(p) { p.style.display = 'none'; });
        document.getElementById(this.dataset.panel).style.display = '';
    });
});

// ── Upload tab ────────────────────────────────────────────────
document.querySelectorAll('.img-upload-input[data-target]').forEach(function(input) {
    input.addEventListener('change', function() {
        var file = this.files[0]; if (!file) return;
        var id = this.dataset.target;
        var st = document.getElementById('status_' + id);
        if (st) { st.textContent = 'Uploading…'; st.style.color = ''; }
        var fd = new FormData();
        fd.append('media_file', file);
        fd.append('folder', 'general');
        fd.append('<?= csrf_token() ?>', getCsrfToken());
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/media/upload-ajax');
        xhr.onload = function() {
            try {
                var res = JSON.parse(xhr.responseText);
                if (res.success) { imgSet(id, res.url); }
                else if (st) { st.textContent = 'Error: ' + (res.error || 'Failed.'); st.style.color = '#ef4444'; }
            } catch(e) { if (st) { st.textContent = 'Upload error.'; st.style.color = '#ef4444'; } }
        };
        xhr.send(fd);
    });
});

// ── URL tab ───────────────────────────────────────────────────
document.querySelectorAll('.img-url-set-btn[data-target]').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var id = this.dataset.target;
        var url = document.getElementById('url_' + id).value.trim();
        imgSet(id, url);
    });
});

// ── Library tab ───────────────────────────────────────────────
document.querySelectorAll('.img-lib-btn[data-target]').forEach(function(btn) {
    btn.addEventListener('click', function() {
        _settingsPickerTarget = this.dataset.target;
        bootstrap.Modal.getOrCreateInstance(document.getElementById('settingsPickerModal')).show();
        settingsLoadPicker('all');
    });
});

function settingsLoadPicker(folder) {
    var body = document.getElementById('settingsPickerBody');
    body.innerHTML = '<div class="text-center text-muted py-5"><span class="spinner-border spinner-border-sm me-2"></span> Loading…</div>';
    fetch('/admin/media/picker?folder=' + encodeURIComponent(folder || 'all'), { headers: {'X-Requested-With':'XMLHttpRequest'} })
    .then(function(r) { return r.text(); })
    .then(function(html) { document.getElementById('settingsPickerBody').innerHTML = html; })
    .catch(function() { document.getElementById('settingsPickerBody').innerHTML = '<div class="text-center text-muted py-5">Failed to load.</div>'; });
}

document.getElementById('settingsPickerBody').addEventListener('click', function(e) {
    var folder = e.target.closest('.picker-folder');
    if (folder) { settingsLoadPicker(folder.dataset.folder); return; }
    var item = e.target.closest('.picker-item');
    if (item && _settingsPickerTarget) {
        imgSet(_settingsPickerTarget, item.dataset.url);
        bootstrap.Modal.getInstance(document.getElementById('settingsPickerModal'))?.hide();
    }
});

// ── Upload-to-library inside picker modal ─────────────────────
document.getElementById('settingsPickerBody').addEventListener('change', function(e) {
    if (e.target.id !== 'pickerFileInput') return;
    var file = e.target.files[0]; if (!file) return;
    var progress = this.querySelector('#pickerUploadProgress');
    var bar      = this.querySelector('#pickerProgressBar');
    var msg      = this.querySelector('#pickerUploadMsg');
    if (progress) progress.style.display = '';
    if (msg) msg.textContent = 'Uploading ' + file.name + '…';
    var fd = new FormData();
    fd.append('media_file', file);
    fd.append('folder', 'general');
    fd.append('<?= csrf_token() ?>', getCsrfToken());
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/admin/media/upload-ajax');
    xhr.upload.addEventListener('progress', function(ev) {
        if (ev.lengthComputable && bar) bar.style.width = Math.round(ev.loaded / ev.total * 100) + '%';
    });
    xhr.onload = function() {
        try {
            var res = JSON.parse(xhr.responseText);
            if (res.success && _settingsPickerTarget) {
                imgSet(_settingsPickerTarget, res.url);
                bootstrap.Modal.getInstance(document.getElementById('settingsPickerModal'))?.hide();
            } else if (msg) {
                msg.textContent = 'Error: ' + (res.error || 'Upload failed.');
            }
        } catch(err) { if (msg) msg.textContent = 'Unexpected error.'; }
    };
    xhr.send(fd);
});
</script>
<?= $this->endSection() ?>
