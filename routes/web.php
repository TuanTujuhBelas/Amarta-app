<?php

use App\Livewire\AthleteRegistration;
use App\Livewire\CoachDashboard;
use App\Livewire\CoachRegistration;
use App\Livewire\StudentDashboard;
use App\Models\Account;
use App\Services\R2StorageService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::view('/', 'welcome')->name('home');

// Registrasi Atlet & Pelatih
Route::get('/register', AthleteRegistration::class)->name('register');
Route::get('/register/atlet', AthleteRegistration::class)->name('register.athlete');
Route::get('/register/pelatih', CoachRegistration::class)->name('register.coach');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user instanceof Account) {
            return $user->isCoach()
                ? redirect()->route('coach.dashboard')
                : redirect()->route('student.dashboard');
        }

        return view('dashboard');
    })->name('dashboard');

    Route::get('/coach/dashboard', CoachDashboard::class)->name('coach.dashboard');
    Route::get('/student/dashboard', StudentDashboard::class)->name('student.dashboard');

    // Secure Document Viewer (Streams from R2 / Storage with Auth Protection)
    Route::get('/document/{path}', function (string $path) {
        $disk = R2StorageService::disk();
        if (! Storage::disk($disk)->exists($path)) {
            abort(404);
        }

        return Storage::disk($disk)->response($path);
    })->where('path', '.*')->name('document.view');
});

require __DIR__.'/settings.php';
