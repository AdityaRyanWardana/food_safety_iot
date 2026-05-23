<!DOCTYPE html>
<html lang="id">
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
                        segoNavy: '#0D0E12',
                        segoNavyLight: '#15171E',
                        segoGray: '#7E8B9B',
                        segoBg: '#D6E6F2', /* Clinical hardware light-blue */
                        brandGreen: '#8DC63F',
                        brandGreenHover: '#7CB532',
                        redBtn: '#E63946',
                        redBtnHover: '#D62828',
                        blueBtn: '#1E6091',
                        blueBtnHover: '#184E77'
                    }
                }
            }
        }
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #EBF3FA;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #BDCEDA;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #A3B8CC;
        }
        
        /* GUI Industrial Console Style Tokens */
        .desktop-window {
            border: 4px solid #334155;
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.4), 
                0 0 40px rgba(59, 130, 246, 0.1),
                inset 0 2px 4px rgba(255, 255, 255, 0.2);
            background-color: #D6E6F2;
        }
        
        .gui-sidebar-panel {
            background-color: #E6EEF4;
            border-right: 2px solid #BDCEDA;
        }
        
        .gui-tactile-btn {
            background: linear-gradient(180deg, #4A90E2 0%, #2172CD 100%);
            border: 2px solid #FFFFFF;
            color: #FFFFFF;
            font-weight: 800;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
            box-shadow: 0 3px 6px rgba(33, 114, 205, 0.25);
            transition: all 0.2s ease-in-out;
        }
        
        .gui-tactile-btn:hover {
            background: linear-gradient(180deg, #5C9FE6 0%, #3182DE 100%);
            box-shadow: 0 4px 8px rgba(33, 114, 205, 0.35);
            transform: translateY(-1px);
        }
        
        .gui-tactile-btn:active {
            background: linear-gradient(180deg, #1C65B7 0%, #15559E 100%);
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.2);
            transform: translateY(1px);
        }

        .gui-tactile-btn-active {
            background: linear-gradient(180deg, #10B981 0%, #047857 100%) !important;
            box-shadow: 0 4px 8px rgba(4, 120, 87, 0.3) !important;
            border-color: #FFFFFF !important;
        }

        .gui-tactile-btn-active:hover {
            background: linear-gradient(180deg, #34D399 0%, #059669 100%) !important;
        }
        
        .gui-btn-red {
            background: linear-gradient(180deg, #EF4444 0%, #B91C1C 100%);
            box-shadow: 0 3px 6px rgba(185, 28, 28, 0.25);
        }
        .gui-btn-red:hover {
            background: linear-gradient(180deg, #F87171 0%, #DC2626 100%);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-950 to-indigo-950 flex items-center justify-center p-4 sm:p-6 h-screen overflow-hidden font-sans">

    <!-- MAIN DESKTOP APPLICATION WINDOW CONTAINER -->
    <div class="desktop-window w-full max-w-[1600px] h-[92vh] rounded-3xl overflow-hidden flex flex-col relative">
        
        <!-- ==================== WINDOW TITLEBAR (Header) ==================== -->
        <header class="h-12 bg-[#E1ECF5] border-b border-[#BDCEDA] flex items-center justify-between px-6 z-20 flex-shrink-0">
            <!-- Left: App Icon & Title -->
            <div class="flex items-center gap-3 select-none">
                <div class="w-7 h-7 rounded-full bg-brandGreen flex items-center justify-center font-bold text-white text-xs font-outfit shadow-sm">
                    Fd
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-black text-blue-950 tracking-wider uppercase font-outfit">FoodDetect IoT</span>
                    <span class="text-[9px] font-black bg-blue-200/60 text-blue-800 px-1.5 py-0.5 rounded border border-blue-300/30 uppercase tracking-widest">Quality Control Terminal</span>
                </div>
            </div>
            
            <!-- Center: App Diagnostic Status -->
            <div class="hidden md:flex items-center bg-[#F3F4F6] px-4 py-1.5 rounded-xl border border-gray-200 shadow-inner gap-2">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span class="text-[9px] font-black text-gray-650 uppercase tracking-wider">Interface Online: USB COM3 ready</span>
            </div>
            
            <!-- Right: Profile & Windows Action Buttons -->
            <div class="flex items-center gap-4">
                <!-- User Profile -->
                <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-2 border-r border-[#BDCEDA] pr-4 group">
                    <div class="w-6 h-6 rounded-full bg-gradient-to-br from-brandGreen to-[#7CB532] text-white flex items-center justify-center font-black text-[10px] shadow-sm group-hover:rotate-6 transition duration-300">
                        {{ strtoupper(substr(Auth::user()->name ?? 'AL', 0, 2)) }}
                    </div>
                    <span class="text-[10px] font-extrabold text-blue-950 group-hover:text-blue-600 transition">{{ Auth::user()->name ?? 'Admin Lab' }}</span>
                </a>
                
                <!-- Windows Min/Max/Close Mock Buttons -->
                <div class="flex items-center gap-1.5 select-none">
                    <div onclick="alert('Aplikasi berjalan dalam mode full-window.')" class="w-3 h-3 rounded-full bg-yellow-500 hover:bg-yellow-600 cursor-pointer shadow-sm transition" title="Minimize"></div>
                    <div onclick="alert('Aplikasi sudah dimaksimalkan.')" class="w-3 h-3 rounded-full bg-green-500 hover:bg-green-600 cursor-pointer shadow-sm transition" title="Maximize"></div>
                    <form action="{{ route('logout') }}" method="POST" id="close-app-form" class="inline">
                        @csrf
                        <div onclick="if(confirm('Keluar dari portal dan tutup sesi QC?')) document.getElementById('close-app-form').submit();" class="w-3 h-3 rounded-full bg-red-500 hover:bg-red-650 cursor-pointer shadow-sm transition" title="Keluar & Tutup Aplikasi"></div>
                    </form>
                </div>
            </div>
        </header>

        <!-- ==================== APPLICATION BODY ==================== -->
        <div class="flex flex-1 overflow-hidden">
            
            <!-- LEFT CONTROLS SIDEBAR -->
            <aside class="gui-sidebar-panel w-[230px] flex flex-col p-4 flex-shrink-0 select-none justify-between">
                
                <!-- Navigation & Controls -->
                <div class="flex flex-col gap-4">
                    <!-- Section: NAVIGATION -->
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('admin.dashboard') }}" class="w-full py-2.5 px-4 rounded-xl text-xs font-black text-center text-white gui-tactile-btn flex items-center justify-start gap-2.5 {{ request()->routeIs('admin.dashboard') ? 'gui-tactile-btn-active' : '' }}">
                            <i class="fa-solid fa-desktop w-4 text-center"></i> Home Dashboard
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="w-full py-2.5 px-4 rounded-xl text-xs font-black text-center text-white gui-tactile-btn flex items-center justify-start gap-2.5 {{ request()->routeIs('admin.categories.*') ? 'gui-tactile-btn-active' : '' }}">
                            <i class="fa-solid fa-circle-info w-4 text-center"></i> Information Mode
                        </a>
                        <a href="{{ route('admin.sensors.index') }}" class="w-full py-2.5 px-4 rounded-xl text-xs font-black text-center text-white gui-tactile-btn flex items-center justify-start gap-2.5 {{ request()->routeIs('admin.sensors.*') ? 'gui-tactile-btn-active' : '' }}">
                            <i class="fa-solid fa-wand-magic-sparkles w-4 text-center"></i> Mode Switcher
                        </a>
                    </div>
                    
                    <!-- Section: CONTROL PANEL -->
                    <div class="flex flex-col gap-3 border-t-2 border-blue-200/50 pt-3">
                        <h3 class="text-[10px] font-extrabold text-blue-900 tracking-wider uppercase">CONTROL PANEL</h3>
                        
                        <!-- Run Server toggle -->
                        <button id="layout-btn-run-server" onclick="toggleLayoutServer()" class="w-full py-3 px-4 rounded-xl text-[10px] font-black text-center text-white gui-tactile-btn flex items-center justify-center gap-2">
                            <span id="layout-led-server" class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse border border-white"></span>
                            <span id="layout-text-server">RUNNING SERVER</span>
                        </button>
                        
                        <!-- Start Test -->
                        <a href="{{ route('admin.testing.index') }}" class="w-full py-3 px-4 rounded-xl text-[10px] font-black text-center text-white gui-tactile-btn flex items-center justify-center gap-2 {{ request()->routeIs('admin.testing.*') ? 'gui-tactile-btn-active' : '' }}">
                            <i class="fa-solid fa-flask"></i> START TEST SCAN
                        </a>
                        
                        <!-- Alerts Log -->
                        <a href="{{ route('admin.contamination.index') }}" class="w-full py-3 px-4 rounded-xl text-[10px] font-black text-center text-white gui-tactile-btn flex items-center justify-center gap-2 {{ request()->routeIs('admin.contamination.*') ? 'gui-tactile-btn-active' : '' }}">
                            <i class="fa-solid fa-triangle-exclamation"></i> LOG CONTAMINATIONS
                        </a>
                        
                        <!-- Profile Edit -->
                        <a href="{{ route('admin.profile.edit') }}" class="w-full py-3 px-4 rounded-xl text-[10px] font-black text-center text-white gui-tactile-btn flex items-center justify-center gap-2 {{ request()->routeIs('admin.profile.edit') ? 'gui-tactile-btn-active' : '' }}">
                            <i class="fa-solid fa-user-gear"></i> EDIT PROFILE
                        </a>
                    </div>
                </div>
                
                <!-- Bottom controls -->
                <div class="flex flex-col gap-3 border-t-2 border-blue-200/50 pt-3 mt-4">
                    <!-- Delay Selector -->
                    <div class="flex flex-col gap-1">
                        <label class="text-[9px] font-extrabold text-blue-900 uppercase">Polling Delay</label>
                        <select onchange="alert('Jeda pemantauan disesuaikan: ' + this.value + ' detik.')" class="w-full py-1.5 px-3 text-[10px] font-bold text-gray-800 bg-white border-2 border-blue-200 rounded-lg shadow-sm outline-none">
                            <option value="1.0">1.0 second</option>
                            <option value="2.0" selected>2.0 seconds</option>
                            <option value="5.0">5.0 seconds</option>
                        </select>
                    </div>
                    
                    <!-- Exit button -->
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full py-3 px-4 rounded-xl text-xs font-black text-center text-white gui-tactile-btn gui-btn-red flex items-center justify-center gap-2">
                            <i class="fa-solid fa-right-from-bracket"></i> EXIT PORTAL
                        </button>
                    </form>
                </div>
            </aside>
            
            <!-- RIGHT CONTENT AREA -->
            <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-segoBg custom-scrollbar relative">
                @yield('content')
            </main>
            
        </div>
        
    </div>

    <!-- Layout Simulation Interaction Script -->
    <script>
        let isLayoutServerRunning = true;
        function toggleLayoutServer() {
            isLayoutServerRunning = !isLayoutServerRunning;
            const led = document.getElementById('layout-led-server');
            const text = document.getElementById('layout-text-server');
            const btn = document.getElementById('layout-btn-run-server');

            // If we are on dashboard, trigger dashboard's server toggle as well
            if (typeof toggleServer === 'function') {
                toggleServer();
                return;
            }

            if (isLayoutServerRunning) {
                led.className = "w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse border border-white";
                text.textContent = "RUNNING SERVER";
                btn.classList.remove('gui-btn-red');
                alert('Server IoT berhasil diaktifkan!');
            } else {
                led.className = "w-2.5 h-2.5 rounded-full bg-red-500 border border-white";
                text.textContent = "SERVER STOPPED";
                btn.classList.add('gui-btn-red');
                alert('Server IoT dihentikan.');
            }
        }
    </script>
</body>
</html>
