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

namespace App\Models;

use CodeIgniter\Model;

class PasswordResetModel extends Model
{
    protected $table            = 'password_resets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['email', 'token', 'expires_at', 'used', 'created_at'];

    protected $useTimestamps = false;

    public function createToken(string $email): string
    {
        // Invalidate any existing tokens for this email
        $this->where('email', $email)->set(['used' => 1])->update();

        $token = bin2hex(random_bytes(32));
        $this->insert([
            'email'      => $email,
            'token'      => $token,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+60 minutes')),
            'used'       => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $token;
    }

    public function findValidToken(string $token): ?array
    {
        return $this->where('token', $token)
            ->where('used', 0)
            ->where('expires_at >', date('Y-m-d H:i:s'))
            ->first();
    }

    public function markUsed(string $token): void
    {
        $this->where('token', $token)->set(['used' => 1])->update();
    }
}
