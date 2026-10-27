<div class="w-full max-w-xl mx-auto">
    <!-- Header Garuda Amarta -->
    <div class="bg-royal-blue rounded-2xl p-6 text-white shadow-lg mb-6 text-center">
        <div class="inline-flex items-center justify-center size-14 rounded-full bg-white/10 mb-3">
            <svg class="size-8 text-vibrant-yellow" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
            </svg>
        </div>
        <h1 class="text-2xl font-black tracking-wider text-vibrant-yellow uppercase">GARUDA AMARTA</h1>
        <p class="text-sm text-blue-100 mt-1 font-medium">Sistem Registrasi & Manajemen Atlet Pencak Silat</p>

        @if (!$isSuccess)
            <!-- Progress Bar -->
            <div class="mt-5">
                <div class="flex justify-between items-center text-xs font-semibold mb-2 text-blue-200">
                    <span>Langkah {{ $currentStep }} dari {{ $totalSteps }}</span>
                    <span>
                        @if($currentStep === 1) Akun & Identitas
                        @elseif($currentStep === 2) Tingkat & Kategori
                        @elseif($currentStep === 3) Data Fisik & Wali
                        @elseif($currentStep === 4) Unggah Berkas Dokumen
                        @endif
                    </span>
                </div>
                <div class="w-full bg-white/20 h-2.5 rounded-full overflow-hidden">
                    <div class="bg-vibrant-yellow h-2.5 rounded-full transition-all duration-300" style="width: {{ ($currentStep / $totalSteps) * 100 }}%"></div>
                </div>
            </div>
        @endif
    </div>

    @if ($isSuccess)
        <!-- Kartu Sukses Pendaftaran -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl p-8 shadow-md border border-neutral-200 dark:border-neutral-800 text-center">
            <div class="size-16 rounded-full bg-emerald-100 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mx-auto mb-4">
                <svg class="size-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Pendaftaran Berhasil!</h2>
            <p class="text-neutral-600 dark:text-neutral-400 mt-2 text-sm">
                Selamat, <span class="font-semibold text-neutral-900 dark:text-white">{{ $registeredName }}</span>. Data Anda telah berhasil didaftarkan dan sedang menunggu verifikasi oleh pelatih.
            </p>

            <div class="mt-6 p-4 rounded-xl bg-neutral-50 dark:bg-neutral-800/60 border border-neutral-200 dark:border-neutral-700">
                <p class="text-xs uppercase tracking-wider text-neutral-500 font-bold">ID Position Resmi Anda:</p>
                <p class="text-2xl font-mono font-black text-royal-blue dark:text-blue-400 mt-1">{{ $registeredIdPosition }}</p>
                <p class="text-xs text-neutral-500 mt-1">Gunakan username dan password yang telah Anda buat untuk masuk.</p>
            </div>

            <div class="mt-8 flex flex-col gap-3">
                <a href="{{ route('login') }}" class="w-full min-h-[48px] inline-flex items-center justify-center rounded-xl bg-royal-blue text-white font-semibold hover:bg-blue-700 transition">
                    Menuju Halaman Login
                </a>
            </div>
        </div>
    @else
        <!-- Form Container -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl p-6 md:p-8 shadow-md border border-neutral-200 dark:border-neutral-800">
            <form wire:submit.prevent="{{ $currentStep === 4 ? 'submit' : 'nextStep' }}">
                
                <!-- STEP 1: Akun & Identitas Utama -->
                @if ($currentStep === 1)
                    <div class="space-y-4">
                        <h2 class="text-lg font-bold text-neutral-900 dark:text-white border-b pb-2 dark:border-neutral-800">
                            1. Informasi Akun & Domisili
                        </h2>

                        <div>
                            <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Nama Panggilan / Akun <span class="text-crimson-red">*</span></label>
                            <input type="text" wire:model.defer="nama" placeholder="Contoh: Ahmad" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none" />
                            @error('nama') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Username <span class="text-crimson-red">*</span></label>
                                <input type="text" wire:model.defer="username" placeholder="Username unik (tanpa spasi)" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none" />
                                @error('username') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Email Aktif <span class="text-crimson-red">*</span></label>
                                <input type="email" wire:model.defer="email" placeholder="nama@email.com" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none" />
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
                            <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Ranting Latihan <span class="text-crimson-red">*</span></label>
                            <select wire:model.defer="id_ranting" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none">
                                <option value="">-- Pilih Ranting Latihan --</option>
                                @foreach($rantings as $ranting)
                                    <option value="{{ $ranting->id_ranting }}">{{ $ranting->nm_ranting }}</option>
                                @endforeach
                            </select>
                            @error('id_ranting') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Alamat Domisili Lengkap <span class="text-crimson-red">*</span></label>
                            <textarea wire:model.defer="alamat" rows="2" placeholder="Nama jalan, RT/RW, kelurahan, kecamatan, kota..." class="w-full p-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none"></textarea>
                            @error('alamat') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                @endif

                <!-- STEP 2: Tingkat & Kategori Atlet -->
                @if ($currentStep === 2)
                    <div class="space-y-4">
                        <h2 class="text-lg font-bold text-neutral-900 dark:text-white border-b pb-2 dark:border-neutral-800">
                            2. Kualifikasi & Tingkat Atlet
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Tingkat Sabuk Saat Ini <span class="text-crimson-red">*</span></label>
                                <select wire:model.defer="tingkat_sabuk" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none">
                                    <option value="Putih 001">Putih (001)</option>
                                    <option value="Kuning 002">Kuning (002)</option>
                                    <option value="Merah 003">Merah (003)</option>
                                    <option value="Biru 005">Biru (005)</option>
                                    <option value="Cokelat 006">Cokelat (006)</option>
                                    <option value="Hitam 007">Hitam (007)</option>
                                </select>
                                @error('tingkat_sabuk') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Jenis Kelamin <span class="text-crimson-red">*</span></label>
                                <select wire:model.defer="gender" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none">
                                    <option value="male">Laki-laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                                @error('gender') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Tingkat Sekolah <span class="text-crimson-red">*</span></label>
                                <select wire:model.live="tingkat" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none">
                                    <option value="TK">TK</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="Universitas">Universitas</option>
                                </select>
                                @error('tingkat') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">
                                    Kategori Tanding
                                    @if($tingkat !== 'SD')
                                        <span class="text-xs font-normal text-emerald-600 dark:text-emerald-400">(Terkunci Otomatis)</span>
                                    @else
                                        <span class="text-xs font-normal text-royal-blue dark:text-blue-400">(Pilihan Manual SD)</span>
                                    @endif
                                </label>
                                
                                @if ($tingkat === 'SD')
                                    <select wire:model.defer="kategori" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none">
                                        <option value="UD1">Usia Dini 1 (UD1)</option>
                                        <option value="UD2">Usia Dini 2 (UD2)</option>
                                    </select>
                                @else
                                    <input type="text" value="{{ $kategori }}" readonly class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-200 dark:border-neutral-800 bg-neutral-100 dark:bg-neutral-800/60 text-neutral-700 dark:text-neutral-300 cursor-not-allowed font-semibold" />
                                @endif
                                @error('kategori') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Kelas Pertandingan <span class="text-crimson-red">*</span></label>
                                <select wire:model.defer="kelas" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none">
                                    <option value="Tanding">Tanding</option>
                                    <option value="Tunggal">Tunggal (Seni)</option>
                                    <option value="Ganda">Ganda (Seni)</option>
                                    <option value="Regu">Regu (Seni)</option>
                                </select>
                                @error('kelas') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Nama Sekolah / Kampus <span class="text-crimson-red">*</span></label>
                                <input type="text" wire:model.defer="nama_sekolah" placeholder="Contoh: SDN Pangkalan Jati 01" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none" />
                                @error('nama_sekolah') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                @endif

                <!-- STEP 3: Fisik & Data Orang Tua -->
                @if ($currentStep === 3)
                    <div class="space-y-4">
                        <h2 class="text-lg font-bold text-neutral-900 dark:text-white border-b pb-2 dark:border-neutral-800">
                            3. Data Fisik & Kontak Orang Tua
                        </h2>

                        <div>
                            <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Nama Lengkap Atlet (Sesuai Akte) <span class="text-crimson-red">*</span></label>
                            <input type="text" wire:model.defer="nama_lengkap" placeholder="Nama lengkap siswa" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none" />
                            @error('nama_lengkap') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Tanggal Lahir <span class="text-crimson-red">*</span></label>
                                <input type="date" wire:model.defer="tanggal_lahir" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none" />
                                @error('tanggal_lahir') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Berat Badan (Kg) <span class="text-crimson-red">*</span></label>
                                <input type="number" step="0.1" wire:model.defer="berat_badan" placeholder="Contoh: 42.5" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none" />
                                @error('berat_badan') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Tinggi Badan (Cm) <span class="text-crimson-red">*</span></label>
                                <input type="number" step="0.1" wire:model.defer="tinggi_badan" placeholder="Contoh: 155.0" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none" />
                                @error('tinggi_badan') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Nama Orang Tua / Wali <span class="text-crimson-red">*</span></label>
                                <input type="text" wire:model.defer="nama_ortu" placeholder="Nama ayah / ibu / wali" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none" />
                                @error('nama_ortu') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">No. WhatsApp / HP Ortu <span class="text-crimson-red">*</span></label>
                                <input type="text" wire:model.defer="no_ortu" placeholder="08xxxxxxxxxx" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none" />
                                @error('no_ortu') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Nomor NIK / KIA (16 Digit) <span class="text-crimson-red">*</span></label>
                                <input type="text" maxlength="16" wire:model.defer="nik_kia" placeholder="16 digit NIK atau KIA" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none font-mono" />
                                @error('nik_kia') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Nomor Kartu Keluarga (16 Digit) <span class="text-crimson-red">*</span></label>
                                <input type="text" maxlength="16" wire:model.defer="no_kk" placeholder="16 digit nomor KK" class="w-full min-h-[48px] px-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-royal-blue outline-none font-mono" />
                                @error('no_kk') <p class="text-xs text-crimson-red mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                @endif

                <!-- STEP 4: Upload Dokumen R2 -->
                @if ($currentStep === 4)
                    <div class="space-y-4">
                        <h2 class="text-lg font-bold text-neutral-900 dark:text-white border-b pb-2 dark:border-neutral-800">
                            4. Unggah Berkas & Dokumen Atlet
                        </h2>
                        <p class="text-xs text-neutral-500">Format: JPG/PNG/WebP, maksimal 5MB per berkas. Gambar akan otomatis dioptimasi di server.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Foto Profil -->
                            <div class="p-4 rounded-xl border-2 border-dashed border-neutral-300 dark:border-neutral-700 text-center">
                                <label class="block text-sm font-bold text-neutral-800 dark:text-neutral-200 mb-2">Foto Profil Atlet <span class="text-crimson-red">*</span></label>
                                @if ($photo)
                                    <img src="{{ $photo->temporaryUrl() }}" class="w-24 h-32 object-cover mx-auto rounded-lg mb-2 shadow" />
                                @else
                                    <div class="size-20 bg-neutral-100 dark:bg-neutral-800 rounded-full mx-auto flex items-center justify-center text-neutral-400 mb-2">
                                        <svg class="size-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                @endif
                                <input type="file" wire:model="photo" accept="image/*" class="text-xs text-neutral-500 file:mr-2 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-royal-blue file:text-white hover:file:bg-blue-700" />
                                @error('photo') <p class="text-xs text-crimson-red mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Foto Kartu Keluarga -->
                            <div class="p-4 rounded-xl border-2 border-dashed border-neutral-300 dark:border-neutral-700 text-center">
                                <label class="block text-sm font-bold text-neutral-800 dark:text-neutral-200 mb-2">Foto Kartu Keluarga (KK) <span class="text-crimson-red">*</span></label>
                                @if ($photo_kk)
                                    <img src="{{ $photo_kk->temporaryUrl() }}" class="w-32 h-20 object-cover mx-auto rounded-lg mb-2 shadow" />
                                @else
                                    <div class="size-20 bg-neutral-100 dark:bg-neutral-800 rounded-lg mx-auto flex items-center justify-center text-neutral-400 mb-2">
                                        <svg class="size-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                @endif
                                <input type="file" wire:model="photo_kk" accept="image/*" class="text-xs text-neutral-500 file:mr-2 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-royal-blue file:text-white hover:file:bg-blue-700" />
                                @error('photo_kk') <p class="text-xs text-crimson-red mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Foto Akte / KIA -->
                            <div class="p-4 rounded-xl border-2 border-dashed border-neutral-300 dark:border-neutral-700 text-center">
                                <label class="block text-sm font-bold text-neutral-800 dark:text-neutral-200 mb-2">Foto Akte Kelahiran / KIA <span class="text-crimson-red">*</span></label>
                                @if ($photo_akte_kia)
                                    <img src="{{ $photo_akte_kia->temporaryUrl() }}" class="w-32 h-20 object-cover mx-auto rounded-lg mb-2 shadow" />
                                @else
                                    <div class="size-20 bg-neutral-100 dark:bg-neutral-800 rounded-lg mx-auto flex items-center justify-center text-neutral-400 mb-2">
                                        <svg class="size-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                                    </div>
                                @endif
                                <input type="file" wire:model="photo_akte_kia" accept="image/*" class="text-xs text-neutral-500 file:mr-2 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-royal-blue file:text-white hover:file:bg-blue-700" />
                                @error('photo_akte_kia') <p class="text-xs text-crimson-red mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Foto Surat Sehat -->
                            <div class="p-4 rounded-xl border-2 border-dashed border-neutral-300 dark:border-neutral-700 text-center">
                                <label class="block text-sm font-bold text-neutral-800 dark:text-neutral-200 mb-2">Foto Surat Keterangan Sehat <span class="text-crimson-red">*</span></label>
                                @if ($photo_surat_sehat)
                                    <img src="{{ $photo_surat_sehat->temporaryUrl() }}" class="w-32 h-20 object-cover mx-auto rounded-lg mb-2 shadow" />
                                @else
                                    <div class="size-20 bg-neutral-100 dark:bg-neutral-800 rounded-lg mx-auto flex items-center justify-center text-neutral-400 mb-2">
                                        <svg class="size-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    </div>
                                @endif
                                <input type="file" wire:model="photo_surat_sehat" accept="image/*" class="text-xs text-neutral-500 file:mr-2 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-royal-blue file:text-white hover:file:bg-blue-700" />
                                @error('photo_surat_sehat') <p class="text-xs text-crimson-red mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Navigation Buttons (Touch-Friendly min 48px) -->
                <div class="mt-8 pt-4 border-t border-neutral-200 dark:border-neutral-800 flex items-center justify-between gap-3">
                    @if ($currentStep > 1)
                        <button type="button" wire:click="prevStep" class="min-h-[48px] px-6 rounded-xl border border-neutral-300 dark:border-neutral-700 text-neutral-700 dark:text-neutral-200 font-semibold hover:bg-neutral-100 dark:hover:bg-neutral-800 transition">
                            Kembali
                        </button>
                    @else
                        <div></div>
                    @endif

                    @if ($currentStep < $totalSteps)
                        <button type="submit" class="min-h-[48px] px-8 rounded-xl bg-royal-blue text-white font-semibold hover:bg-blue-700 transition flex items-center gap-2">
                            <span>Lanjut</span>
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    @else
                        <button type="submit" wire:loading.attr="disabled" class="min-h-[48px] px-8 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold transition flex items-center gap-2 disabled:opacity-50">
                            <span wire:loading.remove>Selesai & Daftar</span>
                            <span wire:loading>Memproses Pendaftaran...</span>
                        </button>
                    @endif
                </div>
            </form>
        </div>
    @endif
</div>
