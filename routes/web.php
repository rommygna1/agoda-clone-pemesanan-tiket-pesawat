<?php

use App\Http\Controllers\HomeController; // Jangan lupa import ini
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AirlineController;
use App\Http\Controllers\Admin\AirportController;
use App\Http\Controllers\Admin\FlightController;
use Illuminate\Support\Facades\Route;

// --- ROUTE PUBLIK (FRONTEND) ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Route Dashboard User (Bawaan Breeze)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ... (Sisa route admin dan profile biarkan tetap sama seperti langkah sebelumnya)
// ...

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('airlines', AirlineController::class);
    Route::resource('airports', AirportController::class);
    Route::resource('flights', FlightController::class);
});

require __DIR__.'/auth.php';