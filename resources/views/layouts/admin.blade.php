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
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Playfair Display"', 'serif'],
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brandGreen: '#8DC63F',
                        brandDark: '#1A1A1A',
                        bgLight: '#F3F4F6',
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans text-gray-800 antialiased bg-bgLight flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-brandDark text-white flex flex-col h-full flex-shrink-0">
        <div class="h-16 flex items-center px-6 border-b border-white/10">
            <h1 class="text-2xl font-serif font-bold tracking-tight">FoodDetect <span class="text-brandGreen text-sm sans-serif ml-1">v1.0</span></h1>
        </div>
        
        <nav class="flex-1 py-6 px-4 space-y-1 overflow-y-auto">
            <p class="px-2 text-xs font-semibold text-white/40 uppercase tracking-wider mb-2">Main Menu</p>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 bg-brandGreen text-white rounded-lg shadow-md shadow-brandGreen/20">
                <i class="fa-solid fa-chart-pie w-6"></i>
                <span class="font-medium">Dashboard Overview</span>
            </a>
            <a href="#" class="flex items-center px-3 py-2.5 text-white/70 hover:bg-white/5 hover:text-white rounded-lg transition">
                <i class="fa-solid fa-tower-broadcast w-6"></i>
                <span class="font-medium">Data Sensor IoT</span>
            </a>
            <a href="#" class="flex items-center px-3 py-2.5 text-white/70 hover:bg-white/5 hover:text-white rounded-lg transition">
                <i class="fa-solid fa-triangle-exclamation w-6"></i>
                <span class="font-medium">Log Kontaminasi</span>
            </a>
            <a href="#" class="flex items-center px-3 py-2.5 text-white/70 hover:bg-white/5 hover:text-white rounded-lg transition">
                <i class="fa-solid fa-boxes-stacked w-6"></i>
                <span class="font-medium">Kategori Pangan</span>
            </a>

            <p class="px-2 text-xs font-semibold text-white/40 uppercase tracking-wider mb-2 mt-6">Manajemen</p>
            <a href="{{ route('admin.profile.edit') }}" class="flex items-center px-3 py-2.5 {{ request()->routeIs('admin.profile.edit') ? 'bg-brandGreen text-white shadow-md shadow-brandGreen/20' : 'text-white/70 hover:bg-white/5 hover:text-white' }} rounded-lg transition">
                <i class="fa-solid fa-user-gear w-6"></i>
                <span class="font-medium">Edit Profil</span>
            </a>
        </nav>
        
        <div class="p-4 border-t border-white/10">
            <a href="{{ route('login') }}" class="flex items-center px-3 py-2 text-white/70 hover:text-white transition">
                <i class="fa-solid fa-arrow-right-from-bracket w-6"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-8 z-10">
            <div class="flex items-center text-sm">
                <span class="text-gray-400">Pages</span>
                <span class="mx-2 text-gray-300">/</span>
                <span class="font-semibold text-brandDark">@yield('breadcrumb', 'Dashboard')</span>
            </div>
            
            <div class="flex items-center space-x-5">
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-red-500 transition text-sm">
                        <i class="fa-solid fa-power-off"></i>
                    </button>
                </form>
                <a href="{{ route('admin.profile.edit') }}" class="flex items-center space-x-3 pl-5 border-l border-gray-200 group">
                    <div class="text-right">
                        <p class="text-sm font-bold text-brandDark leading-tight group-hover:text-brandGreen transition">{{ Auth::user()->name ?? 'Admin Lab' }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'Quality Control' }}</p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-brandGreen text-white flex items-center justify-center font-bold shadow-sm group-hover:scale-105 transition">
                        {{ strtoupper(substr(Auth::user()->name ?? 'AL', 0, 2)) }}
                    </div>
                </a>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            @yield('content')
        </div>
    </main>
</body>
</html>
