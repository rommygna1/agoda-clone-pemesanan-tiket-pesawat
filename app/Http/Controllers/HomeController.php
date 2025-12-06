<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use App\Models\Flight;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Menampilkan Halaman Depan
    public function index()
    {
        // Ambil data bandara untuk dropdown
        $airports = Airport::all();
        return view('welcome', compact('airports'));
    }

    // Memproses Pencarian Tiket
    public function search(Request $request)
    {
        // Validasi input
        $request->validate([
            'origin' => 'required',
            'destination' => 'required|different:origin',
            'date' => 'required|date',
        ]);

        // Query Pencarian
        $flights = Flight::with(['airline', 'origin', 'destination'])
            ->where('origin_airport_id', $request->origin)
            ->where('destination_airport_id', $request->destination)
            ->whereDate('departure_time', $request->date) // Filter berdasarkan tanggal
            ->where('available_seats', '>', 0) // Hanya tampilkan yang ada kursinya
            ->orderBy('price', 'asc') // Urutkan dari termurah
            ->get();

        return view('frontend.search', [
            'flights' => $flights,
            'origin' => Airport::find($request->origin),
            'destination' => Airport::find($request->destination),
            'date' => $request->date,
        ]);
    }
}