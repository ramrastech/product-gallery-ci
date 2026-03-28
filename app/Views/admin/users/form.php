<?php
/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */
$isEdit  = $user !== null;
$action  = $isEdit ? '/admin/users/update/' . $user['id'] : '/admin/users/save';
$selfId  = $selfId ?? 0;
?>
<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="/admin/users" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <span class="text-muted small">Users /</span>
    <span class="small"><?= $isEdit ? esc($user['username']) : 'New User' ?></span>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <form action="<?= $action ?>" method="post" autocomplete="off">
            <?= csrf_field() ?>

            <!-- Account Info -->
            <div class="card mb-4">
                <div class="card-header py-3 px-4">
                    <h6 class="mb-0"><i class="bi bi-person me-2"></i>Account Information</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control"
                               value="<?= esc(old('username', $user['username'] ?? '')) ?>"
                               required minlength="3" placeholder="e.g. john_doe">
                        <div class="form-text text-muted">Min 3 characters. Used to log in.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control"
                               value="<?= esc(old('email', $user['email'] ?? '')) ?>"
                               required placeholder="admin@example.com">
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Role <span class="text-danger">*</span></label>
                        <select name="role" class="form-select"
                            <?= ($isEdit && $user['id'] === $selfId) ? 'disabled title="Cannot change your own role"' : '' ?>>
                            <?php foreach ($roles as $r): ?>
                            <option value="<?= esc($r) ?>"
                                <?= (old('role', $user['role'] ?? 'viewer') === $r) ? 'selected' : '' ?>>
                                <?= esc(ucwords(str_replace('_', ' ', $r))) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($isEdit && $user['id'] === $selfId): ?>
                        <input type="hidden" name="role" value="<?= esc($user['role']) ?>">
                        <div class="form-text text-muted">You cannot change your own role.</div>
                        <?php else: ?>
                        <div class="form-text text-muted">
                            <strong>Super Admin</strong> — full access &nbsp;·&nbsp;
                            <strong>Manager</strong> — manage content &amp; products &nbsp;·&nbsp;
                            <strong>Viewer</strong> — read-only
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Password -->
            <div class="card mb-4">
                <div class="card-header py-3 px-4">
                    <h6 class="mb-0">
                        <i class="bi bi-lock me-2"></i>
                        <?= $isEdit ? 'Reset Password <span class="text-muted fw-normal small">(leave blank to keep current)</span>' : 'Set Password' ?>
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label"><?= $isEdit ? 'New Password' : 'Password' ?> <?= $isEdit ? '' : '<span class="text-danger">*</span>' ?></label>
                        <div class="input-group">
                            <input type="password" name="<?= $isEdit ? 'new_password' : 'password' ?>"
                                   id="pwd1" class="form-control"
                                   <?= $isEdit ? '' : 'required minlength="8"' ?>
                                   placeholder="<?= $isEdit ? 'Leave blank to keep current' : 'Min 8 characters' ?>"
                                   autocomplete="new-password">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('pwd1',this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Confirm Password <?= $isEdit ? '' : '<span class="text-danger">*</span>' ?></label>
                        <div class="input-group">
                            <input type="password" name="confirm_password" id="pwd2" class="form-control"
                                   <?= $isEdit ? '' : 'required' ?>
                                   placeholder="Repeat password" autocomplete="new-password">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('pwd2',this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <?php if (! $isEdit): ?>
                        <div class="form-text text-muted mt-1">Min 8 chars · one uppercase · one number · one special character</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i><?= $isEdit ? 'Update User' : 'Create User' ?>
                </button>
                <a href="/admin/users" class="btn btn-outline-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>

    <?php if ($isEdit): ?>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header py-3 px-4">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>User Details</h6>
            </div>
            <div class="card-body p-4">
                <dl class="row mb-0" style="font-size:.875rem;">
                    <dt class="col-5 text-muted fw-normal">User ID</dt>
                    <dd class="col-7">#<?= (int) $user['id'] ?></dd>
                    <dt class="col-5 text-muted fw-normal mt-2">2FA</dt>
                    <dd class="col-7 mt-2">
                        <?php if ($user['two_fa_enabled']): ?>
                        <span class="badge bg-success"><i class="bi bi-shield-check me-1"></i>Enabled</span>
                        <?php else: ?>
                        <span class="badge bg-secondary"><i class="bi bi-shield-x me-1"></i>Disabled</span>
                        <?php endif; ?>
                    </dd>
                    <dt class="col-5 text-muted fw-normal mt-2">Last Login</dt>
                    <dd class="col-7 mt-2">
                        <?= $user['last_login'] ? esc(date('d M Y, H:i', strtotime($user['last_login']))) : '<span class="text-muted">Never</span>' ?>
                    </dd>
                    <dt class="col-5 text-muted fw-normal mt-2">Created</dt>
                    <dd class="col-7 mt-2">
                        <?= $user['created_at'] ? esc(date('d M Y', strtotime($user['created_at']))) : '—' ?>
                    </dd>
                    <dt class="col-5 text-muted fw-normal mt-2">Status</dt>
                    <dd class="col-7 mt-2">
                        <?php if (! empty($user['deleted_at'])): ?>
                        <span class="badge bg-secondary">Deleted</span>
                        <?php else: ?>
                        <span class="badge bg-success">Active</span>
                        <?php endif; ?>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= $this->section('scripts') ?>
<script>
function togglePwd(id, btn) {
    const inp = document.getElementById(id);
    const showing = inp.type === 'text';
    inp.type = showing ? 'password' : 'text';
    btn.innerHTML = showing ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
}
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
