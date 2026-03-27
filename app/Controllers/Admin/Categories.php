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

    public function save()
    {
        $name = $this->request->getPost('name');
        if (empty(trim($name))) {
            return redirect()->back()->with('error', 'Name is required.');
        }

        $slug = strtolower(trim(preg_replace('/[^a-z0-9\s-]/i', '', $name)));
        $slug = preg_replace('/[\s-]+/', '-', $slug);

        $this->model->insert([
            'name'        => $name,
            'slug'        => $slug . '-' . time(),
            'parent_id'   => $this->request->getPost('parent_id') ?: null,
            'description' => $this->request->getPost('description'),
            'is_active'   => (int)$this->request->getPost('is_active'),
        ]);

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
        $name = $this->request->getPost('name');
        $this->model->update($id, [
            'name'        => $name,
            'parent_id'   => $this->request->getPost('parent_id') ?: null,
            'description' => $this->request->getPost('description'),
            'is_active'   => (int)$this->request->getPost('is_active'),
        ]);
        return redirect()->to('/admin/categories')->with('success', 'Category updated.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/categories')->with('success', 'Category deleted.');
    }
}
