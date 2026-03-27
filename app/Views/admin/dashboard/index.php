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

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(99,102,241,0.15); color:#6366f1;">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div>
                    <div class="stat-value"><?= $totalProducts ?></div>
                    <div class="stat-label">Active Products</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(16,185,129,0.15); color:#10b981;">
                    <i class="bi bi-tags"></i>
                </div>
                <div>
                    <div class="stat-value"><?= $totalCategories ?></div>
                    <div class="stat-label">Categories</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(245,158,11,0.15); color:#f59e0b;">
                    <i class="bi bi-envelope"></i>
                </div>
                <div>
                    <div class="stat-value"><?= $totalEnquiries ?></div>
                    <div class="stat-label">Total Enquiries</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(239,68,68,0.15); color:#ef4444;">
                    <i class="bi bi-bell"></i>
                </div>
                <div>
                    <div class="stat-value"><?= $newEnquiries ?></div>
                    <div class="stat-label">New Enquiries</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Recent Enquiries -->
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between py-3 px-4">
                <h6 class="mb-0 fw-600">Recent Enquiries</h6>
                <a href="/admin/enquiries" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentEnquiries)): ?>
                        <tr><td colspan="4" class="text-center text-muted py-4">No enquiries yet</td></tr>
                        <?php else: ?>
                        <?php foreach ($recentEnquiries as $e): ?>
                        <tr>
                            <td><?= esc($e['name']) ?></td>
                            <td class="text-muted small"><?= esc($e['email']) ?></td>
                            <td class="text-muted small"><?= date('d M Y', strtotime($e['created_at'])) ?></td>
                            <td>
                                <?php
                                $badges = ['new' => 'danger', 'read' => 'warning', 'replied' => 'success'];
                                $badge  = $badges[$e['status']] ?? 'secondary';
                                ?>
                                <span class="badge bg-<?= $badge ?>"><?= ucfirst($e['status']) ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top Products -->
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between py-3 px-4">
                <h6 class="mb-0">Top Viewed Products</h6>
                <a href="/admin/products" class="btn btn-sm btn-outline-secondary">Manage</a>
            </div>
            <ul class="list-group list-group-flush">
                <?php if (empty($topProducts)): ?>
                <li class="list-group-item text-center text-muted py-4" style="background:transparent; border-color: var(--card-border);">No products yet</li>
                <?php else: ?>
                <?php foreach ($topProducts as $p): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center" style="background:transparent; border-color:var(--card-border); color: var(--text-primary);">
                    <span class="small"><?= esc($p['name']) ?></span>
                    <span class="badge" style="background: rgba(99,102,241,0.2); color: #a5b4fc;">
                        <i class="bi bi-eye me-1"></i><?= number_format($p['view_count']) ?>
                    </span>
                </li>
                <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
