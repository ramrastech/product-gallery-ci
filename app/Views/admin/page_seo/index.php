<?php
/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */
?>
<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <p class="text-muted mb-0" style="font-size:.875rem;">Manage meta titles, descriptions, keywords, OG images, and robots settings per page.</p>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Page</th>
                    <th>Meta Title</th>
                    <th>Robots</th>
                    <th style="width:120px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pageLabels as $key => $label): ?>
                <?php $seo = $pages[$key] ?? []; ?>
                <tr>
                    <td>
                        <div class="fw-600"><?= esc($label) ?></div>
                        <small class="text-muted">/<?= esc($key) ?></small>
                    </td>
                    <td>
                        <?php if (! empty($seo['meta_title'])): ?>
                            <span class="small"><?= esc($seo['meta_title']) ?></span>
                        <?php else: ?>
                            <span class="text-muted small fst-italic">Not set</span>
                        <?php endif; ?>
                    </td>
                    <td><code class="small"><?= esc($seo['robots'] ?? 'index, follow') ?></code></td>
                    <td>
                        <a href="/admin/page-seo/edit/<?= esc($key) ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil me-1"></i>Edit SEO
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
