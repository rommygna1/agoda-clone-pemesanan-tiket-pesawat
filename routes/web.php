<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AirlineController;
use App\Http\Controllers\Admin\AirportController;
use App\Http\Controllers\Admin\FlightController;
use App\Http\Controllers\Admin\TransactionController; // [BARU] Import Controller Transaksi
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- 1. ROUTE PUBLIK ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [BookingController::class, 'search'])->name('search');

// --- 2. ROUTE AUTH (USER LOGIN) ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Redirect Dashboard
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role === 'admin') { 
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    })->name('dashboard');

    // --- FITUR BOOKING & DASHBOARD USER ---
    
    // Halaman Pesanan Saya (My Bookings) - Agoda Style
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('booking.index');
    
    // Proses Booking
    Route::get('/book/{flight_id}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/book', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{code}', [BookingController::class, 'show'])->name('booking.show');
    
    // Profil User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- 3. ROUTE ADMIN ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Resource Standar
    Route::resource('airlines', AirlineController::class);
    Route::resource('airports', AirportController::class);
    Route::resource('flights', FlightController::class);

    // [BARU] MANAJEMEN TRANSAKSI
    // Melihat semua transaksi
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    // Konfirmasi Pembayaran Manual (Terima)
    Route::patch('/transactions/{id}/confirm', [TransactionController::class, 'confirm'])->name('transactions.confirm');
    // Batalkan Pesanan Manual (Tolak)
    Route::delete('/transactions/{id}/cancel', [TransactionController::class, 'destroy'])->name('transactions.cancel');
});

require __DIR__.'/auth.php';