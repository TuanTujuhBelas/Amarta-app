<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Menu')" class="grid">
                    @if(auth()->user() instanceof \App\Models\Account && auth()->user()->isStudent())
                        <flux:sidebar.item icon="identification" :href="route('student.dashboard')" :current="request()->routeIs('student.dashboard')" wire:navigate>
                            {{ __('Portal & KTA Atlet') }}
                        </flux:sidebar.item>
                    @else
                        <flux:sidebar.item icon="home" :href="route('coach.dashboard')" :current="request()->routeIs('coach.dashboard') || request()->routeIs('dashboard')" wire:navigate>
                            {{ __('Verifikasi Atlet') }}
                        </flux:sidebar.item>
                    @endif
                </flux:sidebar.group>

                @if(auth()->user() instanceof \App\Models\Account && auth()->user()->isSuperAdmin())
                    <flux:sidebar.group :heading="__('Super Admin')" class="grid">
                        <flux:sidebar.item icon="building-office-2" :href="route('superadmin.ranting')" :current="request()->routeIs('superadmin.ranting') || (request()->routeIs('superadmin.dashboard') && !request()->routeIs('superadmin.transfer') && !request()->routeIs('superadmin.reset_password') && !request()->routeIs('superadmin.logs'))" wire:navigate>
                            {{ __('Master Ranting') }}
                        </flux:sidebar.item>

                        <flux:sidebar.item icon="arrows-right-left" :href="route('superadmin.transfer')" :current="request()->routeIs('superadmin.transfer')" wire:navigate>
                            {{ __('Mutasi Anggota') }}
                        </flux:sidebar.item>

                        <flux:sidebar.item icon="key" :href="route('superadmin.reset_password')" :current="request()->routeIs('superadmin.reset_password')" wire:navigate>
                            {{ __('Reset Password') }}
                        </flux:sidebar.item>

                        <flux:sidebar.item icon="clipboard-document-list" :href="route('superadmin.logs')" :current="request()->routeIs('superadmin.logs')" wire:navigate>
                            {{ __('Audit Trail Log') }}
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                @endif
            </flux:sidebar.nav>

            <flux:spacer />

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Pengaturan') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Keluar') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
