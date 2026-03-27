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

<!-- ========== HERO ========== -->
<section class="pg-inner-hero has-bg-img"
         style="background-image:url('<?= esc($settings['about_hero_bg_url'] ?? 'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?w=1400&q=80') ?>');">
    <div class="pg-hero-overlay"></div>
    <div class="container position-relative z-1 text-center py-5">
        <nav aria-label="breadcrumb" class="pg-breadcrumb-nav mb-3">
            <ol class="breadcrumb justify-content-center pg-breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">About Us</li>
            </ol>
        </nav>
        <h1 class="pg-inner-hero-title">About Us</h1>
        <?php if (! empty($settings['about_hero_subtitle'])): ?>
        <p class="pg-inner-hero-subtitle"><?= esc($settings['about_hero_subtitle']) ?></p>
        <?php endif; ?>
    </div>
</section>

<!-- ========== OUR STORY ========== -->
<section class="pg-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="pg-about-image-grid">
                    <div class="pg-about-img-main">
                        <img src="<?= esc($settings['about_story_main_image'] ?? 'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?w=700&q=80') ?>"
                             alt="Artisan hand-stitching leather">
                    </div>
                    <div class="pg-about-img-accent">
                        <img src="<?= esc($settings['about_story_accent_image'] ?? 'https://viale.in/wp-content/uploads/2022/10/VF-1100-1.png') ?>"
                             alt="Premium leather goods">
                    </div>
                    <div class="pg-about-badge">
                        <div class="pg-about-badge-num">20+</div>
                        <div class="pg-about-badge-label">Years of Artisan Heritage</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <span class="pg-eyebrow">Who We Are</span>
                <h2 class="pg-section-heading">Behind Every Piece,<br>A Story of Dedication</h2>
                <?php if (! empty($settings['about_story_body_1'])): ?>
                <p class="pg-body-text mt-3"><?= esc($settings['about_story_body_1']) ?></p>
                <?php endif; ?>
                <?php if (! empty($settings['about_story_body_2'])): ?>
                <p class="pg-body-text"><?= esc($settings['about_story_body_2']) ?></p>
                <?php endif; ?>
                <div class="row g-3 mt-2">
                    <div class="col-sm-6">
                        <div class="pg-check-item"><i class="bi bi-check2-circle"></i> Full-grain, top-grain &amp; suede</div>
                        <div class="pg-check-item mt-2"><i class="bi bi-check2-circle"></i> Vegan &amp; faux leather options</div>
                        <div class="pg-check-item mt-2"><i class="bi bi-check2-circle"></i> Custom hardware (YKK &amp; global)</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="pg-check-item"><i class="bi bi-check2-circle"></i> Private label &amp; buyer label</div>
                        <div class="pg-check-item mt-2"><i class="bi bi-check2-circle"></i> Low MOQ — from 50 pcs per style</div>
                        <div class="pg-check-item mt-2"><i class="bi bi-check2-circle"></i> Sample in 7–10 working days</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== MISSION & VISION ========== -->
<?php if (! empty($settings['about_mission']) || ! empty($settings['about_vision'])): ?>
<section class="pg-section pg-section-alt">
    <div class="container">
        <div class="text-center mb-5">
            <span class="pg-eyebrow">Our Purpose</span>
            <h2 class="pg-section-heading">Mission &amp; Vision</h2>
        </div>
        <div class="row g-4 justify-content-center">
            <?php if (! empty($settings['about_mission'])): ?>
            <div class="col-md-5">
                <div class="pg-mv-card pg-mv-mission">
                    <div class="pg-mv-icon"><i class="bi bi-bullseye"></i></div>
                    <h4 class="pg-mv-title">Our Mission</h4>
                    <p class="pg-mv-text"><?= esc($settings['about_mission']) ?></p>
                </div>
            </div>
            <?php endif; ?>
            <?php if (! empty($settings['about_vision'])): ?>
            <div class="col-md-5">
                <div class="pg-mv-card pg-mv-vision">
                    <div class="pg-mv-icon"><i class="bi bi-eye"></i></div>
                    <h4 class="pg-mv-title">Our Vision</h4>
                    <p class="pg-mv-text"><?= esc($settings['about_vision']) ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ========== MILESTONES / TIMELINE ========== -->
<?php if (! empty($timeline)): ?>
<section class="pg-section">
    <div class="container">
        <div class="text-center mb-5">
            <span class="pg-eyebrow">Our Journey</span>
            <h2 class="pg-section-heading">Two Decades of Growth</h2>
        </div>
        <div class="pg-timeline">
            <?php foreach ($timeline as $i => $entry): ?>
            <div class="pg-timeline-item <?= $i % 2 === 0 ? 'pg-timeline-left' : 'pg-timeline-right' ?>">
                <div class="pg-timeline-dot"></div>
                <div class="pg-timeline-content">
                    <?php if (! empty($entry['year'])): ?>
                    <div class="pg-timeline-year"><?= esc($entry['year']) ?></div>
                    <?php endif; ?>
                    <h5 class="pg-timeline-title"><?= esc($entry['title']) ?></h5>
                    <?php if (! empty($entry['body'])): ?>
                    <p class="pg-timeline-desc"><?= esc($entry['body']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ========== MANUFACTURING FACILITY ========== -->
<section class="pg-section pg-section-alt">
    <div class="container">
        <div class="row align-items-center g-5">
            <?php if (! empty($facilityPhotos)): ?>
            <div class="col-lg-6 order-lg-2">
                <div class="row g-3">
                    <?php foreach ($facilityPhotos as $photo): ?>
                    <div class="col-6">
                        <img src="<?= esc($photo['image_url'] ?? '') ?>"
                             alt="<?= esc($photo['subtitle'] ?? 'Manufacturing facility') ?>"
                             class="img-fluid rounded-3 w-100" style="height:200px;object-fit:cover;">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-lg-6 <?= ! empty($facilityPhotos) ? 'order-lg-1' : '' ?>">
                <span class="pg-eyebrow">Our Facility</span>
                <h2 class="pg-section-heading"><?= nl2br(esc($settings['about_facility_heading'] ?? 'Built for Scale. Designed for Quality.')) ?></h2>
                <?php if (! empty($settings['about_facility_body'])): ?>
                <p class="pg-body-text mt-3"><?= esc($settings['about_facility_body']) ?></p>
                <?php endif; ?>
                <?php if (! empty($facilityStats)): ?>
                <div class="row g-3 mt-3">
                    <?php foreach ($facilityStats as $stat): ?>
                    <div class="col-6">
                        <div class="pg-facility-stat">
                            <div class="pg-facility-num"><?= esc($stat['title']) ?></div>
                            <div class="pg-facility-label"><?= esc($stat['subtitle'] ?? '') ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- ========== TEAM ========== -->
<?php if (! empty($team)): ?>
<section class="pg-section">
    <div class="container">
        <div class="text-center mb-5">
            <span class="pg-eyebrow">Leadership</span>
            <h2 class="pg-section-heading">The People Behind the Craft</h2>
            <p class="pg-body-text mx-auto" style="max-width:520px;">
                Our leadership team brings together decades of experience in leather manufacturing,
                global trade, and brand development.
            </p>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach ($team as $member): ?>
            <div class="col-sm-6 col-lg-3">
                <div class="pg-team-card">
                    <div class="pg-team-avatar">
                        <img src="<?= esc($member['image_url'] ?? '') ?>"
                             alt="<?= esc($member['title']) ?>">
                    </div>
                    <div class="pg-team-info">
                        <div class="pg-team-name"><?= esc($member['title']) ?></div>
                        <div class="pg-team-role"><?= esc($member['subtitle'] ?? '') ?></div>
                        <?php if (! empty($member['body'])): ?>
                        <p class="pg-team-bio"><?= esc($member['body']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ========== CERTIFICATIONS ========== -->
<?php if (! empty($certifications)): ?>
<section class="pg-section pg-section-alt">
    <div class="container">
        <div class="text-center mb-5">
            <span class="pg-eyebrow">Compliance &amp; Trust</span>
            <h2 class="pg-section-heading">Certified. Audited. Trusted.</h2>
            <p class="pg-body-text mx-auto" style="max-width:560px;">
                Our certifications reflect our commitment to quality, ethics, and environmental
                responsibility — requirements for the world's most demanding retail buyers.
            </p>
        </div>
        <div class="row g-4">
            <?php foreach ($certifications as $cert): ?>
            <div class="col-sm-6 col-lg-3">
                <div class="pg-cert-card-full">
                    <?php if (! empty($cert['icon'])): ?>
                    <i class="bi <?= esc($cert['icon']) ?> pg-cert-icon-lg"></i>
                    <?php endif; ?>
                    <div class="pg-cert-name"><?= esc($cert['title']) ?></div>
                    <?php if (! empty($cert['body'])): ?>
                    <div class="pg-cert-body"><?= esc($cert['body']) ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ========== CTA ========== -->
<section class="pg-cta-section">
    <div class="container text-center">
        <span class="pg-eyebrow-light">Partner With Us</span>
        <h2 class="pg-cta-title mt-2">Ready to Start Your<br>OEM Journey?</h2>
        <p class="pg-cta-subtitle">Share your design, tech pack, or reference — we respond with a sample timeline and quote within 24 hours.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="/contact" class="btn pg-btn-primary btn-lg px-4">
                <i class="bi bi-envelope me-2"></i>Get in Touch
            </a>
            <a href="/products" class="btn pg-btn-outline-light btn-lg px-4">
                <i class="bi bi-grid me-2"></i>Browse Products
            </a>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
