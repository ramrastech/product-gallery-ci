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

use CodeIgniter\Pager\PagerRenderer;

/** @var PagerRenderer $pager */
$pager->setSurroundCount(2);
?>

<nav aria-label="Product navigation">
    <ul class="pagination justify-content-center">

        <?php if ($pager->hasPrevious()): ?>
        <li class="page-item">
            <a class="page-link pg-page-link" href="<?= $pager->getPrevious() ?>" aria-label="Previous">
                <i class="bi bi-chevron-left"></i>
            </a>
        </li>
        <?php else: ?>
        <li class="page-item disabled">
            <span class="page-link pg-page-link"><i class="bi bi-chevron-left"></i></span>
        </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link): ?>
        <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
            <?php if ($link['active']): ?>
            <span class="page-link pg-page-link"><?= $link['title'] ?></span>
            <?php else: ?>
            <a class="page-link pg-page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
            <?php endif ?>
        </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()): ?>
        <li class="page-item">
            <a class="page-link pg-page-link" href="<?= $pager->getNext() ?>" aria-label="Next">
                <i class="bi bi-chevron-right"></i>
            </a>
        </li>
        <?php else: ?>
        <li class="page-item disabled">
            <span class="page-link pg-page-link"><i class="bi bi-chevron-right"></i></span>
        </li>
        <?php endif ?>

    </ul>
</nav>
