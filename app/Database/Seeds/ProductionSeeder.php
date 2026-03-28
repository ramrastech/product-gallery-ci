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

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * ProductionSeeder
 * Seeds categories, products, and product images using hosted stock images.
 * Run: php spark db:seed ProductionSeeder
 */
class ProductionSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $db  = $this->db;

        // -------------------------------------------------------
        // CATEGORIES
        // -------------------------------------------------------
        $categories = [
            [
                'name'        => "Ladies' Handbags",
                'slug'        => 'ladies-handbags',
                'description' => 'Structured and fashion handbags for women in full-grain, top-grain, and vegan leather. OEM/ODM in any colour, hardware, and lining.',
                'image_path'  => 'ladies-handbags.svg',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => "Ladies' Wallets & Clutches",
                'slug'        => 'ladies-wallets-clutches',
                'description' => 'Slim wallets, zip-around card holders, and evening clutches for women. Custom card slots, coin pockets, and wrist strap options.',
                'image_path'  => 'ladies-wallets-clutches.svg',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Sling & Crossbody Bags',
                'slug'        => 'sling-crossbody-bags',
                'description' => 'Compact crossbody and sling bags for everyday carry. Adjustable straps, multiple compartments, and custom hardware finishes.',
                'image_path'  => 'sling-crossbody-bags.svg',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Shopper & Tote Bags',
                'slug'        => 'shopper-tote-bags',
                'description' => 'Large-capacity shopper and tote bags for retail and fashion markets. Canvas, leather, and vegan options with branded lining.',
                'image_path'  => 'shopper-tote-bags.svg',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => "Men's Bags & Briefcases",
                'slug'        => 'mens-bags-briefcases',
                'description' => 'Leather briefcases, laptop bags, messenger bags, and document portfolios for professional men. Structured, slim, and custom-hardware options.',
                'image_path'  => 'mens-bags-briefcases.svg',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => "Men's Wallets",
                'slug'        => 'mens-wallets',
                'description' => 'Bifold, trifold, slim card holders, and money clips in genuine leather. Classic and RFID-blocking options with custom branding.',
                'image_path'  => 'mens-wallets.svg',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => "Men's Belts",
                'slug'        => 'mens-belts',
                'description' => 'Formal and casual leather belts for men. Full-grain and top-grain cowhide with pin, roller, and auto-lock buckles in custom sizes.',
                'image_path'  => 'mens-belts.svg',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => "Ladies' Belts",
                'slug'        => 'ladies-belts',
                'description' => 'Fashion and formal belts for women in leather and PU. Laser-cut patterns, chain trims, and decorative buckles in multiple widths.',
                'image_path'  => 'ladies-belts.svg',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Travel & Duffel Bags',
                'slug'        => 'travel-duffel-bags',
                'description' => 'Weekend duffels, overnight bags, and cabin-size travel bags. Reinforced handles, combination locks, and trolley sleeve options.',
                'image_path'  => 'travel-duffel-bags.svg',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Small Leather Goods',
                'slug'        => 'small-leather-goods',
                'description' => 'Card cases, key holders, coin pouches, passport covers, and luggage tags. Ideal for gifting collections and accessories bundles.',
                'image_path'  => 'small-leather-goods.svg',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Backpacks',
                'slug'        => 'backpacks',
                'description' => 'Leather, canvas, and hybrid backpacks for daily carry, travel, and laptop use. Multiple compartments with custom zippers and hardware.',
                'image_path'  => 'backpacks.svg',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Vegan & PU Collection',
                'slug'        => 'vegan-pu-collection',
                'description' => 'Ethically made accessories in PU microfibre, Piñatex, waxed canvas, and recycled materials — for eco-conscious and vegan brands.',
                'image_path'  => 'vegan-pu-collection.svg',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        // Clear existing data
        $db->table('product_images')->emptyTable();
        $db->table('products')->emptyTable();
        $db->table('categories')->emptyTable();

        // Insert categories and store their IDs
        $catIds = [];
        foreach ($categories as $cat) {
            $db->table('categories')->insert($cat);
            $catIds[$cat['slug']] = $db->insertID();
        }

        // -------------------------------------------------------
        // PRODUCTS
        // -------------------------------------------------------
        $products = [

            // ---- LADIES' HANDBAGS ----
            [
                'cat'     => 'ladies-handbags',
                'name'    => 'Hand Bag VF-1100',
                'sku'     => 'VF-1100',
                'short'   => 'Structured ladies handbag in premium full-grain leather. Top zip closure, suede lining, and antique gold hardware.',
                'desc'    => '<p>The VF-1100 is our best-selling structured ladies handbag — crafted in full-grain cowhide with a gusset base for shape retention. Features include a top zip closure, two interior slip pockets, a zip coin compartment, and a detachable logo fob. Available in antique gold or silver hardware. Custom colours and linings on order.</p><p><strong>MOQ:</strong> 50 pcs per colour. Sample in 7–10 working days.</p>',
                'specs'   => ['Material' => 'Full-Grain Cowhide', 'Lining' => 'Suede', 'Hardware' => 'Antique Gold / Silver', 'Dimensions' => '32 × 24 × 12 cm', 'Handle Drop' => '22 cm', 'Closure' => 'Top Zip', 'Colours' => 'Any Pantone on request'],
                'featured'=> 1,
                'images'  => [
                    ['url' => 'https://viale.in/wp-content/uploads/2022/10/VF-1100-1.png', 'alt' => 'Hand Bag VF-1100 front view', 'primary' => 1],
                    ['url' => 'https://viale.in/wp-content/uploads/2022/07/wome-s-bags-close-up.jpg', 'alt' => 'Ladies handbag collection', 'primary' => 0],
                ],
            ],
            [
                'cat'     => 'ladies-handbags',
                'name'    => 'Hand Bag VF-1096',
                'sku'     => 'VF-1096',
                'short'   => 'Fashion handbag with convertible carry options — both top handles and a detachable shoulder strap. Fully lined interior.',
                'desc'    => '<p>The VF-1096 is a fashion-forward ladies handbag offering convertible carry — use the padded top handles for a chic arm carry, or attach the detachable adjustable strap for hands-free use. Made in top-grain leather with a printed fabric lining and polished gunmetal hardware.</p><p><strong>MOQ:</strong> 50 pcs. Strap length customisable.</p>',
                'specs'   => ['Material' => 'Top-Grain Cowhide', 'Lining' => 'Printed Fabric', 'Hardware' => 'Gunmetal', 'Dimensions' => '30 × 20 × 10 cm', 'Strap' => 'Detachable, Adjustable', 'Closure' => 'Magnetic Snap + Zip'],
                'featured'=> 1,
                'images'  => [
                    ['url' => 'https://viale.in/wp-content/uploads/2022/10/VF-1096-1.png', 'alt' => 'Hand Bag VF-1096 front', 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'ladies-handbags',
                'name'    => 'Structured Tote VF-1085',
                'sku'     => 'VF-1085',
                'short'   => 'Large structured tote in vegetable-tanned leather with open-top design, interior organisation, and base studs.',
                'desc'    => '<p>The VF-1085 Structured Tote combines the practicality of a large carry-all with the elegance of vegetable-tanned leather. Base studs protect the bottom; an interior zipper pocket and card slots keep essentials organised. Available with a custom logo plaque or embossing.</p>',
                'specs'   => ['Material' => 'Vegetable-Tanned Cowhide', 'Hardware' => 'Brushed Gold', 'Dimensions' => '40 × 30 × 15 cm', 'Interior' => '1 zip pocket, 2 slip pockets', 'Base' => '4 gold studs', 'Closure' => 'Open-top with magnetic popper'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://viale.in/wp-content/uploads/2022/10/VF-1039-1.png', 'alt' => 'Structured tote bag', 'primary' => 1],
                    ['url' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=600&q=80', 'alt' => 'Leather tote detail', 'primary' => 0],
                ],
            ],

            // ---- LADIES' WALLETS & CLUTCHES ----
            [
                'cat'     => 'ladies-wallets-clutches',
                'name'    => 'Ladies Clutch VFC-132',
                'sku'     => 'VFC-132',
                'short'   => 'Slim zip-around ladies clutch with multiple card slots, bill compartment, coin pocket, and wrist strap.',
                'desc'    => '<p>VFC-132 is a bestselling zip-around ladies clutch in smooth leather. Features 8 card slots, 2 bill compartments, a zipped coin pocket, and a removable wrist strap. The exterior has a subtle logo deboss. Available in 12 standard leather colours or custom Pantone match.</p>',
                'specs'   => ['Material' => 'Smooth Cowhide', 'Card Slots' => '8', 'Bill Compartments' => '2', 'Coin Pocket' => 'Yes (zip)', 'Wrist Strap' => 'Removable', 'Dimensions' => '20 × 10 cm', 'Closure' => 'Full zip-around'],
                'featured'=> 1,
                'images'  => [
                    ['url' => 'https://viale.in/wp-content/uploads/2022/11/LADIES-WALLET-VFC-132.png', 'alt' => 'Ladies Clutch VFC-132', 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'ladies-wallets-clutches',
                'name'    => 'Ladies Wallet VFC-100',
                'sku'     => 'VFC-100',
                'short'   => 'Classic bi-fold ladies wallet in nappa leather with 6 card slots, bill pocket, and transparent ID window.',
                'desc'    => '<p>The VFC-100 is a slim bi-fold in buttery nappa leather — compact enough for a clutch, yet spacious with 6 card slots, a full-length bill pocket, and a transparent ID window. Branded interior lining available. RFID-blocking version on request.</p>',
                'specs'   => ['Material' => 'Nappa Cowhide', 'Card Slots' => '6', 'ID Window' => 'Yes (clear)', 'Bill Pocket' => '1 full-length', 'RFID Blocking' => 'Optional', 'Dimensions' => '19 × 9 cm'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://viale.in/wp-content/uploads/2022/11/LADIES-WALLET-VFC-100.png', 'alt' => 'Ladies Wallet VFC-100', 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'ladies-wallets-clutches',
                'name'    => 'Card Holder Clutch VFC-115',
                'sku'     => 'VFC-115',
                'short'   => 'Ultra-slim card holder with 4 card slots and a centre slip pocket — ideal for a minimalist evening carry.',
                'desc'    => '<p>VFC-115 is an ultra-slim cardholder for the minimalist carry. Four card slots on the exterior, a centre slip pocket for notes or receipts, and a logo pressed on the front. Available in smooth, saffiano, and croc-print leathers. Custom gift box packaging included on retail orders.</p>',
                'specs'   => ['Material' => 'Saffiano / Smooth / Croc-Print', 'Card Slots' => '4 exterior', 'Centre Pocket' => '1 slip', 'Dimensions' => '10.5 × 7.5 cm', 'Packaging' => 'Custom gift box on request'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://images.pexels.com/photos/7029991/pexels-photo-7029991.jpeg?auto=compress&cs=tinysrgb&w=600', 'alt' => 'Slim leather card holder', 'primary' => 1],
                    ['url' => 'https://viale.in/wp-content/uploads/2022/11/LADIES-WALLET-VFC-100.png', 'alt' => 'Card holder open view', 'primary' => 0],
                ],
            ],

            // ---- SLING & CROSSBODY BAGS ----
            [
                'cat'     => 'sling-crossbody-bags',
                'name'    => 'Sling Bag VF-1069',
                'sku'     => 'VF-1069',
                'short'   => 'Compact leather sling bag with front zip pocket, adjustable strap, and back safety pocket for everyday carry.',
                'desc'    => '<p>VF-1069 is a practical and stylish leather sling bag. Features a main zip compartment, front zip pocket, and a concealed back pocket for passports or phones. The padded adjustable strap suits all body types. Available in smooth, pebble, and saffiano textures.</p>',
                'specs'   => ['Material' => 'Pebble-Grain Cowhide', 'Hardware' => 'Antique Silver', 'Dimensions' => '22 × 16 × 6 cm', 'Strap' => 'Adjustable cross-body', 'Compartments' => 'Main zip + front zip + back pocket', 'Closure' => 'YKK Zip'],
                'featured'=> 1,
                'images'  => [
                    ['url' => 'https://viale.in/wp-content/uploads/2022/11/VF-1069.png', 'alt' => 'Sling Bag VF-1069', 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'sling-crossbody-bags',
                'name'    => 'Mini Saddle Crossbody SB-115',
                'sku'     => 'SB-115',
                'short'   => 'Trendy mini saddle crossbody in smooth leather with flap closure, adjustable chain-leather strap, and interior slip pockets.',
                'desc'    => '<p>SB-115 is a fashion-forward mini saddle bag inspired by current runway trends. The curved silhouette features a flip-lock clasp, a chain-and-leather combo strap, and two interior card-sized pockets. Small but perfectly formed — ideal for evenings and everyday light carry.</p>',
                'specs'   => ['Material' => 'Smooth Cowhide', 'Closure' => 'Flip-Lock Clasp', 'Strap' => 'Chain + Leather, Adjustable', 'Dimensions' => '18 × 14 × 5 cm', 'Interior' => '2 slip pockets'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://images.unsplash.com/photo-1591348278863-a8fb3887e2aa?w=600&q=80', 'alt' => 'Mini saddle crossbody bag', 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'sling-crossbody-bags',
                'name'    => 'Slim Reporter Bag SB-120',
                'sku'     => 'SB-120',
                'short'   => 'Slim messenger-style crossbody with front-flap magnetic closure, organiser interior, and padded tablet sleeve.',
                'desc'    => '<p>SB-120 bridges the gap between a crossbody and a small messenger bag. The magnetic flap closure opens to a well-organised interior with a padded 8" tablet sleeve, two pen loops, card slots, and a key clip. Wide adjustable strap distributes weight comfortably for all-day wear.</p>',
                'specs'   => ['Material' => 'Full-Grain Cowhide', 'Closure' => 'Magnetic Flap', 'Tablet Sleeve' => 'Up to 8 inch', 'Strap' => 'Wide padded, adjustable', 'Dimensions' => '28 × 20 × 6 cm'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=600&q=80', 'alt' => 'Slim crossbody reporter bag', 'primary' => 1],
                ],
            ],

            // ---- SHOPPER & TOTE BAGS ----
            [
                'cat'     => 'shopper-tote-bags',
                'name'    => 'Shopper Bag VF-1044',
                'sku'     => 'VF-1044',
                'short'   => 'Large open-top shopper in smooth leather with dual handles, interior organiser, and structured base.',
                'desc'    => '<p>VF-1044 is a spacious shopper designed for the retail market. The open-top format with magnetic snap popper makes access effortless. Interior features include a zip pocket, 2 slip pockets, and a key clip. Flat base with corner reinforcements. Available in 15 standard leather colours.</p>',
                'specs'   => ['Material' => 'Top-Grain Cowhide', 'Handle Drop' => '28 cm', 'Dimensions' => '38 × 30 × 14 cm', 'Interior' => 'Zip pocket + 2 slip pockets + key clip', 'Closure' => 'Open-top + magnetic snap'],
                'featured'=> 1,
                'images'  => [
                    ['url' => 'https://viale.in/wp-content/uploads/2022/10/VF-1044-1.png', 'alt' => 'Shopper Bag VF-1044', 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'shopper-tote-bags',
                'name'    => 'Canvas & Leather Tote ST-220',
                'sku'     => 'ST-220',
                'short'   => 'Waxed canvas and leather tote with zip top closure, leather base, side pockets, and custom printed interior.',
                'desc'    => '<p>ST-220 combines durability with style — a waxed canvas body with full-leather base and handles, plus antique brass hardware. The zip-top closure and two exterior side pockets make it perfect for everyday and travel. Custom canvas colour, leather colour, and interior print available for white-label orders.</p>',
                'specs'   => ['Material' => 'Waxed Canvas + Cowhide Base', 'Hardware' => 'Antique Brass', 'Dimensions' => '42 × 33 × 15 cm', 'Pockets' => 'Zip top + 2 exterior side', 'Closure' => 'Full zip-top'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=600&q=80', 'alt' => 'Canvas leather tote bag', 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'shopper-tote-bags',
                'name'    => 'Zip Shopper ST-225',
                'sku'     => 'ST-225',
                'short'   => 'Secure zip-top shopper with inner laptop sleeve, organiser pocket, and removable pouch — daily work and gym bag.',
                'desc'    => '<p>ST-225 is a secure, zip-top shopper built for busy professionals. Inside: a 15" laptop sleeve, a separate organiser section with pen loops and card pockets, and a removable zip pouch. Water-resistant nylon lining. A great choice for corporate gifting and retail bundles.</p>',
                'specs'   => ['Material' => 'Pebble-Grain Cowhide', 'Laptop Sleeve' => 'Up to 15 inch', 'Removable Pouch' => 'Yes', 'Dimensions' => '40 × 32 × 14 cm', 'Lining' => 'Water-resistant nylon'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=600&q=80', 'alt' => 'Zip shopper tote', 'primary' => 1],
                ],
            ],

            // ---- MEN'S BAGS & BRIEFCASES ----
            [
                'cat'     => 'mens-bags-briefcases',
                'name'    => 'Classic Leather Briefcase MB-310',
                'sku'     => 'MB-310',
                'short'   => 'Full-grain leather two-handle briefcase with combination lock, laptop sleeve, and multiple organiser compartments.',
                'desc'    => '<p>MB-310 is the quintessential OEM leather briefcase — crafted from full-grain cowhide with a stiff base board and reinforced corners. Two combination-lock clasps, a padded 15" laptop compartment, a document section, and full interior organiser. Available in black, tan, and dark brown.</p>',
                'specs'   => ['Material' => 'Full-Grain Cowhide', 'Hardware' => 'Polished Gold Clasps', 'Lock' => '3-digit combination', 'Laptop' => 'Up to 15 inch', 'Dimensions' => '42 × 32 × 10 cm', 'Handle Drop' => '15 cm'],
                'featured'=> 1,
                'images'  => [
                    ['url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&q=80', 'alt' => "Men's classic leather briefcase", 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'mens-bags-briefcases',
                'name'    => 'Laptop Messenger Bag MB-315',
                'sku'     => 'MB-315',
                'short'   => 'Slim leather messenger bag with padded laptop sleeve, magnetic flap, and quick-access front pocket for commuters.',
                'desc'    => '<p>MB-315 is a sleek leather messenger for the modern professional. The magnetic flap opens to a padded 15" laptop sleeve, main compartment, and front organiser pocket. The wide padded strap has a trolley sleeve. Slim enough for business travel, versatile enough for weekends.</p>',
                'specs'   => ['Material' => 'Top-Grain Cowhide', 'Closure' => 'Magnetic Flap', 'Laptop' => 'Up to 15 inch', 'Strap' => 'Wide padded, trolley sleeve', 'Dimensions' => '40 × 30 × 8 cm'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://images.unsplash.com/photo-1491637639811-60e2756cc1c7?w=600&q=80', 'alt' => "Men's leather messenger bag", 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'mens-bags-briefcases',
                'name'    => 'Document Portfolio MB-320',
                'sku'     => 'MB-320',
                'short'   => 'Slim leather portfolio folder with A4 notepad holder, business card slots, and pen loop — ideal for corporate gifting.',
                'desc'    => '<p>MB-320 is a slim leather portfolio that replaces the traditional folder for meetings. Holds an A4 notepad, 8 business cards, a pen, and a small tablet or document section. Zip-around or snap closure options. Custom logo embossing available — popular for corporate gifting collections.</p>',
                'specs'   => ['Material' => 'Smooth Nappa / Saffiano', 'Notepad' => 'A4 size', 'Card Slots' => '8', 'Closure' => 'Zip-around or Snap', 'Dimensions' => '34 × 25 × 2 cm'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://images.pexels.com/photos/6044266/pexels-photo-6044266.jpeg?auto=compress&cs=tinysrgb&w=600', 'alt' => 'Leather document portfolio', 'primary' => 1],
                ],
            ],

            // ---- MEN'S WALLETS ----
            [
                'cat'     => 'mens-wallets',
                'name'    => "Men's Leather Wallet VFMW-01",
                'sku'     => 'VFMW-01',
                'short'   => 'Classic bifold wallet in genuine leather with 6 card slots, a bill compartment, and a transparent ID window.',
                'desc'    => '<p>VFMW-01 is our most popular men\'s bifold — made from genuine leather with a clean, classic profile. Six card slots keep cards organised; a full-length bill pocket holds currency flat; and the transparent ID window shows your card at a glance. Slim profile fits most pockets. Available with logo embossing.</p>',
                'specs'   => ['Material' => 'Genuine Cowhide', 'Card Slots' => '6', 'Bill Pocket' => '1 full-length', 'ID Window' => 'Yes', 'Dimensions' => '11 × 9 cm (open: 22 × 9 cm)', 'RFID Blocking' => 'Optional'],
                'featured'=> 1,
                'images'  => [
                    ['url' => 'https://viale.in/wp-content/uploads/2022/11/MENS-LEATHER-WALLET-VFMW-01.png', 'alt' => "Men's Leather Wallet VFMW-01", 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'mens-wallets',
                'name'    => 'Slim Card Holder MW-410',
                'sku'     => 'MW-410',
                'short'   => 'Minimalist 4-slot card holder with centre pocket — fits in any pocket. Available in smooth and saffiano leather.',
                'desc'    => '<p>MW-410 is a no-nonsense card holder for the minimalist. Four card slots, a centre slip pocket for cash or receipts, and a slim profile that fits in any pocket. Made from saffiano leather for durability and scratch resistance. Available in 8 standard colours.</p>',
                'specs'   => ['Material' => 'Saffiano Cowhide', 'Card Slots' => '4', 'Centre Pocket' => '1 slip', 'Dimensions' => '10.5 × 7.5 cm', 'Weight' => '30 g'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://images.pexels.com/photos/6693660/pexels-photo-6693660.jpeg?auto=compress&cs=tinysrgb&w=600', 'alt' => 'Slim leather card holder', 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'mens-wallets',
                'name'    => 'Trifold Wallet MW-415',
                'sku'     => 'MW-415',
                'short'   => 'Full-capacity trifold wallet with 9 card slots, zip coin pocket, and bill compartment in premium top-grain leather.',
                'desc'    => '<p>MW-415 is the trifold for those who carry more. Nine card slots, two bill compartments, a zip coin pocket, and two slip pockets make it one of the most organised wallets in our range. Top-grain leather outer with a branded nylon lining. Custom RFID shielding available.</p>',
                'specs'   => ['Material' => 'Top-Grain Cowhide', 'Card Slots' => '9', 'Coin Pocket' => 'Zip', 'Bill Compartments' => '2', 'RFID Blocking' => 'Optional', 'Dimensions' => '11 × 9 cm (open: 33 × 9 cm)'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://viale.in/wp-content/uploads/2022/11/MENS-LEATHER-WALLET-VFMW-01.png', 'alt' => 'Trifold leather wallet', 'primary' => 1],
                ],
            ],

            // ---- MEN'S BELTS ----
            [
                'cat'     => 'mens-belts',
                'name'    => "Men's Formal Belt VWBF-01",
                'sku'     => 'VWBF-01',
                'short'   => 'Full-grain leather formal belt with polished pin buckle in silver or gold. Available in black and tan, sizes 28"–44".',
                'desc'    => '<p>VWBF-01 is a clean, classic formal belt made from full-grain leather. The slim 30mm width is perfect for dress trousers; the polished pin buckle is available in gold or silver finish. Vegetable-tanned edges, hand-burnished for a premium finish. Custom widths and lengths on request.</p>',
                'specs'   => ['Material' => 'Full-Grain Cowhide', 'Width' => '30 mm', 'Buckle' => 'Pin buckle — Gold / Silver', 'Sizes' => '28" – 44" (custom on request)', 'Edge Finish' => 'Burnished', 'Colours' => 'Black, Tan, Dark Brown'],
                'featured'=> 1,
                'images'  => [
                    ['url' => 'https://viale.in/wp-content/uploads/2022/11/Viale-Leather-Belt-Formal-VWBF-01.png', 'alt' => "Men's Formal Belt VWBF-01", 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'mens-belts',
                'name'    => "Men's Casual Belt VWBC-01",
                'sku'     => 'VWBC-01',
                'short'   => 'Casual leather belt with matte roller buckle — ideal for jeans and chinos. Custom widths and lengths available.',
                'desc'    => '<p>VWBC-01 is built for everyday wear. The 35mm width suits casual trousers and jeans; the matte roller buckle gives an understated, modern look. Made from top-grain leather with a painted edge finish. Popular with European retail chains for own-label collections.</p>',
                'specs'   => ['Material' => 'Top-Grain Cowhide', 'Width' => '35 mm', 'Buckle' => 'Roller buckle — Matte Black / Gunmetal', 'Sizes' => '28" – 46"', 'Edge Finish' => 'Painted'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://viale.in/wp-content/uploads/2022/11/Menst-Casual-Leather-VWBC-01.png', 'alt' => "Men's Casual Belt VWBC-01", 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'mens-belts',
                'name'    => "Men's Auto-Lock Belt MB-510",
                'sku'     => 'MB-510',
                'short'   => 'One-size automatic ratchet belt — genuine leather strap with no-holes auto-lock buckle for a perfect fit every time.',
                'desc'    => '<p>MB-510 uses a ratchet auto-lock buckle system — no holes, just a continuous micro-adjustment that gives the exact fit. The genuine leather strap can be trimmed to size by the wearer. Popular for men\'s gifting sets. Comes with a branded gift box and spare strap option.</p>',
                'specs'   => ['Material' => 'Genuine Cowhide', 'Width' => '35 mm', 'Buckle' => 'Auto-lock ratchet', 'Adjustment' => 'No-hole, continuous', 'Sizes' => 'One-size (trimmable)', 'Packaging' => 'Gift box included'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://images.pexels.com/photos/8365688/pexels-photo-8365688.jpeg?auto=compress&cs=tinysrgb&w=600', 'alt' => "Men's ratchet auto-lock belt", 'primary' => 1],
                ],
            ],

            // ---- LADIES' BELTS ----
            [
                'cat'     => 'ladies-belts',
                'name'    => "Ladies' Leather Belt VWLB-01",
                'sku'     => 'VWLB-01',
                'short'   => 'Fashion leather belt for women with decorative square buckle and laser-cut detailing. Available in multiple colours.',
                'desc'    => '<p>VWLB-01 is a versatile ladies fashion belt — the 25mm width suits dresses, skirts, and high-waist jeans. The decorative square buckle comes in gold, silver, and rose-gold finishes. Laser-cut floral detailing on the strap is optional. Any Pantone colour available on request.</p>',
                'specs'   => ['Material' => 'Top-Grain Cowhide', 'Width' => '25 mm', 'Buckle' => 'Square — Gold / Silver / Rose Gold', 'Sizes' => 'XS – XL (custom)', 'Detailing' => 'Laser-cut (optional)'],
                'featured'=> 1,
                'images'  => [
                    ['url' => 'https://viale.in/wp-content/uploads/2022/11/VWLB-01.png', 'alt' => "Ladies' Leather Belt VWLB-01", 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'ladies-belts',
                'name'    => "PU Ladies Belt VWLB-11",
                'sku'     => 'VWLB-11',
                'short'   => 'Slim vegan PU belt for women with polished pin buckle. Lightweight, water-resistant, and available in seasonal colours.',
                'desc'    => '<p>VWLB-11 is a vegan-friendly fashion belt in high-quality PU microfibre. A slim 20mm strap with a polished pin buckle — lightweight, flexible, and water-resistant. Perfect for brands building a vegan accessories capsule. Six standard seasonal colours plus custom Pantone.</p>',
                'specs'   => ['Material' => 'PU Microfibre', 'Width' => '20 mm', 'Buckle' => 'Polished Pin', 'Finish' => 'Water-resistant', 'Sizes' => 'XS – XL'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://viale.in/wp-content/uploads/2022/11/LADIES-PU-BELT-VWLB-11.png', 'alt' => 'PU Ladies Belt VWLB-11', 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'ladies-belts',
                'name'    => "Chain-Trim Fashion Belt LB-610",
                'sku'     => 'LB-610',
                'short'   => 'Statement fashion belt with interlinked metal chain trim along the strap — a runway-inspired design for premium retail.',
                'desc'    => '<p>LB-610 is a fashion-forward statement belt featuring an interlinked metal chain trim riveted along the leather strap. The chain comes in gold, silver, or two-tone finish. The strap is smooth calfskin. Designed for premium fashion retail — available in small runs from 50 pcs per style.</p>',
                'specs'   => ['Material' => 'Smooth Calfskin', 'Chain' => 'Gold / Silver / Two-tone', 'Width' => '30 mm', 'Closure' => 'T-bar or hook', 'Sizes' => 'XS – XL'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://images.unsplash.com/photo-1544441893-675973e31985?w=600&q=80', 'alt' => 'Chain-trim fashion belt', 'primary' => 1],
                ],
            ],

            // ---- TRAVEL & DUFFEL BAGS ----
            [
                'cat'     => 'travel-duffel-bags',
                'name'    => 'Travel Duffel TD-01',
                'sku'     => 'TD-01',
                'short'   => 'Large capacity leather duffel bag with shoe compartment, trolley sleeve, and combination padlock — weekend-ready.',
                'desc'    => '<p>TD-01 is a classic travel duffel crafted in water-resistant cowhide. The large main compartment comfortably fits a weekend\'s worth of clothes; a separate zip shoe compartment keeps footwear isolated; a trolley sleeve slips over carry-on handles; and two combination padlocks secure the zips. Available in 3 sizes.</p>',
                'specs'   => ['Material' => 'Water-Resistant Cowhide', 'Shoe Compartment' => 'Yes (separate zip)', 'Trolley Sleeve' => 'Yes', 'Lock' => '2 × combination padlock', 'Sizes' => 'S (45L) / M (65L) / L (85L)'],
                'featured'=> 1,
                'images'  => [
                    ['url' => 'https://viale.in/wp-content/uploads/2022/11/Travel-Bags-1.jpg', 'alt' => 'Travel Duffel TD-01', 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'travel-duffel-bags',
                'name'    => 'Weekender Canvas Bag TD-710',
                'sku'     => 'TD-710',
                'short'   => 'Waxed canvas and leather weekender with multiple exterior pockets, padded handles, and detachable shoulder strap.',
                'desc'    => '<p>TD-710 is a stylish weekender that balances durability with looks. The waxed canvas body resists water and ageing; the leather base, handles, and trim develop a patina over time. Four exterior pockets, a padded interior, and a removable shoulder strap make it as practical as it is good-looking.</p>',
                'specs'   => ['Material' => 'Waxed Canvas + Leather Trim', 'Handles' => 'Padded leather', 'Strap' => 'Removable, adjustable', 'Exterior Pockets' => '4', 'Dimensions' => '55 × 32 × 28 cm'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&q=80', 'alt' => 'Waxed canvas weekender bag', 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'travel-duffel-bags',
                'name'    => 'Cabin Overnight Bag TD-715',
                'sku'     => 'TD-715',
                'short'   => 'Cabin-size overnight bag with laptop pocket, suit hanger hook, and trolley sleeve — approved for most airline overhead bins.',
                'desc'    => '<p>TD-715 is designed to fit in airline overhead bins (55 × 40 × 20 cm, most airline carry-on limits). A padded 15" laptop pocket, a suit hanger hook, and a dedicated shoe pouch inside. Smooth genuine leather, polished hardware. Great for business travellers and frequent flyers.</p>',
                'specs'   => ['Material' => 'Smooth Genuine Leather', 'Dimensions' => '55 × 40 × 20 cm', 'Laptop Pocket' => 'Up to 15 inch', 'Suit Hook' => 'Yes (retractable)', 'Trolley Sleeve' => 'Yes'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://images.pexels.com/photos/1282316/pexels-photo-1282316.jpeg?auto=compress&cs=tinysrgb&w=600', 'alt' => 'Cabin overnight travel bag', 'primary' => 1],
                ],
            ],

            // ---- SMALL LEATHER GOODS ----
            [
                'cat'     => 'small-leather-goods',
                'name'    => 'Leather Card Case SLG-810',
                'sku'     => 'SLG-810',
                'short'   => 'Slim business card case in premium leather holding up to 20 cards — ideal for corporate gifting with logo emboss.',
                'desc'    => '<p>SLG-810 is a slim, elegant card case for business professionals. Holds up to 20 cards, slides open with a thumb push, and snaps shut magnetically. Available in smooth, saffiano, and croc-print leathers. A popular corporate gifting item — custom logo embossing on the front panel at no extra charge on orders of 200+.</p>',
                'specs'   => ['Material' => 'Saffiano / Smooth / Croc', 'Capacity' => 'Up to 20 cards', 'Closure' => 'Magnetic snap', 'Dimensions' => '10 × 7 cm', 'Branding' => 'Emboss/deboss on front'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://images.pexels.com/photos/6693660/pexels-photo-6693660.jpeg?auto=compress&cs=tinysrgb&w=600', 'alt' => 'Leather business card case', 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'small-leather-goods',
                'name'    => 'Leather Key Holder SLG-815',
                'sku'     => 'SLG-815',
                'short'   => 'Compact 4-hook leather key organiser that keeps keys flat and silent — no more key jangle in your pocket.',
                'desc'    => '<p>SLG-815 is a compact key organiser with 4 stainless hooks that hold keys in a flat, silent arrangement — no more bulk or jangle. The full leather exterior snaps closed and fits easily in any pocket. Available in smooth leather with logo stamp. Great as a set with a matching wallet or card case.</p>',
                'specs'   => ['Material' => 'Full-Grain Cowhide', 'Hooks' => '4 (stainless steel)', 'Closure' => 'Snap', 'Dimensions' => '8 × 4 cm (closed)', 'Colours' => 'Black, Tan, Dark Brown, Navy'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=600&q=80', 'alt' => 'Leather key holder', 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'small-leather-goods',
                'name'    => 'Passport Cover SLG-820',
                'sku'     => 'SLG-820',
                'short'   => 'Full-grain leather passport cover with card slots, boarding pass pocket, and pen loop — the complete travel companion.',
                'desc'    => '<p>SLG-820 is a full-grain leather passport cover with everything a traveller needs. Holds a passport, 4 cards, a boarding pass, and a slim pen. RFID-blocking lining protects your data. Available in 10 standard leather colours — custom interior print or logo foil stamp available.</p>',
                'specs'   => ['Material' => 'Full-Grain Cowhide', 'RFID Blocking' => 'Yes', 'Card Slots' => '4', 'Pen Loop' => 'Yes', 'Boarding Pass' => 'Full-width slot', 'Dimensions' => '14.5 × 10.5 cm'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://images.pexels.com/photos/7029991/pexels-photo-7029991.jpeg?auto=compress&cs=tinysrgb&w=600', 'alt' => 'Leather passport cover', 'primary' => 1],
                ],
            ],

            // ---- BACKPACKS ----
            [
                'cat'     => 'backpacks',
                'name'    => 'Leather Laptop Backpack BP-910',
                'sku'     => 'BP-910',
                'short'   => 'Full-grain leather laptop backpack with padded 15" sleeve, anti-theft back pocket, and premium YKK zippers.',
                'desc'    => '<p>BP-910 is a premium everyday leather backpack built for professionals. The padded 15" laptop sleeve is shielded from the back; an anti-theft hidden back pocket carries valuables securely; and all zippers are YKK for durability. Padded shoulder straps and a back panel make all-day carry comfortable. Custom branding available.</p>',
                'specs'   => ['Material' => 'Full-Grain Cowhide', 'Laptop' => 'Up to 15 inch', 'Anti-Theft Pocket' => 'Yes (back)', 'Zippers' => 'YKK', 'Capacity' => '22L', 'Dimensions' => '44 × 32 × 14 cm'],
                'featured'=> 1,
                'images'  => [
                    ['url' => 'https://images.unsplash.com/photo-1491637639811-60e2756cc1c7?w=600&q=80', 'alt' => 'Leather laptop backpack', 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'backpacks',
                'name'    => 'Canvas & Leather Pack BP-915',
                'sku'     => 'BP-915',
                'short'   => 'Durable waxed canvas backpack with full-grain leather base, straps, and trim — rugged and travel-ready.',
                'desc'    => '<p>BP-915 is a heritage-inspired canvas and leather pack built to travel. The waxed canvas repels water; the full-grain base and shoulder straps develop a rich patina. Internal frame sheet keeps shape; a padded 13" laptop slip sits inside the main compartment. Three exterior pockets for quick-access organisation.</p>',
                'specs'   => ['Material' => 'Waxed Canvas + Full-Grain Leather', 'Laptop' => 'Up to 13 inch', 'Exterior Pockets' => '3', 'Capacity' => '28L', 'Dimensions' => '46 × 34 × 16 cm'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=600&q=80', 'alt' => 'Canvas leather backpack', 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'backpacks',
                'name'    => 'Mini Leather Rucksack BP-920',
                'sku'     => 'BP-920',
                'short'   => 'Compact mini rucksack in soft nappa leather — a fashion-forward design for women and men, suitable for evenings and day trips.',
                'desc'    => '<p>BP-920 is a fashion mini-rucksack in soft nappa leather — small enough for evenings, spacious enough for day trips. The drawstring-and-flap closure with a magnetic snap is both secure and stylish. Interior: one main compartment with a zip pocket and a phone sleeve. Padded straps double as a clutch if the straps are tucked away.</p>',
                'specs'   => ['Material' => 'Soft Nappa', 'Closure' => 'Drawstring + flap + magnetic snap', 'Capacity' => '8L', 'Dimensions' => '28 × 22 × 10 cm', 'Straps' => 'Padded (concealable)'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://viale.in/wp-content/uploads/2022/10/VF-1039-1.png', 'alt' => 'Mini leather rucksack', 'primary' => 1],
                ],
            ],

            // ---- VEGAN & PU COLLECTION ----
            [
                'cat'     => 'vegan-pu-collection',
                'name'    => 'Vegan Tote VG-1010',
                'sku'     => 'VG-1010',
                'short'   => 'Large open-top vegan tote in premium PU microfibre with eco-branded lining and recycled hardware — 100% animal-free.',
                'desc'    => '<p>VG-1010 is designed for eco-conscious brands. The PU microfibre exterior looks and feels like leather but is 100% animal-free. The interior is a recycled-yarn fabric with a printed eco-messaging lining option. All hardware is recycled zinc alloy. Ideal for vegan lifestyle brands, eco retail, and conscious gifting.</p>',
                'specs'   => ['Material' => 'PU Microfibre (vegan)', 'Lining' => 'Recycled-yarn fabric', 'Hardware' => 'Recycled zinc alloy', 'Dimensions' => '38 × 32 × 12 cm', 'Certification' => 'PETA-Approved Vegan on request'],
                'featured'=> 1,
                'images'  => [
                    ['url' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=600&q=80', 'alt' => 'Vegan PU tote bag', 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'vegan-pu-collection',
                'name'    => 'PU Crossbody VG-1015',
                'sku'     => 'VG-1015',
                'short'   => 'Compact vegan crossbody in scratch-resistant PU with adjustable strap, front zip pocket, and water-resistant finish.',
                'desc'    => '<p>VG-1015 is a functional and stylish vegan crossbody. The scratch-resistant PU exterior has a subtle texture; the front zip pocket provides quick access; the main compartment has an organiser section inside. Adjustable nylon webbing strap with PU trim. Available in seasonal fashion colours.</p>',
                'specs'   => ['Material' => 'Scratch-Resistant PU', 'Strap' => 'Nylon webbing + PU trim, adjustable', 'Closure' => 'Zip', 'Dimensions' => '24 × 18 × 7 cm', 'Finish' => 'Water-resistant'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://viale.in/wp-content/uploads/2022/11/LADIES-PU-BELT-VWLB-11.png', 'alt' => 'PU vegan crossbody bag', 'primary' => 1],
                ],
            ],
            [
                'cat'     => 'vegan-pu-collection',
                'name'    => 'Eco Slim Wallet VG-1020',
                'sku'     => 'VG-1020',
                'short'   => 'Ultra-slim vegan bifold wallet in Piñatex (pineapple leaf fibre) — a unique, sustainable alternative to leather.',
                'desc'    => '<p>VG-1020 uses Piñatex — a natural textile made from pineapple leaf fibres, a by-product of the pineapple food industry. The result is a slim, durable bifold wallet with a distinctive texture. Six card slots, a bill pocket, and a transparent ID window. Available in natural tan, deep black, and forest green.</p>',
                'specs'   => ['Material' => 'Piñatex (Pineapple Leaf Fibre)', 'Card Slots' => '6', 'ID Window' => 'Yes', 'Dimensions' => '11 × 9 cm', 'Certification' => 'Cradle-to-Cradle Silver (Ananas Anam)'],
                'featured'=> 0,
                'images'  => [
                    ['url' => 'https://images.pexels.com/photos/7029991/pexels-photo-7029991.jpeg?auto=compress&cs=tinysrgb&w=600', 'alt' => 'Eco vegan slim wallet', 'primary' => 1],
                ],
            ],
        ];

        // Insert products and images
        foreach ($products as $p) {
            $catId = $catIds[$p['cat']] ?? null;
            if (! $catId) continue;

            $slug = \App\Models\ProductModel::makeSlug($p['name']);

            $productId = $db->table('products')->insert([
                'category_id'       => $catId,
                'name'              => $p['name'],
                'slug'              => $slug,
                'short_description' => $p['short'],
                'description'       => $p['desc'],
                'specifications'    => json_encode($p['specs']),
                'sku'               => $p['sku'],
                'is_featured'       => $p['featured'],
                'is_active'         => 1,
                'view_count'        => 0,
                'created_at'        => $now,
                'updated_at'        => $now,
            ]);

            $insertedId = $db->insertID();

            foreach ($p['images'] as $sort => $img) {
                $db->table('product_images')->insert([
                    'product_id' => $insertedId,
                    'image_path' => $img['url'],
                    'alt_text'   => $img['alt'],
                    'sort_order' => $sort,
                    'is_primary' => $img['primary'],
                    'created_at' => $now,
                ]);
            }
        }

        echo "ProductionSeeder: " . count($categories) . " categories and " . count($products) . " products seeded.\n";
    }
}
