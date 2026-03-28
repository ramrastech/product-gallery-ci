<?php
/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */
$storyChecks = array_filter(array_map('trim', explode("\n", $settings['about_story_checks'] ?? '')));
?>
<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<!-- ========== HERO ========== -->
<section class="pg-inner-hero has-bg-img"
         <?php if (! empty($settings['about_hero_bg_url'])): ?>
         style="background-image:url('<?= esc($settings['about_hero_bg_url']) ?>');"
         <?php endif; ?>>
    <div class="pg-hero-overlay"></div>
    <div class="container position-relative z-1 text-center py-5">
        <nav aria-label="breadcrumb" class="pg-breadcrumb-nav mb-3">
            <ol class="breadcrumb justify-content-center pg-breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">About Us</li>
            </ol>
        </nav>
        <h1 class="pg-inner-hero-title"><?= esc($settings['about_hero_title'] ?? 'About Us') ?></h1>
        <?php if (! empty($settings['about_hero_subtitle'])): ?>
        <p class="pg-inner-hero-subtitle"><?= esc($settings['about_hero_subtitle']) ?></p>
        <?php endif; ?>
    </div>
</section>

<!-- ========== OUR STORY ========== -->
<?php if (! empty($settings['about_story_eyebrow']) || ! empty($settings['about_story_heading']) || ! empty($settings['about_story_body_1'])): ?>
<section class="pg-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <?php if (! empty($settings['about_story_main_image']) || ! empty($settings['about_story_accent_image'])): ?>
            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="900">
                <div class="pg-about-image-grid">
                    <?php if (! empty($settings['about_story_main_image'])): ?>
                    <div class="pg-about-img-main">
                        <img src="<?= esc($settings['about_story_main_image']) ?>" alt="Artisan crafting leather">
                    </div>
                    <?php endif; ?>
                    <?php if (! empty($settings['about_story_accent_image'])): ?>
                    <div class="pg-about-img-accent">
                        <img src="<?= esc($settings['about_story_accent_image']) ?>" alt="Premium leather goods">
                    </div>
                    <?php endif; ?>
                    <?php if (! empty($settings['about_story_badge_num'])): ?>
                    <div class="pg-about-badge">
                        <div class="pg-about-badge-num"><?= esc($settings['about_story_badge_num']) ?></div>
                        <div class="pg-about-badge-label"><?= esc($settings['about_story_badge_label'] ?? '') ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="900">
                <?php if (! empty($settings['about_story_eyebrow'])): ?>
                <span class="pg-eyebrow"><?= esc($settings['about_story_eyebrow']) ?></span>
                <?php endif; ?>
                <?php if (! empty($settings['about_story_heading'])): ?>
                <h2 class="pg-section-heading"><?= nl2br(esc($settings['about_story_heading'])) ?></h2>
                <?php endif; ?>
                <?php if (! empty($settings['about_story_body_1'])): ?>
                <p class="pg-body-text mt-3"><?= esc($settings['about_story_body_1']) ?></p>
                <?php endif; ?>
                <?php if (! empty($settings['about_story_body_2'])): ?>
                <p class="pg-body-text"><?= esc($settings['about_story_body_2']) ?></p>
                <?php endif; ?>
                <?php if (! empty($storyChecks)): ?>
                <div class="row g-3 mt-2">
                    <?php
                    $half = ceil(count($storyChecks) / 2);
                    $col1 = array_slice($storyChecks, 0, $half);
                    $col2 = array_slice($storyChecks, $half);
                    ?>
                    <div class="col-sm-6">
                        <?php foreach ($col1 as $i => $check): ?>
                        <div class="pg-check-item <?= $i > 0 ? 'mt-2' : '' ?>"><i class="bi bi-check2-circle"></i> <?= esc($check) ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-sm-6">
                        <?php foreach ($col2 as $i => $check): ?>
                        <div class="pg-check-item <?= $i > 0 ? 'mt-2' : '' ?>"><i class="bi bi-check2-circle"></i> <?= esc($check) ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ========== MISSION & VISION ========== -->
<?php if (! empty($settings['about_mission']) || ! empty($settings['about_vision'])): ?>
<section class="pg-section pg-section-alt">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <?php if (! empty($settings['about_mission_eyebrow'])): ?>
            <span class="pg-eyebrow"><?= esc($settings['about_mission_eyebrow']) ?></span>
            <?php endif; ?>
            <?php if (! empty($settings['about_mission_heading'])): ?>
            <h2 class="pg-section-heading"><?= esc($settings['about_mission_heading']) ?></h2>
            <?php endif; ?>
        </div>
        <div class="row g-4 justify-content-center">
            <?php if (! empty($settings['about_mission'])): ?>
            <div class="col-md-5" data-aos="fade-right">
                <div class="pg-mv-card pg-mv-mission">
                    <div class="pg-mv-icon"><i class="bi bi-bullseye"></i></div>
                    <h4 class="pg-mv-title">Our Mission</h4>
                    <p class="pg-mv-text"><?= esc($settings['about_mission']) ?></p>
                </div>
            </div>
            <?php endif; ?>
            <?php if (! empty($settings['about_vision'])): ?>
            <div class="col-md-5" data-aos="fade-left">
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
        <div class="text-center mb-5" data-aos="fade-up">
            <?php if (! empty($settings['about_timeline_eyebrow'])): ?>
            <span class="pg-eyebrow"><?= esc($settings['about_timeline_eyebrow']) ?></span>
            <?php endif; ?>
            <?php if (! empty($settings['about_timeline_heading'])): ?>
            <h2 class="pg-section-heading"><?= esc($settings['about_timeline_heading']) ?></h2>
            <?php endif; ?>
        </div>
        <div class="pg-timeline">
            <?php foreach ($timeline as $i => $entry): ?>
            <div class="pg-timeline-item <?= $i % 2 === 0 ? 'pg-timeline-left' : 'pg-timeline-right' ?>" data-aos="<?= $i % 2 === 0 ? 'fade-right' : 'fade-left' ?>" data-aos-delay="<?= min($i * 100, 400) ?>">
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
<?php if (! empty($facilityPhotos) || ! empty($settings['about_facility_heading']) || ! empty($settings['about_facility_body']) || ! empty($facilityStats)): ?>
<section class="pg-section pg-section-alt">
    <div class="container">
        <div class="row align-items-center g-5">
            <?php if (! empty($facilityPhotos)): ?>
            <div class="col-lg-6 order-lg-2" data-aos="fade-left">
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
            <div class="col-lg-6 <?= ! empty($facilityPhotos) ? 'order-lg-1' : '' ?>" data-aos="fade-right">
                <?php if (! empty($settings['about_facility_eyebrow'])): ?>
                <span class="pg-eyebrow"><?= esc($settings['about_facility_eyebrow']) ?></span>
                <?php endif; ?>
                <?php if (! empty($settings['about_facility_heading'])): ?>
                <h2 class="pg-section-heading"><?= nl2br(esc($settings['about_facility_heading'])) ?></h2>
                <?php endif; ?>
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
<?php endif; ?>

<!-- ========== TEAM ========== -->
<?php if (! empty($team)): ?>
<section class="pg-section">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <?php if (! empty($settings['about_team_eyebrow'])): ?>
            <span class="pg-eyebrow"><?= esc($settings['about_team_eyebrow']) ?></span>
            <?php endif; ?>
            <?php if (! empty($settings['about_team_heading'])): ?>
            <h2 class="pg-section-heading"><?= esc($settings['about_team_heading']) ?></h2>
            <?php endif; ?>
            <?php if (! empty($settings['about_team_body'])): ?>
            <p class="pg-body-text mx-auto" style="max-width:520px;"><?= esc($settings['about_team_body']) ?></p>
            <?php endif; ?>
        </div>
        <div class="row g-4 justify-content-center">
            <?php $tmIdx = 0; foreach ($team as $member): ?>
            <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?= min($tmIdx++ * 100, 300) ?>">
                <div class="pg-team-card">
                    <div class="pg-team-avatar">
                        <img src="<?= esc($member['image_url'] ?? '') ?>" alt="<?= esc($member['title']) ?>">
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
        <div class="text-center mb-5" data-aos="fade-up">
            <?php if (! empty($settings['about_cert_eyebrow'])): ?>
            <span class="pg-eyebrow"><?= esc($settings['about_cert_eyebrow']) ?></span>
            <?php endif; ?>
            <?php if (! empty($settings['about_cert_heading'])): ?>
            <h2 class="pg-section-heading"><?= esc($settings['about_cert_heading']) ?></h2>
            <?php endif; ?>
            <?php if (! empty($settings['about_cert_body'])): ?>
            <p class="pg-body-text mx-auto" style="max-width:560px;"><?= esc($settings['about_cert_body']) ?></p>
            <?php endif; ?>
        </div>
        <div class="row g-4">
            <?php $certIdx = 0; foreach ($certifications as $cert): ?>
            <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?= min($certIdx++ * 100, 300) ?>">
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
<?php if (! empty($settings['about_cta_title']) || ! empty($settings['about_cta_primary_text'])): ?>
<section class="pg-cta-section">
    <div class="container text-center" data-aos="zoom-in" data-aos-duration="800">
        <?php if (! empty($settings['about_cta_eyebrow'])): ?>
        <span class="pg-eyebrow-light"><?= esc($settings['about_cta_eyebrow']) ?></span>
        <?php endif; ?>
        <?php if (! empty($settings['about_cta_title'])): ?>
        <h2 class="pg-cta-title mt-2"><?= nl2br(esc($settings['about_cta_title'])) ?></h2>
        <?php endif; ?>
        <?php if (! empty($settings['about_cta_subtitle'])): ?>
        <p class="pg-cta-subtitle"><?= esc($settings['about_cta_subtitle']) ?></p>
        <?php endif; ?>
        <?php if (! empty($settings['about_cta_primary_text']) || ! empty($settings['about_cta_secondary_text'])): ?>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <?php if (! empty($settings['about_cta_primary_text'])): ?>
            <a href="<?= esc($settings['about_cta_primary_url'] ?? '#') ?>" class="btn pg-btn-primary btn-lg px-4">
                <i class="bi bi-envelope me-2"></i><?= esc($settings['about_cta_primary_text']) ?>
            </a>
            <?php endif; ?>
            <?php if (! empty($settings['about_cta_secondary_text'])): ?>
            <a href="<?= esc($settings['about_cta_secondary_url'] ?? '#') ?>" class="btn pg-btn-outline-light btn-lg px-4">
                <i class="bi bi-grid me-2"></i><?= esc($settings['about_cta_secondary_text']) ?>
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<?= $this->endSection() ?>
