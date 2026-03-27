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

/**
 * Schema.org JSON-LD — sitewide Organization + WebSite schemas
 * Injected on every public page via the layout.
 * Product pages add their own Product schema via $this->section('schema').
 */
$siteName    = $settings['site_name']    ?? 'Product Gallery';
$siteTagline = $settings['site_tagline'] ?? 'OEM Leather Goods & Fashion Accessories Manufacturer';
$siteUrl     = base_url();
$phone       = $settings['contact_phone']   ?? '';
$email       = $settings['enquiry_email']   ?? '';
$address     = $settings['contact_address'] ?? 'Kanpur, Uttar Pradesh 208001, India';
$whatsapp    = $settings['whatsapp_number'] ?? '';

// Build social profile array
$sameAs = array_values(array_filter([
    $settings['facebook_url']  ?? '',
    $settings['instagram_url'] ?? '',
    $settings['linkedin_url']  ?? '',
    $settings['twitter_url']   ?? '',
    $whatsapp ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $whatsapp) : '',
]));

// ── Organization ─────────────────────────────────────────────────────────────
$organization = [
    '@context'    => 'https://schema.org',
    '@type'       => ['Organization', 'LocalBusiness', 'Store'],
    '@id'         => $siteUrl . '#organization',
    'name'        => $siteName,
    'alternateName' => 'OEM Leather Goods Manufacturer Kanpur',
    'description' => $siteTagline,
    'url'         => $siteUrl,
    'logo'        => [
        '@type' => 'ImageObject',
        'url'   => base_url('assets/img/og-default.jpg'),
    ],
    'image'       => base_url('assets/img/og-default.jpg'),
    'foundingDate'=> '2010',
    'slogan'      => 'Think Leather. Think Craft. Think Quality.',
    'address'     => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => $address,
        'addressLocality' => 'Kanpur',
        'addressRegion'   => 'Uttar Pradesh',
        'postalCode'      => '208001',
        'addressCountry'  => 'IN',
    ],
    'geo' => [
        '@type'     => 'GeoCoordinates',
        'latitude'  => '26.4499',
        'longitude' => '80.3319',
    ],
    'areaServed'  => 'Worldwide',
    'numberOfEmployees' => ['@type' => 'QuantitativeValue', 'value' => '500'],
    'knowsAbout'  => [
        'Leather goods manufacturing',
        'OEM accessories',
        'ODM leather bags',
        'Private label handbags',
        'Leather wallets',
        'Leather belts',
        'Fashion accessories export',
    ],
    'hasCredential' => [
        ['@type' => 'EducationalOccupationalCredential', 'name' => 'ISO 9001:2015 Quality Management'],
        ['@type' => 'EducationalOccupationalCredential', 'name' => 'SA 8000 Social Accountability'],
        ['@type' => 'EducationalOccupationalCredential', 'name' => 'LWG Silver Tannery Certification'],
        ['@type' => 'EducationalOccupationalCredential', 'name' => 'SEDEX Ethical Trade Membership'],
    ],
];
if ($phone)   $organization['telephone'] = $phone;
if ($email)   $organization['email']     = $email;
if ($sameAs)  $organization['sameAs']    = $sameAs;
$organization['openingHoursSpecification'] = [
    '@type'     => 'OpeningHoursSpecification',
    'dayOfWeek' => ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
    'opens'     => '09:00',
    'closes'    => '18:30',
];
$organization['contactPoint'] = [
    '@type'             => 'ContactPoint',
    'contactType'       => 'sales',
    'areaServed'        => 'Worldwide',
    'availableLanguage' => ['English', 'Hindi'],
];
if ($email) $organization['contactPoint']['email']     = $email;
if ($phone) $organization['contactPoint']['telephone'] = $phone;

// ── WebSite (enables Sitelinks Search Box in Google) ─────────────────────────
$website = [
    '@context'        => 'https://schema.org',
    '@type'           => 'WebSite',
    '@id'             => $siteUrl . '#website',
    'name'            => $siteName,
    'url'             => $siteUrl,
    'description'     => $siteTagline,
    'inLanguage'      => 'en-IN',
    'publisher'       => ['@id' => $siteUrl . '#organization'],
    'potentialAction' => [
        '@type'       => 'SearchAction',
        'target'      => [
            '@type'       => 'EntryPoint',
            'urlTemplate' => $siteUrl . 'search?q={search_term_string}',
        ],
        'query-input' => 'required name=search_term_string',
    ],
    'creator' => [
        '@type' => 'Organization',
        'name'  => 'RAMRAS Technologies',
        'url'   => 'https://ramrastech.com',
    ],
];

// ── BreadcrumbList (per page) ─────────────────────────────────────────────────
$uri        = uri_string();
$breadcrumb = null;

if ($uri === '') {
    // Home — no breadcrumb needed
} elseif ($uri === 'products') {
    $breadcrumb = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',     'item' => $siteUrl],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Products', 'item' => $siteUrl . 'products'],
        ],
    ];
} elseif (str_starts_with($uri, 'products/')) {
    $breadcrumb = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',     'item' => $siteUrl],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Products', 'item' => $siteUrl . 'products'],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $metaTitle ?? 'Product', 'item' => current_url()],
        ],
    ];
} elseif (in_array($uri, ['about','contact','faq','privacy','terms'])) {
    $pageLabels = ['about' => 'About Us', 'contact' => 'Contact', 'faq' => 'FAQ', 'privacy' => 'Privacy Policy', 'terms' => 'Terms & Conditions'];
    $breadcrumb = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $siteUrl],
            ['@type' => 'ListItem', 'position' => 2, 'name' => $pageLabels[$uri] ?? ucfirst($uri), 'item' => current_url()],
        ],
    ];
}
?>
<script type="application/ld+json"><?= json_encode($organization, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<script type="application/ld+json"><?= json_encode($website,      JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?php if ($breadcrumb): ?>
<script type="application/ld+json"><?= json_encode($breadcrumb,   JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?php endif ?>
<?= $this->renderSection('schema') ?>
