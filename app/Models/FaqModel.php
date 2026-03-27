<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Models;

use CodeIgniter\Model;

class FaqModel extends Model
{
    protected $table      = 'faq_items';
    protected $primaryKey = 'id';
    protected $useTimestamps  = true;
    protected $allowedFields  = [
        'category_id', 'question', 'answer', 'sort_order', 'is_active',
    ];

    /**
     * Return all FAQ data grouped by category.
     * [['category' => [...], 'items' => [...]], ...]
     */
    public function getGrouped(): array
    {
        $db = \Config\Database::connect();
        $categories = $db->table('faq_categories')
                         ->where('is_active', 1)
                         ->orderBy('sort_order', 'ASC')
                         ->get()->getResultArray();

        $result = [];
        foreach ($categories as $cat) {
            $items = $this->where('category_id', $cat['id'])
                          ->where('is_active', 1)
                          ->orderBy('sort_order', 'ASC')
                          ->findAll();
            if (! empty($items)) {
                $result[] = ['category' => $cat, 'items' => $items];
            }
        }
        return $result;
    }

    /**
     * Get items for a specific category.
     */
    public function getByCategory(int $categoryId): array
    {
        return $this->where('category_id', $categoryId)
                    ->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }
}
