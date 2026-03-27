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
    <title>Page Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --pg-primary: #8B5A2B; }
        body { background: #faf9f7; font-family: 'Segoe UI', system-ui, sans-serif; margin: 0; }
        .pg-404-wrap { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px 20px; }
        .pg-404-card { text-align: center; max-width: 580px; }
        .pg-404-num { font-size: clamp(5rem, 18vw, 9rem); font-weight: 900; color: var(--pg-primary); line-height: 1; letter-spacing: -4px; }
        .pg-404-icon { font-size: 3.5rem; color: rgba(139,90,43,0.20); display: block; margin-bottom: 4px; }
        .pg-404-title { font-size: 1.6rem; font-weight: 800; color: #1a1a1a; margin: 16px 0 12px; }
        .pg-404-text { font-size: 0.95rem; color: #666; margin-bottom: 32px; line-height: 1.7; }
        .pg-btn-primary { background: var(--pg-primary); border: 2px solid var(--pg-primary); color: #fff; font-weight: 700; border-radius: 10px; padding: 12px 28px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .pg-btn-primary:hover { background: #7a4e24; border-color: #7a4e24; color: #fff; }
        .pg-btn-outline { background: transparent; border: 2px solid #dee2e6; color: #555; font-weight: 700; border-radius: 10px; padding: 12px 28px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .pg-btn-outline:hover { border-color: #aaa; color: #333; }
        .pg-404-links { display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; }
        .pg-404-secondary { display: flex; flex-wrap: wrap; gap: 16px; justify-content: center; margin-top: 20px; }
        .pg-404-link { color: var(--pg-primary); font-size: 0.88rem; font-weight: 600; text-decoration: none; }
        .pg-404-link:hover { text-decoration: underline; }
        .pg-404-sep { color: #ccc; }
    </style>
</head>
<body>
<div class="pg-404-wrap">
    <div class="pg-404-card">
        <i class="bi bi-bag-x pg-404-icon"></i>
        <div class="pg-404-num">404</div>
        <h1 class="pg-404-title">This page has gone missing.</h1>
        <p class="pg-404-text">
            The page you're looking for may have been moved, renamed, or is no longer available.
            <?php if (ENVIRONMENT !== 'production'): ?>
            <br><small style="color:#aaa;"><?= esc($message) ?></small>
            <?php endif; ?>
        </p>
        <div class="pg-404-links mb-3">
            <a href="/" class="pg-btn-primary"><i class="bi bi-house"></i> Go to Home</a>
            <a href="/products" class="pg-btn-outline"><i class="bi bi-grid"></i> Browse Products</a>
        </div>
        <div class="pg-404-secondary">
            <a href="/about" class="pg-404-link">About Us</a>
            <span class="pg-404-sep">·</span>
            <a href="/faq" class="pg-404-link">FAQ</a>
            <span class="pg-404-sep">·</span>
            <a href="/contact" class="pg-404-link">Contact Us</a>
        </div>
    </div>
</div>
</body>
</html>
