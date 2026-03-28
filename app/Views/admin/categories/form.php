<?php
/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @email      info@ramrastech.com
 * @mobile     +91-7317377477
 * @website    https://ramrastech.com
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */
?>
<?= $this->extend('layouts/admin') ?>
<?= $this->section('styles') ?>
<style>
/* Image add tabs — identical to product form */
.img-add-tabs { display:flex; gap:0; border:1px solid var(--card-border); border-radius:8px; overflow:hidden; }
.img-add-tab  { flex:1; padding:.45rem; font-size:.75rem; border:none; background:transparent; color:var(--text-muted); cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center; gap:.3rem; }
.img-add-tab:not(:last-child) { border-right:1px solid var(--card-border); }
.img-add-tab.active            { background:var(--accent); color:#fff; }
.img-add-tab:hover:not(.active){ background:rgba(99,102,241,.1); color:var(--text-primary); }
/* Picker modal grid hover */
.picker-item:hover { border-color: var(--accent) !important; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php $isEdit = ! is_null($category); ?>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="/admin/categories" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <span class="text-muted small">Categories /</span>
    <span class="small"><?= $isEdit ? esc($category['name']) : 'New Category' ?></span>
    <?php if ($isEdit && ! empty($category['slug'])): ?>
    <a href="/category/<?= esc($category['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-primary ms-auto">
        <i class="bi bi-box-arrow-up-right me-1"></i>View on Site
    </a>
    <?php endif; ?>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-4">
                <form action="<?= $isEdit ? '/admin/categories/update/' . $category['id'] : '/admin/categories/save' ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Category Name *<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="The display name shown in navigation menus and product listing pages."></i></label>
                        <input type="text" name="name" class="form-control" value="<?= esc($isEdit ? $category['name'] : '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Parent Category<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Leave as Top Level for main categories. Select a parent to create a sub-category nested beneath it."></i></label>
                        <select name="parent_id" class="form-select">
                            <option value="">— Top Level —</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= ($isEdit && $category['parent_id'] == $cat['id']) ? 'selected' : '' ?>>
                                    <?= esc($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Optional text shown on the category's public listing page to describe its products."></i></label>
                        <textarea name="description" class="form-control" rows="3"><?= esc($isEdit ? $category['description'] : '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category Image<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Upload an image shown on the home page category grid. Recommended: 600×400 px, JPG or PNG."></i></label>

                        <?php if ($isEdit && ! empty($category['image_path'])): ?>
                        <div class="mb-2 d-flex align-items-center gap-3">
                            <?php $editThumb = ($category['image_path'][0] === '/') ? $category['image_path'] : '/uploads/categories/' . $category['image_path']; ?>
                            <img src="<?= esc($editThumb) ?>" alt="Current image"
                                 style="height:72px;width:108px;object-fit:cover;border-radius:6px;border:1px solid #dee2e6;">
                            <div>
                                <div class="form-text mb-1">Upload or pick a new image to replace, or remove it.</div>
                                <button type="submit" form="remove-image-form"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Remove this image from the category? The file will stay in the uploads library.');">
                                    <i class="bi bi-x-lg me-1"></i>Remove Image
                                </button>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Add method tabs -->
                        <div class="img-add-tabs mb-3">
                            <button type="button" class="img-add-tab active" data-panel="cat-tab-upload">
                                <i class="bi bi-upload"></i> Upload
                            </button>
                            <button type="button" class="img-add-tab" data-panel="cat-tab-library">
                                <i class="bi bi-images"></i> Library
                            </button>
                            <button type="button" class="img-add-tab" data-panel="cat-tab-url">
                                <i class="bi bi-link-45deg"></i> URL
                            </button>
                        </div>

                        <!-- Tab: Upload -->
                        <div id="cat-tab-upload">
                            <input type="file" name="image" id="catFileInput"
                                   class="form-control form-control-sm"
                                   accept="image/jpeg,image/png,image/webp">
                            <div class="form-text text-muted mt-1">JPG, PNG, WebP · Recommended 600×400 px</div>
                        </div>

                        <!-- Tab: Library -->
                        <div id="cat-tab-library" style="display:none;">
                            <button type="button" class="btn btn-sm btn-outline-secondary w-100" id="catOpenPickerBtn">
                                <i class="bi bi-images me-1"></i> Browse Media Library
                            </button>
                        </div>

                        <!-- Tab: External URL -->
                        <div id="cat-tab-url" style="display:none;">
                            <div class="d-flex gap-2">
                                <input type="text" id="catExtUrlInput" class="form-control form-control-sm"
                                       placeholder="https://example.com/image.jpg">
                                <button type="button" class="btn btn-sm btn-primary" id="catAddExtUrlBtn" style="white-space:nowrap;">
                                    Add
                                </button>
                            </div>
                            <div class="form-text text-muted mt-1">Paste any image URL</div>
                        </div>

                        <input type="hidden" name="image_url" id="catImageUrl" value="">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Status<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Inactive categories are hidden from the public site, but all their products remain saved in the system."></i></label>
                        <select name="is_active" class="form-select">
                            <option value="1" <?= (!$isEdit || $category['is_active']) ? 'selected' : '' ?>>Active</option>
                            <option value="0" <?= ($isEdit && !$category['is_active']) ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Save Changes' : 'Create Category' ?></button>
                        <a href="/admin/categories" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if ($isEdit && ! empty($category['image_path'])): ?>
<form id="remove-image-form" method="post"
      action="/admin/categories/remove-image/<?= $category['id'] ?>" style="display:none;">
    <?= csrf_field() ?>
</form>
<?php endif; ?>

<!-- Media Library Picker Modal -->
<div class="modal fade" id="catPickerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="background:var(--card-bg);border-color:var(--card-border);">
            <div class="modal-header py-2 px-4" style="border-color:var(--card-border);">
                <h6 class="modal-title mb-0">Media Library</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:invert(1);"></button>
            </div>
            <div class="modal-body px-4 py-3" id="catPickerBody" style="min-height:70vh;">
                <div class="text-center text-muted py-5">
                    <span class="spinner-border spinner-border-sm me-2"></span> Loading…
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
// Move modal to <body> for correct z-index stacking
document.body.appendChild(document.getElementById('catPickerModal'));

function getCsrfToken() {
    var match = document.cookie.match(/(?:^|;\s*)csrf_cookie_name=([^;]*)/);
    return match ? decodeURIComponent(match[1]) : '<?= csrf_hash() ?>';
}

// Tab switching
document.querySelectorAll('#cat-tab-upload, #cat-tab-library, #cat-tab-url').forEach(function(p) {
    p.catTabPanel = true;
});
document.querySelectorAll('.img-add-tab[data-panel]').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.img-add-tab[data-panel]').forEach(function(b) { b.classList.remove('active'); });
        this.classList.add('active');
        ['cat-tab-upload', 'cat-tab-library', 'cat-tab-url'].forEach(function(id) {
            document.getElementById(id).style.display = 'none';
        });
        document.getElementById(this.dataset.panel).style.display = '';
    });
});

// Clear file input when a library/URL pick is made (so only one method submits)
function catSetImageUrl(url) {
    if (!url) return;
    document.getElementById('catImageUrl').value = url;
    document.getElementById('catFileInput').value = '';
}

// External URL — Add button
document.getElementById('catAddExtUrlBtn').addEventListener('click', function() {
    var url = document.getElementById('catExtUrlInput').value.trim();
    if (url) catSetImageUrl(url);
});

// Clear image_url when a file is selected for upload
document.getElementById('catFileInput').addEventListener('change', function() {
    if (this.files.length > 0) document.getElementById('catImageUrl').value = '';
});

// Open picker
document.getElementById('catOpenPickerBtn').addEventListener('click', function() {
    bootstrap.Modal.getOrCreateInstance(document.getElementById('catPickerModal')).show();
    catLoadPicker('categories');
});

function catLoadPicker(folder) {
    var body = document.getElementById('catPickerBody');
    body.innerHTML = '<div class="text-center text-muted py-5"><span class="spinner-border spinner-border-sm me-2"></span> Loading…</div>';
    fetch('/admin/media/picker?folder=' + encodeURIComponent(folder || 'categories'), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function(r) { return r.text(); })
    .then(function(html) { document.getElementById('catPickerBody').innerHTML = html; })
    .catch(function() {
        document.getElementById('catPickerBody').innerHTML =
            '<div class="text-center text-muted py-5"><i class="bi bi-exclamation-circle d-block mb-2" style="font-size:2rem;color:#ef4444;"></i>Failed to load media library.</div>';
    });
}

// Picker body — folder tabs & item selection
document.getElementById('catPickerBody').addEventListener('click', function(e) {
    var folder = e.target.closest('.picker-folder');
    if (folder) { catLoadPicker(folder.dataset.folder); return; }

    var item = e.target.closest('.picker-item');
    if (item) {
        catSetImageUrl(item.dataset.url);
        bootstrap.Modal.getInstance(document.getElementById('catPickerModal'))?.hide();
    }
});

// Picker body — upload to library
document.getElementById('catPickerBody').addEventListener('change', function(e) {
    if (e.target.id !== 'pickerFileInput') return;
    var file = e.target.files[0];
    if (!file) return;

    var progress = this.querySelector('#pickerUploadProgress');
    var bar      = this.querySelector('#pickerProgressBar');
    var msg      = this.querySelector('#pickerUploadMsg');
    if (progress) progress.style.display = '';
    if (msg) msg.textContent = 'Uploading ' + file.name + '…';

    var fd = new FormData();
    fd.append('media_file', file);
    fd.append('folder', 'categories');
    fd.append('<?= csrf_token() ?>', getCsrfToken());

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/admin/media/upload-ajax');
    xhr.upload.addEventListener('progress', function(ev) {
        if (ev.lengthComputable && bar) bar.style.width = Math.round(ev.loaded / ev.total * 100) + '%';
    });
    xhr.onload = function() {
        try {
            var res = JSON.parse(xhr.responseText);
            if (res.success) {
                catSetImageUrl(res.url);
                bootstrap.Modal.getInstance(document.getElementById('catPickerModal'))?.hide();
            } else {
                if (msg) msg.textContent = 'Error: ' + (res.error || 'Upload failed.');
            }
        } catch(err) {
            if (msg) msg.textContent = 'Unexpected error uploading file.';
        }
    };
    xhr.send(fd);
});
</script>
<?= $this->endSection() ?>
