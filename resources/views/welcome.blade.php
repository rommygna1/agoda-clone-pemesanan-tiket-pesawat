<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agoda: Pesan Hotel & Penerbangan Murah</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        /* Custom styles untuk meniru input Agoda */
        .agoda-input-container {
            position: relative;
            display: flex;
            align-items: center;
            height: 64px; /* Tinggi fix agar sama rata */
            background: white;
            transition: all 0.2s;
        }
        .agoda-input-container:hover {
            background-color: #f8f9fa;
            z-index: 5; /* Agar border hover muncul di atas */
        }
        /* Input field transparan di atas container */
        .agoda-input-field {
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            padding-left: 54px; /* Ruang untuk ikon */
            padding-right: 16px;
            font-weight: 600;
            color: #2a2a2e;
            font-size: 16px;
            cursor: pointer;
            appearance: none; /* Hilangkan style default select */
        }
        /* Placeholder style */
        .agoda-input-field::placeholder {
            color: #4a4a4a;
            font-weight: 500;
        }
        /* Ikon di dalam input */
        .agoda-input-icon {
            position: absolute;
            left: 20px;
            color: #53535f;
            font-size: 20px;
            pointer-events: none;
        }
        /* Tombol Radio berbentuk Pil */
        .trip-type-radio:checked + label {
            background-color: #eef6fc;
            color: #0057b8;
            border-color: #eef6fc;
        }
    </style>
</head>
<body class="bg-gray-100">

    <nav class="bg-white border-b border-gray-200 fixed w-full top-0 z-50 h-[68px] flex items-center">
        <div class="max-w-[1240px] mx-auto px-4 w-full flex justify-between items-center">
            <div class="flex items-center">
                <a href="/" class="mr-8">
                    <img src="https://images.seeklogo.com/logo-png/37/1/agoda-logo-png_seeklogo-371025.png" alt="Agoda" class="h-18 md:h-16 w-auto">
                </a>

                <div class="hidden lg:flex space-x-5 text-[15px] font-semibold text-[#53535f]">
                    <a href="#" class="hover:text-black flex items-center">
                        Pesawat + Hotel 
                        <span class="bg-[#e12d2d] text-white text-[10px] px-1.5 py-[1px] rounded-sm ml-1.5 font-bold uppercase leading-tight">Paket hemat!</span>
                    </a>
                    <a href="#" class="hover:text-black">Akomodasi</a>
                    <a href="#" class="hover:text-black flex items-center">
                        Transportasi <i class="fa-solid fa-chevron-down text-xs ml-1.5 opacity-70"></i>
                    </a>
                    <a href="#" class="hover:text-black">Aktivitas</a>
                    <a href="#" class="hover:text-black">Kupon & Promo</a>
                    <a href="#" class="hover:text-black text-xl leading-none pb-2">...</a>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <button class="flex items-center space-x-1.5 hover:bg-gray-100 p-2 rounded text-[#53535f] font-semibold text-sm">
                    <img src="https://flagcdn.com/w20/id.png" alt="ID" class="w-5 h-auto rounded-[2px] shadow-sm opacity-80">
                    <span>Rp</span>
                </button>

                @auth
                    <a href="{{ url('/dashboard') }}" class="text-[#0057b8] font-bold text-sm px-4 py-2 hover:bg-[#f3f8fd] rounded">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-[#0057b8] font-bold text-[15px] px-4 py-2.5 hover:bg-[#f3f8fd] rounded transition">Masuk</a>
                    <a href="{{ route('register') }}" class="text-[#0057b8] font-bold text-[15px] border-2 border-[#0057b8] px-5 py-2 rounded hover:bg-[#f3f8fd] transition">Buat akun</a>
                @endauth

                <button class="lg:hidden text-[#53535f] p-2">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </nav>

    <div class="pt-[68px]">
        <div class="relative h-[580px] w-full bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1500375592092-40eb2168fd21?ixlib=rb-4.0.3&auto=format&fit=crop&w=2200&q=80');">
            <div class="absolute inset-0 bg-black/10"></div>

            <div class="relative max-w-[1100px] mx-auto px-4 pt-14 z-10">
                <h1 class="text-3xl md:text-[34px] font-extrabold text-white text-center drop-shadow mb-2 tracking-wide">
                    PESAN PENERBANGAN TERBAIK DI AGODA HARI INI
                </h1>
                <p class="text-lg md:text-[20px] text-white text-center font-semibold drop-shadow-md mb-10">
                    Cari dan pesan di lebih dari 200 maskapai di seluruh dunia
                </p>

                <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
                    
                    <div class="flex overflow-x-auto scrollbar-hide border-b border-gray-200">
                        <button class="flex items-center px-6 py-4 text-[#53535f] hover:text-black hover:bg-gray-50 focus:outline-none transition min-w-max">
                            <i class="fa-solid fa-hotel text-lg mr-2.5"></i>
                            <span class="font-semibold text-[15px]">Hotel</span>
                        </button>
                        <button class="flex items-center px-6 py-4 text-[#53535f] hover:text-black hover:bg-gray-50 focus:outline-none transition min-w-max">
                            <i class="fa-solid fa-house-chimney text-lg mr-2.5"></i>
                            <span class="font-semibold text-[15px]">Rumah & Apt</span>
                        </button>
                        <button class="flex items-center px-6 py-4 text-[#53535f] hover:text-black hover:bg-gray-50 focus:outline-none transition min-w-max">
                            <i class="fa-solid fa-plane-departure text-lg mr-2.5"></i>
                            <span class="font-semibold text-[15px]">Pesawat + Hotel</span>
                        </button>
                        <button class="flex items-center px-6 py-4 text-[#0057b8] border-b-[3px] border-[#0057b8] focus:outline-none transition min-w-max relative top-[1px] bg-white z-10">
                            <i class="fa-solid fa-plane text-lg mr-2.5 rotate-[-45deg]"></i>
                            <span class="font-bold text-[15px]">Pesawat</span>
                        </button>
                        <button class="flex items-center px-6 py-4 text-[#53535f] hover:text-black hover:bg-gray-50 focus:outline-none transition min-w-max">
                            <i class="fa-solid fa-person-snowboarding text-lg mr-2.5"></i>
                            <span class="font-semibold text-[15px]">Aktivitas</span>
                        </button>
                        <button class="flex items-center px-6 py-4 text-[#53535f] hover:text-black hover:bg-gray-50 focus:outline-none transition min-w-max">
                            <i class="fa-solid fa-car text-lg mr-2.5"></i>
                            <span class="font-semibold text-[15px]">Transfer bandara</span>
                        </button>
                    </div>

                    <div class="p-8 bg-white">
                        <form action="{{ route('search') }}" method="GET">
                            
                            <div class="flex space-x-3 mb-5">
                                <div>
                                    <input type="radio" id="oneway" name="trip_type" value="one_way" class="hidden trip-type-radio" checked onchange="toggleReturnDate()">
                                    <label for="oneway" class="cursor-pointer px-5 py-2.5 rounded-full border border-transparent font-bold text-sm text-[#53535f] hover:bg-gray-100 transition-colors select-none inline-block">Satu arah</label>
                                </div>
                                <div>
                                    <input type="radio" id="roundtrip" name="trip_type" value="round_trip" class="hidden trip-type-radio" onchange="toggleReturnDate()">
                                    <label for="roundtrip" class="cursor-pointer px-5 py-2.5 rounded-full border border-transparent font-bold text-sm text-[#53535f] hover:bg-gray-100 transition-colors select-none inline-block">Pulang pergi</label>
                                </div>
                            </div>

                            <div class="border border-gray-300 rounded-xl shadow-sm overflow-hidden mb-6 relative z-0">
                                
                                <div class="flex flex-col md:flex-row relative border-b border-gray-300 z-10">
                                    
                                    <div class="flex-1 agoda-input-container md:border-r border-gray-300">
                                        <i class="fa-solid fa-plane-departure agoda-input-icon"></i>
                                        <select name="origin" class="agoda-input-field" required>
                                            <option value="" disabled selected hidden>Dari mana?</option>
                                            @foreach($airports as $airport)
                                                <option value="{{ $airport->id }}">{{ $airport->city }} ({{ $airport->iata_code }})</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 z-20 hidden md:block">
                                        <button type="button" class="bg-white border border-gray-200 rounded-full p-2 shadow-sm hover:bg-gray-50 hover:shadow transition group">
                                            <i class="fa-solid fa-arrow-right-arrow-left text-[#0057b8] group-hover:rotate-180 transition-transform duration-300"></i>
                                        </button>
                                    </div>

                                    <div class="flex-1 agoda-input-container">
                                        <i class="fa-solid fa-location-dot agoda-input-icon"></i>
                                        <select name="destination" class="agoda-input-field" required>
                                            <option value="" disabled selected hidden>Ke mana?</option>
                                            @foreach($airports as $airport)
                                                <option value="{{ $airport->id }}">{{ $airport->city }} ({{ $airport->iata_code }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="flex flex-col md:flex-row relative z-0">
                                    
                                    <div class="flex-1 flex md:border-r border-gray-300 transition-all duration-300" id="date-container">
                                        <div class="flex-1 agoda-input-container border-r border-gray-300 relative z-10">
                                            <i class="fa-regular fa-calendar agoda-input-icon"></i>
                                            <input type="date" name="date" required min="{{ date('Y-m-d') }}" class="agoda-input-field uppercase" placeholder="Pergi">
                                            </div>

                                        <div id="return-date-wrapper" class="hidden flex-1 agoda-input-container relative z-0 bg-gray-50">
                                            <i class="fa-regular fa-calendar-check agoda-input-icon opacity-60"></i>
                                            <input type="date" name="return_date" min="{{ date('Y-m-d') }}" class="agoda-input-field uppercase bg-transparent" placeholder="Pulang">
                                        </div>
                                    </div>

                                    <div class="flex-1 agoda-input-container">
                                        <i class="fa-solid fa-user-group agoda-input-icon text-lg"></i>
                                        <select name="passengers" class="agoda-input-field appearance-none">
                                            <option value="1" selected>1 Penumpang, Economy</option>
                                            <option value="2">2 Penumpang, Economy</option>
                                            <option value="3">3 Penumpang, Economy</option>
                                            <option value="4">4 Penumpang, Economy</option>
                                        </select>
                                        <i class="fa-solid fa-chevron-down absolute right-5 text-gray-400 text-sm pointer-events-none"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center mb-8">
                                <div class="flex items-center h-5">
                                    <input id="hotel-promo" type="checkbox" class="w-5 h-5 text-[#0057b8] border-gray-300 rounded focus:ring-[#0057b8] cursor-pointer">
                                </div>
                                <label for="hotel-promo" class="ml-3 text-[#2a2a2e] text-[15px] font-medium cursor-pointer select-none flex items-center">
                                    Tambahkan hotel untuk hemat hingga 25% 
                                    <span class="bg-[#e12d2d] text-white text-[11px] px-1.5 py-[2px] rounded-sm ml-2 font-bold uppercase leading-none">Paket Hemat</span>
                                </label>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="w-full bg-[#0057b8] hover:bg-[#00449e] text-white text-[17px] font-bold py-[18px] rounded-xl shadow-lg hover:shadow-xl transition-all transform active:scale-[0.99]">
                                    CARI PENERBANGAN
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed bottom-6 right-6 z-50">
        <button class="bg-[#0057b8] hover:bg-[#00449e] text-white font-bold py-3 px-5 rounded-full shadow-lg flex items-center space-x-2.5 transition-transform hover:-translate-y-1">
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
                // Hapus border kanan di input tanggal pergi saat mode pulang pergi
                dateContainer.children[0].classList.remove('border-r');
            } else {
                returnWrapper.classList.add('hidden');
                returnWrapper.classList.remove('flex');
                 // Tambah border kanan lagi
                 dateContainer.children[0].classList.add('border-r');
            }
        }
    </script>

</body>
</html>