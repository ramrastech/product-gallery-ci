<?php
/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

$isEdit  = ! is_null($product);
$action  = $isEdit ? '/admin/products/update/' . $product['id'] : '/admin/products/save';
$specs   = $isEdit ? ($product['specifications'] ?? []) : [];
$prodId  = $isEdit ? $product['id'] : 0;

/**
 * Resolve image_path to a usable src.
 * Handles: full URL (http/https), absolute path (/uploads/...), legacy bare filename.
 */
$imgSrc = function (string $path): string {
    if (str_starts_with($path, 'http') || str_starts_with($path, '/')) {
        return $path;
    }
    return '/uploads/products/' . $path;
};
?>
<?= $this->extend('layouts/admin') ?>
<?= $this->section('styles') ?>
<style>
.img-card { position:relative; border:2px solid var(--card-border); border-radius:8px; overflow:hidden; cursor:grab; transition:border-color .15s; }
.img-card.is-primary { border-color: var(--accent); }
.img-card img { width:100%; height:88px; object-fit:cover; display:block; }
.img-card .img-actions { position:absolute; top:4px; right:4px; display:flex; flex-direction:column; gap:3px; }
.img-btn { width:22px; height:22px; border:none; border-radius:4px; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:11px; }
.img-primary-bar { position:absolute; bottom:0; left:0; right:0; background:rgba(99,102,241,.85); text-align:center; font-size:9px; color:#fff; padding:2px; letter-spacing:.5px; }

/* Add-image tabs */
.img-add-tabs { display:flex; gap:0; border:1px solid var(--card-border); border-radius:8px; overflow:hidden; }
.img-add-tab { flex:1; padding:.45rem; font-size:.75rem; border:none; background:transparent; color:var(--text-muted); cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center; gap:.3rem; }
.img-add-tab:not(:last-child) { border-right:1px solid var(--card-border); }
.img-add-tab.active { background:var(--accent); color:#fff; }
.img-add-tab:hover:not(.active) { background:rgba(99,102,241,.1); color:var(--text-primary); }

/* Pending images */
.pending-card { position:relative; border:2px dashed var(--accent); border-radius:8px; overflow:hidden; }
.pending-card img { width:100%; height:88px; object-fit:cover; display:block; }
.pending-remove { position:absolute; top:4px; right:4px; width:22px; height:22px; border:none; border-radius:4px; background:rgba(239,68,68,.8); color:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:12px; }
.pending-badge { position:absolute; bottom:0; left:0; right:0; background:rgba(99,102,241,.8); text-align:center; font-size:9px; color:#fff; padding:2px; }

/* Picker modal grid hover */
.picker-item:hover { border-color: var(--accent) !important; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="/admin/products" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <span class="text-muted small">Products /</span>
    <span class="small"><?= $isEdit ? esc($product['name']) : 'New Product' ?></span>
    <?php if ($isEdit && ! empty($product['slug'])): ?>
    <a href="/products/<?= esc($product['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-primary ms-auto">
        <i class="bi bi-box-arrow-up-right me-1"></i>View on Site
    </a>
    <?php endif; ?>
</div>

<form action="<?= $action ?>" method="post" enctype="multipart/form-data" id="productForm">
    <?= csrf_field() ?>
    <div class="row g-4">

        <!-- ── Left Column ── -->
        <div class="col-lg-8">

            <!-- Basic Info -->
            <div class="card mb-4">
                <div class="card-header py-3 px-4"><h6 class="mb-0">Basic Information</h6></div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Product Name *<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="The full product name shown in listings and on the product detail page."></i></label>
                        <input type="text" name="name" class="form-control"
                               value="<?= esc($isEdit ? $product['name'] : old('name')) ?>" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">SKU / Model No.<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Internal stock or model number for reference. Not shown publicly."></i></label>
                            <input type="text" name="sku" class="form-control"
                                   value="<?= esc($isEdit ? $product['sku'] : old('sku')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Assign a category to help buyers browse by product type."></i></label>
                            <select name="category_id" class="form-select">
                                <option value="">— Select Category —</option>
                                <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"
                                    <?= ($isEdit ? $product['category_id'] : old('category_id')) == $cat['id'] ? 'selected' : '' ?>>
                                    <?= esc($cat['name']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Short Description<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="A brief 1–2 line summary shown in product cards and search results."></i></label>
                        <textarea name="short_description" class="form-control" rows="2"><?= esc($isEdit ? $product['short_description'] : old('short_description')) ?></textarea>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Full Description<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Detailed product description shown on the product page. HTML formatting is supported."></i></label>
                        <textarea name="description" class="form-control" rows="6"><?= $isEdit ? $product['description'] : old('description') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Specifications -->
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between py-3 px-4">
                    <h6 class="mb-0">Specifications<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Key-value pairs like Material: Leather or Color: Brown. Displayed in a table on the product page."></i></h6>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="addSpec">
                        <i class="bi bi-plus"></i> Add Row
                    </button>
                </div>
                <div class="card-body p-4">
                    <div id="specRows">
                        <?php foreach ($specs as $key => $val): ?>
                        <div class="spec-row d-flex gap-2 mb-2">
                            <input type="text" name="spec_key[]" class="form-control form-control-sm" placeholder="Key (e.g. Material)" value="<?= esc($key) ?>">
                            <input type="text" name="spec_value[]" class="form-control form-control-sm" placeholder="Value" value="<?= esc($val) ?>">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-spec"><i class="bi bi-x"></i></button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <p class="text-muted small mb-0 mt-2" id="specHint" <?= ! empty($specs) ? 'style="display:none"' : '' ?>>No specifications added yet.</p>
                </div>
            </div>

            <!-- SEO -->
            <div class="card mb-4">
                <div class="card-header py-3 px-4"><h6 class="mb-0">SEO & Meta<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Controls how this product appears in Google search results. Leave blank to use defaults."></i></h6></div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Meta Title<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="The title shown in Google search results. Ideal length: 50–70 characters. Leave blank to use the product name."></i></label>
                        <input type="text" name="meta_title" class="form-control"
                               value="<?= esc($isEdit ? $product['meta_title'] : old('meta_title')) ?>">
                        <div class="form-text text-muted">Leave blank to use product name</div>
                    </div>
                    <div>
                        <label class="form-label">Meta Description<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="The snippet shown in Google search results. Ideal length: 120–160 characters. Leave blank to use the short description."></i></label>
                        <textarea name="meta_description" class="form-control" rows="2"><?= esc($isEdit ? $product['meta_description'] : old('meta_description')) ?></textarea>
                    </div>
                </div>
            </div>

        </div><!-- /col-lg-8 -->

        <!-- ── Right Column ── -->
        <div class="col-lg-4">

            <!-- Status -->
            <div class="card mb-4">
                <div class="card-header py-3 px-4"><h6 class="mb-0">Status</h6></div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Visibility<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Active products are visible on the public site. Draft hides the product without deleting any data."></i></label>
                        <select name="is_active" class="form-select">
                            <option value="1" <?= ($isEdit ? $product['is_active'] : 1) == 1 ? 'selected' : '' ?>>Active (Visible)</option>
                            <option value="0" <?= ($isEdit ? $product['is_active'] : 1) == 0 ? 'selected' : '' ?>>Draft (Hidden)</option>
                        </select>
                    </div>
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured"
                               <?= ($isEdit ? $product['is_featured'] : 0) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="isFeatured" style="color:var(--text-muted);">Featured on Homepage<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Featured products appear in the homepage's featured section."></i></label>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> <?= $isEdit ? 'Save Changes' : 'Create Product' ?>
                        </button>
                        <a href="/admin/products" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </div>

            <!-- ── Product Images ── -->
            <div class="card">
                <div class="card-header py-3 px-4">
                    <h6 class="mb-0">Product Images<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Upload multiple images. Drag to reorder. Click ★ to set the primary thumbnail shown in listings."></i></h6>
                    <div class="text-muted" style="font-size:.72rem;">★ = primary · drag to reorder</div>
                </div>
                <div class="card-body p-3">

                    <!-- Existing saved images (sortable) -->
                    <?php if ($isEdit && ! empty($images)): ?>
                    <div id="imageGrid" class="row g-2 mb-3">
                        <?php foreach ($images as $img): ?>
                        <div class="col-4" data-id="<?= $img['id'] ?>">
                            <div class="img-card <?= $img['is_primary'] ? 'is-primary' : '' ?>">
                                <img src="<?= esc($imgSrc($img['image_path'])) ?>" alt="<?= esc($img['alt_text']) ?>">
                                <div class="img-actions">
                                    <button type="button" class="img-btn"
                                            style="background:rgba(0,0,0,.6);"
                                            onclick="setPrimary(<?= $img['id'] ?>)" title="Set primary">
                                        <i class="bi bi-star-fill" style="color:<?= $img['is_primary'] ? '#fbbf24' : '#94a3b8' ?>;"></i>
                                    </button>
                                    <button type="button" class="img-btn"
                                            style="background:rgba(239,68,68,.8);"
                                            onclick="deleteImage(<?= $img['id'] ?>, this)" title="Delete">
                                        <i class="bi bi-x" style="color:#fff;"></i>
                                    </button>
                                </div>
                                <?php if ($img['is_primary']): ?>
                                <div class="img-primary-bar">PRIMARY</div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php elseif ($isEdit): ?>
                    <p class="text-muted small mb-3" id="noImagesMsg">No images yet.</p>
                    <?php endif; ?>

                    <!-- Pending images (library / URL picks, shown before save on new products) -->
                    <div id="pendingGrid" class="row g-2 mb-3" style="display:none;"></div>

                    <!-- Add method tabs -->
                    <div class="img-add-tabs mb-3">
                        <button type="button" class="img-add-tab active" data-tab="upload">
                            <i class="bi bi-upload"></i> Upload
                        </button>
                        <button type="button" class="img-add-tab" data-tab="library">
                            <i class="bi bi-images"></i> Library
                        </button>
                        <button type="button" class="img-add-tab" data-tab="url">
                            <i class="bi bi-link-45deg"></i> URL
                        </button>
                    </div>

                    <!-- Tab: Upload -->
                    <div class="add-tab-panel" id="tab-upload">
                        <input type="file" name="images[]" id="fileInput"
                               class="form-control form-control-sm" multiple
                               accept="image/jpeg,image/png,image/webp">
                        <div class="form-text text-muted mt-1">JPG, PNG, WebP · Max 5 MB each</div>
                    </div>

                    <!-- Tab: Library -->
                    <div class="add-tab-panel" id="tab-library" style="display:none;">
                        <button type="button" class="btn btn-sm btn-outline-secondary w-100" id="openPickerBtn">
                            <i class="bi bi-images me-1"></i> Browse Media Library
                        </button>
                    </div>

                    <!-- Tab: External URL -->
                    <div class="add-tab-panel" id="tab-url" style="display:none;">
                        <div class="d-flex gap-2">
                            <input type="text" id="extUrlInput" class="form-control form-control-sm"
                                   placeholder="https://example.com/image.jpg">
                            <button type="button" class="btn btn-sm btn-primary" id="addExtUrlBtn" style="white-space:nowrap;">
                                Add
                            </button>
                        </div>
                        <div class="form-text text-muted mt-1">Paste any image URL</div>
                    </div>

                </div><!-- /card-body -->
            </div><!-- /card -->

        </div><!-- /col-lg-4 -->
    </div><!-- /row -->
</form>

<!-- ── Media Library Picker Modal ── -->
<div class="modal fade" id="mediaPickerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="background:var(--card-bg); border-color:var(--card-border);">
            <div class="modal-header py-2 px-4" style="border-color:var(--card-border);">
                <h6 class="modal-title mb-0">Media Library</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        style="filter:<?= 'invert(1)' ?>;"></button>
            </div>
            <div class="modal-body px-4 py-3" id="mediaPickerBody" style="min-height:70vh;">
                <div class="text-center text-muted py-5">
                    <span class="spinner-border spinner-border-sm me-2"></span> Loading…
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
const PRODUCT_ID   = <?= $prodId ?>;
const IS_EDIT      = <?= $isEdit ? 'true' : 'false' ?>;
const CSRF_TOKEN   = '<?= csrf_hash() ?>';
const CSRF_NAME    = '<?= csrf_token() ?>';

// ── Spec rows ──────────────────────────────────────────────────
document.getElementById('addSpec')?.addEventListener('click', function () {
    const row = document.createElement('div');
    row.className = 'spec-row d-flex gap-2 mb-2';
    row.innerHTML = '<input type="text" name="spec_key[]" class="form-control form-control-sm" placeholder="Key">' +
                    '<input type="text" name="spec_value[]" class="form-control form-control-sm" placeholder="Value">' +
                    '<button type="button" class="btn btn-sm btn-outline-danger remove-spec"><i class="bi bi-x"></i></button>';
    document.getElementById('specRows').appendChild(row);
    document.getElementById('specHint').style.display = 'none';
});
document.addEventListener('click', function (e) {
    if (e.target.closest('.remove-spec')) {
        e.target.closest('.spec-row').remove();
        if (! document.querySelectorAll('.spec-row').length) {
            document.getElementById('specHint').style.display = '';
        }
    }
});

// ── Image panel tabs ───────────────────────────────────────────
document.querySelectorAll('.img-add-tab').forEach(function (btn) {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.img-add-tab').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.add-tab-panel').forEach(p => p.style.display = 'none');
        this.classList.add('active');
        document.getElementById('tab-' + this.dataset.tab).style.display = '';
    });
});

// ── Sortable existing images ───────────────────────────────────
const grid = document.getElementById('imageGrid');
if (grid && typeof Sortable !== 'undefined') {
    try {
        new Sortable(grid, {
            animation: 150,
            onEnd: function () {
                const order = [...grid.querySelectorAll('[data-id]')].map(el => el.dataset.id);
                fetch('/admin/products/images/reorder', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ order })
                }).catch(() => {});
            }
        });
    } catch (e) {
        console.warn('Sortable init failed:', e);
    }
}

// ── Set primary / delete existing images ──────────────────────
function setPrimary(id) {
    fetch('/admin/products/images/primary/' + id, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    }).then(() => location.reload());
}

function deleteImage(id, btn) {
    if (! confirm('Delete this image?')) return;
    fetch('/admin/products/images/delete/' + id, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    }).then(() => btn.closest('[data-id]').remove());
}

// ── Pending image queue (for new products or pre-save library/URL adds) ──
let pendingCount = 0;

function addPendingImage(url, label) {
    // On edit mode — add immediately via AJAX; on create — queue as hidden input
    if (IS_EDIT && PRODUCT_ID) {
        addImageAjax(url);
        return;
    }
    // Queue as hidden input for form submission
    const pending = document.getElementById('pendingGrid');
    pending.style.display = '';
    const idx = pendingCount++;
    const col = document.createElement('div');
    col.className = 'col-4';
    col.innerHTML = `
        <div class="pending-card">
            <img src="${escHtml(url)}" onerror="this.src='/admin/assets/img-error.png'" style="width:100%;height:88px;object-fit:cover;display:block;">
            <button type="button" class="pending-remove" onclick="removePending(this)">
                <i class="bi bi-x"></i>
            </button>
            <div class="pending-badge">PENDING</div>
            <input type="hidden" name="image_urls[]" value="${escHtml(url)}">
        </div>`;
    pending.appendChild(col);
}

function removePending(btn) {
    btn.closest('.col-4').remove();
    if (! document.getElementById('pendingGrid').children.length) {
        document.getElementById('pendingGrid').style.display = 'none';
    }
}

function getCsrfToken() {
    // Always read the latest token from the cookie (regenerates after each validated POST)
    const match = document.cookie.match(/(?:^|;\s*)csrf_cookie_name=([^;]*)/);
    return match ? decodeURIComponent(match[1]) : CSRF_TOKEN;
}

function addImageAjax(url) {
    const fd = new FormData();
    fd.append(CSRF_NAME, getCsrfToken());
    fd.append('url', url);
    fetch('/admin/products/images/add-url/' + PRODUCT_ID, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: fd
    })
    .then(r => {
        if (! r.ok) throw new Error('HTTP ' + r.status);
        return r.json();
    })
    .then(data => {
        if (data.status === 'ok') {
            location.reload();
        } else {
            alert('Could not add image: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(err => {
        alert('Failed to add image. Please refresh the page and try again.');
        console.error('addImageAjax error:', err);
    });
}

function escHtml(s) {
    return s.replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

// ── External URL tab ──────────────────────────────────────────
document.getElementById('addExtUrlBtn')?.addEventListener('click', function () {
    const input = document.getElementById('extUrlInput');
    const url   = input.value.trim();
    if (! url || ! url.startsWith('http')) {
        input.classList.add('is-invalid');
        return;
    }
    input.classList.remove('is-invalid');
    addPendingImage(url, url);
    input.value = '';
});
document.getElementById('extUrlInput')?.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('addExtUrlBtn').click();
    }
});

// ── Media Library Picker Modal ────────────────────────────────
const pickerModal  = document.getElementById('mediaPickerModal');
const pickerBody   = document.getElementById('mediaPickerBody');
// Move modal to <body> so its z-index is in the root stacking context,
// not scoped inside .content's animation-created stacking context.
document.body.appendChild(pickerModal);
let   pickerLoaded = false;

function loadPicker(folder) {
    folder = folder || 'all';
    pickerBody.innerHTML = '<div class="text-center text-muted py-5"><span class="spinner-border spinner-border-sm me-2"></span> Loading…</div>';
    fetch('/admin/media/picker?folder=' + encodeURIComponent(folder), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => {
        if (! r.ok) throw new Error('HTTP ' + r.status);
        return r.text();
    })
    .then(html => {
        pickerBody.innerHTML = html;
        pickerLoaded = true;
    })
    .catch(() => {
        pickerBody.innerHTML = '<div class="text-center text-muted py-5"><i class="bi bi-exclamation-circle d-block mb-2" style="font-size:2rem;color:#ef4444;"></i>Failed to load media library.<br><small>Check your connection and try again.</small></div>';
    });
}

document.getElementById('openPickerBtn')?.addEventListener('click', function () {
    bootstrap.Modal.getOrCreateInstance(pickerModal).show();
    loadPicker('all');
});

// Folder tabs inside picker (event delegation)
pickerBody.addEventListener('click', function (e) {
    const folderBtn = e.target.closest('.picker-folder');
    if (folderBtn) {
        loadPicker(folderBtn.dataset.folder);
        return;
    }
    const item = e.target.closest('.picker-item');
    if (item) {
        addPendingImage(item.dataset.url, item.dataset.name || item.dataset.url);
        bootstrap.Modal.getInstance(pickerModal)?.hide();
    }
});

// Upload-to-library inside picker (event delegation on change)
pickerBody.addEventListener('change', function (e) {
    if (e.target.id !== 'pickerFileInput') return;
    const file = e.target.files[0];
    if (! file) return;

    const progress  = pickerBody.querySelector('#pickerUploadProgress');
    const bar       = pickerBody.querySelector('#pickerProgressBar');
    const msg       = pickerBody.querySelector('#pickerUploadMsg');

    if (progress) { progress.style.display = ''; }
    if (msg)      { msg.textContent = 'Uploading ' + file.name + '…'; }
    if (bar)      { bar.style.width = '30%'; }

    const fd = new FormData();
    fd.append('media_file', file);
    fd.append('folder', 'general');
    fd.append(CSRF_NAME, getCsrfToken());

    fetch('/admin/media/upload-ajax', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: fd
    })
    .then(r => r.json())
    .then(data => {
        if (bar) bar.style.width = '100%';
        if (data.success) {
            if (msg) msg.textContent = 'Uploaded! Refreshing…';
            setTimeout(() => loadPicker('general'), 400);
        } else {
            if (msg) { msg.textContent = 'Error: ' + (data.error || 'Upload failed'); msg.style.color = '#ef4444'; }
        }
    })
    .catch(() => {
        if (msg) { msg.textContent = 'Upload failed.'; msg.style.color = '#ef4444'; }
    });
});
</script>
<?= $this->endSection() ?>
