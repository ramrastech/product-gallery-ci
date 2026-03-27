<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePageContentTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'page_key'       => ['type' => 'VARCHAR', 'constraint' => 50],
            'hero_title'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hero_subtitle'  => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'hero_bg_image'  => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'content'        => ['type' => 'LONGTEXT', 'null' => true],
            'last_updated'   => ['type' => 'DATE', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('page_key');
        $this->forge->createTable('page_content');

        // Seed default page content for privacy and terms
        $privacyContent = '<p class="pg-legal-intro">We operate this website as an OEM leather goods and fashion accessories manufacturer based in Kanpur, India. This Privacy Policy explains how we collect, use, protect, and disclose information when you visit our website or contact us with a business enquiry.</p>

<h2>1. Information We Collect</h2>
<h3>Information you provide directly</h3>
<p>When you submit an enquiry through our website you may provide:</p>
<ul>
<li>Your full name</li>
<li>Email address</li>
<li>Phone or WhatsApp number</li>
<li>Company or brand name</li>
<li>Your product requirements or message</li>
</ul>

<h3>Information collected automatically</h3>
<p>When you visit our website, we automatically receive:</p>
<ul>
<li>IP address and approximate location</li>
<li>Browser type and version</li>
<li>Pages visited and time spent on each page</li>
<li>Referring website</li>
<li>Device type (desktop, tablet, mobile)</li>
</ul>

<h2>2. How We Use Your Information</h2>
<ul>
<li><strong>To respond to enquiries</strong> — to answer your questions, send quotes, and coordinate sample production.</li>
<li><strong>To process orders</strong> — to manage OEM/ODM production orders, issue invoices, and arrange shipments.</li>
<li><strong>To communicate with you</strong> — to send order updates, shipping notifications, and follow-ups.</li>
<li><strong>To improve our website</strong> — to analyse how visitors use our site.</li>
<li><strong>To comply with legal obligations</strong> — export documentation, taxation, and trade compliance.</li>
</ul>
<p>We do <strong>not</strong> sell, rent, or share your personal information with third parties for their marketing purposes.</p>

<h2>3. Sharing of Information</h2>
<ul>
<li><strong>Logistics partners</strong> — freight forwarders receive your shipping address to arrange delivery.</li>
<li><strong>Payment processors</strong> — banking details are processed by your bank, not stored by us.</li>
<li><strong>Analytics providers</strong> — if Google Analytics is enabled, anonymised data is shared with Google.</li>
<li><strong>Legal requirements</strong> — we may disclose information if required by law or court order.</li>
</ul>

<h2>4. Data Retention</h2>
<p>We retain enquiry data for <strong>3 years</strong> from the date of last contact, or for the duration of any active business relationship and 3 years thereafter.</p>

<h2>5. Cookies</h2>
<ul>
<li><strong>Essential cookies</strong> — required for the website to function.</li>
<li><strong>Analytics cookies</strong> — used to understand how visitors navigate the site (anonymised, only if Google Analytics is enabled).</li>
</ul>

<h2>6. Third-Party Links</h2>
<p>Our website may contain links to external websites. We are not responsible for the privacy practices of those sites.</p>

<h2>7. Your Rights</h2>
<ul>
<li>Request a copy of the personal data we hold about you</li>
<li>Correct inaccurate personal data</li>
<li>Request deletion of your personal data</li>
<li>Withdraw consent for marketing communications</li>
<li>Lodge a complaint with your local data protection authority</li>
</ul>

<h2>8. Data Security</h2>
<p>We take reasonable technical and organisational measures to protect your personal information against unauthorised access, loss, or misuse, including encrypted database storage and HTTPS on all pages.</p>

<h2>9. Children\'s Privacy</h2>
<p>Our website is a B2B platform intended for trade buyers. We do not knowingly collect personal information from individuals under the age of 18.</p>

<h2>10. Changes to This Policy</h2>
<p>We may update this Privacy Policy from time to time. The "Last updated" date at the top of this page reflects the most recent revision.</p>';

        $termsContent = '<p class="pg-legal-intro">By accessing and using this website, you agree to be bound by these Terms &amp; Conditions. Please read them carefully before using our website or contacting us for business.</p>

<h2>1. Use of Website</h2>
<p>This website is provided for informational and business enquiry purposes. You agree to:</p>
<ul>
<li>Use the website only for lawful purposes</li>
<li>Not transmit any harmful, offensive, or misleading content</li>
<li>Not attempt to gain unauthorised access to any part of the site</li>
<li>Not use automated tools to scrape or extract content without prior written consent</li>
</ul>

<h2>2. Product Information</h2>
<p>All product descriptions, specifications, and images are for reference purposes only. Actual products may vary slightly due to:</p>
<ul>
<li>Material batch variations</li>
<li>Photography and display colour differences</li>
<li>Custom modifications requested by the buyer</li>
</ul>
<p>Confirmed specifications are governed by the purchase order and any agreed tech packs, not by website content.</p>

<h2>3. Enquiries &amp; Quotations</h2>
<p>Submitting an enquiry through this website does not constitute a purchase order or binding agreement. A quotation issued by us is valid for <strong>30 days</strong> unless otherwise stated. We reserve the right to withdraw or amend quotations before acceptance.</p>

<h2>4. Intellectual Property</h2>
<p>All content on this website — including text, images, product designs, and branding — is the property of the company or licensed to us. You may not reproduce, distribute, or use our content without written permission, except for personal reference.</p>

<h2>5. Confidentiality</h2>
<p>Any tech packs, design files, or proprietary information shared by buyers during the enquiry or order process will be treated as confidential. We do not share client designs with third parties without express written consent. We are happy to sign an NDA before any design sharing.</p>

<h2>6. Limitation of Liability</h2>
<p>To the extent permitted by law, we shall not be liable for:</p>
<ul>
<li>Any indirect, incidental, or consequential losses arising from use of this website</li>
<li>Inaccuracies in product information on the website (order specifications supersede website content)</li>
<li>Delays caused by circumstances beyond our control (force majeure)</li>
</ul>

<h2>7. Governing Law</h2>
<p>These Terms &amp; Conditions are governed by the laws of India. Any disputes shall be subject to the exclusive jurisdiction of the courts of Kanpur, Uttar Pradesh, India.</p>

<h2>8. Amendments</h2>
<p>We reserve the right to update these Terms &amp; Conditions at any time. Changes are effective immediately upon posting to the website. Continued use of the website constitutes acceptance of the revised terms.</p>';

        $this->db->table('page_content')->insertBatch([
            [
                'page_key'      => 'privacy',
                'hero_title'    => 'Privacy Policy',
                'hero_subtitle' => 'How we collect, use, and protect your information',
                'content'       => $privacyContent,
                'last_updated'  => date('Y-m-d'),
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'page_key'      => 'terms',
                'hero_title'    => 'Terms & Conditions',
                'hero_subtitle' => 'Terms governing the use of our website and services',
                'content'       => $termsContent,
                'last_updated'  => date('Y-m-d'),
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('page_content');
    }
}
