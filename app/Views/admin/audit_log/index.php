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

<!-- Filter Bar + Clear Log (two sibling forms, not nested) -->
<div class="card mb-4">
    <div class="card-body py-3 px-4">
        <div class="d-flex flex-wrap gap-2 align-items-end">

            <!-- GET filter form -->
            <form method="get" action="/admin/audit-log" class="d-flex flex-wrap gap-2 align-items-end flex-grow-1">
                <div>
                    <label class="form-label small mb-1">Entity</label>
                    <select name="entity" class="form-select form-select-sm" style="min-width:160px;">
                        <option value="">All Entities</option>
                        <?php foreach ($entities as $e): ?>
                        <option value="<?= esc($e) ?>" <?= $filterEntity === $e ? 'selected' : '' ?>>
                            <?= esc(ucwords(str_replace('_', ' ', $e))) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="form-label small mb-1">Admin</label>
                    <input type="text" name="admin" class="form-control form-control-sm"
                           placeholder="Username..." value="<?= esc($filterAdmin ?? '') ?>"
                           style="min-width:160px;">
                </div>
                <button type="submit" class="btn btn-primary btn-sm px-3">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
                <?php if ($filterEntity || $filterAdmin): ?>
                <a href="/admin/audit-log" class="btn btn-outline-secondary btn-sm px-3">
                    <i class="bi bi-x me-1"></i>Clear
                </a>
                <?php endif; ?>
            </form>

            <!-- POST clear-log form (sibling, not nested) -->
            <form method="post" action="/admin/audit-log/clear"
                  onsubmit="return confirm('Clear all log entries? This cannot be undone.');">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-sm btn-outline-danger" data-no-spinner="1">
                    <i class="bi bi-trash me-1"></i>Clear Log
                </button>
            </form>

        </div>
    </div>
</div>

<!-- Log Table -->
<div class="card">
    <div class="card-header py-3 px-4 d-flex align-items-center justify-content-between">
        <h6 class="mb-0">Activity Log</h6>
        <span class="badge bg-secondary"><?= count($logs) ?> entries shown</span>
    </div>

    <?php if (empty($logs)): ?>
    <div class="card-body text-center py-5 text-muted">
        <i class="bi bi-journal-x" style="font-size:2.5rem; opacity:.3;"></i>
        <p class="mt-3 mb-0">No log entries found.</p>
    </div>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width:155px;">Date / Time</th>
                    <th style="width:120px;">Admin</th>
                    <th style="width:170px;">Action</th>
                    <th style="width:130px;">Entity</th>
                    <th>Detail</th>
                    <th style="width:125px;">IP Address</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log):
                    $action = $log['action'] ?? '';
                    if (str_contains($action, 'delete') || str_contains($action, 'clear') || str_contains($action, 'failed')) {
                        $badge = 'danger';
                    } elseif (str_contains($action, 'create') || str_contains($action, 'add') || str_contains($action, 'restore')) {
                        $badge = 'success';
                    } elseif (str_contains($action, 'update') || str_contains($action, 'edit') || str_contains($action, 'save') || str_contains($action, 'reset')) {
                        $badge = 'primary';
                    } elseif (str_contains($action, 'login') || str_contains($action, 'logout')) {
                        $badge = 'warning';
                    } else {
                        $badge = 'secondary';
                    }
                ?>
                <tr>
                    <td class="small text-muted">
                        <?= esc(date('d M Y, H:i', strtotime($log['created_at']))) ?>
                    </td>
                    <td class="small">
                        <i class="bi bi-person me-1 text-muted"></i><?= esc($log['admin_username'] ?? '—') ?>
                    </td>
                    <td>
                        <span class="badge bg-<?= $badge ?> text-uppercase" style="font-size:.65rem;letter-spacing:.4px;">
                            <?= esc(str_replace('_', ' ', $action)) ?>
                        </span>
                    </td>
                    <td class="small">
                        <?php if (!empty($log['entity'])): ?>
                            <?= esc(ucwords(str_replace('_', ' ', $log['entity']))) ?>
                            <?php if (!empty($log['entity_id'])): ?>
                            <span class="text-muted">#<?= (int) $log['entity_id'] ?></span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="small text-muted"><?= esc($log['detail'] ?? '—') ?></td>
                    <td class="small text-muted"><?= esc($log['ip_address'] ?? '—') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($pager)): ?>
    <div class="card-footer py-3 d-flex justify-content-center">
        <?= $pager->links() ?>
    </div>
    <?php endif; ?>

    <?php endif; ?>
</div>

<?= $this->endSection() ?>
