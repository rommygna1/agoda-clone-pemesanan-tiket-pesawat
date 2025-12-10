<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agoda: Pesan Hotel & Penerbangan Murah</title>

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .agoda-input-container {
            position: relative;
            display: flex;
            align-items: center;
            height: 64px;
            background: white;
            transition: all 0.2s;
        }

        .agoda-input-container:hover {
            background-color: #f8f9fa;
            z-index: 5;
        }

        .agoda-input-field {
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            padding-left: 54px;
            padding-right: 16px;
            font-weight: 600;
            color: #2a2a2e;
            font-size: 16px;
            cursor: pointer;
            appearance: none;
        }

        .agoda-input-field::placeholder {
            color: #4a4a4a;
            font-weight: 500;
        }

        .agoda-input-icon {
            position: absolute;
            left: 20px;
            color: #53535f;
            font-size: 20px;
            pointer-events: none;
        }

        .trip-type-radio:checked+label {
            background-color: #eef6fc;
            color: #0057b8;
            border-color: #eef6fc;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-gray-100">

    <nav class="bg-white border-b border-gray-200 fixed w-full top-0 z-[999] h-[68px] flex items-center shadow-sm">
        <div class="max-w-[1240px] mx-auto px-4 w-full flex justify-between items-center">

            <div class="flex items-center">
                <a href="/" class="mr-8">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b0/Agoda_Logo_2022.svg/330px-Agoda_Logo_2022.svg.png?20220609160512"
                        alt="Agoda" class="h-10 md:h-10 w-auto">
                </a>

                <div class="hidden lg:flex space-x-5 text-[15px] font-semibold text-[#53535f]">
                    <a href="#" class="hover:text-black inline-flex items-end">
                        Pesawat + Hotel
                        <span
                            class="bg-[#e12d2d] text-white text-[10px] px-1.5 py-[4px] rounded-sm ml-1.5 font-bold uppercase leading-tight">Paket
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
                    {{-- LOGIKA UTAMA: Cek apakah user adalah ADMIN atau USER BIASA --}}

                    @if (Auth::user()->role === 'admin')
                        {{-- JIKA ADMIN: Tampilkan tombol KHUSUS ke Dashboard Admin --}}
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-[#0057b8] font-bold text-sm px-4 py-2 hover:bg-[#f3f8fd] border border-[#0057b8] rounded transition relative z-50 cursor-pointer">
                            <i class="fa-solid fa-gauge-high mr-1"></i> Dashboard Admin
                        </a>
                    @else
                        {{-- JIKA USER BIASA: Tampilkan Profil Dropdown (Bukan tombol Dashboard) --}}
                        <div class="relative ml-3" x-data="{ open: false }">
                            <button @click="open = !open" type="button"
                                class="flex items-center gap-2 focus:outline-none p-1 pr-2 rounded hover:bg-gray-100 transition border border-transparent hover:border-gray-200">
                                <div
                                    class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold ring-2 ring-white">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="text-sm font-bold text-gray-700 hidden sm:block">
                                    {{ Auth::user()->name }}
                                </span>
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
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                    <i class="fa-regular fa-user mr-2"></i> Profil Saya
                                </a>
                                <a href="{{ route('booking.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                    <i class="fa-solid fa-ticket mr-2"></i> Pesanan Saya
                                </a>

                                <div class="border-t border-gray-100 my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 font-bold hover:bg-red-50">
                                        <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @else
                    {{-- JIKA BELUM LOGIN (GUEST) --}}
                    <a href="{{ route('login') }}"
                        class="text-[#0057b8] font-bold text-[15px] px-4 py-2.5 hover:bg-[#f3f8fd] rounded transition">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="text-[#0057b8] font-bold text-[15px] border-2 border-[#0057b8] px-5 py-2 rounded hover:bg-[#f3f8fd] transition">Buat
                        akun</a>
                @endauth

                <button class="lg:hidden text-[#53535f] p-2">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </nav>

    <div class="pt-[68px]">
        <div class="relative h-[580px] w-full bg-cover bg-center"
            style="background-image: url('https://images.unsplash.com/photo-1500375592092-40eb2168fd21?ixlib=rb-4.0.3&auto=format&fit=crop&w=2200&q=80');">
            <div class="absolute inset-0 bg-black/10"></div>

            <div class="relative max-w-[1100px] mx-auto px-4 pt-14 z-10">
                <h1
                    class="text-3xl md:text-[34px] font-extrabold text-white text-center drop-shadow mb-2 tracking-wide">
                    PESAN PENERBANGAN TERBAIK DI AGODA HARI INI
                </h1>
                <p class="text-lg md:text-[20px] text-white text-center font-semibold drop-shadow-md mb-10">
                    Cari dan pesan di lebih dari 200 maskapai di seluruh dunia
                </p>

                <div class="bg-white rounded-xl shadow-2xl overflow-hidden">

                    <div
                        class="flex overflow-x-auto scrollbar-hide border-b border-gray-200 justify-center">

                        <button
                            class="flex items-center px-6 py-4 text-[#53535f] hover:text-black hover:bg-gray-50 focus:outline-none transition whitespace-nowrap">
                            <i class="fa-solid fa-hotel text-lg mr-2.5"></i>
                            <span class="font-semibold text-[15px]">Hotel</span>
                        </button>

                        <button
                            class="flex items-center px-6 py-4 text-[#53535f] hover:text-black hover:bg-gray-50 focus:outline-none transition whitespace-nowrap">
                            <i class="fa-solid fa-house-chimney text-lg mr-2.5"></i>
                            <span class="font-semibold text-[15px]">Rumah & Apt</span>
                        </button>

                        <button
                            class="flex items-center px-6 py-4 text-[#53535f] hover:text-black hover:bg-gray-50 focus:outline-none transition whitespace-nowrap">
                            <i class="fa-solid fa-plane-departure text-lg mr-2.5"></i>
                            <span class="font-semibold text-[15px]">Pesawat + Hotel</span>
                        </button>

                        <button
                            class="flex items-center px-6 py-4 text-[#0057b8] border-b-[3px] border-[#0057b8] focus:outline-none transition whitespace-nowrap relative top-[1px] bg-white z-10">
                            <i class="fa-solid fa-plane text-lg mr-2.5 rotate-[-45deg]"></i>
                            <span class="font-bold text-[15px]">Pesawat</span>
                        </button>

                        <button
                            class="flex items-center px-6 py-4 text-[#53535f] hover:text-black hover:bg-gray-50 focus:outline-none transition whitespace-nowrap">
                            <i class="fa-solid fa-person-snowboarding text-lg mr-2.5"></i>
                            <span class="font-semibold text-[15px]">Aktivitas</span>
                        </button>

                        <button
                            class="flex items-center px-6 py-4 text-[#53535f] hover:text-black hover:bg-gray-50 focus:outline-none transition whitespace-nowrap">
                            <i class="fa-solid fa-car text-lg mr-2.5"></i>
                            <span class="font-semibold text-[15px]">Transfer bandara</span>
                        </button>
                    </div>

                    <div class="p-8 bg-white">
                        <form action="{{ route('search') }}" method="GET">

                            <div class="flex space-x-3 mb-5">
                                <div>
                                    <input type="radio" id="oneway" name="trip_type" value="one_way"
                                        class="hidden trip-type-radio" checked onchange="toggleReturnDate()">
                                    <label for="oneway"
                                        class="cursor-pointer px-5 py-2.5 rounded-full border border-transparent font-bold text-sm text-[#53535f] hover:bg-gray-100 transition-colors select-none inline-block">Satu
                                        arah</label>
                                </div>
                                <div>
                                    <input type="radio" id="roundtrip" name="trip_type" value="round_trip"
                                        class="hidden trip-type-radio" onchange="toggleReturnDate()">
                                    <label for="roundtrip"
                                        class="cursor-pointer px-5 py-2.5 rounded-full border border-transparent font-bold text-sm text-[#53535f] hover:bg-gray-100 transition-colors select-none inline-block">Pulang
                                        pergi</label>
                                </div>
                            </div>

                            <div class="border border-gray-300 rounded-xl shadow-sm overflow-hidden mb-6 relative z-0">

                                <div class="flex flex-col md:flex-row relative border-b border-gray-300 z-10">

                                    <div class="flex-1 agoda-input-container md:border-r border-gray-300">
                                        <i class="fa-solid fa-plane-departure agoda-input-icon"></i>
                                        <select name="origin" class="agoda-input-field" required>
                                            <option value="" disabled selected hidden>Dari mana?</option>
                                            @foreach ($airports as $airport)
                                                <option value="{{ $airport->id }}">{{ $airport->city }}
                                                    ({{ $airport->iata_code }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div
                                        class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 z-20 hidden md:block">
                                        <button type="button"
                                            class="bg-white border border-gray-200 rounded-full p-2 shadow-sm hover:bg-gray-50 hover:shadow transition group">
                                            <i
                                                class="fa-solid fa-arrow-right-arrow-left text-[#0057b8] group-hover:rotate-180 transition-transform duration-300"></i>
                                        </button>
                                    </div>

                                    <div class="flex-1 agoda-input-container">
                                        <i class="fa-solid fa-location-dot agoda-input-icon"></i>
                                        <select name="destination" class="agoda-input-field" required>
                                            <option value="" disabled selected hidden>Ke mana?</option>
                                            @foreach ($airports as $airport)
                                                <option value="{{ $airport->id }}">{{ $airport->city }}
                                                    ({{ $airport->iata_code }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="flex flex-col md:flex-row relative z-0">

                                    <div class="flex-1 flex md:border-r border-gray-300 transition-all duration-300"
                                        id="date-container">
                                        <div
                                            class="flex-1 agoda-input-container border-r border-gray-300 relative z-10">
                                            <i class="fa-regular fa-calendar agoda-input-icon"></i>
                                            <input type="date" name="date" required min="{{ date('Y-m-d') }}"
                                                class="agoda-input-field uppercase" placeholder="Pergi">
                                        </div>

                                        <div id="return-date-wrapper"
                                            class="hidden flex-1 agoda-input-container relative z-0 bg-gray-50">
                                            <i class="fa-regular fa-calendar-check agoda-input-icon opacity-60"></i>
                                            <input type="date" name="return_date" min="{{ date('Y-m-d') }}"
                                                class="agoda-input-field uppercase bg-transparent"
                                                placeholder="Pulang">
                                        </div>
                                    </div>

                                    <div class="flex-1 agoda-input-container">
                                        <i class="fa-solid fa-user-group agoda-input-icon text-lg"></i>
                                        <select name="passengers" class="agoda-input-field appearance-none">
                                            <option value="1" selected>1 Penumpang, Economy</option>
                                            <option value="2">2 Penumpang, Economy</option>
                                            <option value="3">3 Penumpang, Economy</option>
                                        </select>
                                        <i
                                            class="fa-solid fa-chevron-down absolute right-5 text-gray-400 text-sm pointer-events-none"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center mb-8">
                                <div class="flex items-center h-5">
                                    <input id="hotel-promo" type="checkbox"
                                        class="w-5 h-5 text-[#0057b8] border-gray-300 rounded focus:ring-[#0057b8] cursor-pointer">
                                </div>
                                <label for="hotel-promo"
                                    class="ml-3 text-[#2a2a2e] text-[15px] font-medium cursor-pointer select-none flex items-center">
                                    Tambahkan hotel untuk hemat hingga 25%
                                    <span
                                        class="bg-[#e12d2d] text-white text-[11px] px-1.5 py-[2px] rounded-sm ml-2 font-bold uppercase leading-none">Paket
                                        Hemat</span>
                                </label>
                            </div>

                            <div class="text-center">
                                <button type="submit"
                                    class="w-full bg-[#0057b8] hover:bg-[#00449e] text-white text-[17px] font-bold py-[18px] rounded-xl shadow-lg hover:shadow-xl transition-all transform active:scale-[0.99]">
                                    CARI PENERBANGAN
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION: Inspirasi liburan Indonesia --}}
    <div class="max-w-[1240px] mx-auto px-4 py-12 mt-20">
        <h2 class="text-[28px] font-bold text-[#2a2a2e] mb-8">Yuk, cek inspirasi liburan di Indonesia ini</h2>

        <div class="flex overflow-x-auto space-x-5 pb-4 scrollbar-hide">

            <!-- Jakarta -->
            <a href="#" class="flex-shrink-0 group">
                <div
                    class="w-[220px] h-[220px] rounded-2xl overflow-hidden mb-3 shadow-md group-hover:shadow-xl transition-shadow">
                    <img src="https://images.unsplash.com/photo-1555899434-94d1368aa7af?auto=format&fit=crop&w=800&q=60"
                        alt="Jakarta"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <h3 class="font-bold text-[17px] text-[#2a2a2e] mb-1">Jakarta</h3>
                <p class="text-[14px] text-[#53535f]">14.249 akomodasi</p>
            </a>

            <!-- Bandung -->
            <a href="#" class="flex-shrink-0 group">
                <div
                    class="w-[220px] h-[220px] rounded-2xl overflow-hidden mb-3 shadow-md group-hover:shadow-xl transition-shadow">
                    <img src="https://images.unsplash.com/photo-1596422846543-75c6fc197f07?auto=format&fit=crop&w=800&q=60"
                        alt="Bandung"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <h3 class="font-bold text-[17px] text-[#2a2a2e] mb-1">Bandung</h3>
                <p class="text-[14px] text-[#53535f]">7.196 akomodasi</p>
            </a>

            <!-- Yogyakarta -->
            <a href="#" class="flex-shrink-0 group">
                <div
                    class="w-[220px] h-[220px] rounded-2xl overflow-hidden mb-3 shadow-md group-hover:shadow-xl transition-shadow">
                    <img src="https://images.unsplash.com/photo-1578469550956-0e16b69c6a3d?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8am9namFrYXJ0YXxlbnwwfHwwfHx8MA%3D%3D"
                        alt="Yogyakarta"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <h3 class="font-bold text-[17px] text-[#2a2a2e] mb-1">Yogyakarta</h3>
                <p class="text-[14px] text-[#53535f]">5.503 akomodasi</p>
            </a>

            <!-- Surabaya -->
            <a href="#" class="flex-shrink-0 group">
                <div
                    class="w-[220px] h-[220px] rounded-2xl overflow-hidden mb-3 shadow-md group-hover:shadow-xl transition-shadow">
                    <img src="https://images.unsplash.com/photo-1578916171728-46686eac8d58?w=400&h=400&fit=crop"
                        alt="Surabaya"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <h3 class="font-bold text-[17px] text-[#2a2a2e] mb-1">Surabaya</h3>
                <p class="text-[14px] text-[#53535f]">3.145 akomodasi</p>
            </a>

            <!-- Bali -->
            <a href="#" class="flex-shrink-0 group">
                <div
                    class="w-[220px] h-[220px] rounded-2xl overflow-hidden mb-3 shadow-md group-hover:shadow-xl transition-shadow">
                    <img src="https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?w=400&h=400&fit=crop"
                        alt="Bali"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <h3 class="font-bold text-[17px] text-[#2a2a2e] mb-1">Bali</h3>
                <p class="text-[14px] text-[#53535f]">32.908 akomodasi</p>
            </a>
        </div>
    </div>

    {{-- SECTION: Promo akomodasi --}}
    <div class="max-w-[1240px] mx-auto px-4 py-12">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-[28px] font-bold text-[#2a2a2e]">Jangan sampai kelewatan promo akomodasi ini!</h2>
            <a href="#" class="text-[#0057b8] font-bold text-[15px] hover:underline flex items-center">
                Lihat semua <i class="fa-solid fa-chevron-right ml-2 text-sm"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <div
                class="rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow cursor-pointer bg-gradient-to-br from-purple-600 to-purple-800">
                <div class="p-8 text-white text-center">
                    <div class="mb-4">
                        <i class="fa-solid fa-percent text-6xl opacity-90"></i>
                    </div>
                    <h3 class="text-3xl font-black mb-3">Temukan semua</h3>
                    <h4 class="text-4xl font-black mb-3">promo Anda</h4>
                    <p class="text-2xl font-black">di sini! 👆</p>
                </div>
            </div>

            <div class="rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow cursor-pointer">
                <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=600&h=400&fit=crop"
                    alt="Promo Accor" class="w-full h-[280px] object-cover">
            </div>

            <div
                class="rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow cursor-pointer bg-gradient-to-br from-slate-800 to-slate-950">
                <div class="p-8 text-white flex flex-col justify-center items-center h-[280px]">
                    <div class="text-center mb-4">
                        <div class="text-5xl font-black mb-2">All</div>
                        <div class="text-xl font-semibold">ACCOR</div>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Exclusive Offers</h3>
                    <p class="text-lg font-semibold">with Accor</p>
                    <p class="text-sm mt-2 opacity-75">T&Cs apply</p>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION: Promo penerbangan & aktivitas --}}
    <div class="max-w-[1240px] mx-auto px-4 py-12">
        <h2 class="text-[28px] font-bold text-[#2a2a2e] mb-8">Liburan lebih irit pakai promo Penerbangan & Aktivitas
            ini!</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <div
                class="rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow cursor-pointer bg-gradient-to-r from-orange-500 to-orange-600">
                <div class="p-8 text-white">
                    <div class="flex items-start justify-between mb-4">
                        <i class="fa-solid fa-ticket text-3xl"></i>
                        <span class="bg-white text-orange-600 text-xs font-bold px-2 py-1 rounded">Seluruh Dunia</span>
                    </div>
                    <h3 class="text-2xl font-black mb-2">Tur, Atraksi, dan Lainnya</h3>
                    <p class="text-3xl font-black mb-3">Diskon Hingga</p>
                    <p class="text-5xl font-black mb-2">5%</p>
                    <p class="text-sm font-semibold">Tanpa Belanja Minimum</p>
                    <p class="text-xs mt-2 opacity-90">*S&K berlaku</p>
                </div>
            </div>

            <div
                class="rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow cursor-pointer bg-gradient-to-br from-slate-900 to-blue-900">
                <img src="https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=600&h=400&fit=crop"
                    alt="Halloween Horror Nights" class="w-full h-[320px] object-cover">
            </div>

            <div
                class="rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow cursor-pointer bg-gradient-to-br from-purple-600 via-pink-500 to-purple-700">
                <div class="p-8 text-white flex flex-col justify-center h-[320px]">
                    <span
                        class="bg-yellow-300 text-purple-800 text-xs font-black px-3 py-1 rounded-full inline-block mb-4 w-fit">FLASH
                        SALE</span>
                    <h3 class="text-4xl font-black mb-4">Up to <span class="text-yellow-300">5% off</span></h3>
                    <p class="text-xl font-bold">On all flights, every day!</p>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION: Rumah liburan di Agoda --}}
    <div class="max-w-[1240px] mx-auto px-4 py-12">
        <h2 class="text-[28px] font-bold text-[#2a2a2e] mb-8">Coba suasana yang beda, cek rumah liburan di Agoda!</h2>

        <div class="border-b border-gray-300 mb-6">
            <div class="flex space-x-8 overflow-x-auto scrollbar-hide">
                <button
                    class="pb-4 border-b-4 border-[#0057b8] text-[#0057b8] font-bold text-[15px] whitespace-nowrap">Jakarta</button>
                <button
                    class="pb-4 text-[#53535f] font-semibold text-[15px] hover:text-[#0057b8] whitespace-nowrap">Bandung</button>
                <button
                    class="pb-4 text-[#53535f] font-semibold text-[15px] hover:text-[#0057b8] whitespace-nowrap">Yogyakarta</button>
                <button
                    class="pb-4 text-[#53535f] font-semibold text-[15px] hover:text-[#0057b8] whitespace-nowrap">Surabaya</button>
                <button
                    class="pb-4 text-[#53535f] font-semibold text-[15px] hover:text-[#0057b8] whitespace-nowrap">Bali</button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <a href="#" class="group">
                <div class="rounded-2xl overflow-hidden shadow-md group-hover:shadow-2xl transition-shadow relative">
                    <span
                        class="absolute top-3 right-3 bg-[#0057b8] text-white px-3 py-1.5 rounded-lg font-bold text-sm z-10">9.1</span>
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&h=400&fit=crop"
                        alt="Hotel"
                        class="w-full h-[220px] object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <div class="mt-3">
                    <h3 class="font-bold text-[16px] text-[#2a2a2e] mb-2">Bobopod Juanda, Jakarta</h3>
                    <div class="flex items-center text-orange-500 text-sm mb-2">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <p class="text-[13px] text-[#53535f] mb-1"><i
                            class="fa-solid fa-location-dot text-[#0057b8] mr-1"></i> Pasar Baru, Jakarta</p>
                    <p class="text-[13px] text-[#53535f] mb-2">Per malam sebelum pajak dan biaya lainnya</p>
                    <p class="text-[#e12d2d] font-bold text-[19px]">IDR 257,566</p>
                </div>
            </a>

            <a href="#" class="group">
                <div class="rounded-2xl overflow-hidden shadow-md group-hover:shadow-2xl transition-shadow relative">
                    <span
                        class="absolute top-3 right-3 bg-[#0057b8] text-white px-3 py-1.5 rounded-lg font-bold text-sm z-10">8.9</span>
                    <img src="https://images.unsplash.com/photo-1562790351-d273a961e0e9?w=600&h=400&fit=crop"
                        alt="Hotel"
                        class="w-full h-[220px] object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <div class="mt-3">
                    <h3 class="font-bold text-[16px] text-[#2a2a2e] mb-2">All Nite & Day Residence Kebon Jeruk Jakarta
                    </h3>
                    <div class="flex items-center text-orange-500 text-sm mb-2">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <p class="text-[13px] text-[#53535f] mb-1"><i
                            class="fa-solid fa-location-dot text-[#0057b8] mr-1"></i> Kebon Jeruk, Jakarta</p>
                    <p class="text-[13px] text-[#53535f] mb-2">Per malam sebelum pajak dan biaya lainnya</p>
                    <p class="text-[#e12d2d] font-bold text-[19px]">IDR 383,039</p>
                </div>
            </a>

            <a href="#" class="group">
                <div class="rounded-2xl overflow-hidden shadow-md group-hover:shadow-2xl transition-shadow relative">
                    <span
                        class="absolute top-3 right-3 bg-[#0057b8] text-white px-3 py-1.5 rounded-lg font-bold text-sm z-10">8.4</span>
                    <img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=600&h=400&fit=crop"
                        alt="Hotel"
                        class="w-full h-[220px] object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <div class="mt-3">
                    <h3 class="font-bold text-[16px] text-[#2a2a2e] mb-2">101 URBAN Jakarta Glodok - Kota Tua</h3>
                    <div class="flex items-center text-orange-500 text-sm mb-2">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <p class="text-[13px] text-[#53535f] mb-1"><i
                            class="fa-solid fa-location-dot text-[#0057b8] mr-1"></i> Mangga Besar, Jakarta</p>
                    <p class="text-[13px] text-[#53535f] mb-2">Per malam sebelum pajak dan biaya lainnya</p>
                    <p class="text-[#e12d2d] font-bold text-[19px]">IDR 218,258</p>
                </div>
            </a>

            <a href="#" class="group">
                <div class="rounded-2xl overflow-hidden shadow-md group-hover:shadow-2xl transition-shadow relative">
                    <span
                        class="absolute top-3 right-3 bg-[#0057b8] text-white px-3 py-1.5 rounded-lg font-bold text-sm z-10">8.4</span>
                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=600&h=400&fit=crop"
                        alt="Hotel"
                        class="w-full h-[220px] object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <div class="mt-3">
                    <h3 class="font-bold text-[16px] text-[#2a2a2e] mb-2">The Gloria Suites Grogol, Jakarta</h3>
                    <div class="flex items-center text-orange-500 text-sm mb-2">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <p class="text-[13px] text-[#53535f] mb-1"><i
                            class="fa-solid fa-location-dot text-[#0057b8] mr-1"></i> Grogol, Jakarta</p>
                    <p class="text-[13px] text-[#53535f] mb-2">Per malam sebelum pajak dan biaya lainnya</p>
                    <p class="text-[#e12d2d] font-bold text-[19px]">IDR 295,747</p>
                </div>
            </a>
        </div>

        <div class="text-center mt-8">
            <a href="#"
                class="text-[#0057b8] font-bold text-[15px] hover:underline flex items-center justify-center">
                Lihat properti (Jakarta) lainnya <i class="fa-solid fa-chevron-right ml-2 text-sm"></i>
            </a>
        </div>
    </div>

    {{-- SECTION: Destinasi luar Indonesia --}}
    <div class="max-w-[1240px] mx-auto px-4 py-12">
        <h2 class="text-[28px] font-bold text-[#2a2a2e] mb-8">Destinasi populer di luar Indonesia</h2>

        <div class="flex overflow-x-auto space-x-5 pb-4 scrollbar-hide">
            <a href="#" class="flex-shrink-0 group">
                <div
                    class="w-[220px] h-[220px] rounded-2xl overflow-hidden mb-3 shadow-md group-hover:shadow-xl transition-shadow">
                    <img src="https://images.unsplash.com/photo-1596422846543-75c6fc197f07?w=400&h=400&fit=crop"
                        alt="Kuala Lumpur"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <h3 class="font-bold text-[17px] text-[#2a2a2e] mb-1">Kuala Lumpur</h3>
                <p class="text-[14px] text-[#53535f]">19.902 akomodasi</p>
            </a>

            <a href="#" class="flex-shrink-0 group">
                <div
                    class="w-[220px] h-[220px] rounded-2xl overflow-hidden mb-3 shadow-md group-hover:shadow-xl transition-shadow">
                    <img src="https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=400&h=400&fit=crop"
                        alt="Tokyo"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <h3 class="font-bold text-[17px] text-[#2a2a2e] mb-1">Tokyo</h3>
                <p class="text-[14px] text-[#53535f]">12.486 akomodasi</p>
            </a>

            <a href="#" class="flex-shrink-0 group">
                <div
                    class="w-[220px] h-[220px] rounded-2xl overflow-hidden mb-3 shadow-md group-hover:shadow-xl transition-shadow">
                    <img src="https://plus.unsplash.com/premium_photo-1661951189203-12decb9d7f8e?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8dGFpY2h1bmclMjBjaXR5fGVufDB8fDB8fHww"
                        alt="Taichung"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <h3 class="font-bold text-[17px] text-[#2a2a2e] mb-1">Taichung</h3>
                <p class="text-[14px] text-[#53535f]">1.918 akomodasi</p>
            </a>

            <a href="#" class="flex-shrink-0 group">
                <div
                    class="w-[220px] h-[220px] rounded-2xl overflow-hidden mb-3 shadow-md group-hover:shadow-xl transition-shadow">
                    <img src="https://images.unsplash.com/photo-1524413840807-0c3cb6fa808d?w=400&h=400&fit=crop"
                        alt="Taipei"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <h3 class="font-bold text-[17px] text-[#2a2a2e] mb-1">Taipei</h3>
                <p class="text-[14px] text-[#53535f]">3.566 akomodasi</p>
            </a>

            <a href="#" class="flex-shrink-0 group">
                <div
                    class="w-[220px] h-[220px] rounded-2xl overflow-hidden mb-3 shadow-md group-hover:shadow-xl transition-shadow">
                    <img src="https://images.unsplash.com/photo-1687861717577-8ff74dd61a47?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8am9ob3IlMjBiYWhydXxlbnwwfHwwfHx8MA%3D%3D"
                        alt="Johor Bahru"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <h3 class="font-bold text-[17px] text-[#2a2a2e] mb-1">Johor Bahru</h3>
                <p class="text-[14px] text-[#53535f]">6.994 akomodasi</p>
            </a>
        </div>
    </div>

    {{-- FOOTER UTAMA --}}
    <footer class="bg-[#f7f9fa] border-t border-gray-200 mt-16">
        <div class="max-w-[1240px] mx-auto px-4 py-12">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 mb-12">
                <div>
                    <h3 class="font-bold text-[15px] text-[#2a2a2e] mb-4">Bantuan</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Pusat
                                bantuan</a></li>
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">FAQ</a></li>
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Kebijakan
                                privasi</a></li>
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Kebijakan
                                cookie</a></li>
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Ketentuan
                                penggunaan</a></li>
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Kelola
                                preferensi cookie</a></li>
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Undang-Undang
                                Layanan Digital (DSA) Uni Eropa</a></li>
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Pedoman konten &
                                pelaporan</a></li>
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Pernyataan
                                Perbudakan Modern</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-bold text-[15px] text-[#2a2a2e] mb-4">Perusahaan</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Tentang kami</a>
                        </li>
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Karier</a></li>
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Pers</a></li>
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Blog</a></li>
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">PointsMAX</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-bold text-[15px] text-[#2a2a2e] mb-4">Destinasi</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Negara</a></li>
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Semua Rute
                                Penerbangan</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-bold text-[15px] text-[#2a2a2e] mb-4">Jadi partner kami</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Portal partner
                                YCS</a></li>
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Partner Hub</a>
                        </li>
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Beriklan di
                                Agoda</a></li>
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Afiliasi</a>
                        </li>
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Dokumentasi API
                                Agoda</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-bold text-[15px] text-[#2a2a2e] mb-4">Unduh aplikasi</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Aplikasi iOS</a>
                        </li>
                        <li><a href="#" class="text-[14px] text-[#53535f] hover:text-[#0057b8]">Aplikasi
                                Android</a></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- FOOTER BAWAH GELAP DENGAN LOGO GROUP --}}
        <footer class="bg-[#2a2b2f] text-gray-300 pt-10 pb-20 w-full">
            <div class="max-w-7xl mx-auto px-4">
                <p class="text-[14px] text-center mb-2">
                    Hak cipta © 2005 – 2025 Agoda Company Pte. Ltd. Semua Hak Dilindungi Undang-undang.
                </p>
                <p class="text-[14px] text-center mb-10">
                    Agoda adalah bagian dari Booking Holdings Inc., pemimpin bisnis perjalanan online dan layanan
                    terkait lainnya di dunia.
                </p>

                <div class="flex justify-center items-center gap-40 flex-wrap">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b0/Agoda_Logo_2022.svg/330px-Agoda_Logo_2022.svg.png?20220609160512"
                        alt="Agoda" class="h-5 opacity-90 hover:opacity-100 transition">

                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/Priceline.com_logo.svg/500px-Priceline.com_logo.svg.png?20180821070811"
                        alt="Priceline" class="h-5 opacity-90 hover:opacity-100 transition">

                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4d/Kayak_Logo_2017.png/640px-Kayak_Logo_2017.png"
                        alt="Kayak" class="h-5 opacity-90 hover:opacity-100 transition">

                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/be/Booking.com_logo.svg/640px-Booking.com_logo.svg.png"
                        alt="Booking.com" class="h-5 opacity-90 hover:opacity-100 transition">

                    <img src="https://upload.wikimedia.org/wikipedia/commons/8/8a/OpenTable_logo2.png?20150321201431"
                        alt="OpenTable" class="h-5 opacity-90 hover:opacity-100 transition">
                </div>
            </div>
        </footer>
    </footer>

    <div class="fixed bottom-6 right-6 z-50">
        <button
            class="bg-[#0057b8] hover:bg-[#00449e] text-white font-bold py-3 px-5 rounded-full shadow-lg flex items-center space-x-2.5 transition-transform hover:-translate-y-1">
            <i class="fa-solid fa-mobile-screen-button text-xl"></i>
            <span class="text-[15px]">Lebih hemat di aplikasi!</span>
        </button>
    </div>

    <script>
        function toggleReturnDate() {
            const isRoundTrip = document.getElementById('roundtrip').checked;
            const returnWrapper = document.getElementById('return-date-wrapper');
            const dateContainer = document.getElementById('date-container');

            if (isRoundTrip) {
                returnWrapper.classList.remove('hidden');
                returnWrapper.classList.add('flex');
                dateContainer.children[0].classList.remove('border-r');
            } else {
                returnWrapper.classList.add('hidden');
                returnWrapper.classList.remove('flex');
                dateContainer.children[0].classList.add('border-r');
            }
        }
    </script>

</body>

</html>
