<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Models;

use CodeIgniter\Model;

class AboutSectionModel extends Model
{
    protected $table      = 'about_sections';
    protected $primaryKey = 'id';
    protected $useTimestamps  = true;
    protected $allowedFields  = [
        'section', 'year', 'icon', 'title', 'subtitle', 'body',
        'image_url', 'image_id', 'sort_order', 'is_active',
    ];

    /**
     * Get all active items for a given section, sorted.
     */
    public function getSection(string $section): array
    {
        return $this->where('section', $section)
                    ->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    /**
     * Move an item up or down in sort_order.
     */
    public function reorder(int $id, string $direction): void
    {
        $item = $this->find($id);
        if (! $item) return;

        $swap = $this->where('section', $item['section'])
                     ->where('is_active', 1);

        if ($direction === 'up') {
            $swap = $swap->where('sort_order <', $item['sort_order'])
                         ->orderBy('sort_order', 'DESC')->first();
        } else {
            $swap = $swap->where('sort_order >', $item['sort_order'])
                         ->orderBy('sort_order', 'ASC')->first();
        }

        if ($swap) {
            $this->update($id,         ['sort_order' => $swap['sort_order']]);
            $this->update($swap['id'], ['sort_order' => $item['sort_order']]);
        }
    }
}
