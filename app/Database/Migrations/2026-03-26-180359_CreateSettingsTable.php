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

class CreateSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'key'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'value' => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('key');
        $this->forge->createTable('settings');

        // Seed default settings
        $this->db->table('settings')->insertBatch([
            ['key' => 'site_name',       'value' => 'Product Gallery'],
            ['key' => 'site_tagline',    'value' => 'Discover Our Products'],
            ['key' => 'enquiry_email',   'value' => ''],
            ['key' => 'whatsapp_number', 'value' => ''],
            ['key' => 'ga_tracking_id',  'value' => ''],
            ['key' => 'meta_pixel_id',   'value' => ''],
            ['key' => 'active_theme',    'value' => 'default'],
            ['key' => 'facebook_url',    'value' => ''],
            ['key' => 'instagram_url',   'value' => ''],
            ['key' => 'linkedin_url',    'value' => ''],
            ['key' => 'twitter_url',     'value' => ''],
            ['key' => 'hero_title',      'value' => 'Explore Our Collection'],
            ['key' => 'hero_subtitle',   'value' => 'Quality products for every need'],
            ['key' => 'contact_phone',   'value' => ''],
            ['key' => 'contact_address', 'value' => ''],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
}
