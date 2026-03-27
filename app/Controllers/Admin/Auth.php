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
use App\Models\AdminModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }
        return view('admin/auth/login', ['title' => 'Admin Login']);
    }

    public function loginPost()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Please enter username and password.');
        }

        $adminModel = new AdminModel();
        $admin = $adminModel->where('username', $username)->orWhere('email', $username)->first();

        if (! $admin || ! password_verify($password, $admin['password'])) {
            return redirect()->back()->with('error', 'Invalid credentials.')->withInput();
        }

        session()->set([
            'admin_logged_in' => true,
            'admin_id'        => $admin['id'],
            'admin_username'  => $admin['username'],
        ]);

        $adminModel->update($admin['id'], ['last_login' => date('Y-m-d H:i:s')]);

        return redirect()->to('/admin');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login')->with('success', 'Logged out successfully.');
    }
}
