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

class CreateProductImagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'product_id' => ['type' => 'INT', 'unsigned' => true],
            'image_path' => ['type' => 'VARCHAR', 'constraint' => 255],
            'alt_text'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'sort_order' => ['type' => 'INT', 'default' => 0],
            'is_primary' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('product_id');
        $this->forge->createTable('product_images');
    }

    public function down()
    {
        $this->forge->dropTable('product_images');
    }
}
