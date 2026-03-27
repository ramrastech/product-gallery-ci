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

use App\Models\SettingsModel;

class Contact extends BaseController
{
    public function index(): string
    {
        $settings = (new SettingsModel())->getAllKeyed();

        return view('contact/index', [
            'settings'  => $settings,
            'metaTitle' => 'Contact Us — ' . ($settings['site_name'] ?? 'Product Gallery'),
            'metaDesc'  => 'Get in touch for OEM enquiries, samples, and pricing. We respond within 4 hours. Based in Kanpur, India — exporting to 40+ countries.',
        ]);
    }
}
