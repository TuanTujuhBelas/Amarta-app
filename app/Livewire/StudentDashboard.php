<?php

namespace App\Livewire;

use App\Models\RevisionRequest;
use App\Models\Student;
use App\Services\ActivityLogger;
use App\Services\R2StorageService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\Response;

class StudentDashboard extends Component
{
    use WithFileUploads;

    public ?Student $student = null;

    public ?RevisionRequest $activeRevision = null;

    // File Uploads for Revision
    /** @var mixed */
    public $new_photo;

    /** @var mixed */
    public $new_photo_kk;

    /** @var mixed */
    public $new_photo_akte_kia;

    /** @var mixed */
    public $new_photo_surat_sehat;

    public string $successMessage = '';

    public function mount(): void
    {
        $this->loadStudentData();
    }

    public function loadStudentData(): void
    {
        $this->student = Student::with('account')
            ->where('id_account', Auth::id())
            ->first();

        if ($this->student && $this->student->status_verifikasi === 'need_revision') {
            $this->activeRevision = RevisionRequest::where('id_siswa', $this->student->id)
                ->where('status', 'pending')
                ->latest()
                ->first();
        } else {
            $this->activeRevision = null;
        }
    }

    /**
     * Submit perbaikan berkas yang diminta revisi oleh pelatih.
     */
    public function submitRevision(): void
    {
        if (! $this->student || ! $this->activeRevision) {
            return;
        }

        $requestedItems = $this->activeRevision->requested_items ?? [];
        $rules = [];

        if (in_array('photo', $requestedItems)) {
            $rules['new_photo'] = 'required|image|max:5120';
        }
        if (in_array('photo_kk', $requestedItems)) {
            $rules['new_photo_kk'] = 'required|image|max:5120';
        }
        if (in_array('photo_akte_kia', $requestedItems)) {
            $rules['new_photo_akte_kia'] = 'required|image|max:5120';
        }
        if (in_array('photo_surat_sehat', $requestedItems)) {
            $rules['new_photo_surat_sehat'] = 'required|image|max:5120';
        }

        $this->validate($rules);

        $student = $this->student;
        $activeRevision = $this->activeRevision;

        DB::transaction(function () use ($student, $activeRevision) {
            $updates = [];

            // Foto Profil
            if ($this->new_photo) {
                R2StorageService::delete($student->photo);
                $updates['photo'] = R2StorageService::uploadCompressed($this->new_photo, 'athletes/profiles');
                $student->account?->update(['photo' => $updates['photo']]);
            }

            // Foto KK
            if ($this->new_photo_kk) {
                R2StorageService::delete($student->photo_kk);
                $updates['photo_kk'] = R2StorageService::uploadCompressed($this->new_photo_kk, 'athletes/kk');
            }

            // Foto Akte / KIA
            if ($this->new_photo_akte_kia) {
                R2StorageService::delete($student->photo_akte_kia);
                $updates['photo_akte_kia'] = R2StorageService::uploadCompressed($this->new_photo_akte_kia, 'athletes/akte');
            }

            // Foto Surat Sehat
            if ($this->new_photo_surat_sehat) {
                R2StorageService::delete($student->photo_surat_sehat);
                $updates['photo_surat_sehat'] = R2StorageService::uploadCompressed($this->new_photo_surat_sehat, 'athletes/surat_sehat');
            }

            $updates['status_verifikasi'] = 'pending';
            $student->update($updates);

            // Tandai revisi request sebagai resolved
            $activeRevision->update(['status' => 'resolved']);

            // Audit Log
            ActivityLogger::log(
                Auth::id(),
                'SUBMIT_REVISION',
                "Siswa mengunggah ulang dokumen revisi ({$student->nama_lengkap})",
                $student->id,
                ['updated_items' => array_keys($updates)]
            );
        });

        $this->reset(['new_photo', 'new_photo_kk', 'new_photo_akte_kia', 'new_photo_surat_sehat']);
        $this->loadStudentData();
        $this->successMessage = 'Berkas revisi berhasil diunggah! Status Anda kembali ke Pending untuk ditinjau ulang oleh pelatih.';
    }

    /**
     * Unduh PDF data diri resmi atlet.
     */
    public function downloadPdf(): ?Response
    {
        if (! $this->student) {
            return null;
        }

        $pdf = Pdf::loadView('pdf.student-card', ['student' => $this->student])
            ->setPaper('a4', 'portrait');

        $idPosition = $this->student->account->id_position ?? (string) $this->student->id;
        $filename = 'Kartu_Atlet_'.str_replace(['.', '-', ' '], '_', $idPosition).'.pdf';

        return response()->streamDownload(fn () => print ($pdf->output()), $filename);
    }

    public function render(): View
    {
        return view('livewire.student-dashboard')
            ->layout('layouts.app', ['title' => 'Dashboard Atlet - Garuda Amarta']);
    }
}
