<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $id_account
 * @property string $nama_lengkap
 * @property Carbon|null $tanggal_lahir
 * @property string $no_ortu
 * @property string $nama_ortu
 * @property string $nik_kia
 * @property string $no_kk
 * @property string $tingkat_sabuk
 * @property string $gender
 * @property string $tingkat
 * @property string $kategori
 * @property string|null $kelas
 * @property string $nama_sekolah
 * @property string|null $berat_badan
 * @property string|null $tinggi_badan
 * @property string|null $photo
 * @property string|null $photo_kk
 * @property string|null $photo_akte_kia
 * @property string|null $photo_surat_sehat
 * @property string $status_verifikasi
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $nama_sabuk
 * @property-read Account|null $account
 * @property-read Collection<int, RevisionRequest> $revisionRequests
 */
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

    /**
     * Get belt name without code (e.g. 'Merah' instead of 'Merah 003').
     */
    public function getNamaSabukAttribute(): string
    {
        return trim((string) preg_replace('/\s*\d+$/', '', (string) $this->tingkat_sabuk));
    }

    /**
     * @return BelongsTo<Account, $this>
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'id_account');
    }

    /**
     * @return HasMany<RevisionRequest, $this>
     */
    public function revisionRequests(): HasMany
    {
        return $this->hasMany(RevisionRequest::class, 'id_siswa');
    }
}
