<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Isi Data Penumpang - Agoda</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> body { font-family: 'Open Sans', sans-serif; background-color: #f7f9fa; } </style>
</head>
<body>

    {{-- Navbar Simple --}}
    <nav class="bg-white border-b border-gray-200 h-16 flex items-center shadow-sm sticky top-0 z-50">
        <div class="max-w-[1140px] mx-auto px-4 w-full">
            <a href="/" class="flex items-center gap-2">
                <img src="https://images.seeklogo.com/logo-png/37/1/agoda-logo-png_seeklogo-371025.png" alt="Agoda" class="h-8">
            </a>
        </div>
    </nav>

    <div class="max-w-[1140px] mx-auto px-4 py-8">
        <form action="{{ route('booking.store') }}" method="POST">
            @csrf
            <input type="hidden" name="flight_id" value="{{ $flight->id }}">
            
            <div class="flex flex-col lg:flex-row gap-6">
                
                {{-- LEFT SIDE: PASSENGER FORM --}}
                <div class="flex-1 space-y-6">
                    
                    {{-- Alert Login Info --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 flex gap-3">
                        <i class="fa-solid fa-circle-user text-blue-600 text-xl mt-0.5"></i>
                        <div>
                            <p class="text-sm text-gray-800 font-bold">Masuk sebagai {{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-600">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <h2 class="text-xl font-bold text-gray-800">Detail Penumpang</h2>

                    @for ($i = 0; $i < $passengersCount; $i++)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 relative">
                            <div class="absolute -left-[1px] top-6 w-1 h-8 bg-blue-600 rounded-r"></div>
                            <h3 class="text-base font-bold text-gray-800 mb-4">Penumpang {{ $i + 1 }}</h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1">Title</label>
                                    <select name="passengers[{{ $i }}][title]" class="w-full border border-gray-300 rounded p-2.5 text-sm focus:border-blue-500 outline-none bg-white">
                                        <option value="Mr">Tuan (Mr)</option>
                                        <option value="Mrs">Nyonya (Mrs)</option>
                                        <option value="Ms">Nona (Ms)</option>
                                    </select>
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-xs font-bold text-gray-500 mb-1">Nama Depan & Tengah (sesuai KTP/Paspor)</label>
                                    <input type="text" name="passengers[{{ $i }}][first_name]" class="w-full border border-gray-300 rounded p-2.5 text-sm focus:border-blue-500 outline-none" placeholder="Contoh: Budi" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1">Nama Belakang</label>
                                    <input type="text" name="passengers[{{ $i }}][last_name]" class="w-full border border-gray-300 rounded p-2.5 text-sm focus:border-blue-500 outline-none" placeholder="Contoh: Santoso" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1">Tanggal Lahir</label>
                                    <input type="date" name="passengers[{{ $i }}][date_of_birth]" class="w-full border border-gray-300 rounded p-2.5 text-sm focus:border-blue-500 outline-none" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Kewarganegaraan</label>
                                <select name="passengers[{{ $i }}][nationality]" class="w-full border border-gray-300 rounded p-2.5 text-sm focus:border-blue-500 outline-none bg-white">
                                    <option value="ID">Indonesia</option>
                                    <option value="MY">Malaysia</option>
                                    <option value="SG">Singapore</option>
                                    <option value="US">United States</option>
                                </select>
                            </div>
                        </div>
                    @endfor

                    <div class="text-right">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded shadow-lg transition text-lg w-full md:w-auto">
                            Lanjut ke Pembayaran <i class="fa-solid fa-chevron-right ml-2"></i>
                        </button>
                    </div>

                </div>

                {{-- RIGHT SIDE: FLIGHT SUMMARY --}}
                <div class="w-full lg:w-[360px] flex-shrink-0">
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5 sticky top-24">
                        <h3 class="font-bold text-gray-800 mb-4 border-b border-gray-100 pb-3">Ringkasan Pesanan</h3>
                        
                        <div class="flex items-start gap-3 mb-4">
                            @if($flight->airline->logo)
                                <img src="{{ asset('storage/' . $flight->airline->logo) }}" class="h-8 w-8 object-contain">
                            @endif
                            <div>
                                <div class="font-bold text-sm">{{ $flight->airline->name }}</div>
                                <div class="text-xs text-gray-500">{{ $flight->flight_number }} • Economy</div>
                            </div>
                        </div>

                        <div class="relative pl-4 border-l-2 border-gray-200 ml-1.5 space-y-6 mb-6">
                            <div class="relative">
                                <div class="absolute -left-[21px] top-1 w-3 h-3 bg-white border-2 border-gray-400 rounded-full"></div>
                                <div class="text-sm font-bold">{{ \Carbon\Carbon::parse($flight->departure_time)->format('H:i') }}</div>
                                <div class="text-xs text-gray-500">{{ $flight->origin->city }} ({{ $flight->origin->iata_code }})</div>
                                <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($flight->departure_time)->translatedFormat('d M Y') }}</div>
                            </div>
                            <div class="relative">
                                <div class="absolute -left-[21px] top-1 w-3 h-3 bg-gray-800 border-2 border-gray-800 rounded-full"></div>
                                <div class="text-sm font-bold">{{ \Carbon\Carbon::parse($flight->arrival_time)->format('H:i') }}</div>
                                <div class="text-xs text-gray-500">{{ $flight->destination->city }} ({{ $flight->destination->iata_code }})</div>
                                <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($flight->arrival_time)->translatedFormat('d M Y') }}</div>
                            </div>
                        </div>

                        <div class="bg-blue-50 rounded p-3 mb-4">
                            <div class="flex justify-between items-center text-sm mb-1">
                                <span class="text-gray-600">Harga per tiket</span>
                                <span class="font-bold">Rp {{ number_format($flight->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Jumlah Penumpang</span>
                                <span class="font-bold">x {{ $passengersCount }}</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                            <span class="font-bold text-gray-800">Total Harga</span>
                            <span class="text-xl font-bold text-red-600">Rp {{ number_format($flight->price * $passengersCount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

</body>
</html>