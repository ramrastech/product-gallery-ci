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

<div class="row g-4">
    <?php foreach ($themes as $theme): ?>
    <div class="col-md-4">
        <div class="card <?= $activeTheme === $theme['id'] ? 'border-primary' : '' ?>" style="border-width: <?= $activeTheme === $theme['id'] ? '2px' : '1px' ?>;">

            <!-- Theme Preview -->
            <div style="height: 160px; background: <?= $theme['preview_bg'] ?>; border-radius: 0.375rem 0.375rem 0 0; padding: 16px; position:relative; overflow:hidden;">
                <!-- Mock navbar -->
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                    <div style="width:80px; height:8px; background:<?= $theme['preview_accent'] ?>; border-radius:4px; opacity:0.9;"></div>
                    <div style="display:flex; gap:8px;">
                        <div style="width:30px; height:6px; background:<?= $theme['preview_accent'] ?>; border-radius:3px; opacity:0.4;"></div>
                        <div style="width:30px; height:6px; background:<?= $theme['preview_accent'] ?>; border-radius:3px; opacity:0.4;"></div>
                        <div style="width:30px; height:6px; background:<?= $theme['preview_accent'] ?>; border-radius:3px; opacity:0.4;"></div>
                    </div>
                </div>
                <!-- Mock hero -->
                <div style="background:<?= $theme['preview_accent'] ?>; border-radius:6px; padding:12px; opacity:0.15; height:50px;"></div>
                <!-- Mock cards -->
                <div style="display:flex; gap:6px; margin-top:8px;">
                    <?php for ($i = 0; $i < 3; $i++): ?>
                    <div style="flex:1; background:<?= $theme['preview_accent'] ?>; border-radius:4px; height:30px; opacity:<?= 0.08 + ($i * 0.04) ?>;"></div>
                    <?php endfor; ?>
                </div>
                <?php if ($activeTheme === $theme['id']): ?>
                <div style="position:absolute; top:8px; right:8px; background:#6366f1; color:#fff; font-size:10px; font-weight:700; padding:2px 8px; border-radius:20px;">ACTIVE</div>
                <?php endif; ?>
            </div>

            <div class="card-body p-4">
                <h6 class="mb-1"><?= esc($theme['name']) ?></h6>
                <p class="text-muted small mb-3"><?= esc($theme['description']) ?></p>
                <?php if ($activeTheme === $theme['id']): ?>
                    <button class="btn btn-primary btn-sm w-100" disabled>
                        <i class="bi bi-check-circle me-1"></i> Active Theme
                    </button>
                <?php else: ?>
                    <form method="post" action="/admin/themes/activate">
                        <?= csrf_field() ?>
                        <input type="hidden" name="theme" value="<?= esc($theme['id']) ?>">
                        <button type="submit" class="btn btn-outline-secondary btn-sm w-100">
                            Activate Theme
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
