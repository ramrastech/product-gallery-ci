<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PageContentModel;

class PageContent extends BaseController
{
    private PageContentModel $model;

    private array $pageLabels = [
        'privacy' => 'Privacy Policy',
        'terms'   => 'Terms & Conditions',
    ];

    public function __construct()
    {
        $this->model = new PageContentModel();
    }

    public function edit(string $key)
    {
        if (! array_key_exists($key, $this->pageLabels)) {
            return redirect()->to('/admin/settings')->with('error', 'Unknown page.');
        }

        return view('admin/page_content/edit', [
            'pageTitle'  => 'Edit Content — ' . $this->pageLabels[$key],
            'pageKey'    => $key,
            'pageLabel'  => $this->pageLabels[$key],
            'content'    => $this->model->getPage($key),
        ]);
    }

    public function save(string $key)
    {
        if (! array_key_exists($key, $this->pageLabels)) {
            return redirect()->to('/admin/settings')->with('error', 'Unknown page.');
        }

        $data = [
            'hero_title'    => $this->request->getPost('hero_title') ?? '',
            'hero_subtitle' => $this->request->getPost('hero_subtitle') ?? '',
            'content'       => $this->request->getPost('content') ?? '',
            'last_updated'  => date('Y-m-d'),
        ];

        $this->model->savePage($key, $data);

        return redirect()->to('/admin/page-content/' . $key . '/edit')->with('success', $this->pageLabels[$key] . ' content saved.');
    }
}
