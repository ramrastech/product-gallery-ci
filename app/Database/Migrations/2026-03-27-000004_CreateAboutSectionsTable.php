<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAboutSectionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'section'    => ['type' => 'VARCHAR', 'constraint' => 50],   // timeline|facility_stat|facility_photo|team|certification
            'year'       => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'icon'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'title'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'subtitle'   => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'body'       => ['type' => 'TEXT', 'null' => true],
            'image_url'  => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'image_id'   => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'sort_order' => ['type' => 'SMALLINT', 'default' => 0],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey(['section', 'sort_order']);
        $this->forge->createTable('about_sections');
    }

    public function down()
    {
        $this->forge->dropTable('about_sections');
    }
}
