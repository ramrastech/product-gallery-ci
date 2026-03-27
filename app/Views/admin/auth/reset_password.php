<!--
 | @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 | @company    Ramras Technologies
 | @developer  RPS Rathore
 | @email      info@ramrastech.com
 | @mobile     +91-7317377477
 | @website    https://ramrastech.com
 | @copyright  © 2026 Ramras Technologies. All rights reserved.
 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — Product Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; min-height: 100vh; display: flex; align-items: center; }
        .auth-card { background: #1e293b; border: 1px solid #334155; border-radius: 16px; }
        .auth-card .card-title { color: #f1f5f9; font-weight: 700; letter-spacing: -0.5px; }
        .auth-card .form-label { color: #94a3b8; font-size: 0.85rem; }
        .auth-card .form-control { background: #0f172a; border-color: #334155; color: #f1f5f9; }
        .auth-card .form-control:focus { background: #0f172a; border-color: #6366f1; color: #f1f5f9; box-shadow: 0 0 0 0.2rem rgba(99,102,241,.25); }
        .btn-indigo { background: #6366f1; border: none; color: #fff; font-weight: 600; }
        .btn-indigo:hover { background: #4f46e5; color: #fff; }
        .brand-dot { color: #6366f1; }
        .req { font-size: 0.78rem; color: #64748b; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="auth-card card p-4 shadow-lg">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h4 class="card-title mb-1">Product Gallery<span class="brand-dot">.</span></h4>
                        <p class="text-muted small">Set a new password</p>
                    </div>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger py-2 small"><?= esc(session()->getFlashdata('error')) ?></div>
                    <?php endif; ?>

                    <form action="/admin/reset-password" method="post" id="resetForm">
                        <?= csrf_field() ?>
                        <input type="hidden" name="token" value="<?= esc($token) ?>">
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control" required autofocus>
                            <div class="req mt-1">Min 8 chars · 1 uppercase · 1 number · 1 special character</div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-indigo w-100 py-2" id="submitBtn">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('resetForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Resetting...';
});
</script>
</body>
</html>
