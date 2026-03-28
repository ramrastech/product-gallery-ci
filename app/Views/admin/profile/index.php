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

    <!-- ── Left: Account Info ── -->
    <div class="col-lg-7">

        <!-- Profile Info Card -->
        <div class="card mb-4">
            <div class="card-header py-3 px-4">
                <h6 class="mb-0"><i class="bi bi-person-circle me-2"></i>Profile Information</h6>
            </div>
            <div class="card-body p-4">
                <form action="/admin/profile/save-info" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control"
                               value="<?= esc(old('username', $admin['username'])) ?>" required minlength="3">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control"
                               value="<?= esc(old('email', $admin['email'])) ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Save Changes
                    </button>
                </form>
            </div>
        </div>

        <!-- Change Password Card -->
        <div class="card mb-4" id="password">
            <div class="card-header py-3 px-4">
                <h6 class="mb-0"><i class="bi bi-lock me-2"></i>Change Password</h6>
            </div>
            <div class="card-body p-4">
                <form action="/admin/profile/change-password" method="post" autocomplete="off">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <div class="input-group">
                            <input type="password" name="current_password" id="curPwd" class="form-control" required autocomplete="current-password">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('curPwd',this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <div class="input-group">
                            <input type="password" name="new_password" id="newPwd" class="form-control" required minlength="8" autocomplete="new-password">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('newPwd',this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="form-text text-muted mt-1">Min 8 chars · one uppercase · one number · one special character</div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" name="confirm_password" id="cfmPwd" class="form-control" required autocomplete="new-password">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('cfmPwd',this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-shield-lock me-1"></i> Update Password
                    </button>
                </form>
            </div>
        </div>

    </div>

    <!-- ── Right: Account Details + 2FA ── -->
    <div class="col-lg-5">

        <!-- Account Details -->
        <div class="card mb-4">
            <div class="card-header py-3 px-4">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Account Details</h6>
            </div>
            <div class="card-body p-4">
                <dl class="row mb-0" style="font-size:.875rem;">
                    <dt class="col-5 text-muted fw-normal">Role</dt>
                    <dd class="col-7">
                        <?php
                        $roleColors = ['super_admin' => 'danger', 'manager' => 'primary', 'viewer' => 'secondary'];
                        $roleColor  = $roleColors[$admin['role']] ?? 'secondary';
                        ?>
                        <span class="badge bg-<?= $roleColor ?>"><?= esc(ucwords(str_replace('_', ' ', $admin['role']))) ?></span>
                    </dd>
                    <dt class="col-5 text-muted fw-normal mt-2">Last Login</dt>
                    <dd class="col-7 mt-2">
                        <?= $admin['last_login'] ? esc(date('d M Y, H:i', strtotime($admin['last_login']))) : '<span class="text-muted">—</span>' ?>
                    </dd>
                    <dt class="col-5 text-muted fw-normal mt-2">Account Created</dt>
                    <dd class="col-7 mt-2">
                        <?= $admin['created_at'] ? esc(date('d M Y', strtotime($admin['created_at']))) : '<span class="text-muted">—</span>' ?>
                    </dd>
                </dl>
            </div>
        </div>

        <!-- Two-Factor Authentication -->
        <div class="card">
            <div class="card-header py-3 px-4">
                <h6 class="mb-0"><i class="bi bi-phone me-2"></i>Two-Factor Authentication</h6>
            </div>
            <div class="card-body p-4">
                <?php $twoFa = (int) ($admin['two_fa_enabled'] ?? 0); ?>
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="flex-shrink-0 mt-1">
                        <?php if ($twoFa): ?>
                        <span class="badge bg-success px-2 py-1"><i class="bi bi-shield-check me-1"></i>Enabled</span>
                        <?php else: ?>
                        <span class="badge bg-secondary px-2 py-1"><i class="bi bi-shield-x me-1"></i>Disabled</span>
                        <?php endif; ?>
                    </div>
                    <p class="mb-0 small text-muted">
                        <?php if ($twoFa): ?>
                        A one-time code is sent to your email on each login. Disable only if you no longer need this security layer.
                        <?php else: ?>
                        Enable to require an email OTP on every login. Recommended for super_admin accounts.
                        <?php endif; ?>
                    </p>
                </div>
                <form action="/admin/profile/toggle-2fa" method="post">
                    <?= csrf_field() ?>
                    <?php if ($twoFa): ?>
                    <button type="submit" class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Disable two-factor authentication? Your account will be less secure.')">
                        <i class="bi bi-shield-x me-1"></i>Disable 2FA
                    </button>
                    <?php else: ?>
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="bi bi-shield-check me-1"></i>Enable 2FA
                    </button>
                    <?php endif; ?>
                </form>
            </div>
        </div>

    </div>
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
