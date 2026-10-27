<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $id_siswa
 * @property int $id_pelatih
 * @property array<int|string, mixed>|null $requested_items
 * @property string|null $catatan
 * @property string $status
 * @property Carbon|null $created_at
 * @property-read Student|null $student
 * @property-read Account|null $coach
 */
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

    /**
     * @return BelongsTo<Student, $this>
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'id_siswa');
    }

    /**
     * @return BelongsTo<Account, $this>
     */
    public function coach(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'id_pelatih');
    }
}
