<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Booking;
use App\Models\Passenger;
use App\Models\Airport;
use App\Models\Airline; // [PENTING] Tambahkan Model Airline
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * LOGIC 1: HASIL PENCARIAN (ADVANCED & AJAX SUPPORT)
     * Mendukung filter Sidebar (Harga, Waktu, Maskapai) dan Global Search.
     */
    public function search(Request $request)
    {
        // 1. Data Dasar
        $airports = Airport::all();
        $minPriceDb = Flight::min('price') ?? 0;
        $maxPriceDb = Flight::max('price') ?? 20000000;

        // 2. Query Builder Utama
        $query = Flight::with(['airline', 'origin', 'destination']);

        // --- FILTER RUTE (Wajib) ---
        if ($request->origin) {
            $query->where('origin_airport_id', $request->origin);
        }
        if ($request->destination) {
            $query->where('destination_airport_id', $request->destination);
        }

        // --- FILTER PENUMPANG (Stok Kursi) ---
        $passengers = $request->input('passengers', 1);
        $query->where('available_seats', '>=', $passengers);

        // --- GLOBAL DATE SEARCH (Mulai dari tanggal ini ke depan) ---
        $searchDate = $request->date ? $request->date : now()->format('Y-m-d');
        $query->whereDate('departure_time', '>=', $searchDate);

        // =========================================================
        // FILTER LANJUTAN (Sesuai Sidebar View Anda)
        // =========================================================

        // 1. Filter Maskapai (Array)
        if ($request->has('airlines') && is_array($request->airlines)) {
            $query->whereIn('airline_id', $request->airlines);
        }

        // 2. Filter Harga (Min & Max)
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // 3. Filter Waktu Keberangkatan (Jam)
        if ($request->filled('dep_start') && $request->filled('dep_end')) {
            $query->whereTime('departure_time', '>=', $request->dep_start . ':00')
                  ->whereTime('departure_time', '<=', $request->dep_end . ':59');
        }

        // 4. Filter Waktu Kedatangan (Jam)
        if ($request->filled('arr_start') && $request->filled('arr_end')) {
            $query->whereTime('arrival_time', '>=', $request->arr_start . ':00')
                  ->whereTime('arrival_time', '<=', $request->arr_end . ':59');
        }

        // 5. Filter Durasi (Jam)
        if ($request->filled('max_duration')) {
            // Menghitung selisih waktu dalam jam di Database
            $query->whereRaw('TIMESTAMPDIFF(HOUR, departure_time, arrival_time) <= ?', [$request->max_duration]);
        }

        // --- SORTING ---
        $sort = $request->input('sort', 'cheapest');
        switch ($sort) {
            case 'cheapest': $query->orderBy('price', 'asc'); break;
            case 'earliest': $query->orderBy('departure_time', 'asc'); break;
            case 'latest':   $query->orderBy('departure_time', 'desc'); break;
            default:         $query->orderBy('price', 'asc');
        }

        // Eksekusi Query
        $flights = $query->paginate(10)->withQueryString();

        // [LOGIC AJAX] Jika request dari Javascript (Alpine.js), kembalikan partial view saja
        if ($request->ajax()) {
            return view('frontend.partials.flight-list', compact('flights'))->render();
        }

        // [LOGIC BIASA] Jika request halaman penuh
        // Ambil maskapai yang tersedia untuk rute ini saja (Smart Filter)
        $availableAirlines = Airline::whereHas('flights', function($q) use ($request, $searchDate) {
            if($request->origin) $q->where('origin_airport_id', $request->origin);
            if($request->destination) $q->where('destination_airport_id', $request->destination);
            $q->whereDate('departure_time', '>=', $searchDate);
        })->get();

        return view('frontend.search', compact('flights', 'airports', 'availableAirlines', 'minPriceDb', 'maxPriceDb'));
    }

    /**
     * LOGIC 2: FORM BOOKING
     */
    public function create(Request $request, $flight_id)
    {
        // Keamanan: Wajib Login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $flight = Flight::with(['airline', 'origin', 'destination'])->findOrFail($flight_id);
        $passengersCount = $request->query('passengers', 1);

        return view('frontend.book', compact('flight', 'passengersCount'));
    }

    /**
     * LOGIC 3: PROSES CHECKOUT (TRANSAKSI DATABASE)
     */
    public function store(Request $request)
    {
        $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'passengers' => 'required|array',
            'passengers.*.title' => 'required|string',
            'passengers.*.first_name' => 'required|string',
            'passengers.*.last_name' => 'required|string',
            'passengers.*.nationality' => 'required|string',
            'passengers.*.date_of_birth' => 'required|date',
        ]);

        $flight = Flight::findOrFail($request->flight_id);
        $totalPassengers = count($request->passengers);
        $totalPrice = $flight->price * $totalPassengers;

        // Cek Stok Terakhir
        if ($flight->available_seats < $totalPassengers) {
            return back()->with('error', 'Maaf, kursi tidak cukup.');
        }

        try {
            return DB::transaction(function () use ($request, $flight, $totalPrice, $totalPassengers) {
                
                // A. Buat Booking
                $bookingCode = 'AGD-' . strtoupper(Str::random(6));
                $booking = Booking::create([
                    'user_id' => Auth::id(),
                    'flight_id' => $flight->id,
                    'booking_code' => $bookingCode,
                    'total_passengers' => $totalPassengers,
                    'total_amount' => $totalPrice,
                    'status' => 'pending',
                ]);

                // B. Simpan Penumpang
                foreach ($request->passengers as $paxData) {
                    Passenger::create([
                        'booking_id' => $booking->id,
                        'title' => $paxData['title'],
                        'first_name' => $paxData['first_name'],
                        'last_name' => $paxData['last_name'],
                        'date_of_birth' => $paxData['date_of_birth'],
                        'nationality' => $paxData['nationality'],
                        'passport_number' => $paxData['passport_number'] ?? null,
                    ]);
                }

                // C. Kurangi Stok
                $flight->decrement('available_seats', $totalPassengers);

                return redirect()->route('booking.show', $booking->booking_code)
                    ->with('success', 'Booking berhasil dibuat!');
            });

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * LOGIC 4: DETAIL BOOKING / TIKET
     */
    public function show($code)
    {
        $booking = Booking::where('booking_code', $code)
            ->with(['flight.airline', 'flight.origin', 'flight.destination', 'passengers'])
            ->firstOrFail();

        // Proteksi Akses
        if ($booking->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('frontend.booking-success', compact('booking'));
    }
}