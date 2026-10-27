<?php

namespace App\Services;

use App\Models\ActivityLog;

class ActivityLogger
{
    /**
     * Record an audit trail to t_activity_log.
     *
     * @param  array<string, mixed>|null  $properties
     */
    public static function log(
        int|string|null $accountId,
        string $action,
        ?string $description = null,
        ?int $studentId = null,
        ?array $properties = null
    ): ActivityLog {
        return ActivityLog::create([
            'id_account' => (int) $accountId,
            'id_siswa' => $studentId,
            'action' => $action,
            'description' => $description,
            'properties' => $properties,
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ]);
    }
}
