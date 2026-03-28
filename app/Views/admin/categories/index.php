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

<div class="d-flex justify-content-end mb-4">
    <a href="/admin/categories/new" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> New Category
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th width="52"></th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Products</th>
                    <th>Status</th>
                    <th width="100">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($categories)): ?>
                <tr><td colspan="6" class="text-center text-muted py-5">No categories yet. <a href="/admin/categories/new">Create one</a></td></tr>
                <?php else: ?>
                <?php foreach ($categories as $cat): ?>
                <tr>
                    <td class="py-1">
                        <?php if (! empty($cat['image_path'])): ?>
                        <?php $catThumb = ($cat['image_path'][0] === '/') ? $cat['image_path'] : '/uploads/categories/' . $cat['image_path']; ?>
                        <img src="<?= esc($catThumb) ?>" alt=""
                             style="width:44px;height:36px;object-fit:cover;border-radius:4px;border:1px solid #dee2e6;">
                        <?php else: ?>
                        <div style="width:44px;height:36px;background:#f1f3f5;border-radius:4px;border:1px solid #dee2e6;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-image text-muted" style="font-size:14px;"></i>
                        </div>
                        <?php endif; ?>
                    </td>
                    <td><?= esc($cat['name']) ?></td>
                    <td class="text-muted small"><?= esc($cat['slug']) ?></td>
                    <td class="text-muted small"><?= $cat['product_count'] ?></td>
                    <td>
                        <?php if ($cat['is_active']): ?>
                            <span class="badge bg-success">Active</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td style="white-space:nowrap;">
                        <div class="d-flex align-items-center gap-1 flex-nowrap">
                        <?php if (! empty($cat['slug'])): ?>
                        <a href="/category/<?= esc($cat['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-primary py-0 px-2" title="View on site">
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                        <?php endif; ?>
                        <a href="/admin/categories/edit/<?= $cat['id'] ?>" class="btn btn-sm btn-outline-secondary py-0 px-2" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="post" action="/admin/categories/delete/<?= $cat['id'] ?>" style="margin:0;"
                              onsubmit="return confirm('Delete this category?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
