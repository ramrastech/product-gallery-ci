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

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'category_id'       => ['type' => 'INT', 'unsigned' => true, 'null' => true, 'default' => null],
            'name'              => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug'              => ['type' => 'VARCHAR', 'constraint' => 280],
            'short_description' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'description'       => ['type' => 'LONGTEXT', 'null' => true],
            'specifications'    => ['type' => 'JSON', 'null' => true],
            'sku'               => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'is_featured'       => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_active'         => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'meta_title'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'meta_description'  => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'view_count'        => ['type' => 'INT', 'default' => 0],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey('category_id');
        $this->forge->addKey('is_featured');
        $this->forge->addKey('is_active');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
