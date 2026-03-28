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

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ProductImageModel;
use App\Models\CategoryModel;
use App\Models\SettingsModel;

class Products extends BaseController
{
    protected ProductModel $productModel;
    protected ProductImageModel $imageModel;
    protected CategoryModel $categoryModel;
    protected array $settings;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->imageModel    = new ProductImageModel();
        $this->categoryModel = new CategoryModel();
        $this->settings      = (new SettingsModel())->getAllKeyed();
    }

    public function index(): string
    {
        $categorySlug = $this->request->getGet('category');
        $page         = (int)($this->request->getGet('page') ?? 1);
        $perPage      = 16;

        $builder    = $this->productModel->where('is_active', 1);
        $activeCategory = null;

        if ($categorySlug) {
            $activeCategory = $this->categoryModel->where('slug', $categorySlug)->first();
            if ($activeCategory) {
                $builder = $builder->where('category_id', $activeCategory['id']);
            }
        }

        $products   = $builder->orderBy('id', 'DESC')->paginate($perPage, 'default', $page);
        $pager      = $this->productModel->pager;
        $categories = $this->categoryModel->where('is_active', 1)->findAll();

        foreach ($products as &$p) {
            $img = $this->imageModel->where('product_id', $p['id'])->where('is_primary', 1)->first();
            if (! $img) {
                $img = $this->imageModel->where('product_id', $p['id'])->orderBy('sort_order')->first();
            }
            $p['primary_image'] = $img['image_path'] ?? null;
        }

        return view('products/index', [
            'settings'       => $this->settings,
            'products'       => $products,
            'pager'          => $pager,
            'categories'     => $categories,
            'activeCategory' => $activeCategory,
            'metaTitle'      => 'Products — ' . ($this->settings['site_name'] ?? 'Product Gallery'),
            'metaDesc'       => $activeCategory['description'] ?? ($this->settings['site_tagline'] ?? ''),
        ]);
    }

    public function byCategory(string $slug): string
    {
        return redirect()->to('/products?category=' . $slug);
    }

    public function detail(string $slug): string
    {
        $product = $this->productModel->getBySlug($slug);
        if (! $product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Increment view count
        $this->productModel->incrementViewCount($product['id']);

        // Load images
        $images = $this->imageModel->where('product_id', $product['id'])->orderBy('sort_order')->findAll();

        // Primary image for OG
        $primaryImage = null;
        foreach ($images as $img) {
            if ($img['is_primary']) {
                $primaryImage = $img['image_path'];
                break;
            }
        }
        if (! $primaryImage && ! empty($images)) {
            $primaryImage = $images[0]['image_path'];
        }

        // Parse specs
        $specs = [];
        if ($product['specifications']) {
            $specs = json_decode($product['specifications'], true) ?? [];
        }

        // Related products (same category)
        $related = [];
        if ($product['category_id']) {
            $related = $this->productModel
                ->where('category_id', $product['category_id'])
                ->where('id !=', $product['id'])
                ->where('is_active', 1)
                ->limit(4)
                ->findAll();
            foreach ($related as &$r) {
                $img = $this->imageModel->where('product_id', $r['id'])->where('is_primary', 1)->first();
                if (! $img) {
                    $img = $this->imageModel->where('product_id', $r['id'])->orderBy('sort_order')->first();
                }
                $r['primary_image'] = $img['image_path'] ?? null;
            }
        }

        $category = $product['category_id']
            ? $this->categoryModel->find($product['category_id'])
            : null;

        if (! $primaryImage) {
            $ogImageUrl = base_url('assets/img/og-default.jpg');
        } elseif (str_starts_with($primaryImage, 'http')) {
            $ogImageUrl = $primaryImage;
        } else {
            // image_path may be a full path like /uploads/products/... or a bare filename
            $cleanPath  = ltrim($primaryImage, '/');
            // Swap .webp → .jpg for social crawlers (WhatsApp does not support WebP)
            $jpegPath   = preg_replace('/\.webp$/i', '.jpg', $cleanPath);
            $ogImageUrl = is_file(FCPATH . $jpegPath)
                ? base_url($jpegPath)
                : base_url($cleanPath);
        }

        $waMessage = "Hi! I'm interested in " . $product['name'] . " — " . current_url();

        return view('products/detail', [
            'settings'   => $this->settings,
            'product'    => $product,
            'images'     => $images,
            'specs'      => $specs,
            'related'    => $related,
            'category'   => $category,
            'metaTitle'  => ($product['meta_title'] ?: $product['name']) . ' — ' . ($this->settings['site_name'] ?? ''),
            'metaDesc'   => $product['meta_description'] ?: $product['short_description'] ?: '',
            'ogImage'    => $ogImageUrl,
            'ogType'     => 'product',
            'waMessage'  => $waMessage,
            'shareTitle' => $product['name'],
        ]);
    }

    public function search(): string
    {
        $query    = $this->request->getGet('q');
        $products = [];

        if ($query) {
            $products = $this->productModel->search($query);
            foreach ($products as &$p) {
                $img = $this->imageModel->where('product_id', $p['id'])->where('is_primary', 1)->first();
                if (! $img) {
                    $img = $this->imageModel->where('product_id', $p['id'])->orderBy('sort_order')->first();
                }
                $p['primary_image'] = $img['image_path'] ?? null;
            }
        }

        $categories = $this->categoryModel->where('is_active', 1)->findAll();

        return view('products/index', [
            'settings'       => $this->settings,
            'products'       => $products,
            'pager'          => null,
            'categories'     => $categories,
            'activeCategory' => null,
            'searchQuery'    => $query,
            'metaTitle'      => 'Search: ' . ($query ?? '') . ' — ' . ($this->settings['site_name'] ?? ''),
            'metaDesc'       => '',
        ]);
    }
}
