<?php
/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */
?>
<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div class="d-flex gap-2">
        <a href="/admin/page-content/privacy"
           class="btn btn-sm <?= $pageKey === 'privacy' ? 'btn-primary' : 'btn-outline-secondary' ?>">
            Privacy Policy
        </a>
        <a href="/admin/page-content/terms"
           class="btn btn-sm <?= $pageKey === 'terms' ? 'btn-primary' : 'btn-outline-secondary' ?>">
            Terms & Conditions
        </a>
    </div>
    <?php if (!empty($content['last_updated'])): ?>
        <small class="text-muted">Last updated: <?= esc($content['last_updated']) ?></small>
    <?php endif; ?>
</div>

<div class="card" style="max-width:900px;">
    <div class="card-body">
        <form method="post" action="/admin/page-content/<?= esc($pageKey) ?>/save">
            <?= csrf_field() ?>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Hero Title</label>
                    <input type="text" name="hero_title" class="form-control form-control-sm"
                           value="<?= esc($content['hero_title'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Hero Subtitle</label>
                    <input type="text" name="hero_subtitle" class="form-control form-control-sm"
                           value="<?= esc($content['hero_subtitle'] ?? '') ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Page Content <small class="text-muted">(HTML supported)</small></label>
                    <textarea name="content" class="form-control form-control-sm" rows="20"
                              style="font-family: monospace; font-size: 0.82rem;"><?= esc($content['content'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-check-lg me-1"></i> Save <?= esc($pageLabel) ?>
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
