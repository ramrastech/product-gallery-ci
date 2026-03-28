<?php
/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */
$isEdit = $item !== null;
?>
<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="/admin/faq" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to FAQ
    </a>
</div>

<div class="card" style="max-width:720px;">
    <div class="card-body">
        <form method="post" action="/admin/faq/item/save">
            <?= csrf_field() ?>
            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?= $item['id'] ?>">
            <?php endif; ?>

            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select form-select-sm" required>
                        <option value="">Select category…</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= ($categoryId == $cat['id']) ? 'selected' : '' ?>>
                            <?= esc($cat['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-select form-select-sm">
                        <option value="1" <?= ($item['is_active'] ?? 1) == 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= ($item['is_active'] ?? 1) == 0 ? 'selected' : '' ?>>Hidden</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Question</label>
                    <input type="text" name="question" class="form-control form-control-sm"
                           value="<?= esc($item['question'] ?? '') ?>" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Answer</label>
                    <textarea name="answer" class="form-control form-control-sm" rows="6" required><?= esc($item['answer'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-check-lg me-1"></i> <?= $isEdit ? 'Update FAQ' : 'Save FAQ' ?>
                </button>
                <a href="/admin/faq" class="btn btn-outline-secondary btn-sm">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
