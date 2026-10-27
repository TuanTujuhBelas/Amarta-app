<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

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

    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'id_account');
    }

    public function revisionRequests()
    {
        return $this->hasMany(RevisionRequest::class, 'id_pelatih');
    }

    public function activityLogs()
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
