<?php

namespace App\Livewire;

use App\Models\Account;
use App\Services\ActivityLogger;
use App\Services\PositionIdService;
use App\Services\R2StorageService;
use Illuminate\Support\Facades\DB;
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
    public string $nama_ranting = '';
    public string $alamat = '';
    public $photo;

    public bool $isSuccess = false;
    public string $registeredIdPosition = '';
    public string $registeredName = '';

    protected function rules(): array
    {
        return [
            'nama'         => 'required|string|max:255',
            'username'     => 'required|string|min:4|max:100|alpha_dash|unique:m_account,username',
            'email'        => 'required|email|max:255|unique:m_account,email',
            'password'     => 'required|string|min:6|confirmed',
            'nama_ranting' => 'required|string|max:255',
            'alamat'       => 'required|string|max:1000',
            'photo'        => 'nullable|image|max:5120',
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

            // Simpan HANYA ke m_account (Pelatih TIDAK masuk ke m_siswa)
            $account = Account::create([
                'nama'         => $this->nama,
                'username'     => $this->username,
                'password'     => md5($this->password),
                'status'       => 'active',
                'id_position'  => $idPosition,
                'photo'        => $photoPath,
                'alamat'       => $this->alamat,
                'email'        => $this->email,
                'nama_ranting' => $this->nama_ranting,
            ]);

            ActivityLogger::log(
                $account->id,
                'REGISTER',
                "Pendaftaran akun pelatih baru {$this->nama} (ID: {$idPosition})",
                null,
                ['id_position' => $idPosition, 'role' => 'pelatih', 'ranting' => $this->nama_ranting]
            );

            $this->registeredIdPosition = $idPosition;
            $this->registeredName       = $this->nama;
            $this->isSuccess            = true;
        });
    }

    public function render()
    {
        return view('livewire.coach-registration')
            ->layout('layouts.auth.simple', ['title' => 'Registrasi Pelatih - Garuda Amarta']);
    }
}
