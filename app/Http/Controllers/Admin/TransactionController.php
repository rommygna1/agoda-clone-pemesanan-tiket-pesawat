<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Menampilkan semua daftar transaksi (booking)
     */
    public function index()
    {
        // Ambil semua booking dari yang terbaru
        // Include relasi user dan flight agar bisa ditampilkan detailnya
        $transactions = Booking::with(['user', 'flight.airline', 'flight.origin', 'flight.destination'])
                               ->latest()
                               ->paginate(10);

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Mengubah status pembayaran menjadi SUCCESS / PAID
     */
    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);
        
        // Update status ke 'paid' (atau 'confirmed' sesuai enum database Anda)
        $booking->update([
            'status' => 'paid'
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil dikonfirmasi secara manual.');
    }

    /**
     * Mengubah status pembayaran menjadi FAILED / CANCELLED (Opsional)
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        
        // Kembalikan stok kursi jika dicancel (Opsional, fitur bagus untuk ada)
        $booking->flight->increment('available_seats', $booking->total_passengers);

        $booking->update([
            'status' => 'cancelled'
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil dibatalkan.');
    }
}