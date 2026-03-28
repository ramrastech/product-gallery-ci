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
use App\Models\MediaLibraryModel;
use App\Models\ProductModel;
use App\Models\ProductImageModel;
use App\Models\CategoryModel;

class Products extends BaseController
{
    protected ProductModel $productModel;
    protected ProductImageModel $imageModel;
    protected CategoryModel $categoryModel;
    protected ImageOptimizer $optimizer;
    protected MediaLibraryModel $mediaModel;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->imageModel    = new ProductImageModel();
        $this->categoryModel = new CategoryModel();
        $this->optimizer     = new ImageOptimizer();
        $this->mediaModel    = new MediaLibraryModel();
    }

    public function index()
    {
        $search     = $this->request->getGet('q');
        $categoryId = $this->request->getGet('category');
        $page       = (int)($this->request->getGet('page') ?? 1);
        $perPage    = 20;

        $builder = $this->productModel;
        if ($search) {
            $builder = $builder->groupStart()->like('name', $search)->orLike('sku', $search)->groupEnd();
        }
        if ($categoryId) {
            $builder = $builder->where('category_id', $categoryId);
        }

        $products   = $builder->orderBy('id', 'DESC')->paginate($perPage, 'default', $page);
        $pager      = $this->productModel->pager;
        $categories = $this->categoryModel->where('is_active', 1)->findAll();

        // Attach primary image to each product
        foreach ($products as &$p) {
            $img = $this->imageModel->where('product_id', $p['id'])->where('is_primary', 1)->first();
            if (! $img) {
                $img = $this->imageModel->where('product_id', $p['id'])->orderBy('sort_order')->first();
            }
            $p['primary_image'] = $img['image_path'] ?? null;
        }

        return view('admin/products/index', [
            'pageTitle'  => 'Products',
            'products'   => $products,
            'pager'      => $pager,
            'categories' => $categories,
            'search'     => $search,
            'categoryId' => $categoryId,
        ]);
    }

    public function create()
    {
        return view('admin/products/form', [
            'pageTitle'  => 'New Product',
            'product'    => null,
            'images'     => [],
            'categories' => $this->categoryModel->where('is_active', 1)->findAll(),
        ]);
    }

    public function save()
    {
        $rules = [
            'name'     => 'required|min_length[2]|max_length[255]',
            'category_id' => 'permit_empty|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/admin/products/new')->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $name = $this->request->getPost('name');
        $slug = ProductModel::makeSlug($name);

        // Ensure unique slug
        $existing = $this->productModel->where('slug', $slug)->first();
        if ($existing) {
            $slug .= '-' . time();
        }

        $specs = [];
        $specKeys   = $this->request->getPost('spec_key')   ?? [];
        $specValues = $this->request->getPost('spec_value') ?? [];
        foreach ($specKeys as $i => $key) {
            if (! empty(trim($key))) {
                $specs[trim($key)] = trim($specValues[$i] ?? '');
            }
        }

        $productId = $this->productModel->insert([
            'category_id'       => $this->request->getPost('category_id') ?: null,
            'name'              => $name,
            'slug'              => $slug,
            'short_description' => $this->request->getPost('short_description'),
            'description'       => $this->request->getPost('description'),
            'specifications'    => empty($specs) ? null : json_encode($specs),
            'sku'               => $this->request->getPost('sku'),
            'is_featured'       => (int)$this->request->getPost('is_featured'),
            'is_active'         => (int)$this->request->getPost('is_active'),
            'meta_title'        => $this->request->getPost('meta_title') ?: $name,
            'meta_description'  => $this->request->getPost('meta_description'),
        ]);

        $this->handleImageUploads($productId);
        $this->handleImageUrls($productId);

        return redirect()->to('/admin/products/edit/' . $productId)
            ->with('success', 'Product created successfully.');
    }

    public function edit(int $id)
    {
        $product = $this->productModel->find($id);
        if (! $product) {
            return redirect()->to('/admin/products')->with('error', 'Product not found.');
        }

        $images = $this->imageModel->where('product_id', $id)->orderBy('sort_order')->findAll();

        if ($product['specifications']) {
            $product['specifications'] = json_decode($product['specifications'], true) ?? [];
        } else {
            $product['specifications'] = [];
        }

        return view('admin/products/form', [
            'pageTitle'  => 'Edit Product',
            'product'    => $product,
            'images'     => $images,
            'categories' => $this->categoryModel->where('is_active', 1)->findAll(),
        ]);
    }

    public function update(int $id)
    {
        $product = $this->productModel->find($id);
        if (! $product) {
            return redirect()->to('/admin/products')->with('error', 'Product not found.');
        }

        $name = $this->request->getPost('name');
        $slug = $product['slug'];

        $specs = [];
        $specKeys   = $this->request->getPost('spec_key')   ?? [];
        $specValues = $this->request->getPost('spec_value') ?? [];
        foreach ($specKeys as $i => $key) {
            if (! empty(trim($key))) {
                $specs[trim($key)] = trim($specValues[$i] ?? '');
            }
        }

        $this->productModel->update($id, [
            'category_id'       => $this->request->getPost('category_id') ?: null,
            'name'              => $name,
            'slug'              => $slug,
            'short_description' => $this->request->getPost('short_description'),
            'description'       => $this->request->getPost('description'),
            'specifications'    => empty($specs) ? null : json_encode($specs),
            'sku'               => $this->request->getPost('sku'),
            'is_featured'       => (int)$this->request->getPost('is_featured'),
            'is_active'         => (int)$this->request->getPost('is_active'),
            'meta_title'        => $this->request->getPost('meta_title') ?: $name,
            'meta_description'  => $this->request->getPost('meta_description'),
        ]);

        $this->handleImageUploads($id);
        $this->handleImageUrls($id);

        return redirect()->to('/admin/products/edit/' . $id)->with('success', 'Product updated successfully.');
    }

    public function delete(int $id)
    {
        $product = $this->productModel->find($id);
        if ($product) {
            $images = $this->imageModel->where('product_id', $id)->findAll();
            foreach ($images as $img) {
                $this->unlinkImageFile($img['image_path']);
            }
            $this->imageModel->where('product_id', $id)->delete();
            $this->productModel->delete($id);
        }
        return redirect()->to('/admin/products')->with('success', 'Product deleted.');
    }

    public function reorderImages()
    {
        $order = $this->request->getJSON(true)['order'] ?? [];
        foreach ($order as $idx => $imageId) {
            $this->imageModel->update((int)$imageId, ['sort_order' => $idx]);
        }
        return $this->response->setJSON(['status' => 'ok']);
    }

    public function deleteImage(int $id)
    {
        $img = $this->imageModel->find($id);
        if ($img) {
            $this->unlinkImageFile($img['image_path']);
            $this->imageModel->delete($id);
            if ($img['is_primary']) {
                $next = $this->imageModel->where('product_id', $img['product_id'])->orderBy('sort_order')->first();
                if ($next) {
                    $this->imageModel->update($next['id'], ['is_primary' => 1]);
                }
            }
        }
        return $this->response->setJSON(['status' => 'ok']);
    }

    /**
     * AJAX: instantly add an image from URL or media library to a product.
     */
    public function addImageFromUrl(int $productId)
    {
        $url = trim($this->request->getPost('url') ?? '');
        if (empty($url) || ! $this->productModel->find($productId)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid.']);
        }

        $existingCount = $this->imageModel->where('product_id', $productId)->countAllResults();
        $hasPrimary    = $this->imageModel->where('product_id', $productId)->where('is_primary', 1)->countAllResults() > 0;
        $isPrimary     = (! $hasPrimary && $existingCount === 0) ? 1 : 0;

        $imageId = $this->imageModel->insert([
            'product_id' => $productId,
            'image_path' => $url,
            'alt_text'   => '',
            'sort_order' => $existingCount,
            'is_primary' => $isPrimary,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON(['status' => 'ok', 'id' => $imageId, 'is_primary' => $isPrimary]);
    }

    public function setPrimaryImage(int $id)
    {
        $img = $this->imageModel->find($id);
        if ($img) {
            $this->imageModel->where('product_id', $img['product_id'])->set(['is_primary' => 0])->update();
            $this->imageModel->update($id, ['is_primary' => 1]);
        }
        return $this->response->setJSON(['status' => 'ok']);
    }

    private function handleImageUploads(int $productId): void
    {
        $files = $this->request->getFiles();
        if (empty($files['images'])) {
            return;
        }

        $uploadDir = FCPATH . 'uploads/media/products';
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $existingCount = $this->imageModel->where('product_id', $productId)->countAllResults();
        $hasPrimary    = $this->imageModel->where('product_id', $productId)->where('is_primary', 1)->countAllResults() > 0;

        foreach ($files['images'] as $idx => $file) {
            if (! $file->isValid() || $file->hasMoved()) {
                continue;
            }
            $ext = strtolower($file->getClientExtension());
            if (! in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                continue;
            }
            if ($file->getSize() > 5 * 1024 * 1024) {
                continue;
            }

            // Move to a temp file, then run through the optimizer
            $tmpName  = bin2hex(random_bytes(12)) . '_orig.' . $ext;
            $origName = $file->getClientName();
            $file->move($uploadDir, $tmpName);

            $baseName = bin2hex(random_bytes(8));
            $result   = $this->optimizer->process($uploadDir . '/' . $tmpName, $uploadDir, $baseName);
            if (isset($result['error'])) {
                continue;
            }

            // Register in media_library
            $this->mediaModel->insert([
                'filename'      => $result['filename'],
                'original_name' => $origName,
                'folder'        => 'products',
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

            $imageUrl  = '/uploads/media/products/' . $result['filename'];
            $isPrimary = (! $hasPrimary && $existingCount === 0 && $idx === 0) ? 1 : 0;
            if ($isPrimary) {
                $hasPrimary = true;
            }

            $this->imageModel->insert([
                'product_id' => $productId,
                'image_path' => $imageUrl,
                'alt_text'   => $origName,
                'sort_order' => $existingCount + $idx,
                'is_primary' => $isPrimary,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $existingCount++;
        }
    }

    /**
     * Handle image_urls[] POSTed from the form (library picks or external URLs
     * added before saving on NEW product forms via hidden inputs).
     */
    private function handleImageUrls(int $productId): void
    {
        $urls = $this->request->getPost('image_urls') ?? [];
        if (empty($urls)) {
            return;
        }

        $existingCount = $this->imageModel->where('product_id', $productId)->countAllResults();
        $hasPrimary    = $this->imageModel->where('product_id', $productId)->where('is_primary', 1)->countAllResults() > 0;

        foreach ($urls as $idx => $url) {
            $url = trim($url);
            if (empty($url)) {
                continue;
            }
            $isPrimary = (! $hasPrimary && $existingCount === 0 && $idx === 0) ? 1 : 0;
            if ($isPrimary) {
                $hasPrimary = true;
            }

            $this->imageModel->insert([
                'product_id' => $productId,
                'image_path' => $url,
                'alt_text'   => '',
                'sort_order' => $existingCount + $idx,
                'is_primary' => $isPrimary,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $existingCount++;
        }
    }

    /**
     * Delete a local file referenced by image_path (handles legacy bare filenames
     * and new full-path format; silently skips external URLs).
     */
    private function unlinkImageFile(string $imagePath): void
    {
        if (str_starts_with($imagePath, 'http')) {
            return; // external URL — nothing to delete from disk
        }
        if (str_starts_with($imagePath, '/')) {
            $path = FCPATH . ltrim($imagePath, '/');
        } else {
            // Legacy: bare filename stored without leading slash
            $path = FCPATH . 'uploads/products/' . $imagePath;
        }
        if (is_file($path)) {
            unlink($path);
        }
    }
}
