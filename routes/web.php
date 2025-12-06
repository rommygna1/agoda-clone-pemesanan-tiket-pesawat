<?php

use App\Http\Controllers\HomeController; 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController; 
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AirlineController;
use App\Http\Controllers\Admin\AirportController;
use App\Http\Controllers\Admin\FlightController;
use Illuminate\Support\Facades\Route;
use App\Models\Airport; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- ROUTE PUBLIK (FRONTEND) ---

// Halaman Utama: Mengirim data bandara untuk dropdown search
Route::get('/', function () {
    $airports = Airport::all();
    return view('welcome', compact('airports'));
})->name('home');

// Pencarian Penerbangan (Menggunakan BookingController sesuai Langkah 5)
Route::get('/search', [BookingController::class, 'search'])->name('search');


// --- ROUTE AUTH (USER LOGIN) ---
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard User
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // === BOOKING FLOW (LANGKAH 5) ===
    // 1. Form Booking (Isi data penumpang)
    Route::get('/book/{flight_id}', [BookingController::class, 'create'])->name('booking.create');
    
    // 2. Proses Simpan Booking (Checkout Database Transaction)
    Route::post('/book', [BookingController::class, 'store'])->name('booking.store');
    
    // 3. Halaman Sukses / Detail Tiket
    Route::get('/booking/{code}', [BookingController::class, 'show'])->name('booking.show');
    // =================================

    // Profile Routes (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// --- ROUTE ADMIN ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('airlines', AirlineController::class);
    Route::resource('airports', AirportController::class);
    Route::resource('flights', FlightController::class);
});

require __DIR__.'/auth.php';