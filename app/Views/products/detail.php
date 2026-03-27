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

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb pg-breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/products">Products</a></li>
                <?php if ($category): ?>
                <li class="breadcrumb-item">
                    <a href="/products?category=<?= esc($category['slug']) ?>"><?= esc($category['name']) ?></a>
                </li>
                <?php endif; ?>
                <li class="breadcrumb-item active"><?= esc($product['name']) ?></li>
            </ol>
        </nav>

        <?php if (session()->getFlashdata('enquiry_success')): ?>
        <div class="alert alert-success alert-dismissible fade show py-2 mb-4">
            <?= esc(session()->getFlashdata('enquiry_success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <div class="row g-5">

            <!-- LEFT: Image Gallery -->
            <div class="col-lg-6">
                <?php if (! empty($images)): ?>
                <!-- Main Swiper -->
                <div class="swiper pg-gallery-main mb-3">
                    <div class="swiper-wrapper">
                        <?php foreach ($images as $img):
                            $imgUrl = str_starts_with($img['image_path'], 'http')
                                ? $img['image_path']
                                : '/uploads/products/' . $img['image_path'];
                        ?>
                        <div class="swiper-slide">
                            <a href="<?= esc($imgUrl) ?>" class="glightbox"
                               data-gallery="product-gallery">
                                <img src="<?= esc($imgUrl) ?>"
                                     alt="<?= esc($img['alt_text'] ?: $product['name']) ?>"
                                     class="pg-gallery-main-img">
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($images) > 1): ?>
                    <div class="swiper-button-prev pg-gallery-prev"></div>
                    <div class="swiper-button-next pg-gallery-next"></div>
                    <?php endif; ?>
                </div>

                <!-- Thumbnails -->
                <?php if (count($images) > 1): ?>
                <div class="swiper pg-gallery-thumbs">
                    <div class="swiper-wrapper">
                        <?php foreach ($images as $img):
                            $imgUrl = str_starts_with($img['image_path'], 'http')
                                ? $img['image_path']
                                : '/uploads/products/' . $img['image_path'];
                        ?>
                        <div class="swiper-slide">
                            <img src="<?= esc($imgUrl) ?>"
                                 alt="<?= esc($img['alt_text'] ?: '') ?>" class="pg-thumb-img">
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php else: ?>
                <div class="pg-no-image d-flex align-items-center justify-content-center">
                    <i class="bi bi-image" style="font-size: 4rem; opacity:0.3;"></i>
                </div>
                <?php endif; ?>

                <!-- Share Buttons -->
                <div class="mt-4">
                    <?= view('partials/share_buttons', [
                        'shareTitle' => $product['name'],
                        'settings'   => $settings,
                    ]) ?>
                </div>
            </div>

            <!-- RIGHT: Product Info -->
            <div class="col-lg-6">
                <?php if ($category): ?>
                <div class="pg-product-category mb-2">
                    <a href="/products?category=<?= esc($category['slug']) ?>"><?= esc($category['name']) ?></a>
                </div>
                <?php endif; ?>

                <h1 class="pg-detail-title"><?= esc($product['name']) ?></h1>

                <?php if ($product['sku']): ?>
                <p class="text-muted small mb-3">SKU: <?= esc($product['sku']) ?></p>
                <?php endif; ?>

                <?php if ($product['short_description']): ?>
                <p class="pg-detail-short-desc"><?= esc($product['short_description']) ?></p>
                <?php endif; ?>

                <!-- CTA Buttons -->
                <div class="pg-cta-row d-flex flex-wrap gap-3 my-4">
                    <button type="button" class="btn pg-btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#enquiryModal">
                        <i class="bi bi-envelope me-2"></i>Send Enquiry
                    </button>
                    <?php if (! empty($settings['whatsapp_number'])): ?>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $settings['whatsapp_number']) ?>?text=<?= rawurlencode($waMessage) ?>"
                       class="btn pg-btn-whatsapp btn-lg" target="_blank" rel="noopener">
                        <i class="bi bi-whatsapp me-2"></i>WhatsApp
                    </a>
                    <?php endif; ?>
                </div>

                <!-- Specifications -->
                <?php if (! empty($specs)): ?>
                <div class="pg-specs-card mt-4">
                    <h5 class="pg-specs-title">Specifications</h5>
                    <table class="table pg-specs-table">
                        <tbody>
                            <?php foreach ($specs as $key => $val): ?>
                            <tr>
                                <td class="pg-spec-key"><?= esc($key) ?></td>
                                <td class="pg-spec-val"><?= esc($val) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>

                <!-- Full Description -->
                <?php if ($product['description']): ?>
                <div class="pg-description mt-4">
                    <h5 class="pg-specs-title">Description</h5>
                    <div class="pg-desc-content">
                        <?= $product['description'] ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>

        <!-- Related Products -->
        <?php if (! empty($related)): ?>
        <div class="mt-5 pt-4 pg-related-section">
            <h3 class="pg-section-title mb-4">You might also like</h3>
            <div class="row g-4">
                <?php foreach ($related as $r): ?>
                <div class="col-6 col-md-3">
                    <?= view('partials/product_card', ['product' => $r]) ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</section>

<!-- Enquiry Modal -->
<div class="modal fade" id="enquiryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content pg-modal">
            <div class="modal-header">
                <h5 class="modal-title">Send Enquiry — <?= esc($product['name']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <?php if (session()->getFlashdata('enquiry_error')): ?>
                <div class="alert alert-danger small py-2"><?= session()->getFlashdata('enquiry_error') ?></div>
                <?php endif; ?>
                <form action="/enquiry/submit" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="hidden" name="redirect_to" value="/products/<?= esc($product['slug']) ?>">
                    <div class="mb-3">
                        <label class="form-label">Your Name *</label>
                        <input type="text" name="name" class="form-control" required value="<?= esc(old('name')) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address *</label>
                        <input type="email" name="email" class="form-control" required value="<?= esc(old('email')) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?= esc(old('phone')) ?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Message</label>
                        <textarea name="message" class="form-control" rows="3"
                                  placeholder="Tell us your requirements..."><?= esc(old('message')) ?></textarea>
                    </div>
                    <button type="submit" class="btn pg-btn-primary w-100">
                        <i class="bi bi-send me-2"></i>Send Enquiry
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('schema') ?>
<?php
// ── Product JSON-LD ───────────────────────────────────────────────────────────
$primaryImgUrl = $ogImage ?? base_url('assets/img/og-default.jpg');
$productSchema = [
    '@context'    => 'https://schema.org',
    '@type'       => 'Product',
    'name'        => $product['name'],
    'description' => strip_tags($product['short_description'] ?? $product['description'] ?? ''),
    'url'         => current_url(),
    'image'       => $primaryImgUrl,
    'sku'         => $product['sku'] ?? '',
    'brand'       => [
        '@type' => 'Brand',
        'name'  => $settings['site_name'] ?? 'Product Gallery',
    ],
    'manufacturer' => [
        '@type'   => 'Organization',
        'name'    => $settings['site_name'] ?? 'Product Gallery',
        'address' => [
            '@type'           => 'PostalAddress',
            'addressLocality' => 'Kanpur',
            'addressRegion'   => 'Uttar Pradesh',
            'addressCountry'  => 'IN',
        ],
    ],
    'offers' => [
        '@type'           => 'Offer',
        'priceCurrency'   => 'USD',
        'price'           => '0',
        'priceSpecification' => [
            '@type'       => 'PriceSpecification',
            'description' => 'Price on enquiry — OEM/ODM minimum order applies',
        ],
        'availability'    => 'https://schema.org/InStock',
        'seller'          => [
            '@type' => 'Organization',
            'name'  => $settings['site_name'] ?? 'Product Gallery',
            'url'   => base_url(),
        ],
        'url'             => current_url(),
    ],
];
if (!empty($specs)) {
    $productSchema['additionalProperty'] = [];
    foreach ($specs as $k => $v) {
        $productSchema['additionalProperty'][] = [
            '@type'     => 'PropertyValue',
            'name'      => $k,
            'value'     => $v,
        ];
    }
}
if ($category) {
    $productSchema['category'] = $category['name'];
}
?>
<script type="application/ld+json"><?= json_encode($productSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Gallery init
const thumbsSwiper = new Swiper('.pg-gallery-thumbs', {
    spaceBetween: 8,
    slidesPerView: 'auto',
    freeMode: true,
    watchSlidesProgress: true,
});

const mainSwiper = new Swiper('.pg-gallery-main', {
    spaceBetween: 0,
    loop: <?= count($images) > 1 ? 'true' : 'false' ?>,
    navigation: {
        nextEl: '.pg-gallery-next',
        prevEl: '.pg-gallery-prev',
    },
    thumbs: {
        swiper: thumbsSwiper,
    },
});

// Lightbox
GLightbox({ selector: '.glightbox' });

// Auto-open modal if enquiry errors exist
<?php if (session()->getFlashdata('enquiry_error')): ?>
new bootstrap.Modal(document.getElementById('enquiryModal')).show();
<?php endif; ?>
</script>
<?= $this->endSection() ?>
