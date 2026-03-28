<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Models;

use CodeIgniter\Model;

class MediaLibraryModel extends Model
{
    protected $table      = 'media_library';
    protected $primaryKey = 'id';
    protected $useTimestamps  = false;
    protected $allowedFields  = [
        'filename', 'original_name', 'folder', 'mime_type',
        'file_size', 'width', 'height', 'variants', 'alt_text', 'title', 'uploaded_by', 'created_at',
    ];

    /**
     * Get public URL for a media item.
     */
    public static function url(array $media): string
    {
        return '/uploads/media/' . $media['folder'] . '/' . $media['filename'];
    }

    /**
     * Get URL by ID. Returns null if not found.
     */
    public function getUrl(int $id): ?string
    {
        $row = $this->find($id);
        return $row ? self::url($row) : null;
    }

    /**
     * Get all files in a folder, newest first.
     */
    public function getFolderFiles(string $folder = 'general'): array
    {
        return $this->where('folder', $folder)
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }

    /**
     * Get all files across all folders, newest first.
     */
    public function getAllFiles(): array
    {
        return $this->orderBy('id', 'DESC')->findAll();
    }
}
