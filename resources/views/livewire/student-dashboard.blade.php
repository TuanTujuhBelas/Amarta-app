<div class="space-y-6 max-w-4xl mx-auto">
    <!-- Header Banner -->
    <div class="bg-royal-blue text-white rounded-2xl p-6 md:p-8 shadow-lg flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-xs font-semibold text-vibrant-yellow mb-2">
                <span>🥋 Portal Atlet Resmi</span>
                <span>•</span>
                <span>{{ $student->account->nama_ranting ?? 'Garuda Amarta' }}</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-black text-white">Halo, {{ $student->nama_lengkap ?? auth()->user()->nama }}!</h1>
            <p class="text-blue-100 text-sm mt-1">Pantau status verifikasi keanggotaan dan kelengkapan dokumen pencak silat Anda.</p>
        </div>
        <div>
            <span class="px-4 py-2 rounded-xl bg-white/10 text-xs font-mono font-bold tracking-wider text-vibrant-yellow border border-white/20">
                ID: {{ $student->account->id_position ?? auth()->user()->id_position }}
            </span>
        </div>
    </div>

    @if ($successMessage)
        <div class="p-4 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 text-sm font-semibold flex items-center justify-between">
            <span>{{ $successMessage }}</span>
            <button wire:click="$set('successMessage', '')" class="text-neutral-400 hover:text-neutral-700">&times;</button>
        </div>
    @endif

    <!-- STATUS VERIFIKASI BANNER -->
    @if ($student)
        @if ($student->status_verifikasi === 'approved')
            <div class="p-5 rounded-2xl bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 flex items-start gap-4">
                <div class="size-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-emerald-900 dark:text-emerald-200">Berkas Terverifikasi & Disetujui!</h3>
                    <p class="text-xs text-emerald-700 dark:text-emerald-300 mt-1">
                        Selamat, data dan seluruh dokumen Anda telah diverifikasi oleh pelatih. Anda resmi terdaftar sebagai atlet tanding Garuda Amarta.
                    </p>
                </div>
            </div>
        @elseif ($student->status_verifikasi === 'need_revision')
            <div class="p-5 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border-2 border-crimson-red space-y-4">
                <div class="flex items-start gap-3">
                    <div class="size-10 rounded-full bg-rose-100 text-crimson-red flex items-center justify-center shrink-0">
                        <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-crimson-red text-base">Perhatian: Pelatih Meminta Revisi Dokumen</h3>
                        <p class="text-xs text-rose-800 dark:text-rose-300 mt-1">
                            Beberapa dokumen yang Anda unggah belum memenuhi syarat. Silakan periksa instruksi pelatih di bawah dan unggah ulang berkas yang diminta.
                        </p>
                    </div>
                </div>

                @if ($activeRevision)
                    <div class="p-4 rounded-xl bg-white dark:bg-neutral-900 border border-rose-200 dark:border-rose-900 space-y-2">
                        <p class="text-xs font-bold text-neutral-500 uppercase">Catatan Instruksi Pelatih:</p>
                        <p class="text-sm font-semibold text-neutral-900 dark:text-white bg-rose-50/50 dark:bg-rose-950/30 p-3 rounded-lg border border-rose-100 dark:border-rose-900">
                            "{{ $activeRevision->catatan }}"
                        </p>
                    </div>

                    <!-- Form Unggah Ulang Berkas Revisi -->
                    <form wire:submit.prevent="submitRevision" class="bg-white dark:bg-neutral-900 p-5 rounded-xl border border-neutral-200 dark:border-neutral-800 space-y-4">
                        <h4 class="text-sm font-bold text-neutral-900 dark:text-white">Form Unggah Ulang Berkas Revisi:</h4>

                        @php $req = $activeRevision->requested_items ?? []; @endphp

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if (in_array('photo', $req))
                                <div class="p-3 rounded-xl border-2 border-dashed border-rose-300 dark:border-rose-800 text-center">
                                    <label class="block text-xs font-bold text-crimson-red mb-1">Unggah Ulang Foto Profil *</label>
                                    @if ($new_photo)
                                        <img src="{{ $new_photo->temporaryUrl() }}" class="size-20 object-cover mx-auto rounded-lg mb-2" />
                                    @endif
                                    <input type="file" wire:model="new_photo" accept="image/*" class="text-xs text-neutral-500 file:py-1 file:px-2 file:rounded file:bg-royal-blue file:text-white file:border-0" />
                                    @error('new_photo') <p class="text-xs text-crimson-red mt-1">{{ $message }}</p> @enderror
                                </div>
                            @endif

                            @if (in_array('photo_kk', $req))
                                <div class="p-3 rounded-xl border-2 border-dashed border-rose-300 dark:border-rose-800 text-center">
                                    <label class="block text-xs font-bold text-crimson-red mb-1">Unggah Ulang Foto KK *</label>
                                    @if ($new_photo_kk)
                                        <img src="{{ $new_photo_kk->temporaryUrl() }}" class="size-20 object-cover mx-auto rounded-lg mb-2" />
                                    @endif
                                    <input type="file" wire:model="new_photo_kk" accept="image/*" class="text-xs text-neutral-500 file:py-1 file:px-2 file:rounded file:bg-royal-blue file:text-white file:border-0" />
                                    @error('new_photo_kk') <p class="text-xs text-crimson-red mt-1">{{ $message }}</p> @enderror
                                </div>
                            @endif

                            @if (in_array('photo_akte_kia', $req))
                                <div class="p-3 rounded-xl border-2 border-dashed border-rose-300 dark:border-rose-800 text-center">
                                    <label class="block text-xs font-bold text-crimson-red mb-1">Unggah Ulang Akte / KIA *</label>
                                    @if ($new_photo_akte_kia)
                                        <img src="{{ $new_photo_akte_kia->temporaryUrl() }}" class="size-20 object-cover mx-auto rounded-lg mb-2" />
                                    @endif
                                    <input type="file" wire:model="new_photo_akte_kia" accept="image/*" class="text-xs text-neutral-500 file:py-1 file:px-2 file:rounded file:bg-royal-blue file:text-white file:border-0" />
                                    @error('new_photo_akte_kia') <p class="text-xs text-crimson-red mt-1">{{ $message }}</p> @enderror
                                </div>
                            @endif

                            @if (in_array('photo_surat_sehat', $req))
                                <div class="p-3 rounded-xl border-2 border-dashed border-rose-300 dark:border-rose-800 text-center">
                                    <label class="block text-xs font-bold text-crimson-red mb-1">Unggah Ulang Surat Sehat *</label>
                                    @if ($new_photo_surat_sehat)
                                        <img src="{{ $new_photo_surat_sehat->temporaryUrl() }}" class="size-20 object-cover mx-auto rounded-lg mb-2" />
                                    @endif
                                    <input type="file" wire:model="new_photo_surat_sehat" accept="image/*" class="text-xs text-neutral-500 file:py-1 file:px-2 file:rounded file:bg-royal-blue file:text-white file:border-0" />
                                    @error('new_photo_surat_sehat') <p class="text-xs text-crimson-red mt-1">{{ $message }}</p> @enderror
                                </div>
                            @endif
                        </div>

                        <div class="pt-2 text-right">
                            <button type="submit" wire:loading.attr="disabled" class="min-h-[44px] px-6 rounded-xl bg-crimson-red hover:bg-red-700 text-white font-bold text-sm transition disabled:opacity-50">
                                <span wire:loading.remove>Kirim Berkas Revisi Sekarang</span>
                                <span wire:loading>Mengunggah ke Cloudflare R2...</span>
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        @else
            <div class="p-5 rounded-2xl bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800 flex items-start gap-4">
                <div class="size-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-amber-900 dark:text-amber-200">Sedang Dalam Peninjauan (Pending)</h3>
                    <p class="text-xs text-amber-700 dark:text-amber-300 mt-1">
                        Pendaftaran Anda telah diterima sistem. Pelatih sedang meninjau dokumen pendaftaran Anda. Mohon pantau halaman ini secara berkala.
                    </p>
                </div>
            </div>
        @endif

        <!-- KARTU ANGGOTA ATLET (SESUAI PRD BAGIAN 5) -->
        <div class="bg-white dark:bg-neutral-900 rounded-3xl p-6 md:p-8 shadow-xl border-2 border-royal-blue/30 max-w-2xl mx-auto space-y-6">
            <!-- Header Kartu -->
            <div class="flex items-center gap-4 pb-4 border-b-2 border-royal-blue">
                <img src="{{ asset('gama.png') }}" class="size-16 object-contain" alt="Logo Garuda Amarta" />
                <div>
                    <h2 class="text-2xl font-black text-royal-blue dark:text-blue-400 tracking-wide uppercase">GARUDA AMARTA</h2>
                    <h3 class="text-sm font-bold text-amber-600 dark:text-amber-400 tracking-widest uppercase">KARTU ANGGOTA ATLET</h3>
                </div>
            </div>

            <!-- Body Kartu -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 py-2">
                @php $fotoUrl = \App\Services\R2StorageService::url($student->photo); @endphp
                <div class="shrink-0">
                    @if ($fotoUrl)
                        <img src="{{ $fotoUrl }}" class="w-32 h-44 object-cover rounded-xl border-2 border-amber-500 shadow-md" alt="{{ $student->nama_lengkap }}" />
                    @else
                        <div class="w-32 h-44 rounded-xl bg-neutral-100 dark:bg-neutral-800 border-2 border-dashed border-neutral-300 dark:border-neutral-700 flex items-center justify-center text-xs text-neutral-400">
                            FOTO PROFIL (ATLET)
                        </div>
                    @endif
                </div>

                <div class="flex-1 w-full space-y-2.5 text-sm">
                    <div class="flex items-start">
                        <span class="w-36 text-neutral-500 font-semibold shrink-0">Nama Lengkap</span>
                        <span class="text-neutral-500 mr-2">:</span>
                        <strong class="text-neutral-900 dark:text-white font-bold">{{ $student->nama_lengkap }}</strong>
                    </div>

                    <div class="flex items-start">
                        <span class="w-36 text-neutral-500 font-semibold shrink-0">Tanggal Lahir</span>
                        <span class="text-neutral-500 mr-2">:</span>
                        <span class="text-neutral-800 dark:text-neutral-200">{{ $student->tanggal_lahir ? $student->tanggal_lahir->translatedFormat('d F Y') : '-' }}</span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-36 text-neutral-500 font-semibold shrink-0">Sabuk</span>
                        <span class="text-neutral-500 mr-2">:</span>
                        <strong class="text-neutral-900 dark:text-white font-bold">{{ $student->nama_sabuk }}</strong>
                    </div>

                    <div class="flex items-start">
                        <span class="w-36 text-neutral-500 font-semibold shrink-0">Ranting</span>
                        <span class="text-neutral-500 mr-2">:</span>
                        <span class="text-neutral-800 dark:text-neutral-200">{{ $student->account->nama_ranting ?? $student->account->ranting?->nm_ranting ?? '-' }}</span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-36 text-neutral-500 font-semibold shrink-0">Email</span>
                        <span class="text-neutral-500 mr-2">:</span>
                        <span class="text-neutral-800 dark:text-neutral-200">{{ $student->account->email ?? '-' }}</span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-36 text-neutral-500 font-semibold shrink-0">ID Position</span>
                        <span class="text-neutral-500 mr-2">:</span>
                        <span class="font-mono font-bold text-royal-blue dark:text-blue-400">{{ $student->account->id_position ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer & Tombol Download -->
            <div class="pt-4 border-t border-neutral-200 dark:border-neutral-800">
                <button wire:click="downloadPdf" class="w-full min-h-[48px] rounded-2xl bg-royal-blue hover:bg-blue-700 text-white font-bold text-sm shadow-lg inline-flex items-center justify-center gap-2 transition">
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>DOWNLOAD KARTU ANGGOTA (PDF)</span>
                </button>
            </div>
        </div>
    @else
        <div class="p-8 rounded-2xl bg-white dark:bg-neutral-900 border text-center text-neutral-400">
            <p>Akun ini tidak memiliki data atlet terkait.</p>
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
                    <h2 class="text-xl font-black text-neutral-900 dark:text-white">Pembaruan Kata Sandi Akun</h2>
                    <p class="text-xs text-neutral-600 dark:text-neutral-400">
                        Kata sandi Anda telah di-reset oleh sistem/administrator. Silakan masukkan kata sandi baru untuk mengamankan akun Anda.
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
                            Simpan Kata Sandi & Lanjutkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
