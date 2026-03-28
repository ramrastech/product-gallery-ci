<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FaqModel;

class FaqContent extends BaseController
{
    private FaqModel $itemModel;
    private \CodeIgniter\Database\BaseConnection $db;

    public function __construct()
    {
        $this->itemModel = new FaqModel();
        $this->db        = \Config\Database::connect();
    }

    public function index()
    {
        $categories = $this->db->table('faq_categories')
                               ->orderBy('sort_order')
                               ->get()->getResultArray();

        $grouped = [];
        foreach ($categories as $cat) {
            $grouped[] = [
                'category' => $cat,
                'items'    => $this->itemModel->where('category_id', $cat['id'])
                                              ->orderBy('sort_order')
                                              ->findAll(),
            ];
        }

        return view('admin/faq_content/index', [
            'pageTitle' => 'FAQ Management',
            'grouped'   => $grouped,
        ]);
    }

    // --- Category CRUD ---

    public function saveCategory()
    {
        $id   = (int) ($this->request->getPost('id') ?? 0);
        $name = trim($this->request->getPost('name') ?? '');

        if (empty($name)) {
            return redirect()->to('/admin/faq')->with('error', 'Category name is required.');
        }

        if ($id > 0) {
            $this->db->table('faq_categories')->update(['name' => $name], ['id' => $id]);
            $msg = 'Category updated.';
        } else {
            $maxOrder = (int) ($this->db->table('faq_categories')->selectMax('sort_order')->get()->getRowArray()['sort_order'] ?? -1);
            $this->db->table('faq_categories')->insert([
                'name'       => $name,
                'sort_order' => $maxOrder + 1,
                'is_active'  => 1,
            ]);
            $msg = 'Category added.';
        }

        return redirect()->to('/admin/faq')->with('success', $msg);
    }

    public function deleteCategory(int $id)
    {
        $count = $this->itemModel->where('category_id', $id)->countAllResults();
        if ($count > 0) {
            return redirect()->to('/admin/faq')->with('error', 'Cannot delete a category that has FAQ items. Delete the items first.');
        }
        $this->db->table('faq_categories')->delete(['id' => $id]);
        return redirect()->to('/admin/faq')->with('success', 'Category deleted.');
    }

    // --- FAQ Item CRUD ---

    public function newItem(int $categoryId = 0)
    {
        $categories = $this->db->table('faq_categories')->orderBy('sort_order')->get()->getResultArray();
        return view('admin/faq_content/item_form', [
            'pageTitle'   => 'Add FAQ Item',
            'item'        => null,
            'categories'  => $categories,
            'categoryId'  => $categoryId,
        ]);
    }

    public function editItem(int $id)
    {
        $item = $this->itemModel->find($id);
        if (! $item) {
            return redirect()->to('/admin/faq')->with('error', 'Item not found.');
        }
        $categories = $this->db->table('faq_categories')->orderBy('sort_order')->get()->getResultArray();
        return view('admin/faq_content/item_form', [
            'pageTitle'  => 'Edit FAQ Item',
            'item'       => $item,
            'categories' => $categories,
            'categoryId' => $item['category_id'],
        ]);
    }

    public function saveItem()
    {
        $id         = (int) ($this->request->getPost('id') ?? 0);
        $categoryId = (int) ($this->request->getPost('category_id') ?? 0);
        $question   = trim($this->request->getPost('question') ?? '');
        $answer     = $this->request->getPost('answer') ?? '';

        if (empty($question) || empty($answer)) {
            $formUrl = $id > 0 ? '/admin/faq/item/edit/' . $id : '/admin/faq/item/new';
            return redirect()->to($formUrl)->withInput()->with('error', 'Question and answer are required.');
        }

        $data = [
            'category_id' => $categoryId,
            'question'    => $question,
            'answer'      => $answer,
            'is_active'   => (int) ($this->request->getPost('is_active') ?? 1),
        ];

        if ($id > 0) {
            $this->itemModel->update($id, $data);
            $msg = 'FAQ item updated.';
        } else {
            $maxOrder     = $this->itemModel->where('category_id', $categoryId)->selectMax('sort_order')->first();
            $data['sort_order'] = ($maxOrder['sort_order'] ?? -1) + 1;
            $this->itemModel->insert($data);
            $msg = 'FAQ item added.';
        }

        return redirect()->to('/admin/faq')->with('success', $msg);
    }

    public function deleteItem(int $id)
    {
        $this->itemModel->delete($id);
        return redirect()->to('/admin/faq')->with('success', 'FAQ item deleted.');
    }

    public function reorderItem(int $id)
    {
        $direction = $this->request->getPost('direction');
        if (in_array($direction, ['up', 'down'])) {
            $item = $this->itemModel->find($id);
            if (! $item) return redirect()->to('/admin/faq');

            $sibling = $this->itemModel->where('category_id', $item['category_id']);
            if ($direction === 'up') {
                $sibling = $sibling->where('sort_order <', $item['sort_order'])
                                   ->orderBy('sort_order', 'DESC')->first();
            } else {
                $sibling = $sibling->where('sort_order >', $item['sort_order'])
                                   ->orderBy('sort_order', 'ASC')->first();
            }
            if ($sibling) {
                $this->itemModel->update($id,           ['sort_order' => $sibling['sort_order']]);
                $this->itemModel->update($sibling['id'], ['sort_order' => $item['sort_order']]);
            }
        }
        return redirect()->to('/admin/faq')->with('success', 'Order updated.');
    }
}
