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

class CreateEnquiriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'product_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true, 'default' => null],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 150],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'phone'      => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'message'    => ['type' => 'TEXT', 'null' => true],
            'status'     => ['type' => 'ENUM', 'constraint' => ['new', 'read', 'replied'], 'default' => 'new'],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('product_id');
        $this->forge->addKey('status');
        $this->forge->createTable('enquiries');
    }

    public function down()
    {
        $this->forge->dropTable('enquiries');
    }
}
