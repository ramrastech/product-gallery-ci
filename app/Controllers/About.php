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
use App\Models\AboutSectionModel;

class About extends BaseController
{
    public function index(): string
    {
        $settings          = (new SettingsModel())->getAllKeyed();
        $seo               = (new PageSeoModel())->getPage('about');
        $aboutSectionModel = new AboutSectionModel();

        $timeline       = $aboutSectionModel->getSection('timeline');
        $facilityStats  = $aboutSectionModel->getSection('facility_stat');
        $facilityPhotos = $aboutSectionModel->getSection('facility_photo');
        $team           = $aboutSectionModel->getSection('team');
        $certifications = $aboutSectionModel->getSection('certification');

        $metaTitle = ! empty($seo['meta_title'])       ? $seo['meta_title']       : ('About Us — ' . ($settings['site_name'] ?? 'Product Gallery'));
        $metaDesc  = ! empty($seo['meta_description']) ? $seo['meta_description'] : 'Learn about our 20+ years of leather goods and fashion accessories manufacturing in Kanpur, India.';

        return view('about/index', [
            'settings'       => $settings,
            'timeline'       => $timeline,
            'facilityStats'  => $facilityStats,
            'facilityPhotos' => $facilityPhotos,
            'team'           => $team,
            'certifications' => $certifications,
            'metaTitle'      => $metaTitle,
            'metaDesc'       => $metaDesc,
            'metaKeywords'   => $seo['meta_keywords'] ?? '',
            'metaRobots'     => $seo['robots'] ?? 'index, follow',
            'ogImage'        => $seo['og_image'] ?? '',
        ]);
    }
}
