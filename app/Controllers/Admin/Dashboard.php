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
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\EnquiryModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $productModel  = new ProductModel();
        $categoryModel = new CategoryModel();
        $enquiryModel  = new EnquiryModel();

        $data = [
            'pageTitle'      => 'Dashboard',
            'totalProducts'  => $productModel->where('is_active', 1)->countAllResults(),
            'totalCategories'=> $categoryModel->where('is_active', 1)->countAllResults(),
            'totalEnquiries' => $enquiryModel->countAllResults(),
            'newEnquiries'   => $enquiryModel->where('status', 'new')->countAllResults(),
            'recentEnquiries'=> $enquiryModel->orderBy('id', 'DESC')->limit(5)->findAll(),
            'topProducts'    => $productModel->getTopViewed(5),
        ];

        return view('admin/dashboard/index', $data);
    }
}
