<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFaqItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'category_id' => ['type' => 'INT', 'unsigned' => true],
            'question'    => ['type' => 'VARCHAR', 'constraint' => 500],
            'answer'      => ['type' => 'TEXT'],
            'sort_order'  => ['type' => 'SMALLINT', 'default' => 0],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('category_id');
        $this->forge->createTable('faq_items');
    }

    public function down()
    {
        $this->forge->dropTable('faq_items');
    }
}
