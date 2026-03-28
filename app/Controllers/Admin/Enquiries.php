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
use App\Models\EnquiryModel;
use App\Models\ProductModel;

class Enquiries extends BaseController
{
    protected EnquiryModel $model;

    public function __construct()
    {
        $this->model = new EnquiryModel();
    }

    public function index()
    {
        $status = $this->request->getGet('status');
        $page   = (int)($this->request->getGet('page') ?? 1);

        $builder = $this->model;
        if ($status) {
            $builder = $builder->where('status', $status);
        }

        $enquiries = $builder->orderBy('id', 'DESC')->paginate(20, 'default', $page);
        $pager     = $this->model->pager;

        $productModel = new ProductModel();
        foreach ($enquiries as &$e) {
            if ($e['product_id']) {
                $p = $productModel->find($e['product_id']);
                $e['product_name'] = $p['name'] ?? 'Deleted Product';
            } else {
                $e['product_name'] = '—';
            }
        }

        return view('admin/enquiries/index', [
            'pageTitle'  => 'Enquiries',
            'enquiries'  => $enquiries,
            'pager'      => $pager,
            'status'     => $status,
        ]);
    }

    public function view(int $id)
    {
        $enquiry = $this->model->find($id);
        if (! $enquiry) {
            return redirect()->to('/admin/enquiries')->with('error', 'Enquiry not found.');
        }

        if ($enquiry['status'] === 'new') {
            $this->model->update($id, ['status' => 'read']);
            $enquiry['status'] = 'read';
        }

        $product = null;
        if ($enquiry['product_id']) {
            $product = (new ProductModel())->find($enquiry['product_id']);
        }

        return view('admin/enquiries/view', [
            'pageTitle' => 'Enquiry #' . $id,
            'enquiry'   => $enquiry,
            'product'   => $product,
        ]);
    }

    public function updateStatus(int $id)
    {
        $status = $this->request->getPost('status');
        if (in_array($status, ['new', 'read', 'replied'])) {
            $this->model->update($id, ['status' => $status]);
        }
        return redirect()->to('/admin/enquiries/view/' . $id)->with('success', 'Status updated.');
    }
}
