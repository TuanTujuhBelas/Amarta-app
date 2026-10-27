<?php

namespace App\Livewire;

use App\Models\Account;
use App\Models\Ranting;
use App\Services\ActivityLogger;
use App\Services\PositionIdService;
use App\Services\R2StorageService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithFileUploads;

class CoachRegistration extends Component
{
    use WithFileUploads;

    public string $nama = '';

    public string $username = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public ?int $id_ranting = null;

    public string $alamat = '';

    /** @var mixed */
    public $photo;

    public bool $isSuccess = false;

    public string $registeredIdPosition = '';

    public string $registeredName = '';

    /**
     * @return array<string, string>
     */
    protected function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'username' => 'required|string|min:4|max:100|alpha_dash|unique:m_account,username',
            'email' => 'required|email|max:255|unique:m_account,email',
            'password' => 'required|string|min:6|confirmed',
            'id_ranting' => 'required|integer|exists:m_ranting,id_ranting',
            'alamat' => 'required|string|max:1000',
            'photo' => 'nullable|image|max:5120',
        ];
    }

    public function submit(PositionIdService $positionIdService): void
    {
        $this->validate();

        DB::transaction(function () use ($positionIdService) {
            $idPosition = $positionIdService->generateCoachId();

            $photoPath = null;
            if ($this->photo) {
                $photoPath = R2StorageService::uploadCompressed($this->photo, 'coaches/profiles');
            }

            $ranting = Ranting::find($this->id_ranting);
            $namaRanting = $ranting ? $ranting->nm_ranting : '';

            // Simpan HANYA ke m_account (Pelatih TIDAK masuk ke m_siswa)
            $account = Account::create([
                'id_ranting' => $this->id_ranting,
                'nama' => $this->nama,
                'username' => $this->username,
                'password' => md5($this->password),
                'level' => 'PLT',
                'status' => 'active',
                'id_position' => $idPosition,
                'is_first_login' => true,
                'photo' => $photoPath,
                'alamat' => $this->alamat,
                'email' => $this->email,
                'nama_ranting' => $namaRanting,
            ]);

            ActivityLogger::log(
                $account->id,
                'REGISTER',
                "Pendaftaran akun pelatih baru {$this->nama} (ID: {$idPosition})",
                null,
                ['id_position' => $idPosition, 'role' => 'pelatih', 'ranting' => $namaRanting]
            );

            $this->registeredIdPosition = $idPosition;
            $this->registeredName = $this->nama;
            $this->isSuccess = true;
        });
    }

    public function render(): View
    {
        $rantings = Schema::hasTable('m_ranting')
            ? Ranting::orderBy('nm_ranting')->get()
            : collect();

        return view('livewire.coach-registration', [
            'rantings' => $rantings,
        ])->layout('layouts.auth.simple', ['title' => 'Registrasi Pelatih - Garuda Amarta']);
    }
}
