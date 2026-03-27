<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AboutSectionModel;
use App\Models\SettingsModel;

class AboutContent extends BaseController
{
    private AboutSectionModel $model;
    private SettingsModel $settingsModel;

    private array $sectionLabels = [
        'timeline'      => 'Company Timeline',
        'facility_stat' => 'Facility Stats',
        'facility_photo'=> 'Facility Photos',
        'team'          => 'Leadership Team',
        'certification' => 'Certifications',
    ];

    public function __construct()
    {
        $this->model         = new AboutSectionModel();
        $this->settingsModel = new SettingsModel();
    }

    public function index()
    {
        $counts = [];
        foreach (array_keys($this->sectionLabels) as $sec) {
            $counts[$sec] = $this->model->where('section', $sec)->where('is_active', 1)->countAllResults();
        }

        return view('admin/about_content/index', [
            'pageTitle'     => 'About Page Content',
            'sectionLabels' => $this->sectionLabels,
            'counts'        => $counts,
        ]);
    }

    public function section(string $section)
    {
        if (! array_key_exists($section, $this->sectionLabels)) {
            return redirect()->to('/admin/about-content')->with('error', 'Unknown section.');
        }

        $items = $this->model->where('section', $section)->orderBy('sort_order')->findAll();

        return view('admin/about_content/section', [
            'pageTitle' => $this->sectionLabels[$section],
            'section'   => $section,
            'label'     => $this->sectionLabels[$section],
            'items'     => $items,
        ]);
    }

    public function newItem(string $section)
    {
        if (! array_key_exists($section, $this->sectionLabels)) {
            return redirect()->to('/admin/about-content');
        }

        return view('admin/about_content/item_form', [
            'pageTitle' => 'Add Item — ' . $this->sectionLabels[$section],
            'section'   => $section,
            'label'     => $this->sectionLabels[$section],
            'item'      => null,
        ]);
    }

    public function createItem(string $section)
    {
        if (! array_key_exists($section, $this->sectionLabels)) {
            return redirect()->to('/admin/about-content');
        }

        $maxOrder  = $this->model->where('section', $section)->selectMax('sort_order')->first();
        $nextOrder = ($maxOrder['sort_order'] ?? -1) + 1;

        $this->model->insert([
            'section'    => $section,
            'year'       => $this->request->getPost('year') ?? '',
            'icon'       => $this->request->getPost('icon') ?? '',
            'title'      => $this->request->getPost('title') ?? '',
            'subtitle'   => $this->request->getPost('subtitle') ?? '',
            'body'       => $this->request->getPost('body') ?? '',
            'image_url'  => $this->request->getPost('image_url') ?? '',
            'sort_order' => $nextOrder,
            'is_active'  => (int) ($this->request->getPost('is_active') ?? 1),
        ]);

        return redirect()->to('/admin/about-content/section/' . $section)->with('success', 'Item added.');
    }

    public function editItem(int $id)
    {
        $item = $this->model->find($id);
        if (! $item) {
            return redirect()->to('/admin/about-content')->with('error', 'Item not found.');
        }

        return view('admin/about_content/item_form', [
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
            return redirect()->to('/admin/about-content')->with('error', 'Item not found.');
        }

        $this->model->update($id, [
            'year'      => $this->request->getPost('year') ?? '',
            'icon'      => $this->request->getPost('icon') ?? '',
            'title'     => $this->request->getPost('title') ?? '',
            'subtitle'  => $this->request->getPost('subtitle') ?? '',
            'body'      => $this->request->getPost('body') ?? '',
            'image_url' => $this->request->getPost('image_url') ?? '',
            'is_active' => (int) ($this->request->getPost('is_active') ?? 1),
        ]);

        return redirect()->to('/admin/about-content/section/' . $item['section'])->with('success', 'Item updated.');
    }

    public function deleteItem(int $id)
    {
        $item = $this->model->find($id);
        if ($item) {
            $this->model->delete($id);
            return redirect()->to('/admin/about-content/section/' . $item['section'])->with('success', 'Item deleted.');
        }
        return redirect()->to('/admin/about-content')->with('error', 'Item not found.');
    }

    public function reorderItem(int $id)
    {
        $direction = $this->request->getPost('direction');
        if (in_array($direction, ['up', 'down'])) {
            $this->model->reorder($id, $direction);
        }
        $item = $this->model->find($id);
        return redirect()->to('/admin/about-content/section/' . ($item['section'] ?? ''))->with('success', 'Order updated.');
    }

    public function settings()
    {
        $settings = $this->settingsModel->getAllKeyed();
        return view('admin/about_content/settings', [
            'pageTitle' => 'About Page Text Settings',
            'settings'  => $settings,
        ]);
    }

    public function saveSettings()
    {
        $fields = [
            'about_hero_subtitle', 'about_hero_bg_url',
            'about_story_main_image', 'about_story_accent_image',
            'about_story_body_1', 'about_story_body_2',
            'about_mission', 'about_vision',
            'about_facility_heading', 'about_facility_body',
        ];

        foreach ($fields as $key) {
            $this->settingsModel->setSetting($key, $this->request->getPost($key) ?? '');
        }

        return redirect()->back()->with('success', 'About page settings saved.');
    }
}
