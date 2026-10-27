<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string|null $nama
 * @property string $username
 * @property string $password
 * @property string $status
 * @property string|null $id_position
 * @property string|null $photo
 * @property string|null $alamat
 * @property string|null $email
 * @property string|null $nama_ranting
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $name
 * @property-read Student|null $student
 * @property-read Collection<int, RevisionRequest> $revisionRequests
 * @property-read Collection<int, ActivityLog> $activityLogs
 */
class Account extends Authenticatable
{
    use Notifiable;

    protected $table = 'm_account';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'username',
        'password',
        'status',
        'id_position',
        'photo',
        'alamat',
        'email',
        'nama_ranting',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * @return HasOne<Student, $this>
     */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'id_account');
    }

    /**
     * @return HasMany<RevisionRequest, $this>
     */
    public function revisionRequests(): HasMany
    {
        return $this->hasMany(RevisionRequest::class, 'id_pelatih');
    }

    /**
     * @return HasMany<ActivityLog, $this>
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'id_account');
    }

    /**
     * Check if account belongs to a student (exists in m_siswa).
     */
    public function isStudent(): bool
    {
        return $this->student()->exists();
    }

    /**
     * Check if account is a coach (does not exist in m_siswa).
     */
    public function isCoach(): bool
    {
        return ! $this->isStudent();
    }

    /**
     * Accessor for 'name' attribute used by Flux UI components.
     */
    public function getNameAttribute(): string
    {
        return $this->nama ?? $this->username ?? '';
    }

    /**
     * Get the user's initials for avatar display in Flux UI.
     */
    public function initials(): string
    {
        $name = $this->nama ?? $this->username ?? 'GA';
        $initials = Str::initials($name, true);

        return Str::length($initials) > 1
            ? Str::substr($initials, 0, 1).Str::substr($initials, -1)
            : $initials;
    }
}
