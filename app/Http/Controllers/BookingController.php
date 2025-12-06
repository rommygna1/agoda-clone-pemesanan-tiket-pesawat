<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Booking;
use App\Models\Passenger;
use App\Models\Airport;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * LOGIC 1: HASIL PENCARIAN
     * Menampilkan daftar penerbangan berdasarkan input user dari Landing Page.
     */
    public function search(Request $request)
    {
        // 1. Validasi Input agar tidak kosong/asal
        $request->validate([
            'origin' => 'required|exists:airports,id',
            'destination' => 'required|exists:airports,id|different:origin',
            'date' => 'required|date|after_or_equal:today',
            'passengers' => 'required|integer|min:1|max:10',
        ]);

        // 2. Ambil data input
        $originId = $request->origin;
        $destinationId = $request->destination;
        $date = $request->date;
        $passengers = $request->passengers;

        // 3. Query Database: Cari penerbangan yang cocok
        $flights = Flight::with(['airline', 'origin', 'destination'])
            ->where('origin_airport_id', $originId)
            ->where('destination_airport_id', $destinationId)
            ->whereDate('departure_time', $date)
            ->where('available_seats', '>=', $passengers) // Pastikan kursi cukup
            ->orderBy('price', 'asc') // Urutkan dari termurah
            ->get();

        // 4. Ambil data Airport untuk ditampilkan di Header Halaman
        $origin = Airport::find($originId);
        $destination = Airport::find($destinationId);

        // 5. Kirim data ke View (Kita akan buat view ini di langkah berikutnya)
        return view('frontend.search', compact('flights', 'origin', 'destination', 'date', 'passengers'));
    }

    /**
     * LOGIC 2: FORM BOOKING
     * Menampilkan halaman pengisian data penumpang setelah user klik "Pilih".
     */
    public function create(Request $request, $flight_id)
    {
        // Cari flight, jika tidak ada tampilkan 404
        $flight = Flight::with(['airline', 'origin', 'destination'])->findOrFail($flight_id);
        
        // Ambil jumlah penumpang dari URL (default 1)
        $passengersCount = $request->query('passengers', 1);

        // Tampilkan view form booking
        return view('frontend.book', compact('flight', 'passengersCount'));
    }

    /**
     * LOGIC 3: PROSES CHECKOUT (PENTING!)
     * Menyimpan data booking dan penumpang ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Data Penumpang
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

        // 2. DATABASE TRANSACTION
        // Gunakan ini agar jika error di tengah jalan, data tidak tersimpan setengah-setengah.
        try {
            return DB::transaction(function () use ($request, $flight, $totalPrice, $totalPassengers) {
                
                // A. Generate Kode Booking Unik (contoh: AGD-8X92A)
                $bookingCode = 'AGD-' . strtoupper(Str::random(6));

                // B. Simpan ke Tabel Bookings
                $booking = Booking::create([
                    'user_id' => Auth::id(), // User yang sedang login
                    'flight_id' => $flight->id,
                    'booking_code' => $bookingCode,
                    'total_passengers' => $totalPassengers,
                    'total_amount' => $totalPrice,
                    'status' => 'pending', // Status awal Pending (Belum bayar)
                ]);

                // C. Simpan Detail Setiap Penumpang
                foreach ($request->passengers as $paxData) {
                    Passenger::create([
                        'booking_id' => $booking->id,
                        'title' => $paxData['title'],
                        'first_name' => $paxData['first_name'],
                        'last_name' => $paxData['last_name'],
                        'date_of_birth' => $paxData['date_of_birth'],
                        'nationality' => $paxData['nationality'],
                        'passport_number' => $paxData['passport_number'] ?? null, // Opsional
                    ]);
                }

                // D. Kurangi Stok Kursi Pesawat
                $flight->decrement('available_seats', $totalPassengers);

                // E. Redirect ke halaman Sukses/Detail
                return redirect()->route('booking.show', $booking->booking_code)
                    ->with('success', 'Booking berhasil dibuat! Silakan lakukan pembayaran.');
            });

        } catch (\Exception $e) {
            // Jika error, kembalikan ke form dengan pesan error
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * LOGIC 4: LIHAT TIKET / DETAIL BOOKING
     */
    public function show($code)
    {
        // Cari booking berdasarkan kode unik
        $booking = Booking::where('booking_code', $code)
            ->with(['flight.airline', 'flight.origin', 'flight.destination', 'passengers'])
            ->firstOrFail();

        // Keamanan: Pastikan hanya pemilik booking yang bisa lihat
        if ($booking->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('frontend.booking-success', compact('booking'));
    }
}