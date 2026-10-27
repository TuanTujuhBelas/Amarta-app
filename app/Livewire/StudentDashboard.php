<?php

namespace App\Livewire;

use App\Models\RevisionRequest;
use App\Models\Student;
use App\Services\ActivityLogger;
use App\Services\R2StorageService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class StudentDashboard extends Component
{
    use WithFileUploads;

    public ?Student $student = null;

    public ?RevisionRequest $activeRevision = null;

    // File Uploads for Revision
    public $new_photo;

    public $new_photo_kk;

    public $new_photo_akte_kia;

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

        DB::transaction(function () {
            $updates = [];

            // Foto Profil
            if ($this->new_photo) {
                R2StorageService::delete($this->student->photo);
                $updates['photo'] = R2StorageService::uploadCompressed($this->new_photo, 'athletes/profiles');
                $this->student->account->update(['photo' => $updates['photo']]);
            }

            // Foto KK
            if ($this->new_photo_kk) {
                R2StorageService::delete($this->student->photo_kk);
                $updates['photo_kk'] = R2StorageService::uploadCompressed($this->new_photo_kk, 'athletes/kk');
            }

            // Foto Akte / KIA
            if ($this->new_photo_akte_kia) {
                R2StorageService::delete($this->student->photo_akte_kia);
                $updates['photo_akte_kia'] = R2StorageService::uploadCompressed($this->new_photo_akte_kia, 'athletes/akte');
            }

            // Foto Surat Sehat
            if ($this->new_photo_surat_sehat) {
                R2StorageService::delete($this->student->photo_surat_sehat);
                $updates['photo_surat_sehat'] = R2StorageService::uploadCompressed($this->new_photo_surat_sehat, 'athletes/surat_sehat');
            }

            $updates['status_verifikasi'] = 'pending';
            $this->student->update($updates);

            // Tandai revisi request sebagai resolved
            $this->activeRevision->update(['status' => 'resolved']);

            // Audit Log
            ActivityLogger::log(
                Auth::id(),
                'SUBMIT_REVISION',
                "Siswa mengunggah ulang dokumen revisi ({$this->student->nama_lengkap})",
                $this->student->id,
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
    public function downloadPdf()
    {
        if (! $this->student) {
            return;
        }

        $pdf = Pdf::loadView('pdf.student-card', ['student' => $this->student])
            ->setPaper('a4', 'portrait');

        $filename = 'Kartu_Atlet_'.str_replace(['.', '-', ' '], '_', $this->student->account->id_position).'.pdf';

        return response()->streamDownload(fn () => print ($pdf->output()), $filename);
    }

    public function render()
    {
        return view('livewire.student-dashboard')
            ->layout('layouts.app', ['title' => 'Dashboard Atlet - Garuda Amarta']);
    }
}
