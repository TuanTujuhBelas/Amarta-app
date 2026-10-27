<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RevisionRequest extends Model
{
    const UPDATED_AT = null; // Sesuai PRD hanya ada created_at

    protected $table = 't_revisi_request';

    protected $fillable = [
        'id_siswa',
        'id_pelatih',
        'requested_items',
        'catatan',
        'status',
    ];

    protected $casts = [
        'requested_items' => 'array',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'id_siswa');
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'id_pelatih');
    }
}
