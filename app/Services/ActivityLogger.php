<?php

namespace App\Services;

use App\Models\ActivityLog;

class ActivityLogger
{
    public static function log($userId = null, string $action, ?string $description = null, array $properties = [])
    {
        ActivityLog::create([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip() ?? null,
            'user_agent' => request()->userAgent() ?? null,
            'properties' => $properties ?: null,
        ]);
    }
}
