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
<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<form action="/admin/settings/save" method="post">
    <?= csrf_field() ?>
    <div class="row g-4">

        <!-- Site Identity -->
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header py-3 px-4"><h6 class="mb-0"><i class="bi bi-globe2 me-2 text-primary"></i>Site Identity</h6></div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Logo URL<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="URL to your logo image (.png, .svg, .webp). Displayed in the site navbar. If blank, site name text is shown."></i></label>
                            <input type="url" name="logo_url" class="form-control" value="<?= esc($settings['logo_url'] ?? '') ?>" placeholder="https://... or /uploads/...">
                            <?php if (! empty($settings['logo_url'])): ?>
                            <div class="mt-2">
                                <img src="<?= esc($settings['logo_url']) ?>" alt="Logo preview" style="max-height:40px; max-width:160px; object-fit:contain; background:rgba(255,255,255,.08); border-radius:4px; padding:4px;">
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Favicon URL<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="URL to your favicon (.ico, .png, .svg). Shown in browser tabs and bookmarks."></i></label>
                            <input type="url" name="favicon_url" class="form-control" value="<?= esc($settings['favicon_url'] ?? '') ?>" placeholder="https://... or /favicon.ico">
                            <?php if (! empty($settings['favicon_url'])): ?>
                            <div class="mt-2 d-flex align-items-center gap-2">
                                <img src="<?= esc($settings['favicon_url']) ?>" alt="Favicon preview" style="width:24px;height:24px;object-fit:contain;">
                                <span class="small text-muted">Current favicon</span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Site Name<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Your business name shown in the browser title bar, site header, and outgoing emails."></i></label>
                            <input type="text" name="site_name" class="form-control" value="<?= esc($settings['site_name'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Site Tagline<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="A short brand slogan shown beneath the logo in the site header."></i></label>
                            <input type="text" name="site_tagline" class="form-control" value="<?= esc($settings['site_tagline'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Site Info -->
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header py-3 px-4"><h6 class="mb-0">Contact &amp; Hero</h6></div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Hero Title<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="The large headline displayed in the homepage banner/hero section."></i></label>
                        <input type="text" name="hero_title" class="form-control" value="<?= esc($settings['hero_title'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hero Subtitle<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Supporting text shown beneath the Hero Title in the homepage banner."></i></label>
                        <input type="text" name="hero_subtitle" class="form-control" value="<?= esc($settings['hero_subtitle'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Phone<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Displayed in the website footer and on the Contact page."></i></label>
                        <input type="text" name="contact_phone" class="form-control" value="<?= esc($settings['contact_phone'] ?? '') ?>">
                    </div>
                    <div>
                        <label class="form-label">Contact Address<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Your business address shown in the footer and on the Contact page."></i></label>
                        <textarea name="contact_address" class="form-control" rows="2"><?= esc($settings['contact_address'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="card">
                <div class="card-header py-3 px-4"><h6 class="mb-0">Social Media Links</h6></div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-facebook me-1" style="color:#1877f2;"></i>Facebook URL</label>
                        <input type="url" name="facebook_url" class="form-control" value="<?= esc($settings['facebook_url'] ?? '') ?>" placeholder="https://facebook.com/yourpage">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-instagram me-1" style="color:#e1306c;"></i>Instagram URL</label>
                        <input type="url" name="instagram_url" class="form-control" value="<?= esc($settings['instagram_url'] ?? '') ?>" placeholder="https://instagram.com/yourhandle">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-linkedin me-1" style="color:#0077b5;"></i>LinkedIn URL</label>
                        <input type="url" name="linkedin_url" class="form-control" value="<?= esc($settings['linkedin_url'] ?? '') ?>">
                    </div>
                    <div>
                        <label class="form-label"><i class="bi bi-twitter-x me-1"></i>Twitter/X URL</label>
                        <input type="url" name="twitter_url" class="form-control" value="<?= esc($settings['twitter_url'] ?? '') ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- Marketing / Integrations -->
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header py-3 px-4"><h6 class="mb-0">Enquiry Settings</h6></div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Enquiry Notification Email<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Every new enquiry submitted on the site will be sent to this email address."></i></label>
                        <input type="email" name="enquiry_email" class="form-control" value="<?= esc($settings['enquiry_email'] ?? '') ?>"
                               placeholder="you@yourdomain.com">
                        <div class="form-text text-muted">New enquiries will be sent here.</div>
                    </div>
                    <div>
                        <label class="form-label"><i class="bi bi-whatsapp me-1" style="color:#25d366;"></i>WhatsApp Number<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Used for the WhatsApp enquiry button on product pages. Format: country code + number with no + sign (e.g. 919876543210)."></i></label>
                        <input type="text" name="whatsapp_number" class="form-control" value="<?= esc($settings['whatsapp_number'] ?? '') ?>"
                               placeholder="919876543210 (country code, no +)">
                        <div class="form-text text-muted">Used for the WhatsApp enquiry button on product pages.</div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header py-3 px-4"><h6 class="mb-0">Analytics & Tracking</h6></div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-bar-chart me-1" style="color:#e37400;"></i>Google Analytics 4 ID<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Your GA4 Measurement ID (starts with G-). Tracks site visitors and behaviour. Leave blank to disable analytics."></i></label>
                        <input type="text" name="ga_tracking_id" class="form-control" value="<?= esc($settings['ga_tracking_id'] ?? '') ?>"
                               placeholder="G-XXXXXXXXXX">
                        <div class="form-text text-muted">Leave blank to disable tracking.</div>
                    </div>
                    <div>
                        <label class="form-label"><i class="bi bi-meta me-1" style="color:#0082fb;"></i>Meta Pixel ID<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Your Facebook/Meta Pixel ID for ad conversion tracking. Found in Meta Events Manager. Leave blank to disable."></i></label>
                        <input type="text" name="meta_pixel_id" class="form-control" value="<?= esc($settings['meta_pixel_id'] ?? '') ?>"
                               placeholder="1234567890123456">
                        <div class="form-text text-muted">Leave blank to disable Meta Pixel.</div>
                    </div>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Save All Settings
                </button>
            </div>
        </div>

    </div>
</form>

<?= $this->endSection() ?>
