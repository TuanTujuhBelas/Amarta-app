<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    const UPDATED_AT = null; // Sesuai PRD hanya ada created_at

    protected $table = 't_activity_log';

    protected $fillable = [
        'id_account',
        'id_siswa',
        'action',
        'description',
        'properties',
        'ip_address',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'id_account');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'id_siswa');
    }
}
