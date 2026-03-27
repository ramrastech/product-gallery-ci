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

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Add2FAColumnsToAdmins extends Migration
{
    public function up(): void
    {
        $fields = [];

        if (! $this->db->fieldExists('two_fa_enabled', 'admins')) {
            $fields['two_fa_enabled'] = [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'null'       => false,
                'after'      => 'last_login',
            ];
        }

        if (! $this->db->fieldExists('otp_code', 'admins')) {
            $fields['otp_code'] = [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
                'default'    => null,
                'after'      => 'two_fa_enabled',
            ];
        }

        if (! $this->db->fieldExists('otp_expires_at', 'admins')) {
            $fields['otp_expires_at'] = [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
                'after'   => 'otp_code',
            ];
        }

        if (! empty($fields)) {
            $this->forge->addColumn('admins', $fields);
        }
    }

    public function down(): void
    {
        foreach (['two_fa_enabled', 'otp_code', 'otp_expires_at'] as $col) {
            if ($this->db->fieldExists($col, 'admins')) {
                $this->forge->dropColumn('admins', $col);
            }
        }
    }
}
