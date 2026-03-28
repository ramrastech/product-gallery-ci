<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HomeSectionModel;
use App\Models\SettingsModel;

class HomeContent extends BaseController
{
    private HomeSectionModel $model;
    private SettingsModel $settingsModel;

    private array $sectionLabels = [
        'stat'       => 'Stats Bar',
        'capability' => 'Capabilities',
        'material'   => 'Materials & Quality',
        'market'     => 'Markets We Serve',
        'whyus'      => 'Why Choose Us',
        'cert'       => 'Home Certifications',
    ];

    public function __construct()
    {
        $this->model         = new HomeSectionModel();
        $this->settingsModel = new SettingsModel();
    }

    public function index()
    {
        $counts = [];
        foreach (array_keys($this->sectionLabels) as $sec) {
            $counts[$sec] = $this->model->where('section', $sec)->where('is_active', 1)->countAllResults();
        }

        return view('admin/home_content/index', [
            'pageTitle'     => 'Home Page Content',
            'sectionLabels' => $this->sectionLabels,
            'counts'        => $counts,
        ]);
    }

    public function section(string $section)
    {
        if (! array_key_exists($section, $this->sectionLabels)) {
            return redirect()->to('/admin/home-content')->with('error', 'Unknown section.');
        }

        $items = $this->model->where('section', $section)->orderBy('sort_order')->findAll();

        return view('admin/home_content/section', [
            'pageTitle' => $this->sectionLabels[$section],
            'section'   => $section,
            'label'     => $this->sectionLabels[$section],
            'items'     => $items,
        ]);
    }

    public function newItem(string $section)
    {
        if (! array_key_exists($section, $this->sectionLabels)) {
            return redirect()->to('/admin/home-content');
        }

        return view('admin/home_content/item_form', [
            'pageTitle' => 'Add Item — ' . $this->sectionLabels[$section],
            'section'   => $section,
            'label'     => $this->sectionLabels[$section],
            'item'      => null,
        ]);
    }

    public function createItem(string $section)
    {
        if (! array_key_exists($section, $this->sectionLabels)) {
            return redirect()->to('/admin/home-content');
        }

        $maxOrder = $this->model->where('section', $section)->selectMax('sort_order')->first();
        $nextOrder = ($maxOrder['sort_order'] ?? -1) + 1;

        $this->model->insert([
            'section'    => $section,
            'icon'       => $this->request->getPost('icon') ?? '',
            'title'      => $this->request->getPost('title') ?? '',
            'subtitle'   => $this->request->getPost('subtitle') ?? '',
            'body'       => $this->request->getPost('body') ?? '',
            'image_url'  => $this->request->getPost('image_url') ?? '',
            'sort_order' => $nextOrder,
            'is_active'  => (int) ($this->request->getPost('is_active') ?? 1),
        ]);

        return redirect()->to('/admin/home-content/section/' . $section)->with('success', 'Item added.');
    }

    public function editItem(int $id)
    {
        $item = $this->model->find($id);
        if (! $item) {
            return redirect()->to('/admin/home-content')->with('error', 'Item not found.');
        }

        return view('admin/home_content/item_form', [
            'pageTitle' => 'Edit Item — ' . ($this->sectionLabels[$item['section']] ?? $item['section']),
            'section'   => $item['section'],
            'label'     => $this->sectionLabels[$item['section']] ?? $item['section'],
            'item'      => $item,
        ]);
    }

    public function updateItem(int $id)
    {
        $item = $this->model->find($id);
        if (! $item) {
            return redirect()->to('/admin/home-content')->with('error', 'Item not found.');
        }

        $this->model->update($id, [
            'icon'      => $this->request->getPost('icon') ?? '',
            'title'     => $this->request->getPost('title') ?? '',
            'subtitle'  => $this->request->getPost('subtitle') ?? '',
            'body'      => $this->request->getPost('body') ?? '',
            'image_url' => $this->request->getPost('image_url') ?? '',
            'is_active' => (int) ($this->request->getPost('is_active') ?? 1),
        ]);

        return redirect()->to('/admin/home-content/section/' . $item['section'])->with('success', 'Item updated.');
    }

    public function deleteItem(int $id)
    {
        $item = $this->model->find($id);
        if ($item) {
            $this->model->delete($id);
            return redirect()->to('/admin/home-content/section/' . $item['section'])->with('success', 'Item deleted.');
        }
        return redirect()->to('/admin/home-content')->with('error', 'Item not found.');
    }

    public function reorderItem(int $id)
    {
        $direction = $this->request->getPost('direction');
        if (in_array($direction, ['up', 'down'])) {
            $this->model->reorder($id, $direction);
        }
        $item = $this->model->find($id);
        return redirect()->to('/admin/home-content/section/' . ($item['section'] ?? ''))->with('success', 'Order updated.');
    }

    /**
     * Save the flat settings for the home page (hero, story, CTA texts etc.)
     */
    public function saveSettings()
    {
        $fields = [
            'hero_eyebrow', 'hero_title_line1', 'hero_title_line2', 'hero_accent_text',
            'hero_cta_primary_text', 'hero_cta_primary_url', 'hero_cta_secondary_text', 'hero_cta_secondary_href',
            'hero_video_url', 'hero_poster_url', 'hero_frame_image_url', 'hero_trust_badges',
            'story_eyebrow', 'story_heading', 'story_body_1', 'story_body_2',
            'story_main_image_url', 'story_accent_image_url', 'story_badge_num', 'story_badge_label', 'story_checks',
            'story_cta_text', 'story_cta_url',
            'featured_eyebrow', 'featured_heading', 'featured_cta_text', 'featured_cta_url',
            'capabilities_eyebrow', 'capabilities_heading', 'capabilities_subtext',
            'categories_eyebrow', 'categories_heading', 'categories_cta_text', 'categories_cta_url',
            'markets_eyebrow', 'markets_heading',
            'materials_eyebrow', 'materials_heading', 'materials_body',
            'whyus_eyebrow', 'whyus_heading',
            'cta_eyebrow', 'cta_title', 'cta_subtitle', 'cta_note',
            'cta_whatsapp_text', 'cta_browse_text', 'cta_browse_url',
        ];

        foreach ($fields as $key) {
            $this->settingsModel->setSetting($key, $this->request->getPost($key) ?? '');
        }

        return redirect()->to('/admin/home-content/settings')->with('success', 'Home page settings saved.');
    }

    public function settings()
    {
        $settings = $this->settingsModel->getAllKeyed();
        return view('admin/home_content/settings', [
            'pageTitle' => 'Home Page Text Settings',
            'settings'  => $settings,
        ]);
    }
}
