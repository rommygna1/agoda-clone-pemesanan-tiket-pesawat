<x-app-layout>
    {{-- Background Abu-abu tipis ala Agoda --}}
    <div class="min-h-screen bg-gray-50 pb-12 font-sans">

        {{-- Header Section dengan Nama User --}}

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-4">

                <div>
                    <h1 class="text-2xl font-bold text-white">{{ Auth::user()->name }}</h1>
                    <p class="text-blue-200 text-sm">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>


        {{-- Main Container (Overlap ke Header) --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                {{-- SIDEBAR MENU (Kiri) --}}
                <div class="col-span-1">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="p-4 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Akun Saya</span>
                        </div>
                        <nav class="flex flex-col">
                            {{-- Menu Trip Saya --}}
                            <a href="#"
                                class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium">Trip Saya</span>
                            </a>

                            {{-- Menu Semua Pesanan (Active State) --}}
                            <a href="{{ route('booking.index') }}"
                                class="flex items-center gap-3 px-4 py-3 text-blue-600 bg-blue-50 border-l-4 border-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span class="text-sm font-medium">Semua pesanan</span>
                            </a>

                            {{-- Menu Hotel --}}
                            <a href="#"
                                class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium">Hotel</span>
                            </a>

                            {{-- Menu Tiket Pesawat --}}
                            <a href="{{ route('booking.index') }}"
                                class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                <span class="text-sm font-medium">Tiket pesawat</span>
                            </a>

                            {{-- Menu Aktivitas --}}
                            <a href="#"
                                class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium">Aktivitas</span>
                            </a>

                            {{-- Menu Pesan dari Properti --}}
                            <a href="#"
                                class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium">Pesan dari Properti</span>
                            </a>

                            {{-- Menu Ulasan --}}
                            <a href="#"
                                class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium">Ulasan</span>
                            </a>

                            {{-- Menu AgodaVIP --}}
                            <a href="#"
                                class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium">AgodaVIP</span>
                            </a>

                            {{-- Menu AgodaTunai --}}
                            <a href="#"
                                class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium">AgodaTunai</span>
                            </a>

                            {{-- Menu Imbalan Cashback --}}
                            <a href="#"
                                class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium">Imbalan Cashback</span>
                            </a>

                            {{-- Menu PointsMAX --}}
                            <a href="#"
                                class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium">PointsMAX</span>
                            </a>

                            {{-- Menu Profil --}}
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors border-t border-gray-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-sm font-medium">Profil</span>
                            </a>

                            {{-- Menu Keluar --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex w-full items-center gap-3 px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-600 transition-colors text-left">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    <span class="text-sm font-medium">Keluar</span>
                                </button>
                            </form>
                        </nav>
                    </div>
                </div>

                {{-- MAIN CONTENT (Kanan) --}}
                <div class="col-span-1 md:col-span-3" x-data="{ activeTab: 'upcoming', viewMode: 'itinerary' }">

                    {{-- TABS NAVIGATION --}}
                    <div class="bg-white rounded-lg shadow-sm mb-6">
                        <div class="border-b border-gray-200">
                            <ul class="flex -mb-px text-sm font-medium text-center" role="tablist">
                                <li class="flex-1">
                                    <button @click="activeTab = 'upcoming'"
                                        :class="activeTab === 'upcoming' ? 'text-blue-600 border-b-2 border-blue-600' :
                                            'text-gray-600 hover:text-gray-800 border-transparent'"
                                        class="inline-block w-full p-4 transition-all font-semibold">
                                        Akan datang
                                    </button>
                                </li>
                                <li class="flex-1">
                                    <button @click="activeTab = 'completed'"
                                        :class="activeTab === 'completed' ? 'text-blue-600 border-b-2 border-blue-600' :
                                            'text-gray-600 hover:text-gray-800 border-transparent'"
                                        class="inline-block w-full p-4 transition-all font-semibold">
                                        Selesai
                                    </button>
                                </li>
                                <li class="flex-1">
                                    <button @click="activeTab = 'cancelled'"
                                        :class="activeTab === 'cancelled' ? 'text-blue-600 border-b-2 border-blue-600' :
                                            'text-gray-600 hover:text-gray-800 border-transparent'"
                                        class="inline-block w-full p-4 transition-all font-semibold">
                                        Dibatalkan
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- View Toggle (Itinerary / Daftar) -->
                        <div class="p-4 border-b border-gray-200">
                            <!-- gunakan grid 2 kolom agar kedua tombol saling mengisi seluruh lebar -->
                            <div class="grid grid-cols-2 gap-2">
                                <button @click="viewMode = 'itinerary'"
                                    :class="viewMode === 'itinerary' ? 'bg-blue-50 text-blue-600 border-blue-600' :
                                        'bg-white text-gray-600 border-gray-300 hover:bg-gray-50'"
                                    class="flex items-center justify-center gap-2 w-full py-2 rounded-full border-2 transition-all font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                    Itinerari
                                </button>

                                <button @click="viewMode = 'list'"
                                    :class="viewMode === 'list' ? 'bg-blue-50 text-blue-600 border-blue-600' :
                                        'bg-white text-gray-600 border-gray-300 hover:bg-gray-50'"
                                    class="flex items-center justify-center gap-2 w-full py-2 rounded-full border-2 transition-all font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                    </svg>
                                    Daftar
                                </button>
                            </div>
                        </div>

                    </div>

                    {{-- CONTENT AREA --}}
                    <div class="bg-white rounded-lg shadow-sm p-6 min-h-[500px]">

                        {{-- Empty State --}}
                        <template
                            x-if="activeTab === 'upcoming' && {{ $bookings->where('status', '!=', 'cancelled')->isEmpty() ? 'true' : 'false' }}">
                            <div class="text-center py-16">
                                <div class="inline-flex items-center justify-center w-32 h-32 mb-6">
                                    <svg class="w-full h-full text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum ada rencana traveling</h3>
                                <p class="text-gray-500 mb-8 max-w-md mx-auto">Dunia menunggu! Jelajahi destinasi
                                    impian dan cari tahu petualangan berikutnya.</p>

                                {{-- Quick Action Buttons --}}
                                <div class="flex flex-wrap justify-center gap-4 mb-6">
                                    <a href="{{ route('home') }}"
                                        class="flex flex-col items-center gap-2 p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-all min-w-[120px]">
                                        <div
                                            class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center text-white">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z">
                                                </path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700">Cari Penerbangan</span>
                                    </a>
                                    <a href="#"
                                        class="flex flex-col items-center gap-2 p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-all min-w-[120px]">
                                        <div
                                            class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center text-white">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                </path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700">Cari Akomodasi</span>
                                    </a>
                                    <a href="#"
                                        class="flex flex-col items-center gap-2 p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-all min-w-[120px]">
                                        <div
                                            class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center text-white">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700">Cari Aktivitas</span>
                                    </a>
                                </div>

                                {{-- Merencanakan perjalanan berikutnya section --}}
                                <div class="mt-12 pt-8 border-t border-gray-200">
                                    <h4 class="text-lg font-bold text-gray-800 mb-6">Merencanakan perjalanan
                                        berikutnya?</h4>
                                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3">
                                        <a href="{{ route('home') }}"
                                            class="flex flex-col items-center gap-2 p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all">
                                            <svg class="w-8 h-8 text-blue-600" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z">
                                                </path>
                                            </svg>
                                            <span class="text-xs font-semibold text-gray-700 text-center">Cari
                                                Penerbangan</span>
                                        </a>
                                        <a href="#"
                                            class="flex flex-col items-center gap-2 p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all">
                                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                </path>
                                            </svg>
                                            <span class="text-xs font-semibold text-gray-700 text-center">Cari
                                                Akomodasi</span>
                                        </a>
                                        <a href="#"
                                            class="flex flex-col items-center gap-2 p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all">
                                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            <span class="text-xs font-semibold text-gray-700 text-center">Cari
                                                Aktivitas</span>
                                        </a>
                                        <a href="#"
                                            class="flex flex-col items-center gap-2 p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all">
                                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                            </svg>
                                            <span class="text-xs font-semibold text-gray-700 text-center">Cari Transfer
                                                Bandara</span>
                                        </a>
                                        <a href="#"
                                            class="flex flex-col items-center gap-2 p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all">
                                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2">
                                                </path>
                                            </svg>
                                            <span class="text-xs font-semibold text-gray-700 text-center">Cari Sewa
                                                Mobil</span>
                                        </a>
                                        <a href="#"
                                            class="flex flex-col items-center gap-2 p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all">
                                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z">
                                                </path>
                                            </svg>
                                            <span class="text-xs font-semibold text-gray-700 text-center">Temukan Opsi
                                                Transport...</span>
                                        </a>
                                        <a href="#"
                                            class="flex flex-col items-center gap-2 p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all">
                                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                                </path>
                                            </svg>
                                            <span class="text-xs font-semibold text-gray-700 text-center">Cari Kartu
                                                eSIM</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </template>

                        {{-- TAB: AKAN DATANG (dengan data tiket pesawat) --}}
                        <template
                            x-if="activeTab === 'upcoming' && {{ $bookings->where('status', '!=', 'cancelled')->isNotEmpty() ? 'true' : 'false' }}">
                            <div x-transition:enter="transition ease-out duration-300">
                                <div class="space-y-4">
                                    @foreach ($bookings->where('status', '!=', 'cancelled') as $booking)
                                        <div
                                            class="border-2 border-gray-200 rounded-xl p-6 hover:shadow-lg hover:border-blue-300 transition-all bg-white">

                                            {{-- Header Card --}}
                                            <div class="flex justify-between items-start mb-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h3 class="font-bold text-gray-800 text-lg">
                                                            {{ $booking->flight->origin->city ?? 'Origin' }} <span
                                                                class="text-gray-400 mx-1">&rarr;</span>
                                                            {{ $booking->flight->destination->city ?? 'Destination' }}
                                                        </h3>
                                                        <p class="text-sm text-gray-500">
                                                            Kode Booking: <span
                                                                class="font-mono font-medium text-gray-700">{{ $booking->booking_code }}</span>
                                                        </p>
                                                    </div>
                                                </div>

                                                {{-- Status Badge --}}
                                                @php
                                                    $statusClass = match ($booking->status) {
                                                        'paid', 'confirmed', 'success' => 'bg-green-100 text-green-700',
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'cancelled', 'failed' => 'bg-red-100 text-red-800',
                                                        default => 'bg-gray-100 text-gray-800',
                                                    };
                                                @endphp
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide {{ $statusClass }}">
                                                    {{ $booking->status }}
                                                </span>
                                            </div>

                                            <hr class="border-gray-100 my-4">

                                            {{-- Detail Penerbangan --}}
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                                <div>
                                                    <p class="text-gray-500 text-xs uppercase mb-1">Maskapai</p>
                                                    <div class="flex items-center gap-2">
                                                        <div class="flex items-center gap-3">
                                                            @if ($booking->flight->airline->logo ?? false)
                                                                <img src="{{ asset('storage/' . $booking->flight->airline->logo) }}"
                                                                    alt="{{ $booking->flight->airline->name }}"
                                                                    class="h-5 w-auto max-w-[62px] object-contain">
                                                              
                                                            @else
                                                                <div
                                                                    class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center text-xs font-bold text-gray-500">
                                                                    {{ substr($booking->flight->airline->name ?? 'A', 0, 1) }}
                                                                </div>
                                                            @endif

                                                        </div>
                                                        <span
                                                            class="font-semibold text-gray-700">{{ $booking->flight->airline->name ?? 'Maskapai' }}</span>
                                                        <span class="text-sm font-medium text-gray-700">
                                                                {{ $booking->flight->flight_number }}
                                                            </span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 text-xs uppercase mb-1">Jadwal Berangkat
                                                    </p>
                                                    <p class="font-semibold text-gray-700">
                                                        {{ \Carbon\Carbon::parse($booking->flight->departure_time)->format('d M Y, H:i') }}
                                                    </p>
                                                </div>
                                                <div class="text-right flex flex-col justify-end">
                                                    <a href="{{ route('booking.show', $booking->booking_code) }}"
                                                        class="text-blue-600 font-semibold hover:underline text-sm">
                                                        Lihat E-Tiket &rsaquo;
                                                    </a>
                                                </div>
                                            </div>

                                            <hr class="border-gray-200 my-5">

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </template>

                        {{-- TAB: SELESAI --}}
                        <template x-if="activeTab === 'completed'"
                            x-transition:enter="transition ease-out duration-300">
                            <div class="text-center py-16">
                                <div class="inline-flex items-center justify-center w-32 h-32 mb-6">
                                    <svg class="w-full h-full text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Belum ada perjalanan selesai</h3>
                                <p class="text-gray-500">Perjalanan yang sudah selesai akan muncul di sini.</p>
                            </div>
                        </template>

                        {{-- TAB: DIBATALKAN --}}
                        <template x-if="activeTab === 'cancelled'"
                            x-transition:enter="transition ease-out duration-300">
                            <div class="text-center py-16">
                                <div class="inline-flex items-center justify-center w-32 h-32 mb-6">
                                    <svg class="w-full h-full text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Belum ada pembatalan</h3>
                                <p class="text-gray-500">Pesanan yang dibatalkan akan muncul di sini.</p>
                            </div>
                        </template>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
