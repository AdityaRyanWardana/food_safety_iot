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
        
        <!-- ==================== LIVE CALIBRATION ENGINE ==================== -->
        <div class="flex justify-center mb-6">
            
            <!-- Left Panel: 2-Sensor Selection and Live Calibration Controls -->
            <div class="w-full max-w-2xl gui-box rounded-2xl p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between border-b-2 border-blue-100 pb-3 mb-4">
                        <h2 class="text-xs font-extrabold text-blue-950 tracking-wide uppercase flex items-center gap-2">
                            <i class="fa-solid fa-sliders text-blue-500 animate-pulse text-xs"></i>
                            Sensor Selector & Live Calibration
                        </h2>
                        <span class="text-[10px] bg-blue-100 text-blue-700 font-bold px-2 py-0.5 rounded-md">Real-Time Metrics</span>
                    </div>

                    <!-- Sensor Selection buttons -->
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <button id="btn-select-sensor1" onclick="changeActiveSensor(1)" class="p-3 rounded-xl border-2 border-blue-500 bg-blue-50/50 flex flex-col items-center text-center transition duration-300">
                            <i class="fa-solid fa-microchip text-blue-500 text-base mb-1"></i>
                            <span class="text-xs font-black text-blue-950">Sensor 1</span>
                            <span class="text-[9px] text-gray-500 font-bold">SENS-DG-01 (Meat)</span>
                        </button>
                        <button id="btn-select-sensor2" onclick="changeActiveSensor(2)" class="p-3 rounded-xl border-2 border-white hover:border-blue-200 bg-white flex flex-col items-center text-center transition duration-300">
                            <i class="fa-solid fa-microchip text-gray-400 text-base mb-1"></i>
                            <span class="text-xs font-bold text-gray-700">Sensor 2</span>
                            <span class="text-[9px] text-gray-400 font-semibold">SENS-SY-02 (Veg)</span>
                        </button>
                    </div>

                    <!-- Live Telemetry sliders -->
                    <div class="space-y-4 bg-blue-50/40 border border-blue-100 p-4 rounded-xl">
                        <div class="flex items-center justify-between">
                            <span id="active-sensor-title" class="text-xs font-black text-blue-950 uppercase">Active Sensor: Sensor 1</span>
                            <button id="btn-auto-simulate" onclick="toggleAutoSimulation()" class="text-[9px] font-extrabold px-2.5 py-1 rounded bg-brandGreen hover:bg-brandGreenHover text-white shadow-sm transition">
                                <i class="fa-solid fa-play mr-1"></i>AUTO CYCLE
                            </button>
                        </div>
                        <div class="border-t border-blue-100 my-2"></div>
                        
                        <div>
                            <div class="flex justify-between text-[10px] font-extrabold text-blue-950 uppercase mb-1">
                                <span>Temperature (<span id="slider-temp-val">18.2</span>°C)</span>
                                <span class="text-gray-400 font-bold">Range: -10 to 50</span>
                            </div>
                            <input type="range" id="slider-temp" min="-10" max="50" step="0.1" value="18.2" oninput="updateCalibration()" class="w-full h-2 bg-blue-100 rounded-lg appearance-none cursor-pointer accent-blue-600">
                        </div>

                        <div>
                            <div class="flex justify-between text-[10px] font-extrabold text-blue-950 uppercase mb-1">
                                <span>Humidity (<span id="slider-hum-val">86.0</span>%)</span>
                                <span class="text-gray-400 font-bold">Range: 0 to 100</span>
                            </div>
                            <input type="range" id="slider-hum" min="0" max="100" step="0.5" value="86" oninput="updateCalibration()" class="w-full h-2 bg-blue-100 rounded-lg appearance-none cursor-pointer accent-blue-600">
                        </div>

                        <div>
                            <div class="flex justify-between text-[10px] font-extrabold text-blue-950 uppercase mb-1">
                                <span>Gas level (<span id="slider-gas-val">450</span> ppm)</span>
                                <span class="text-gray-400 font-bold">Range: 0 to 600</span>
                            </div>
                            <input type="range" id="slider-gas" min="0" max="600" step="5" value="450" oninput="updateCalibration()" class="w-full h-2 bg-blue-100 rounded-lg appearance-none cursor-pointer accent-blue-600">
                        </div>
                    </div>
                </div>

                <!-- Side-by-side Live Values Panel -->
                <div class="mt-4 pt-3 border-t border-blue-100">
                    <div class="grid grid-cols-2 gap-2 text-[9px] font-extrabold text-blue-950 uppercase text-center font-mono">
                        <div class="bg-white border border-blue-250 rounded-lg p-2.5">
                            <span class="block text-[8px] text-gray-400 mb-0.5">SENS-DG-01 (Meat)</span>
                            <span id="label-sensor1-val" class="font-bold text-[10px] text-red-500">18.2°C | 86% | 450ppm</span>
                        </div>
                        <div class="bg-white border border-blue-250 rounded-lg p-2.5">
                            <span class="block text-[8px] text-gray-400 mb-0.5">SENS-SY-02 (Veg)</span>
                            <span id="label-sensor2-val" class="font-bold text-[10px] text-yellow-600">12.5°C | 78% | 220ppm</span>
                        </div>
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
                        <input type="text" id="info-sensor-metrics" value="Temp: 18.2°C | Hum: 86% | Gas: 450 ppm" class="w-full px-3 py-2 text-xs font-bold text-red-500 gui-input" readonly>
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
                                {{ $reading->sensorDevice?->device_code ?? '-' }}
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
    // 2-Sensor Specifications & Calibration Data Setup
    // -----------------------------------------------------------------
    const sensors = {
        1: {
            code: 'SENS-DG-01',
            name: 'Sensor Ruang Daging',
            location: 'Gudang Penyimpanan Daging A',
            temp: 18.2,
            hum: 86.0,
            gas: 450,
            note: 'Tingkat kontaminasi gas amonia tinggi pada daging cincang.'
        },
        2: {
            code: 'SENS-SY-02',
            name: 'Sensor Rak Sayur',
            location: 'Chiller Sayuran B',
            temp: 12.5,
            hum: 78.0,
            gas: 220,
            note: 'Suhu chiller agak hangat, indikasi awal pembusukan daun sayur.'
        }
    };

    // -----------------------------------------------------------------
    // Live Inference Logic
    // -----------------------------------------------------------------
    function updateCalibration() {
        updateCalibrationValues();
        
        const temp = parseFloat(document.getElementById('slider-temp').value);
        const hum = parseFloat(document.getElementById('slider-hum').value);
        const gas = parseInt(document.getElementById('slider-gas').value);

        // Update active sensor data
        sensors[activeSensorId].temp = temp;
        sensors[activeSensorId].hum = hum;
        sensors[activeSensorId].gas = gas;

        // Update live metrics labels
        document.getElementById('label-sensor1-val').textContent = `${sensors[1].temp.toFixed(1)}°C | ${sensors[1].hum.toFixed(0)}% | ${sensors[1].gas}ppm`;
        document.getElementById('label-sensor2-val').textContent = `${sensors[2].temp.toFixed(1)}°C | ${sensors[2].hum.toFixed(0)}% | ${sensors[2].gas}ppm`;

        // Style the labels based on safety status
        const sens1Safety = getQuickSafetyLabel(sensors[1].temp, sensors[1].hum, sensors[1].gas);
        const sens2Safety = getQuickSafetyLabel(sensors[2].temp, sensors[2].hum, sensors[2].gas);

        document.getElementById('label-sensor1-val').className = `font-bold text-[10px] ${sens1Safety === 'bahaya' ? 'text-red-500 animate-pulse' : sens1Safety === 'waspada' ? 'text-yellow-600' : 'text-emerald-600'}`;
        document.getElementById('label-sensor2-val').className = `font-bold text-[10px] ${sens2Safety === 'bahaya' ? 'text-red-500 animate-pulse' : sens2Safety === 'waspada' ? 'text-yellow-600' : 'text-emerald-600'}`;

        // Update Bottom Panels
        const currentActive = sensors[activeSensorId];
        document.getElementById('info-sensor-code').value = currentActive.code;
        document.getElementById('info-sensor-name').value = currentActive.name;
        document.getElementById('info-sensor-location').value = currentActive.location;

        const metricsInput = document.getElementById('info-sensor-metrics');
        metricsInput.value = `Temp: ${temp.toFixed(1)}°C | Hum: ${hum.toFixed(0)}% | Gas: ${gas} ppm`;
        
        const finalClass = getQuickSafetyLabel(temp, hum, gas);
        if (finalClass === 'bahaya') {
            metricsInput.className = "w-full px-3 py-2 text-xs font-bold text-red-500 gui-input";
        } else if (finalClass === 'waspada') {
            metricsInput.className = "w-full px-3 py-2 text-xs font-bold text-yellow-600 gui-input";
        } else {
            metricsInput.className = "w-full px-3 py-2 text-xs font-bold text-emerald-600 gui-input";
        }

        // Barcode Specs panel details
        const statusColor = finalClass === 'aman' ? 'text-green-600' : finalClass === 'waspada' ? 'text-yellow-500' : 'text-red-500';
        const safetyStatusText = finalClass === 'aman' ? 'AMAN (Optimal)' : finalClass === 'waspada' ? 'WASPADA (Anomali)' : 'BAHAYA (KONTAMINASI)';
        const diagNote = finalClass === 'bahaya' ? 'Kadar kontaminasi gas kritis. Disarankan pengujian laboratorium lanjutan.' : finalClass === 'waspada' ? 'Suhu / Kelembaban di luar batas normal. Periksa sistem chiller.' : 'Metrik sensor dalam batas aman optimal.';
        
        document.getElementById('info-barcode-details').innerHTML = `
            <b>Sensor Code:</b> ${currentActive.code}<br>
            <b>Sensor Name:</b> ${currentActive.name}<br>
            <b>Status:</b> <span class="font-extrabold ${statusColor}">${safetyStatusText}</span><br>
            <b>Location:</b> ${currentActive.location}<br>
            <b>Diagnostics:</b> ${diagNote}
        `;
    }

    function getQuickSafetyLabel(t, h, g) {
        let dangerCount = 0;
        let warningCount = 0;

        if (t > 40 || t < -5) dangerCount++;
        else if (t > 8 || t < 0) warningCount++;

        if (h > 85 || h < 10) dangerCount++;
        else if (h > 70 || h < 20) warningCount++;

        if (g > 400) dangerCount++;
        else if (g > 200) warningCount++;

        if (dangerCount >= 1) return 'bahaya';
        if (warningCount >= 1) return 'waspada';
        return 'aman';
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

    // -----------------------------------------------------------------
    // Interactive Simulation Toggles (Auto Cycle & Sliders Tickers)
    // -----------------------------------------------------------------
    function toggleAutoSimulation() {
        const btn = document.getElementById('btn-auto-simulate');
        if (autoSimInterval) {
            clearInterval(autoSimInterval);
            autoSimInterval = null;
            btn.innerHTML = '<i class="fa-solid fa-play mr-1"></i>AUTO CYCLE';
            btn.className = "text-[9px] font-extrabold px-2.5 py-1 rounded bg-brandGreen hover:bg-brandGreenHover text-white shadow-sm transition";
            logConsole(`Automatic simulation cycle PAUSED.`);
        } else {
            logConsole(`Automatic simulation cycle STARTED.`);
            btn.innerHTML = '<i class="fa-solid fa-pause mr-1"></i>PAUSE CYCLE';
            btn.className = "text-[9px] font-extrabold px-2.5 py-1 rounded bg-red-500 hover:bg-red-600 text-white shadow-sm transition";
            
            autoSimInterval = setInterval(() => {
                autoSimTime += 0.15;
                
                // Oscillate sliders based on sine waves to demonstrate dynamic ML outputs
                let t_val, h_val, g_val;
                
                if (activeSensorId === 1) {
                    t_val = 18.2 + 15.0 * Math.sin(autoSimTime);
                    h_val = 65.0 + 20.0 * Math.sin(autoSimTime * 1.2);
                    g_val = Math.round(280 + 220 * Math.sin(autoSimTime * 0.8));
                } else {
                    t_val = 8.5 + 8.0 * Math.sin(autoSimTime);
                    h_val = 75.0 + 15.0 * Math.cos(autoSimTime * 0.7);
                    g_val = Math.round(180 + 150 * Math.sin(autoSimTime * 1.1));
                }

                // Constraints to range limits
                t_val = Math.max(-10, Math.min(50, t_val));
                h_val = Math.max(0, Math.min(100, h_val));
                g_val = Math.max(0, Math.min(600, g_val));

                document.getElementById('slider-temp').value = t_val.toFixed(1);
                document.getElementById('slider-hum').value = h_val.toFixed(1);
                document.getElementById('slider-gas').value = g_val;

                updateCalibration();
                
                // periodic console log
                if (Math.round(autoSimTime * 10) % 20 === 0) {
                    logConsole(`Auto-inference cycle running. Active Sensor ${activeSensorId} outputs refreshed.`);
                }
            }, 300);
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
            if (count === 1) logConsole(`Pinging Sensor 1 (SENS-DG-01)...`);
            if (count === 2) logConsole(`Pinging Sensor 2 (SENS-SY-02)...`);
            if (count === 3) {
                logConsole(`Scan complete. 2 physical sensors active in dual ML inference mode.`);
                clearInterval(scanInt);
                alert('Jaringan sensor berhasil dipindai!');
            }
        }, 800);
    }

    function resetConsoleSimulation() {
        elapsedSeconds = 0;
        document.getElementById('elapsed-timer').textContent = "00:00:00";
        document.getElementById('history-log-box').innerHTML = `<div>[${new Date().toLocaleTimeString()}] Simulation parameters reset successfully.</div>`;
        
        sensors[1].temp = 4.2;
        sensors[1].hum = 68.0;
        sensors[1].gas = 120;

        sensors[2].temp = 8.5;
        sensors[2].hum = 75.0;
        sensors[2].gas = 150;

        document.getElementById('total-alerts-count').textContent = "0 LOGS";

        if (autoSimInterval) {
            toggleAutoSimulation();
        }

        changeActiveSensor(1);
        logConsole(`Parameters reset. Models returned to normal safe state.`);
    }

    // Initialize select state to Sensor 1 on load
    window.addEventListener('DOMContentLoaded', () => {
        changeActiveSensor(1);
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
