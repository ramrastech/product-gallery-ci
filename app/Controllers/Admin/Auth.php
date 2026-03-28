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
use App\Models\AuditLogModel;
use App\Models\PasswordResetModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }
        return view('admin/auth/login', [
            'title'              => 'Admin Login',
            'rememberedUsername' => get_cookie('admin_remember_me') ?? '',
        ]);
    }

    public function loginPost()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Please enter username and password.');
        }

        $rememberMe = (bool) $this->request->getPost('remember_me');

        $adminModel = new AdminModel();
        $admin = $adminModel->where('username', $username)->orWhere('email', $username)->first();

        if (! $admin || ! password_verify($password, $admin['password'])) {
            AuditLogModel::record('login_failed', 'admin', null, "Failed login attempt for: {$username}");
            return redirect()->back()->with('error', 'Invalid credentials.')->withInput();
        }

        // Handle remember-me cookie (stores username for auto-fill, 30 days)
        if ($rememberMe) {
            set_cookie('admin_remember_me', $username, 60 * 60 * 24 * 30);
        } else {
            delete_cookie('admin_remember_me');
        }

        // If 2FA is enabled, send OTP and redirect to verify step
        if (! empty($admin['two_fa_enabled'])) {
            $otp     = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));

            $adminModel->update($admin['id'], [
                'otp_code'       => $otp,
                'otp_expires_at' => $expires,
            ]);

            $this->sendOtpEmail($admin['email'], $admin['username'], $otp);

            session()->set('admin_2fa_pending_id', $admin['id']);
            return redirect()->to('/admin/verify-otp');
        }

        $this->completeLogin($admin, $adminModel);
        return redirect()->to('/admin');
    }

    public function verifyOtp()
    {
        if (! session()->get('admin_2fa_pending_id')) {
            return redirect()->to('/admin/login');
        }
        return view('admin/auth/verify_otp');
    }

    public function verifyOtpPost()
    {
        $pendingId = session()->get('admin_2fa_pending_id');
        if (! $pendingId) {
            return redirect()->to('/admin/login');
        }

        $adminModel = new AdminModel();
        $admin      = $adminModel->find($pendingId);

        if (! $admin) {
            return redirect()->to('/admin/login')->with('error', 'Session expired. Please log in again.');
        }

        $submitted = trim($this->request->getPost('otp'));

        if (
            empty($admin['otp_code']) ||
            $submitted !== $admin['otp_code'] ||
            strtotime($admin['otp_expires_at']) < time()
        ) {
            return redirect()->back()->with('error', 'Invalid or expired OTP. Please try again.');
        }

        // Clear OTP
        $adminModel->update($admin['id'], ['otp_code' => null, 'otp_expires_at' => null]);

        session()->remove('admin_2fa_pending_id');
        $this->completeLogin($admin, $adminModel);
        return redirect()->to('/admin');
    }

    public function logout()
    {
        AuditLogModel::record('logout', 'admin', session()->get('admin_id'));
        session()->destroy();
        return redirect()->to('/admin/login')->with('success', 'Logged out successfully.');
    }

    // -------------------------------------------------------
    // Forgot / Reset Password
    // -------------------------------------------------------

    public function forgotPassword()
    {
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }
        return view('admin/auth/forgot_password');
    }

    public function forgotPasswordPost()
    {
        $email = trim($this->request->getPost('email'));

        if (empty($email) || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Please enter a valid email address.');
        }

        $adminModel = new AdminModel();
        $admin      = $adminModel->where('email', $email)->first();

        // Always show success to prevent email enumeration
        if ($admin) {
            $resetModel = new PasswordResetModel();
            $token      = $resetModel->createToken($email);
            $this->sendResetEmail($email, $admin['username'], $token);
            AuditLogModel::record('password_reset_requested', 'admin', $admin['id']);
        }

        return redirect()->to('/admin/forgot-password')
            ->with('success', 'If that email is registered, a reset link has been sent. Check your inbox.');
    }

    public function resetPassword(string $token)
    {
        $resetModel = new PasswordResetModel();
        $record     = $resetModel->findValidToken($token);

        if (! $record) {
            return redirect()->to('/admin/forgot-password')
                ->with('error', 'This reset link is invalid or has expired.');
        }

        return view('admin/auth/reset_password', ['token' => $token]);
    }

    public function resetPasswordPost()
    {
        $token    = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $confirm  = $this->request->getPost('confirm_password');

        $resetModel = new PasswordResetModel();
        $record     = $resetModel->findValidToken($token);

        if (! $record) {
            return redirect()->to('/admin/forgot-password')
                ->with('error', 'This reset link is invalid or has expired.');
        }

        if (empty($password) || strlen($password) < 8) {
            return redirect()->back()->withInput()->with('error', 'Password must be at least 8 characters.');
        }

        if (! preg_match('/[A-Z]/', $password)) {
            return redirect()->back()->withInput()->with('error', 'Password must contain at least one uppercase letter.');
        }

        if (! preg_match('/[0-9]/', $password)) {
            return redirect()->back()->withInput()->with('error', 'Password must contain at least one number.');
        }

        if (! preg_match('/[^A-Za-z0-9]/', $password)) {
            return redirect()->back()->withInput()->with('error', 'Password must contain at least one special character.');
        }

        if ($password !== $confirm) {
            return redirect()->back()->withInput()->with('error', 'Passwords do not match.');
        }

        $adminModel = new AdminModel();
        $admin      = $adminModel->where('email', $record['email'])->first();

        if ($admin) {
            $adminModel->update($admin['id'], ['password' => password_hash($password, PASSWORD_BCRYPT)]);
            $resetModel->markUsed($token);
            AuditLogModel::record('password_reset_completed', 'admin', $admin['id']);
        }

        return redirect()->to('/admin/login')->with('success', 'Password reset successfully. You can now log in.');
    }

    // -------------------------------------------------------
    // Helpers
    // -------------------------------------------------------

    private function completeLogin(array $admin, AdminModel $adminModel): void
    {
        session()->set([
            'admin_logged_in' => true,
            'admin_id'        => $admin['id'],
            'admin_username'  => $admin['username'],
            'admin_role'      => $admin['role'] ?? 'super_admin',
        ]);

        $adminModel->update($admin['id'], ['last_login' => date('Y-m-d H:i:s')]);
        AuditLogModel::record('login', 'admin', $admin['id']);
    }

    private function sendOtpEmail(string $to, string $username, string $otp): void
    {
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setSubject('Your Login OTP — Product Gallery');
        $email->setMessage("
            <p>Hi {$username},</p>
            <p>Your one-time login code is: <strong style='font-size:24px;letter-spacing:4px'>{$otp}</strong></p>
            <p>This code expires in <strong>10 minutes</strong>. Do not share it with anyone.</p>
            <p>If you did not request this, please secure your account immediately.</p>
            <p>— Product Gallery Admin</p>
        ");
        $email->send();
    }

    private function sendResetEmail(string $to, string $username, string $token): void
    {
        $resetUrl = base_url('/admin/reset-password/' . $token);
        $email    = \Config\Services::email();
        $email->setTo($to);
        $email->setSubject('Reset Your Password — Product Gallery');
        $email->setMessage("
            <p>Hi {$username},</p>
            <p>We received a request to reset your admin password.</p>
            <p><a href='{$resetUrl}' style='background:#6366f1;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;display:inline-block;'>Reset Password</a></p>
            <p>Or copy this link:<br><small>{$resetUrl}</small></p>
            <p>This link expires in <strong>60 minutes</strong>. If you did not request this, ignore this email.</p>
            <p>— Product Gallery Admin</p>
        ");
        $email->send();
    }
}
