<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $id_account
 * @property int|null $id_siswa
 * @property string $action
 * @property string|null $description
 * @property array<string, mixed>|null $properties
 * @property string|null $ip_address
 * @property Carbon|null $created_at
 * @property-read Account|null $account
 * @property-read Student|null $student
 */
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

    /**
     * @return BelongsTo<Account, $this>
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'id_account');
    }

    /**
     * @return BelongsTo<Student, $this>
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'id_siswa');
    }
}
