<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran - Agoda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <style> body { font-family: sans-serif; background-color: #f7f9fa; } </style>
</head>
<body>
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-8 text-center">
            
            <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-plane-departure text-2xl"></i>
            </div>

            <h1 class="text-2xl font-bold text-gray-800 mb-2">Booking Berhasil Dibuat!</h1>
            <p class="text-gray-500 mb-6">Kode Booking: <span class="font-mono font-bold text-gray-800">{{ $booking->booking_code }}</span></p>

            <div class="bg-gray-50 rounded p-4 mb-6 text-left">
                <div class="flex justify-between mb-2">
                    <span class="text-sm text-gray-600">Total Pembayaran</span>
                    <span class="font-bold text-gray-800">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Status</span>
                    <span class="text-sm font-bold uppercase text-orange-500">{{ $booking->status }}</span>
                </div>
            </div>

            <button id="pay-button" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg shadow transition">
                Bayar Sekarang
            </button>
            
            <a href="{{ route('home') }}" class="block mt-4 text-sm text-blue-600 hover:underline">Kembali ke Beranda</a>
        </div>
    </div>

    <script type="text/javascript">
        // Trigger Midtrans Popup
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $booking->snap_token }}', {
                onSuccess: function(result){
                    // Redirect atau tampilkan pesan sukses
                    alert("Pembayaran Berhasil!");
                    window.location.href = "{{ route('booking.index') }}"; // Ke halaman My Bookings
                },
                onPending: function(result){
                    alert("Menunggu pembayaran Anda!");
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                },
                onClose: function(){
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        });
    </script>
</body>
</html>