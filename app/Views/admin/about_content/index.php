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
    <p class="text-muted mb-0 small">Manage content blocks displayed on the About page.</p>
    <a href="/admin/about-content/settings" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-sliders me-1"></i> Text Settings
    </a>
</div>

<div class="row g-3">
    <!-- Settings-managed sections -->
    <?php foreach ([
        'story'   => ['label' => 'Story / Who We Are',  'desc' => 'Eyebrow, heading, images, badge, check items, body text.',  'anchor' => '#story'],
        'mission' => ['label' => 'Mission & Vision',     'desc' => 'Eyebrow, heading, mission & vision text.',                 'anchor' => '#mission'],
        'timeline'=> ['label' => 'Timeline Heading',     'desc' => 'Eyebrow & heading for the timeline section.',              'anchor' => '#timeline'],
        'facility'=> ['label' => 'Facility Heading',     'desc' => 'Eyebrow, heading & body for manufacturing facility.',      'anchor' => '#facility'],
        'team'    => ['label' => 'Team Heading',         'desc' => 'Eyebrow, heading & intro text for the leadership section.','anchor' => '#team'],
        'cert'    => ['label' => 'Certifications Heading','desc' => 'Eyebrow, heading & intro text for certifications.',       'anchor' => '#certs'],
        'cta'     => ['label' => 'CTA Section',          'desc' => 'All CTA banner text and button labels/URLs.',              'anchor' => '#cta'],
    ] as $cfg): ?>
    <div class="col-md-4">
        <div class="card h-100" style="border-style:dashed;">
            <div class="card-body d-flex flex-column gap-2">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0"><?= $cfg['label'] ?></h6>
                    <span class="badge" style="background:rgba(99,102,241,.12);color:var(--accent);">Settings</span>
                </div>
                <p class="text-muted small mb-0"><?= $cfg['desc'] ?></p>
                <div class="mt-auto pt-2">
                    <a href="/admin/about-content/settings<?= $cfg['anchor'] ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-sliders me-1"></i> Edit in Text Settings
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

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
                    <a href="/admin/about-content/section/<?= esc($key) ?>" class="btn btn-sm btn-primary">
                        <i class="bi bi-grid me-1"></i> Manage Items
                    </a>
                    <a href="/admin/about-content/item/new/<?= esc($key) ?>" class="btn btn-sm btn-outline-secondary ms-1">
                        <i class="bi bi-plus"></i> Add
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
