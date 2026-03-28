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

<div class="d-flex align-items-center justify-content-between mb-4">
    <a href="/admin/home-content" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
    <a href="/admin/home-content/item/new/<?= esc($section) ?>" class="btn btn-sm btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add Item
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th width="40">#</th>
                    <th>Title</th>
                    <th>Subtitle</th>
                    <th>Icon</th>
                    <th>Status</th>
                    <th width="140">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($items)): ?>
                <tr><td colspan="6" class="text-center text-muted py-5">
                    No items yet. <a href="/admin/home-content/item/new/<?= esc($section) ?>">Add one</a>.
                </td></tr>
                <?php else: ?>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td class="text-muted small"><?= (int)$item['sort_order'] ?></td>
                    <td><?= esc($item['title']) ?: '<span class="text-muted">—</span>' ?></td>
                    <td class="text-muted small"><?= esc($item['subtitle']) ?: '—' ?></td>
                    <td>
                        <?php if ($item['icon']): ?>
                            <i class="bi <?= esc($item['icon']) ?>"></i>
                            <span class="text-muted small ms-1"><?= esc($item['icon']) ?></span>
                        <?php else: ?>
                            <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($item['is_active']): ?>
                            <span class="badge bg-success">Active</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Hidden</span>
                        <?php endif; ?>
                    </td>
                    <td style="white-space:nowrap;">
                        <div class="d-flex align-items-center gap-1 flex-nowrap">
                        <form method="post" action="/admin/home-content/item/reorder/<?= $item['id'] ?>">
                            <?= csrf_field() ?>
                            <input type="hidden" name="direction" value="up">
                            <button type="submit" class="btn btn-sm btn-outline-secondary py-0 px-1" title="Move up">
                                <i class="bi bi-chevron-up"></i>
                            </button>
                        </form>
                        <form method="post" action="/admin/home-content/item/reorder/<?= $item['id'] ?>">
                            <?= csrf_field() ?>
                            <input type="hidden" name="direction" value="down">
                            <button type="submit" class="btn btn-sm btn-outline-secondary py-0 px-1" title="Move down">
                                <i class="bi bi-chevron-down"></i>
                            </button>
                        </form>
                        <a href="/admin/home-content/item/edit/<?= $item['id'] ?>" class="btn btn-sm btn-outline-secondary py-0 px-2">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="post" action="/admin/home-content/item/delete/<?= $item['id'] ?>"
                              onsubmit="return confirm('Delete this item?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2">
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
