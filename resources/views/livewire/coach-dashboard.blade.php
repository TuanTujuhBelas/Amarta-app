<div class="space-y-6">
    <!-- Top Welcome Banner -->
    <div class="bg-royal-blue text-white rounded-2xl p-6 md:p-8 shadow-lg flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-xs font-semibold text-vibrant-yellow mb-2">
                <span>🥋 Panel Pelatih Resmi</span>
                <span>•</span>
                <span>{{ auth()->user()->nama_ranting ?? 'Pusat' }}</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-black text-white">Selamat Datang, Pelatih {{ auth()->user()->nama }}!</h1>
            <p class="text-blue-100 text-sm mt-1">Kelola verifikasi atlet, tindak lanjut revisi berkas, dan pencetakan dokumen resmi Garuda Amarta.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-4 py-2 rounded-xl bg-white/10 text-xs font-mono font-bold tracking-wider text-vibrant-yellow border border-white/20">
                ID: {{ auth()->user()->id_position }}
            </span>
        </div>
    </div>

    <!-- Alert Notification -->
    @if ($alertMessage)
        <div class="p-4 rounded-xl flex items-center justify-between gap-3 text-sm font-semibold {{ $alertType === 'success' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300' : 'bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/40 dark:text-amber-300' }}">
            <div class="flex items-center gap-2">
                @if($alertType === 'success')
                    <svg class="size-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                @else
                    <svg class="size-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                @endif
                <span>{{ $alertMessage }}</span>
            </div>
            <button wire:click="$set('alertMessage', '')" class="text-neutral-400 hover:text-neutral-700">&times;</button>
        </div>
    @endif

    <!-- Metrics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <!-- Total Atlet -->
        <div class="bg-white dark:bg-neutral-900 p-5 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm">
            <p class="text-xs font-semibold text-neutral-500 uppercase tracking-wider">Total Atlet Terdaftar</p>
            <p class="text-3xl font-black text-neutral-900 dark:text-white mt-2">{{ $metrics['total'] }}</p>
            <p class="text-xs text-neutral-400 mt-1">Seluruh ranting</p>
        </div>

        <!-- Pending -->
        <div class="bg-white dark:bg-neutral-900 p-5 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm">
            <p class="text-xs font-semibold text-amber-600 dark:text-amber-400 uppercase tracking-wider">Menunggu Verifikasi</p>
            <p class="text-3xl font-black text-amber-600 dark:text-amber-400 mt-2">{{ $metrics['pending'] }}</p>
            <p class="text-xs text-neutral-400 mt-1">Perlu dicek dokumennya</p>
        </div>

        <!-- Approved -->
        <div class="bg-white dark:bg-neutral-900 p-5 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm">
            <p class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Terverifikasi (Sah)</p>
            <p class="text-3xl font-black text-emerald-600 dark:text-emerald-400 mt-2">{{ $metrics['approved'] }}</p>
            <p class="text-xs text-neutral-400 mt-1">Berkas lengkap & valid</p>
        </div>

        <!-- Need Revision -->
        <div class="bg-white dark:bg-neutral-900 p-5 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm">
            <p class="text-xs font-semibold text-crimson-red uppercase tracking-wider">Perlu Revisi</p>
            <p class="text-3xl font-black text-crimson-red mt-2">{{ $metrics['need_revision'] }}</p>
            <p class="text-xs text-neutral-400 mt-1">Menunggu unggah ulang</p>
        </div>
    </div>

    <!-- Filter Bar & Search -->
    <div class="bg-white dark:bg-neutral-900 p-4 md:p-6 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
            <!-- Search -->
            <div class="md:col-span-5">
                <label class="block text-xs font-semibold text-neutral-500 mb-1">Cari Atlet</label>
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Ketik nama atlet, ID position, atau sekolah..." class="w-full min-h-[44px] pl-10 pr-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm text-neutral-900 dark:text-white outline-none focus:ring-2 focus:ring-royal-blue" />
                    <svg class="size-4 text-neutral-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <!-- Filter Status -->
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-neutral-500 mb-1">Status</label>
                <select wire:model.live="filterStatus" class="w-full min-h-[44px] px-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm text-neutral-900 dark:text-white outline-none focus:ring-2 focus:ring-royal-blue">
                    <option value="">Semua Status</option>
                    <option value="pending">🟡 Pending</option>
                    <option value="approved">🟢 Terverifikasi</option>
                    <option value="need_revision">🔴 Perlu Revisi</option>
                </select>
            </div>

            <!-- Filter Ranting -->
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-neutral-500 mb-1">Ranting Latihan</label>
                <select wire:model.live="filterRanting" class="w-full min-h-[44px] px-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm text-neutral-900 dark:text-white outline-none focus:ring-2 focus:ring-royal-blue">
                    <option value="">Semua Ranting</option>
                    @foreach ($rantingOptions as $ranting)
                        <option value="{{ $ranting }}">{{ $ranting }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Ekspor Bulk ZIP Button -->
            <div class="md:col-span-3">
                <button wire:click="exportZip" wire:loading.attr="disabled" class="w-full min-h-[44px] px-4 py-2.5 rounded-xl bg-vibrant-yellow hover:bg-yellow-400 text-neutral-950 font-bold text-xs uppercase tracking-wider flex items-center justify-center gap-2 shadow-xs transition disabled:opacity-50 cursor-pointer">
                    <span wire:loading.remove wire:target="exportZip" class="flex items-center gap-2">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Ekspor Paket ZIP
                    </span>
                    <span wire:loading wire:target="exportZip" class="flex items-center gap-2">
                        <svg class="size-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Menyusun ZIP...
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Tabel Data Atlet -->
    <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-neutral-50 dark:bg-neutral-800/60 border-b border-neutral-200 dark:border-neutral-800 text-xs text-neutral-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-4 font-semibold">Atlet</th>
                        <th class="px-5 py-4 font-semibold">Ranting & Sabuk</th>
                        <th class="px-5 py-4 font-semibold">Tingkat & Kategori</th>
                        <th class="px-5 py-4 font-semibold">Fisik (BB/TB)</th>
                        <th class="px-5 py-4 font-semibold">Status</th>
                        <th class="px-5 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
                    @forelse ($students as $student)
                        <tr class="hover:bg-neutral-50/70 dark:hover:bg-neutral-800/40 transition">
                            <!-- Profil & ID -->
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    @php
                                        $photoUrl = \App\Services\R2StorageService::url($student->photo);
                                    @endphp
                                    @if ($photoUrl)
                                        <img src="{{ $photoUrl }}" class="size-11 object-cover rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-xs" alt="{{ $student->nama_lengkap }}" />
                                    @else
                                        <div class="size-11 rounded-xl bg-neutral-200 dark:bg-neutral-700 flex items-center justify-center font-bold text-neutral-500 text-xs">
                                            {{ substr($student->nama_lengkap, 0, 2) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-neutral-900 dark:text-white leading-tight">{{ $student->nama_lengkap }}</p>
                                        <p class="text-xs font-mono text-royal-blue dark:text-blue-400 font-semibold mt-0.5">{{ $student->account->id_position ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Ranting & Sabuk -->
                            <td class="px-5 py-4">
                                <p class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $student->account->nama_ranting ?? '-' }}</p>
                                <span class="inline-block mt-1 px-2 py-0.5 rounded-md text-xs font-medium bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300">
                                    {{ $student->tingkat_sabuk }}
                                </span>
                            </td>

                            <!-- Tingkat & Kategori -->
                            <td class="px-5 py-4">
                                <p class="text-neutral-900 dark:text-white font-medium">{{ $student->tingkat }} — <span class="text-royal-blue dark:text-blue-400 font-bold">{{ $student->kategori }}</span></p>
                                <p class="text-xs text-neutral-500 mt-0.5">Kelas: {{ $student->kelas }}</p>
                            </td>

                            <!-- Fisik -->
                            <td class="px-5 py-4 text-xs text-neutral-600 dark:text-neutral-400">
                                <p><span class="font-semibold text-neutral-900 dark:text-white">{{ $student->berat_badan }}</span> kg</p>
                                <p><span class="font-semibold text-neutral-900 dark:text-white">{{ $student->tinggi_badan }}</span> cm</p>
                            </td>

                            <!-- Status Badge -->
                            <td class="px-5 py-4">
                                @if ($student->status_verifikasi === 'approved')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                        <span class="size-1.5 rounded-full bg-emerald-600"></span> Disetujui
                                    </span>
                                @elseif ($student->status_verifikasi === 'need_revision')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 dark:bg-rose-950/60 dark:text-rose-300 border border-rose-200 dark:border-rose-800">
                                        <span class="size-1.5 rounded-full bg-crimson-red"></span> Perlu Revisi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                                        <span class="size-1.5 rounded-full bg-amber-500 animate-pulse"></span> Pending
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-5 py-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Detail Dokumen -->
                                    <button wire:click="openDetail({{ $student->id }})" title="Lihat Berkas & Detail" class="p-2 rounded-lg bg-neutral-100 dark:bg-neutral-800 hover:bg-neutral-200 dark:hover:bg-neutral-700 text-neutral-700 dark:text-neutral-200 transition">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>

                                    <!-- Setujui / Approve -->
                                    @if ($student->status_verifikasi !== 'approved')
                                        <button wire:click="approve({{ $student->id }})" title="Setujui Verifikasi" class="p-2 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-400 dark:border-emerald-800 transition">
                                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    @endif

                                    <!-- Minta Revisi -->
                                    <button wire:click="openRevision({{ $student->id }})" title="Minta Revisi Dokumen" class="p-2 rounded-lg bg-rose-50 text-crimson-red hover:bg-crimson-red hover:text-white border border-rose-200 dark:bg-rose-950/40 dark:border-rose-900 transition">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    </button>

                                    <!-- Ekspor PDF -->
                                    <button wire:click="exportPdf({{ $student->id }})" title="Unduh Biodata PDF" class="p-2 rounded-lg bg-blue-50 text-royal-blue hover:bg-royal-blue hover:text-white border border-blue-200 dark:bg-blue-950/40 dark:text-blue-400 dark:border-blue-900 transition">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-neutral-400">
                                <svg class="size-12 mx-auto text-neutral-300 dark:text-neutral-700 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="font-medium text-sm">Belum ada data atlet yang sesuai dengan filter pencarian.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($students->hasPages())
            <div class="p-4 border-t border-neutral-200 dark:border-neutral-800">
                {{ $students->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL DETAIL & PEMERIKSAAN BERKAS DOKUMEN -->
    @if ($showDetailModal && $selectedStudent)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-neutral-900 w-full max-w-4xl max-h-[90vh] rounded-2xl shadow-2xl border border-neutral-200 dark:border-neutral-800 flex flex-col overflow-hidden">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-800 flex items-center justify-between bg-neutral-50 dark:bg-neutral-800/50">
                    <div>
                        <h2 class="text-lg font-bold text-neutral-900 dark:text-white">Pemeriksaan Berkas: {{ $selectedStudent->nama_lengkap }}</h2>
                        <p class="text-xs font-mono text-royal-blue dark:text-blue-400 font-bold mt-0.5">{{ $selectedStudent->account->id_position }}</p>
                    </div>
                    <button wire:click="closeDetail" class="text-neutral-400 hover:text-neutral-700 text-2xl leading-none">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto space-y-6 flex-1 text-sm">
                    <!-- Galeri 4 Dokumen -->
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-500 mb-3">4 Berkas Dokumen Wajib Atlet</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <!-- Foto Profil -->
                            @php $pUrl = \App\Services\R2StorageService::url($selectedStudent->photo); @endphp
                            <div class="p-3 rounded-xl border border-neutral-200 dark:border-neutral-700 text-center bg-neutral-50 dark:bg-neutral-800/40">
                                <p class="text-xs font-bold text-neutral-700 dark:text-neutral-300 mb-2">Foto Profil</p>
                                @if($pUrl)
                                    <a href="{{ $pUrl }}" target="_blank" class="block group relative">
                                        <img src="{{ $pUrl }}" class="w-full h-36 object-cover rounded-lg shadow-xs group-hover:opacity-90" />
                                        <span class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs font-semibold rounded-lg transition">Buka Penuh</span>
                                    </a>
                                @else
                                    <div class="h-36 flex items-center justify-center text-xs text-neutral-400">Tidak ada file</div>
                                @endif
                            </div>

                            <!-- Foto KK -->
                            @php $kkUrl = \App\Services\R2StorageService::url($selectedStudent->photo_kk); @endphp
                            <div class="p-3 rounded-xl border border-neutral-200 dark:border-neutral-700 text-center bg-neutral-50 dark:bg-neutral-800/40">
                                <p class="text-xs font-bold text-neutral-700 dark:text-neutral-300 mb-2">Kartu Keluarga (KK)</p>
                                @if($kkUrl)
                                    <a href="{{ $kkUrl }}" target="_blank" class="block group relative">
                                        <img src="{{ $kkUrl }}" class="w-full h-36 object-cover rounded-lg shadow-xs group-hover:opacity-90" />
                                        <span class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs font-semibold rounded-lg transition">Buka Penuh</span>
                                    </a>
                                @else
                                    <div class="h-36 flex items-center justify-center text-xs text-neutral-400">Tidak ada file</div>
                                @endif
                            </div>

                            <!-- Foto Akte / KIA -->
                            @php $akteUrl = \App\Services\R2StorageService::url($selectedStudent->photo_akte_kia); @endphp
                            <div class="p-3 rounded-xl border border-neutral-200 dark:border-neutral-700 text-center bg-neutral-50 dark:bg-neutral-800/40">
                                <p class="text-xs font-bold text-neutral-700 dark:text-neutral-300 mb-2">Akte Lahir / KIA</p>
                                @if($akteUrl)
                                    <a href="{{ $akteUrl }}" target="_blank" class="block group relative">
                                        <img src="{{ $akteUrl }}" class="w-full h-36 object-cover rounded-lg shadow-xs group-hover:opacity-90" />
                                        <span class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs font-semibold rounded-lg transition">Buka Penuh</span>
                                    </a>
                                @else
                                    <div class="h-36 flex items-center justify-center text-xs text-neutral-400">Tidak ada file</div>
                                @endif
                            </div>

                            <!-- Foto Surat Sehat -->
                            @php $sehatUrl = \App\Services\R2StorageService::url($selectedStudent->photo_surat_sehat); @endphp
                            <div class="p-3 rounded-xl border border-neutral-200 dark:border-neutral-700 text-center bg-neutral-50 dark:bg-neutral-800/40">
                                <p class="text-xs font-bold text-neutral-700 dark:text-neutral-300 mb-2">Surat Dokter / Sehat</p>
                                @if($sehatUrl)
                                    <a href="{{ $sehatUrl }}" target="_blank" class="block group relative">
                                        <img src="{{ $sehatUrl }}" class="w-full h-36 object-cover rounded-lg shadow-xs group-hover:opacity-90" />
                                        <span class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs font-semibold rounded-lg transition">Buka Penuh</span>
                                    </a>
                                @else
                                    <div class="h-36 flex items-center justify-center text-xs text-neutral-400">Tidak ada file</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Lengkap Atlet -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-neutral-200 dark:border-neutral-800">
                        <div class="space-y-2">
                            <p class="text-xs text-neutral-500 uppercase font-semibold">Data Diri</p>
                            <p><span class="text-neutral-400">Nama:</span> <strong class="text-neutral-900 dark:text-white">{{ $selectedStudent->nama_lengkap }}</strong></p>
                            <p><span class="text-neutral-400">Tgl Lahir:</span> {{ $selectedStudent->tanggal_lahir ? $selectedStudent->tanggal_lahir->format('d F Y') : '-' }}</p>
                            <p><span class="text-neutral-400">Gender:</span> {{ $selectedStudent->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                            <p><span class="text-neutral-400">NIK / KIA:</span> <span class="font-mono">{{ $selectedStudent->nik_kia }}</span></p>
                            <p><span class="text-neutral-400">No. KK:</span> <span class="font-mono">{{ $selectedStudent->no_kk }}</span></p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-xs text-neutral-500 uppercase font-semibold">Kontak & Ranting</p>
                            <p><span class="text-neutral-400">Ranting:</span> <strong>{{ $selectedStudent->account->nama_ranting ?? '-' }}</strong></p>
                            <p><span class="text-neutral-400">Sekolah:</span> {{ $selectedStudent->nama_sekolah }} ({{ $selectedStudent->tingkat }})</p>
                            <p><span class="text-neutral-400">Wali:</span> {{ $selectedStudent->nama_ortu }} (WA: {{ $selectedStudent->no_ortu }})</p>
                            <p><span class="text-neutral-400">Email:</span> {{ $selectedStudent->account->email }}</p>
                            <p><span class="text-neutral-400">Alamat:</span> {{ $selectedStudent->account->alamat }}</p>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer Actions -->
                <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-800 bg-neutral-50 dark:bg-neutral-800/50 flex items-center justify-between gap-3">
                    <button wire:click="closeDetail" class="px-4 py-2 rounded-xl border border-neutral-300 dark:border-neutral-700 text-neutral-700 dark:text-neutral-300 text-sm font-semibold">Tutup</button>
                    
                    <div class="flex items-center gap-2">
                        <button wire:click="exportPdf({{ $selectedStudent->id }})" class="px-4 py-2 rounded-xl bg-blue-50 text-royal-blue border border-blue-300 hover:bg-royal-blue hover:text-white text-sm font-semibold transition inline-flex items-center gap-1.5">
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Kartu Anggota (PDF)</span>
                        </button>
                        <button wire:click="openRevision({{ $selectedStudent->id }})" class="px-4 py-2 rounded-xl bg-rose-50 text-crimson-red border border-rose-300 hover:bg-crimson-red hover:text-white text-sm font-semibold transition">
                            Minta Revisi Berkas
                        </button>
                        @if ($selectedStudent->status_verifikasi !== 'approved')
                            <button wire:click="approve({{ $selectedStudent->id }})" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold transition">
                                Setujui & Sahkan Atlet
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL PERMINTAAN REVISI DOKUMEN -->
    @if ($showRevisionModal && $selectedStudent)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-neutral-900 w-full max-w-lg rounded-2xl shadow-2xl border border-neutral-200 dark:border-neutral-800 overflow-hidden">
                <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-800 flex items-center justify-between bg-rose-50 dark:bg-rose-950/30">
                    <h2 class="text-base font-bold text-crimson-red">Instruksi Revisi: {{ $selectedStudent->nama_lengkap }}</h2>
                    <button wire:click="closeRevision" class="text-neutral-400 hover:text-neutral-700 text-2xl leading-none">&times;</button>
                </div>

                <form wire:submit.prevent="submitRevision" class="p-6 space-y-4">
                    <p class="text-xs text-neutral-600 dark:text-neutral-400">
                        Centang berkas atau data yang bermasalah. Atlet akan diminta mengunggah ulang hanya item yang Anda centang:
                    </p>

                    <!-- Checkboxes -->
                    <div class="space-y-2 text-sm">
                        <label class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-800 cursor-pointer">
                            <input type="checkbox" wire:model.defer="requestedItems" value="photo" class="size-4 text-royal-blue rounded" />
                            <span>Foto Profil Atlet (Buram / Bukan seragam silat)</span>
                        </label>
                        <label class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-800 cursor-pointer">
                            <input type="checkbox" wire:model.defer="requestedItems" value="photo_kk" class="size-4 text-royal-blue rounded" />
                            <span>Foto Kartu Keluarga (KK) (Terpotong / Tidak terbaca)</span>
                        </label>
                        <label class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-800 cursor-pointer">
                            <input type="checkbox" wire:model.defer="requestedItems" value="photo_akte_kia" class="size-4 text-royal-blue rounded" />
                            <span>Foto Akte Kelahiran / KIA (Buram / Tidak sesuai)</span>
                        </label>
                        <label class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-800 cursor-pointer">
                            <input type="checkbox" wire:model.defer="requestedItems" value="photo_surat_sehat" class="size-4 text-royal-blue rounded" />
                            <span>Foto Surat Keterangan Sehat (Kedaluwarsa / Tanpa cap klinik)</span>
                        </label>
                        @error('requestedItems') <p class="text-xs text-crimson-red mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Catatan Pelatih -->
                    <div>
                        <label class="block text-xs font-bold text-neutral-700 dark:text-neutral-300 mb-1">Catatan Tambahan untuk Atlet <span class="text-crimson-red">*</span></label>
                        <textarea wire:model.defer="revisionNotes" rows="3" placeholder="Contoh: Mohon foto ulang kartu keluarga agar nomor KK dan nama orang tua terbaca jelas..." class="w-full p-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm outline-none focus:ring-2 focus:ring-royal-blue"></textarea>
                        @error('revisionNotes') <p class="text-xs text-crimson-red mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-3 border-t border-neutral-200 dark:border-neutral-800 flex justify-end gap-2">
                        <button type="button" wire:click="closeRevision" class="px-4 py-2 rounded-xl border border-neutral-300 dark:border-neutral-700 text-sm font-semibold">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-crimson-red hover:bg-red-700 text-white text-sm font-bold transition">Kirim Revisi ke Atlet</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- FIRST LOGIN MODAL (WAJIB GANTI PASSWORD & PROFIL) -->
    @if ($showFirstLoginModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-md p-4">
            <div class="bg-white dark:bg-neutral-900 rounded-2xl max-w-lg w-full p-6 md:p-8 shadow-2xl border-2 border-royal-blue space-y-5 animate-in fade-in zoom-in-95 duration-200">
                <div class="text-center space-y-2">
                    <div class="size-14 rounded-full bg-blue-100 dark:bg-blue-950/60 text-royal-blue dark:text-blue-400 flex items-center justify-center mx-auto text-2xl">
                        🔐
                    </div>
                    <h2 class="text-xl font-black text-neutral-900 dark:text-white">Pembaruan Keamanan Pertama Kali</h2>
                    <p class="text-xs text-neutral-600 dark:text-neutral-400">
                        Demi keamanan akun Anda, Anda wajib mengganti kata sandi bawaan dan memperbarui data profil sebelum dapat mengakses Dashboard Garuda Amarta.
                    </p>
                </div>

                <form wire:submit.prevent="submitFirstLogin" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-neutral-700 dark:text-neutral-300 mb-1">Kata Sandi Baru <span class="text-crimson-red">*</span></label>
                        <input type="password" wire:model.defer="firstLoginPassword" placeholder="Minimal 6 karakter" class="w-full min-h-[44px] px-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm outline-none focus:ring-2 focus:ring-royal-blue" />
                        @error('firstLoginPassword') <p class="text-xs text-crimson-red mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-neutral-700 dark:text-neutral-300 mb-1">Ulangi Kata Sandi Baru <span class="text-crimson-red">*</span></label>
                        <input type="password" wire:model.defer="firstLoginPassword_confirmation" placeholder="Konfirmasi kata sandi baru" class="w-full min-h-[44px] px-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm outline-none focus:ring-2 focus:ring-royal-blue" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-neutral-700 dark:text-neutral-300 mb-1">Email Aktif <span class="text-crimson-red">*</span></label>
                        <input type="email" wire:model.defer="firstLoginEmail" class="w-full min-h-[44px] px-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm outline-none focus:ring-2 focus:ring-royal-blue" />
                        @error('firstLoginEmail') <p class="text-xs text-crimson-red mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-neutral-700 dark:text-neutral-300 mb-1">Alamat Domisili <span class="text-crimson-red">*</span></label>
                        <textarea wire:model.defer="firstLoginAlamat" rows="2" class="w-full p-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm outline-none focus:ring-2 focus:ring-royal-blue"></textarea>
                        @error('firstLoginAlamat') <p class="text-xs text-crimson-red mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full min-h-[48px] rounded-xl bg-royal-blue hover:bg-blue-700 text-white font-bold text-sm shadow-lg transition">
                            Simpan & Buka Akses Dashboard
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
