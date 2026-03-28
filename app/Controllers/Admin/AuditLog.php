<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AuditLogModel;

class AuditLog extends BaseController
{
    public function index()
    {
        $model  = new AuditLogModel();
        $page   = (int) ($this->request->getGet('page') ?? 1);
        $entity = $this->request->getGet('entity');
        $admin  = $this->request->getGet('admin');

        if ($entity) {
            $model = $model->where('entity', $entity);
        }
        if ($admin) {
            $model = $model->like('admin_username', $admin);
        }

        $logs  = $model->orderBy('created_at', 'DESC')->paginate(50);
        $pager = $model->pager;

        // Distinct entity types for filter dropdown
        $db      = \Config\Database::connect();
        $entities = $db->table('audit_logs')
                       ->select('entity')
                       ->distinct()
                       ->where('entity IS NOT NULL', null, false)
                       ->orderBy('entity')
                       ->get()->getResultArray();

        return view('admin/audit_log/index', [
            'pageTitle' => 'Activity Log',
            'logs'      => $logs,
            'pager'     => $pager,
            'entities'  => array_column($entities, 'entity'),
            'filterEntity' => $entity,
            'filterAdmin'  => $admin,
        ]);
    }

    public function clear()
    {
        $db = \Config\Database::connect();
        $db->table('audit_logs')->truncate();
        AuditLogModel::record('audit_log_cleared', 'audit_logs', null, 'Audit log cleared by admin');
        return redirect()->to('/admin/audit-log')->with('success', 'Activity log cleared.');
    }
}
