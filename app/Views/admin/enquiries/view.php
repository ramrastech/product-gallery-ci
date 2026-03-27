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

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="/admin/enquiries" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <span class="text-muted small">Enquiries / #<?= $enquiry['id'] ?></span>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header py-3 px-4"><h6 class="mb-0">Enquiry Details</h6></div>
            <div class="card-body p-4">
                <dl class="row mb-0" style="row-gap: 0.75rem;">
                    <dt class="col-4 text-muted small">Name</dt>
                    <dd class="col-8"><?= esc($enquiry['name']) ?></dd>
                    <dt class="col-4 text-muted small">Email</dt>
                    <dd class="col-8"><a href="mailto:<?= esc($enquiry['email']) ?>"><?= esc($enquiry['email']) ?></a></dd>
                    <dt class="col-4 text-muted small">Phone</dt>
                    <dd class="col-8"><?= esc($enquiry['phone'] ?: '—') ?></dd>
                    <dt class="col-4 text-muted small">Product</dt>
                    <dd class="col-8">
                        <?php if ($product): ?>
                            <a href="/products/<?= esc($product['slug']) ?>" target="_blank"><?= esc($product['name']) ?></a>
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </dd>
                    <dt class="col-4 text-muted small">Date</dt>
                    <dd class="col-8 text-muted small"><?= date('d M Y, H:i', strtotime($enquiry['created_at'])) ?></dd>
                    <dt class="col-4 text-muted small">IP</dt>
                    <dd class="col-8 text-muted small"><?= esc($enquiry['ip_address'] ?: '—') ?></dd>
                </dl>
            </div>
        </div>

        <?php if ($enquiry['message']): ?>
        <div class="card mt-4">
            <div class="card-header py-3 px-4"><h6 class="mb-0">Message</h6></div>
            <div class="card-body p-4">
                <p style="white-space: pre-line; color: var(--text-primary);"><?= esc($enquiry['message']) ?></p>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header py-3 px-4"><h6 class="mb-0">Update Status</h6></div>
            <div class="card-body p-4">
                <?php $badges = ['new' => 'danger', 'read' => 'warning', 'replied' => 'success']; ?>
                <div class="mb-3">
                    Current: <span class="badge bg-<?= $badges[$enquiry['status']] ?>"><?= ucfirst($enquiry['status']) ?></span>
                </div>
                <form method="post" action="/admin/enquiries/status/<?= $enquiry['id'] ?>">
                    <?= csrf_field() ?>
                    <select name="status" class="form-select mb-3">
                        <option value="new" <?= $enquiry['status'] === 'new' ? 'selected' : '' ?>>New</option>
                        <option value="read" <?= $enquiry['status'] === 'read' ? 'selected' : '' ?>>Read</option>
                        <option value="replied" <?= $enquiry['status'] === 'replied' ? 'selected' : '' ?>>Replied</option>
                    </select>
                    <button type="submit" class="btn btn-primary w-100">Update Status</button>
                </form>

                <?php if ($enquiry['email']): ?>
                <hr style="border-color: var(--card-border);">
                <a href="mailto:<?= esc($enquiry['email']) ?>?subject=Re: <?= esc($product ? $product['name'] : 'Your Enquiry') ?>"
                   class="btn btn-outline-secondary w-100">
                    <i class="bi bi-envelope me-2"></i>Reply via Email
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
