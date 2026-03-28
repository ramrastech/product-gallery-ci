<!--
 | @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 | @company    Ramras Technologies
 | @developer  RPS Rathore
 | @copyright  © 2026 Ramras Technologies. All rights reserved.
 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Product Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background: #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Inter', system-ui, sans-serif;
        }
        .auth-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 16px;
            animation: fadeUp 0.32s ease both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: none; }
        }
        .brand-icon {
            width: 52px; height: 52px;
            background: rgba(99,102,241,.15);
            border: 1px solid rgba(99,102,241,.3);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; color: #6366f1;
            margin: 0 auto 1rem;
        }
        .auth-card .card-title  { color: #f1f5f9; font-weight: 700; letter-spacing: -0.5px; }
        .auth-card .form-label  { color: #94a3b8; font-size: 0.85rem; }
        .auth-card .form-control,
        .auth-card .input-group-text {
            background: #0f172a;
            border-color: #334155;
            color: #f1f5f9;
        }
        .auth-card .form-control::placeholder { color: #475569; }
        .auth-card .form-control:focus {
            background: #0f172a;
            border-color: #6366f1;
            color: #f1f5f9;
            box-shadow: 0 0 0 0.2rem rgba(99,102,241,.25);
        }
        .auth-card .input-group-text {
            border-left: none;
            cursor: pointer;
            transition: color 0.15s;
        }
        .auth-card .input-group-text:hover { color: #6366f1; }
        .auth-card .form-control.has-eye { border-right: none; }
        .btn-indigo { background: #6366f1; border: none; color: #fff; font-weight: 600; }
        .btn-indigo:hover { background: #4f46e5; color: #fff; }
        .brand-dot { color: #6366f1; }
        .form-check-input:checked { background-color: #6366f1; border-color: #6366f1; }
        .form-check-label { color: #94a3b8; font-size: 0.82rem; }
        .forgot-link { color: #6366f1; font-size: 0.82rem; text-decoration: none; }
        .forgot-link:hover { color: #818cf8; text-decoration: underline; }
        .otp-notice {
            background: rgba(99,102,241,.08);
            border: 1px solid rgba(99,102,241,.2);
            border-radius: 8px;
            color: #94a3b8;
            font-size: 0.78rem;
        }
        .divider { border-color: #334155; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="auth-card card p-4 shadow-lg">
                <div class="card-body">

                    <!-- Brand -->
                    <div class="text-center mb-4">
                        <div class="brand-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <h4 class="card-title mb-1">Product Gallery<span class="brand-dot">.</span></h4>
                        <p class="text-muted small mb-0">Sign in to your admin account</p>
                    </div>

                    <!-- Alerts -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger py-2 small d-flex align-items-center gap-2">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <?= esc(session()->getFlashdata('error')) ?>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success py-2 small d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill"></i>
                            <?= esc(session()->getFlashdata('success')) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Login Form -->
                    <form action="/admin/login" method="post" id="loginForm">
                        <?= csrf_field() ?>

                        <!-- Username / Email -->
                        <div class="mb-3">
                            <label class="form-label">Username or Email</label>
                            <input type="text" name="username" class="form-control"
                                   value="<?= esc(old('username', $rememberedUsername ?? '')) ?>"
                                   required autofocus autocomplete="username"
                                   placeholder="admin or admin@example.com">
                        </div>

                        <!-- Password with show/hide -->
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="pwdField"
                                       class="form-control has-eye"
                                       required autocomplete="current-password"
                                       placeholder="Enter your password">
                                <span class="input-group-text" id="pwdToggle" title="Show / hide password">
                                    <i class="bi bi-eye" id="pwdIcon"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Remember me + Forgot password -->
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="remember_me"
                                       id="rememberMe" value="1"
                                       <?= !empty($rememberedUsername) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="rememberMe">Remember me</label>
                            </div>
                            <a href="/admin/forgot-password" class="forgot-link">
                                <i class="bi bi-key me-1"></i>Forgot password?
                            </a>
                        </div>

                        <button type="submit" class="btn btn-indigo w-100 py-2" id="submitBtn">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                        </button>
                    </form>

                    <!-- 2FA / OTP notice -->
                    <div class="otp-notice p-3 mt-4 text-center">
                        <i class="bi bi-shield-check me-1" style="color:#6366f1;"></i>
                        If your account has <strong style="color:#f1f5f9;">2FA enabled</strong>, a one-time code will be emailed to you after sign in.
                    </div>

                </div>
            </div>
            <p class="text-center mt-3" style="color:#475569;font-size:0.75rem;">
                &copy; <?= date('Y') ?> Ramras Technologies. All rights reserved.
            </p>
        </div>
    </div>
</div>

<script>
// Password show/hide
document.getElementById('pwdToggle').addEventListener('click', function () {
    const field = document.getElementById('pwdField');
    const icon  = document.getElementById('pwdIcon');
    if (field.type === 'password') {
        field.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        field.type = 'password';
        icon.className = 'bi bi-eye';
    }
});

// Submit spinner
document.getElementById('loginForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Signing in...';
});
</script>
</body>
</html>
