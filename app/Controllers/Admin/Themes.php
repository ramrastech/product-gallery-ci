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

class Themes extends BaseController
{
    public function index()
    {
        $settingsModel = new SettingsModel();
        $activeTheme   = $settingsModel->get('active_theme', 'default');

        $themes = [
            [
                'id'          => 'default',
                'name'        => 'Default',
                'description' => 'Clean, modern light theme with indigo accents. Professional and versatile.',
                'preview_bg'  => '#f8fafc',
                'preview_accent' => '#6366f1',
            ],
            [
                'id'          => 'dark',
                'name'        => 'Dark Elegance',
                'description' => 'Sophisticated dark theme with gold accents. Great for luxury or premium products.',
                'preview_bg'  => '#0f172a',
                'preview_accent' => '#f59e0b',
            ],
            [
                'id'          => 'minimal',
                'name'        => 'Minimal',
                'description' => 'Pure white, clean typography, no distractions. Lets your products speak.',
                'preview_bg'  => '#ffffff',
                'preview_accent' => '#111827',
            ],
        ];

        return view('admin/themes/index', [
            'pageTitle'   => 'Themes',
            'themes'      => $themes,
            'activeTheme' => $activeTheme,
        ]);
    }

    public function activate()
    {
        $theme = $this->request->getPost('theme');
        $valid = ['default', 'dark', 'minimal'];

        if (in_array($theme, $valid)) {
            (new SettingsModel())->setSetting('active_theme', $theme);
            return redirect()->to('/admin/themes')->with('success', 'Theme "' . ucfirst($theme) . '" activated.');
        }

        return redirect()->to('/admin/themes')->with('error', 'Invalid theme.');
    }
}
