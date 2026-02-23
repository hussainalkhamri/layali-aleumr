<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = AuditLog::with('user');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('action_type', 'like', "%$s%")->orWhere('table_name', 'like', "%$s%")->orWhereHas('user', fn($uq) => $uq->where('full_name', 'like', "%$s%")));
        }

        $logs = $query->latest()->take(200)->get();

        return view('pages.audit-logs', compact('logs'));
    }
}
