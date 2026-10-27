<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $table = 'm_siswa';

    protected $fillable = [
        'id_account',
        'nama_lengkap',
        'tanggal_lahir',
        'no_ortu',
        'nama_ortu',
        'nik_kia',
        'no_kk',
        'tingkat_sabuk',
        'gender',
        'tingkat',
        'kategori',
        'kelas',
        'nama_sekolah',
        'berat_badan',
        'tinggi_badan',
        'photo',
        'photo_kk',
        'photo_akte_kia',
        'photo_surat_sehat',
        'status_verifikasi',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'berat_badan' => 'decimal:2',
        'tinggi_badan' => 'decimal:2',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'id_account');
    }

    public function revisionRequests(): HasMany
    {
        return $this->hasMany(RevisionRequest::class, 'id_siswa');
    }
}
