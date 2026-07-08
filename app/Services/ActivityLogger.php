<?php

namespace App\Services;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    /**
     * Create a new class instance.
     */
    public static function log(
        string $action,
        string $module,
        string $description,
    ) {
        ActivityLog::create([
            'user_id'      => Auth::id(),
            'action'       => $action,
            'module'       => $module,
            'description'  => $description,
        ]);
    }
}
