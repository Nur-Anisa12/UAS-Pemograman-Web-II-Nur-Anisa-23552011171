<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Filter berdasarkan module
        if ($request->module) {
            $query->where('module', $request->module);
        }

        // Filter berdasarkan action
        if ($request->action) {
            $query->where('action', $request->action);
        }

        // Search description
        if ($request->search) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        // Filter tanggal
        if ($request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $logs = $query->paginate(20)->withQueryString();

        // Untuk dropdown filter
        $modules = ActivityLog::distinct()->pluck('module');
        $actions = ActivityLog::distinct()->pluck('action');

        return view('admin.activity-log.index', compact('logs', 'modules', 'actions'));
    }
}
