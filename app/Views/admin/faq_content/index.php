<?php
/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */
?>
<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <!-- Left: FAQ list -->
    <div class="col-lg-8">
        <?php if (empty($grouped)): ?>
        <div class="card">
            <div class="card-body text-center text-muted py-5">
                No FAQ categories yet. Add one using the form on the right.
            </div>
        </div>
        <?php else: ?>
        <?php foreach ($grouped as $group): ?>
        <?php $cat = $group['category']; ?>
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center justify-content-between py-2 px-3">
                <span class="fw-semibold"><?= esc($cat['name']) ?></span>
                <div class="d-flex gap-2 align-items-center">
                    <a href="/admin/faq/item/new/<?= $cat['id'] ?>" class="btn btn-sm btn-outline-secondary py-0 px-2">
                        <i class="bi bi-plus"></i> Add FAQ
                    </a>
                    <form method="post" action="/admin/faq/category/delete/<?= $cat['id'] ?>" class="d-inline"
                          onsubmit="return confirm('Delete this category? All items must be removed first.');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            <?php if (empty($group['items'])): ?>
            <div class="card-body py-3 text-muted small">No items in this category.</div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="40">#</th>
                            <th>Question</th>
                            <th>Status</th>
                            <th style="width:160px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($group['items'] as $item): ?>
                        <tr>
                            <td class="text-muted small"><?= (int)$item['sort_order'] ?></td>
                            <td class="small"><?= esc($item['question']) ?></td>
                            <td>
                                <?php if ($item['is_active']): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Hidden</span>
                                <?php endif; ?>
                            </td>
                            <td style="white-space:nowrap;">
                                <form method="post" action="/admin/faq/item/reorder/<?= $item['id'] ?>" class="d-inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="direction" value="up">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary py-0 px-1" title="Move up">
                                        <i class="bi bi-chevron-up"></i>
                                    </button>
                                </form>
                                <form method="post" action="/admin/faq/item/reorder/<?= $item['id'] ?>" class="d-inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="direction" value="down">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary py-0 px-1" title="Move down">
                                        <i class="bi bi-chevron-down"></i>
                                    </button>
                                </form>
                                <a href="/admin/faq/item/edit/<?= $item['id'] ?>" class="btn btn-sm btn-outline-secondary py-0 px-2 ms-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="post" action="/admin/faq/item/delete/<?= $item['id'] ?>" class="d-inline"
                                      onsubmit="return confirm('Delete this FAQ item?');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Right: Add / Edit Category -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header py-2"><strong class="small">Add Category</strong></div>
            <div class="card-body">
                <form method="post" action="/admin/faq/category/save">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="0">
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="name" class="form-control form-control-sm" placeholder="e.g. General" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-plus me-1"></i> Add Category
                    </button>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header py-2"><strong class="small">Quick Add FAQ</strong></div>
            <div class="card-body">
                <a href="/admin/faq/item/new" class="btn btn-outline-secondary btn-sm w-100">
                    <i class="bi bi-plus me-1"></i> New FAQ Item
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
