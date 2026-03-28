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
    <p class="text-muted mb-0 small"><?= count($users) ?> user(s) total</p>
    <a href="/admin/users/new" class="btn btn-primary btn-sm">
        <i class="bi bi-person-plus me-1"></i> New User
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th style="width:120px;">Role</th>
                    <th style="width:80px;" class="text-center">2FA</th>
                    <th style="width:160px;">Last Login</th>
                    <th style="width:100px;">Status</th>
                    <th style="width:120px;" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u):
                    $isSelf    = $u['id'] === $selfId;
                    $isDeleted = ! empty($u['deleted_at']);
                    $roleColors = ['super_admin' => 'danger', 'manager' => 'primary', 'viewer' => 'secondary'];
                    $roleColor  = $roleColors[$u['role']] ?? 'secondary';
                ?>
                <tr class="<?= $isDeleted ? 'opacity-50' : '' ?>">
                    <td class="text-muted small"><?= (int) $u['id'] ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                 style="width:32px;height:32px;background:var(--accent);opacity:<?= $isDeleted ? '.4' : '.85' ?>;font-size:.8rem;font-weight:700;color:#fff;">
                                <?= strtoupper(substr($u['username'], 0, 1)) ?>
                            </div>
                            <div>
                                <div class="fw-medium" style="font-size:.875rem;"><?= esc($u['username']) ?></div>
                                <?php if ($isSelf): ?>
                                <span class="badge bg-success" style="font-size:.6rem;">You</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td class="small text-muted"><?= esc($u['email']) ?></td>
                    <td>
                        <span class="badge bg-<?= $roleColor ?>"><?= esc(ucwords(str_replace('_', ' ', $u['role']))) ?></span>
                    </td>
                    <td class="text-center">
                        <?php if ($u['two_fa_enabled']): ?>
                        <i class="bi bi-shield-check text-success" title="2FA enabled"></i>
                        <?php else: ?>
                        <i class="bi bi-shield-x text-muted" title="2FA disabled"></i>
                        <?php endif; ?>
                    </td>
                    <td class="small text-muted">
                        <?= $u['last_login'] ? esc(date('d M Y, H:i', strtotime($u['last_login']))) : '—' ?>
                    </td>
                    <td>
                        <?php if ($isDeleted): ?>
                        <span class="badge bg-secondary">Deleted</span>
                        <?php else: ?>
                        <span class="badge bg-success">Active</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end">
                        <?php if ($isDeleted): ?>
                        <form method="post" action="/admin/users/restore/<?= (int) $u['id'] ?>" class="d-inline">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-outline-success" title="Restore">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </button>
                        </form>
                        <?php else: ?>
                        <a href="/admin/users/edit/<?= (int) $u['id'] ?>" class="btn btn-sm btn-outline-secondary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <?php if (! $isSelf): ?>
                        <form method="post" action="/admin/users/delete/<?= (int) $u['id'] ?>" class="d-inline"
                              onsubmit="return confirm('Delete user <?= esc($u['username']) ?>? They can be restored later.')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
