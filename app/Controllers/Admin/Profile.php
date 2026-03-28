<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\AuditLogModel;

class Profile extends BaseController
{
    protected AdminModel $model;

    public function __construct()
    {
        $this->model = new AdminModel();
    }

    public function index()
    {
        $admin = $this->model->find(session()->get('admin_id'));
        if (! $admin) {
            return redirect()->to('/admin')->with('error', 'Admin account not found.');
        }

        return view('admin/profile/index', [
            'pageTitle' => 'My Profile',
            'admin'     => $admin,
        ]);
    }

    public function saveInfo()
    {
        $id    = (int) session()->get('admin_id');
        $admin = $this->model->find($id);
        if (! $admin) {
            return redirect()->to('/admin/profile')->with('error', 'Account not found.');
        }

        $username = trim($this->request->getPost('username') ?? '');
        $email    = trim($this->request->getPost('email') ?? '');

        if (empty($username) || strlen($username) < 3) {
            return redirect()->to('/admin/profile')->withInput()->with('error', 'Username must be at least 3 characters.');
        }
        if (empty($email) || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->to('/admin/profile')->withInput()->with('error', 'A valid email address is required.');
        }

        // Check username uniqueness (excluding self)
        $taken = $this->model->where('username', $username)->where('id !=', $id)->first();
        if ($taken) {
            return redirect()->to('/admin/profile')->withInput()->with('error', 'That username is already taken.');
        }

        // Check email uniqueness (excluding self)
        $taken = $this->model->where('email', $email)->where('id !=', $id)->first();
        if ($taken) {
            return redirect()->to('/admin/profile')->withInput()->with('error', 'That email address is already in use.');
        }

        $this->model->update($id, ['username' => $username, 'email' => $email]);

        // Update session username if it changed
        if ($username !== $admin['username']) {
            session()->set('admin_username', $username);
        }

        AuditLogModel::record('profile_updated', 'admins', $id, "Profile info updated");

        return redirect()->to('/admin/profile')->with('success', 'Profile information updated.');
    }

    public function changePassword()
    {
        $id    = (int) session()->get('admin_id');
        $admin = $this->model->find($id);
        if (! $admin) {
            return redirect()->to('/admin/profile')->with('error', 'Account not found.');
        }

        $current = $this->request->getPost('current_password') ?? '';
        $new     = $this->request->getPost('new_password') ?? '';
        $confirm = $this->request->getPost('confirm_password') ?? '';

        if (! password_verify($current, $admin['password'])) {
            return redirect()->to('/admin/profile#password')->with('error', 'Current password is incorrect.');
        }
        if (strlen($new) < 8) {
            return redirect()->to('/admin/profile#password')->with('error', 'New password must be at least 8 characters.');
        }
        if (! preg_match('/[A-Z]/', $new)) {
            return redirect()->to('/admin/profile#password')->with('error', 'New password must contain at least one uppercase letter.');
        }
        if (! preg_match('/[0-9]/', $new)) {
            return redirect()->to('/admin/profile#password')->with('error', 'New password must contain at least one number.');
        }
        if (! preg_match('/[^A-Za-z0-9]/', $new)) {
            return redirect()->to('/admin/profile#password')->with('error', 'New password must contain at least one special character.');
        }
        if ($new !== $confirm) {
            return redirect()->to('/admin/profile#password')->with('error', 'New passwords do not match.');
        }

        $this->model->update($id, ['password' => password_hash($new, PASSWORD_BCRYPT)]);
        AuditLogModel::record('password_changed', 'admins', $id, "Password changed via profile");

        return redirect()->to('/admin/profile')->with('success', 'Password changed successfully.');
    }

    public function toggle2fa()
    {
        $id    = (int) session()->get('admin_id');
        $admin = $this->model->find($id);
        if (! $admin) {
            return redirect()->to('/admin/profile')->with('error', 'Account not found.');
        }

        $current = (int) ($admin['two_fa_enabled'] ?? 0);
        $new     = $current ? 0 : 1;

        $this->model->update($id, ['two_fa_enabled' => $new]);
        AuditLogModel::record('2fa_toggled', 'admins', $id, '2FA ' . ($new ? 'enabled' : 'disabled'));

        $msg = $new ? 'Two-factor authentication enabled.' : 'Two-factor authentication disabled.';
        return redirect()->to('/admin/profile')->with('success', $msg);
    }
}
