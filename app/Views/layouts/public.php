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
<html lang="en-IN" itemscope itemtype="https://schema.org/WebPage">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    $activeTheme  = $settings['active_theme'] ?? 'default';
    $siteName     = $settings['site_name']    ?? 'Product Gallery';
    $siteTagline  = $settings['site_tagline'] ?? 'OEM Leather Goods & Fashion Accessories Manufacturer';
    $pageTitle    = $metaTitle ?? $siteName;
    $pageDesc     = $metaDesc  ?? $siteTagline;
    $pageKeywords = $metaKeywords ?? 'leather goods manufacturer, OEM leather bags, ODM accessories, private label handbags, wallets manufacturer India, leather belts OEM, fashion accessories Kanpur, leather goods export India';
    $pageRobots   = $metaRobots ?? 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1';
    ?>

    <!-- ── Primary Meta ──────────────────────────────────── -->
    <title><?= esc($pageTitle) ?></title>
    <meta name="description"    content="<?= esc($pageDesc) ?>">
    <meta name="keywords"       content="<?= esc($pageKeywords) ?>">
    <meta name="robots"         content="<?= esc($pageRobots) ?>">
    <meta name="author"         content="<?= esc($siteName) ?>">
    <meta name="copyright"      content="&copy; <?= date('Y') ?> <?= esc($siteName) ?>">
    <meta name="language"       content="English">
    <meta name="revisit-after"  content="7 days">
    <meta name="rating"         content="general">
    <meta name="format-detection" content="telephone=no">
    <meta name="theme-color"    content="#8B5A2B">

    <!-- ── Developer / Generator ─────────────────────────── -->
    <meta name="generator"  content="CodeIgniter 4 — Developed by RAMRAS Technologies (ramrastech.com)">
    <meta name="developer"  content="RAMRAS Technologies — ramrastech.com">
    <meta name="designer"   content="RAMRAS Technologies — ramrastech.com">

    <!-- ── Geo / Local SEO ───────────────────────────────── -->
    <meta name="geo.region"      content="IN-UP">
    <meta name="geo.placename"   content="Kanpur, Uttar Pradesh, India">
    <meta name="geo.position"    content="26.4499;80.3319">
    <meta name="ICBM"            content="26.4499, 80.3319">

    <!-- ── Business / Contact ────────────────────────────── -->
    <meta name="category"        content="Leather Goods Manufacturing, Fashion Accessories, OEM ODM Export">
    <meta name="classification"  content="Business, Manufacturing, B2B">
    <meta name="coverage"        content="Worldwide">
    <meta name="target"          content="all">
    <?php if (!empty($settings['enquiry_email'])): ?>
    <meta name="reply-to"        content="<?= esc($settings['enquiry_email']) ?>">
    <meta name="email"           content="<?= esc($settings['enquiry_email']) ?>">
    <?php endif; ?>
    <?php if (!empty($settings['contact_phone'])): ?>
    <meta name="telephone"       content="<?= esc($settings['contact_phone']) ?>">
    <?php endif; ?>

    <!-- ── Open Graph + Twitter Card ─────────────────────── -->
    <?= view('partials/og_meta') ?>

    <!-- ── Schema.org JSON-LD Structured Data ────────────── -->
    <?= view('partials/schema_org') ?>

    <!-- ── Favicon ───────────────────────────────────────── -->
    <?php if (! empty($settings['favicon_url'])): ?>
    <link rel="icon" href="<?= esc($settings['favicon_url']) ?>">
    <link rel="shortcut icon" href="<?= esc($settings['favicon_url']) ?>">
    <?php else: ?>
    <link rel="icon" href="/favicon.ico">
    <?php endif; ?>

    <!-- ── Preconnect CDNs ───────────────────────────────── -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://images.unsplash.com" crossorigin>
    <link rel="preconnect" href="https://images.pexels.com" crossorigin>
    <link rel="dns-prefetch" href="https://viale.in">

    <!-- ── Bootstrap ─────────────────────────────────────── -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- ── Swiper / GLightbox ────────────────────────────── -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox@3.3.0/dist/css/glightbox.min.css">

    <!-- ── AOS Scroll Animations ─────────────────────────── -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">

    <!-- ── Active Theme ──────────────────────────────────── -->
    <link rel="stylesheet" href="/themes/<?= esc($activeTheme) ?>/style.css">

    <?= $this->renderSection('styles') ?>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg pg-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/">
            <?php if (! empty($settings['logo_url'])): ?>
            <img src="<?= esc($settings['logo_url']) ?>" alt="<?= esc($settings['site_name'] ?? 'Product Gallery') ?>"
                 style="max-height:40px; width:auto; object-fit:contain;">
            <?php else: ?>
            <?= esc($settings['site_name'] ?? 'Product Gallery') ?>
            <?php endif; ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() === '' ? 'active' : '' ?>" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= str_starts_with(uri_string(), 'products') ? 'active' : '' ?>" href="/products">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() === 'about' ? 'active' : '' ?>" href="/about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() === 'faq' ? 'active' : '' ?>" href="/faq">FAQ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() === 'contact' ? 'active' : '' ?>" href="/contact">Contact</a>
                </li>
            </ul>
            <form class="d-flex" action="/search" method="get">
                <div class="input-group input-group-sm">
                    <input class="form-control pg-search" type="search" name="q" placeholder="Search products..." value="<?= esc(service('request')->getGet('q') ?? '') ?>">
                    <button class="btn pg-search-btn" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main>
    <?= $this->renderSection('content') ?>
</main>

<!-- Footer -->
<footer class="pg-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4 col-lg-4">
                <h6 class="pg-footer-brand"><?= esc($settings['site_name'] ?? 'Product Gallery') ?></h6>
                <p class="pg-footer-tagline"><?= esc($settings['site_tagline'] ?? '') ?></p>
                <?php if (! empty($settings['contact_address'])): ?>
                <p class="small mt-2"><i class="bi bi-geo-alt me-2"></i><?= esc($settings['contact_address']) ?></p>
                <?php else: ?>
                <p class="small mt-2"><i class="bi bi-geo-alt me-2"></i>Kanpur, Uttar Pradesh, India</p>
                <?php endif; ?>
                <?php if (! empty($settings['contact_phone'])): ?>
                <p class="small"><i class="bi bi-telephone me-2"></i><?= esc($settings['contact_phone']) ?></p>
                <?php endif; ?>
                <?php if (! empty($settings['enquiry_email'])): ?>
                <p class="small"><i class="bi bi-envelope me-2"></i>
                    <a href="mailto:<?= esc($settings['enquiry_email']) ?>" class="pg-footer-email"><?= esc($settings['enquiry_email']) ?></a>
                </p>
                <?php endif; ?>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <h6 class="pg-footer-heading">Products</h6>
                <ul class="list-unstyled pg-footer-links">
                    <li><a href="/products">All Products</a></li>
                    <li><a href="/products?category=ladies-handbags">Handbags</a></li>
                    <li><a href="/products?category=mens-wallets">Wallets</a></li>
                    <li><a href="/products?category=mens-belts">Belts</a></li>
                    <li><a href="/products?category=backpacks">Backpacks</a></li>
                    <li><a href="/products?category=vegan-pu-collection">Vegan</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <h6 class="pg-footer-heading">Company</h6>
                <ul class="list-unstyled pg-footer-links">
                    <li><a href="/">Home</a></li>
                    <li><a href="/about">About Us</a></li>
                    <li><a href="/faq">FAQ</a></li>
                    <li><a href="/contact">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-md-12 col-lg-4">
                <h6 class="pg-footer-heading">Follow &amp; Connect</h6>
                <div class="d-flex gap-3 pg-social-icons mb-3">
                    <?php if (! empty($settings['facebook_url'])): ?>
                    <a href="<?= esc($settings['facebook_url']) ?>" target="_blank" rel="noopener" title="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <?php endif; ?>
                    <?php if (! empty($settings['instagram_url'])): ?>
                    <a href="<?= esc($settings['instagram_url']) ?>" target="_blank" rel="noopener" title="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <?php endif; ?>
                    <?php if (! empty($settings['linkedin_url'])): ?>
                    <a href="<?= esc($settings['linkedin_url']) ?>" target="_blank" rel="noopener" title="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <?php endif; ?>
                    <?php if (! empty($settings['twitter_url'])): ?>
                    <a href="<?= esc($settings['twitter_url']) ?>" target="_blank" rel="noopener" title="X / Twitter">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                    <?php endif; ?>
                    <?php if (! empty($settings['whatsapp_number'])): ?>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $settings['whatsapp_number']) ?>"
                       target="_blank" rel="noopener" title="WhatsApp">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    <?php endif; ?>
                </div>
                <p class="small pg-footer-cert">
                    <i class="bi bi-patch-check-fill text-success me-1"></i> ISO 9001:2015
                    &nbsp;&middot;&nbsp;
                    <i class="bi bi-award-fill text-warning me-1"></i> SA 8000
                    &nbsp;&middot;&nbsp;
                    <i class="bi bi-shield-check text-info me-1"></i> LWG Silver
                </p>
            </div>
        </div>
        <hr class="pg-footer-divider">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <p class="pg-footer-copy small mb-0">
                &copy; <?= date('Y') ?> <?= esc($settings['site_name'] ?? 'Product Gallery') ?>. All rights reserved.
            </p>
            <div class="pg-footer-legal">
                <a href="/privacy">Privacy Policy</a>
                <span class="mx-2 text-muted">·</span>
                <a href="/terms">Terms &amp; Conditions</a>
                <span class="mx-2 text-muted">·</span>
                <a href="/faq">FAQ</a>
            </div>
        </div>
        <p class="pg-footer-dev">
            <span class="pg-footer-dev-needle">&#x2702;</span>
            Stitched in code by
            <a href="https://ramrastech.com" target="_blank" rel="noopener">RAMRAS TECHNOLOGIES</a>
        </p>
    </div>
</footer>

<!-- WhatsApp Floating Button -->
<?= view('partials/whatsapp_btn') ?>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/glightbox@3.3.0/dist/js/glightbox.min.js"></script>

<!-- Analytics -->
<?= view('partials/analytics') ?>

<!-- AOS Init -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init({ duration: 700, once: true, offset: 80, easing: 'ease-out-cubic' });</script>

<?= $this->renderSection('scripts') ?>
</body>
</html>
