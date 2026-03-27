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

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'category_id', 'name', 'slug', 'short_description', 'description',
        'specifications', 'sku', 'is_featured', 'is_active',
        'meta_title', 'meta_description', 'view_count',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getFeatured(int $limit = 8): array
    {
        return $this->where('is_featured', 1)->where('is_active', 1)->orderBy('id', 'DESC')->limit($limit)->findAll();
    }

    public function getByCategory(int $categoryId, int $limit = 20, int $offset = 0): array
    {
        return $this->where('category_id', $categoryId)->where('is_active', 1)->orderBy('id', 'DESC')->limit($limit, $offset)->findAll();
    }

    public function getBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)->where('is_active', 1)->first();
    }

    public function search(string $query, int $limit = 20): array
    {
        return $this->groupStart()
            ->like('name', $query)
            ->orLike('short_description', $query)
            ->orLike('sku', $query)
            ->groupEnd()
            ->where('is_active', 1)
            ->limit($limit)
            ->findAll();
    }

    public function incrementViewCount(int $id): void
    {
        $this->db->query("UPDATE products SET view_count = view_count + 1 WHERE id = ?", [$id]);
    }

    public function getTopViewed(int $limit = 6): array
    {
        return $this->where('is_active', 1)->orderBy('view_count', 'DESC')->limit($limit)->findAll();
    }

    public static function makeSlug(string $name): string
    {
        $slug = strtolower(trim($name));
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        return trim($slug, '-');
    }
}
