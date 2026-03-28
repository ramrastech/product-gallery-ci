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
use App\Libraries\ImageOptimizer;
use App\Models\AuditLogModel;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class Categories extends BaseController
{
    protected CategoryModel $model;

    public function __construct()
    {
        $this->model = new CategoryModel();
    }

    public function index()
    {
        $categories = $this->model->orderBy('name')->findAll();
        $productModel = new ProductModel();

        foreach ($categories as &$cat) {
            $cat['product_count'] = $productModel->where('category_id', $cat['id'])->countAllResults();
        }

        return view('admin/categories/index', [
            'pageTitle'  => 'Categories',
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return view('admin/categories/form', [
            'pageTitle'  => 'New Category',
            'category'   => null,
            'categories' => $this->model->where('is_active', 1)->findAll(),
        ]);
    }

    private function generateSlug(string $name, ?int $excludeId = null): string
    {
        $base = strtolower(trim(preg_replace('/[^a-z0-9\s-]/i', '', $name)));
        $base = preg_replace('/[\s-]+/', '-', $base);
        $base = trim($base, '-');

        $slug    = $base;
        $counter = 1;
        $db      = \Config\Database::connect();

        while (true) {
            $builder = $db->table('categories')->where('slug', $slug);
            if ($excludeId) {
                $builder->where('id !=', $excludeId);
            }
            if ($builder->countAllResults() === 0) {
                break;
            }
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private ?string $_imageUploadError = null;

    private array $allowedExts  = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    private int   $maxFileBytes = 8 * 1024 * 1024;

    private function handleImageUpload(): ?string
    {
        $this->_imageUploadError = null;

        // Image picked from media library or external URL — use directly
        $imageUrl = $this->request->getPost('image_url');
        if ($imageUrl && (str_starts_with($imageUrl, '/uploads/media/') || str_starts_with($imageUrl, 'http'))) {
            return $imageUrl;
        }

        $file = $this->request->getFile('image');
        if (! $file || ! $file->isValid() || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        $ext = strtolower($file->getClientExtension());
        if (! in_array($ext, $this->allowedExts)) {
            $this->_imageUploadError = 'Image not saved — unsupported format .' . strtoupper($ext) . '. Allowed: JPG, PNG, WebP, GIF.';
            return null;
        }
        if ($file->getSize() > $this->maxFileBytes) {
            $mb = number_format($file->getSize() / 1048576, 1);
            $this->_imageUploadError = "Image not saved — file is {$mb} MB, maximum is 8 MB.";
            return null;
        }

        $uploadDir = FCPATH . 'uploads/media/categories';
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $originalName = $file->getClientName();
        $tmpName      = bin2hex(random_bytes(12)) . '_orig.' . $ext;
        $file->move($uploadDir, $tmpName);

        $baseName  = bin2hex(random_bytes(8));
        $optimizer = new ImageOptimizer();
        $result    = $optimizer->process($uploadDir . '/' . $tmpName, $uploadDir, $baseName);

        if (isset($result['error'])) {
            $this->_imageUploadError = 'Image not saved — ' . $result['error'];
            return null;
        }

        \Config\Database::connect()->table('media_library')->insert([
            'filename'      => $result['filename'],
            'original_name' => $originalName,
            'folder'        => 'categories',
            'mime_type'     => 'image/webp',
            'file_size'     => $result['variants']['lg']['size'] ?? 0,
            'width'         => $result['orig_w'],
            'height'        => $result['orig_h'],
            'variants'      => json_encode($result['variants']),
            'alt_text'      => '',
            'title'         => '',
            'uploaded_by'   => session()->get('admin_id'),
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        return '/uploads/media/categories/' . $result['filename'];
    }

    public function save()
    {
        $rules = [
            'name'      => 'required|min_length[2]|max_length[150]',
            'parent_id' => 'permit_empty|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/admin/categories/new')->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $name      = $this->request->getPost('name');
        $imagePath = $this->handleImageUpload();

        $id = $this->model->insert([
            'name'        => $name,
            'slug'        => $this->generateSlug($name),
            'parent_id'   => $this->request->getPost('parent_id') ?: null,
            'description' => $this->request->getPost('description'),
            'image_path'  => $imagePath,
            'is_active'   => (int)$this->request->getPost('is_active'),
        ]);

        AuditLogModel::record('category_created', 'categories', $id, "Created: {$name}");

        if ($this->_imageUploadError) {
            return redirect()->to('/admin/categories/edit/' . $id)
                ->with('warning', 'Category created, but: ' . $this->_imageUploadError);
        }
        return redirect()->to('/admin/categories')->with('success', 'Category created.');
    }

    public function edit(int $id)
    {
        $category = $this->model->find($id);
        if (! $category) {
            return redirect()->to('/admin/categories')->with('error', 'Category not found.');
        }

        return view('admin/categories/form', [
            'pageTitle'  => 'Edit Category',
            'category'   => $category,
            'categories' => $this->model->where('is_active', 1)->where('id !=', $id)->findAll(),
        ]);
    }

    public function update(int $id)
    {
        $rules = [
            'name'      => 'required|min_length[2]|max_length[150]',
            'parent_id' => 'permit_empty|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/admin/categories/edit/' . $id)->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $name = $this->request->getPost('name');
        $data = [
            'name'        => $name,
            'parent_id'   => $this->request->getPost('parent_id') ?: null,
            'description' => $this->request->getPost('description'),
            'is_active'   => (int)$this->request->getPost('is_active'),
        ];

        $newImage = $this->handleImageUpload();
        if ($newImage !== null) {
            $data['image_path'] = $newImage;
        }

        $this->model->update($id, $data);

        AuditLogModel::record('category_updated', 'categories', $id, "Updated: {$name}");

        if ($this->_imageUploadError) {
            return redirect()->to('/admin/categories/edit/' . $id)
                ->with('warning', 'Category saved, but: ' . $this->_imageUploadError);
        }
        return redirect()->to('/admin/categories')->with('success', 'Category updated.');
    }

    public function removeImage(int $id)
    {
        $category = $this->model->find($id);
        if (! $category) {
            return redirect()->to('/admin/categories')->with('error', 'Category not found.');
        }

        // Clear image reference only — file stays on disk (in library)
        $this->model->update($id, ['image_path' => null]);

        AuditLogModel::record('category_updated', 'categories', $id, "Image removed from: {$category['name']}");
        return redirect()->to('/admin/categories/edit/' . $id)->with('success', 'Image removed from category. The file remains in the uploads library.');
    }

    public function delete(int $id)
    {
        $category = $this->model->find($id);
        $this->model->delete($id);
        AuditLogModel::record('category_deleted', 'categories', $id, "Deleted: " . ($category['name'] ?? $id));
        return redirect()->to('/admin/categories')->with('success', 'Category deleted.');
    }
}
