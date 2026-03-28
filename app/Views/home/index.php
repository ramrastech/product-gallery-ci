<?php
/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */
?>
<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('enquiry_success')): ?>
<div class="container mt-3">
    <div class="alert alert-success alert-dismissible fade show py-2">
        <?= esc(session()->getFlashdata('enquiry_success')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php endif; ?>

<!-- ========== HERO ========== -->
<section class="pg-hero pg-hero-oem has-bg-video">
    <?php if (! empty($settings['hero_video_url'])): ?>
    <video class="pg-hero-video" autoplay muted loop playsinline preload="auto"
           poster="<?= esc($settings['hero_poster_url'] ?? '') ?>">
        <source src="<?= esc($settings['hero_video_url']) ?>" type="video/mp4">
    </video>
    <?php elseif (! empty($settings['hero_poster_url'])): ?>
    <div class="pg-hero-video" style="background:url('<?= esc($settings['hero_poster_url']) ?>') center/cover no-repeat;"></div>
    <?php endif; ?>
    <div class="pg-hero-overlay"></div>
    <div class="container position-relative z-2">
        <div class="row align-items-center min-vh-hero">
            <div class="col-lg-7">
                <?php if (! empty($settings['hero_eyebrow'])): ?>
                <span class="pg-hero-eyebrow"><?= esc($settings['hero_eyebrow']) ?></span>
                <?php endif; ?>
                <?php if (! empty($settings['hero_title_line1']) || ! empty($settings['hero_title_line2']) || ! empty($settings['hero_accent_text'])): ?>
                <h1 class="pg-hero-title">
                    <?php if (! empty($settings['hero_title_line1'])): ?>
                    <?= esc($settings['hero_title_line1']) ?><br>
                    <?php endif; ?>
                    <?php if (! empty($settings['hero_title_line2'])): ?>
                    <?= esc($settings['hero_title_line2']) ?><br>
                    <?php endif; ?>
                    <?php if (! empty($settings['hero_accent_text'])): ?>
                    <span class="pg-hero-accent"><?= esc($settings['hero_accent_text']) ?></span>
                    <?php endif; ?>
                </h1>
                <?php endif; ?>
                <?php if (! empty($settings['hero_subtitle'])): ?>
                <p class="pg-hero-subtitle"><?= esc($settings['hero_subtitle']) ?></p>
                <?php endif; ?>
                <?php if (! empty($settings['hero_cta_primary_text']) || ! empty($settings['hero_cta_secondary_text'])): ?>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <?php if (! empty($settings['hero_cta_primary_text'])): ?>
                    <a href="<?= esc($settings['hero_cta_primary_url'] ?? '#') ?>" class="btn pg-btn-primary btn-lg px-4">
                        <?= esc($settings['hero_cta_primary_text']) ?> <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    <?php endif; ?>
                    <?php if (! empty($settings['hero_cta_secondary_text'])): ?>
                    <a href="<?= esc($settings['hero_cta_secondary_href'] ?? '#') ?>" class="btn pg-btn-outline-light btn-lg px-4">
                        <?= esc($settings['hero_cta_secondary_text']) ?>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <?php if (! empty($trustBadges)): ?>
                <div class="pg-hero-trust mt-4">
                    <?php foreach ($trustBadges as $i => $badge): ?>
                    <?= $i > 0 ? '<span class="ms-3">' : '<span>' ?>
                        <i class="bi <?= esc($badge['icon']) ?> <?= esc($badge['color'] ?? 'text-success') ?> me-1"></i>
                        <?= esc($badge['text']) ?>
                    </span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php if (! empty($settings['hero_frame_image_url'])): ?>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="pg-hero-image-frame">
                    <img src="<?= esc($settings['hero_frame_image_url']) ?>"
                         alt="Premium leather collection"
                         class="pg-hero-frame-img">
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ========== STATS BAR ========== -->
<?php if (! empty($stats)): ?>
<section class="pg-stats-bar">
    <div class="container">
        <div class="row g-0 pg-stats-row">
            <?php $lastIdx = count($stats) - 1; foreach ($stats as $i => $stat): ?>
            <div class="col-6 col-md-3 pg-stat-item <?= $i === $lastIdx ? 'pg-stat-last' : '' ?>" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <div class="pg-stat-number"><?= esc($stat['title']) ?></div>
                <div class="pg-stat-label"><?= esc($stat['subtitle']) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ========== OUR STORY ========== -->
<section class="pg-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="900">
                <div class="pg-about-image-grid">
                    <?php if (! empty($settings['story_main_image_url'])): ?>
                    <div class="pg-about-img-main">
                        <img src="<?= esc($settings['story_main_image_url']) ?>"
                             alt="Artisan crafting leather goods">
                    </div>
                    <?php endif; ?>
                    <?php if (! empty($settings['story_accent_image_url'])): ?>
                    <div class="pg-about-img-accent">
                        <img src="<?= esc($settings['story_accent_image_url']) ?>"
                             alt="Leather goods showcase">
                    </div>
                    <?php endif; ?>
                    <?php if (! empty($settings['story_badge_num'])): ?>
                    <div class="pg-about-badge">
                        <div class="pg-about-badge-num"><?= esc($settings['story_badge_num']) ?></div>
                        <div class="pg-about-badge-label"><?= esc($settings['story_badge_label'] ?? '') ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="900">
                <?php if (! empty($settings['story_eyebrow'])): ?>
                <span class="pg-eyebrow"><?= esc($settings['story_eyebrow']) ?></span>
                <?php endif; ?>
                <?php if (! empty($settings['story_heading'])): ?>
                <h2 class="pg-section-heading"><?= nl2br(esc($settings['story_heading'])) ?></h2>
                <?php endif; ?>
                <?php if (! empty($settings['story_body_1'])): ?>
                <p class="pg-body-text mt-3"><?= esc($settings['story_body_1']) ?></p>
                <?php endif; ?>
                <?php if (! empty($settings['story_body_2'])): ?>
                <p class="pg-body-text"><?= esc($settings['story_body_2']) ?></p>
                <?php endif; ?>
                <?php if (! empty($storyChecks)): ?>
                <div class="row g-3 mt-2">
                    <?php
                    $half = ceil(count($storyChecks) / 2);
                    $col1 = array_slice($storyChecks, 0, $half);
                    $col2 = array_slice($storyChecks, $half);
                    ?>
                    <div class="col-sm-6">
                        <?php foreach ($col1 as $check): ?>
                        <div class="pg-check-item"><i class="bi bi-check2-circle"></i> <?= esc($check) ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-sm-6">
                        <?php foreach ($col2 as $check): ?>
                        <div class="pg-check-item mt-2"><i class="bi bi-check2-circle"></i> <?= esc($check) ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php if (! empty($settings['story_cta_text'])): ?>
                <a href="<?= esc($settings['story_cta_url'] ?? '#') ?>" class="btn pg-btn-primary mt-4"><?= esc($settings['story_cta_text']) ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- ========== CAPABILITIES ========== -->
<?php if (! empty($capabilities)): ?>
<section class="pg-section pg-section-alt">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <?php if (! empty($settings['capabilities_eyebrow'])): ?>
            <span class="pg-eyebrow"><?= esc($settings['capabilities_eyebrow']) ?></span>
            <?php endif; ?>
            <?php if (! empty($settings['capabilities_heading'])): ?>
            <h2 class="pg-section-heading"><?= esc($settings['capabilities_heading']) ?></h2>
            <?php endif; ?>
            <?php if (! empty($settings['capabilities_subtext'])): ?>
            <p class="pg-body-text mt-2 mx-auto" style="max-width:560px;"><?= esc($settings['capabilities_subtext']) ?></p>
            <?php endif; ?>
        </div>
        <div class="row g-4">
            <?php $capIdx = 0; foreach ($capabilities as $cap): ?>
            <div class="col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= min($capIdx++ * 100, 300) ?>">
                <div class="pg-capability-card">
                    <?php if (! empty($cap['icon'])): ?>
                    <div class="pg-capability-icon"><i class="bi <?= esc($cap['icon']) ?>"></i></div>
                    <?php endif; ?>
                    <h5 class="pg-capability-title"><?= esc($cap['title']) ?></h5>
                    <p class="pg-capability-desc"><?= esc($cap['body'] ?? '') ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ========== PRODUCT CATEGORIES ========== -->
<?php
$genderGroups  = ['Women', 'Men', 'Unisex', 'Vegan'];
$displayCategories = $categories;
?>
<section class="pg-section">
    <div class="container">
        <div class="d-flex align-items-end justify-content-between mb-4 flex-wrap gap-2" data-aos="fade-up">
            <div>
                <?php if (! empty($settings['categories_eyebrow'])): ?>
                <span class="pg-eyebrow"><?= esc($settings['categories_eyebrow']) ?></span>
                <?php endif; ?>
                <?php if (! empty($settings['categories_heading'])): ?>
                <h2 class="pg-section-heading mb-0"><?= esc($settings['categories_heading']) ?></h2>
                <?php endif; ?>
            </div>
            <?php if (! empty($settings['categories_cta_text'])): ?>
            <a href="<?= esc($settings['categories_cta_url'] ?? '#') ?>" class="pg-view-all"><?= esc($settings['categories_cta_text']) ?> <i class="bi bi-arrow-right"></i></a>
            <?php endif; ?>
        </div>

        <?php if (! empty($displayCategories)): ?>
        <!-- Gender filter tabs (only when categories have gender field) -->
        <?php
        $hasGender = false;
        foreach ($displayCategories as $c) {
            if (! empty($c['gender'])) { $hasGender = true; break; }
        }
        ?>
        <?php if ($hasGender): ?>
        <div class="pg-cat-tabs mb-4">
            <button class="pg-cat-tab active" data-filter="all">All</button>
            <?php foreach ($genderGroups as $g): ?>
            <button class="pg-cat-tab" data-filter="<?= esc($g) ?>"><?= esc($g) ?></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="row g-3" id="categoryGrid">
            <?php $catIdx = 0; foreach ($displayCategories as $cat):
                $gender = $cat['gender'] ?? 'Unisex';
            ?>
            <div class="col-6 col-md-4 col-lg-3 pg-cat-item" data-gender="<?= esc($gender) ?>" data-aos="zoom-in" data-aos-delay="<?= min($catIdx++ * 75, 375) ?>">
                <a href="/products<?= ! empty($cat['slug']) ? '?category=' . esc($cat['slug']) : '' ?>"
                   class="pg-category-card d-block text-decoration-none">
                    <?php if (! empty($cat['image_path'])): ?>
                        <?php $catImgUrl = ($cat['image_path'][0] === '/') ? $cat['image_path'] : '/uploads/categories/' . $cat['image_path']; ?>
                        <div class="pg-category-img" style="background-image:url('<?= esc($catImgUrl) ?>');"></div>
                    <?php elseif (! empty($cat['image_url'])): ?>
                        <div class="pg-category-img" style="background-image:url('<?= esc($cat['image_url']) ?>');"></div>
                    <?php else: ?>
                        <div class="pg-category-img pg-category-icon-bg">
                            <i class="bi <?= esc($cat['icon'] ?? 'bi-grid') ?>"></i>
                        </div>
                    <?php endif; ?>
                    <?php if (! empty($gender) && $gender !== 'Unisex'): ?>
                    <span class="pg-cat-gender-badge pg-cat-gender-<?= strtolower(esc($gender)) ?>"><?= esc($gender) ?></span>
                    <?php endif; ?>
                    <div class="pg-category-info">
                        <span class="pg-category-name"><?= esc($cat['name']) ?></span>
                        <span class="pg-category-count"><?= (int) ($cat['product_count'] ?? $cat['count'] ?? 0) ?> products</span>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="text-muted">No categories found. <a href="/admin/categories">Add categories in Admin.</a></p>
        <?php endif; ?>
    </div>
</section>

<!-- ========== FEATURED PRODUCTS ========== -->
<?php if (! empty($featured)): ?>
<section class="pg-section pg-section-alt">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2" data-aos="fade-up">
            <div>
                <?php if (! empty($settings['featured_eyebrow'])): ?>
                <span class="pg-eyebrow"><?= esc($settings['featured_eyebrow']) ?></span>
                <?php endif; ?>
                <?php if (! empty($settings['featured_heading'])): ?>
                <h2 class="pg-section-heading mb-0"><?= esc($settings['featured_heading']) ?></h2>
                <?php endif; ?>
            </div>
            <?php if (! empty($settings['featured_cta_text'])): ?>
            <a href="<?= esc($settings['featured_cta_url'] ?? '#') ?>" class="pg-view-all"><?= esc($settings['featured_cta_text']) ?> <i class="bi bi-arrow-right"></i></a>
            <?php endif; ?>
        </div>
        <div class="row g-4">
            <?php $featIdx = 0; foreach ($featured as $p): ?>
            <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="<?= min($featIdx++ * 100, 300) ?>">
                <?= view('partials/product_card', ['product' => $p]) ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ========== MATERIALS & QUALITY ========== -->
<?php if (! empty($materials) || ! empty($certs)): ?>
<section class="pg-section pg-quality-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="900">
                <?php if (! empty($settings['materials_eyebrow'])): ?>
                <span class="pg-eyebrow"><?= esc($settings['materials_eyebrow']) ?></span>
                <?php endif; ?>
                <?php if (! empty($settings['materials_heading'])): ?>
                <h2 class="pg-section-heading"><?= nl2br(esc($settings['materials_heading'])) ?></h2>
                <?php endif; ?>
                <?php if (! empty($settings['materials_body'])): ?>
                <p class="pg-body-text mt-3"><?= esc($settings['materials_body']) ?></p>
                <?php endif; ?>
                <?php if (! empty($certs)): ?>
                <div class="row g-3 mt-2">
                    <?php foreach ($certs as $cert): ?>
                    <div class="col-6">
                        <div class="pg-cert-card">
                            <?php if (! empty($cert['icon'])): ?>
                            <i class="bi <?= esc($cert['icon']) ?> pg-cert-icon"></i>
                            <?php endif; ?>
                            <div class="pg-cert-label"><?= esc($cert['title']) ?></div>
                            <?php if (! empty($cert['subtitle'])): ?>
                            <div class="pg-cert-sub"><?= esc($cert['subtitle']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php if (! empty($materials)): ?>
            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="900">
                <div class="pg-quality-list">
                    <?php foreach ($materials as $mat): ?>
                    <div class="pg-quality-item">
                        <?php if (! empty($mat['icon'])): ?>
                        <div class="pg-quality-icon"><i class="bi <?= esc($mat['icon']) ?>"></i></div>
                        <?php endif; ?>
                        <div>
                            <div class="pg-quality-title"><?= esc($mat['title']) ?></div>
                            <?php if (! empty($mat['body'])): ?>
                            <div class="pg-quality-desc"><?= esc($mat['body']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ========== MARKETS WE SERVE ========== -->
<?php if (! empty($markets)): ?>
<section class="pg-section pg-section-alt">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <?php if (! empty($settings['markets_eyebrow'])): ?>
            <span class="pg-eyebrow"><?= esc($settings['markets_eyebrow']) ?></span>
            <?php endif; ?>
            <?php if (! empty($settings['markets_heading'])): ?>
            <h2 class="pg-section-heading"><?= esc($settings['markets_heading']) ?></h2>
            <?php endif; ?>
        </div>
        <div class="row g-3 justify-content-center">
            <?php $mktIdx = 0; foreach ($markets as $m): ?>
            <div class="col-6 col-sm-4 col-md-3 col-lg-auto" data-aos="zoom-in" data-aos-delay="<?= min($mktIdx++ * 75, 375) ?>">
                <div class="pg-industry-card">
                    <?php if (! empty($m['icon'])): ?>
                    <i class="bi <?= esc($m['icon']) ?> pg-industry-icon"></i>
                    <?php endif; ?>
                    <span class="pg-industry-name"><?= esc($m['title']) ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ========== WHY CHOOSE US ========== -->
<?php if (! empty($whyus)): ?>
<section class="pg-section">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <?php if (! empty($settings['whyus_eyebrow'])): ?>
            <span class="pg-eyebrow"><?= esc($settings['whyus_eyebrow']) ?></span>
            <?php endif; ?>
            <?php if (! empty($settings['whyus_heading'])): ?>
            <h2 class="pg-section-heading"><?= esc($settings['whyus_heading']) ?></h2>
            <?php endif; ?>
        </div>
        <div class="row g-4">
            <?php $wuIdx = 0; foreach ($whyus as $w): ?>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?= min($wuIdx++ * 100, 300) ?>">
                <div class="pg-why-card">
                    <?php if (! empty($w['icon'])): ?>
                    <div class="pg-why-num"><?= esc($w['icon']) ?></div>
                    <?php endif; ?>
                    <h5 class="pg-why-title"><?= esc($w['title']) ?></h5>
                    <?php if (! empty($w['body'])): ?>
                    <p class="pg-why-desc"><?= esc($w['body']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ========== CTA BANNER ========== -->
<section class="pg-cta-section" id="contact-cta">
    <div class="container text-center" data-aos="zoom-in" data-aos-duration="800">
        <?php if (! empty($settings['cta_eyebrow'])): ?>
        <span class="pg-eyebrow-light"><?= esc($settings['cta_eyebrow']) ?></span>
        <?php endif; ?>
        <?php if (! empty($settings['cta_title'])): ?>
        <h2 class="pg-cta-title mt-2"><?= nl2br(esc($settings['cta_title'])) ?></h2>
        <?php endif; ?>
        <?php if (! empty($settings['cta_subtitle'])): ?>
        <p class="pg-cta-subtitle"><?= esc($settings['cta_subtitle']) ?></p>
        <?php endif; ?>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <?php
            $waNum  = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '');
            $waLink = $waNum
                ? 'https://wa.me/' . $waNum . '?text=' . rawurlencode('Hi! I am interested in OEM manufacturing for a leather accessories collection. Can we discuss?')
                : 'https://wa.me/?text=' . rawurlencode('Hi! I am interested in OEM manufacturing for a leather accessories collection. Can we discuss?');
            ?>
            <?php if ($waNum || ! empty($settings['cta_whatsapp_text'])): ?>
            <a href="<?= $waLink ?>" class="btn pg-btn-whatsapp btn-lg px-4" target="_blank" rel="noopener">
                <i class="bi bi-whatsapp me-2"></i><?= esc($settings['cta_whatsapp_text'] ?? 'Chat on WhatsApp') ?>
            </a>
            <?php endif; ?>
            <?php if (! empty($settings['cta_browse_text'])): ?>
            <a href="<?= esc($settings['cta_browse_url'] ?? '#') ?>" class="btn pg-btn-outline-light btn-lg px-4">
                <i class="bi bi-grid me-2"></i><?= esc($settings['cta_browse_text']) ?>
            </a>
            <?php endif; ?>
        </div>
        <?php if (! empty($settings['cta_note'])): ?>
        <p class="mt-4 small pg-cta-note">
            <i class="bi bi-clock me-1"></i> <?= esc($settings['cta_note']) ?>
        </p>
        <?php endif; ?>
    </div>
</section>

<!-- Category filter script -->
<script>
document.querySelectorAll('.pg-cat-tab').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.pg-cat-tab').forEach(function(b) { b.classList.remove('active'); });
        this.classList.add('active');
        var filter = this.dataset.filter;
        document.querySelectorAll('.pg-cat-item').forEach(function(item) {
            item.style.display = (filter === 'all' || item.dataset.gender === filter) ? '' : 'none';
        });
    });
});
</script>

<?= $this->endSection() ?>
