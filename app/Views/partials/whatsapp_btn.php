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

$waNumber = $settings['whatsapp_number'] ?? '';
$waText   = $waMessage ?? 'Hello! I am interested in your products.';
if (empty($waNumber)) return;
$waUrl = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $waNumber) . '?text=' . rawurlencode($waText);
?>
<a href="<?= esc($waUrl) ?>" class="pg-whatsapp-btn" target="_blank" rel="noopener" title="Chat on WhatsApp">
    <i class="bi bi-whatsapp"></i>
</a>
