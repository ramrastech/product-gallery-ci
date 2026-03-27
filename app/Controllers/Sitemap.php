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
use App\Models\CategoryModel;

class Sitemap extends BaseController
{
    public function index(): \CodeIgniter\HTTP\Response
    {
        $products   = (new ProductModel())->where('is_active', 1)->findAll();
        $categories = (new CategoryModel())->where('is_active', 1)->findAll();
        $base       = rtrim(base_url(), '/');

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        $staticPages = ['', '/products'];
        foreach ($staticPages as $p) {
            $xml .= "  <url><loc>{$base}{$p}</loc><changefreq>weekly</changefreq><priority>1.0</priority></url>\n";
        }

        foreach ($categories as $cat) {
            $xml .= "  <url><loc>{$base}/products?category=" . urlencode($cat['slug']) . "</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>\n";
        }

        foreach ($products as $p) {
            $lastmod = date('Y-m-d', strtotime($p['updated_at'] ?: $p['created_at'] ?: 'now'));
            $xml    .= "  <url><loc>{$base}/products/" . esc($p['slug']) . "</loc><lastmod>{$lastmod}</lastmod><changefreq>monthly</changefreq><priority>0.7</priority></url>\n";
        }

        $xml .= '</urlset>';

        return $this->response
            ->setHeader('Content-Type', 'application/xml')
            ->setBody($xml);
    }
}
