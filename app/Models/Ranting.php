<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id_ranting
 * @property string $nm_ranting
 * @property string|null $alamat
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Account> $accounts
 */
class Ranting extends Model
{
    protected $table = 'm_ranting';

    protected $primaryKey = 'id_ranting';

    protected $fillable = [
        'nm_ranting',
        'alamat',
    ];

    /**
     * @return HasMany<Account, $this>
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class, 'id_ranting', 'id_ranting');
    }
}
