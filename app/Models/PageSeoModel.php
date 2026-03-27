<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Models;

use CodeIgniter\Model;

class PageSeoModel extends Model
{
    protected $table      = 'page_seo';
    protected $primaryKey = 'id';
    protected $useTimestamps  = true;
    protected $allowedFields  = [
        'page_key', 'meta_title', 'meta_description', 'meta_keywords',
        'og_title', 'og_description', 'og_image', 'og_type',
        'robots', 'canonical',
    ];

    /**
     * Get SEO data for a page key. Returns empty-string defaults if not found.
     */
    public function getPage(string $key): array
    {
        $row = $this->where('page_key', $key)->first();
        return $row ?: [
            'page_key'         => $key,
            'meta_title'       => '',
            'meta_description' => '',
            'meta_keywords'    => '',
            'og_title'         => '',
            'og_description'   => '',
            'og_image'         => '',
            'og_type'          => 'website',
            'robots'           => 'index, follow',
            'canonical'        => '',
        ];
    }

    /**
     * Upsert SEO data for a page key.
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

    /**
     * All page keys with their current titles (for admin listing).
     */
    public function getAllPages(): array
    {
        return $this->orderBy('page_key')->findAll();
    }
}
