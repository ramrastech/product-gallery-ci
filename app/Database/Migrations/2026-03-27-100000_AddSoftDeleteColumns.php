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

class AddSoftDeleteColumns extends Migration
{
    private array $tables = ['products', 'categories', 'admins', 'enquiries', 'product_images'];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (! $this->db->fieldExists('deleted_at', $table)) {
                $this->forge->addColumn($table, [
                    'deleted_at' => [
                        'type'       => 'DATETIME',
                        'null'       => true,
                        'default'    => null,
                        'after'      => 'id',
                    ],
                ]);
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            if ($this->db->fieldExists('deleted_at', $table)) {
                $this->forge->dropColumn($table, 'deleted_at');
            }
        }
    }
}
