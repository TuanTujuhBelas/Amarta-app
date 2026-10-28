<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Welcome Banner -->
        <div class="bg-royal-blue text-white rounded-2xl p-5 sm:p-6 md:p-8 shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="min-w-0">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 text-[11px] sm:text-xs font-semibold text-white border border-white/25 mb-2">
                    <flux:icon.shield-check variant="micro" class="size-3.5" />
                    <span>Garuda Amarta</span>
                </div>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-black text-white break-words">
                    Selamat Datang, {{ auth()->user()->name ?? auth()->user()->nama ?? 'Pengguna' }}!
                </h1>
                <p class="text-blue-100 text-xs sm:text-sm mt-1">
                    Akun Anda telah masuk. Pilih menu di bawah untuk mulai menggunakan sistem.
                </p>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('profile.edit') }}" wire:navigate
                class="group bg-white dark:bg-neutral-900 p-5 sm:p-6 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm hover:border-royal-blue hover:shadow-md transition flex items-start gap-4">
                <span class="size-11 shrink-0 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-royal-blue flex items-center justify-center">
                    <flux:icon.user-circle variant="outline" class="size-6" />
                </span>
                <div class="min-w-0 flex-1">
                    <h2 class="font-bold text-neutral-900 dark:text-white group-hover:text-royal-blue transition">
                        Pengaturan Profil
                    </h2>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                        Perbarui nama, email, dan preferensi akun Anda.
                    </p>
                </div>
                <flux:icon.chevron-right variant="outline" class="size-5 text-neutral-300 group-hover:text-royal-blue transition" />
            </a>

            <a href="{{ route('security.edit') }}" wire:navigate
                class="group bg-white dark:bg-neutral-900 p-5 sm:p-6 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm hover:border-royal-blue hover:shadow-md transition flex items-start gap-4">
                <span class="size-11 shrink-0 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-royal-blue flex items-center justify-center">
                    <flux:icon.lock-closed variant="outline" class="size-6" />
                </span>
                <div class="min-w-0 flex-1">
                    <h2 class="font-bold text-neutral-900 dark:text-white group-hover:text-royal-blue transition">
                        Keamanan Akun
                    </h2>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                        Ubah kata sandi, aktifkan 2FA, kelola passkey.
                    </p>
                </div>
                <flux:icon.chevron-right variant="outline" class="size-5 text-neutral-300 group-hover:text-royal-blue transition" />
            </a>
        </div>

        <!-- Info Note -->
        <div class="p-4 rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 flex items-start gap-3">
            <span class="size-8 shrink-0 rounded-lg bg-blue-50 dark:bg-blue-950/40 text-royal-blue flex items-center justify-center">
                <flux:icon.information-circle variant="outline" class="size-5" />
            </span>
            <div class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400">
                <p class="font-semibold text-neutral-900 dark:text-white">Akun belum terhubung ke profil atlet/pelatih.</p>
                <p class="mt-0.5">
                    Jika Anda ingin mendaftar sebagai atlet,
                    <a href="{{ route('register.athlete') }}" class="font-semibold text-royal-blue hover:underline" wire:navigate>buka halaman registrasi</a>.
                    Hubungi admin jika akun seharusnya terhubung ke data lain.
                </p>
            </div>
        </div>
    </div>
</x-layouts::app>
