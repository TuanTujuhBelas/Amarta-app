<div class="space-y-6">
    <!-- Header Super Admin Banner -->
    <div class="bg-gradient-to-r from-royal-blue via-blue-900 to-indigo-950 rounded-2xl p-6 md:p-8 text-white shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border border-blue-800/40">
        <div class="space-y-1">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-vibrant-yellow/20 text-vibrant-yellow text-xs font-bold border border-vibrant-yellow/30">
                <span>👑 Super Admin</span>
                <span>•</span>
                <span>
                    @if($activeTab === 'ranting') Master Ranting
                    @elseif($activeTab === 'transfer') Mutasi & Transfer
                    @elseif($activeTab === 'reset-password') Reset Password
                    @elseif($activeTab === 'logs') Audit Trail Log
                    @endif
                </span>
            </div>
            <h1 class="text-2xl md:text-3xl font-black tracking-tight text-white">
                @if($activeTab === 'ranting') Master Ranting Cabang Latihan
                @elseif($activeTab === 'transfer') Mutasi & Perpindahan Ranting Anggota
                @elseif($activeTab === 'reset-password') Reset Kata Sandi Akun Pengguna
                @elseif($activeTab === 'logs') Audit Trail Log Aktivitas Sistem
                @endif
            </h1>
            <p class="text-blue-200 text-sm">
                @if($activeTab === 'ranting') Kelola cabang latihan resmi Garuda Amarta yang digunakan pada form pendaftaran.
                @elseif($activeTab === 'transfer') Pindahkan pelatih atau siswa antar ranting dengan pencatatan mutasi resmi.
                @elseif($activeTab === 'reset-password') Tetapkan password baru untuk pelatih atau siswa yang mengalami kendala login.
                @elseif($activeTab === 'logs') Rekam jejak seluruh aktivitas verifikasi, pendaftaran, dan pengelolaan sistem.
                @endif
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('coach.dashboard') }}" class="min-h-[44px] px-5 rounded-xl bg-vibrant-yellow hover:bg-yellow-400 text-neutral-900 font-bold text-sm inline-flex items-center gap-2 shadow-lg transition">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                <span>Dashboard Verifikasi Atlet</span>
            </a>
        </div>
    </div>

    @if ($alertMessage)
        <div class="p-4 rounded-xl text-sm font-semibold flex items-center justify-between {{ $alertType === 'error' ? 'bg-rose-50 text-crimson-red border border-rose-200 dark:bg-rose-950/40' : 'bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300' }}">
            <span>{{ $alertMessage }}</span>
            <button wire:click="$set('alertMessage', '')" class="text-neutral-400 hover:text-neutral-700">&times;</button>
        </div>
    @endif

    <!-- Tautan Privat Registrasi Pelatih Khusus Super Admin -->
    <div class="p-4 rounded-2xl bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
        <div class="flex items-center gap-2.5">
            <span class="size-8 rounded-lg bg-amber-100 dark:bg-amber-900/40 text-amber-600 flex items-center justify-center text-sm font-bold shrink-0">🔒</span>
            <div>
                <strong class="text-amber-950 dark:text-amber-200 font-bold block">Tautan Khusus Pendaftaran Pelatih (Privat):</strong>
                <span class="font-mono text-amber-800 dark:text-amber-300">{{ url('/regist-pelatih') }}</span>
            </div>
        </div>
        <a href="{{ route('register.pelatih') }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold transition text-center shrink-0">
            Buka Form Pelatih ↗
        </a>
    </div>

    <!-- Metrics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-neutral-900 p-5 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-neutral-400 uppercase">Master Ranting</span>
                <span class="size-8 rounded-lg bg-blue-50 dark:bg-blue-950/50 text-royal-blue flex items-center justify-center font-bold text-sm">🏛️</span>
            </div>
            <p class="text-2xl font-black text-neutral-900 dark:text-white mt-2">{{ $metrics['total_ranting'] }}</p>
            <p class="text-[11px] text-neutral-400 mt-0.5">Cabang Latihan Aktif</p>
        </div>

        <div class="bg-white dark:bg-neutral-900 p-5 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-neutral-400 uppercase">Total Pelatih</span>
                <span class="size-8 rounded-lg bg-amber-50 dark:bg-amber-950/50 text-amber-600 flex items-center justify-center font-bold text-sm">🧑‍🏫</span>
            </div>
            <p class="text-2xl font-black text-neutral-900 dark:text-white mt-2">{{ $metrics['total_pelatih'] }}</p>
            <p class="text-[11px] text-neutral-400 mt-0.5">Instruktur Terdaftar</p>
        </div>

        <div class="bg-white dark:bg-neutral-900 p-5 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-neutral-400 uppercase">Total Atlet</span>
                <span class="size-8 rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 flex items-center justify-center font-bold text-sm">🥋</span>
            </div>
            <p class="text-2xl font-black text-neutral-900 dark:text-white mt-2">{{ $metrics['total_atlet'] }}</p>
            <p class="text-[11px] text-neutral-400 mt-0.5">Siswa / Atlet Tanding</p>
        </div>

        <div class="bg-white dark:bg-neutral-900 p-5 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-neutral-400 uppercase">Audit Trail</span>
                <span class="size-8 rounded-lg bg-purple-50 dark:bg-purple-950/50 text-purple-600 flex items-center justify-center font-bold text-sm">📋</span>
            </div>
            <p class="text-2xl font-black text-neutral-900 dark:text-white mt-2">{{ $metrics['total_logs'] }}</p>
            <p class="text-[11px] text-neutral-400 mt-0.5">Aktivitas Tercatat</p>
        </div>
    </div>

    <!-- TAB 1: MASTER RANTING -->
    @if ($activeTab === 'ranting')
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm p-6 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-neutral-900 dark:text-white">Daftar Cabang / Ranting Latihan</h2>
                    <p class="text-xs text-neutral-500">Cabang latihan resmi Garuda Amarta yang digunakan saat pendaftaran siswa & pelatih.</p>
                </div>
                <button wire:click="openCreateRanting" class="min-h-[40px] px-4 rounded-xl bg-royal-blue hover:bg-blue-700 text-white font-semibold text-xs inline-flex items-center gap-2 transition shadow">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Ranting Baru</span>
                </button>
            </div>

            <div class="overflow-x-auto rounded-xl border border-neutral-200 dark:border-neutral-800">
                <table class="w-full text-left text-xs">
                    <thead class="bg-neutral-50 dark:bg-neutral-800/60 uppercase font-bold text-neutral-500 border-b border-neutral-200 dark:border-neutral-800">
                        <tr>
                            <th class="py-3 px-4">ID</th>
                            <th class="py-3 px-4">Nama Ranting</th>
                            <th class="py-3 px-4">Alamat / Lokasi</th>
                            <th class="py-3 px-4 text-center">Jumlah Anggota</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
                        @forelse($rantings as $r)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/40 transition">
                                <td class="py-3 px-4 font-mono font-bold text-neutral-500">{{ $r->id_ranting }}</td>
                                <td class="py-3 px-4 font-bold text-neutral-900 dark:text-white">{{ $r->nm_ranting }}</td>
                                <td class="py-3 px-4 text-neutral-600 dark:text-neutral-400">{{ $r->alamat ?? '-' }}</td>
                                <td class="py-3 px-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full bg-blue-50 dark:bg-blue-950/40 text-royal-blue dark:text-blue-400 font-bold">
                                        {{ $r->accounts_count }} Anggota
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right space-x-2">
                                    <button wire:click="editRanting({{ $r->id_ranting }})" class="px-3 py-1.5 rounded-lg bg-neutral-100 dark:bg-neutral-800 hover:bg-neutral-200 text-neutral-800 dark:text-neutral-200 font-semibold transition">
                                        Edit
                                    </button>
                                    <button wire:click="deleteRanting({{ $r->id_ranting }})" wire:confirm="Yakin ingin menghapus ranting ini?" class="px-3 py-1.5 rounded-lg bg-rose-50 dark:bg-rose-950/30 text-crimson-red hover:bg-rose-100 font-semibold transition">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-neutral-400">Belum ada data ranting.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- TAB 2: TRANSFER ANGGOTA -->
    @if ($activeTab === 'transfer')
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm p-6 space-y-6">
            <div>
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white">Mutasi / Perpindahan Ranting</h2>
                <p class="text-xs text-neutral-500">Pindahkan pelatih atau siswa antar ranting secara resmi. Perubahan akan tercatat di riwayat audit.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom 1: Cari Anggota -->
                <div class="space-y-4 p-5 rounded-xl bg-neutral-50 dark:bg-neutral-800/40 border border-neutral-200 dark:border-neutral-800">
                    <h3 class="text-sm font-bold text-neutral-900 dark:text-white">1. Pilih Anggota yang Akan Dipindahkan</h3>
                    <div>
                        <label class="block text-xs font-semibold text-neutral-600 dark:text-neutral-400 mb-1">Cari Nama / Username / ID Posisi</label>
                        <input type="text" wire:model.live.debounce.300ms="searchTransfer" placeholder="Ketik untuk mencari..." class="w-full min-h-[44px] px-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-xs outline-none focus:ring-2 focus:ring-royal-blue" />
                    </div>

                    @if (!empty($transferAccounts))
                        <div class="space-y-2 max-h-60 overflow-y-auto">
                            @foreach($transferAccounts as $acc)
                                <label class="flex items-center justify-between p-3 rounded-xl border {{ $transferAccountId === $acc->id ? 'border-royal-blue bg-blue-50/50 dark:bg-blue-950/30' : 'border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800' }} cursor-pointer">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" wire:model="transferAccountId" value="{{ $acc->id }}" class="text-royal-blue" />
                                        <div>
                                            <p class="text-xs font-bold text-neutral-900 dark:text-white">{{ $acc->nama }} <span class="text-[10px] uppercase font-mono px-1.5 py-0.5 rounded bg-neutral-100 dark:bg-neutral-700 text-neutral-500">{{ $acc->level }}</span></p>
                                            <p class="text-[11px] font-mono text-royal-blue dark:text-blue-400">{{ $acc->id_position }}</p>
                                        </div>
                                    </div>
                                    <span class="text-xs font-semibold text-neutral-500">Ranting: {{ $acc->nama_ranting ?? 'Belum ada' }}</span>
                                </label>
                            @endforeach
                        </div>
                    @endif
                    @error('transferAccountId') <p class="text-xs text-crimson-red">{{ $message }}</p> @enderror
                </div>

                <!-- Kolom 2: Ranting Tujuan -->
                <div class="space-y-4 p-5 rounded-xl bg-neutral-50 dark:bg-neutral-800/40 border border-neutral-200 dark:border-neutral-800">
                    <h3 class="text-sm font-bold text-neutral-900 dark:text-white">2. Pilih Ranting Tujuan</h3>
                    <div>
                        <label class="block text-xs font-semibold text-neutral-600 dark:text-neutral-400 mb-1">Ranting Baru</label>
                        <select wire:model="targetRantingId" class="w-full min-h-[44px] px-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-xs outline-none focus:ring-2 focus:ring-royal-blue">
                            <option value="">-- Pilih Ranting Tujuan --</option>
                            @foreach($rantings as $rg)
                                <option value="{{ $rg->id_ranting }}">{{ $rg->nm_ranting }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('targetRantingId') <p class="text-xs text-crimson-red">{{ $message }}</p> @enderror

                    <div class="pt-4">
                        <button wire:click="transferMember" wire:confirm="Konfirmasi pemindahan anggota ini?" class="w-full min-h-[44px] rounded-xl bg-royal-blue hover:bg-blue-700 text-white font-bold text-xs shadow transition">
                            Proses Pemindahan Ranting
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- TAB 3: RESET PASSWORD -->
    @if ($activeTab === 'reset-password')
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm p-6 space-y-6">
            <div>
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white">Reset Password Akun</h2>
                <p class="text-xs text-neutral-500">Gunakan fitur ini untuk mereset kata sandi pelatih atau siswa yang lupa password. Akun akan dipaksa mengganti password baru saat login.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom 1: Cari User -->
                <div class="space-y-4 p-5 rounded-xl bg-neutral-50 dark:bg-neutral-800/40 border border-neutral-200 dark:border-neutral-800">
                    <h3 class="text-sm font-bold text-neutral-900 dark:text-white">1. Pilih Akun Pengguna</h3>
                    <div>
                        <label class="block text-xs font-semibold text-neutral-600 dark:text-neutral-400 mb-1">Cari Nama / Username / Email / ID Posisi</label>
                        <input type="text" wire:model.live.debounce.300ms="searchReset" placeholder="Ketik pencarian akun..." class="w-full min-h-[44px] px-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-xs outline-none focus:ring-2 focus:ring-royal-blue" />
                    </div>

                    @if (!empty($resetAccounts))
                        <div class="space-y-2 max-h-60 overflow-y-auto">
                            @foreach($resetAccounts as $acc)
                                <label class="flex items-center justify-between p-3 rounded-xl border {{ $resetAccountId === $acc->id ? 'border-royal-blue bg-blue-50/50 dark:bg-blue-950/30' : 'border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800' }} cursor-pointer">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" wire:model="resetAccountId" value="{{ $acc->id }}" class="text-royal-blue" />
                                        <div>
                                            <p class="text-xs font-bold text-neutral-900 dark:text-white">{{ $acc->nama }} <span class="text-[10px] uppercase font-mono px-1.5 py-0.5 rounded bg-neutral-100 dark:bg-neutral-700 text-neutral-500">{{ $acc->level }}</span></p>
                                            <p class="text-[11px] font-mono text-neutral-500">{{ $acc->username }} ({{ $acc->email }})</p>
                                        </div>
                                    </div>
                                    <span class="text-xs font-mono text-royal-blue dark:text-blue-400">{{ $acc->id_position ?? '-' }}</span>
                                </label>
                            @endforeach
                        </div>
                    @endif
                    @error('resetAccountId') <p class="text-xs text-crimson-red">{{ $message }}</p> @enderror
                </div>

                <!-- Kolom 2: Password Baru -->
                <div class="space-y-4 p-5 rounded-xl bg-neutral-50 dark:bg-neutral-800/40 border border-neutral-200 dark:border-neutral-800">
                    <h3 class="text-sm font-bold text-neutral-900 dark:text-white">2. Tetapkan Password Baru</h3>
                    <div>
                        <label class="block text-xs font-semibold text-neutral-600 dark:text-neutral-400 mb-1">Password Sementara (Minimal 6 Karakter)</label>
                        <input type="text" wire:model="newPassword" placeholder="Contoh: Amarta123!" class="w-full min-h-[44px] px-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-xs font-mono outline-none focus:ring-2 focus:ring-royal-blue" />
                    </div>
                    @error('newPassword') <p class="text-xs text-crimson-red">{{ $message }}</p> @enderror

                    <div class="pt-4">
                        <button wire:click="executeResetPassword" wire:confirm="Reset password akun ini sekarang?" class="w-full min-h-[44px] rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs shadow transition">
                            Reset Password Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- TAB 4: AUDIT TRAIL LOGS -->
    @if ($activeTab === 'logs')
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm p-6 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-neutral-900 dark:text-white">Audit Trail Aktivitas Sistem</h2>
                    <p class="text-xs text-neutral-500">Rekam jejak seluruh registrasi, verifikasi berkas, revisi dokumen, perubahan password, dan mutasi anggota.</p>
                </div>
                <div class="w-full sm:w-72">
                    <input type="text" wire:model.live.debounce.300ms="logSearch" placeholder="Cari action, nama, deskripsi..." class="w-full min-h-[38px] px-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-xs outline-none focus:ring-2 focus:ring-royal-blue" />
                </div>
            </div>

            <div class="overflow-x-auto rounded-xl border border-neutral-200 dark:border-neutral-800">
                <table class="w-full text-left text-xs">
                    <thead class="bg-neutral-50 dark:bg-neutral-800/60 uppercase font-bold text-neutral-500 border-b border-neutral-200 dark:border-neutral-800">
                        <tr>
                            <th class="py-3 px-4">Waktu</th>
                            <th class="py-3 px-4">User Pelaksana</th>
                            <th class="py-3 px-4">Aksi</th>
                            <th class="py-3 px-4">Deskripsi Aktivitas</th>
                            <th class="py-3 px-4">Metadata</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
                        @forelse($logs as $log)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/40 transition">
                                <td class="py-3 px-4 text-neutral-500 font-mono text-[11px] whitespace-nowrap">
                                    {{ $log->created_at ? $log->created_at->format('Y-m-d H:i:s') : '-' }}
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-bold text-neutral-900 dark:text-white">{{ $log->account->nama ?? 'Sistem' }}</div>
                                    <div class="text-[10px] text-neutral-400 font-mono">{{ $log->account->username ?? '-' }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold font-mono uppercase bg-neutral-100 dark:bg-neutral-800 text-royal-blue dark:text-blue-400">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-neutral-800 dark:text-neutral-200">
                                    {{ $log->description }}
                                </td>
                                <td class="py-3 px-4 font-mono text-[10px] text-neutral-500 max-w-xs truncate">
                                    {{ $log->metadata ? json_encode($log->metadata) : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-neutral-400">Tidak ada log aktivitas yang cocok.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pt-2">
                {{ $logs->links() }}
            </div>
        </div>
    @endif

    <!-- MODAL CREATE / EDIT RANTING -->
    @if ($showRantingModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div class="bg-white dark:bg-neutral-900 rounded-2xl max-w-md w-full p-6 shadow-2xl border border-neutral-200 dark:border-neutral-800 space-y-4">
                <h3 class="text-lg font-bold text-neutral-900 dark:text-white">
                    {{ $editingRantingId ? 'Edit Master Ranting' : 'Tambah Ranting Baru' }}
                </h3>

                <div>
                    <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Nama Ranting Latihan <span class="text-crimson-red">*</span></label>
                    <input type="text" wire:model="nm_ranting" placeholder="Contoh: Ranting Tebet, Mayora, dll." class="w-full min-h-[44px] px-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm outline-none focus:ring-2 focus:ring-royal-blue" />
                    @error('nm_ranting') <p class="text-xs text-crimson-red mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Alamat / Lokasi Latihan</label>
                    <textarea wire:model="alamat_ranting" rows="3" placeholder="Alamat lengkap tempat latihan..." class="w-full p-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm outline-none focus:ring-2 focus:ring-royal-blue"></textarea>
                    @error('alamat_ranting') <p class="text-xs text-crimson-red mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button wire:click="$set('showRantingModal', false)" class="px-4 py-2 rounded-xl bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 text-xs font-semibold hover:bg-neutral-200 transition">
                        Batal
                    </button>
                    <button wire:click="saveRanting" class="px-4 py-2 rounded-xl bg-royal-blue text-white text-xs font-bold hover:bg-blue-700 transition">
                        Simpan Ranting
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
