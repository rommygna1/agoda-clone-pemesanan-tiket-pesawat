<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: true }">
        
        <aside class="bg-gray-900 text-white transition-all duration-300 flex flex-col" 
               :class="sidebarOpen ? 'w-64' : 'w-20'">
            
            <div class="h-16 flex items-center justify-center border-b border-gray-800 bg-black/20">
                <span x-show="sidebarOpen" class="text-xl font-bold tracking-wider">ADMIN PANEL</span>
                <span x-show="!sidebarOpen" class="text-xl font-bold">AP</span>
            </div>

            <nav class="flex-1 px-2 py-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 bg-gray-800 rounded-md text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <span x-show="sidebarOpen" class="ml-3 font-medium">Dashboard</span>
                </a>

                <p x-show="sidebarOpen" class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-6 mb-2">Master Data</p>

                <a href="{{ route('admin.airports.index') }}" class="flex items-center px-4 py-2 text-gray-400 hover:bg-gray-800 hover:text-white rounded-md transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                    <span x-show="sidebarOpen" class="ml-3">Bandara</span>
                </a>
                
                <a href="{{ route('admin.airlines.index') }}" class="flex items-center px-4 py-2 text-gray-400 hover:bg-gray-800 hover:text-white rounded-md transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    <span x-show="sidebarOpen" class="ml-3">Maskapai</span>
                </a>

                <a href="{{ route('admin.flights.index') }}" class="flex items-center px-4 py-2 text-gray-400 hover:bg-gray-800 hover:text-white rounded-md transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span x-show="sidebarOpen" class="ml-3">Penerbangan</span>
                </a>
            </nav>

            <div class="p-4 border-t border-gray-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center text-red-400 hover:text-red-300 w-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span x-show="sidebarOpen" class="ml-3 text-sm font-bold">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            <header class="bg-white shadow h-16 flex items-center justify-between px-6 z-10">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="font-bold text-gray-700">Administrator Panel</div>
            </header>

            <div class="flex-1 overflow-auto p-8 bg-gray-100">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>