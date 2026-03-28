<?php
/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */
$s = fn(string $key) => esc($settings[$key] ?? '');

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
    <a href="/admin/about-content" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to About Content
    </a>
</div>

<form method="post" action="/admin/about-content/settings/save">
    <?= csrf_field() ?>

    <!-- Hero -->
    <div class="card mb-4" id="hero">
        <div class="card-header py-2"><strong class="small">Hero Section</strong></div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Page Title <small class="text-muted">(h1)</small></label>
                <input type="text" name="about_hero_title" class="form-control form-control-sm" value="<?= $s('about_hero_title') ?>" placeholder="About Us">
            </div>
            <div class="col-md-6">
                <label class="form-label">Subtitle</label>
                <input type="text" name="about_hero_subtitle" class="form-control form-control-sm" value="<?= $s('about_hero_subtitle') ?>">
            </div>
            <?php $imgPicker('about_hero_bg_url', 'Background Image', 'col-12') ?>
        </div>
    </div>

    <!-- Story -->
    <div class="card mb-4" id="story">
        <div class="card-header py-2"><strong class="small">Story / Who We Are Section</strong></div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Eyebrow</label>
                <input type="text" name="about_story_eyebrow" class="form-control form-control-sm" value="<?= $s('about_story_eyebrow') ?>" placeholder="Who We Are">
            </div>
            <div class="col-md-6">
                <label class="form-label">Heading</label>
                <input type="text" name="about_story_heading" class="form-control form-control-sm" value="<?= $s('about_story_heading') ?>" placeholder="Behind Every Piece, A Story of Dedication">
            </div>
            <div class="col-12">
                <label class="form-label">Body Paragraph 1</label>
                <textarea name="about_story_body_1" class="form-control form-control-sm" rows="3"><?= $s('about_story_body_1') ?></textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Body Paragraph 2</label>
                <textarea name="about_story_body_2" class="form-control form-control-sm" rows="3"><?= $s('about_story_body_2') ?></textarea>
            </div>
            <?php $imgPicker('about_story_main_image', 'Main Image') ?>
            <?php $imgPicker('about_story_accent_image', 'Accent Image') ?>
            <div class="col-md-4">
                <label class="form-label">Badge Number</label>
                <input type="text" name="about_story_badge_num" class="form-control form-control-sm" value="<?= $s('about_story_badge_num') ?>" placeholder="20+">
            </div>
            <div class="col-md-4">
                <label class="form-label">Badge Label</label>
                <input type="text" name="about_story_badge_label" class="form-control form-control-sm" value="<?= $s('about_story_badge_label') ?>" placeholder="Years of Artisan Heritage">
            </div>
            <div class="col-md-4">
                <label class="form-label">Check Items <small class="text-muted">(one per line)</small></label>
                <textarea name="about_story_checks" class="form-control form-control-sm" rows="6"><?= $s('about_story_checks') ?></textarea>
            </div>
        </div>
    </div>

    <!-- Mission & Vision -->
    <div class="card mb-4" id="mission">
        <div class="card-header py-2"><strong class="small">Mission &amp; Vision Section</strong></div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Eyebrow</label>
                <input type="text" name="about_mission_eyebrow" class="form-control form-control-sm" value="<?= $s('about_mission_eyebrow') ?>" placeholder="Our Purpose">
            </div>
            <div class="col-md-6">
                <label class="form-label">Heading</label>
                <input type="text" name="about_mission_heading" class="form-control form-control-sm" value="<?= $s('about_mission_heading') ?>" placeholder="Mission &amp; Vision">
            </div>
            <div class="col-12">
                <label class="form-label">Mission Statement</label>
                <textarea name="about_mission" class="form-control form-control-sm" rows="3"><?= $s('about_mission') ?></textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Vision Statement</label>
                <textarea name="about_vision" class="form-control form-control-sm" rows="3"><?= $s('about_vision') ?></textarea>
            </div>
        </div>
    </div>

    <!-- Timeline -->
    <div class="card mb-4" id="timeline">
        <div class="card-header py-2"><strong class="small">Timeline Section <small class="text-muted fw-normal">— items managed in About Content → Company Timeline</small></strong></div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Eyebrow</label>
                <input type="text" name="about_timeline_eyebrow" class="form-control form-control-sm" value="<?= $s('about_timeline_eyebrow') ?>" placeholder="Our Journey">
            </div>
            <div class="col-md-6">
                <label class="form-label">Heading</label>
                <input type="text" name="about_timeline_heading" class="form-control form-control-sm" value="<?= $s('about_timeline_heading') ?>" placeholder="Two Decades of Growth">
            </div>
        </div>
    </div>

    <!-- Facility -->
    <div class="card mb-4" id="facility">
        <div class="card-header py-2"><strong class="small">Manufacturing Facility Section <small class="text-muted fw-normal">— photos &amp; stats in About Content</small></strong></div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Eyebrow</label>
                <input type="text" name="about_facility_eyebrow" class="form-control form-control-sm" value="<?= $s('about_facility_eyebrow') ?>" placeholder="Our Facility">
            </div>
            <div class="col-md-6">
                <label class="form-label">Heading</label>
                <input type="text" name="about_facility_heading" class="form-control form-control-sm" value="<?= $s('about_facility_heading') ?>" placeholder="Built for Scale. Designed for Quality.">
            </div>
            <div class="col-12">
                <label class="form-label">Body</label>
                <textarea name="about_facility_body" class="form-control form-control-sm" rows="3"><?= $s('about_facility_body') ?></textarea>
            </div>
        </div>
    </div>

    <!-- Team -->
    <div class="card mb-4" id="team">
        <div class="card-header py-2"><strong class="small">Leadership Team Section <small class="text-muted fw-normal">— team members in About Content</small></strong></div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Eyebrow</label>
                <input type="text" name="about_team_eyebrow" class="form-control form-control-sm" value="<?= $s('about_team_eyebrow') ?>" placeholder="Leadership">
            </div>
            <div class="col-md-6">
                <label class="form-label">Heading</label>
                <input type="text" name="about_team_heading" class="form-control form-control-sm" value="<?= $s('about_team_heading') ?>" placeholder="The People Behind the Craft">
            </div>
            <div class="col-12">
                <label class="form-label">Intro Text</label>
                <textarea name="about_team_body" class="form-control form-control-sm" rows="2"><?= $s('about_team_body') ?></textarea>
            </div>
        </div>
    </div>

    <!-- Certifications -->
    <div class="card mb-4" id="certs">
        <div class="card-header py-2"><strong class="small">Certifications Section <small class="text-muted fw-normal">— cert items in About Content</small></strong></div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Eyebrow</label>
                <input type="text" name="about_cert_eyebrow" class="form-control form-control-sm" value="<?= $s('about_cert_eyebrow') ?>" placeholder="Compliance &amp; Trust">
            </div>
            <div class="col-md-6">
                <label class="form-label">Heading</label>
                <input type="text" name="about_cert_heading" class="form-control form-control-sm" value="<?= $s('about_cert_heading') ?>" placeholder="Certified. Audited. Trusted.">
            </div>
            <div class="col-12">
                <label class="form-label">Intro Text</label>
                <textarea name="about_cert_body" class="form-control form-control-sm" rows="2"><?= $s('about_cert_body') ?></textarea>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="card mb-4" id="cta">
        <div class="card-header py-2"><strong class="small">CTA Banner</strong></div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Eyebrow</label>
                <input type="text" name="about_cta_eyebrow" class="form-control form-control-sm" value="<?= $s('about_cta_eyebrow') ?>" placeholder="Partner With Us">
            </div>
            <div class="col-md-6">
                <label class="form-label">Title</label>
                <input type="text" name="about_cta_title" class="form-control form-control-sm" value="<?= $s('about_cta_title') ?>" placeholder="Ready to Start Your OEM Journey?">
            </div>
            <div class="col-12">
                <label class="form-label">Subtitle</label>
                <input type="text" name="about_cta_subtitle" class="form-control form-control-sm" value="<?= $s('about_cta_subtitle') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Primary Button Text</label>
                <input type="text" name="about_cta_primary_text" class="form-control form-control-sm" value="<?= $s('about_cta_primary_text') ?>" placeholder="Get in Touch">
            </div>
            <div class="col-md-6">
                <label class="form-label">Primary Button URL</label>
                <input type="text" name="about_cta_primary_url" class="form-control form-control-sm" value="<?= $s('about_cta_primary_url') ?>" placeholder="/contact">
            </div>
            <div class="col-md-6">
                <label class="form-label">Secondary Button Text</label>
                <input type="text" name="about_cta_secondary_text" class="form-control form-control-sm" value="<?= $s('about_cta_secondary_text') ?>" placeholder="Browse Products">
            </div>
            <div class="col-md-6">
                <label class="form-label">Secondary Button URL</label>
                <input type="text" name="about_cta_secondary_url" class="form-control form-control-sm" value="<?= $s('about_cta_secondary_url') ?>" placeholder="/products">
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

function imgSet(id, url) {
    if (!url) return;
    document.getElementById(id).value = url;
    var prev = document.getElementById('prev_' + id);
    if (prev) { prev.querySelector('img').src = url; prev.style.display = ''; }
    var st = document.getElementById('status_' + id);
    if (st) { st.textContent = '✓ Set'; st.style.color = 'var(--accent)'; setTimeout(function() { st.textContent = ''; }, 2000); }
}

document.querySelectorAll('.img-add-tab[data-pg]').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var pg = this.dataset.pg;
        document.querySelectorAll('.img-add-tab[data-pg="' + pg + '"]').forEach(function(b) { b.classList.remove('active'); });
        this.classList.add('active');
        document.querySelectorAll('[data-pg-panel="' + pg + '"]').forEach(function(p) { p.style.display = 'none'; });
        document.getElementById(this.dataset.panel).style.display = '';
    });
});

document.querySelectorAll('.img-upload-input[data-target]').forEach(function(input) {
    input.addEventListener('change', function() {
        var file = this.files[0]; if (!file) return;
        var id = this.dataset.target;
        var st = document.getElementById('status_' + id);
        if (st) { st.textContent = 'Uploading…'; st.style.color = ''; }
        var fd = new FormData();
        fd.append('media_file', file); fd.append('folder', 'about');
        fd.append('<?= csrf_token() ?>', getCsrfToken());
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/media/upload-ajax');
        xhr.onload = function() {
            try { var res = JSON.parse(xhr.responseText);
                if (res.success) { imgSet(id, res.url); }
                else if (st) { st.textContent = 'Error: ' + (res.error || 'Failed.'); st.style.color = '#ef4444'; }
            } catch(e) { if (st) { st.textContent = 'Upload error.'; st.style.color = '#ef4444'; } }
        };
        xhr.send(fd);
    });
});

document.querySelectorAll('.img-url-set-btn[data-target]').forEach(function(btn) {
    btn.addEventListener('click', function() {
        imgSet(this.dataset.target, document.getElementById('url_' + this.dataset.target).value.trim());
    });
});

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
    fd.append('folder', 'about');
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
