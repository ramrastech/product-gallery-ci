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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$isEdit   = ! is_null($product);
$action   = $isEdit ? '/admin/products/update/' . $product['id'] : '/admin/products/save';
$specs    = $isEdit ? ($product['specifications'] ?? []) : [];
?>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="/admin/products" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <span class="text-muted small">Products /</span>
    <span class="small"><?= $isEdit ? esc($product['name']) : 'New Product' ?></span>
</div>

<form action="<?= $action ?>" method="post" enctype="multipart/form-data" id="productForm">
    <?= csrf_field() ?>
    <div class="row g-4">

        <!-- Left Column -->
        <div class="col-lg-8">

            <!-- Basic Info -->
            <div class="card mb-4">
                <div class="card-header py-3 px-4"><h6 class="mb-0">Basic Information</h6></div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Product Name *</label>
                        <input type="text" name="name" class="form-control"
                               value="<?= esc($isEdit ? $product['name'] : old('name')) ?>" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">SKU / Model No.</label>
                            <input type="text" name="sku" class="form-control"
                                   value="<?= esc($isEdit ? $product['sku'] : old('sku')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category</label>
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
                        <label class="form-label">Short Description</label>
                        <textarea name="short_description" class="form-control" rows="2"><?= esc($isEdit ? $product['short_description'] : old('short_description')) ?></textarea>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Full Description</label>
                        <textarea name="description" class="form-control" rows="6" id="description"><?= $isEdit ? $product['description'] : old('description') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Specifications -->
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between py-3 px-4">
                    <h6 class="mb-0">Specifications</h6>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="addSpec">
                        <i class="bi bi-plus"></i> Add Row
                    </button>
                </div>
                <div class="card-body p-4">
                    <div id="specRows">
                        <?php if (! empty($specs)): ?>
                            <?php foreach ($specs as $key => $val): ?>
                            <div class="spec-row d-flex gap-2 mb-2">
                                <input type="text" name="spec_key[]" class="form-control form-control-sm" placeholder="Key (e.g. Material)" value="<?= esc($key) ?>">
                                <input type="text" name="spec_value[]" class="form-control form-control-sm" placeholder="Value" value="<?= esc($val) ?>">
                                <button type="button" class="btn btn-sm btn-outline-danger remove-spec"><i class="bi bi-x"></i></button>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <p class="text-muted small mb-0 mt-2" id="specHint" <?= ! empty($specs) ? 'style="display:none"' : '' ?>>No specifications added yet.</p>
                </div>
            </div>

            <!-- SEO -->
            <div class="card mb-4">
                <div class="card-header py-3 px-4"><h6 class="mb-0">SEO & Meta</h6></div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control"
                               value="<?= esc($isEdit ? $product['meta_title'] : old('meta_title')) ?>">
                        <div class="form-text text-muted">Leave blank to use product name</div>
                    </div>
                    <div>
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="2"><?= esc($isEdit ? $product['meta_description'] : old('meta_description')) ?></textarea>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column -->
        <div class="col-lg-4">

            <!-- Status -->
            <div class="card mb-4">
                <div class="card-header py-3 px-4"><h6 class="mb-0">Status</h6></div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Visibility</label>
                        <select name="is_active" class="form-select">
                            <option value="1" <?= ($isEdit ? $product['is_active'] : 1) == 1 ? 'selected' : '' ?>>Active (Visible)</option>
                            <option value="0" <?= ($isEdit ? $product['is_active'] : 1) == 0 ? 'selected' : '' ?>>Draft (Hidden)</option>
                        </select>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured"
                               <?= ($isEdit ? $product['is_featured'] : 0) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="isFeatured" style="color:var(--sidebar-text);">Featured on Homepage</label>
                    </div>
                    <div class="mt-4 d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> <?= $isEdit ? 'Save Changes' : 'Create Product' ?>
                        </button>
                        <a href="/admin/products" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </div>

            <!-- Images -->
            <div class="card">
                <div class="card-header py-3 px-4">
                    <h6 class="mb-0">Product Images</h6>
                    <div class="text-muted" style="font-size:0.75rem;">JPG, PNG, WebP · Max 5MB each · Drag to reorder</div>
                </div>
                <div class="card-body p-3">
                    <?php if ($isEdit && ! empty($images)): ?>
                    <div id="imageGrid" class="row g-2 mb-3">
                        <?php foreach ($images as $img): ?>
                        <div class="col-6" data-id="<?= $img['id'] ?>">
                            <div class="position-relative" style="border: 2px solid <?= $img['is_primary'] ? '#6366f1' : 'var(--card-border)' ?>; border-radius: 8px; overflow: hidden; cursor: grab;">
                                <img src="/uploads/products/<?= esc($img['image_path']) ?>"
                                     style="width:100%; height:90px; object-fit:cover; display:block;">
                                <div class="position-absolute top-0 end-0 p-1 d-flex flex-column gap-1">
                                    <button type="button" class="btn btn-sm p-0" style="width:22px;height:22px;background:rgba(0,0,0,0.6);border-radius:4px;"
                                            onclick="setPrimary(<?= $img['id'] ?>)" title="Set as primary">
                                        <i class="bi bi-star-fill" style="font-size:10px;color:<?= $img['is_primary'] ? '#fbbf24' : '#94a3b8' ?>"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm p-0" style="width:22px;height:22px;background:rgba(239,68,68,0.8);border-radius:4px;"
                                            onclick="deleteImage(<?= $img['id'] ?>, this)" title="Delete">
                                        <i class="bi bi-x" style="font-size:12px;color:#fff;"></i>
                                    </button>
                                </div>
                                <?php if ($img['is_primary']): ?>
                                <div style="position:absolute;bottom:0;left:0;right:0;background:rgba(99,102,241,0.8);text-align:center;font-size:9px;color:#fff;padding:2px;">PRIMARY</div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php elseif ($isEdit): ?>
                    <p class="text-muted small mb-3">No images yet. Upload below.</p>
                    <?php endif; ?>

                    <label class="form-label small">Upload Images</label>
                    <input type="file" name="images[]" class="form-control form-control-sm" multiple accept="image/jpeg,image/png,image/webp">
                    <div class="form-text text-muted">You can select multiple files at once.</div>
                </div>
            </div>

        </div>
    </div>
</form>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
// Spec rows
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
        if (document.querySelectorAll('.spec-row').length === 0) {
            document.getElementById('specHint').style.display = '';
        }
    }
});

// Sortable image grid
const grid = document.getElementById('imageGrid');
if (grid) {
    const sortable = new Sortable(grid, {
        animation: 150,
        onEnd: function () {
            const order = [...grid.querySelectorAll('[data-id]')].map(el => el.dataset.id);
            fetch('/admin/products/images/reorder', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ order })
            });
        }
    });
}

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
</script>
<?= $this->endSection() ?>
