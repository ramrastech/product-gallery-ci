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
<?= $this->section('content') ?>

<?php $isEdit = ! is_null($category); ?>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="/admin/categories" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <span class="text-muted small">Categories /</span>
    <span class="small"><?= $isEdit ? esc($category['name']) : 'New Category' ?></span>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-4">
                <form action="<?= $isEdit ? '/admin/categories/update/' . $category['id'] : '/admin/categories/save' ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Category Name *</label>
                        <input type="text" name="name" class="form-control" value="<?= esc($isEdit ? $category['name'] : '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Parent Category</label>
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
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"><?= esc($isEdit ? $category['description'] : '') ?></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Status</label>
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

<?= $this->endSection() ?>
