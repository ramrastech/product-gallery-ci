<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMediaLibraryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'filename'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'original_name' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'folder'        => ['type' => 'VARCHAR', 'constraint' => 100, 'default' => 'general'],
            'mime_type'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'file_size'     => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'width'         => ['type' => 'SMALLINT', 'unsigned' => true, 'null' => true],
            'height'        => ['type' => 'SMALLINT', 'unsigned' => true, 'null' => true],
            'alt_text'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'title'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'uploaded_by'   => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('media_library');
    }

    public function down()
    {
        $this->forge->dropTable('media_library');
    }
}
