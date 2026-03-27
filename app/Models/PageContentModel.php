<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Models;

use CodeIgniter\Model;

class PageContentModel extends Model
{
    protected $table      = 'page_content';
    protected $primaryKey = 'id';
    protected $useTimestamps  = true;
    protected $allowedFields  = [
        'page_key', 'hero_title', 'hero_subtitle', 'hero_bg_image', 'content', 'last_updated',
    ];

    /**
     * Get content for a page. Returns array with empty defaults if not found.
     */
    public function getPage(string $key): array
    {
        $row = $this->where('page_key', $key)->first();
        return $row ?: [
            'page_key'      => $key,
            'hero_title'    => '',
            'hero_subtitle' => '',
            'hero_bg_image' => '',
            'content'       => '',
            'last_updated'  => null,
        ];
    }

    /**
     * Upsert content for a page.
     */
    public function savePage(string $key, array $data): bool
    {
        $existing = $this->where('page_key', $key)->first();
        $data['page_key'] = $key;
        if ($existing) {
            return $this->update($existing['id'], $data);
        }
        return (bool) $this->insert($data);
    }
}
