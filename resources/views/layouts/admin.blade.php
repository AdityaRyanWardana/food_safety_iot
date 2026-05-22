<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FoodDetect Admin')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        outfit: ['"Outfit"', 'sans-serif'],
                    },
                    colors: {
                        segoNavy: '#0D0E12', /* Pure Dark Black for Sego Style */
                        segoNavyLight: '#15171E',
                        segoOrange: '#8DC63F', /* Swapped to brandGreen */
                        segoOrangeHover: '#7CB532', /* Darker brandGreen */
                        segoGray: '#7E8B9B',
                        segoBg: '#F8F9FB',
                        brandGreen: '#8DC63F',
                        brandGreenHover: '#7CB532',
                    }
                }
            }
        }
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
    </style>
</head>
<body class="font-sans text-[#2C3A4B] antialiased bg-segoBg flex h-screen overflow-hidden">

    <!-- Sidebar (Gaya Hitam-Hijau FoodDetect) -->
    <aside class="w-[260px] bg-segoNavy text-white flex flex-col h-full flex-shrink-0 border-r border-white/5 relative">
        <!-- Logo Brand -->
        <a href="{{ route('admin.dashboard') }}" class="h-20 flex items-center px-6 gap-3 mb-4 hover:opacity-90 transition duration-200 group/logo">
            <div class="w-10 h-10 rounded-full bg-brandGreen flex items-center justify-center font-bold text-white text-base font-outfit shadow-md shadow-brandGreen/25 group-hover/logo:scale-105 transition duration-300">
                Fd
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-tight font-outfit leading-tight text-white group-hover/logo:text-brandGreen transition duration-300">FoodDetect</h1>
                <p class="text-[9px] font-bold text-brandGreen uppercase tracking-widest mt-0.5">Admin Monitoring</p>
            </div>
        </a>
        
        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto custom-scrollbar">
            <p class="px-3 text-[10px] font-extrabold text-segoGray/60 uppercase tracking-widest mb-3">Main Menu</p>
            
            <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-3 rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-brandGreen text-white font-bold shadow-lg shadow-brandGreen/20' : 'text-white/60 hover:bg-white/5 hover:text-white' }} shadow-sm">
                <i class="fa-solid fa-chart-pie w-6 text-base transition group-hover:scale-110 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-white/40 group-hover:text-white' }}"></i>
                <span class="text-sm font-semibold">Dashboard</span>
            </a>
            
            <a href="{{ route('admin.sensors.index') }}" class="group flex items-center px-4 py-3 rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.sensors.*') ? 'bg-brandGreen text-white font-bold shadow-lg shadow-brandGreen/20' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                <i class="fa-solid fa-tower-broadcast w-6 text-base transition group-hover:scale-110 {{ request()->routeIs('admin.sensors.*') ? 'text-white' : 'text-white/40 group-hover:text-white' }}"></i>
                <span class="text-sm font-semibold">Data Sensor IoT</span>
            </a>
            
            <a href="{{ route('admin.contamination.index') }}" class="group flex items-center px-4 py-3 rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.contamination.*') ? 'bg-brandGreen text-white font-bold shadow-lg shadow-brandGreen/20' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                <i class="fa-solid fa-triangle-exclamation w-6 text-base transition group-hover:scale-110 {{ request()->routeIs('admin.contamination.*') ? 'text-white' : 'text-white/40 group-hover:text-white' }}"></i>
                <span class="text-sm font-semibold">Log Kontaminasi</span>
            </a>
            
            <a href="{{ route('admin.categories.index') }}" class="group flex items-center px-4 py-3 rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.categories.*') ? 'bg-brandGreen text-white font-bold shadow-lg shadow-brandGreen/20' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                <i class="fa-solid fa-boxes-stacked w-6 text-base transition group-hover:scale-110 {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-white/40 group-hover:text-white' }}"></i>
                <span class="text-sm font-semibold">Kategori Pangan</span>
            </a>

            <p class="px-3 text-[10px] font-extrabold text-segoGray/60 uppercase tracking-widest mb-3 pt-6">Pengetesan</p>
            
            <a href="{{ route('admin.testing.index') }}" class="group flex items-center px-4 py-3 rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.testing.*') ? 'bg-brandGreen text-white font-bold shadow-lg shadow-brandGreen/20' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                <i class="fa-solid fa-flask-vial w-6 text-base transition group-hover:scale-110 {{ request()->routeIs('admin.testing.*') ? 'text-white' : 'text-white/40 group-hover:text-white' }}"></i>
                <span class="text-sm font-semibold">Tes Sensor USB</span>
            </a>

            <p class="px-3 text-[10px] font-extrabold text-segoGray/60 uppercase tracking-widest mb-3 pt-6">Manajemen</p>
            
            <a href="{{ route('admin.profile.edit') }}" class="group flex items-center px-4 py-3 rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.profile.edit') ? 'bg-brandGreen text-white font-bold shadow-lg shadow-brandGreen/20' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                <i class="fa-solid fa-user-gear w-6 text-base transition group-hover:scale-110 {{ request()->routeIs('admin.profile.edit') ? 'text-white' : 'text-white/40 group-hover:text-white' }}"></i>
                <span class="text-sm font-semibold">Edit Profil</span>
            </a>
        </nav>
        
        <!-- Kartu Promo Hijau di Sidebar Bawah -->
        <div class="p-4 mx-4 mb-6 rounded-2xl bg-brandGreen/10 border border-brandGreen/20 flex flex-col items-center text-center relative overflow-hidden">
            <div class="w-10 h-10 rounded-full bg-brandGreen flex items-center justify-center text-white mb-2 shadow-sm shadow-brandGreen/20">
                <i class="fa-solid fa-circle-nodes"></i>
            </div>
            <p class="text-[10px] font-extrabold tracking-wider text-white uppercase">Tes Kualitas Pangan</p>
            <p class="text-[9px] text-white/55 mt-1 leading-relaxed max-w-[150px]">Lakukan analisa mandiri sampel di Laboratorium.</p>
            <a href="{{ route('admin.testing.index') }}" class="mt-3.5 w-full bg-white text-brandGreen hover:bg-white/95 text-[11px] font-extrabold py-2 px-4 rounded-xl transition duration-300 flex items-center justify-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-flask"></i> Mulai Tes
            </a>
        </div>

        <!-- Logout -->
        <div class="p-4 border-t border-white/5 bg-black/15">
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="group flex w-full items-center px-4 py-2.5 text-white/60 hover:text-red-400 hover:bg-red-500/5 rounded-xl transition duration-300 text-sm font-semibold">
                    <i class="fa-solid fa-arrow-right-from-bracket w-6 text-base text-white/40 group-hover:text-red-400 group-hover:translate-x-1 transition duration-300"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <!-- Header (Gaya Hitam-Hijau) -->
        <header class="h-20 bg-white border-b border-gray-150/70 flex items-center justify-between px-8 z-10">
            <div>
                <h2 class="text-xl font-bold font-outfit text-gray-900 tracking-tight">@yield('breadcrumb', 'Analytics')</h2>
            </div>
            
            <div class="flex items-center gap-6">
                <!-- Search bar placeholder untuk estetika Sego -->
                <div class="hidden md:flex items-center bg-[#F3F4F6] px-4 py-2.5 rounded-2xl w-[260px] border border-gray-100">
                    <input type="text" placeholder="Cari di sini..." class="bg-transparent text-xs text-gray-700 outline-none w-full placeholder-gray-400">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs"></i>
                </div>
                
                <!-- Profile Sego -->
                <a href="{{ route('admin.profile.edit') }}" class="flex items-center space-x-3 pl-5 border-l border-gray-200 group">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brandGreen to-[#7CB532] text-white flex items-center justify-center font-black text-xs shadow-md shadow-brandGreen/25 group-hover:rotate-6 transition duration-300">
                        {{ strtoupper(substr(Auth::user()->name ?? 'AL', 0, 2)) }}
                    </div>
                    <div class="text-left hidden sm:block">
                        <p class="text-xs font-bold text-gray-900 leading-tight group-hover:text-brandGreen transition duration-300">{{ Auth::user()->name ?? 'Admin Lab' }}</p>
                        <p class="text-[9px] font-bold text-segoGray mt-0.5 tracking-wider uppercase">{{ Auth::user()->email ?? 'Quality Control' }}</p>
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] text-segoGray group-hover:translate-y-0.5 transition duration-300"></i>
                </a>
            </div>
        </header>

        <!-- Main Inner Area (Murni Light Mode) -->
        <div class="flex-1 overflow-y-auto p-8 bg-segoBg">
            @yield('content')
        </div>
    </main>
</body>
</html>
