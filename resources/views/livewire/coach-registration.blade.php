<div class="w-full max-w-xl mx-auto">
    <!-- Header Garuda Amarta -->
    <div class="bg-royal-blue rounded-2xl p-6 text-white shadow-lg mb-6 text-center">
        <div class="inline-flex items-center justify-center size-14 rounded-full bg-white/10 mb-3">
            <svg class="size-8 text-vibrant-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
        </div>
        <h1 class="text-2xl font-black tracking-wider text-vibrant-yellow uppercase">GARUDA AMARTA</h1>
        <p class="text-sm text-blue-100 mt-1 font-medium">Registrasi Akun Pelatih / Instruktur Pencak Silat</p>

        <!-- Role Switcher Tab -->
        @if (!$isSuccess)
            <div class="mt-5 grid grid-cols-2 p-1 bg-blue-900/40 rounded-xl gap-1 text-xs font-bold">
                <a href="{{ route('register') }}" class="py-2.5 rounded-lg text-blue-200 hover:text-white transition text-center">
                    🥋 Daftar Sebagai Atlet
                </a>
                <span class="py-2.5 rounded-lg bg-vibrant-yellow text-neutral-900 shadow font-black text-center">
                    🧑‍🏫 Daftar Sebagai Pelatih
                </span>
            </div>
        @endif
    </div>

    @if ($isSuccess)
        <!-- Kartu Sukses Pendaftaran Pelatih -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl p-8 shadow-md border border-neutral-200 dark:border-neutral-800 text-center">
            <div class="size-16 rounded-full bg-emerald-100 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mx-auto mb-4">
                <svg class="size-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Pendaftaran Pelatih Berhasil!</h2>
            <p class="text-neutral-600 dark:text-neutral-400 mt-2 text-sm">
                Selamat bergabung, Pelatih <span class="font-semibold text-neutral-900 dark:text-white">{{ $registeredName }}</span>. Akun Anda telah aktif dan siap digunakan untuk mengelola data atlet.
            </p>

            <div class="mt-6 p-4 rounded-xl bg-neutral-50 dark:bg-neutral-800/60 border border-neutral-200 dark:border-neutral-700">
                <p class="text-xs uppercase tracking-wider text-neutral-500 font-bold">ID Pelatih Resmi:</p>
                <p class="text-2xl font-mono font-black text-royal-blue dark:text-blue-400 mt-1">{{ $registeredIdPosition }}</p>
                <p class="text-xs text-neutral-500 mt-1">Gunakan username dan password yang baru saja dibuat untuk masuk ke Dashboard Pelatih.</p>
            </div>

            <div class="mt-8">
                <a href="{{ route('login') }}" class="w-full min-h-[48px] inline-flex items-center justify-center rounded-xl bg-royal-blue text-white font-semibold hover:bg-blue-700 transition">
                    Menuju Halaman Login Pelatih
                </a>
            </div>
        </div>
    @else
        <!-- Form Pelatih -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl p-6 md:p-8 shadow-md border border-neutral-200 dark:border-neutral-800">
            <form wire:submit.prevent="submit" class="space-y-4">
                
                <div class="border-b pb-3 dark:border-neutral-800">
                    <h2 class="text-lg font-bold text-neutral-900 dark:text-white">Formulir Pendaftaran Pelatih</h2>
                    <p class="text-xs text-neutral-500 mt-0.5">Akun ini memiliki hak akses untuk memverifikasi atlet, meminta revisi, dan mengekspor dokumen.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Nama Lengkap & Gelar Pelatih <span class="text-crimson-red">*</span></label>
                    <input type="text" wire:model.defer="nama" placeholder="Contoh: Bambang Pamungkas, S.Pd." class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none" />
                    @error('nama') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Username Login <span class="text-crimson-red">*</span></label>
                        <input type="text" wire:model.defer="username" placeholder="Username unik" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none" />
                        @error('username') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Email Aktif <span class="text-crimson-red">*</span></label>
                        <input type="email" wire:model.defer="email" placeholder="pelatih@garudaamarta.com" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none" />
                        @error('email') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Password <span class="text-crimson-red">*</span></label>
                        <input type="password" wire:model.defer="password" placeholder="Minimal 6 karakter" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none" />
                        @error('password') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Ulangi Password <span class="text-crimson-red">*</span></label>
                        <input type="password" wire:model.defer="password_confirmation" placeholder="Konfirmasi password" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none" />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Ranting Tempat Melatih <span class="text-crimson-red">*</span></label>
                    <input type="text" wire:model.defer="nama_ranting" placeholder="Contoh: Ranting Pangkalan Jati, Mayora, Pusat" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none" />
                    @error('nama_ranting') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Alamat Domisili <span class="text-crimson-red">*</span></label>
                    <textarea wire:model.defer="alamat" rows="2" placeholder="Alamat tempat tinggal pelatih..." class="w-full p-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none"></textarea>
                    @error('alamat') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <!-- Foto Profil Pelatih -->
                <div class="p-4 rounded-xl border-2 border-dashed border-neutral-300 dark:border-neutral-700 text-center">
                    <label class="block text-sm font-bold text-neutral-800 dark:text-neutral-200 mb-2">Foto Profil Pelatih (Opsional)</label>
                    @if ($photo)
                        <img src="{{ $photo->temporaryUrl() }}" class="size-24 object-cover mx-auto rounded-full mb-2 shadow" />
                    @else
                        <div class="size-20 bg-neutral-100 dark:bg-neutral-800 rounded-full mx-auto flex items-center justify-center text-neutral-400 mb-2">
                            <svg class="size-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                    @endif
                    <input type="file" wire:model="photo" accept="image/*" class="text-xs text-neutral-500 file:mr-2 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-royal-blue file:text-white hover:file:bg-blue-700" />
                    @error('photo') <p class="text-xs text-crimson-red mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 border-t border-neutral-200 dark:border-neutral-800">
                    <button type="submit" wire:loading.attr="disabled" class="w-full min-h-[48px] px-8 rounded-xl bg-royal-blue hover:bg-blue-700 text-white font-bold transition flex items-center justify-center gap-2 disabled:opacity-50">
                        <span wire:loading.remove>Daftar Sebagai Pelatih</span>
                        <span wire:loading>Memproses Pendaftaran Pelatih...</span>
                    </button>
                </div>

                <div class="text-center pt-2">
                    <p class="text-xs text-neutral-500">
                        Sudah memiliki akun? <a href="{{ route('login') }}" class="font-semibold text-royal-blue dark:text-blue-400 hover:underline">Masuk di sini</a>
                    </p>
                </div>
            </form>
        </div>
    @endif
</div>
