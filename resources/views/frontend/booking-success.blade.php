<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Tiket - Agoda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <style> 
        body { font-family: 'Open Sans', sans-serif; background-color: #f7f9fa; } 
        /* CSS Khusus Print agar tampilan bersih saat dicetak */
        @media print {
            .no-print { display: none !important; }
            body { background-color: white; }
            .ticket-container { box-shadow: none; border: 2px solid #eee; margin: 0; padding: 0; }
            .bg-gray-50 { background-color: #f9fafb !important; -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-6">

    {{-- KARTU TIKET / PEMBAYARAN --}}
    <div class="ticket-container bg-white rounded-xl shadow-xl max-w-3xl w-full p-8 relative overflow-hidden border border-gray-100">
        
        {{-- HEADER STATUS --}}
        <div class="text-center mb-8 border-b border-dashed border-gray-200 pb-6">
            @if($booking->status == 'paid' || $booking->status == 'confirmed')
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                    <i class="fa-solid fa-check text-3xl"></i>
                </div>
                <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">E-Tiket Penerbangan</h1>
                <p class="text-green-600 font-bold mt-2 text-sm bg-green-50 inline-block px-4 py-1 rounded-full border border-green-200">
                    <i class="fa-solid fa-circle-check mr-1"></i> Pembayaran Berhasil
                </p>
            @elseif($booking->status == 'pending')
                <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-hourglass-half text-3xl animate-pulse"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Menunggu Pembayaran</h1>
                <p class="text-gray-500 mt-2">Selesaikan pembayaran untuk menerbitkan E-Tiket</p>
            @else
                <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-xmark text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Pesanan Dibatalkan</h1>
            @endif
        </div>

        {{-- DETAIL TIKET --}}
        <div class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-widest font-bold mb-1">Kode Booking</p>
                    <p class="text-4xl font-mono font-bold text-gray-900 tracking-wider">{{ $booking->booking_code }}</p>
                </div>
                <div class="mt-4 md:mt-0 text-left md:text-right">
                     <p class="text-xs text-gray-500 uppercase tracking-widest font-bold mb-1">Total Biaya</p>
                     <p class="text-2xl font-bold text-[#0057b8]">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- INFORMASI PENERBANGAN --}}
            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                <div class="flex flex-col md:flex-row gap-6 items-center justify-between">
                    {{-- ASAL --}}
                    <div class="text-center md:text-left min-w-[120px]">
                        <p class="text-3xl font-bold text-gray-800">{{ $booking->flight->origin->iata_code }}</p>
                        <p class="text-sm text-gray-600 font-medium">{{ $booking->flight->origin->city }}</p>
                        <p class="text-xs text-gray-500 mt-1 bg-white px-2 py-1 rounded shadow-sm inline-block">
                            {{ \Carbon\Carbon::parse($booking->flight->departure_time)->format('H:i') }}
                        </p>
                    </div>
                    
                    {{-- DURASI & MASKAPAI --}}
                    <div class="flex-1 flex flex-col items-center w-full px-4">
                         <p class="text-xs text-gray-400 font-bold tracking-wide mb-5">
                             {{ \Carbon\Carbon::parse($booking->flight->departure_time)->diff($booking->flight->arrival_time)->format('%Hj %Im') }}
                         </p>
                         <div class="w-full h-[2px] bg-gray-300 relative flex items-center justify-center">
                             <div class="absolute left-0 w-2 h-2 bg-gray-400 rounded-full"></div>
                             <div class="bg-white px-2 z-10">
                                 <i class="fa-solid fa-plane text-[#0057b8] text-lg rotate-30 transform"></i>
                             </div>
                             <div class="absolute right-0 w-2 h-2 bg-gray-400 rounded-full"></div>
                         </div>
                         <div class="flex items-center gap-2 mt-7">
                            @if($booking->flight->airline->logo)
                                <img src="{{ asset('storage/' . $booking->flight->airline->logo) }}" class="h-5 w-auto object-contain">
                            @endif
                
                         </div>
                    </div>

                    {{-- TUJUAN --}}
                    <div class="text-center md:text-right min-w-[120px]">
                        <p class="text-3xl font-bold text-gray-800">{{ $booking->flight->destination->iata_code }}</p>
                        <p class="text-sm text-gray-600 font-medium">{{ $booking->flight->destination->city }}</p>
                        <p class="text-xs text-gray-500 mt-1 bg-white px-2 py-1 rounded shadow-sm inline-block">
                            {{ \Carbon\Carbon::parse($booking->flight->arrival_time)->format('H:i') }}
                        </p>
                    </div>
                </div>
                
                <div class="mt-6 pt-4 border-t border-gray-200 text-center">
                    <p class="text-xs text-gray-500">Tanggal Penerbangan: <span class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($booking->flight->departure_time)->translatedFormat('l, d F Y') }}</span></p>
                </div>
            </div>
        </div>

        {{-- DAFTAR PENUMPANG --}}
        @if($booking->passengers->isNotEmpty())
        <div class="mb-8">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 pl-1">Daftar Penumpang</h3>
            <div class="bg-white border border-gray-200 rounded-lg divide-y divide-gray-100">
                @foreach($booking->passengers as $index => $pax)
                <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">{{ $pax->title }} {{ $pax->first_name }} {{ $pax->last_name }}</p>
                            <p class="text-xs text-gray-500 uppercase">{{ $pax->nationality }}</p>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-gray-400">Dewasa</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- FOOTER / TOMBOL AKSI (Disembunyikan saat print) --}}
        <div class="no-print mt-4 space-y-3">
            @if($booking->status == 'pending')
                {{-- TOMBOL BAYAR (Muncul jika Pending) --}}
                <button id="pay-button" class="w-full bg-[#0057b8] hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg transition transform hover:-translate-y-1 flex justify-center items-center gap-3">
                    <i class="fa-regular fa-credit-card text-xl"></i>
                    <span class="text-lg">Bayar Sekarang</span>
                </button>
            @elseif($booking->status == 'paid' || $booking->status == 'confirmed')
                {{-- TOMBOL PRINT (Muncul jika Paid) --}}
                <button onclick="window.print()" class="w-full bg-gray-800 hover:bg-gray-900 text-white font-bold py-4 rounded-xl shadow-lg transition transform hover:-translate-y-1 flex justify-center items-center gap-3">
                    <i class="fa-solid fa-print text-xl"></i>
                    <span class="text-lg">Cetak / Simpan PDF</span>
                </button>
            @endif
            
            <a href="{{ route('booking.index') }}" class="block text-center text-sm font-semibold text-gray-500 hover:text-[#0057b8] py-2 transition">
                &larr; Kembali ke Pesanan Saya
            </a>
        </div>

    </div>

    {{-- SCRIPT MIDTRANS (Hanya jika Pending) --}}
    @if($booking->status == 'pending')
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $booking->snap_token }}', {
                onSuccess: function(result){
                    alert("Pembayaran Berhasil!");
                    location.reload(); 
                },
                onPending: function(result){
                    alert("Menunggu pembayaran Anda!");
                    location.reload();
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
    @endif

</body>
</html>