<?php

namespace App\Services;

use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PositionIdService
{
    /**
     * Belt codes mapping as defined in PRD.
     */
    protected const BELT_CODES = [
        'Putih 001'   => '001',
        'Kuning 002'  => '002',
        'Merah 003'   => '003',
        'Biru 005'    => '005',
        'Cokelat 006' => '006',
        'Hitam 007'   => '007',
    ];

    /**
     * Generate automatic atomic ID Position for athletes.
     * Format: PLT.[Tahun]-[TglBln]-[KodeSabuk][Urut] (Contoh: PLT.2026-2610-001005)
     */
    public function generate(string $beltName, ?Carbon $date = null): string
    {
        $date = $date ?? Carbon::now();
        $year = $date->format('Y');
        $dayMonth = $date->format('dm');
        $beltCode = self::BELT_CODES[$beltName] ?? '001';

        $prefix = "PLT.{$year}-{$dayMonth}-{$beltCode}";

        return DB::transaction(function () use ($prefix) {
            // Find highest existing sequence for this prefix with lock
            $latestAccount = Account::where('id_position', 'LIKE', "{$prefix}%")
                ->orderBy('id_position', 'desc')
                ->lockForUpdate()
                ->first();

            $sequence = 1;
            if ($latestAccount && !empty($latestAccount->id_position)) {
                $lastThreeDigits = substr($latestAccount->id_position, -3);
                if (is_numeric($lastThreeDigits)) {
                    $sequence = ((int) $lastThreeDigits) + 1;
                }
            }

            $sequencePadded = str_pad((string) $sequence, 3, '0', STR_PAD_LEFT);

            return "{$prefix}{$sequencePadded}";
        });
    }
}
