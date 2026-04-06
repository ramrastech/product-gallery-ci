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

<section class="pg-section">
    <div class="container">

        <!-- Page Header -->
        <div class="pg-page-header mb-4" data-aos="fade-up">
            <?php if (isset($searchQuery) && $searchQuery): ?>
                <h1 class="pg-page-title">Search results for "<?= esc($searchQuery) ?>"</h1>
                <p class="text-muted"><?= count($products) ?> result(s) found</p>
            <?php elseif ($activeCategory): ?>
                <h1 class="pg-page-title"><?= esc($activeCategory['name']) ?></h1>
                <?php if ($activeCategory['description']): ?>
                    <p class="text-muted"><?= esc($activeCategory['description']) ?></p>
                <?php endif; ?>
            <?php else: ?>
                <h1 class="pg-page-title">All Products</h1>
            <?php endif; ?>
        </div>

        <!-- Mobile Categories: horizontal scrollable pills -->
        <div class="pg-categories-mobile d-md-none mb-3" data-aos="fade-up">
            <div class="pg-category-pills">
                <a href="/products" class="pg-category-pill <?= ! $activeCategory ? 'active' : '' ?>">All</a>
                <?php foreach ($categories as $cat): ?>
                <a href="/products?category=<?= esc($cat['slug']) ?>"
                   class="pg-category-pill <?= ($activeCategory && $activeCategory['id'] == $cat['id']) ? 'active' : '' ?>">
                    <?= esc($cat['name']) ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="row g-4">
            <!-- Sidebar (hidden on mobile) -->
            <div class="col-lg-3 col-md-4 d-none d-md-block" data-aos="fade-right">
                <div class="pg-sidebar">
                    <h6 class="pg-sidebar-title">Categories</h6>
                    <ul class="pg-sidebar-list">
                        <li>
                            <a href="/products" class="pg-sidebar-link <?= ! $activeCategory ? 'active' : '' ?>">
                                All Products
                            </a>
                        </li>
                        <?php foreach ($categories as $cat): ?>
                        <li>
                            <a href="/products?category=<?= esc($cat['slug']) ?>"
                               class="pg-sidebar-link <?= ($activeCategory && $activeCategory['id'] == $cat['id']) ? 'active' : '' ?>">
                                <?= esc($cat['name']) ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-12 col-md-8 col-lg-9">
                <?php if (empty($products)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-search" style="font-size:3rem; opacity:0.3;"></i>
                    <p class="mt-3 text-muted">No products found.</p>
                    <a href="/products" class="btn pg-btn-primary">View All Products</a>
                </div>
                <?php else: ?>
                <div class="row g-4">
                    <?php $pIdx = 0; foreach ($products as $p): ?>
                    <div class="col-6 col-xl-4" data-aos="fade-up" data-aos-delay="<?= min($pIdx++ * 75, 300) ?>">
                        <?= view('partials/product_card', ['product' => $p]) ?>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php if (isset($pager) && $pager): ?>
                <div class="mt-5 d-flex justify-content-center pg-pagination">
                    <?= $pager->links('default', 'bootstrap_5') ?>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
</section>

<?= $this->endSection() ?>
