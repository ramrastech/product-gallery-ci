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

namespace App\Models;

use CodeIgniter\Model;

class AuditLogModel extends Model
{
    protected $table            = 'audit_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'admin_id', 'admin_username', 'action', 'entity', 'entity_id', 'detail', 'ip_address', 'created_at',
    ];

    protected $useTimestamps = false;

    public static function record(string $action, string $entity = null, int $entityId = null, string $detail = null): void
    {
        $model = new self();
        $model->insert([
            'admin_id'       => session()->get('admin_id'),
            'admin_username' => session()->get('admin_username'),
            'action'         => $action,
            'entity'         => $entity,
            'entity_id'      => $entityId,
            'detail'         => $detail,
            'ip_address'     => service('request')->getIPAddress(),
            'created_at'     => date('Y-m-d H:i:s'),
        ]);
    }
}
