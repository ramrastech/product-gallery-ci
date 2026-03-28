<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 *
 * Seeds all dynamic content into the database from the previously hardcoded view files.
 * Run: php spark db:seed ContentSeeder
 */

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run()
    {
        $this->seedSettings();
        $this->seedHomeSections();
        $this->seedAboutSections();
        $this->seedFaq();
    }

    // -------------------------------------------------------
    // Settings — new keys for dynamic page content
    // -------------------------------------------------------
    private function seedSettings(): void
    {
        $newSettings = [
            // Hero section
            'hero_eyebrow'            => 'OEM · ODM · Private Label Manufacturing',
            'hero_title_line1'        => 'Think Leather.',
            'hero_title_line2'        => 'Think Craft.',
            'hero_accent_text'        => 'Think Quality.',
            'hero_cta_primary_text'   => 'Explore Our Range',
            'hero_cta_primary_url'    => '/products',
            'hero_cta_secondary_text' => 'Request a Quote',
            'hero_cta_secondary_href' => '#contact-cta',
            'hero_video_url'          => 'https://viale.in/wp-content/uploads/2022/08/Viale-Banner.mp4',
            'hero_poster_url'         => 'https://viale.in/wp-content/uploads/2022/07/young-woman-working-her-workspace-woman-wearing-apron-making-belt-grounge-dark-stone-texture-background.jpg',
            'hero_frame_image_url'    => 'https://viale.in/wp-content/uploads/2022/07/wome-s-bags-close-up.jpg',
            'hero_trust_badges'       => json_encode([
                ['icon' => 'bi-patch-check-fill', 'color' => 'text-success', 'text' => 'ISO 9001:2015'],
                ['icon' => 'bi-award-fill',       'color' => 'text-warning', 'text' => 'SA 8000 Certified'],
                ['icon' => 'bi-award-fill',       'color' => 'text-success', 'text' => 'LWG Silver Tannery'],
                ['icon' => 'bi-truck',            'color' => 'text-success', 'text' => '40+ Countries Exported'],
            ]),
            // Story section
            'story_eyebrow'           => 'Who We Are',
            'story_heading'           => 'Behind Every Piece, A Story of Dedication',
            'story_body_1'            => 'Motivated by technical experience with some of the most reputed global brands, our journey started with the core ideology of manufacturing in 2010 — setting up a leather goods factory in Kanpur. Over time, we evolved into a professional factory where various fashion accessory categories grew alongside our client relationships.',
            'story_body_2'            => 'The management carries over 24 years of experience in making top-of-the-line leather products and accessories. Our success is driven by a strong team, creative product design and development, and a skilled workforce committed to quality at every stage.',
            'story_main_image_url'    => 'https://viale.in/wp-content/uploads/2022/08/man-creates-leather-ware.jpg',
            'story_accent_image_url'  => 'https://viale.in/wp-content/uploads/2022/10/VF-1100-1.png',
            'story_badge_num'         => '20+',
            'story_badge_label'       => 'Years of Artisan Heritage',
            'story_checks'            => json_encode([
                'Full-grain, top-grain & suede',
                'Vegan & faux leather options',
                'Custom hardware (YKK & global)',
                'Private label & buyer label',
                'Low MOQ — from 50 pcs per style',
                'Sample in 7–10 working days',
            ]),
            // Capabilities section headings
            'capabilities_eyebrow'    => 'What We Do',
            'capabilities_heading'    => 'Everything Under One Roof',
            'capabilities_subtext'    => 'From raw hide to finished product — every stage of production handled in-house for complete quality control and faster turnaround.',
            // Categories section headings
            'categories_eyebrow'      => 'Product Range',
            'categories_heading'      => 'Browse by Category',
            // Markets section headings
            'markets_eyebrow'         => 'Who We Serve',
            'markets_heading'         => 'Accessories for Every Market',
            // Why Us section headings
            'whyus_eyebrow'           => 'Why Partner With Us',
            'whyus_heading'           => 'The OEM Partner Brands Trust',
            // CTA section
            'cta_eyebrow'             => "Let's Build Your Collection",
            'cta_title'               => 'Ready to Bring Your Accessory Line to Life?',
            'cta_subtitle'            => 'Share your tech pack or product idea — we\'ll come back with a quote and sample timeline within 24 hours.',
            'cta_note'                => 'Avg. response under 4 hours · NDA signed before sample sharing · Samples from 50 pcs',
            // About page flat settings
            'about_hero_subtitle'     => 'Two decades of craft, trusted by brands across 40+ countries.',
            'about_hero_bg_url'       => 'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?w=1400&q=80',
            'about_story_main_image'  => 'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?w=700&q=80',
            'about_story_accent_image'=> 'https://viale.in/wp-content/uploads/2022/10/VF-1100-1.png',
            'about_story_body_1'      => 'Motivated by technical experience with some of the most reputed global brands, our journey started with the core ideology of manufacturing in 2010 — setting up a leather goods factory in Kanpur, India. Over time, we evolved into a professional full-service factory where various fashion accessory categories grew alongside our client relationships.',
            'about_story_body_2'      => 'The management carries over 24 years of experience in making top-of-the-line leather products and accessories. Our success is driven by a strong team, creative product design and development, and a skilled workforce committed to quality at every stage. Today we export to 40+ countries and partner with 350+ brands across Europe, the USA, the Middle East, and Asia.',
            'about_mission'           => 'To be the most trusted OEM & ODM manufacturing partner for global fashion accessory brands — delivering consistent quality, transparent processes, and on-time shipments that help our clients build lasting retail success.',
            'about_vision'            => 'To be recognised globally as Kanpur\'s finest leather goods exporter — setting industry benchmarks in ethical manufacturing, sustainable materials, and craft excellence while empowering a skilled, diverse local workforce.',
            'about_facility_heading'  => 'Built for Scale. Designed for Quality.',
            'about_facility_body'     => 'Our Kanpur manufacturing campus spans over 50,000 sq. ft. with dedicated zones for cutting, stitching, finishing, quality control, and export packing. Every stage of production is handled in-house — giving us complete control over consistency and delivery.',
            // FAQ page
            'faq_hero_bg_url'         => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=1400&q=80',
            'faq_hero_subtitle'       => 'Everything you need to know about our OEM manufacturing process.',
            // Materials section (home page)
            'materials_eyebrow'       => 'Materials & Certifications',
            'materials_heading'       => 'Sourced Well. Certified Right. Crafted Better.',
            'materials_body'          => 'We ensure the best quality by beginning with the selection of the finest raw materials and closely monitoring every stage of production through skilled quality personnel. This ensures consistent, reliable delivery to our customers\' warehouses — every time.',
        ];

        foreach ($newSettings as $key => $value) {
            $existing = $this->db->table('settings')->where('key', $key)->get()->getRowArray();
            if (! $existing) {
                $this->db->table('settings')->insert(['key' => $key, 'value' => $value]);
            }
        }
    }

    // -------------------------------------------------------
    // Home Sections — stats, capabilities, markets, why-us
    // -------------------------------------------------------
    private function seedHomeSections(): void
    {
        // Skip if already seeded
        if ($this->db->table('home_sections')->countAllResults() > 0) return;

        $rows = [];
        $order = 0;

        // Stats
        $stats = [
            ['20+', 'Years of Craft'],
            ['20+', 'Product Categories'],
            ['40+', 'Countries Exported To'],
            ['350+', 'Brand Partnerships'],
        ];
        foreach ($stats as $s) {
            $rows[] = [
                'section'    => 'stat',
                'title'      => $s[0],
                'subtitle'   => $s[1],
                'sort_order' => $order++,
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        // Capabilities
        $order = 0;
        $caps = [
            ['bi-scissors',    'Pattern Cutting & Clicking',          'Computer-aided pattern making with die-cutting and laser cutting for precision consistency across all materials — leather, PU, canvas, nylon, and suede.'],
            ['bi-pencil-square','Stitching & Hand Sewing',             'Industrial sewing machines for saddle, box, and welt stitching. Hand sewing available for luxury finishes. Reinforced stress points as standard across all bags.'],
            ['bi-palette',     'Dyeing, Burnishing & Edge Finishing', 'Pantone-matched leather dyeing, dip-dyeing, and burnished or painted edge finishing. Consistent colour lots across bulk production runs.'],
            ['bi-vector-pen',  'Embossing, Debossing & Laser Etching','Logo embossing, debossing, hot foil stamping, laser cutting patterns, digital printing, and embroidery — customised branding on every product type.'],
            ['bi-gear',        'Hardware & Fittings',                 'Premium brass, zinc alloy, and stainless hardware. YKK zippers as standard. Custom hardware in antique, brushed gold, gunmetal, and chrome finishes.'],
            ['bi-box-seam',    'Packaging & Retail Fulfilment',       'Custom gift boxes, dust bags, branded hang tags, tissue paper, and barcoded labels. Export-ready carton packing with full documentation.'],
        ];
        foreach ($caps as $c) {
            $rows[] = [
                'section'    => 'capability',
                'icon'       => $c[0],
                'title'      => $c[1],
                'body'       => $c[2],
                'sort_order' => $order++,
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        // Markets
        $order = 0;
        $markets = [
            ['bi-bag-heart-fill',  "Women's Fashion"],
            ['bi-briefcase-fill',  "Men's Lifestyle"],
            ['bi-stars',           'Luxury Brands'],
            ['bi-shop',            'Retail Chains'],
            ['bi-globe2',          'Export / E-Commerce'],
            ['bi-award-fill',      'Corporate Gifting'],
            ['bi-compass',         'Travel & Outdoor'],
            ['bi-heart-fill',      'Eco / Vegan Brands'],
        ];
        foreach ($markets as $m) {
            $rows[] = [
                'section'    => 'market',
                'icon'       => $m[0],
                'title'      => $m[1],
                'sort_order' => $order++,
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        // Why Us
        $order = 0;
        $whyus = [
            ['01', 'Design to Delivery',    'Send a sketch, tech pack, or reference sample. We handle pattern development, prototyping, and bulk production — all in-house.'],
            ['02', 'Low MOQ, Scale Fast',   'Start from 50 pieces per style. Once your design is locked, we scale to thousands with consistent quality and on-time delivery.'],
            ['03', 'Private & Buyer Label', 'Brand embossing, woven labels, printed linings, hang tags, and branded packaging — we handle your identity as carefully as your product.'],
            ['04', 'Socially Compliant',    'SA8000, SEDEX, and BSCI certified. Safe working conditions, fair wages, and an all-women manufacturing unit — compliant with global retail standards.'],
        ];
        foreach ($whyus as $w) {
            $rows[] = [
                'section'    => 'whyus',
                'icon'       => $w[0],
                'title'      => $w[1],
                'body'       => $w[2],
                'sort_order' => $order++,
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        // Materials quality items
        $order = 0;
        $materials = [
            ['bi-gem',        'Full-Grain & Top-Grain Cowhide',    'Our most-used leathers — sourced from certified tanneries. Available in natural, aniline, semi-aniline, and corrected finishes.'],
            ['bi-droplet-half','Buffalo, Sheepskin & Goatskin',    'Buffalo for structured bags and belts. Lambskin and sheepskin for garments and soft accessories. Goat nappa for wallets and clutches.'],
            ['bi-layers',     'Suede, Nubuck & Split Leather',     'Buffed suede and nubuck for linings, facings, and fashion-forward styles. Split leather for cost-effective accessories with genuine character.'],
            ['bi-globe2',     'Vegan & Sustainable Alternatives',  'PU microfibre, Piñatex, recycled PET, waxed canvas, and ballistic nylon — for brands building an ethical accessories line.'],
        ];
        foreach ($materials as $m) {
            $rows[] = [
                'section'    => 'material',
                'icon'       => $m[0],
                'title'      => $m[1],
                'body'       => $m[2],
                'sort_order' => $order++,
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        // Certifications (home page)
        $order = 0;
        $certs = [
            ['bi-patch-check-fill', 'ISO 9001:2015', 'Quality Management'],
            ['bi-people-fill',      'SA 8000',        'Social Accountability'],
            ['bi-award-fill',       'LWG Silver',     'Leather Working Group'],
            ['bi-shield-check',     'SEDEX / BSCI',   'Ethical Trade Audit'],
        ];
        foreach ($certs as $c) {
            $rows[] = [
                'section'    => 'cert',
                'icon'       => $c[0],
                'title'      => $c[1],
                'subtitle'   => $c[2],
                'sort_order' => $order++,
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        // Normalize all rows to the same column set
        $allCols = array_fill_keys(array_unique(array_merge(...array_map('array_keys', $rows))), null);
        $rows = array_map(fn($r) => array_merge($allCols, $r), $rows);
        $this->db->table('home_sections')->insertBatch($rows);
    }

    // -------------------------------------------------------
    // About Sections — timeline, facility, team, certifications
    // -------------------------------------------------------
    private function seedAboutSections(): void
    {
        if ($this->db->table('about_sections')->countAllResults() > 0) return;

        $rows = [];
        $order = 0;

        // Timeline
        $timeline = [
            ['2003', 'Industry Beginnings',              'Management gains deep technical expertise working with reputed global leather goods brands — absorbing world-class standards in design, materials, and quality.'],
            ['2010', 'Factory Established',              'Launched our first manufacturing unit in Kanpur — India\'s leather capital — with a focused team of artisans specialising in women\'s handbags and small leather goods.'],
            ['2014', 'ISO 9001 Certified',               'Achieved ISO 9001:2015 Quality Management certification. Expanded production to include men\'s wallets, belts, and travel accessories.'],
            ['2017', 'SA 8000 & SEDEX Audit',            'Passed SA 8000 Social Accountability and SEDEX ethical trade audits — opening doors to major European and US retail chains with strict compliance requirements.'],
            ['2019', 'LWG Silver Tannery & Vegan Line', 'Earned LWG Silver certification for leather sourcing. Launched a dedicated vegan and sustainable materials collection — PU, Piñatex, and recycled PET.'],
            ['2024', '350+ Brand Partners & 40 Countries','Now partnering with over 350 brands globally across 40+ countries, with an expanded 20-category product range and a 500+ strong skilled workforce.'],
        ];
        foreach ($timeline as $t) {
            $rows[] = [
                'section'    => 'timeline',
                'year'       => $t[0],
                'title'      => $t[1],
                'body'       => $t[2],
                'sort_order' => $order++,
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        // Facility stats
        $order = 0;
        $facStats = [
            ['50,000+', 'sq. ft. facility'],
            ['500+',    'skilled workers'],
            ['12',      'production lines'],
            ['7–10',    'days for first sample'],
        ];
        foreach ($facStats as $f) {
            $rows[] = [
                'section'    => 'facility_stat',
                'title'      => $f[0],
                'subtitle'   => $f[1],
                'sort_order' => $order++,
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        // Facility photos
        $order = 0;
        $facPhotos = [
            ['https://images.unsplash.com/photo-1565084888279-aca607ecce0c?w=500&q=80', 'Factory sewing floor'],
            ['https://images.unsplash.com/photo-1601924994987-69e26d50dc26?w=500&q=80', 'Leather cutting and clicking'],
            ['https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=500&q=80', 'Quality inspection'],
            ['https://images.unsplash.com/photo-1551836022-8b2858c9c69b?w=500&q=80', 'Finished leather goods packaging'],
        ];
        foreach ($facPhotos as $p) {
            $rows[] = [
                'section'    => 'facility_photo',
                'image_url'  => $p[0],
                'subtitle'   => $p[1],
                'sort_order' => $order++,
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        // Team
        $order = 0;
        $team = [
            ['Rahul Sharma',  'Managing Director',                  '24 years in leather goods manufacturing. Built partnerships with brands across Europe and the US.',                                       'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=300&q=80'],
            ['Priya Mehta',   'Head of Design & Development',       'Fashion design background with expertise in trend-led product development and technical pattern making.',                                  'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=300&q=80'],
            ['Anil Verma',    'Head of Export & Business Development','Manages global client relationships and end-to-end export logistics across 40+ countries.',                                              'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=300&q=80'],
            ['Sunita Patel',  'Quality Assurance Manager',          'Leads the QA team ensuring every shipment meets ISO, SEDEX, and buyer compliance standards.',                                             'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=300&q=80'],
        ];
        foreach ($team as $m) {
            $rows[] = [
                'section'    => 'team',
                'title'      => $m[0],
                'subtitle'   => $m[1],
                'body'       => $m[2],
                'image_url'  => $m[3],
                'sort_order' => $order++,
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        // Certifications (about page — detailed version)
        $order = 0;
        $certs = [
            ['bi-patch-check-fill', 'ISO 9001:2015',     'Quality Management System — governs all production, inspection, and delivery processes for consistent output.'],
            ['bi-people-fill',      'SA 8000',           'Social Accountability certification verifying safe, fair, and ethical working conditions throughout our factory.'],
            ['bi-award-fill',       'LWG Silver Tannery','Leather Working Group Silver rating — confirming our leather sourcing meets international environmental standards.'],
            ['bi-shield-check',     'SEDEX / BSCI',      'Ethical trade audit platform membership — enabling full supply chain transparency for global retail buyers.'],
        ];
        foreach ($certs as $c) {
            $rows[] = [
                'section'    => 'certification',
                'icon'       => $c[0],
                'title'      => $c[1],
                'body'       => $c[2],
                'sort_order' => $order++,
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        // Normalize all rows to the same column set
        $allCols = array_fill_keys(array_unique(array_merge(...array_map('array_keys', $rows))), null);
        $rows = array_map(fn($r) => array_merge($allCols, $r), $rows);
        $this->db->table('about_sections')->insertBatch($rows);
    }

    // -------------------------------------------------------
    // FAQ — categories and items
    // -------------------------------------------------------
    private function seedFaq(): void
    {
        if ($this->db->table('faq_categories')->countAllResults() > 0) return;

        $faqData = [
            'Getting Started' => [
                ['q' => 'What is the minimum order quantity (MOQ)?',
                 'a' => 'Our standard MOQ is <strong>50 pieces per style per colour</strong>. For repeat orders or established brand partners, we can discuss lower quantities. Some specialised products (e.g. custom hardware or exotic materials) may require a higher MOQ — we will advise at the quoting stage.'],
                ['q' => 'Can I order a single sample before committing to bulk?',
                 'a' => 'Yes. We offer pre-production samples (PPS) so you can approve the design, materials, and finish before bulk production begins. Sample lead time is typically <strong>7–10 working days</strong> from design approval. A sample charge applies and is refunded or credited against your first bulk order.'],
                ['q' => 'Do you offer OEM, ODM, or both?',
                 'a' => '<strong>Both.</strong> OEM: you provide the design (tech pack, sketch, or reference sample) and we manufacture to your specification. ODM: you select from our existing range and we produce it under your brand. We can also assist with design development if you have only a rough brief.'],
                ['q' => 'What information do I need to share to get a quote?',
                 'a' => 'To generate an accurate quote, please share: (1) product sketch or reference image, (2) desired material and colour, (3) approximate dimensions, (4) hardware preferences, (5) target quantity, and (6) your delivery country. A tech pack accelerates the process but is not mandatory at the enquiry stage.'],
            ],
            'Materials & Quality' => [
                ['q' => 'What leather types do you work with?',
                 'a' => 'We work with full-grain, top-grain, corrected-grain, split leather, suede, nubuck, nappa, buffalo, sheepskin, and goatskin. For vegan ranges, we offer PU microfibre, Piñatex (pineapple leaf fibre), waxed canvas, ballistic nylon, and recycled PET fabrics.'],
                ['q' => 'Can you match a specific leather colour (Pantone)?',
                 'a' => 'Yes. We work with certified tanneries that can match any Pantone colour for leather dye lots. Please provide the Pantone TPX or TCX code, or send a physical swatch. Colour matching adds approximately 5–7 working days to sample lead time.'],
                ['q' => 'What hardware brands do you use?',
                 'a' => 'We use <strong>YKK zippers</strong> as standard. Metal hardware (buckles, D-rings, clasps, studs, feet) is sourced from certified foundries in India and China in brass, zinc alloy, and stainless steel. Custom hardware moulds are available from 200 pcs and take 3–4 weeks.'],
                ['q' => 'What quality certifications do you hold?',
                 'a' => 'We are certified to <strong>ISO 9001:2015</strong> (Quality Management), <strong>SA 8000</strong> (Social Accountability), <strong>LWG Silver</strong> (Leather Working Group — environmental standards), and are registered on <strong>SEDEX</strong> and <strong>BSCI</strong> for ethical trade audits. Full certificate copies are available on request.'],
            ],
            'Production & Lead Times' => [
                ['q' => 'What is the typical bulk production lead time?',
                 'a' => 'After sample approval and receipt of a purchase order and deposit, standard bulk lead time is <strong>45–60 working days</strong> depending on product complexity and quantity. Rush orders of up to 30% faster are available for select products — please enquire at the time of order placement.'],
                ['q' => 'Can you handle very large orders?',
                 'a' => 'Yes. Our factory runs 12 production lines with 500+ skilled workers and can handle orders of 5,000 to 50,000+ units per month depending on the product mix. We will confirm capacity at the quoting stage.'],
                ['q' => 'Do you do private label and custom branding?',
                 'a' => 'Yes — all of it. We handle logo embossing, debossing, hot-foil stamping, laser etching, printed linings, woven labels, hang tags, care labels, and branded packaging (boxes, dust bags, tissue paper, ribbons, barcoded labels). Everything under one roof.'],
                ['q' => 'Can I visit your factory?',
                 'a' => 'Absolutely. We welcome factory visits from prospective and existing brand partners. Our facility is located in <strong>Kanpur, Uttar Pradesh, India</strong>. Please contact us to schedule a visit — we will arrange a factory tour, materials viewing, and a design consultation.'],
            ],
            'Shipping & Export' => [
                ['q' => 'Which countries do you export to?',
                 'a' => 'We currently export to <strong>40+ countries</strong> across Europe (UK, Germany, France, Italy, Spain, Nordics), the USA, Canada, Australia, the Middle East (UAE, Saudi Arabia, Qatar), and South-East Asia. We are experienced with country-specific compliance requirements and documentation.'],
                ['q' => 'What are the payment terms?',
                 'a' => 'Standard terms are <strong>30% advance</strong> on order confirmation and <strong>70% balance</strong> before shipment. For established partners, we offer Net 30 terms after a track record of 3+ orders. We accept bank transfers (TT), PayPal (for samples), and Letters of Credit for large orders.'],
                ['q' => 'Do you provide export documentation?',
                 'a' => 'Yes — we provide all standard export documents: commercial invoice, packing list, certificate of origin, bill of lading / airway bill, and GSP certificate where applicable. We can work with your freight forwarder or suggest trusted logistics partners for door-to-door delivery.'],
                ['q' => 'How are goods packaged for export?',
                 'a' => 'Each product is individually tagged and packed in branded dust bags or tissue paper, then into individual retail boxes (if specified), then into export cartons with barcodes, carton marks, and a packing list. All cartons are shrink-wrapped on pallets for sea freight.'],
            ],
        ];

        $catOrder = 0;
        foreach ($faqData as $catName => $items) {
            $this->db->table('faq_categories')->insert([
                'name'       => $catName,
                'sort_order' => $catOrder++,
                'is_active'  => 1,
            ]);
            $catId    = $this->db->insertID();
            $itemOrder = 0;
            foreach ($items as $item) {
                $this->db->table('faq_items')->insert([
                    'category_id' => $catId,
                    'question'    => $item['q'],
                    'answer'      => $item['a'],
                    'sort_order'  => $itemOrder++,
                    'is_active'   => 1,
                    'created_at'  => date('Y-m-d H:i:s'),
                    'updated_at'  => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
