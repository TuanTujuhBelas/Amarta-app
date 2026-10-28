<div class="w-full max-w-2xl mx-auto">
    <!-- Header Garuda Amarta -->
    <div class="bg-royal-blue rounded-2xl p-5 sm:p-6 text-white shadow-lg mb-6 text-center">
        <div class="inline-flex items-center justify-center size-14 rounded-full bg-white/10 mb-3 text-white">
            <flux:icon.academic-cap variant="outline" class="size-8" />
        </div>
        <h1 class="text-xl sm:text-2xl font-black tracking-wider text-white uppercase">GARUDA AMARTA</h1>
        <p class="text-xs sm:text-sm text-blue-100 mt-1 font-medium">Sistem Registrasi & Manajemen Atlet Pencak Silat</p>

        @if (!$isSuccess)
            <!-- Visual Stepper -->
            @php
                $stepLabels = [
                    1 => 'Akun',
                    2 => 'Kategori',
                    3 => 'Data Fisik',
                    4 => 'Berkas',
                ];
            @endphp
            <div class="mt-6" aria-label="Progress Pendaftaran">
                <ol class="flex items-center justify-between gap-1.5 sm:gap-2">
                    @for ($i = 1; $i <= $totalSteps; $i++)
                        @php
                            $isDone = $i < $currentStep;
                            $isActive = $i === $currentStep;
                        @endphp
                        <li class="flex-1 flex flex-col items-center min-w-0" aria-current="{{ $isActive ? 'step' : 'false' }}">
                            <div class="w-full flex items-center">
                                <div class="h-1 flex-1 rounded-full {{ $i === 1 ? 'bg-transparent' : ($isDone || $isActive ? 'bg-white' : 'bg-white/20') }}"></div>
                                <div class="shrink-0 size-7 sm:size-8 rounded-full flex items-center justify-center text-xs font-black border-2 transition
                                    {{ $isDone ? 'bg-blue-100 border-blue-100 text-royal-blue'
                                       : ($isActive ? 'bg-white border-white text-royal-blue ring-4 ring-white/25 scale-110'
                                       : 'bg-white/10 border-white/25 text-blue-200') }}">
                                    @if ($isDone)
                                        <flux:icon.check variant="micro" class="size-4" />
                                    @else
                                        {{ $i }}
                                    @endif
                                </div>
                                <div class="h-1 flex-1 rounded-full {{ $i === $totalSteps ? 'bg-transparent' : ($isDone ? 'bg-white' : 'bg-white/20') }}"></div>
                            </div>
                            <span class="mt-1.5 text-[10px] sm:text-[11px] font-semibold truncate max-w-full {{ $isActive ? 'text-white' : 'text-blue-200' }}">
                                {{ $stepLabels[$i] }}
                            </span>
                        </li>
                    @endfor
                </ol>
                <p class="mt-3 text-[11px] sm:text-xs text-blue-100 font-medium">
                    Langkah {{ $currentStep }} dari {{ $totalSteps }} —
                    @if($currentStep === 1) Akun & Identitas
                    @elseif($currentStep === 2) Tingkat & Kategori
                    @elseif($currentStep === 3) Data Fisik & Wali
                    @elseif($currentStep === 4) Unggah Berkas Dokumen
                    @endif
                </p>
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

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @php
                                $uploads = [
                                    ['field' => 'photo',              'label' => 'Foto Profil Atlet',             'icon' => 'user-circle',  'preview_class' => 'w-24 h-32'],
                                    ['field' => 'photo_kk',           'label' => 'Foto Kartu Keluarga (KK)',      'icon' => 'users',        'preview_class' => 'w-32 h-20'],
                                    ['field' => 'photo_akte_kia',     'label' => 'Foto Akte Kelahiran / KIA',     'icon' => 'identification','preview_class' => 'w-32 h-20'],
                                    ['field' => 'photo_surat_sehat',  'label' => 'Foto Surat Keterangan Sehat',   'icon' => 'heart',        'preview_class' => 'w-32 h-20'],
                                ];
                            @endphp
                            @foreach($uploads as $up)
                                @php $file = ${$up['field']}; @endphp
                                <div class="p-4 rounded-xl border-2 border-dashed border-neutral-300 dark:border-neutral-700 text-center space-y-2.5">
                                    <label class="block text-sm font-bold text-neutral-800 dark:text-neutral-200">
                                        {{ $up['label'] }} <span class="text-crimson-red">*</span>
                                    </label>

                                    @if ($file)
                                        <img src="{{ $file->temporaryUrl() }}" class="{{ $up['preview_class'] }} object-cover mx-auto rounded-lg shadow" alt="Preview {{ $up['label'] }}" />
                                    @else
                                        <div class="size-20 bg-neutral-100 dark:bg-neutral-800 rounded-xl mx-auto flex items-center justify-center text-neutral-400">
                                            <flux:icon :icon="$up['icon']" variant="outline" class="size-10" />
                                        </div>
                                    @endif

                                    <label class="w-full min-h-[44px] inline-flex items-center justify-center gap-2 px-4 rounded-xl bg-royal-blue hover:bg-blue-700 text-white font-semibold text-xs cursor-pointer transition">
                                        <flux:icon.cloud-arrow-up variant="outline" class="size-4" />
                                        <span>{{ $file ? 'Ganti Berkas' : 'Pilih Berkas' }}</span>
                                        <input type="file" wire:model="{{ $up['field'] }}" accept="image/*" class="sr-only" />
                                    </label>

                                    <div wire:loading wire:target="{{ $up['field'] }}" class="text-[11px] text-neutral-500">
                                        Mengunggah...
                                    </div>

                                    @error($up['field']) <p class="text-xs text-crimson-red">{{ $message }}</p> @enderror
                                </div>
                            @endforeach
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
