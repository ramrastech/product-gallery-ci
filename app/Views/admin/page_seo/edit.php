<?php
/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */
?>
<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="mb-3">
    <a href="/admin/page-seo" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Back to SEO Manager
    </a>
</div>

<form action="/admin/page-seo/save/<?= esc($pageKey) ?>" method="post">
    <?= csrf_field() ?>
    <div class="row g-4">

        <!-- Primary Meta -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header py-3 px-4"><h6 class="mb-0">Primary SEO Tags<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="These tags control how this page appears in Google search results."></i></h6></div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Meta Title <small class="text-muted">(max 70 chars recommended)</small><i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Shown in the browser tab and as the clickable headline in Google search results. Keep under 70 characters."></i></label>
                        <input type="text" name="meta_title" id="metaTitle" class="form-control"
                               value="<?= esc($seo['meta_title'] ?? '') ?>" maxlength="120">
                        <div class="form-text"><span id="titleCount">0</span>/70 characters</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Description <small class="text-muted">(max 160 chars recommended)</small><i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="The summary text shown beneath the title in Google search results. Aim for 120–160 characters."></i></label>
                        <textarea name="meta_description" id="metaDesc" class="form-control" rows="3" maxlength="300"><?= esc($seo['meta_description'] ?? '') ?></textarea>
                        <div class="form-text"><span id="descCount">0</span>/160 characters</div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Meta Keywords <small class="text-muted">(comma separated)</small><i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Comma-separated keywords related to this page. Less critical for modern SEO but still good practice."></i></label>
                        <input type="text" name="meta_keywords" class="form-control"
                               value="<?= esc($seo['meta_keywords'] ?? '') ?>" placeholder="keyword1, keyword2, ...">
                    </div>
                </div>
            </div>

            <!-- Open Graph -->
            <div class="card mb-4">
                <div class="card-header py-3 px-4"><h6 class="mb-0">Open Graph (Social Sharing)<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Controls how this page looks when shared on Facebook, LinkedIn, WhatsApp, and other social platforms."></i></h6></div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label">OG Title <small class="text-muted">(leave blank to use Meta Title)</small><i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="The headline shown in social media link previews. Defaults to your Meta Title if left blank."></i></label>
                        <input type="text" name="og_title" class="form-control" value="<?= esc($seo['og_title'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">OG Description <small class="text-muted">(leave blank to use Meta Description)</small><i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="The description shown in social media link previews. Defaults to your Meta Description if left blank."></i></label>
                        <textarea name="og_description" class="form-control" rows="2"><?= esc($seo['og_description'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">OG Image URL<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="The preview image shown when this page is shared on social media. Recommended size: 1200×630px. Use an absolute URL or an upload path."></i></label>
                        <input type="url" name="og_image" class="form-control"
                               value="<?= esc($seo['og_image'] ?? '') ?>" placeholder="https://... or /uploads/media/og/image.jpg">
                        <div class="form-text">Recommended size: 1200×630px. Use an absolute URL.</div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">OG Type<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="The type of content. Use 'website' for most pages, 'article' for blog/news pages, 'product' for product pages."></i></label>
                        <select name="og_type" class="form-select">
                            <?php foreach (['website', 'article', 'product'] as $type): ?>
                            <option value="<?= $type ?>" <?= ($seo['og_type'] ?? 'website') === $type ? 'selected' : '' ?>><?= $type ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Robots & Canonical -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header py-3 px-4"><h6 class="mb-0">Robots & Indexing<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Controls whether search engines can index this page and follow its links."></i></h6></div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Robots Meta<i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="'Index + Follow' is the default for all public pages. Use 'No Index' only for pages you want to hide from Google."></i></label>
                        <select name="robots" class="form-select">
                            <?php
                            $robotOptions = [
                                'index, follow'                  => 'Index + Follow (default)',
                                'noindex, follow'                => 'No Index, Follow',
                                'index, nofollow'                => 'Index, No Follow',
                                'noindex, nofollow'              => 'No Index, No Follow',
                                'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1' => 'Full (with snippet control)',
                            ];
                            foreach ($robotOptions as $val => $label): ?>
                            <option value="<?= esc($val) ?>" <?= ($seo['robots'] ?? 'index, follow') === $val ? 'selected' : '' ?>>
                                <?= esc($label) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Canonical URL <small class="text-muted">(optional override)</small><i class="bi bi-question-circle help-tip" data-bs-toggle="tooltip" title="Prevents duplicate content issues. Leave blank to automatically use the current page URL."></i></label>
                        <input type="url" name="canonical" class="form-control"
                               value="<?= esc($seo['canonical'] ?? '') ?>" placeholder="https://yourdomain.com/page">
                        <div class="form-text">Leave blank to use the current page URL.</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <div class="alert alert-info py-2 px-3 small mb-3">
                        <i class="bi bi-info-circle me-1"></i>
                        These settings override the defaults for <strong><?= esc($pageLabel) ?></strong>.
                    </div>
                    <button type="submit" class="btn btn-primary d-grid w-100">
                        <i class="bi bi-check-lg me-1"></i>Save SEO Settings
                    </button>
                    <a href="/admin/page-seo" class="btn btn-outline-secondary d-grid w-100 mt-2">Cancel</a>
                </div>
            </div>
        </div>

    </div>
</form>

<?= $this->section('scripts') ?>
<script>
// Character counters
function updateCount(inputId, countId, limit) {
    var el = document.getElementById(inputId);
    var cnt = document.getElementById(countId);
    if (!el || !cnt) return;
    function update() {
        var len = el.value.length;
        cnt.textContent = len;
        cnt.style.color = len > limit ? '#ef4444' : 'inherit';
    }
    el.addEventListener('input', update);
    update();
}
updateCount('metaTitle', 'titleCount', 70);
updateCount('metaDesc', 'descCount', 160);
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
