<div class="space-y-4">
    @forelse($flights as $flight)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 overflow-hidden relative group"
             x-data="{ expanded: false }">
            
            {{-- HEADER: TANGGAL & SISA KURSI --}}
            <div class="bg-gray-50 px-5 py-2 border-b border-gray-100 flex justify-between items-center">
                <span class="text-xs font-bold text-gray-600 flex items-center gap-2">
                    <i class="fa-regular fa-calendar text-[#0057b8]"></i>
                    {{ \Carbon\Carbon::parse($flight->departure_time)->translatedFormat('D, d M Y') }}
                </span>
                @if($flight->available_seats <= 5)
                    <span class="text-[10px] font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full border border-red-100">
                        Sisa {{ $flight->available_seats }} kursi!
                    </span>
                @endif
            </div>

            {{-- BODY UTAMA (YANG SELALU MUNCUL) --}}
            <div class="p-5 cursor-pointer" @click="expanded = !expanded">
                <div class="flex flex-col md:flex-row items-center gap-4">
                    
                    {{-- 1. Maskapai --}}
                    <div class="w-full md:w-1/5 flex items-center gap-3">
                        @if($flight->airline->logo)
                            <img src="{{ asset('storage/' . $flight->airline->logo) }}" class="h-8 w-8 object-contain">
                        @else
                            <div class="h-8 w-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-400">
                                <i class="fa-solid fa-plane"></i>
                            </div>
                        @endif
                        <div class="flex flex-col">
                            <span class="font-bold text-sm text-gray-800">{{ $flight->airline->name }}</span>
                            <span class="text-[11px] text-gray-500">{{ $flight->flight_number }}</span>
                        </div>
                    </div>

                    {{-- 2. Jadwal (Kiri - Kanan) --}}
                    <div class="flex-1 flex items-center justify-between px-4">
                        {{-- Berangkat --}}
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-800">{{ \Carbon\Carbon::parse($flight->departure_time)->format('H:i') }}</div>
                            <div class="text-xs text-gray-500 font-semibold">{{ $flight->origin->iata_code }}</div>
                        </div>

                        {{-- Durasi --}}
                        <div class="flex flex-col items-center w-24">
                            <div class="text-[11px] text-gray-500 mb-1">
                                {{ \Carbon\Carbon::parse($flight->departure_time)->diff(\Carbon\Carbon::parse($flight->arrival_time))->format('%Hj %Im') }}
                            </div>
                            <div class="relative w-full h-[1px] bg-gray-300">
                                <div class="absolute -top-1 left-1/2 -translate-x-1/2 bg-white px-1">
                                    <i class="fa-solid fa-plane text-gray-300 text-[10px] rotate-90"></i>
                                </div>
                                <div class="absolute -top-[2px] left-0 w-1 h-1 rounded-full bg-gray-300"></div>
                                <div class="absolute -top-[2px] right-0 w-1 h-1 rounded-full bg-gray-300"></div>
                            </div>
                            <div class="text-[10px] text-green-600 font-bold mt-6">Langsung</div>
                        </div>

                        {{-- Tiba --}}
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-800 relative">
                                {{ \Carbon\Carbon::parse($flight->arrival_time)->format('H:i') }}
                                @if(\Carbon\Carbon::parse($flight->arrival_time)->day > \Carbon\Carbon::parse($flight->departure_time)->day)
                                    <sup class="text-[9px] text-red-500 font-bold top-[-4px]">+1</sup>
                                @endif
                            </div>
                            <div class="text-xs text-gray-500 font-semibold">{{ $flight->destination->iata_code }}</div>
                        </div>
                    </div>

                    {{-- 3. Harga & Panah (Pengganti Tombol Pilih) --}}
                    <div class="w-full md:w-1/4 text-right flex flex-row md:flex-col justify-between items-center md:items-end border-t md:border-t-0 md:border-l border-gray-100 pt-3 md:pt-0 md:pl-4">
                        <div>
                            <div class="text-xs text-gray-400 line-through">Rp {{ number_format($flight->price * 1.1, 0, ',', '.') }}</div>
                            <div class="text-xl font-bold text-red-600">
                                <span class="text-xs text-gray-500 font-normal mr-0.5">Rp</span>{{ number_format($flight->price, 0, ',', '.') }}
                            </div>
                            <div class="text-[10px] text-gray-500">per penumpang</div>
                        </div>
                        
                        {{-- LOGO PANAH (Sesuai Request) --}}
                        <div class="mt-2">
                            <button class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50 transition transform duration-300"
                                    :class="expanded ? 'rotate-180 bg-blue-50 border-blue-200 text-blue-600' : 'text-gray-500'">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            {{-- DETAIL DROPDOWN (MUNCUL SAAT DIKLIK) --}}
            <div x-show="expanded" 
                 x-collapse
                 style="display: none;"
                 class="border-t border-gray-200 bg-gray-50/50">
                
                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-8">
                        
                        {{-- Timeline Detail --}}
                        <div class="flex-1 relative">
                            <div class="absolute left-[59px] top-2 bottom-4 w-[2px] bg-gray-300"></div>

                            {{-- Keberangkatan --}}
                            <div class="flex gap-6 mb-8 relative z-10">
                                <div class="text-right w-12 flex-shrink-0">
                                    <div class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($flight->departure_time)->format('H:i') }}</div>
                                    <div class="text-[10px] text-gray-500">{{ \Carbon\Carbon::parse($flight->departure_time)->format('d M') }}</div>
                                </div>
                                <div class="w-3 h-3 rounded-full border-2 border-gray-400 bg-white mt-1.5 flex-shrink-0"></div>
                                <div>
                                    <div class="text-sm font-bold text-gray-800">{{ $flight->origin->city }} ({{ $flight->origin->iata_code }})</div>
                                    <div class="text-xs text-gray-500">{{ $flight->origin->name }}</div>
                                </div>
                            </div>

                            {{-- Durasi Info --}}
                            <div class="flex gap-6 mb-8 relative z-10">
                                <div class="w-12"></div> <div class="flex flex-col items-center -ml-[5px]">
                                    <i class="fa-solid fa-plane text-gray-400 text-xs py-1 bg-gray-50"></i>
                                </div>
                                <div class="text-xs text-gray-500 pt-1">
                                    <span class="font-semibold text-gray-700">{{ $flight->departure_time->diff($flight->arrival_time)->format('%Hj %Im') }}</span> • 
                                    {{ $flight->airline->name }} • {{ $flight->flight_number }} • Economy
                                </div>
                            </div>

                            {{-- Kedatangan --}}
                            <div class="flex gap-6 relative z-10">
                                <div class="text-right w-12 flex-shrink-0">
                                    <div class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($flight->arrival_time)->format('H:i') }}</div>
                                    <div class="text-[10px] text-gray-500">{{ \Carbon\Carbon::parse($flight->arrival_time)->format('d M') }}</div>
                                </div>
                                <div class="w-3 h-3 rounded-full border-2 border-gray-800 bg-gray-800 mt-1.5 flex-shrink-0"></div>
                                <div>
                                    <div class="text-sm font-bold text-gray-800">{{ $flight->destination->city }} ({{ $flight->destination->iata_code }})</div>
                                    <div class="text-xs text-gray-500">{{ $flight->destination->name }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Fasilitas & Tombol Booking --}}
                        <div class="w-full md:w-64 border-l border-gray-200 pl-0 md:pl-8 flex flex-col justify-between">
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center gap-3 text-xs text-gray-600">
                                    <i class="fa-solid fa-suitcase w-4 text-center text-gray-400"></i>
                                    <span>Bagasi Kabin: <b>7 kg</b></span>
                                </div>
                                <div class="flex items-center gap-3 text-xs text-gray-600">
                                    <i class="fa-solid fa-suitcase-rolling w-4 text-center text-gray-400"></i>
                                    <span>Bagasi Terdaftar: <b>20 kg</b></span>
                                </div>
                                <div class="flex items-center gap-3 text-xs text-gray-600">
                                    <i class="fa-solid fa-utensils w-4 text-center text-gray-400"></i>
                                    <span>Makanan: <b>Berbayar</b></span>
                                </div>
                            </div>

                            {{-- TOMBOL PILIH (Disini sekarang posisinya) --}}
                            <form action="{{ route('booking.create', $flight->id) }}" method="GET">
                                <input type="hidden" name="passengers" value="{{ request('passengers', 1) }}">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded shadow-sm hover:shadow transition text-sm flex justify-center items-center gap-2">
                                    Pilih 
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    @empty
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <i class="fa-solid fa-plane-slash text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak ada penerbangan ditemukan</h3>
            <p class="text-gray-500">Coba ubah tanggal atau filter pencarian Anda</p>
        </div>
    @endforelse

    {{-- Pagination --}}
    @if($flights->hasPages())
        <div class="mt-6">
            {{ $flights->links() }}
        </div>
    @endif
</div>