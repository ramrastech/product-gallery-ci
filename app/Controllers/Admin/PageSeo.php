<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PageSeoModel;

class PageSeo extends BaseController
{
    private PageSeoModel $model;

    private array $pageLabels = [
        'home'     => 'Home Page',
        'about'    => 'About Us',
        'products' => 'Products Listing',
        'contact'  => 'Contact Page',
        'faq'      => 'FAQ Page',
        'privacy'  => 'Privacy Policy',
        'terms'    => 'Terms & Conditions',
    ];

    public function __construct()
    {
        $this->model = new PageSeoModel();
    }

    public function index()
    {
        $pages = $this->model->getAllPages();

        // Ensure all defined pages appear, even if no DB row yet
        $indexed = [];
        foreach ($pages as $p) {
            $indexed[$p['page_key']] = $p;
        }
        foreach (array_keys($this->pageLabels) as $key) {
            if (! isset($indexed[$key])) {
                $indexed[$key] = $this->model->getPage($key);
            }
        }

        return view('admin/page_seo/index', [
            'pageTitle'  => 'SEO Management',
            'pages'      => $indexed,
            'pageLabels' => $this->pageLabels,
        ]);
    }

    public function edit(string $key)
    {
        if (! array_key_exists($key, $this->pageLabels)) {
            return redirect()->to('/admin/page-seo')->with('error', 'Unknown page.');
        }

        return view('admin/page_seo/edit', [
            'pageTitle'  => 'Edit SEO — ' . ($this->pageLabels[$key] ?? $key),
            'pageKey'    => $key,
            'pageLabel'  => $this->pageLabels[$key] ?? $key,
            'seo'        => $this->model->getPage($key),
        ]);
    }

    public function save(string $key)
    {
        if (! array_key_exists($key, $this->pageLabels)) {
            return redirect()->to('/admin/page-seo')->with('error', 'Unknown page.');
        }

        $data = [
            'meta_title'       => $this->request->getPost('meta_title') ?? '',
            'meta_description' => $this->request->getPost('meta_description') ?? '',
            'meta_keywords'    => $this->request->getPost('meta_keywords') ?? '',
            'og_title'         => $this->request->getPost('og_title') ?? '',
            'og_description'   => $this->request->getPost('og_description') ?? '',
            'og_image'         => $this->request->getPost('og_image') ?? '',
            'og_type'          => $this->request->getPost('og_type') ?? 'website',
            'robots'           => $this->request->getPost('robots') ?? 'index, follow',
            'canonical'        => $this->request->getPost('canonical') ?? '',
        ];

        $this->model->savePage($key, $data);

        return redirect()->to('/admin/page-seo')->with('success', 'SEO settings saved for ' . ($this->pageLabels[$key] ?? $key) . '.');
    }
}
