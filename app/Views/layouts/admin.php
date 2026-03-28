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
<html lang="en" data-admin-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle ?? 'Admin') ?> — Product Gallery Admin</title>
    <?php
    $adminSettings = (new \App\Models\SettingsModel())->getAllKeyed();
    $adminFavicon  = $adminSettings['favicon_url'] ?? '';
    ?>
    <?php if ($adminFavicon): ?>
    <link rel="icon" href="<?= esc($adminFavicon) ?>">
    <?php else: ?>
    <link rel="icon" href="/favicon.ico">
    <?php endif; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        /* ── Dark mode (default) ── */
        :root {
            --sidebar-bg: #0f172a;
            --sidebar-border: #1e293b;
            --sidebar-text: #94a3b8;
            --topbar-bg: #1e293b;
            --body-bg: #0f172a;
            --card-bg: #1e293b;
            --card-border: #334155;
            --text-primary: #f1f5f9;
            --text-muted: #64748b;
            --accent: #6366f1;
            --input-bg: #0f172a;
            --input-border: #334155;
            --sidebar-w: 240px;
            --sidebar-w-collapsed: 64px;
        }
        /* ── Light mode ── */
        html[data-admin-theme="light"] {
            --topbar-bg: #ffffff;
            --body-bg: #f1f5f9;
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --text-primary: #0f172a;
            --text-muted: #64748b;
            --input-bg: #ffffff;
            --input-border: #cbd5e1;
        }
        body { background: var(--body-bg); color: var(--text-primary); font-family: 'Inter', system-ui, sans-serif; transition: background 0.2s, color 0.2s; }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            position: fixed; top: 0; left: 0; z-index: 100;
            display: flex; flex-direction: column;
            transition: width 0.22s ease;
            overflow: hidden;
        }
        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--sidebar-border);
            white-space: nowrap;
            overflow: hidden;
            transition: padding 0.22s ease;
        }
        .sidebar-brand h6 { color: #f1f5f9; font-weight: 700; margin: 0; font-size: 1rem; letter-spacing: -0.3px; }
        .sidebar-brand h6 .brand-dot { color: var(--accent); }
        .sidebar-brand small { color: var(--text-muted); font-size: 0.72rem; display: block; transition: opacity 0.15s; }
        .sidebar-nav { flex: 1; padding: 1rem 0; overflow-y: auto; overflow-x: hidden; }
        .nav-section {
            padding: 0.5rem 1rem 0.25rem;
            font-size: 0.65rem; font-weight: 600; letter-spacing: 1px;
            text-transform: uppercase; color: #475569;
            white-space: nowrap; overflow: hidden;
            transition: opacity 0.15s, height 0.22s ease, padding 0.22s ease;
        }
        .sidebar-nav .nav-link {
            color: #94a3b8;
            padding: 0.55rem 1.5rem;
            font-size: 0.875rem;
            display: flex; align-items: center; gap: 0.65rem;
            border-radius: 0;
            transition: all 0.15s;
            white-space: nowrap; overflow: hidden;
        }
        .sidebar-nav .nav-link:hover { color: #f1f5f9; background: rgba(99,102,241,0.1); }
        .sidebar-nav .nav-link.active { color: #fff; background: var(--accent); }
        .sidebar-nav .nav-link i { font-size: 1rem; width: 18px; flex-shrink: 0; }
        .nav-text { transition: opacity 0.15s; }
        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--sidebar-border);
            white-space: nowrap; overflow: hidden;
            transition: padding 0.22s ease;
        }
        .sidebar-footer .nav-link { padding: 0.5rem 0; color: #ef4444; }

        /* ── Sidebar collapsed state ── */
        .sidebar.collapsed { width: var(--sidebar-w-collapsed); }
        .brand-short { display: none; }
        .sidebar.collapsed .brand-text { display: none; }
        .sidebar.collapsed .brand-short { display: inline; }
        .sidebar.collapsed .sidebar-brand { padding: 1.25rem 0; text-align: center; }
        .sidebar.collapsed .nav-section { opacity: 0; height: 0; padding-top: 0; padding-bottom: 0; }
        .sidebar.collapsed .nav-text { opacity: 0; width: 0; overflow: hidden; }
        .sidebar.collapsed .badge { display: none !important; }
        .sidebar.collapsed .sidebar-nav .nav-link {
            padding: 0.65rem 0;
            justify-content: center;
            gap: 0;
        }
        .sidebar.collapsed .sidebar-nav .nav-link i { width: auto; font-size: 1.05rem; }
        .sidebar.collapsed .sidebar-footer { padding: 0.75rem 0; text-align: center; }
        .sidebar.collapsed .sidebar-footer .nav-link { padding: 0.5rem 0; justify-content: center; }

        /* ── Main wrapper ── */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex; flex-direction: column;
            transition: margin-left 0.22s ease;
        }
        .main-wrapper.collapsed { margin-left: var(--sidebar-w-collapsed); }

        .topbar { background: var(--topbar-bg); border-bottom: 1px solid var(--card-border); padding: 0.75rem 1.5rem; display: flex; align-items: center; justify-content: space-between; transition: background 0.2s; }
        .topbar .page-title { font-size: 1.05rem; font-weight: 600; color: var(--text-primary); margin: 0; }
        .topbar .admin-info { color: var(--text-muted); font-size: 0.85rem; }
        .content { flex: 1; padding: 1.75rem; }
        .card { background: var(--card-bg); border: 1px solid var(--card-border); color: var(--text-primary); transition: background 0.2s; }
        .card-header { background: transparent; border-bottom: 1px solid var(--card-border); color: var(--text-primary); }
        .table { --bs-table-color: var(--text-primary); --bs-table-bg: transparent; --bs-table-border-color: var(--card-border); color: var(--text-primary); }
        .table-hover > tbody > tr:hover { --bs-table-hover-color: var(--text-primary); background-color: rgba(99,102,241,0.05); }
        .table th { border-color: var(--card-border); color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }
        .table td { border-color: var(--card-border); vertical-align: middle; color: var(--text-primary); }
        .form-control, .form-select { background: var(--input-bg); border-color: var(--input-border); color: var(--text-primary); }
        .form-control:focus, .form-select:focus { background: var(--input-bg); border-color: var(--accent); color: var(--text-primary); box-shadow: 0 0 0 0.2rem rgba(99,102,241,.2); }
        .form-control::placeholder { color: var(--text-muted); }
        .form-label { color: var(--text-muted); font-size: 0.85rem; font-weight: 500; }
        .btn-primary { background: var(--accent); border-color: var(--accent); }
        .btn-primary:hover { background: #4f46e5; border-color: #4f46e5; }
        .btn-outline-secondary { color: var(--text-muted); border-color: var(--card-border); }
        .btn-outline-secondary:hover { background: var(--card-border); color: var(--text-primary); border-color: var(--card-border); }
        html[data-admin-theme="light"] .btn-outline-secondary { color: #475569; border-color: #cbd5e1; }
        html[data-admin-theme="light"] .btn-outline-secondary:hover { background: #e2e8f0; color: #0f172a; }
        .badge-new { background: #ef4444; }
        .stat-card { border-radius: 12px; }
        .stat-card .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
        .stat-value { font-size: 1.75rem; font-weight: 700; line-height: 1; }
        .stat-label { color: var(--text-muted); font-size: 0.8rem; }
        /* Topbar icon buttons */
        #themeToggle, #sidebarToggle { background: transparent; border: 1px solid var(--card-border); color: var(--text-muted); width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.15s; }
        #themeToggle:hover, #sidebarToggle:hover { color: var(--text-primary); border-color: var(--accent); }
        .help-tip { color: var(--text-muted); font-size: 0.8rem; cursor: help; margin-left: 4px; vertical-align: middle; opacity: 0.7; transition: color 0.15s, opacity 0.15s; }
        .help-tip:hover { color: var(--accent); opacity: 1; }
        #helpBtn { background: transparent; border: 1px solid var(--card-border); color: var(--text-muted); width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.15s; }
        #helpBtn:hover { color: var(--accent); border-color: var(--accent); }
        /* ── Scroll motion ── */
        .topbar  { animation: adm-slide-down 0.28s ease both; }
        .content { animation: adm-fade-up    0.32s ease both; }
        @keyframes adm-slide-down { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:none; } }
        @keyframes adm-fade-up    { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:none; } }
        [data-scroll] {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity 0.42s cubic-bezier(.25,.46,.45,.94),
                        transform 0.42s cubic-bezier(.25,.46,.45,.94);
            transition-delay: var(--sd, 0ms);
            will-change: opacity, transform;
        }
        [data-scroll].in-view { opacity: 1; transform: none; }
        @media (prefers-reduced-motion: reduce) {
            .topbar, .content, [data-scroll] { animation: none; transition: none; opacity: 1; transform: none; }
        }
        @media (max-width: 768px) { .sidebar { transform: translateX(-100%); } .main-wrapper { margin-left: 0; } }
    </style>
    <?= $this->renderSection('styles') ?>
    <script>
        // Apply saved theme before paint to prevent flash
        (function(){
            var t = localStorage.getItem('adminTheme');
            if (t) document.documentElement.setAttribute('data-admin-theme', t);
        })();
    </script>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        <h6><span class="brand-text">Product Gallery</span><span class="brand-short">PG</span><span class="brand-dot">.</span></h6>
        <small class="brand-text">Admin Panel</small>
    </div>
    <?php $role = session()->get('admin_role') ?? 'viewer'; ?>
    <nav class="sidebar-nav">
        <div class="nav-section">Main</div>
        <a href="/admin" class="nav-link <?= uri_string() === 'admin' ? 'active' : '' ?>" title="Dashboard">
            <i class="bi bi-speedometer2"></i><span class="nav-text"> Dashboard</span>
        </a>

        <div class="nav-section mt-2">Catalog</div>
        <a href="/admin/products" class="nav-link <?= str_starts_with(uri_string(), 'admin/products') ? 'active' : '' ?>" title="Products">
            <i class="bi bi-box-seam"></i><span class="nav-text"> Products</span>
        </a>
        <a href="/admin/categories" class="nav-link <?= str_starts_with(uri_string(), 'admin/categories') ? 'active' : '' ?>" title="Categories">
            <i class="bi bi-tags"></i><span class="nav-text"> Categories</span>
        </a>

        <div class="nav-section mt-2">CRM</div>
        <a href="/admin/enquiries" class="nav-link <?= str_starts_with(uri_string(), 'admin/enquiries') ? 'active' : '' ?>" title="Enquiries">
            <i class="bi bi-envelope"></i><span class="nav-text"> Enquiries</span>
            <?php
            $newCount = (new \App\Models\EnquiryModel())->where('status', 'new')->countAllResults();
            if ($newCount > 0): ?>
                <span class="badge badge-new ms-auto" style="background:#ef4444;"><?= $newCount ?></span>
            <?php endif; ?>
        </a>

        <?php if (in_array($role, ['super_admin', 'manager'])): ?>
        <div class="nav-section mt-2">Content</div>
        <a href="/admin/home-content" class="nav-link <?= str_starts_with(uri_string(), 'admin/home-content') ? 'active' : '' ?>" title="Home Content">
            <i class="bi bi-house-heart"></i><span class="nav-text"> Home Content</span>
        </a>
        <a href="/admin/about-content" class="nav-link <?= str_starts_with(uri_string(), 'admin/about-content') ? 'active' : '' ?>" title="About Content">
            <i class="bi bi-info-circle"></i><span class="nav-text"> About Content</span>
        </a>
        <a href="/admin/faq" class="nav-link <?= str_starts_with(uri_string(), 'admin/faq') ? 'active' : '' ?>" title="FAQ">
            <i class="bi bi-question-circle"></i><span class="nav-text"> FAQ</span>
        </a>
        <a href="/admin/page-content/privacy" class="nav-link <?= str_starts_with(uri_string(), 'admin/page-content') ? 'active' : '' ?>" title="Legal Pages">
            <i class="bi bi-file-earmark-text"></i><span class="nav-text"> Legal Pages</span>
        </a>

        <div class="nav-section mt-2">SEO &amp; Media</div>
        <a href="/admin/page-seo" class="nav-link <?= str_starts_with(uri_string(), 'admin/page-seo') ? 'active' : '' ?>" title="Page SEO">
            <i class="bi bi-search"></i><span class="nav-text"> Page SEO</span>
        </a>
        <a href="/admin/media" class="nav-link <?= str_starts_with(uri_string(), 'admin/media') ? 'active' : '' ?>" title="Media Library">
            <i class="bi bi-image"></i><span class="nav-text"> Media Library</span>
        </a>
        <?php endif; ?>

        <?php if ($role === 'super_admin'): ?>
        <div class="nav-section mt-2">Config</div>
        <a href="/admin/themes" class="nav-link <?= str_starts_with(uri_string(), 'admin/themes') ? 'active' : '' ?>" title="Themes">
            <i class="bi bi-palette"></i><span class="nav-text"> Themes</span>
        </a>
        <a href="/admin/settings" class="nav-link <?= str_starts_with(uri_string(), 'admin/settings') ? 'active' : '' ?>" title="Site Settings">
            <i class="bi bi-gear"></i><span class="nav-text"> Site Settings</span>
        </a>
        <a href="/admin/users" class="nav-link <?= str_starts_with(uri_string(), 'admin/users') ? 'active' : '' ?>" title="Admin Users">
            <i class="bi bi-people"></i><span class="nav-text"> Admin Users</span>
        </a>
        <a href="/admin/audit-log" class="nav-link <?= str_starts_with(uri_string(), 'admin/audit-log') ? 'active' : '' ?>" title="Activity Log">
            <i class="bi bi-journal-text"></i><span class="nav-text"> Activity Log</span>
        </a>
        <?php endif; ?>

        <div class="nav-section mt-2">Account</div>
        <a href="/admin/profile" class="nav-link <?= str_starts_with(uri_string(), 'admin/profile') ? 'active' : '' ?>" title="My Profile">
            <i class="bi bi-person-circle"></i><span class="nav-text"> My Profile</span>
        </a>

        <div class="nav-section mt-2">Support</div>
        <a href="/admin/help" class="nav-link <?= str_starts_with(uri_string(), 'admin/help') ? 'active' : '' ?>" title="Help &amp; Support">
            <i class="bi bi-life-preserver"></i><span class="nav-text"> Help &amp; Support</span>
        </a>
    </nav>
    <div class="sidebar-footer">
        <a href="/admin/logout" class="nav-link" style="color: #ef4444;" title="Logout">
            <i class="bi bi-box-arrow-left"></i><span class="nav-text"> Logout</span>
        </a>
    </div>
</aside>

<!-- Main Content -->
<div class="main-wrapper" id="mainWrapper">
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button id="sidebarToggle" title="Toggle sidebar">
                <i class="bi bi-layout-sidebar"></i>
            </button>
            <h1 class="page-title"><?= esc($pageTitle ?? 'Dashboard') ?></h1>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="/admin/help" id="helpBtn" title="Help & Support">
                <i class="bi bi-question-circle"></i>
            </a>
            <button id="themeToggle" title="Toggle dark/light mode">
                <i class="bi bi-moon"></i>
            </button>
            <div class="admin-info">
                <i class="bi bi-person-circle me-1"></i>
                <?= esc(session()->get('admin_username')) ?>
            </div>
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
        <?php if (session()->getFlashdata('warning')): ?>
            <div class="alert alert-warning alert-dismissible fade show py-2 mb-3" role="alert">
                <?= esc(session()->getFlashdata('warning')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ── Admin theme toggle ──
(function () {
    const KEY = 'adminTheme';
    const saved = localStorage.getItem(KEY) || 'dark';
    document.documentElement.setAttribute('data-admin-theme', saved);

    function syncIcon() {
        const t = document.documentElement.getAttribute('data-admin-theme');
        const btn = document.getElementById('themeToggle');
        if (btn) btn.innerHTML = t === 'dark' ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon"></i>';
    }

    document.addEventListener('DOMContentLoaded', function () {
        syncIcon();
        const btn = document.getElementById('themeToggle');
        if (btn) {
            btn.addEventListener('click', function () {
                const next = document.documentElement.getAttribute('data-admin-theme') === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-admin-theme', next);
                localStorage.setItem(KEY, next);
                syncIcon();
            });
        }
    });
})();

// ── Sidebar collapse ──
(function () {
    const SKEY = 'adminSidebarCollapsed';
    const sidebar = document.getElementById('adminSidebar');
    const wrapper = document.getElementById('mainWrapper');
    const btn     = document.getElementById('sidebarToggle');

    function applyState(collapsed) {
        if (collapsed) {
            sidebar.classList.add('collapsed');
            wrapper.classList.add('collapsed');
        } else {
            sidebar.classList.remove('collapsed');
            wrapper.classList.remove('collapsed');
        }
    }

    // Restore saved state immediately (before DOMContentLoaded to avoid layout jump)
    applyState(localStorage.getItem(SKEY) === '1');

    document.addEventListener('DOMContentLoaded', function () {
        if (!btn) return;
        btn.addEventListener('click', function () {
            const isCollapsed = sidebar.classList.contains('collapsed');
            applyState(!isCollapsed);
            localStorage.setItem(SKEY, isCollapsed ? '0' : '1');
        });
    });
})();

// ── Scroll motion system ──
document.addEventListener('DOMContentLoaded', function () {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    const content = document.querySelector('.content');
    if (!content) return;

    // Tag .card elements — stagger siblings that share the same parent
    const byParent = new Map();
    content.querySelectorAll('.card').forEach(card => {
        const p = card.parentElement;
        if (!byParent.has(p)) byParent.set(p, []);
        byParent.get(p).push(card);
    });
    byParent.forEach(group => {
        group.forEach((card, i) => {
            card.setAttribute('data-scroll', '');
            card.style.setProperty('--sd', (i * 60) + 'ms');
        });
    });

    // Tag table body rows with a short stagger
    content.querySelectorAll('table tbody tr').forEach((tr, i) => {
        tr.setAttribute('data-scroll', '');
        tr.style.setProperty('--sd', Math.min(i * 35, 320) + 'ms');
    });

    // Observe all tagged elements
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('in-view');
                obs.unobserve(e.target);
            }
        });
    }, { threshold: 0.04, rootMargin: '0px 0px -16px 0px' });

    content.querySelectorAll('[data-scroll]').forEach(el => obs.observe(el));
});

// ── Bootstrap tooltips (global) ──
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
        new bootstrap.Tooltip(el, { trigger: 'hover focus', boundary: 'window' });
    });

    // Sidebar nav tooltips — only active when sidebar is collapsed
    document.querySelectorAll('#adminSidebar .nav-link[title]').forEach(function (el) {
        new bootstrap.Tooltip(el, {
            trigger: 'hover',
            placement: 'right',
            boundary: 'window',
            customClass: 'sidebar-tooltip',
        });
    });
});

// ── Global: disable submit buttons and show spinner on any form submission ──
document.addEventListener('submit', function (e) {
    const form = e.target;
    const btn  = form.querySelector('[type="submit"]');
    if (btn && !btn.dataset.noSpinner) {
        btn.disabled = true;
        const original = btn.innerHTML;
        btn.innerHTML  = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> ' + original;
        setTimeout(() => { btn.disabled = false; btn.innerHTML = original; }, 8000);
    }
});
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
