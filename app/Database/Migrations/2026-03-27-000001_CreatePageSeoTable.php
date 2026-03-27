<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePageSeoTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'page_key'         => ['type' => 'VARCHAR', 'constraint' => 50],
            'meta_title'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'meta_description' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'meta_keywords'    => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'og_title'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'og_description'   => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'og_image'         => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'og_type'          => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true, 'default' => 'website'],
            'robots'           => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true, 'default' => 'index, follow'],
            'canonical'        => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('page_key');
        $this->forge->createTable('page_seo');

        // Seed default SEO for all pages
        $this->db->table('page_seo')->insertBatch([
            [
                'page_key'         => 'home',
                'meta_title'       => 'OEM Leather Goods & Fashion Accessories Manufacturer — Kanpur, India',
                'meta_description' => 'Premium OEM leather goods manufacturer. Handbags, wallets, belts, travel bags. 20+ years, 40+ countries, 350+ brand partners. ISO 9001 certified. Request a quote.',
                'meta_keywords'    => 'OEM leather bags manufacturer India, private label handbags, leather goods factory Kanpur, ODM accessories, leather wallets OEM, fashion accessories manufacturer',
                'og_type'          => 'website',
                'robots'           => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'page_key'         => 'about',
                'meta_title'       => 'About Us — 20+ Years of Leather Goods Manufacturing',
                'meta_description' => 'Learn about our 20+ years of leather goods and fashion accessories manufacturing in Kanpur, India. OEM, ODM, and private label for global brands.',
                'meta_keywords'    => 'leather goods manufacturer about, OEM factory India, Kanpur leather manufacturer, fashion accessories history',
                'og_type'          => 'website',
                'robots'           => 'index, follow',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'page_key'         => 'products',
                'meta_title'       => 'Products — Leather Goods & Fashion Accessories Catalogue',
                'meta_description' => 'Browse our complete range of OEM leather goods: handbags, wallets, belts, travel bags, backpacks, and more. ISO certified. Custom manufacturing from 50 pcs.',
                'meta_keywords'    => 'leather handbags catalogue, leather wallets OEM, leather belts manufacturer, travel bags wholesale, fashion accessories India',
                'og_type'          => 'website',
                'robots'           => 'index, follow',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'page_key'         => 'contact',
                'meta_title'       => 'Contact Us — OEM Leather Goods Enquiry',
                'meta_description' => 'Get in touch for OEM leather goods manufacturing enquiries. Share your tech pack or design — we respond within 4 hours with a sample timeline and quote.',
                'meta_keywords'    => 'contact leather manufacturer India, OEM enquiry, leather goods factory contact',
                'og_type'          => 'website',
                'robots'           => 'index, follow',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'page_key'         => 'faq',
                'meta_title'       => 'FAQ — OEM Leather Goods Manufacturing Questions',
                'meta_description' => 'Frequently asked questions about our OEM leather goods manufacturing, minimum order quantities, sampling process, lead times, and export capabilities.',
                'meta_keywords'    => 'leather manufacturer FAQ, OEM MOQ, leather goods sample, leather factory lead time',
                'og_type'          => 'website',
                'robots'           => 'index, follow',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'page_key'         => 'privacy',
                'meta_title'       => 'Privacy Policy',
                'meta_description' => 'How we collect, use, and protect your personal information when you use our website.',
                'meta_keywords'    => '',
                'og_type'          => 'website',
                'robots'           => 'noindex, follow',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'page_key'         => 'terms',
                'meta_title'       => 'Terms & Conditions',
                'meta_description' => 'Terms and conditions governing the use of our website and services.',
                'meta_keywords'    => '',
                'og_type'          => 'website',
                'robots'           => 'noindex, follow',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('page_seo');
    }
}
