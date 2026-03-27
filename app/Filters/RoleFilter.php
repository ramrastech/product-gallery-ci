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

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * RoleFilter — restrict routes to specific roles.
 *
 * Usage in routes:
 *   ['filter' => 'role:super_admin']
 *   ['filter' => 'role:super_admin,manager']
 */
class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $role = session()->get('admin_role') ?? 'viewer';

        if (empty($arguments)) {
            return;
        }

        $allowed = array_map('trim', explode(',', implode(',', $arguments)));

        if (! in_array($role, $allowed, true)) {
            return redirect()->to('/admin')->with('error', 'Access denied. Insufficient permissions.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // nothing
    }
}
