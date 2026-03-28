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
?>
<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<!-- ========== HERO ========== -->
<section class="pg-inner-hero has-bg-img"
         style="background-image:url('https://images.unsplash.com/photo-1497366216548-37526070297c?w=1400&q=80');">
    <div class="pg-hero-overlay"></div>
    <div class="container position-relative z-1 text-center py-5">
        <nav aria-label="breadcrumb" class="pg-breadcrumb-nav mb-3">
            <ol class="breadcrumb justify-content-center pg-breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Contact Us</li>
            </ol>
        </nav>
        <h1 class="pg-inner-hero-title">Contact Us</h1>
        <p class="pg-inner-hero-subtitle">
            Reach out for samples, pricing, or to start an OEM partnership. We respond within 4 hours.
        </p>
    </div>
</section>

<?php if (session()->getFlashdata('enquiry_success')): ?>
<div class="container mt-4">
    <div class="alert alert-success alert-dismissible fade show py-3">
        <i class="bi bi-check-circle me-2"></i>
        <?= esc(session()->getFlashdata('enquiry_success')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('enquiry_error')): ?>
<div class="container mt-4">
    <div class="alert alert-danger alert-dismissible fade show py-3">
        <i class="bi bi-exclamation-circle me-2"></i>
        <?= session()->getFlashdata('enquiry_error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php endif; ?>

<!-- ========== CONTACT SECTION ========== -->
<section class="pg-section">
    <div class="container">
        <div class="row g-5 align-items-start">

            <!-- Contact Info -->
            <div class="col-lg-4" data-aos="fade-right">
                <span class="pg-eyebrow">Reach Us</span>
                <h2 class="pg-section-heading">Get in Touch</h2>
                <p class="pg-body-text mt-2 mb-4">
                    Whether you have a design brief, a sample request, or a general query —
                    our team is ready to help you move forward quickly.
                </p>

                <div class="pg-contact-info-list">

                    <?php if (!empty($settings['contact_address'])): ?>
                    <div class="pg-contact-info-item">
                        <div class="pg-contact-info-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div>
                            <div class="pg-contact-info-label">Address</div>
                            <div class="pg-contact-info-val"><?= nl2br(esc($settings['contact_address'])) ?></div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="pg-contact-info-item">
                        <div class="pg-contact-info-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div>
                            <div class="pg-contact-info-label">Address</div>
                            <div class="pg-contact-info-val">Kanpur, Uttar Pradesh — 208001, India</div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($settings['contact_phone'])): ?>
                    <div class="pg-contact-info-item">
                        <div class="pg-contact-info-icon"><i class="bi bi-telephone-fill"></i></div>
                        <div>
                            <div class="pg-contact-info-label">Phone</div>
                            <div class="pg-contact-info-val">
                                <a href="tel:<?= esc(preg_replace('/\s/', '', $settings['contact_phone'])) ?>"><?= esc($settings['contact_phone']) ?></a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($settings['enquiry_email'])): ?>
                    <div class="pg-contact-info-item">
                        <div class="pg-contact-info-icon"><i class="bi bi-envelope-fill"></i></div>
                        <div>
                            <div class="pg-contact-info-label">Email</div>
                            <div class="pg-contact-info-val">
                                <a href="mailto:<?= esc($settings['enquiry_email']) ?>"><?= esc($settings['enquiry_email']) ?></a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($settings['whatsapp_number'])): ?>
                    <div class="pg-contact-info-item">
                        <div class="pg-contact-info-icon pg-wa-icon"><i class="bi bi-whatsapp"></i></div>
                        <div>
                            <div class="pg-contact-info-label">WhatsApp</div>
                            <div class="pg-contact-info-val">
                                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $settings['whatsapp_number']) ?>?text=<?= rawurlencode('Hi! I would like to discuss an OEM order.') ?>"
                                   target="_blank" rel="noopener">
                                    <?= esc($settings['whatsapp_number']) ?> — Chat Now
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="pg-contact-info-item">
                        <div class="pg-contact-info-icon"><i class="bi bi-clock-fill"></i></div>
                        <div>
                            <div class="pg-contact-info-label">Business Hours</div>
                            <div class="pg-contact-info-val">Mon – Sat: 9:00 AM – 6:30 PM IST</div>
                        </div>
                    </div>

                </div>

                <!-- Social Links -->
                <div class="mt-4">
                    <div class="pg-contact-social-label">Follow Us</div>
                    <div class="d-flex gap-3 mt-2 pg-social-icons">
                        <?php if (!empty($settings['facebook_url'])): ?>
                        <a href="<?= esc($settings['facebook_url']) ?>" target="_blank" rel="noopener"><i class="bi bi-facebook"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($settings['instagram_url'])): ?>
                        <a href="<?= esc($settings['instagram_url']) ?>" target="_blank" rel="noopener"><i class="bi bi-instagram"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($settings['linkedin_url'])): ?>
                        <a href="<?= esc($settings['linkedin_url']) ?>" target="_blank" rel="noopener"><i class="bi bi-linkedin"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Enquiry Form -->
            <div class="col-lg-8" data-aos="fade-left">
                <div class="pg-contact-form-card">
                    <h4 class="pg-contact-form-title">Send Us an Enquiry</h4>
                    <p class="pg-body-text mb-4">
                        Fill in the form below and we'll get back to you within 4 hours during business hours.
                        For urgent requests, WhatsApp is fastest.
                    </p>

                    <form action="/enquiry/submit" method="post" novalidate>
                        <?= csrf_field() ?>
                        <input type="hidden" name="redirect_to" value="/contact">

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="pg-form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control pg-form-input"
                                       placeholder="Your full name" required
                                       value="<?= esc(old('name')) ?>">
                            </div>
                            <div class="col-sm-6">
                                <label class="pg-form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control pg-form-input"
                                       placeholder="your@email.com" required
                                       value="<?= esc(old('email')) ?>">
                            </div>
                            <div class="col-sm-6">
                                <label class="pg-form-label">Phone / WhatsApp</label>
                                <input type="tel" name="phone" class="form-control pg-form-input"
                                       placeholder="+91 98765 43210"
                                       value="<?= esc(old('phone')) ?>">
                            </div>
                            <div class="col-sm-6">
                                <label class="pg-form-label">Company / Brand Name</label>
                                <input type="text" name="company" class="form-control pg-form-input"
                                       placeholder="Your company name"
                                       value="<?= esc(old('company')) ?>">
                            </div>
                            <div class="col-12">
                                <label class="pg-form-label">Product / Category of Interest</label>
                                <select name="product_category" class="form-select pg-form-input">
                                    <option value="">-- Select a category --</option>
                                    <option value="Ladies Handbags">Ladies' Handbags</option>
                                    <option value="Ladies Wallets & Clutches">Ladies' Wallets &amp; Clutches</option>
                                    <option value="Sling & Crossbody Bags">Sling &amp; Crossbody Bags</option>
                                    <option value="Shopper & Tote Bags">Shopper &amp; Tote Bags</option>
                                    <option value="Mens Bags & Briefcases">Men's Bags &amp; Briefcases</option>
                                    <option value="Mens Wallets">Men's Wallets</option>
                                    <option value="Mens Belts">Men's Belts</option>
                                    <option value="Ladies Belts">Ladies' Belts</option>
                                    <option value="Travel & Duffel Bags">Travel &amp; Duffel Bags</option>
                                    <option value="Small Leather Goods">Small Leather Goods</option>
                                    <option value="Backpacks">Backpacks</option>
                                    <option value="Vegan & PU Collection">Vegan &amp; PU Collection</option>
                                    <option value="Other / Custom">Other / Custom</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="pg-form-label">Your Message / Enquiry</label>
                                <textarea name="message" class="form-control pg-form-input" rows="5"
                                          placeholder="Describe your requirements — quantity, materials, customisation, target market, etc."><?= esc(old('message')) ?></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn pg-btn-primary btn-lg px-5">
                                    <i class="bi bi-send me-2"></i>Send Enquiry
                                </button>
                                <p class="small text-muted mt-3 mb-0">
                                    <i class="bi bi-lock me-1"></i>Your information is kept strictly confidential.
                                    NDA available upon request before sample sharing.
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ========== MAP ========== -->
<section class="pg-map-section" data-aos="fade-up" data-aos-offset="50">
    <div class="pg-map-overlay-bar">
        <div class="container d-flex flex-wrap align-items-center gap-4 py-3">
            <div class="d-flex align-items-center gap-2 pg-map-info">
                <i class="bi bi-geo-alt-fill"></i>
                <span>Kanpur, Uttar Pradesh, India</span>
            </div>
            <div class="d-flex align-items-center gap-2 pg-map-info">
                <i class="bi bi-airplane-fill"></i>
                <span>Nearest Airport: Kanpur Civil Airport (KNU)</span>
            </div>
            <div class="d-flex align-items-center gap-2 pg-map-info">
                <i class="bi bi-train-front-fill"></i>
                <span>Kanpur Central Railway Station — 8 km</span>
            </div>
        </div>
    </div>
    <div class="pg-map-embed">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d229551.2767397009!2d79.97745325!3d26.44938925!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x399c4770b127c46f%3A0x1778302a9fbe7b41!2sKanpur%2C%20Uttar%20Pradesh!5e0!3m2!1sen!2sin!4v1680000000000!5m2!1sen!2sin"
            width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="Our location in Kanpur, India">
        </iframe>
    </div>
</section>

<!-- ========== WHATSAPP CTA ========== -->
<section class="pg-section pg-section-alt">
    <div class="container text-center" data-aos="zoom-in">
        <h3 class="pg-section-heading">Prefer to Chat Directly?</h3>
        <p class="pg-body-text mb-4">WhatsApp is the fastest way to share references, get quick pricing, and start the conversation.</p>
        <?php
        $waNum = !empty($settings['whatsapp_number'])
            ? preg_replace('/[^0-9]/', '', $settings['whatsapp_number'])
            : '';
        $waLink = $waNum
            ? "https://wa.me/{$waNum}?text=" . rawurlencode('Hi! I would like to discuss an OEM leather accessories order.')
            : "https://wa.me/?text=" . rawurlencode('Hi! I would like to discuss an OEM leather accessories order.');
        ?>
        <a href="<?= $waLink ?>" target="_blank" rel="noopener" class="btn pg-btn-whatsapp btn-lg px-5">
            <i class="bi bi-whatsapp me-2"></i>Chat on WhatsApp
        </a>
    </div>
</section>

<?= $this->endSection() ?>
