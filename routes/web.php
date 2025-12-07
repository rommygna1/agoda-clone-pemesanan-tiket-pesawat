<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AirlineController;
use App\Http\Controllers\Admin\AirportController;
use App\Http\Controllers\Admin\FlightController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- 1. ROUTE PUBLIK ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [BookingController::class, 'search'])->name('search');

// --- 2. ROUTE AUTH (USER LOGIN) ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // TRAFFIC CONTROLLER: Redirect berdasarkan ROLE
    Route::get('/dashboard', function () {
        $user = Auth::user();

        // PENTING: Menggunakan 'role', bukan 'usertype'
        if ($user->role === 'admin') { 
            return redirect()->route('admin.dashboard');
        }

        // User biasa tidak punya dashboard, kembali ke home
        return redirect()->route('home');
    })->name('dashboard');

    // Fitur Booking & Profile
    Route::get('/book/{flight_id}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/book', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{code}', [BookingController::class, 'show'])->name('booking.show');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- 3. ROUTE ADMIN (Middleware 'admin') ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('airlines', AirlineController::class);
    Route::resource('airports', AirportController::class);
    Route::resource('flights', FlightController::class);
});

require __DIR__.'/auth.php';