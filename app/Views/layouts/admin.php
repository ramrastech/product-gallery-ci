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
    <title><?= esc($pageTitle ?? 'Admin') ?> — Product Gallery Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #0f172a;
            --sidebar-border: #1e293b;
            --sidebar-text: #94a3b8;
            --sidebar-active: #6366f1;
            --topbar-bg: #1e293b;
            --body-bg: #0f172a;
            --card-bg: #1e293b;
            --card-border: #334155;
            --text-primary: #f1f5f9;
            --text-muted: #64748b;
            --accent: #6366f1;
        }
        body { background: var(--body-bg); color: var(--text-primary); font-family: 'Inter', system-ui, sans-serif; }
        .sidebar { width: 240px; min-height: 100vh; background: var(--sidebar-bg); border-right: 1px solid var(--sidebar-border); position: fixed; top: 0; left: 0; z-index: 100; display: flex; flex-direction: column; }
        .sidebar-brand { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--sidebar-border); }
        .sidebar-brand h6 { color: var(--text-primary); font-weight: 700; margin: 0; font-size: 1rem; letter-spacing: -0.3px; }
        .sidebar-brand span { color: var(--accent); }
        .sidebar-nav { flex: 1; padding: 1rem 0; overflow-y: auto; }
        .nav-section { padding: 0.5rem 1rem 0.25rem; font-size: 0.65rem; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--text-muted); }
        .sidebar-nav .nav-link { color: var(--sidebar-text); padding: 0.55rem 1.5rem; font-size: 0.875rem; display: flex; align-items: center; gap: 0.65rem; border-radius: 0; transition: all 0.15s; }
        .sidebar-nav .nav-link:hover { color: var(--text-primary); background: rgba(99,102,241,0.1); }
        .sidebar-nav .nav-link.active { color: #fff; background: var(--accent); }
        .sidebar-nav .nav-link i { font-size: 1rem; width: 18px; }
        .main-wrapper { margin-left: 240px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background: var(--topbar-bg); border-bottom: 1px solid var(--card-border); padding: 0.75rem 1.5rem; display: flex; align-items: center; justify-content: space-between; }
        .topbar .page-title { font-size: 1.05rem; font-weight: 600; color: var(--text-primary); margin: 0; }
        .topbar .admin-info { color: var(--text-muted); font-size: 0.85rem; }
        .content { flex: 1; padding: 1.75rem; }
        .card { background: var(--card-bg); border: 1px solid var(--card-border); color: var(--text-primary); }
        .card-header { background: transparent; border-bottom: 1px solid var(--card-border); }
        .table { color: var(--text-primary); }
        .table-hover > tbody > tr:hover { background: rgba(255,255,255,0.03); color: var(--text-primary); }
        .table th { border-color: var(--card-border); color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }
        .table td { border-color: var(--card-border); vertical-align: middle; }
        .form-control, .form-select { background: #0f172a; border-color: #334155; color: var(--text-primary); }
        .form-control:focus, .form-select:focus { background: #0f172a; border-color: var(--accent); color: var(--text-primary); box-shadow: 0 0 0 0.2rem rgba(99,102,241,.2); }
        .form-label { color: var(--sidebar-text); font-size: 0.85rem; font-weight: 500; }
        .btn-primary { background: var(--accent); border-color: var(--accent); }
        .btn-primary:hover { background: #4f46e5; border-color: #4f46e5; }
        .badge-new { background: #ef4444; }
        .stat-card { border-radius: 12px; }
        .stat-card .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
        .stat-value { font-size: 1.75rem; font-weight: 700; line-height: 1; }
        .stat-label { color: var(--text-muted); font-size: 0.8rem; }
        @media (max-width: 768px) { .sidebar { transform: translateX(-100%); } .main-wrapper { margin-left: 0; } }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <h6>Product Gallery<span>.</span></h6>
        <small style="color: var(--text-muted); font-size: 0.72rem;">Admin Panel</small>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Main</div>
        <a href="/admin" class="nav-link <?= uri_string() === 'admin' ? 'active' : '' ?>">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section mt-2">Catalog</div>
        <a href="/admin/products" class="nav-link <?= str_starts_with(uri_string(), 'admin/products') ? 'active' : '' ?>">
            <i class="bi bi-box-seam"></i> Products
        </a>
        <a href="/admin/categories" class="nav-link <?= str_starts_with(uri_string(), 'admin/categories') ? 'active' : '' ?>">
            <i class="bi bi-tags"></i> Categories
        </a>

        <div class="nav-section mt-2">CRM</div>
        <a href="/admin/enquiries" class="nav-link <?= str_starts_with(uri_string(), 'admin/enquiries') ? 'active' : '' ?>">
            <i class="bi bi-envelope"></i> Enquiries
            <?php
            $newCount = (new \App\Models\EnquiryModel())->where('status', 'new')->countAllResults();
            if ($newCount > 0): ?>
                <span class="badge badge-new ms-auto" style="background:#ef4444;"><?= $newCount ?></span>
            <?php endif; ?>
        </a>

        <div class="nav-section mt-2">Content</div>
        <a href="/admin/home-content" class="nav-link <?= str_starts_with(uri_string(), 'admin/home-content') ? 'active' : '' ?>">
            <i class="bi bi-house-heart"></i> Home Content
        </a>
        <a href="/admin/about-content" class="nav-link <?= str_starts_with(uri_string(), 'admin/about-content') ? 'active' : '' ?>">
            <i class="bi bi-info-circle"></i> About Content
        </a>
        <a href="/admin/faq" class="nav-link <?= str_starts_with(uri_string(), 'admin/faq') ? 'active' : '' ?>">
            <i class="bi bi-question-circle"></i> FAQ
        </a>
        <a href="/admin/page-content/privacy" class="nav-link <?= str_starts_with(uri_string(), 'admin/page-content') ? 'active' : '' ?>">
            <i class="bi bi-file-earmark-text"></i> Legal Pages
        </a>

        <div class="nav-section mt-2">SEO & Media</div>
        <a href="/admin/page-seo" class="nav-link <?= str_starts_with(uri_string(), 'admin/page-seo') ? 'active' : '' ?>">
            <i class="bi bi-search"></i> Page SEO
        </a>
        <a href="/admin/media" class="nav-link <?= str_starts_with(uri_string(), 'admin/media') ? 'active' : '' ?>">
            <i class="bi bi-image"></i> Media Library
        </a>

        <div class="nav-section mt-2">Config</div>
        <a href="/admin/themes" class="nav-link <?= str_starts_with(uri_string(), 'admin/themes') ? 'active' : '' ?>">
            <i class="bi bi-palette"></i> Themes
        </a>
        <a href="/admin/settings" class="nav-link <?= str_starts_with(uri_string(), 'admin/settings') ? 'active' : '' ?>">
            <i class="bi bi-gear"></i> Settings
        </a>
    </nav>
    <div style="padding: 1rem 1.5rem; border-top: 1px solid var(--sidebar-border);">
        <a href="/admin/logout" class="nav-link" style="padding: 0.5rem 0; color: #ef4444;">
            <i class="bi bi-box-arrow-left"></i> Logout
        </a>
    </div>
</aside>

<!-- Main Content -->
<div class="main-wrapper">
    <div class="topbar">
        <h1 class="page-title"><?= esc($pageTitle ?? 'Dashboard') ?></h1>
        <div class="admin-info">
            <i class="bi bi-person-circle me-1"></i>
            <?= esc(session()->get('admin_username')) ?>
        </div>
    </div>

    <div class="content">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show py-2 mb-3" role="alert">
                <?= esc(session()->getFlashdata('success')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show py-2 mb-3" role="alert">
                <?= esc(session()->getFlashdata('error')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
