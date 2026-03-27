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

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="/admin/enquiries" class="btn btn-sm <?= ! $status ? 'btn-primary' : 'btn-outline-secondary' ?>">All</a>
    <a href="/admin/enquiries?status=new" class="btn btn-sm <?= $status === 'new' ? 'btn-primary' : 'btn-outline-secondary' ?>">New</a>
    <a href="/admin/enquiries?status=read" class="btn btn-sm <?= $status === 'read' ? 'btn-primary' : 'btn-outline-secondary' ?>">Read</a>
    <a href="/admin/enquiries?status=replied" class="btn btn-sm <?= $status === 'replied' ? 'btn-primary' : 'btn-outline-secondary' ?>">Replied</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Product</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th width="80">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($enquiries)): ?>
                <tr><td colspan="8" class="text-center text-muted py-5">No enquiries found.</td></tr>
                <?php else: ?>
                <?php foreach ($enquiries as $e): ?>
                <?php $badges = ['new' => 'danger', 'read' => 'warning', 'replied' => 'success']; ?>
                <tr <?= $e['status'] === 'new' ? 'style="font-weight:600;"' : '' ?>>
                    <td class="text-muted small"><?= $e['id'] ?></td>
                    <td><?= esc($e['name']) ?></td>
                    <td class="small"><?= esc($e['email']) ?></td>
                    <td class="small text-muted"><?= esc($e['phone'] ?: '—') ?></td>
                    <td class="small text-muted"><?= esc($e['product_name']) ?></td>
                    <td class="small text-muted"><?= date('d M Y, H:i', strtotime($e['created_at'])) ?></td>
                    <td><span class="badge bg-<?= $badges[$e['status']] ?? 'secondary' ?>"><?= ucfirst($e['status']) ?></span></td>
                    <td>
                        <a href="/admin/enquiries/view/<?= $e['id'] ?>" class="btn btn-sm btn-outline-secondary py-0 px-2">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if (isset($pager) && $pager): ?>
    <div class="card-footer d-flex justify-content-end" style="background:transparent; border-color:var(--card-border);">
        <?= $pager->links('default', 'bootstrap_5') ?>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
