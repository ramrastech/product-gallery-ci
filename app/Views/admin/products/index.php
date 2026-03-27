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

<div class="d-flex align-items-center justify-content-between mb-4">
    <form class="d-flex gap-2" method="get" action="/admin/products">
        <input type="text" name="q" class="form-control form-control-sm" placeholder="Search products..." value="<?= esc($search) ?>" style="width:220px;">
        <select name="category" class="form-select form-select-sm" style="width:180px;">
            <option value="">All Categories</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= $categoryId == $cat['id'] ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn-sm btn-outline-secondary" type="submit">Filter</button>
        <?php if ($search || $categoryId): ?>
            <a href="/admin/products" class="btn btn-sm btn-outline-danger">Clear</a>
        <?php endif; ?>
    </form>
    <a href="/admin/products/new" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> New Product
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th width="60">Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>SKU</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th width="100">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr><td colspan="8" class="text-center text-muted py-5">No products found. <a href="/admin/products/new">Create one</a></td></tr>
                <?php else: ?>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td>
                        <?php if ($p['primary_image']): ?>
                            <img src="/uploads/products/<?= esc($p['primary_image']) ?>" width="48" height="48" style="object-fit:cover; border-radius:6px;">
                        <?php else: ?>
                            <div style="width:48px;height:48px;background:#334155;border-radius:6px;display:flex;align-items:center;justify-content:center;"><i class="bi bi-image text-muted"></i></div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="/admin/products/edit/<?= $p['id'] ?>" class="text-decoration-none" style="color: var(--text-primary);">
                            <?= esc($p['name']) ?>
                        </a>
                        <div class="text-muted small">/products/<?= esc($p['slug']) ?></div>
                    </td>
                    <td class="small text-muted">
                        <?php
                        $cat = array_filter($categories, fn($c) => $c['id'] == $p['category_id']);
                        echo $cat ? esc(reset($cat)['name']) : '—';
                        ?>
                    </td>
                    <td class="small text-muted"><?= esc($p['sku'] ?: '—') ?></td>
                    <td>
                        <?php if ($p['is_featured']): ?>
                            <span class="badge" style="background:rgba(245,158,11,0.2);color:#fbbf24;">Featured</span>
                        <?php else: ?>
                            <span class="text-muted small">—</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($p['is_active']): ?>
                            <span class="badge bg-success">Active</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Draft</span>
                        <?php endif; ?>
                    </td>
                    <td class="small text-muted"><?= number_format($p['view_count']) ?></td>
                    <td>
                        <a href="/admin/products/edit/<?= $p['id'] ?>" class="btn btn-sm btn-outline-secondary py-0 px-2">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="post" action="/admin/products/delete/<?= $p['id'] ?>" class="d-inline"
                              onsubmit="return confirm('Delete this product?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if (isset($pager) && $pager): ?>
    <div class="card-footer d-flex justify-content-end" style="background:transparent; border-color: var(--card-border);">
        <?= $pager->links('default', 'bootstrap_5') ?>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
