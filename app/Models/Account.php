<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
}
