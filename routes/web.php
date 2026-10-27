<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

// Registrasi Atlet & Pelatih
Route::get('/register', \App\Livewire\AthleteRegistration::class)->name('register');
Route::get('/register/atlet', \App\Livewire\AthleteRegistration::class)->name('register.athlete');
Route::get('/register/pelatih', \App\Livewire\CoachRegistration::class)->name('register.coach');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->isCoach()) {
            return redirect()->route('coach.dashboard');
        }
        return redirect()->route('student.dashboard');
    })->name('dashboard');

    Route::get('/coach/dashboard', \App\Livewire\CoachDashboard::class)->name('coach.dashboard');
    Route::get('/student/dashboard', \App\Livewire\StudentDashboard::class)->name('student.dashboard');
});

require __DIR__.'/settings.php';
