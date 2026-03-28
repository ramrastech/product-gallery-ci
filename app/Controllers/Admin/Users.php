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

class Users extends BaseController
{
    protected AdminModel $model;

    protected array $validRoles = ['super_admin', 'manager', 'viewer'];

    public function __construct()
    {
        $this->model = new AdminModel();
    }

    public function index()
    {
        $users = $this->model->withDeleted()->orderBy('id', 'ASC')->findAll();

        return view('admin/users/index', [
            'pageTitle' => 'Admin Users',
            'users'     => $users,
            'selfId'    => (int) session()->get('admin_id'),
        ]);
    }

    public function create()
    {
        return view('admin/users/form', [
            'pageTitle' => 'New Admin User',
            'user'      => null,
            'roles'     => $this->validRoles,
        ]);
    }

    public function save()
    {
        $username = trim($this->request->getPost('username') ?? '');
        $email    = trim($this->request->getPost('email') ?? '');
        $password = $this->request->getPost('password') ?? '';
        $confirm  = $this->request->getPost('confirm_password') ?? '';
        $role     = $this->request->getPost('role') ?? 'viewer';

        $err = $this->validateUserInput($username, $email, $password, $confirm, $role);
        if ($err) {
            return redirect()->to('/admin/users/new')->withInput()->with('error', $err);
        }

        // Uniqueness checks
        if ($this->model->where('username', $username)->first()) {
            return redirect()->to('/admin/users/new')->withInput()->with('error', 'Username already exists.');
        }
        if ($this->model->where('email', $email)->first()) {
            return redirect()->to('/admin/users/new')->withInput()->with('error', 'Email address already in use.');
        }

        $id = $this->model->insert([
            'username'   => $username,
            'email'      => $email,
            'password'   => password_hash($password, PASSWORD_BCRYPT),
            'role'       => $role,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        AuditLogModel::record('user_created', 'admins', $id, "Created admin: {$username} ({$role})");

        return redirect()->to('/admin/users')->with('success', "User '{$username}' created successfully.");
    }

    public function edit(int $id)
    {
        $user = $this->model->withDeleted()->find($id);
        if (! $user) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        return view('admin/users/form', [
            'pageTitle' => 'Edit User — ' . esc($user['username']),
            'user'      => $user,
            'roles'     => $this->validRoles,
            'selfId'    => (int) session()->get('admin_id'),
        ]);
    }

    public function update(int $id)
    {
        $user = $this->model->withDeleted()->find($id);
        if (! $user) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        $username = trim($this->request->getPost('username') ?? '');
        $email    = trim($this->request->getPost('email') ?? '');
        $role     = $this->request->getPost('role') ?? $user['role'];
        $password = $this->request->getPost('new_password') ?? '';
        $confirm  = $this->request->getPost('confirm_password') ?? '';

        if (empty($username) || strlen($username) < 3) {
            return redirect()->to('/admin/users/edit/' . $id)->withInput()->with('error', 'Username must be at least 3 characters.');
        }
        if (empty($email) || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->to('/admin/users/edit/' . $id)->withInput()->with('error', 'A valid email address is required.');
        }
        if (! in_array($role, $this->validRoles, true)) {
            return redirect()->to('/admin/users/edit/' . $id)->withInput()->with('error', 'Invalid role selected.');
        }

        // Uniqueness checks (excluding self)
        if ($this->model->where('username', $username)->where('id !=', $id)->first()) {
            return redirect()->to('/admin/users/edit/' . $id)->withInput()->with('error', 'Username already taken.');
        }
        if ($this->model->where('email', $email)->where('id !=', $id)->first()) {
            return redirect()->to('/admin/users/edit/' . $id)->withInput()->with('error', 'Email address already in use.');
        }

        // Prevent demoting the last super_admin
        if ($user['role'] === 'super_admin' && $role !== 'super_admin') {
            $superCount = $this->model->where('role', 'super_admin')->countAllResults();
            if ($superCount <= 1) {
                return redirect()->to('/admin/users/edit/' . $id)->withInput()
                    ->with('error', 'Cannot change role — this is the last super_admin account.');
            }
        }

        $data = ['username' => $username, 'email' => $email, 'role' => $role];

        // Optional password reset
        if (! empty($password)) {
            $passErr = $this->validatePassword($password, $confirm);
            if ($passErr) {
                return redirect()->to('/admin/users/edit/' . $id)->withInput()->with('error', $passErr);
            }
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $this->model->update($id, $data);
        AuditLogModel::record('user_updated', 'admins', $id, "Updated admin: {$username} ({$role})");

        return redirect()->to('/admin/users')->with('success', "User '{$username}' updated successfully.");
    }

    public function delete(int $id)
    {
        $selfId = (int) session()->get('admin_id');

        if ($id === $selfId) {
            return redirect()->to('/admin/users')->with('error', 'You cannot delete your own account.');
        }

        $user = $this->model->find($id);
        if (! $user) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        // Prevent deleting the last super_admin
        if ($user['role'] === 'super_admin') {
            $superCount = $this->model->where('role', 'super_admin')->countAllResults();
            if ($superCount <= 1) {
                return redirect()->to('/admin/users')->with('error', 'Cannot delete the last super_admin account.');
            }
        }

        $this->model->delete($id);
        AuditLogModel::record('user_deleted', 'admins', $id, "Deleted admin: {$user['username']}");

        return redirect()->to('/admin/users')->with('success', "User '{$user['username']}' deleted.");
    }

    public function restore(int $id)
    {
        $user = $this->model->withDeleted()->find($id);
        if (! $user) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        $this->model->update($id, ['deleted_at' => null]);
        AuditLogModel::record('user_restored', 'admins', $id, "Restored admin: {$user['username']}");

        return redirect()->to('/admin/users')->with('success', "User '{$user['username']}' restored.");
    }

    // ── Private helpers ──────────────────────────────────────────────────────

    private function validateUserInput(string $username, string $email, string $password, string $confirm, string $role): ?string
    {
        if (strlen($username) < 3) return 'Username must be at least 3 characters.';
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) return 'A valid email address is required.';
        if (! in_array($role, $this->validRoles, true)) return 'Invalid role selected.';
        return $this->validatePassword($password, $confirm);
    }

    private function validatePassword(string $password, string $confirm): ?string
    {
        if (strlen($password) < 8)               return 'Password must be at least 8 characters.';
        if (! preg_match('/[A-Z]/', $password))   return 'Password must contain at least one uppercase letter.';
        if (! preg_match('/[0-9]/', $password))   return 'Password must contain at least one number.';
        if (! preg_match('/[^A-Za-z0-9]/', $password)) return 'Password must contain at least one special character.';
        if ($password !== $confirm)               return 'Passwords do not match.';
        return null;
    }
}
