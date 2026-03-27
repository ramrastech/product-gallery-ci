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

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingsModel;

class Settings extends BaseController
{
    public function index()
    {
        $settingsModel = new SettingsModel();
        return view('admin/settings/index', [
            'pageTitle' => 'Settings',
            'settings'  => $settingsModel->getAllKeyed(),
        ]);
    }

    public function save()
    {
        $settingsModel = new SettingsModel();
        $fields = [
            'site_name', 'site_tagline', 'enquiry_email', 'whatsapp_number',
            'ga_tracking_id', 'meta_pixel_id', 'facebook_url', 'instagram_url',
            'linkedin_url', 'twitter_url', 'hero_title', 'hero_subtitle',
            'contact_phone', 'contact_address',
        ];

        foreach ($fields as $key) {
            $settingsModel->setSetting($key, $this->request->getPost($key) ?? '');
        }

        return redirect()->back()->with('success', 'Settings saved successfully.');
    }
}
