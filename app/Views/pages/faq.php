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

<section class="pg-inner-hero has-bg-img"
         style="background-image:url('<?= esc($settings['faq_hero_bg_url'] ?? 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=1400&q=80') ?>');">
    <div class="pg-hero-overlay"></div>
    <div class="container position-relative z-1 text-center py-5">
        <nav aria-label="breadcrumb" class="pg-breadcrumb-nav mb-3">
            <ol class="breadcrumb justify-content-center pg-breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">FAQ</li>
            </ol>
        </nav>
        <h1 class="pg-inner-hero-title">Frequently Asked Questions</h1>
        <?php if (! empty($settings['faq_hero_subtitle'])): ?>
        <p class="pg-inner-hero-subtitle"><?= esc($settings['faq_hero_subtitle']) ?></p>
        <?php endif; ?>
    </div>
</section>

<section class="pg-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <?php if (! empty($faqGroups)): ?>

                <!-- FAQ Category Tabs -->
                <ul class="nav pg-faq-tabs mb-5" id="faqTabs" data-aos="fade-up">
                    <?php foreach ($faqGroups as $i => $group): ?>
                    <li class="nav-item">
                        <button class="pg-faq-tab <?= $i === 0 ? 'active' : '' ?>"
                                data-bs-toggle="tab"
                                data-bs-target="#faq-tab-<?= (int) $group['category']['id'] ?>">
                            <?= esc($group['category']['name']) ?>
                        </button>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <div class="tab-content">
                    <?php foreach ($faqGroups as $i => $group):
                        $catId = (int) $group['category']['id'];
                    ?>
                    <div class="tab-pane fade <?= $i === 0 ? 'show active' : '' ?>" id="faq-tab-<?= $catId ?>">
                        <div class="accordion pg-faq-accordion" id="faqAcc<?= $catId ?>" data-aos="fade-up" data-aos-delay="100">
                            <?php foreach ($group['items'] as $j => $faq): ?>
                            <div class="accordion-item pg-faq-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button pg-faq-q <?= $j > 0 ? 'collapsed' : '' ?>"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#faqA<?= $catId ?>-<?= $j ?>"
                                            aria-expanded="<?= $j === 0 ? 'true' : 'false' ?>">
                                        <?= esc($faq['question']) ?>
                                    </button>
                                </h2>
                                <div id="faqA<?= $catId ?>-<?= $j ?>"
                                     class="accordion-collapse collapse <?= $j === 0 ? 'show' : '' ?>"
                                     data-bs-parent="#faqAcc<?= $catId ?>">
                                    <div class="accordion-body pg-faq-a">
                                        <?= $faq['answer'] ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-question-circle display-3 text-muted"></i>
                    <p class="mt-3 text-muted">No FAQ items yet. <a href="/admin/faq">Add them in Admin.</a></p>
                </div>
                <?php endif; ?>

                <!-- Still have questions -->
                <div class="pg-faq-cta mt-5" data-aos="zoom-in">
                    <i class="bi bi-chat-dots-fill pg-faq-cta-icon"></i>
                    <h5>Still have a question?</h5>
                    <p>Our team responds to all enquiries within 4 hours during business hours.</p>
                    <div class="d-flex flex-wrap justify-content-center gap-3 mt-3">
                        <a href="/contact" class="btn pg-btn-primary px-4">
                            <i class="bi bi-envelope me-2"></i>Send Us a Message
                        </a>
                        <?php
                        $waNum  = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '');
                        $waLink = $waNum
                            ? 'https://wa.me/' . $waNum . '?text=' . rawurlencode('Hi! I have a question about your OEM leather goods manufacturing.')
                            : 'https://wa.me/?text=' . rawurlencode('Hi! I have a question about your OEM leather goods manufacturing.');
                        ?>
                        <a href="<?= $waLink ?>" target="_blank" rel="noopener" class="btn pg-btn-whatsapp px-4">
                            <i class="bi bi-whatsapp me-2"></i>WhatsApp Us
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?= $this->section('scripts') ?>
<script>
document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function(btn) {
    btn.addEventListener('shown.bs.tab', function() {
        document.querySelectorAll('.pg-faq-tab').forEach(function(t) { t.classList.remove('active'); });
        btn.classList.add('active');
    });
});
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
