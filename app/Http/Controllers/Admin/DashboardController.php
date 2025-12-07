<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Import Model agar bisa baca Database
use App\Models\Airline;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Total Data (Realtime dari Database)
        $totalAirlines = Airline::count();
        $totalAirports = Airport::count();
        $totalFlights  = Flight::count();
        $totalBookings = Booking::count(); // Masih 0 di database Anda, tapi tetap kita pasang

        // 2. Ambil 5 Penerbangan Terbaru untuk ditampilkan di Tabel
        $recentFlights = Flight::with(['airline', 'origin', 'destination'])
                               ->latest()
                               ->take(5)
                               ->get();

        // 3. Kirim data ke View
        return view('admin.dashboard', compact(
            'totalAirlines', 
            'totalAirports', 
            'totalFlights', 
            'totalBookings',
            'recentFlights'
        ));
    }
}