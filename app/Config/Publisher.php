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

namespace Config;

use CodeIgniter\Config\Publisher as BasePublisher;

/**
 * Publisher Configuration
 *
 * Defines basic security restrictions for the Publisher class
 * to prevent abuse by injecting malicious files into a project.
 */
class Publisher extends BasePublisher
{
    /**
     * A list of allowed destinations with a (pseudo-)regex
     * of allowed files for each destination.
     * Attempts to publish to directories not in this list will
     * result in a PublisherException. Files that do no fit the
     * pattern will cause copy/merge to fail.
     *
     * @var array<string, string>
     */
    public $restrictions = [
        ROOTPATH => '*',
        FCPATH   => '#\.(s?css|js|map|html?|xml|json|webmanifest|ttf|eot|woff2?|gif|jpe?g|tiff?|png|webp|bmp|ico|svg)$#i',
    ];
}
