<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\SettingsModel;
use App\Models\ProductImageModel;
use App\Models\PageSeoModel;
use App\Models\HomeSectionModel;

class Home extends BaseController
{
    public function index(): string
    {
        $settingsModel     = new SettingsModel();
        $settings          = $settingsModel->getAllKeyed();

        $productModel      = new ProductModel();
        $categoryModel     = new CategoryModel();
        $imageModel        = new ProductImageModel();
        $pageSeoModel      = new PageSeoModel();
        $homeSectionModel  = new HomeSectionModel();

        // Per-page SEO
        $seo = $pageSeoModel->getPage('home');

        // Featured products with primary image
        $featured = $productModel->getFeatured(8);
        foreach ($featured as &$p) {
            $img = $imageModel->where('product_id', $p['id'])->where('is_primary', 1)->first();
            if (! $img) {
                $img = $imageModel->where('product_id', $p['id'])->orderBy('sort_order')->first();
            }
            $p['primary_image'] = $img['image_path'] ?? null;
        }
        unset($p);

        // Categories with product counts
        $categories = $categoryModel->where('is_active', 1)
                                    ->where('parent_id IS NULL', null, false)
                                    ->findAll();
        foreach ($categories as &$cat) {
            $cat['product_count'] = $productModel->where('category_id', $cat['id'])
                                                  ->where('is_active', 1)
                                                  ->countAllResults();
        }
        unset($cat);

        // Home section data from DB
        $stats        = $homeSectionModel->getSection('stat');
        $capabilities = $homeSectionModel->getSection('capability');
        $materials    = $homeSectionModel->getSection('material');
        $certs        = $homeSectionModel->getSection('cert');
        $markets      = $homeSectionModel->getSection('market');
        $whyus        = $homeSectionModel->getSection('whyus');

        // Decode trust badges JSON
        $trustBadges = [];
        if (! empty($settings['hero_trust_badges'])) {
            $trustBadges = json_decode($settings['hero_trust_badges'], true) ?? [];
        }

        // Story checks JSON
        $storyChecks = [];
        if (! empty($settings['story_checks'])) {
            $storyChecks = json_decode($settings['story_checks'], true) ?? [];
        }

        // SEO values: prefer page_seo, fall back to settings
        $metaTitle = ! empty($seo['meta_title']) ? $seo['meta_title'] : ($settings['site_name'] ?? 'Product Gallery');
        $metaDesc  = ! empty($seo['meta_description']) ? $seo['meta_description'] : ($settings['site_tagline'] ?? '');

        return view('home/index', [
            'settings'     => $settings,
            'featured'     => $featured,
            'categories'   => $categories,
            'stats'        => $stats,
            'capabilities' => $capabilities,
            'materials'    => $materials,
            'certs'        => $certs,
            'markets'      => $markets,
            'whyus'        => $whyus,
            'trustBadges'  => $trustBadges,
            'storyChecks'  => $storyChecks,
            'metaTitle'    => $metaTitle,
            'metaDesc'     => $metaDesc,
            'metaKeywords' => $seo['meta_keywords'] ?? '',
            'metaRobots'   => $seo['robots'] ?? 'index, follow',
            'ogImage'      => $seo['og_image'] ?? '',
        ]);
    }
}
