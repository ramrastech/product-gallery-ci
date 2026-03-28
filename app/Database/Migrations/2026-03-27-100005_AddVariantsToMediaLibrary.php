<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVariantsToMediaLibrary extends Migration
{
    public function up()
    {
        $this->forge->addColumn('media_library', [
            'variants' => [
                'type'       => 'JSON',
                'null'       => true,
                'default'    => null,
                'after'      => 'height',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('media_library', 'variants');
    }
}
