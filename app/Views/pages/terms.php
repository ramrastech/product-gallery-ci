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

<section class="pg-inner-hero" style="background:var(--pg-primary);min-height:220px;">
    <div class="container position-relative z-1 text-center py-5">
        <nav aria-label="breadcrumb" class="pg-breadcrumb-nav mb-3">
            <ol class="breadcrumb justify-content-center pg-breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Terms &amp; Conditions</li>
            </ol>
        </nav>
        <h1 class="pg-inner-hero-title"><?= esc($pageContent['hero_title'] ?? 'Terms &amp; Conditions') ?></h1>
        <p class="pg-inner-hero-subtitle">
            Last updated: <?= ! empty($pageContent['last_updated']) ? date('d F Y', strtotime($pageContent['last_updated'])) : date('d F Y') ?>
        </p>
    </div>
</section>

<section class="pg-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="pg-legal-doc">

                    <?php if (! empty($pageContent['content'])): ?>
                        <?= $pageContent['content'] ?>
                    <?php endif; ?>

                    <h2>Contact Us</h2>
                    <p>For questions about these Terms &amp; Conditions:</p>
                    <div class="pg-legal-contact">
                        <p>
                            <strong><?= esc($settings['site_name'] ?? 'Product Gallery') ?></strong><br>
                            <?php if (! empty($settings['contact_address'])): ?>
                            <?= nl2br(esc($settings['contact_address'])) ?><br>
                            <?php else: ?>
                            Kanpur, Uttar Pradesh — 208001, India<br>
                            <?php endif; ?>
                            <?php if (! empty($settings['enquiry_email'])): ?>
                            Email: <a href="mailto:<?= esc($settings['enquiry_email']) ?>"><?= esc($settings['enquiry_email']) ?></a>
                            <?php endif; ?>
                        </p>
                    </div>

                </div>

                <div class="text-center mt-5">
                    <a href="/contact" class="btn pg-btn-primary px-4">Contact Us</a>
                    <a href="/privacy" class="btn btn-outline-secondary ms-2 px-4">Privacy Policy</a>
                </div>

            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
