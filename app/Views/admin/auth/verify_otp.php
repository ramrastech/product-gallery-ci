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
    <title>Two-Factor Verification — Product Gallery</title>
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
        .auth-card .card-title { color: #f1f5f9; font-weight: 700; letter-spacing: -0.5px; }
        .brand-dot { color: #6366f1; }
        .btn-indigo { background: #6366f1; border: none; color: #fff; font-weight: 600; }
        .btn-indigo:hover { background: #4f46e5; color: #fff; }

        /* OTP digit boxes */
        .otp-inputs {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        .otp-digit {
            width: 48px; height: 56px;
            background: #0f172a;
            border: 1px solid #334155;
            border-radius: 10px;
            color: #f1f5f9;
            font-size: 1.4rem;
            font-weight: 700;
            text-align: center;
            caret-color: #6366f1;
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
        }
        .otp-digit:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 0.2rem rgba(99,102,241,.25);
        }
        .otp-digit.filled { border-color: #6366f1; }

        .email-hint {
            background: rgba(99,102,241,.08);
            border: 1px solid rgba(99,102,241,.2);
            border-radius: 8px;
            color: #94a3b8;
            font-size: 0.8rem;
        }
        .back-link { color: #64748b; font-size: 0.82rem; text-decoration: none; }
        .back-link:hover { color: #94a3b8; }
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
                            <i class="bi bi-phone"></i>
                        </div>
                        <h4 class="card-title mb-1">Product Gallery<span class="brand-dot">.</span></h4>
                        <p class="text-muted small mb-0">Two-Factor Verification</p>
                    </div>

                    <!-- Alerts -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger py-2 small d-flex align-items-center gap-2">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <?= esc(session()->getFlashdata('error')) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Email hint -->
                    <div class="email-hint p-3 mb-4 text-center">
                        <i class="bi bi-envelope me-1" style="color:#6366f1;"></i>
                        A 6-digit code has been sent to your registered email address. It expires in <strong style="color:#f1f5f9;">10 minutes</strong>.
                    </div>

                    <!-- OTP Form -->
                    <form action="/admin/verify-otp" method="post" id="otpForm">
                        <?= csrf_field() ?>
                        <!-- Hidden field that receives the combined OTP -->
                        <input type="hidden" name="otp" id="otpHidden">

                        <div class="mb-4">
                            <label class="form-label text-center d-block mb-3" style="color:#94a3b8;font-size:0.85rem;">Enter your one-time code</label>
                            <div class="otp-inputs">
                                <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="\d" autocomplete="one-time-code" data-index="0">
                                <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="\d" data-index="1">
                                <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="\d" data-index="2">
                                <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="\d" data-index="3">
                                <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="\d" data-index="4">
                                <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="\d" data-index="5">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-indigo w-100 py-2" id="submitBtn" disabled>
                            <i class="bi bi-shield-check me-1"></i> Verify Code
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="/admin/login" class="back-link">
                            <i class="bi bi-arrow-left me-1"></i>Back to login
                        </a>
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
(function () {
    const digits  = Array.from(document.querySelectorAll('.otp-digit'));
    const hidden  = document.getElementById('otpHidden');
    const submit  = document.getElementById('submitBtn');

    function syncHidden() {
        const val = digits.map(d => d.value).join('');
        hidden.value = val;
        submit.disabled = val.length < 6;
    }

    digits.forEach(function (input, i) {
        // Only allow single digit
        input.addEventListener('input', function (e) {
            // Handle paste of full code into first box
            const pasted = e.target.value.replace(/\D/g, '');
            if (pasted.length > 1) {
                pasted.split('').slice(0, 6).forEach(function (ch, j) {
                    if (digits[j]) { digits[j].value = ch; digits[j].classList.add('filled'); }
                });
                const next = digits[Math.min(pasted.length, 5)];
                if (next) next.focus();
                syncHidden();
                return;
            }
            input.value = pasted.slice(-1);
            input.classList.toggle('filled', input.value !== '');
            if (input.value && i < 5) digits[i + 1].focus();
            syncHidden();
        });

        input.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace' && !input.value && i > 0) {
                digits[i - 1].value = '';
                digits[i - 1].classList.remove('filled');
                digits[i - 1].focus();
                syncHidden();
            }
            if (e.key === 'ArrowLeft' && i > 0) digits[i - 1].focus();
            if (e.key === 'ArrowRight' && i < 5) digits[i + 1].focus();
        });

        // Allow only digits
        input.addEventListener('keypress', function (e) {
            if (!/\d/.test(e.key)) e.preventDefault();
        });
    });

    // Focus first box on load
    digits[0].focus();

    // Submit handler
    document.getElementById('otpForm').addEventListener('submit', function (e) {
        syncHidden();
        if (hidden.value.length < 6) { e.preventDefault(); return; }
        submit.disabled = true;
        submit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Verifying...';
    });
})();
</script>
</body>
</html>
