<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Controllers;

use App\Models\SettingsModel;
use App\Models\PageSeoModel;
use App\Models\FaqModel;
use App\Models\PageContentModel;

class Pages extends BaseController
{
    protected array $settings;
    protected PageSeoModel $pageSeoModel;

    public function __construct()
    {
        $this->settings     = (new SettingsModel())->getAllKeyed();
        $this->pageSeoModel = new PageSeoModel();
    }

    public function privacy(): string
    {
        $seo        = $this->pageSeoModel->getPage('privacy');
        $pageContent = (new PageContentModel())->getPage('privacy');

        $metaTitle = ! empty($seo['meta_title'])       ? $seo['meta_title']       : ('Privacy Policy — ' . ($this->settings['site_name'] ?? 'Product Gallery'));
        $metaDesc  = ! empty($seo['meta_description']) ? $seo['meta_description'] : 'How we collect, use, and protect your personal information.';

        return view('pages/privacy', [
            'settings'    => $this->settings,
            'pageContent' => $pageContent,
            'metaTitle'   => $metaTitle,
            'metaDesc'    => $metaDesc,
            'metaRobots'  => $seo['robots'] ?? 'noindex, follow',
        ]);
    }

    public function terms(): string
    {
        $seo        = $this->pageSeoModel->getPage('terms');
        $pageContent = (new PageContentModel())->getPage('terms');

        $metaTitle = ! empty($seo['meta_title'])       ? $seo['meta_title']       : ('Terms & Conditions — ' . ($this->settings['site_name'] ?? 'Product Gallery'));
        $metaDesc  = ! empty($seo['meta_description']) ? $seo['meta_description'] : 'Terms and conditions governing the use of our website and services.';

        return view('pages/terms', [
            'settings'    => $this->settings,
            'pageContent' => $pageContent,
            'metaTitle'   => $metaTitle,
            'metaDesc'    => $metaDesc,
            'metaRobots'  => $seo['robots'] ?? 'noindex, follow',
        ]);
    }

    public function faq(): string
    {
        $seo      = $this->pageSeoModel->getPage('faq');
        $faqModel = new FaqModel();
        $faqGroups = $faqModel->getGrouped();

        $metaTitle = ! empty($seo['meta_title'])       ? $seo['meta_title']       : ('FAQ — ' . ($this->settings['site_name'] ?? 'Product Gallery'));
        $metaDesc  = ! empty($seo['meta_description']) ? $seo['meta_description'] : 'Frequently asked questions about our OEM leather goods manufacturing, MOQs, sampling, and export process.';

        return view('pages/faq', [
            'settings'   => $this->settings,
            'faqGroups'  => $faqGroups,
            'metaTitle'  => $metaTitle,
            'metaDesc'   => $metaDesc,
            'metaRobots' => $seo['robots'] ?? 'index, follow',
        ]);
    }
}
