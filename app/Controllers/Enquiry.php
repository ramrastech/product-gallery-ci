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

namespace App\Controllers;

use App\Models\EnquiryModel;
use App\Models\ProductModel;
use App\Models\SettingsModel;

class Enquiry extends BaseController
{
    public function submit()
    {
        $rules = [
            'name'    => 'required|min_length[2]|max_length[150]',
            'email'   => 'required|valid_email',
            'message' => 'permit_empty|max_length[2000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('enquiry_error', implode('<br>', $this->validator->getErrors()));
        }

        $productId = (int)$this->request->getPost('product_id') ?: null;

        // Prepend company and category to message if provided (contact page fields)
        $message  = $this->request->getPost('message') ?? '';
        $company  = trim($this->request->getPost('company') ?? '');
        $category = trim($this->request->getPost('product_category') ?? '');
        $prefix   = '';
        if ($company)  $prefix .= "Company: {$company}\n";
        if ($category) $prefix .= "Category of Interest: {$category}\n";
        if ($prefix)   $message = rtrim($prefix) . "\n\n" . $message;

        $enquiryId = (new EnquiryModel())->insert([
            'product_id' => $productId,
            'name'       => $this->request->getPost('name'),
            'email'      => $this->request->getPost('email'),
            'phone'      => $this->request->getPost('phone'),
            'message'    => $message,
            'ip_address' => $this->request->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Send email notification if configured
        $enquiryEmail = (new SettingsModel())->get('enquiry_email');
        if ($enquiryEmail && filter_var($enquiryEmail, FILTER_VALIDATE_EMAIL)) {
            try {
                $email = \Config\Services::email();
                $productName = '';
                if ($productId) {
                    $product = (new ProductModel())->find($productId);
                    $productName = $product['name'] ?? '';
                }
                $email->setFrom('noreply@' . $_SERVER['HTTP_HOST'], (new SettingsModel())->get('site_name', 'Product Gallery'));
                $email->setTo($enquiryEmail);
                $email->setSubject('New Enquiry' . ($productName ? ': ' . $productName : ''));
                $email->setMessage(
                    "<b>Name:</b> " . esc($this->request->getPost('name')) . "<br>" .
                    "<b>Email:</b> " . esc($this->request->getPost('email')) . "<br>" .
                    "<b>Phone:</b> " . esc($this->request->getPost('phone')) . "<br>" .
                    ($productName ? "<b>Product:</b> {$productName}<br>" : '') .
                    "<b>Message:</b><br>" . nl2br(esc($this->request->getPost('message')))
                );
                $email->send();
            } catch (\Exception $e) {
                // Fail silently — enquiry is already stored in DB
                log_message('error', 'Enquiry email failed: ' . $e->getMessage());
            }
        }

        $redirectTo = $this->request->getPost('redirect_to') ?: '/';
        return redirect()->to($redirectTo)->with('enquiry_success', 'Thank you! We\'ll get back to you shortly.');
    }
}
