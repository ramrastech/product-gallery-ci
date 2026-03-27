<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @email      info@ramrastech.com
 * @mobile     +91-7317377477
 * @website    https://ramrastech.com
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

$siteName   = $settings['site_name']    ?? 'Product Gallery';
$siteTagline= $settings['site_tagline'] ?? 'OEM Leather Goods & Fashion Accessories Manufacturer, Kanpur India';
$ogTitle    = $metaTitle ?? $siteName;
$ogDesc     = $metaDesc  ?? $siteTagline;
$ogImage    = $ogImage   ?? base_url('assets/img/og-default.jpg');
$ogUrl      = current_url();
$ogType     = $ogType    ?? 'website';
$canonical  = $canonical ?? $ogUrl;

// Strip query string from canonical for list pages
if ($ogType === 'website' && str_contains($canonical, '?')) {
    $canonical = strtok($canonical, '?');
}
?>

<!-- ── Canonical ─────────────────────────────────────── -->
<link rel="canonical" href="<?= esc($canonical) ?>">

<!-- ── Open Graph ────────────────────────────────────── -->
<meta property="og:type"         content="<?= esc($ogType) ?>">
<meta property="og:title"        content="<?= esc($ogTitle) ?>">
<meta property="og:description"  content="<?= esc($ogDesc) ?>">
<meta property="og:image"        content="<?= esc($ogImage) ?>">
<meta property="og:image:alt"    content="<?= esc($ogTitle) ?>">
<meta property="og:url"          content="<?= esc($ogUrl) ?>">
<meta property="og:site_name"    content="<?= esc($siteName) ?>">
<meta property="og:locale"       content="en_IN">
<?php if (!empty($settings['facebook_url'])): ?>
<meta property="article:publisher" content="<?= esc($settings['facebook_url']) ?>">
<?php endif; ?>

<!-- ── Twitter Card ──────────────────────────────────── -->
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="<?= esc($ogTitle) ?>">
<meta name="twitter:description" content="<?= esc($ogDesc) ?>">
<meta name="twitter:image"       content="<?= esc($ogImage) ?>">
<?php if (!empty($settings['twitter_url'])): ?>
<meta name="twitter:site"        content="<?= esc(basename(rtrim($settings['twitter_url'], '/'))) ?>">
<?php endif; ?>
