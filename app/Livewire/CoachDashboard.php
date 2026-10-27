<?php

namespace App\Livewire;

use App\Models\Account;
use App\Models\RevisionRequest;
use App\Models\Student;
use App\Services\ActivityLogger;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\Response;

class CoachDashboard extends Component
{
    use WithPagination;

    // Filter & Search
    public string $search = '';

    public string $filterRanting = '';

    public string $filterKategori = '';

    public string $filterStatus = '';

    public string $filterKelas = '';

    // Modal States
    public bool $showDetailModal = false;

    public bool $showRevisionModal = false;

    public ?Student $selectedStudent = null;

    // Revision Form
    /** @var array<int, string> */
    public array $requestedItems = [];

    public string $revisionNotes = '';

    // Notification
    public string $alertMessage = '';

    public string $alertType = 'success';

    /** @var array<string, mixed> */
    protected $queryString = [
        'search' => ['except' => ''],
        'filterRanting' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterKategori' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterRanting(): void
    {
        $this->resetPage();
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    /**
     * Buka modal detail atlet untuk memeriksa berkas.
     */
    public function openDetail(int $studentId): void
    {
        $this->selectedStudent = Student::with(['account', 'revisionRequests'])->findOrFail($studentId);
        $this->showDetailModal = true;
    }

    public function closeDetail(): void
    {
        $this->showDetailModal = false;
        $this->selectedStudent = null;
    }

    /**
     * Buka modal permintaan revisi dokumen.
     */
    public function openRevision(int $studentId): void
    {
        $this->selectedStudent = Student::with('account')->findOrFail($studentId);
        $this->requestedItems = [];
        $this->revisionNotes = '';
        $this->showRevisionModal = true;
    }

    public function closeRevision(): void
    {
        $this->showRevisionModal = false;
        $this->requestedItems = [];
        $this->revisionNotes = '';
    }

    /**
     * Setujui / Verifikasi atlet (Status -> approved).
     */
    public function approve(int $studentId): void
    {
        $student = Student::with('account')->findOrFail($studentId);
        $student->update(['status_verifikasi' => 'approved']);

        // Tandai revisi sebelumnya (jika ada) sebagai resolved
        RevisionRequest::where('id_siswa', $student->id)
            ->where('status', 'pending')
            ->update(['status' => 'resolved']);

        $idPosition = $student->account->id_position ?? '-';

        ActivityLogger::log(
            Auth::id(),
            'UPDATE_MANUAL',
            "Pelatih menyetujui verifikasi data atlet {$student->nama_lengkap} ({$idPosition})",
            $student->id,
            ['status_verifikasi' => 'approved']
        );

        $this->alertMessage = "Atlet {$student->nama_lengkap} berhasil diverifikasi & disetujui.";
        $this->alertType = 'success';

        if ($this->showDetailModal && $this->selectedStudent) {
            $this->selectedStudent->refresh();
        }
    }

    /**
     * Kirim instruksi revisi dokumen ke atlet (Status -> need_revision).
     */
    public function submitRevision(): void
    {
        $this->validate([
            'requestedItems' => 'required|array|min:1',
            'revisionNotes' => 'required|string|max:1000',
        ], [
            'requestedItems.required' => 'Pilih minimal satu item dokumen yang harus direvisi.',
            'requestedItems.min' => 'Pilih minimal satu item dokumen yang harus direvisi.',
            'revisionNotes.required' => 'Catatan instruksi revisi wajib diisi untuk atlet.',
        ]);

        if (! $this->selectedStudent) {
            return;
        }

        // 1. Simpan ke t_revisi_request
        RevisionRequest::create([
            'id_siswa' => $this->selectedStudent->id,
            'id_pelatih' => (int) Auth::id(),
            'requested_items' => $this->requestedItems,
            'catatan' => $this->revisionNotes,
            'status' => 'pending',
        ]);

        // 2. Ubah status siswa ke need_revision
        $this->selectedStudent->update([
            'status_verifikasi' => 'need_revision',
        ]);

        // 3. Catat di t_activity_log
        ActivityLogger::log(
            Auth::id(),
            'REQUEST_REVISION',
            "Pelatih meminta revisi dokumen untuk atlet {$this->selectedStudent->nama_lengkap}",
            $this->selectedStudent->id,
            [
                'items' => $this->requestedItems,
                'catatan' => $this->revisionNotes,
            ]
        );

        $this->alertMessage = "Instruksi revisi berhasil dikirim ke atlet {$this->selectedStudent->nama_lengkap}.";
        $this->alertType = 'warning';

        $this->closeRevision();
        if ($this->showDetailModal) {
            $this->closeDetail();
        }
    }

    /**
     * Unduh PDF biodata resmi atlet berlogo Garuda Amarta.
     */
    public function exportPdf(int $studentId): Response
    {
        $student = Student::with('account')->findOrFail($studentId);
        $idPosition = $student->account->id_position ?? (string) $student->id;

        ActivityLogger::log(
            Auth::id(),
            'EXPORT_DATA',
            "Pelatih mengunduh PDF biodata atlet {$student->nama_lengkap} ({$idPosition})",
            $student->id
        );

        $pdf = Pdf::loadView('pdf.student-card', compact('student'))
            ->setPaper('a4', 'portrait');

        $filename = 'Data_Atlet_'.str_replace(['.', '-', ' '], '_', $idPosition).'.pdf';

        return response()->streamDownload(fn () => print ($pdf->output()), $filename);
    }

    public function render(): View
    {
        // Query Siswa dengan Filter
        $query = Student::with('account');

        if (! empty($this->search)) {
            $search = '%'.$this->search.'%';
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', $search)
                    ->orWhere('nama_sekolah', 'LIKE', $search)
                    ->orWhereHas('account', function ($sub) use ($search) {
                        $sub->where('id_position', 'LIKE', $search)
                            ->orWhere('username', 'LIKE', $search)
                            ->orWhere('nama_ranting', 'LIKE', $search);
                    });
            });
        }

        if (! empty($this->filterRanting)) {
            $query->whereHas('account', fn ($q) => $q->where('nama_ranting', $this->filterRanting));
        }

        if (! empty($this->filterStatus)) {
            $query->where('status_verifikasi', $this->filterStatus);
        }

        if (! empty($this->filterKategori)) {
            $query->where('kategori', $this->filterKategori);
        }

        if (! empty($this->filterKelas)) {
            $query->where('kelas', $this->filterKelas);
        }

        $students = $query->latest()->paginate(10);

        // Ringkasan Statistik
        $metrics = [
            'total' => Student::count(),
            'pending' => Student::where('status_verifikasi', 'pending')->count(),
            'approved' => Student::where('status_verifikasi', 'approved')->count(),
            'need_revision' => Student::where('status_verifikasi', 'need_revision')->count(),
        ];

        // Daftar Ranting Unik untuk Dropdown Filter
        $rantingOptions = Account::whereNotNull('nama_ranting')
            ->where('nama_ranting', '!=', '')
            ->distinct()
            ->pluck('nama_ranting');

        return view('livewire.coach-dashboard', [
            'students' => $students,
            'metrics' => $metrics,
            'rantingOptions' => $rantingOptions,
        ])->layout('layouts.app', ['title' => 'Dashboard Pelatih - Garuda Amarta']);
    }
}
