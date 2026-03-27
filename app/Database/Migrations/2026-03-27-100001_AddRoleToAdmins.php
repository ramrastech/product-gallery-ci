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

class AddRoleToAdmins extends Migration
{
    public function up(): void
    {
        if (! $this->db->fieldExists('role', 'admins')) {
            $this->forge->addColumn('admins', [
                'role' => [
                    'type'       => "ENUM('super_admin','manager','viewer')",
                    'null'       => false,
                    'default'    => 'super_admin',
                    'after'      => 'username',
                ],
            ]);
        }
    }

    public function down(): void
    {
        if ($this->db->fieldExists('role', 'admins')) {
            $this->forge->dropColumn('admins', 'role');
        }
    }
}
