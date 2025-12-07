<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Booking;
use App\Models\Passenger;
use App\Models\Airport;
use App\Models\Airline; // Tambahkan Model Airline
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * LOGIC 1: HASIL PENCARIAN (ADVANCED & GLOBAL)
     * Menampilkan daftar penerbangan dengan Filter & Sorting.
     */
    public function search(Request $request)
    {
        // 1. Ambil Data Dasar untuk Dropdown (agar tidak error di view)
        $airports = Airport::all();

        // 2. Query Builder Utama
        $query = Flight::with(['airline', 'origin', 'destination']);

        // --- FILTER RUTE (Wajib) ---
        if ($request->origin) {
            $query->where('origin_airport_id', $request->origin);
        }
        if ($request->destination) {
            $query->where('destination_airport_id', $request->destination);
        }

        // --- FILTER JUMLAH PENUMPANG ---
        // Hanya tampilkan penerbangan yang sisa kursinya cukup
        $passengers = $request->input('passengers', 1);
        $query->where('available_seats', '>=', $passengers);

        // --- FILTER TANGGAL (GLOBAL SEARCH) ---
        // Mencari penerbangan mulai dari tanggal yang dipilih ke masa depan
        $searchDate = $request->date ? $request->date : now()->format('Y-m-d');
        $query->whereDate('departure_time', '>=', $searchDate);

        // --- FILTER TAMBAHAN (Maskapai & Harga) ---
        if ($request->has('airlines') && is_array($request->airlines)) {
            $query->whereIn('airline_id', $request->airlines);
        }
        if ($request->has('min_price') && $request->min_price != null) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price != null) {
            $query->where('price', '<=', $request->max_price);
        }

        // --- SORTING (Pengurutan) ---
        $sort = $request->input('sort', 'cheapest');
        switch ($sort) {
            case 'cheapest':
                $query->orderBy('price', 'asc');
                break;
            case 'earliest':
                $query->orderBy('departure_time', 'asc');
                break;
            case 'latest':
                $query->orderBy('departure_time', 'desc');
                break;
            default:
                $query->orderBy('price', 'asc');
        }

        // Eksekusi Query dengan Pagination
        $flights = $query->paginate(10)->withQueryString();

        // Ambil daftar maskapai yang TERSEDIA saja untuk sidebar filter
        $availableAirlines = Airline::whereHas('flights', function($q) use ($request, $searchDate) {
            if($request->origin) $q->where('origin_airport_id', $request->origin);
            if($request->destination) $q->where('destination_airport_id', $request->destination);
            $q->whereDate('departure_time', '>=', $searchDate);
        })->get();

        // Kirim data ke View 'frontend.search'
        return view('frontend.search', compact('flights', 'airports', 'availableAirlines', 'passengers'));
    }

    /**
     * LOGIC 2: FORM BOOKING
     * Menampilkan halaman pengisian data penumpang.
     */
    public function create(Request $request, $flight_id)
    {
        // Pastikan User Login Sebelum Booking
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $flight = Flight::with(['airline', 'origin', 'destination'])->findOrFail($flight_id);
        
        // Ambil jumlah penumpang dari URL (default 1)
        $passengersCount = $request->query('passengers', 1);

        return view('frontend.book', compact('flight', 'passengersCount'));
    }

    /**
     * LOGIC 3: PROSES CHECKOUT (DATABASE TRANSACTION)
     * Menyimpan Booking -> Penumpang -> Kurangi Stok
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
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
        
        // Cek lagi apakah stok masih cukup (mencegah race condition)
        if ($flight->available_seats < $totalPassengers) {
            return back()->with('error', 'Maaf, kursi sudah habis terjual beberapa detik yang lalu.');
        }

        $totalPrice = $flight->price * $totalPassengers;

        // 2. MULAI TRANSAKSI DATABASE
        try {
            return DB::transaction(function () use ($request, $flight, $totalPrice, $totalPassengers) {
                
                // A. Buat Booking Header
                $bookingCode = 'AGD-' . strtoupper(Str::random(6));
                
                $booking = Booking::create([
                    'booking_code' => $bookingCode,
                    'user_id' => Auth::id(),
                    'flight_id' => $flight->id,
                    'total_passengers' => $totalPassengers,
                    'total_amount' => $totalPrice,
                    'status' => 'pending', // Menunggu pembayaran
                ]);

                // B. Simpan Data Penumpang
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

                // C. Kurangi Stok Kursi
                $flight->decrement('available_seats', $totalPassengers);

                // D. Redirect ke Halaman Sukses
                return redirect()->route('booking.show', $booking->booking_code)
                    ->with('success', 'Booking berhasil! Silakan lakukan pembayaran.');
            });

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * LOGIC 4: LIHAT TIKET / HALAMAN PEMBAYARAN
     */
    public function show($code)
    {
        $booking = Booking::where('booking_code', $code)
            ->with(['flight.airline', 'flight.origin', 'flight.destination', 'passengers'])
            ->firstOrFail();

        // Keamanan: Hanya pemilik atau admin yang boleh lihat
        if ($booking->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke tiket ini.');
        }

        return view('frontend.booking-success', compact('booking'));
    }
}