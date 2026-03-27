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

$url   = urlencode(current_url());
$title = urlencode($shareTitle ?? '');
$waMsg = urlencode(($shareTitle ?? '') . ' — ' . current_url());
$waNum = $settings['whatsapp_number'] ?? '';
?>
<div class="pg-share-row d-flex align-items-center gap-2 flex-wrap">
    <span class="small text-muted me-1">Share:</span>

    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $url ?>"
       target="_blank" rel="noopener" class="pg-share-btn pg-share-fb" title="Share on Facebook">
        <i class="bi bi-facebook"></i>
    </a>

    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= $url ?>&title=<?= $title ?>"
       target="_blank" rel="noopener" class="pg-share-btn pg-share-li" title="Share on LinkedIn">
        <i class="bi bi-linkedin"></i>
    </a>

    <a href="https://twitter.com/intent/tweet?url=<?= $url ?>&text=<?= $title ?>"
       target="_blank" rel="noopener" class="pg-share-btn pg-share-tw" title="Share on Twitter/X">
        <i class="bi bi-twitter-x"></i>
    </a>

    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $waNum) ?>?text=<?= $waMsg ?>"
       target="_blank" rel="noopener" class="pg-share-btn pg-share-wa" title="Share on WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>

    <button onclick="navigator.clipboard.writeText('<?= current_url() ?>').then(()=>alert('Link copied!'))"
            class="pg-share-btn pg-share-copy" title="Copy Link">
        <i class="bi bi-link-45deg"></i>
    </button>
</div>
