<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hasil Pencarian - Agoda</title>

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Custom Styles for Slider & Checkbox */
        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 16px;
            width: 16px;
            border-radius: 50%;
            background: #0057b8;
            cursor: pointer;
            margin-top: -6px;
        }

        input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 4px;
            cursor: pointer;
            background: #e5e7eb;
            border-radius: 2px;
        }
    </style>
</head>

<body class="bg-[#f7f9fa]">

    {{-- NAVBAR (Fixed Top & Z-Index Tinggi) --}}
    <nav class="bg-white border-b border-gray-200 fixed w-full top-0 z-[999] h-[68px] flex items-center shadow-sm">
        <div class="max-w-[1240px] mx-auto px-4 w-full flex justify-between items-center">

            <div class="flex items-center">
                <a href="/" class="mr-8">
                    <img src="https://images.seeklogo.com/logo-png/37/1/agoda-logo-png_seeklogo-371025.png"
                        alt="Agoda" class="h-19 md:h-16 w-auto">
                </a>

                <div class="hidden lg:flex space-x-5 text-[15px] font-semibold text-[#53535f]">
                    <a href="#" class="hover:text-black flex items-center **inline-flex items-end**">
                        Pesawat + Hotel
                        <span
                            class="bg-[#e12d2d] text-white text-[10px] px-1.5 py-[1px] rounded-sm ml-1.5 font-bold uppercase leading-tight">Paket
                            hemat!</span>
                    </a>
                    <a href="#" class="hover:text-black **inline-flex items-end**">Akomodasi</a>
                    <a href="#" class="hover:text-black **inline-flex items-end**">
                        Transportasi <i class="fa-solid fa-chevron-down text-xs ml-1 opacity-70"></i>
                    </a>
                    <a href="#" class="hover:text-black **inline-flex items-end**">Aktivitas</a>
                    <a href="#" class="hover:text-black **inline-flex items-end**">Kupon & Promo</a>
                    <a href="#" class="hover:text-black **inline-flex items-end** text-x2 leading-none">...</a>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <button
                    class="flex items-center space-x-1.5 hover:bg-gray-100 p-2 rounded text-[#53535f] font-semibold text-sm">
                    <img src="https://flagcdn.com/w20/id.png" alt="ID"
                        class="w-5 h-auto rounded-[2px] shadow-sm opacity-80">
                    <span>Rp</span>
                </button>

                @auth
                    @if (Auth::user()->role === 'admin')
                        {{-- Tombol Dashboard Admin --}}
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-[#0057b8] font-bold text-sm px-4 py-2 hover:bg-[#f3f8fd] border border-[#0057b8] rounded transition relative z-50 cursor-pointer">
                            <i class="fa-solid fa-gauge-high mr-1"></i> Dashboard Admin
                        </a>
                    @else
                        {{-- Dropdown Profil User --}}
                        <div class="relative ml-3" x-data="{ open: false }">
                            <button @click="open = !open" type="button"
                                class="flex items-center gap-2 focus:outline-none p-1 pr-2 rounded hover:bg-gray-100 transition border border-transparent hover:border-gray-200">
                                <div
                                    class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold ring-2 ring-white">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span
                                    class="text-sm font-bold text-gray-700 hidden sm:block">{{ Auth::user()->name }}</span>
                                <i class="fa-solid fa-chevron-down text-xs text-gray-500 transition-transform duration-200"
                                    :class="{ 'rotate-180': open }"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" style="display: none;"
                                class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-xl py-2 z-[1000] border border-gray-100 origin-top-right">
                                <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                                    <p class="text-xs text-gray-500 uppercase font-bold">Akun Saya</p>
                                    <p class="text-sm font-bold text-gray-900 truncate mt-1">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600"><i
                                        class="fa-regular fa-user mr-2"></i> Profil Saya</a>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600"><i
                                        class="fa-solid fa-ticket mr-2"></i> Pesanan Saya</a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 font-bold hover:bg-red-50"><i
                                            class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Keluar</button>
                                </form>
                            </div>
                        </div>
                    @endif
                @else
                    {{-- Tombol Guest --}}
                    <a href="{{ route('login') }}"
                        class="text-[#0057b8] font-bold text-[15px] px-4 py-2.5 hover:bg-[#f3f8fd] rounded transition">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="text-[#0057b8] font-bold text-[15px] border-2 border-[#0057b8] px-5 py-2 rounded hover:bg-[#f3f8fd] transition">Buat
                        akun</a>
                @endauth

                <button class="lg:hidden text-[#53535f] p-2"><i class="fa-solid fa-bars text-xl"></i></button>
            </div>
        </div>
    </nav>

    {{-- Spacer untuk Navbar Fixed --}}
    <div class="h-[68px]"></div>

    {{-- Search Bar Sticky --}}
    <div class="bg-white border-b border-gray-200 sticky top-[68px] z-40 shadow-sm">
        <div class="max-w-[1240px] mx-auto px-4 py-4">
            <form action="{{ route('search') }}" method="GET" class="flex items-center gap-3">
                <div class="flex-1 flex items-center gap-2 bg-white border border-gray-300 rounded-lg px-4 py-3">
                    <i class="fa-solid fa-plane-departure text-blue-600"></i>
                    <select name="origin" class="flex-1 outline-none text-sm font-semibold" required>
                        <option value="{{ request('origin') }}" selected>
                            {{ $flights->first()?->origin?->city ?? 'Asal' }}</option>
                        @foreach ($airports as $airport)
                            <option value="{{ $airport->id }}">{{ $airport->city }} ({{ $airport->iata_code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <i class="fa-solid fa-arrow-right-arrow-left text-gray-400"></i>

                <div class="flex-1 flex items-center gap-2 bg-white border border-gray-300 rounded-lg px-4 py-3">
                    <i class="fa-solid fa-location-dot text-blue-600"></i>
                    <select name="destination" class="flex-1 outline-none text-sm font-semibold" required>
                        <option value="{{ request('destination') }}" selected>
                            {{ $flights->first()?->destination?->city ?? 'Tujuan' }}</option>
                        @foreach ($airports as $airport)
                            <option value="{{ $airport->id }}">{{ $airport->city }} ({{ $airport->iata_code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-2 bg-white border border-gray-300 rounded-lg px-4 py-3">
                    <i class="fa-regular fa-calendar text-blue-600"></i>
                    <input type="date" name="date" value="{{ request('date') }}"
                        class="outline-none text-sm font-semibold" required>
                </div>

                <div class="flex items-center gap-2 bg-white border border-gray-300 rounded-lg px-4 py-3">
                    <i class="fa-solid fa-user text-blue-600"></i>
                    <select name="passengers" class="outline-none text-sm font-semibold">
                        <option value="{{ request('passengers', 1) }}" selected>{{ request('passengers', 1) }}
                            Penumpang</option>
                        @for ($i = 1; $i <= 4; $i++)
                            <option value="{{ $i }}">{{ $i }} Penumpang</option>
                        @endfor
                    </select>
                </div>

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-bold text-sm transition">
                    Cari
                </button>
            </form>
        </div>
    </div>

    {{-- Date Comparison Bar --}}
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-[1240px] mx-auto px-4 py-3">
            <div class="flex items-center justify-between gap-2 overflow-x-auto scrollbar-hide">
                @for ($i = -2; $i <= 2; $i++)
                    @php
                        $date = \Carbon\Carbon::parse(request('date', now()))->addDays($i);
                        $isToday = $i === 0;
                        $randomPrice = rand(1200000, 1400000);
                    @endphp
                    <a href="{{ route('search', array_merge(request()->except('page'), ['date' => $date->format('Y-m-d')])) }}"
                        class="flex-1 text-center py-3 px-4 rounded-lg transition hover:bg-gray-50 {{ $isToday ? 'bg-blue-50 border-2 border-blue-600' : 'border-2 border-transparent' }}">
                        <div class="text-xs text-gray-600 mb-1 font-semibold">{{ $date->format('d M') }}</div>
                        <div
                            class="text-sm {{ $isToday ? 'text-blue-600 font-bold' : 'text-gray-800 font-semibold' }}">
                            Mulai Rp {{ number_format($randomPrice, 0, ',', '.') }}
                        </div>
                    </a>
                @endfor
            </div>
        </div>
    </div>

    {{-- Main Content WITH ALPINE.JS AJAX LOGIC --}}
    <div class="max-w-[1240px] mx-auto px-4 py-6" x-data="{
        // --- FILTER STATES ---
        selectedAirlines: [],
        selectAllAirlines: false,
        includeBaggage: false,
        departureEnd: 24,
        arrivalEnd: 24,
        priceLimit: {{ $maxPriceDb ?? 10943262 }},
        maxDuration: 72,
        selectedTransit: [],
    
        // --- AJAX FUNCTION ---
        async fetchFlights() {
            let params = new URLSearchParams(window.location.search);
            params.delete('page'); // Reset paging
    
            // Append array params manually to avoid duplication issues
            params.delete('airlines[]');
            this.selectedAirlines.forEach(id => params.append('airlines[]', id));
            params.delete('transit[]');
            this.selectedTransit.forEach(val => params.append('transit[]', val));
    
            params.set('max_price', this.priceLimit);
            params.set('dep_end', this.departureEnd);
            params.set('arr_end', this.arrivalEnd);
            params.set('max_duration', this.maxDuration);
    
            try {
                const res = await fetch(`{{ route('search') }}?${params.toString()}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await res.text();
                // Replace content of the flight results container
                document.getElementById('flight-results-container').innerHTML = html;
            } catch (e) { console.error(e); }
        },
    
        // --- WATCHERS (Trigger AJAX on change) ---
        init() {
            this.$watch('selectedAirlines', () => this.fetchFlights());
            this.$watch('selectedTransit', () => this.fetchFlights());
            this.$watch('includeBaggage', () => this.fetchFlights()); // Assuming backend handles this logic
    
            // Debounce for sliders (wait 500ms before requesting)
            let timer;
            const debounced = () => { clearTimeout(timer);
                timer = setTimeout(() => this.fetchFlights(), 500); };
            this.$watch('priceLimit', debounced);
            this.$watch('departureEnd', debounced);
            this.$watch('arrivalEnd', debounced);
            this.$watch('maxDuration', debounced);
        },
    
        toggleAllAirlines() {
            this.selectAllAirlines = !this.selectAllAirlines;
            // Assumes availableAirlines is passed from controller
            const allIds = {{ Js::from($availableAirlines->pluck('id')) }};
            this.selectedAirlines = this.selectAllAirlines ? allIds : [];
        },
    
        resetFilters() {
            this.selectedAirlines = [];
            this.selectAllAirlines = false;
            this.includeBaggage = false;
            this.departureEnd = 24;
            this.arrivalEnd = 24;
            this.priceLimit = {{ $maxPriceDb ?? 10943262 }};
            this.maxDuration = 72;
            this.selectedTransit = [];
        }
    }">
        <div class="flex gap-6">

            {{-- LEFT SIDEBAR: FILTERS --}}
            <aside class="w-[280px] flex-shrink-0">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 sticky top-[200px]">

                    {{-- Disarankan Header --}}
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="font-bold text-base">Disarankan</h3>
                        <button @click="resetFilters()"
                            class="text-blue-600 text-xs font-semibold hover:underline">Hapus</button>
                    </div>

                    {{-- Termasuk bagasi terdaftar --}}
                    <div class="px-4 pt-4 pb-3 border-b border-gray-200">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" x-model="includeBaggage"
                                class="mr-3 w-5 h-5 text-blue-600 rounded">
                            <span class="text-sm font-medium text-gray-700">Termasuk bagasi terdaftar</span>
                        </label>
                    </div>

                    {{-- Maskapai Filter --}}
                    <div class="p-4 border-b border-gray-200">
                        <h4 class="font-bold text-sm mb-3">Maskapai</h4>

                        {{-- Pilih semua dengan TOGGLE SWITCH --}}
                        <div class="flex items-center justify-between mb-3 pb-3 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-700">Pilih semua maskapai</span>
                            <button @click="toggleAllAirlines()"
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors"
                                :class="selectAllAirlines ? 'bg-blue-600' : 'bg-gray-300'">
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                                    :class="selectAllAirlines ? 'translate-x-6' : 'translate-x-1'"></span>
                            </button>
                        </div>

                        {{-- List Maskapai --}}
                        <div class="space-y-2 max-h-[250px] overflow-y-auto scrollbar-hide">
                            @foreach ($availableAirlines as $airline)
                                <label
                                    class="flex items-center cursor-pointer hover:bg-gray-50 -mx-2 px-2 py-1 rounded">
                                    <input type="checkbox" value="{{ $airline->id }}" x-model="selectedAirlines"
                                        class="mr-3 w-5 h-5 text-blue-600 rounded">
                                    <span class="text-sm text-gray-700">{{ $airline->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Waktu Filter (2 SLIDERS) --}}
                    <div class="p-4 border-b border-gray-200">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="font-bold text-sm">Waktu</h4>
                            <button @click="departureEnd = 24; arrivalEnd = 24"
                                class="text-blue-600 text-xs font-semibold hover:underline">Hapus</button>
                        </div>

                        {{-- Keberangkatan Slider --}}
                        <div class="mb-4">
                            <div class="text-xs text-gray-600 mb-2 font-bold">
                                Keberangkatan <span x-text="`00.00 - ${departureEnd}.00`"></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] text-gray-500 font-bold">00.00</span>
                                <input type="range" x-model="departureEnd" min="0" max="24"
                                    class="flex-1 h-2 bg-blue-600 rounded-lg appearance-none cursor-pointer">
                                <span class="text-[10px] text-gray-500 font-bold">24.59</span>
                            </div>
                        </div>

                        {{-- Kedatangan Slider --}}
                        <div>
                            <div class="text-xs text-gray-600 mb-2 font-bold">
                                Kedatangan <span x-text="`00.00 - ${arrivalEnd}.00`"></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] text-gray-500 font-bold">00.00</span>
                                <input type="range" x-model="arrivalEnd" min="0" max="24"
                                    class="flex-1 h-2 bg-blue-600 rounded-lg appearance-none cursor-pointer">
                                <span class="text-[10px] text-gray-500 font-bold">24.59</span>
                            </div>
                        </div>
                    </div>

                    {{-- Harga Filter --}}
                    <div class="p-4 border-b border-gray-200">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="font-bold text-sm">Harga per orang</h4>
                            <button @click="priceLimit = {{ $maxPriceDb ?? 10943262 }}"
                                class="text-blue-600 text-xs font-semibold hover:underline">Hapus</button>
                        </div>
                        <div class="text-xs text-gray-600 mb-2">
                            Hingga Rp <span x-text="parseInt(priceLimit).toLocaleString('id-ID')"></span>
                        </div>
                        <input type="range" x-model="priceLimit" min="0"
                            max="{{ $maxPriceDb ?? 10943262 }}" step="100000"
                            class="w-full h-2 bg-blue-600 rounded-lg appearance-none cursor-pointer">
                    </div>

                    {{-- Durasi Filter --}}
                    <div class="p-4 border-b border-gray-200">
                        <h4 class="font-bold text-sm mb-3">Durasi</h4>
                        <div class="text-xs text-gray-600 mb-2">
                            Kurang dari <span x-text="maxDuration">72</span> jam
                        </div>
                        <input type="range" x-model="maxDuration" min="0" max="72"
                            class="w-full h-2 bg-blue-600 rounded-lg appearance-none cursor-pointer">
                    </div>

                    {{-- Transit Filter --}}
                    <div class="p-4">
                        <h4 class="font-bold text-sm mb-3">Transit</h4>
                        <div class="space-y-2">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" value="direct" x-model="selectedTransit"
                                    class="mr-3 w-5 h-5 text-blue-600 rounded">
                                <span class="text-sm font-medium text-gray-700">Langsung</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" value="1" x-model="selectedTransit"
                                    class="mr-3 w-5 h-5 text-blue-600 rounded">
                                <span class="text-sm font-medium text-gray-700">1 Transit</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" value="2+" x-model="selectedTransit"
                                    class="mr-3 w-5 h-5 text-blue-600 rounded">
                                <span class="text-sm font-medium text-gray-700">2+ Transit</span>
                            </label>
                        </div>
                    </div>

                </div>
            </aside>

            {{-- RIGHT SIDE: RESULTS --}}
            <main class="flex-1">

                {{-- Sort Tabs --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-4 overflow-hidden">
                    <div class="flex border-b border-gray-200">
                        <button
                            class="flex-1 py-4 px-4 font-semibold text-sm text-gray-600 hover:bg-gray-50 whitespace-nowrap">
                            Termurah<br>
                            <span class="text-xs font-normal">Rp 1.263.126 • 2j 25m</span>
                        </button>
                        <button
                            class="flex-1 py-4 px-4 font-bold text-sm bg-blue-50 text-blue-600 border-b-2 border-blue-600 whitespace-nowrap">
                            Terbaik secara keseluruhan<br>
                            <span class="text-xs font-normal">Rp 1.263.126 • 2j 25m</span>
                        </button>
                        <button
                            class="flex-1 py-4 px-4 font-semibold text-sm text-gray-600 hover:bg-gray-50 whitespace-nowrap">
                            Tercepat<br>
                            <span class="text-xs font-normal">Rp 1.263.126 • 2j 25m</span>
                        </button>
                        <button
                            class="flex-1 py-4 px-4 font-semibold text-sm text-gray-600 hover:bg-gray-50 flex items-center justify-center whitespace-nowrap">
                            Urutkan berdasarkan <i class="fa-solid fa-chevron-down ml-2 text-xs"></i>
                        </button>
                    </div>
                </div>

                {{-- Flight Results Container (AJAX Target) --}}
                <div id="flight-results-container">
                    @include('frontend.partials.flight-list')
                </div>

            </main>
        </div>
    </div>

</body>

</html>
