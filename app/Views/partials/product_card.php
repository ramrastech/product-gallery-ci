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
<a href="/products/<?= esc($product['slug']) ?>" class="pg-product-card d-block text-decoration-none">
    <div class="pg-product-img-wrap">
        <?php if ($product['primary_image']):
            $imgSrc = (str_starts_with($product['primary_image'], 'http') || str_starts_with($product['primary_image'], '/'))
                ? $product['primary_image']
                : '/uploads/products/' . $product['primary_image'];
        ?>
            <img src="<?= esc($imgSrc) ?>"
                 alt="<?= esc($product['name']) ?>" class="pg-product-img" loading="lazy">
        <?php else: ?>
            <div class="pg-product-img-placeholder">
                <i class="bi bi-image"></i>
            </div>
        <?php endif; ?>
        <?php if ($product['is_featured']): ?>
            <span class="pg-badge-featured">Featured</span>
        <?php endif; ?>
    </div>
    <div class="pg-product-info">
        <h3 class="pg-product-name"><?= esc($product['name']) ?></h3>
        <?php if (! empty($product['short_description'])): ?>
            <p class="pg-product-desc"><?= esc($product['short_description']) ?></p>
        <?php endif; ?>
        <span class="pg-product-cta">View Details <i class="bi bi-arrow-right"></i></span>
    </div>
</a>
