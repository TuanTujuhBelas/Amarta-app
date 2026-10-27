<?php

namespace App\Livewire;

use App\Models\Account;
use App\Models\Student;
use App\Services\ActivityLogger;
use App\Services\PositionIdService;
use App\Services\R2StorageService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class AthleteRegistration extends Component
{
    use WithFileUploads;

    public int $currentStep = 1;
    public int $totalSteps = 4;

    // Step 1: Akun & Identitas Utama
    public string $nama = '';
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $alamat = '';
    public string $nama_ranting = '';

    // Step 2: Tingkat & Kategori Atlet
    public string $tingkat_sabuk = 'Putih 001';
    public string $gender = 'male';
    public string $tingkat = 'SD';
    public string $kategori = 'UD1';
    public string $kelas = 'Tanding';
    public string $nama_sekolah = '';

    // Step 3: Fisik & Orang Tua
    public string $nama_lengkap = '';
    public string $tanggal_lahir = '';
    public ?string $berat_badan = null;
    public ?string $tinggi_badan = null;
    public string $nama_ortu = '';
    public string $no_ortu = '';
    public string $nik_kia = '';
    public string $no_kk = '';

    // Step 4: Upload Dokumen R2
    public $photo;
    public $photo_kk;
    public $photo_akte_kia;
    public $photo_surat_sehat;

    // State Sukses
    public bool $isSuccess = false;
    public string $registeredIdPosition = '';
    public string $registeredName = '';

    /**
     * Auto-mapping kategori saat tingkat sekolah berubah (Sesuai Aturan PRD Bagian 5).
     */
    public function updatedTingkat(string $value): void
    {
        match ($value) {
            'TK'          => $this->kategori = 'Pra-UD',
            'SMP'         => $this->kategori = 'Pra Remaja',
            'SMA'         => $this->kategori = 'Remaja',
            'Universitas' => $this->kategori = 'Dewasa',
            'SD'          => $this->kategori = 'UD1',
            default       => $this->kategori = 'Pra-UD',
        };
    }

    /**
     * Navigasi ke langkah berikutnya setelah validasi.
     */
    public function nextStep(): void
    {
        $this->validateCurrentStep();
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    /**
     * Kembali ke langkah sebelumnya.
     */
    public function prevStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    /**
     * Validasi berdasarkan langkah aktif.
     */
    protected function validateCurrentStep(): void
    {
        if ($this->currentStep === 1) {
            $this->validate([
                'nama'         => 'required|string|max:255',
                'username'     => 'required|string|min:4|max:100|alpha_dash|unique:m_account,username',
                'email'        => 'required|email|max:255|unique:m_account,email',
                'password'     => 'required|string|min:6|confirmed',
                'alamat'       => 'required|string|max:1000',
                'nama_ranting' => 'required|string|max:255',
            ]);
        } elseif ($this->currentStep === 2) {
            $this->validate([
                'tingkat_sabuk' => 'required|in:Putih 001,Kuning 002,Merah 003,Biru 005,Cokelat 006,Hitam 007',
                'gender'        => 'required|in:male,female',
                'tingkat'       => 'required|in:TK,SD,SMP,SMA,Universitas',
                'kategori'      => 'required|in:Pra-UD,UD1,UD2,Pra Remaja,Remaja,Dewasa',
                'kelas'         => 'required|in:Tunggal,Regu,Ganda,Tanding',
                'nama_sekolah'  => 'required|string|max:255',
            ]);
        } elseif ($this->currentStep === 3) {
            $this->validate([
                'nama_lengkap'  => 'required|string|max:255',
                'tanggal_lahir' => 'required|date',
                'berat_badan'   => 'required|numeric|min:15|max:200',
                'tinggi_badan'  => 'required|numeric|min:50|max:250',
                'nama_ortu'     => 'required|string|max:255',
                'no_ortu'       => 'required|string|min:9|max:20',
                'nik_kia'       => 'required|digits:16',
                'no_kk'         => 'required|digits:16',
            ]);
        }
    }

    /**
     * Submit formulir lengkap (Fase 2 & 3 PRD).
     */
    public function submit(PositionIdService $positionIdService): void
    {
        // Validasi Step 4 (Berkas)
        $this->validate([
            'photo'              => 'required|image|max:5120',
            'photo_kk'           => 'required|image|max:5120',
            'photo_akte_kia'     => 'required|image|max:5120',
            'photo_surat_sehat'  => 'required|image|max:5120',
        ]);

        DB::transaction(function () use ($positionIdService) {
            // 1. Generate ID Position unik (Contoh: PLT.2026-2610-001005)
            $idPosition = $positionIdService->generate($this->tingkat_sabuk);

            // 2. Upload & kompres dokumen ke R2/Storage
            $photoPath       = R2StorageService::uploadCompressed($this->photo, 'athletes/profiles');
            $kkPath          = R2StorageService::uploadCompressed($this->photo_kk, 'athletes/kk');
            $aktePath        = R2StorageService::uploadCompressed($this->photo_akte_kia, 'athletes/akte');
            $sehatPath       = R2StorageService::uploadCompressed($this->photo_surat_sehat, 'athletes/surat_sehat');

            // 3. Simpan Akun (m_account) dengan MD5 password sesuai PRD
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

            // 4. Simpan Data Atlet (m_siswa)
            $student = Student::create([
                'id_account'         => $account->id,
                'nama_lengkap'       => $this->nama_lengkap,
                'tanggal_lahir'      => $this->tanggal_lahir,
                'no_ortu'            => $this->no_ortu,
                'nama_ortu'          => $this->nama_ortu,
                'nik_kia'            => $this->nik_kia,
                'no_kk'              => $this->no_kk,
                'tingkat_sabuk'      => $this->tingkat_sabuk,
                'gender'             => $this->gender,
                'tingkat'            => $this->tingkat,
                'kategori'           => $this->kategori,
                'kelas'              => $this->kelas,
                'nama_sekolah'       => $this->nama_sekolah,
                'berat_badan'        => $this->berat_badan,
                'tinggi_badan'       => $this->tinggi_badan,
                'photo'              => $photoPath,
                'photo_kk'           => $kkPath,
                'photo_akte_kia'     => $aktePath,
                'photo_surat_sehat'  => $sehatPath,
                'status_verifikasi'  => 'pending',
            ]);

            // 5. Catat Audit Log (t_activity_log)
            ActivityLogger::log(
                $account->id,
                'REGISTER',
                "Pendaftaran atlet baru {$this->nama_lengkap} (ID: {$idPosition})",
                $student->id,
                ['id_position' => $idPosition, 'ranting' => $this->nama_ranting]
            );

            $this->registeredIdPosition = $idPosition;
            $this->registeredName       = $this->nama_lengkap;
            $this->isSuccess            = true;
        });
    }

    public function render()
    {
        return view('livewire.athlete-registration')
            ->layout('layouts.auth.simple', ['title' => 'Registrasi Atlet - Garuda Amarta']);
    }
}
