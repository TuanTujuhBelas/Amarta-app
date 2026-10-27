<?php

namespace App\Livewire;

use App\Models\Account;
use App\Models\ActivityLog;
use App\Models\Ranting;
use App\Models\Student;
use App\Services\ActivityLogger;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class SuperAdminDashboard extends Component
{
    use WithPagination;

    public string $activeTab = 'ranting'; // ranting, transfer, reset-password, logs

    // Alert feedback
    public string $alertMessage = '';

    public string $alertType = 'success';

    // Ranting CRUD
    public string $nm_ranting = '';

    public string $alamat_ranting = '';

    public ?int $editingRantingId = null;

    public bool $showRantingModal = false;

    // Member Transfer
    public ?int $transferAccountId = null;

    public ?int $targetRantingId = null;

    public string $searchTransfer = '';

    // Password Reset
    public ?int $resetAccountId = null;

    public string $newPassword = '';

    public string $searchReset = '';

    // Log Filter
    public string $logSearch = '';

    /** @var array<string, mixed> */
    protected $queryString = [
        'activeTab' => ['except' => 'ranting'],
    ];

    public function mount(): void
    {
        $user = Auth::user();
        if (! ($user instanceof Account) || ! $user->isSuperAdmin()) {
            abort(403, 'Akses terbatas hanya untuk Super Admin (su).');
        }

        if (request()->routeIs('superadmin.transfer')) {
            $this->activeTab = 'transfer';
        } elseif (request()->routeIs('superadmin.reset_password')) {
            $this->activeTab = 'reset-password';
        } elseif (request()->routeIs('superadmin.logs')) {
            $this->activeTab = 'logs';
        } elseif (request()->routeIs('superadmin.ranting')) {
            $this->activeTab = 'ranting';
        }
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->alertMessage = '';
        $this->resetPage();
    }

    // ==================== MASTER RANTING ====================
    public function openCreateRanting(): void
    {
        $this->reset(['nm_ranting', 'alamat_ranting', 'editingRantingId']);
        $this->showRantingModal = true;
    }

    public function editRanting(int $id): void
    {
        $ranting = Ranting::findOrFail($id);
        $this->editingRantingId = $ranting->id_ranting;
        $this->nm_ranting = $ranting->nm_ranting;
        $this->alamat_ranting = $ranting->alamat ?? '';
        $this->showRantingModal = true;
    }

    public function saveRanting(): void
    {
        $this->validate([
            'nm_ranting' => 'required|string|max:255',
            'alamat_ranting' => 'nullable|string|max:1000',
        ]);

        if ($this->editingRantingId) {
            $ranting = Ranting::findOrFail($this->editingRantingId);
            $oldName = $ranting->nm_ranting;
            $ranting->update([
                'nm_ranting' => $this->nm_ranting,
                'alamat' => $this->alamat_ranting,
            ]);

            // Sync account nama_ranting for existing accounts in this ranting
            Account::where('id_ranting', $ranting->id_ranting)->update([
                'nama_ranting' => $this->nm_ranting,
            ]);

            ActivityLogger::log(
                Auth::id(),
                'UPDATE_RANTING',
                "Mengubah master ranting {$oldName} menjadi {$this->nm_ranting}",
                null,
                ['id_ranting' => $ranting->id_ranting, 'nm_ranting' => $this->nm_ranting]
            );

            $this->alertMessage = "Ranting {$this->nm_ranting} berhasil diperbarui.";
        } else {
            $ranting = Ranting::create([
                'nm_ranting' => $this->nm_ranting,
                'alamat' => $this->alamat_ranting,
            ]);

            ActivityLogger::log(
                Auth::id(),
                'CREATE_RANTING',
                "Menambahkan ranting baru {$this->nm_ranting}",
                null,
                ['id_ranting' => $ranting->id_ranting, 'nm_ranting' => $this->nm_ranting]
            );

            $this->alertMessage = "Ranting {$this->nm_ranting} berhasil dibuat.";
        }

        $this->showRantingModal = false;
        $this->reset(['nm_ranting', 'alamat_ranting', 'editingRantingId']);
        $this->alertType = 'success';
    }

    public function deleteRanting(int $id): void
    {
        $ranting = Ranting::withCount('accounts')->findOrFail($id);
        if ($ranting->accounts_count > 0) {
            $this->alertMessage = "Ranting '{$ranting->nm_ranting}' tidak dapat dihapus karena masih memiliki {$ranting->accounts_count} anggota aktif. Pindahkan anggota terlebih dahulu.";
            $this->alertType = 'error';

            return;
        }

        $nama = $ranting->nm_ranting;
        $ranting->delete();

        ActivityLogger::log(
            Auth::id(),
            'DELETE_RANTING',
            "Menghapus master ranting {$nama}",
            null,
            ['id_ranting' => $id, 'nm_ranting' => $nama]
        );

        $this->alertMessage = "Ranting '{$nama}' berhasil dihapus.";
        $this->alertType = 'success';
    }

    // ==================== TRANSFER ANGGOTA ====================
    public function transferMember(): void
    {
        $this->validate([
            'transferAccountId' => 'required|exists:m_account,id',
            'targetRantingId' => 'required|exists:m_ranting,id_ranting',
        ]);

        $account = Account::findOrFail($this->transferAccountId);
        $targetRanting = Ranting::findOrFail($this->targetRantingId);

        $oldRantingName = $account->nama_ranting ?? 'Tanpa Ranting';

        $account->update([
            'id_ranting' => $targetRanting->id_ranting,
            'nama_ranting' => $targetRanting->nm_ranting,
        ]);

        ActivityLogger::log(
            Auth::id(),
            'TRANSFER_MEMBER',
            "Memindahkan {$account->nama} ({$account->id_position}) dari {$oldRantingName} ke {$targetRanting->nm_ranting}",
            null,
            [
                'id_account' => $account->id,
                'target_id_ranting' => $targetRanting->id_ranting,
                'target_ranting' => $targetRanting->nm_ranting,
            ]
        );

        $this->alertMessage = "Anggota {$account->nama} berhasil dipindahkan ke ranting {$targetRanting->nm_ranting}.";
        $this->alertType = 'success';
        $this->reset(['transferAccountId', 'targetRantingId', 'searchTransfer']);
    }

    // ==================== RESET PASSWORD ====================
    public function executeResetPassword(): void
    {
        $this->validate([
            'resetAccountId' => 'required|exists:m_account,id',
            'newPassword' => 'required|string|min:6',
        ]);

        $account = Account::findOrFail($this->resetAccountId);
        $account->update([
            'password' => md5($this->newPassword),
            'is_first_login' => true, // Paksa ganti password pada login berikutnya
        ]);

        ActivityLogger::log(
            Auth::id(),
            'RESET_PASSWORD',
            "Super Admin me-reset kata sandi untuk {$account->nama} ({$account->username})",
            null,
            ['id_account' => $account->id, 'username' => $account->username]
        );

        $this->alertMessage = "Password akun {$account->nama} ({$account->username}) berhasil di-reset. Akun diwajibkan ganti password saat login.";
        $this->alertType = 'success';
        $this->reset(['resetAccountId', 'newPassword', 'searchReset']);
    }

    public function render(): View
    {
        // Data Ranting
        $rantings = Ranting::withCount('accounts')->orderBy('nm_ranting')->get();

        // Data Transfer Options
        $transferAccounts = [];
        if (! empty($this->searchTransfer)) {
            $search = '%'.$this->searchTransfer.'%';
            $transferAccounts = Account::where('level', '!=', 'su')
                ->where(function ($q) use ($search) {
                    $q->where('nama', 'LIKE', $search)
                        ->orWhere('username', 'LIKE', $search)
                        ->orWhere('id_position', 'LIKE', $search);
                })
                ->with('ranting')
                ->limit(10)
                ->get();
        }

        // Data Reset Options
        $resetAccounts = [];
        if (! empty($this->searchReset)) {
            $search = '%'.$this->searchReset.'%';
            $resetAccounts = Account::where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', $search)
                    ->orWhere('username', 'LIKE', $search)
                    ->orWhere('id_position', 'LIKE', $search)
                    ->orWhere('email', 'LIKE', $search);
            })
                ->with('ranting')
                ->limit(10)
                ->get();
        }

        // Logs
        $logsQuery = ActivityLog::with('account')->latest();
        if (! empty($this->logSearch)) {
            $s = '%'.$this->logSearch.'%';
            $logsQuery->where(function ($q) use ($s) {
                $q->where('action', 'LIKE', $s)
                    ->orWhere('description', 'LIKE', $s)
                    ->orWhereHas('account', fn ($sub) => $sub->where('nama', 'LIKE', $s)->orWhere('username', 'LIKE', $s));
            });
        }
        $logs = $logsQuery->paginate(15);

        // Metrics
        $metrics = [
            'total_ranting' => Ranting::count(),
            'total_pelatih' => Account::where('level', 'PLT')->count(),
            'total_atlet' => Student::count(),
            'total_logs' => ActivityLog::count(),
        ];

        return view('livewire.super-admin-dashboard', [
            'rantings' => $rantings,
            'transferAccounts' => $transferAccounts,
            'resetAccounts' => $resetAccounts,
            'logs' => $logs,
            'metrics' => $metrics,
        ])->layout('layouts.app', ['title' => 'Super Admin Panel - Garuda Amarta']);
    }
}
