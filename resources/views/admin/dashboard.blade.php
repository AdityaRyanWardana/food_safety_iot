@extends('layouts.admin')

@section('title', 'Dashboard - FoodDetect Admin')
@section('breadcrumb', 'Dashboard Overview')

@section('content')
<!-- Vintage Industrial IoT GUI Styles -->
<style>
    /* Premium hardware-style UI aesthetic */
    .gui-console {
        background-color: #D6E6F2;
        border: 4px solid #FFFFFF;
        border-radius: 24px;
        box-shadow: 
            0 10px 25px -5px rgba(0, 0, 0, 0.1), 
            0 8px 10px -6px rgba(0, 0, 0, 0.1),
            inset 0 4px 10px rgba(255, 255, 255, 0.6);
        padding: 20px;
    }
    
    .gui-panel-outer {
        background-color: #E6EEF4;
        border: 2px solid #BDCEDA;
        box-shadow: inset 1px 1px 3px rgba(0,0,0,0.05);
    }
    
    .gui-box {
        background: #F0F5FA;
        border: 3px solid #FFFFFF;
        box-shadow: 
            inset 1px 1px 2px rgba(0, 0, 0, 0.05),
            1px 2px 4px rgba(0, 0, 0, 0.06);
    }
    
    .gui-node {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 12px;
        color: #FFFFFF;
        text-shadow: 0 1px 1px rgba(0,0,0,0.5);
        border: 2px solid #FFFFFF;
        box-shadow: 
            1px 2px 3px rgba(0,0,0,0.15),
            inset 0 -2px 4px rgba(0,0,0,0.3);
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .gui-node:hover {
        transform: scale(1.15);
        z-index: 10;
    }
    
    .node-gray {
        background: radial-gradient(circle at 35% 35%, #9CA3AF 0%, #4B5563 100%);
    }
    .node-green {
        background: radial-gradient(circle at 35% 35%, #34D399 0%, #059669 100%);
    }
    .node-yellow {
        background: radial-gradient(circle at 35% 35%, #FBBF24 0%, #D97706 100%);
    }
    .node-red {
        background: radial-gradient(circle at 35% 35%, #F87171 0%, #DC2626 100%);
    }
    
    /* Blinking animations for anomalies */
    .blink-red {
        animation: blinkRed 1.2s infinite alternate;
    }
    @keyframes blinkRed {
        0% { box-shadow: 0 0 4px #EF4444, inset 0 -2px 4px rgba(0,0,0,0.3); }
        100% { box-shadow: 0 0 16px #EF4444, 0 0 6px #EF4444, inset 0 -2px 4px rgba(0,0,0,0.2); }
    }
    
    .blink-yellow {
        animation: blinkYellow 1.5s infinite alternate;
    }
    @keyframes blinkYellow {
        0% { box-shadow: 0 0 3px #F59E0B, inset 0 -2px 4px rgba(0,0,0,0.3); }
        100% { box-shadow: 0 0 12px #F59E0B, 0 0 4px #F59E0B, inset 0 -2px 4px rgba(0,0,0,0.2); }
    }

    .blink-green {
        animation: blinkGreen 2s infinite alternate;
    }
    @keyframes blinkGreen {
        0% { box-shadow: 0 0 2px #10B981, inset 0 -2px 4px rgba(0,0,0,0.3); }
        100% { box-shadow: 0 0 8px #10B981, inset 0 -2px 4px rgba(0,0,0,0.2); }
    }
    
    .gui-input {
        background-color: #FFFFFF;
        border: 2px solid #BDCEDA;
        border-radius: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        color: #1F2937;
        box-shadow: inset 1px 1px 3px rgba(0,0,0,0.08);
    }
    
    .gui-input:focus {
        border-color: #3B82F6;
        outline: none;
    }
    
    /* High-tech Camera Bounding Boxes overlay */
    .camera-overlay-box {
        position: absolute;
        border-width: 2px;
        box-shadow: 0 0 8px currentColor;
        font-size: 8px;
        font-weight: 800;
        text-transform: uppercase;
        padding: 2px 4px;
        animation: pulseOverlay 2s infinite ease-in-out;
    }
    @keyframes pulseOverlay {
        0% { opacity: 0.85; }
        50% { opacity: 0.45; }
        100% { opacity: 0.85; }
    }
</style>

<div class="mb-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-xl font-black font-outfit text-blue-950 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-solar-panel text-brandGreen"></i>
                MONITORING SYSTEM CONSOLE
            </h2>
        </div>
        <a href="{{ route('admin.testing.index') }}" class="group inline-flex items-center justify-center px-4 py-2 text-xs font-extrabold text-white rounded-xl bg-brandGreen hover:bg-brandGreenHover shadow-sm transition duration-300 gap-1.5">
            <i class="fa-solid fa-flask text-[10px]"></i>
            Mulai Tes Baru
        </a>
    </div>
</div>

<!-- ==================== MAIN EXPANDED GUI CONSOLE ==================== -->
<div class="gui-console w-full mb-8 font-sans">
    <div class="flex flex-col gap-6">
        
        <!-- Header Banner -->
        <div class="gui-box rounded-2xl p-4 flex items-center justify-between border-2 border-white">
            <h1 class="text-base md:text-lg font-black text-blue-950 tracking-wider font-outfit uppercase flex items-center gap-2">
                <i class="fa-solid fa-industry text-blue-500"></i>
                WIRE & FOOD SAFETY SELECTION SYSTEM CONSOLE
            </h1>
            <div class="flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-sm shadow-red-500/50"></span>
                <span class="w-2.5 h-2.5 rounded-full bg-yellow-500 shadow-sm shadow-yellow-500/50"></span>
                <span class="w-2.5 h-2.5 rounded-full bg-green-500 shadow-sm shadow-green-500/50"></span>
            </div>
        </div>
        
        <!-- Nodes & Live Camera Section (Replicating exact layout of screenshot) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Group A / Group B Nodes Grid (Left 7 cols) -->
            <div class="lg:col-span-7 gui-box rounded-2xl p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between border-b-2 border-blue-100 pb-3 mb-4">
                        <h2 class="text-xs font-extrabold text-blue-950 tracking-wide uppercase flex items-center gap-2">
                            <i class="fa-solid fa-circle-nodes text-blue-500 animate-pulse text-xs"></i>
                            Sensor Network Node Matrix
                        </h2>
                        <span class="text-[10px] bg-blue-100 text-blue-700 font-bold px-2 py-0.5 rounded-md">24 Channels (A | B)</span>
                    </div>
                    
                    <!-- Channels layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Group A -->
                        <div class="bg-blue-50/50 border border-blue-100 p-4 rounded-xl">
                            <h3 class="text-xs font-black text-blue-900 tracking-wider text-center uppercase mb-3 pb-1 border-b border-blue-200/40">Group A (Laboratory)</h3>
                            <div class="grid grid-cols-4 gap-y-3.5 gap-x-2 justify-items-center">
                                <!-- A12 to A1 circular buttons -->
                                <div id="node-12A" onclick="selectNode('12A')" class="gui-node node-gray">12A</div>
                                <div id="node-11A" onclick="selectNode('11A')" class="gui-node node-gray">11A</div>
                                <div id="node-10A" onclick="selectNode('10A')" class="gui-node node-gray">10A</div>
                                <div id="node-9A" onclick="selectNode('9A')" class="gui-node node-gray">9A</div>
                                <div id="node-8A" onclick="selectNode('8A')" class="gui-node node-gray">8A</div>
                                <div id="node-7A" onclick="selectNode('7A')" class="gui-node node-gray">7A</div>
                                <div id="node-6A" onclick="selectNode('6A')" class="gui-node node-gray">6A</div>
                                <div id="node-5A" onclick="selectNode('5A')" class="gui-node node-gray">5A</div>
                                <div id="node-4A" onclick="selectNode('4A')" class="gui-node node-green blink-green">4A</div>
                                <div id="node-3A" onclick="selectNode('3A')" class="gui-node node-green blink-green">3A</div>
                                <div id="node-2A" onclick="selectNode('2A')" class="gui-node node-yellow blink-yellow">2A</div>
                                <div id="node-1A" onclick="selectNode('1A')" class="gui-node node-red blink-red">1A</div>
                            </div>
                        </div>
                        
                        <!-- Group B -->
                        <div class="bg-blue-50/50 border border-blue-100 p-4 rounded-xl">
                            <h3 class="text-xs font-black text-blue-900 tracking-wider text-center uppercase mb-3 pb-1 border-b border-blue-200/40">Group B (Chillers)</h3>
                            <div class="grid grid-cols-4 gap-y-3.5 gap-x-2 justify-items-center">
                                <!-- B12 to B1 circular buttons -->
                                <div id="node-12B" onclick="selectNode('12B')" class="gui-node node-gray">12B</div>
                                <div id="node-11B" onclick="selectNode('11B')" class="gui-node node-gray">11B</div>
                                <div id="node-10B" onclick="selectNode('10B')" class="gui-node node-gray">10B</div>
                                <div id="node-9B" onclick="selectNode('9B')" class="gui-node node-gray">9B</div>
                                <div id="node-8B" onclick="selectNode('8B')" class="gui-node node-gray">8B</div>
                                <div id="node-7B" onclick="selectNode('7B')" class="gui-node node-gray">7B</div>
                                <div id="node-6B" onclick="selectNode('6B')" class="gui-node node-gray">6B</div>
                                <div id="node-5B" onclick="selectNode('5B')" class="gui-node node-gray">5B</div>
                                <div id="node-4B" onclick="selectNode('4B')" class="gui-node node-gray">4B</div>
                                <div id="node-3B" onclick="selectNode('3B')" class="gui-node node-gray">3B</div>
                                <div id="node-2B" onclick="selectNode('2B')" class="gui-node node-gray">2B</div>
                                <div id="node-1B" onclick="selectNode('1B')" class="gui-node node-gray">1B</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Color legend -->
                <div class="flex flex-wrap gap-4 items-center justify-center text-[9px] font-extrabold text-blue-950 uppercase mt-4 pt-3 border-t border-blue-100">
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 border border-white"></span> AMAN (OK)</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-500 border border-white"></span> WASPADA (WARN)</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-red-500 border border-white"></span> BAHAYA (DANGER)</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-gray-500 border border-white"></span> OFFLINE</span>
                </div>
            </div>
            
            <!-- Live Computer Vision Camera Feed (Right 5 cols) -->
            <div class="lg:col-span-5 gui-box rounded-2xl p-5 flex flex-col">
                <div class="flex items-center justify-between border-b-2 border-blue-100 pb-3 mb-4">
                    <h2 class="text-xs font-extrabold text-blue-950 tracking-wide uppercase flex items-center gap-2">
                        <i class="fa-solid fa-camera text-blue-500"></i>
                        Live Inspection Camera
                    </h2>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span> <b class="text-[9px] text-red-550 uppercase tracking-widest font-black">REC</b></span>
                </div>
                
                <div class="relative w-full aspect-video rounded-xl border-3 border-white bg-slate-950 overflow-hidden shadow-inner flex items-center justify-center">
                    <!-- Camera Feed Image -->
                    <img id="camera-feed-img" src="{{ asset('assets/food_camera_inspection.png') }}" class="w-full h-full object-cover opacity-90 transition duration-300" alt="Food Inspection Live">
                    
                    <!-- High Tech Grid CSS Overlay -->
                    <div class="absolute inset-0 bg-[linear-gradient(rgba(18,24,38,0)_95%,rgba(59,130,246,0.1)_95%),linear-gradient(90deg,rgba(18,24,38,0)_95%,rgba(59,130,246,0.1)_95%)] bg-[size:20px_20px] pointer-events-none"></div>
                    
                    <!-- Bounding boxes overlays -->
                    <div id="cam-box-danger" class="camera-overlay-box text-red-500 border-red-500" style="top: 25%; left: 10%; width: 26%; height: 50%;">
                        [A1] DANGER: DECOMPOSITION
                    </div>
                    <div id="cam-box-warning" class="camera-overlay-box text-yellow-500 border-yellow-500" style="top: 15%; left: 42%; width: 22%; height: 42%;">
                        [A2] WARN: HUMIDITY ANOMALY
                    </div>
                    <div id="cam-box-safe" class="camera-overlay-box text-emerald-500 border-emerald-500" style="top: 30%; left: 70%; width: 24%; height: 45%;">
                        [A3] SAFE: OPTIMAL
                    </div>
                    
                    <!-- Disabled Camera Cover -->
                    <div id="camera-standby-screen" class="absolute inset-0 bg-slate-900 hidden flex-col items-center justify-center gap-3">
                        <div class="w-14 h-14 rounded-full bg-slate-800 flex items-center justify-center text-slate-500 border border-slate-700">
                            <i class="fa-solid fa-video-slash text-2xl"></i>
                        </div>
                        <span class="text-xs font-black text-slate-400 uppercase tracking-widest">CAMERA FEED DISABLED</span>
                        <span class="text-[9px] text-slate-500 font-bold uppercase">STANDBY MODE</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Information Display Panel -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- SENSOR INFORMATION panel (Left 4 cols) -->
            <div class="lg:col-span-4 gui-box rounded-2xl p-5 flex flex-col justify-between">
                <div class="border-b-2 border-blue-100 pb-3 mb-4">
                    <h2 class="text-xs font-extrabold text-blue-950 tracking-wide uppercase flex items-center gap-2">
                        <i class="fa-solid fa-microchip text-blue-500"></i>
                        Sensor Information
                    </h2>
                </div>
                
                <div class="flex flex-col gap-3">
                    <div>
                        <label class="text-[9px] font-extrabold text-blue-900 uppercase">Operator / User</label>
                        <input type="text" id="info-user" value="{{ Auth::user()->name ?? 'Admin Lab' }}" class="w-full px-3 py-2 text-xs gui-input" readonly>
                    </div>
                    <div>
                        <label class="text-[9px] font-extrabold text-blue-900 uppercase">Sensor ID / Code</label>
                        <input type="text" id="info-sensor-code" value="SENS-DG-01" class="w-full px-3 py-2 text-xs font-mono tracking-wider gui-input" readonly>
                    </div>
                    <div>
                        <label class="text-[9px] font-extrabold text-blue-900 uppercase">Sensor Name</label>
                        <input type="text" id="info-sensor-name" value="Sensor Ruang Daging" class="w-full px-3 py-2 text-xs gui-input" readonly>
                    </div>
                    <div>
                        <label class="text-[9px] font-extrabold text-blue-900 uppercase">Location</label>
                        <input type="text" id="info-sensor-location" value="Gudang Penyimpanan Daging A" class="w-full px-3 py-2 text-xs gui-input" readonly>
                    </div>
                    <div>
                        <label class="text-[9px] font-extrabold text-blue-900 uppercase">Data Current / Metrics</label>
                        <input type="text" id="info-sensor-metrics" value="Temp: 18.2°C | Hum: 86% | Gas: 450 ppm | pH: 4.8" class="w-full px-3 py-2 text-xs font-bold text-red-500 gui-input" readonly>
                    </div>
                </div>
            </div>
            
            <!-- CONNECTIFY INFORMATIONS panel (Middle 5 cols) -->
            <div class="lg:col-span-5 gui-box rounded-2xl p-5 flex flex-col justify-between">
                <div>
                    <div class="border-b-2 border-blue-100 pb-3 mb-3">
                        <h2 class="text-xs font-extrabold text-blue-950 tracking-wide uppercase flex items-center gap-2">
                            <i class="fa-solid fa-network-wired text-blue-500"></i>
                            Connectify Informations
                        </h2>
                    </div>
                    
                    <!-- Status Bar -->
                    <div class="flex items-center gap-2 bg-white border border-blue-200/50 rounded-xl px-4 py-2.5 mb-4 shadow-sm">
                        <span class="relative flex h-2 w-2">
                            <span id="led-sim-pulse" class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span id="led-sim" class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span id="text-sim-status" class="text-xs font-black text-blue-950 uppercase tracking-wide">SYSTEM CYCLE: ONLINE</span>
                    </div>
                    
                    <!-- Flex Row for History list & Barcode Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Events/History checklist -->
                        <div class="bg-white border border-blue-200/70 p-3 rounded-xl">
                            <h3 class="text-[9px] font-black text-blue-900 tracking-wider uppercase border-b border-blue-100 pb-1 mb-2">History Checks</h3>
                            <div class="space-y-1.5 text-[9px] font-bold text-gray-700">
                                <label class="flex items-center gap-1.5"><input type="checkbox" checked disabled class="accent-emerald-500"> Lab Server Started</label>
                                <label class="flex items-center gap-1.5"><input type="checkbox" checked disabled class="accent-emerald-500"> USB Interface Ready</label>
                                <label class="flex items-center gap-1.5"><input type="checkbox" checked id="history-ch1" class="accent-emerald-500"> Cycle 1/50 Complete</label>
                                <label class="flex items-center gap-1.5"><input type="checkbox" checked id="history-ch2" class="accent-emerald-500"> Box Model loaded</label>
                            </div>
                        </div>
                        
                        <!-- Detailed node/barcode logs -->
                        <div class="bg-white border border-blue-200/70 p-3 rounded-xl flex flex-col">
                            <h3 class="text-[9px] font-black text-blue-900 tracking-wider uppercase border-b border-blue-100 pb-1 mb-2">Node Specification</h3>
                            <div id="info-barcode-details" class="text-[9px] text-gray-700 font-semibold leading-relaxed overflow-y-auto max-h-[85px] custom-scrollbar">
                                <b>Sensor Code:</b> SENS-DG-01<br>
                                <b>Sensor Name:</b> Sensor Ruang Daging<br>
                                <b>Status:</b> <span class="font-bold text-red-500">Bahaya (Anomali Kritis)</span><br>
                                <b>Location:</b> Gudang Penyimpanan Daging A<br>
                                <b>Diagnostics:</b> Deteksi bau gas amonia/pembusukan tinggi pada sampel daging cincang.
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Terminal Console logger -->
                <div class="mt-4 pt-3 border-t border-blue-100/60">
                    <label class="text-[9px] font-extrabold text-blue-900 uppercase mb-1.5 block">Console Logger Output</label>
                    <div id="history-log-box" class="h-[60px] bg-slate-950 text-emerald-400 font-mono text-[9px] p-2.5 rounded-lg overflow-y-auto leading-relaxed border-2 border-blue-200 custom-scrollbar">
                        <div>[19:34:43] System initialized, welcome operator.</div>
                        <div>[19:34:44] Database connected: SQLite v3.</div>
                        <div>[19:34:45] 5 sensors operational inside the network.</div>
                        <div>[19:34:46] Warning anomaly detected on Sensor Node 1A.</div>
                    </div>
                </div>
            </div>
            
            <!-- TIME panel (Right 3 cols) -->
            <div class="lg:col-span-3 gui-box rounded-2xl p-5 flex flex-col justify-between">
                <div class="border-b-2 border-blue-100 pb-3 mb-4">
                    <h2 class="text-xs font-extrabold text-blue-950 tracking-wide uppercase flex items-center gap-2">
                        <i class="fa-solid fa-clock text-blue-500"></i>
                        System Time
                    </h2>
                </div>
                
                <div class="flex flex-col gap-4">
                    <!-- Timer stopwatch -->
                    <div class="bg-white border-2 border-blue-100 rounded-xl p-2.5 text-center">
                        <span class="text-[9px] font-extrabold text-blue-900 uppercase block mb-1">SCAN ELAPSED TIMER</span>
                        <span id="elapsed-timer" class="text-xl font-black font-mono text-blue-950 tracking-widest">00:00:13</span>
                    </div>
                    
                    <!-- Actual real-world time -->
                    <div class="bg-white border-2 border-blue-100 rounded-xl p-2.5 text-center">
                        <span class="text-[9px] font-extrabold text-blue-900 uppercase block mb-1">ACTUAL TIME</span>
                        <span id="actual-time" class="text-[10px] font-black font-mono text-gray-750 tracking-wide">13:22:35 | 17-10-2025</span>
                    </div>
                    
                    <!-- Total count of tests / warnings -->
                    <div class="bg-blue-950 text-white rounded-xl p-2.5 text-center shadow-md">
                        <span class="text-[8px] font-extrabold text-blue-200 uppercase block mb-0.5">WARNINGS TODAY</span>
                        <span class="text-xl font-black font-outfit" id="total-alerts-count">{{ $warningsToday }} LOGS</span>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
</div>

<!-- ==================== TABEL LOG DATABASE ==================== -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Card Header -->
    <div class="px-6 py-5 border-b border-gray-100 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 bg-gray-50/30">
        <div>
            <h3 class="font-bold font-outfit text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-brandGreen"></i>
                Database Log Pemantauan Real-time
            </h3>
            <p class="text-xs text-gray-400 mt-0.5">Histori pembacaan data sensor IoT yang tersimpan secara terstruktur di database SQLite.</p>
        </div>
        
        <!-- Sego-inspired categories tab filter (Vibrant brandGreen active state) -->
        <div class="flex flex-wrap gap-2 text-xs font-bold text-gray-455 my-1">
            <button onclick="filterCategory('all', this)" class="px-3.5 py-1.5 rounded-xl bg-brandGreen text-white shadow-sm shadow-brandGreen/25 category-tab-btn active">Semua Sampel</button>
            @foreach($categories as $cat)
            <button onclick="filterCategory('{{ $cat->name }}', this)" class="px-3.5 py-1.5 rounded-xl hover:bg-gray-100 hover:text-gray-700 transition category-tab-btn">{{ $cat->name }}</button>
            @endforeach
        </div>

        <div class="flex items-center gap-4 w-full lg:w-auto justify-between lg:justify-end border-t lg:border-t-0 pt-3 lg:pt-0">
            @if($recentReadings->count() > 0)
            <form action="{{ route('admin.readings.clear') }}" method="POST" class="inline-flex items-center gap-2">
                @csrf
                @method('DELETE')
                <button type="button" onclick="confirmBulkClear(this)" class="text-xs text-red-500 hover:text-white hover:bg-red-500 px-3 py-1.5 rounded-lg border border-red-200/50 font-bold transition flex items-center gap-1">
                    <i class="fa-solid fa-trash-can pointer-events-none"></i>
                    <span class="bulk-text pointer-events-none">Hapus Semua Log</span>
                </button>
                <button type="button" onclick="cancelBulkClear(this)" class="hidden bulk-cancel text-xs text-gray-400 hover:text-gray-600 transition font-semibold">Batal</button>
            </form>
            <span class="text-gray-200">|</span>
            @endif
            <a href="{{ route('admin.sensors.index') }}" class="text-xs text-brandGreen hover:text-brandGreenHover font-extrabold bg-brandGreen/10 px-3 py-1.5 rounded-xl border border-brandGreen/20 transition">
                Lihat Semua Sensor
            </a>
        </div>
    </div>
    
    <!-- Logs Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-gray-50/20 border-b border-gray-100 text-xs text-gray-400 uppercase tracking-wider">
                    <th class="px-6 py-4 font-bold">ID Perangkat</th>
                    <th class="px-6 py-4 font-bold">Sampel Makanan</th>
                    <th class="px-6 py-4 font-bold">Kategori</th>
                    <th class="px-6 py-4 font-bold">Metrik Sensor</th>
                    <th class="px-6 py-4 font-bold text-center">Status</th>
                    <th class="px-6 py-4 font-bold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recentReadings as $reading)
                <tr data-category="{{ $reading->foodCategory->name ?? 'Umum' }}" class="reading-row hover:bg-gray-50/30 transition group">
                    <!-- Device ID -->
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full @if($reading->sensorDevice?->status === 'active') bg-emerald-500 animate-pulse @else bg-gray-300 @endif"></span>
                            <span class="font-bold text-gray-900 font-mono text-xs tracking-wide bg-gray-55 px-2.5 py-1 rounded-md border border-gray-100">
                                {{ $reading->sensorDevice->device_code ?? '-' }}
                            </span>
                        </div>
                    </td>
                    
                    <!-- Sample Name -->
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-800">
                            {{ $reading->sample_name ?? 'Pengukuran Langsung' }}
                        </div>
                        <div class="text-[10px] text-gray-400 flex items-center gap-1 mt-0.5 font-bold">
                            <i class="fa-regular fa-clock"></i>
                            {{ $reading->read_at ? $reading->read_at->diffForHumans() : '-' }}
                        </div>
                    </td>
                    
                    <!-- Category -->
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-gray-50 text-gray-650 text-xs font-semibold border border-gray-100/50">
                            <i class="{{ $reading->foodCategory->icon ?? 'fa-solid fa-box' }} mr-1.5 text-gray-400"></i>
                            {{ $reading->foodCategory->name ?? 'Umum' }}
                        </span>
                    </td>
                    
                    <!-- Sensor Metrics -->
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-2 max-w-sm">
                            @if(isset($reading->temperature))
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-orange-50/80 text-orange-650 text-xs font-bold border border-orange-100/50">
                                <i class="fa-solid fa-temperature-half mr-1.5 text-orange-400"></i>{{ number_format($reading->temperature, 1) }}°C
                            </span>
                            @endif
                            
                            @if(isset($reading->humidity))
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-50/80 text-blue-650 text-xs font-bold border border-blue-100/50">
                                <i class="fa-solid fa-droplet mr-1.5 text-blue-400"></i>{{ number_format($reading->humidity, 1) }}%
                            </span>
                            @endif

                            @if(isset($reading->gas_level))
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-amber-50/80 text-amber-700 text-xs font-bold border border-amber-100/50">
                                <i class="fa-solid fa-smog mr-1.5 text-amber-400"></i>{{ number_format($reading->gas_level, 0) }} ppm
                            </span>
                            @endif

                            @if(isset($reading->ph_level))
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-teal-50/80 text-teal-700 text-xs font-bold border border-teal-100/50">
                                <i class="fa-solid fa-vial mr-1.5 text-teal-400"></i>pH {{ number_format($reading->ph_level, 1) }}
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-gray-55 text-gray-400 text-xs font-bold border border-gray-100" title="pH tidak terukur">
                                <i class="fa-solid fa-vial-slash mr-1.5"></i>pH -
                            </span>
                            @endif
                        </div>
                    </td>
                    
                    <!-- Safety Status -->
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border transition shadow-sm
                            @if($reading->safety_status === 'aman') bg-green-50 text-emerald-700 border-green-200/60
                            @elseif($reading->safety_status === 'waspada') bg-yellow-50 text-yellow-700 border-yellow-200/60
                            @else bg-red-50 text-red-600 border-red-200/60
                            @endif">
                            <span class="w-1.5 h-1.5 rounded-full mr-1.5 animate-pulse
                                @if($reading->safety_status === 'aman') bg-emerald-500
                                @elseif($reading->safety_status === 'waspada') bg-yellow-500
                                @else bg-red-500
                                @endif"></span>
                            {{ ucfirst($reading->safety_status) }}
                        </span>
                    </td>
                    
                    <!-- Action -->
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('admin.readings.destroy', $reading) }}" method="POST" class="inline-flex items-center gap-1.5 justify-end">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmReadingsDelete(this)" class="p-2 rounded-lg text-gray-455 hover:text-red-500 hover:bg-red-50 transition flex items-center gap-1" title="Hapus Log">
                                <i class="fa-solid fa-trash-can pointer-events-none text-sm"></i>
                                <span class="text-xs font-semibold hidden delete-text pointer-events-none">Yakin?</span>
                            </button>
                            <button type="button" onclick="cancelReadingsDelete(this)" class="hidden cancel-btn text-xs text-gray-400 hover:text-gray-600 transition font-semibold px-2 py-1">Batal</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                        <div class="max-w-sm mx-auto">
                            <div class="w-16 h-16 mx-auto bg-gray-50 rounded-full flex items-center justify-center text-gray-455 mb-4 border border-gray-100">
                                <i class="fa-solid fa-chart-line text-2xl"></i>
                            </div>
                            <p class="font-bold text-gray-800">Belum ada log pemantauan</p>
                            <p class="text-xs text-gray-400 mt-1">Lakukan pengetesan pangan menggunakan USB sensor untuk melihat data real-time di sini.</p>
                            <a href="{{ route('admin.testing.index') }}" class="inline-flex items-center gap-2 mt-4 text-xs font-extrabold text-white bg-brandGreen hover:bg-brandGreenHover px-5 py-2.5 rounded-xl shadow-sm transition">
                                <i class="fa-solid fa-flask"></i> Mulai Tes Sekarang
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
                
                <!-- Dynamic Empty State Row (Initially Hidden) -->
                <tr id="dynamic-empty-state-row" class="hidden">
                    <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                        <div class="max-w-sm mx-auto">
                            <div class="w-16 h-16 mx-auto bg-gray-55 rounded-full flex items-center justify-center text-gray-400 mb-4 border border-gray-100">
                                <i class="fa-solid fa-flask-vial text-2xl text-brandGreen animate-bounce"></i>
                            </div>
                            <p class="font-bold text-gray-850">Tidak ada data pengetesan</p>
                            <p class="text-xs text-gray-455 mt-1 font-medium">Belum ada rekaman pemantauan sensor untuk kategori pangan ini.</p>
                            <a href="{{ route('admin.testing.index') }}" class="inline-flex items-center gap-2 mt-4 text-xs font-extrabold text-white bg-brandGreen hover:bg-brandGreenHover px-5 py-2.5 rounded-xl shadow-sm transition">
                                <i class="fa-solid fa-flask"></i> Mulai Tes Sekarang
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- ==================== JAVASCRIPT SIMULATION & CONTROLLER INTERACTION ==================== -->
<script>
    // -----------------------------------------------------------------
    // Node Database & Simulation Setup
    // -----------------------------------------------------------------
    const sensorNodesData = {
        '1A': {
            code: 'SENS-DG-01',
            name: 'Sensor Ruang Daging',
            status: 'danger',
            temp: 18.2,
            hum: 86.0,
            gas: 450,
            ph: 4.8,
            location: 'Gudang Penyimpanan Daging A',
            safety: 'Bahaya (Dekomposisi Gas)',
            note: 'Tingkat kontaminasi gas amonia tinggi pada daging cincang.'
        },
        '2A': {
            code: 'SENS-SY-02',
            name: 'Sensor Rak Sayur',
            status: 'warning',
            temp: 12.5,
            hum: 78.0,
            gas: 220,
            ph: 6.8,
            location: 'Chiller Sayuran B',
            safety: 'Waspada (Suhu & Gas Meningkat)',
            note: 'Suhu chiller agak hangat, indikasi awal pembusukan daun sayur.'
        },
        '3A': {
            code: 'SENS-MS-03',
            name: 'Sensor Counter Saji',
            status: 'safe',
            temp: 65.0,
            hum: 30.0,
            gas: 45,
            ph: 6.5,
            location: 'Area Saji Hangat C',
            safety: 'Aman (Optimal)',
            note: 'Suhu area saji hangat stabil, kebersihan optimal.'
        },
        '4A': {
            code: 'ESP32-XXSR-69',
            name: 'ESP32 xxsr69',
            status: 'safe',
            temp: 24.5,
            hum: 55.0,
            gas: 90,
            ph: 7.0,
            location: 'Laboratorium Utama',
            safety: 'Aman (Kondisi Normal)',
            note: 'Kalibrasi sensor dalam batas toleransi normal.'
        },
        '5A': {
            code: 'SENS-OFF-04',
            name: 'Sensor Cadangan',
            status: 'offline',
            temp: null,
            hum: null,
            gas: null,
            ph: null,
            location: 'Ruang Lab Kalibrasi',
            safety: 'Offline',
            note: 'Perangkat dinonaktifkan atau dalam pemeliharaan.'
        }
    };

    // Auto-generate virtual slots for the rest of channels (6A-12A, 1B-12B)
    for (let i = 6; i <= 12; i++) {
        sensorNodesData[i + 'A'] = {
            code: `SENS-VIRT-A${i}`,
            name: `Virtual Node A${i}`,
            status: 'offline',
            temp: null,
            hum: null,
            gas: null,
            ph: null,
            location: 'Ready Slot - Virtual Channel',
            safety: 'Offline (Virtual)',
            note: 'Saluran kosong siap digunakan.'
        };
    }
    for (let i = 1; i <= 12; i++) {
        sensorNodesData[i + 'B'] = {
            code: `SENS-VIRT-B${i}`,
            name: `Virtual Node B${i}`,
            status: 'offline',
            temp: null,
            hum: null,
            gas: null,
            ph: null,
            location: 'Ready Slot - Virtual Channel',
            safety: 'Offline (Virtual)',
            note: 'Saluran kosong siap digunakan.'
        };
    }

    // -----------------------------------------------------------------
    // Node Selection Logic
    // -----------------------------------------------------------------
    function selectNode(nodeId) {
        // Clear highlights
        document.querySelectorAll('.gui-node').forEach(el => {
            el.classList.remove('ring-4', 'ring-blue-500', 'scale-110');
        });

        // Add highlight
        const activeNode = document.getElementById(`node-${nodeId}`);
        if (activeNode) {
            activeNode.classList.add('ring-4', 'ring-blue-500', 'scale-110');
        }

        const data = sensorNodesData[nodeId];

        // Update fields
        document.getElementById('info-sensor-code').value = data.code;
        document.getElementById('info-sensor-name').value = data.name;
        document.getElementById('info-sensor-location').value = data.location;

        const metricsInput = document.getElementById('info-sensor-metrics');
        if (data.status === 'offline') {
            metricsInput.value = 'N/A (Device Offline / Inactive)';
            metricsInput.className = "w-full px-3 py-2 text-xs font-bold text-gray-500 gui-input";
        } else {
            metricsInput.value = `Temp: ${data.temp}°C | Hum: ${data.hum}% | Gas: ${data.gas} ppm | pH: ${data.ph || '-'}`;
            if (data.status === 'danger') {
                metricsInput.className = "w-full px-3 py-2 text-xs font-bold text-red-500 gui-input";
            } else if (data.status === 'warning') {
                metricsInput.className = "w-full px-3 py-2 text-xs font-bold text-yellow-500 gui-input";
            } else {
                metricsInput.className = "w-full px-3 py-2 text-xs font-bold text-emerald-600 gui-input";
            }
        }

        // Update detailed specs
        const statusColor = data.status === 'safe' ? 'text-green-600' : data.status === 'warning' ? 'text-yellow-500' : data.status === 'danger' ? 'text-red-500' : 'text-gray-500';
        document.getElementById('info-barcode-details').innerHTML = `
            <b>Sensor Code:</b> ${data.code}<br>
            <b>Sensor Name:</b> ${data.name}<br>
            <b>Status:</b> <span class="font-extrabold ${statusColor}">${data.safety.toUpperCase()}</span><br>
            <b>Location:</b> ${data.location}<br>
            <b>Diagnostics:</b> ${data.note || 'N/A'}<br>
            <b>Last Checked:</b> ${new Date().toLocaleTimeString()}
        `;

        // Highlight/pulsate related overlay box in Live Camera
        document.querySelectorAll('.camera-overlay-box').forEach(box => {
            box.classList.remove('ring-4', 'ring-white', 'opacity-100');
        });

        if (nodeId === '1A') {
            document.getElementById('cam-box-danger').classList.add('ring-4', 'ring-white', 'opacity-100');
        } else if (nodeId === '2A') {
            document.getElementById('cam-box-warning').classList.add('ring-4', 'ring-white', 'opacity-100');
        } else if (nodeId === '3A' || nodeId === '4A') {
            document.getElementById('cam-box-safe').classList.add('ring-4', 'ring-white', 'opacity-100');
        }

        logConsole(`Selected Node ${nodeId} (${data.code}) - Status: ${data.safety.toUpperCase()}`);
    }

    // -----------------------------------------------------------------
    // Console Tickers & Stopwatch Time
    // -----------------------------------------------------------------
    let elapsedSeconds = 13;
    let timerInterval = null;
    let isTimerPaused = false;

    function startTimer() {
        if (timerInterval) clearInterval(timerInterval);
        timerInterval = setInterval(() => {
            if (!isTimerPaused) {
                elapsedSeconds++;
                const hrs = String(Math.floor(elapsedSeconds / 3600)).padStart(2, '0');
                const mins = String(Math.floor((elapsedSeconds % 3600) / 60)).padStart(2, '0');
                const secs = String(elapsedSeconds % 60).padStart(2, '0');
                document.getElementById('elapsed-timer').textContent = `${hrs}:${mins}:${secs}`;
            }
        }, 1000);
    }

    function updateActualTime() {
        setInterval(() => {
            const now = new Date();
            const dateStr = now.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' }).replace(/\//g, '-');
            const timeStr = now.toLocaleTimeString('id-ID');
            document.getElementById('actual-time').textContent = `${timeStr} | ${dateStr}`;
        }, 1000);
    }

    // Initialize time tickers
    startTimer();
    updateActualTime();

    // -----------------------------------------------------------------
    // Console Controls driving Simulation (Hooked to Layout)
    // -----------------------------------------------------------------
    let isServerRunning = true;

    function toggleServer() {
        isServerRunning = !isServerRunning;
        const layoutLed = document.getElementById('layout-led-server');
        const layoutText = document.getElementById('layout-text-server');
        const layoutBtn = document.getElementById('layout-btn-run-server');

        const simLed = document.getElementById('led-sim');
        const simPulse = document.getElementById('led-sim-pulse');
        const simText = document.getElementById('text-sim-status');

        if (isServerRunning) {
            if (layoutLed) layoutLed.className = "w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse border border-white";
            if (layoutText) layoutText.textContent = "RUNNING SERVER";
            if (layoutBtn) layoutBtn.classList.remove('gui-btn-red');
            
            simLed.className = "relative inline-flex rounded-full h-2 w-2 bg-emerald-500";
            simPulse.className = "animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75";
            simText.textContent = "SYSTEM CYCLE: ONLINE";
            logConsole(`IoT server successfully STARTED.`);
        } else {
            if (layoutLed) layoutLed.className = "w-2.5 h-2.5 rounded-full bg-red-500 border border-white";
            if (layoutText) layoutText.textContent = "SERVER STOPPED";
            if (layoutBtn) layoutBtn.classList.add('gui-btn-red');

            simLed.className = "relative inline-flex rounded-full h-2 w-2 bg-red-500";
            simPulse.className = "hidden";
            simText.textContent = "SYSTEM CYCLE: OFFLINE";
            logConsole(`IoT server STOPPED by operator command.`);
        }
    }

    function toggleCameraFeed() {
        const screen = document.getElementById('camera-standby-screen');
        const img = document.getElementById('camera-feed-img');

        if (screen.classList.contains('hidden')) {
            screen.classList.remove('hidden');
            img.classList.add('opacity-0');
            logConsole(`Camera hardware feed disconnected.`);
        } else {
            screen.classList.add('hidden');
            img.classList.remove('opacity-0');
            logConsole(`Camera hardware feed re-established.`);
        }
    }

    function logConsole(message) {
        const consoleBox = document.getElementById('history-log-box');
        if (consoleBox) {
            const timestamp = new Date().toLocaleTimeString();
            consoleBox.innerHTML += `<div>[${timestamp}] ${message}</div>`;
            consoleBox.scrollTop = consoleBox.scrollHeight;
        }
    }

    function triggerMockScan() {
        if (!isServerRunning) {
            logConsole(`ERROR: Cannot scan. Server is offline.`);
            alert('Aktifkan server terlebih dahulu!');
            return;
        }

        logConsole(`Starting high-speed IoT network broadcast...`);
        let count = 0;
        const scanInt = setInterval(() => {
            count++;
            if (count === 1) logConsole(`Pinging Node Group A channel 1-12...`);
            if (count === 2) logConsole(`Pinging Node Group B channel 1-12...`);
            if (count === 3) {
                logConsole(`Scan complete. 4 nodes active. 1 offline. 19 empty slots.`);
                clearInterval(scanInt);
                alert('Jaringan sensor berhasil dipindai!');
            }
        }, 800);
    }

    function resetConsoleSimulation() {
        elapsedSeconds = 0;
        document.getElementById('elapsed-timer').textContent = "00:00:00";
        document.getElementById('history-log-box').innerHTML = `<div>[${new Date().toLocaleTimeString()}] Simulation parameters reset successfully.</div>`;
        
        sensorNodesData['1A'].status = 'safe';
        sensorNodesData['1A'].safety = 'Aman (Terkontrol)';
        sensorNodesData['1A'].temp = 4.2;
        sensorNodesData['1A'].gas = 120;
        sensorNodesData['1A'].ph = 6.2;
        sensorNodesData['1A'].note = 'Suhu daging stabil di area dingin, tidak terdeteksi kontaminasi gas.';

        const node1A = document.getElementById('node-1A');
        node1A.className = "gui-node node-green blink-green";
        document.getElementById('cam-box-danger').className = "camera-overlay-box text-green-500 border-green-500";
        document.getElementById('cam-box-danger').textContent = "[A1] SAFE: RESTORED";

        document.getElementById('total-alerts-count').textContent = "0 LOGS";

        logConsole(`Alert status cleared. Resetting Node 1A to OK.`);
        selectNode('1A');
    }

    // Initialize select state to node 1A on load
    window.addEventListener('DOMContentLoaded', () => {
        selectNode('1A');
    });

    // -----------------------------------------------------------------
    // Legacy / Tabular logs controls & filters (Preserved functionality)
    // -----------------------------------------------------------------
    function confirmReadingsDelete(button) {
        if (button.classList.contains('confirm-state')) {
            button.closest('form').submit();
            return;
        }
        
        document.querySelectorAll('.confirm-state').forEach(btn => {
            if (btn.querySelector('.bulk-text')) {
                resetBulkClear(btn);
            } else {
                resetReadingsDelete(btn);
            }
        });

        button.classList.add('confirm-state');
        button.classList.remove('text-gray-455', 'hover:text-red-500', 'hover:bg-red-50');
        button.classList.add('text-white', 'bg-red-500', 'hover:bg-red-600', 'px-2.5', 'py-1', 'rounded-lg', 'shadow-sm');
        
        const icon = button.querySelector('i');
        icon.classList.add('mr-1');
        
        const text = button.querySelector('.delete-text');
        if (text) text.classList.remove('hidden');

        const cancelBtn = button.closest('form').querySelector('.cancel-btn');
        if (cancelBtn) cancelBtn.classList.remove('hidden');

        button.timeoutId = setTimeout(() => {
            resetReadingsDelete(button);
        }, 4000);
    }

    function cancelReadingsDelete(cancelBtn) {
        const button = cancelBtn.closest('form').querySelector('button');
        resetReadingsDelete(button);
    }

    function resetReadingsDelete(button) {
        if (button.timeoutId) {
            clearTimeout(button.timeoutId);
        }
        button.classList.remove('confirm-state', 'text-white', 'bg-red-500', 'hover:bg-red-600', 'px-2.5', 'py-1', 'rounded-lg', 'shadow-sm');
        button.classList.add('text-gray-455', 'hover:text-red-500', 'hover:bg-red-50');
        
        const icon = button.querySelector('i');
        icon.classList.remove('mr-1');
        
        const text = button.querySelector('.delete-text');
        if (text) text.classList.add('hidden');

        const cancelBtn = button.closest('form').querySelector('.cancel-btn');
        if (cancelBtn) cancelBtn.classList.add('hidden');
    }

    function confirmBulkClear(button) {
        if (button.classList.contains('confirm-state')) {
            button.closest('form').submit();
            return;
        }
        
        document.querySelectorAll('.confirm-state').forEach(btn => {
            if (btn.querySelector('.bulk-text')) {
                resetBulkClear(btn);
            } else {
                resetReadingsDelete(btn);
            }
        });

        button.classList.add('confirm-state');
        button.classList.remove('text-red-500', 'hover:text-white', 'hover:bg-red-500', 'border-red-200/50');
        button.classList.add('text-white', 'bg-red-500', 'hover:bg-red-600', 'px-3', 'py-1.5', 'rounded-lg', 'shadow-sm');
        
        const icon = button.querySelector('i');
        icon.classList.add('mr-1');
        
        const text = button.querySelector('.bulk-text');
        text.textContent = 'Yakin Bersihkan Semua?';

        const cancelBtn = button.closest('form').querySelector('.bulk-cancel');
        if (cancelBtn) cancelBtn.classList.remove('hidden');

        button.timeoutId = setTimeout(() => {
            resetBulkClear(button);
        }, 5000);
    }

    function cancelBulkClear(cancelBtn) {
        const button = cancelBtn.closest('form').querySelector('button');
        resetBulkClear(button);
    }

    function resetBulkClear(button) {
        if (button.timeoutId) {
            clearTimeout(button.timeoutId);
        }
        button.classList.remove('confirm-state', 'text-white', 'bg-red-500', 'hover:bg-red-600', 'px-3', 'py-1.5', 'rounded-lg', 'shadow-sm');
        button.classList.add('text-red-500', 'hover:text-white', 'hover:bg-red-500', 'border-red-200/50');
        
        const icon = button.querySelector('i');
        icon.classList.remove('mr-1');
        
        const text = button.querySelector('.bulk-text');
        text.textContent = 'Hapus Semua Log';

        const cancelBtn = button.closest('form').querySelector('.bulk-cancel');
        if (cancelBtn) cancelBtn.classList.add('hidden');
    }

    function filterCategory(categoryName, btn) {
        // Update tabs
        document.querySelectorAll('.category-tab-btn').forEach(b => {
            b.className = "px-3.5 py-1.5 rounded-xl hover:bg-gray-100 hover:text-gray-700 transition category-tab-btn";
        });
        btn.className = "px-3.5 py-1.5 rounded-xl bg-brandGreen text-white shadow-sm shadow-brandGreen/25 category-tab-btn active";

        // Filter rows
        const rows = document.querySelectorAll('.reading-row');
        let visibleCount = 0;
        
        rows.forEach(row => {
            const rowCat = row.getAttribute('data-category');
            if (categoryName === 'all' || rowCat === categoryName) {
                row.classList.remove('hidden');
                visibleCount++;
            } else {
                row.classList.add('hidden');
            }
        });

        // Show/hide empty state
        const dynamicEmpty = document.getElementById('dynamic-empty-state-row');
        if (visibleCount === 0) {
            if (dynamicEmpty) dynamicEmpty.classList.remove('hidden');
        } else {
            if (dynamicEmpty) dynamicEmpty.classList.add('hidden');
        }
    }
</script>

@if(session('success'))
<script>alert('{{ session('success') }}')</script>
@endif
@endsection
