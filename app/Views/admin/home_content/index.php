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
    <p class="text-muted mb-0 small">Manage dynamic content blocks displayed on the home page.</p>
    <a href="/admin/home-content/settings" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-sliders me-1"></i> Text Settings
    </a>
</div>

<div class="row g-3">
    <!-- Story Section — managed via Text Settings -->
    <div class="col-md-4">
        <div class="card h-100" style="border-style:dashed;">
            <div class="card-body d-flex flex-column gap-2">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">Story / About Snippet</h6>
                    <span class="badge" style="background:rgba(99,102,241,.12);color:var(--accent);">Settings</span>
                </div>
                <p class="text-muted small mb-0">Images, heading, body text &amp; CTA — managed in Text Settings.</p>
                <div class="mt-auto pt-2">
                    <a href="/admin/home-content/settings#story" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-sliders me-1"></i> Edit in Text Settings
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products — managed via Text Settings -->
    <div class="col-md-4">
        <div class="card h-100" style="border-style:dashed;">
            <div class="card-body d-flex flex-column gap-2">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">Featured Products</h6>
                    <span class="badge" style="background:rgba(99,102,241,.12);color:var(--accent);">Settings</span>
                </div>
                <p class="text-muted small mb-0">Eyebrow &amp; heading — managed in Text Settings. Items come from the Products catalog (featured flag).</p>
                <div class="mt-auto pt-2">
                    <a href="/admin/home-content/settings#featured" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-sliders me-1"></i> Edit in Text Settings
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php foreach ($sectionLabels as $key => $label): ?>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body d-flex flex-column gap-2">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0"><?= esc($label) ?></h6>
                    <span class="badge" style="background: rgba(99,102,241,0.15); color: var(--accent);">
                        <?= $counts[$key] ?> active
                    </span>
                </div>
                <p class="text-muted small mb-0">Section: <code><?= esc($key) ?></code></p>
                <div class="mt-auto pt-2">
                    <a href="/admin/home-content/section/<?= esc($key) ?>" class="btn btn-sm btn-primary">
                        <i class="bi bi-grid me-1"></i> Manage Items
                    </a>
                    <a href="/admin/home-content/item/new/<?= esc($key) ?>" class="btn btn-sm btn-outline-secondary ms-1">
                        <i class="bi bi-plus"></i> Add
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
