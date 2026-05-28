@extends('layouts.admin')
@section('title', 'Pengetesan Pangan - FoodDetect Admin')
@section('breadcrumb', 'Pengetesan Pangan')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Header Section -->
<div class="flex justify-between items-end mb-6">
    <div>
        <h2 class="text-2xl font-bold font-outfit text-gray-900 tracking-tight">Pengetesan Pangan via Sensor USB</h2>
        <p class="text-gray-500 text-sm mt-1">Hubungkan sensor micro-controller Anda via USB untuk analisis kontaminasi real-time.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Controls & Configuration -->
    <div class="lg:col-span-1 space-y-6">
        <!-- USB Connection Card -->
        <div class="relative overflow-hidden bg-white rounded-2xl p-6 shadow-sm border border-gray-150/70 transition hover:shadow-md group">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-usb text-brandGreen"></i>
                Koneksi Sensor USB
            </h3>
            
            <div id="connectionStatus" class="flex items-center mb-4 px-4 py-3.5 rounded-xl bg-gray-50 border border-gray-200/50">
                <span id="statusDot" class="w-2.5 h-2.5 rounded-full bg-gray-400 mr-3 animate-pulse"></span>
                <span id="statusText" class="text-xs font-bold text-gray-450 uppercase tracking-widest">Tidak Terhubung</span>
            </div>

            <!-- Baud Rate Selector (Added for modern microcontroller/ESP32 compatibility) -->
            <div class="mb-4">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Baud Rate (Kecepatan Serial)</label>
                <select id="baudRateSelect" class="w-full border border-gray-250 rounded-xl px-3 py-2.5 text-xs bg-white outline-none focus:ring-2 focus:ring-[#8DC63F]/30 focus:border-brandGreen transition duration-300">
                    <option value="9600">9600 Baud (Arduino Uno/Nano/Mega default)</option>
                    <option value="115200" selected>115200 Baud (ESP32/ESP8266/NodeMCU default)</option>
                    <option value="57600">57600 Baud</option>
                    <option value="38400">38400 Baud</option>
                    <option value="19200">19200 Baud</option>
                </select>
            </div>
            
            <button id="btnConnect" onclick="connectSerial()" class="w-full bg-brandGreen text-white py-3 rounded-xl font-bold hover:bg-brandGreenHover hover:shadow-lg hover:shadow-brandGreen/25 transition duration-300 flex items-center justify-center gap-2">
                <i class="fa-solid fa-plug"></i>Hubungkan Sensor USB
            </button>
            
            <button id="btnDisconnect" onclick="disconnectSerial()" class="hidden w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl font-bold transition duration-300 flex items-center justify-center gap-2">
                <i class="fa-solid fa-plug-circle-xmark"></i>Putuskan Koneksi
            </button>
            <p class="text-[10px] text-gray-400 mt-3 text-center leading-relaxed">Mendukung Chrome, Edge, & Opera. Pastikan board mikrokontroler tercolok dan **Serial Monitor Arduino IDE Anda ditutup** agar tidak bentrok.</p>
        </div>

        <!-- Sample Info Card -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-150/70 transition hover:shadow-md">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-flask text-blue-500"></i>
                Informasi Sampel
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nama Sampel</label>
                    <input type="text" id="sampleName" placeholder="Daging Sapi Lot-A1" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white outline-none focus:ring-2 focus:ring-[#8DC63F]/30 focus:border-brandGreen transition duration-300">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Kategori Pangan</label>
                    <select id="foodCategory" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white outline-none focus:ring-2 focus:ring-[#8DC63F]/30 focus:border-brandGreen transition duration-300">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Perangkat Sensor IoT</label>
                    <select id="sensorDevice" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white outline-none focus:ring-2 focus:ring-[#8DC63F]/30 focus:border-brandGreen transition duration-300">
                        <option value="">-- Pilih Perangkat Sensor --</option>
                        @foreach($devices as $dev)
                        <option value="{{ $dev->id }}">{{ $dev->name }} ({{ $dev->device_code }})</option>
                        @endforeach
                    </select>
                    <div class="mt-1.5 flex justify-between items-center text-[10px]">
                        <span class="text-gray-400">Pilih board pengirim data telemetri.</span>
                        <a href="{{ route('admin.sensors.index') }}" class="text-brandGreen hover:underline font-bold">
                            <i class="fa-solid fa-plus-circle"></i> Tambah Perangkat Baru
                        </a>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Catatan Khusus</label>
                    <textarea id="notes" rows="2" placeholder="Kondisi fisik, bau, atau detail sampel..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white outline-none resize-none focus:ring-2 focus:ring-[#8DC63F]/30 focus:border-brandGreen transition duration-300"></textarea>
                </div>
            </div>
        </div>

        <!-- Manual Input Card -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-150/70 transition hover:shadow-md">
            <h3 class="font-bold text-gray-900 mb-1 flex items-center gap-2">
                <i class="fa-solid fa-keyboard text-purple-500"></i>
                Input Manual (Fallback)
            </h3>
            <p class="text-[10px] text-gray-400 mb-4">Simulasikan data apabila perangkat sensor fisik tidak tersedia.</p>
            
            <div class="grid grid-cols-2 gap-3.5">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Suhu (°C)</label>
                    <input type="number" id="manualTemp" step="0.1" placeholder="25.5" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-white outline-none focus:ring-2 focus:ring-[#8DC63F]/30 focus:border-brandGreen transition duration-300">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Kelembapan (%)</label>
                    <input type="number" id="manualHum" step="0.1" placeholder="68.0" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-white outline-none focus:ring-2 focus:ring-[#8DC63F]/30 focus:border-brandGreen transition duration-300">
                </div>
                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Gas (ppm)</label>
                    <input type="number" id="manualGas" step="0.1" placeholder="120" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-white outline-none focus:ring-2 focus:ring-[#8DC63F]/30 focus:border-brandGreen transition duration-300">
                </div>
            </div>
            
            <button onclick="submitManualReading()" class="w-full mt-4 bg-gradient-to-r from-purple-600 to-indigo-650 hover:from-purple-700 hover:to-indigo-750 text-white py-3 rounded-xl font-bold transition duration-300 flex items-center justify-center gap-2 shadow-sm shadow-purple-100">
                <i class="fa-solid fa-paper-plane"></i>Kirim & Analisis Manual
            </button>
        </div>
    </div>

    <!-- Right Column: Real-time Telemetry & Diagnostics -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Live Gauges Dashboard -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-150/70 transition hover:shadow-md">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-gauge-high text-brandGreen"></i>
                Telemetri Sensor Real-Time
            </h3>
            
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Temp Gauge -->
                <div class="relative overflow-hidden p-4 rounded-2xl bg-gradient-to-b from-green-50/20 to-white border border-green-100/50 text-center">
                    <i class="fa-solid fa-temperature-half text-3xl text-brandGreen mb-2.5"></i>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Suhu</p>
                    <p id="liveTemp" class="text-3xl font-black text-gray-900 mt-1">--</p>
                    <span class="text-[10px] font-bold text-gray-400">°C</span>
                </div>
                
                <!-- Humidity Gauge -->
                <div class="relative overflow-hidden p-4 rounded-2xl bg-gradient-to-b from-blue-50/50 to-white border border-blue-100/50 text-center">
                    <i class="fa-solid fa-droplet text-3xl text-blue-500 mb-2.5"></i>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kelembapan</p>
                    <p id="liveHum" class="text-3xl font-black text-gray-900 mt-1">--</p>
                    <span class="text-[10px] font-bold text-gray-400">%</span>
                </div>
                
                <!-- Gas Gauge -->
                <div class="relative overflow-hidden p-4 rounded-2xl bg-gradient-to-b from-yellow-50/50 to-white border border-yellow-100/50 text-center">
                    <i class="fa-solid fa-smog text-3xl text-yellow-600 mb-2.5"></i>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kandungan Gas</p>
                    <p id="liveGas" class="text-3xl font-black text-gray-900 mt-1">--</p>
                    <span class="text-[10px] font-bold text-gray-400">ppm</span>
                </div>
                
            </div>

            <!-- Live Status & Raw ADC Row (Premium Hardware Style) -->
            <div class="mt-4 pt-4 border-t border-gray-150/70 grid grid-cols-2 gap-4">
                <div class="bg-gray-50/50 rounded-xl px-4 py-2.5 flex items-center justify-between border border-gray-200/50 shadow-inner">
                    <div class="flex items-center gap-2">
                        <span class="text-[9px] font-extrabold text-gray-500 uppercase">Status Sensor:</span>
                        <span id="liveStatusBadge" class="text-[9px] font-black uppercase px-2 py-0.5 rounded bg-gray-400 text-white flex items-center gap-1 shadow-sm">
                            <i class="fa-solid fa-circle-question"></i> MENUNGGU DATA
                        </span>
                    </div>
                </div>
                <div class="bg-gray-50/50 rounded-xl px-4 py-2.5 flex items-center justify-between border border-gray-200/50 shadow-inner">
                    <div class="flex items-center gap-2">
                        <span class="text-[9px] font-extrabold text-gray-500 uppercase">Raw ADC MQ135:</span>
                        <span id="liveAdcValue" class="text-xs font-mono font-black text-gray-700">--</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-5">
                <button id="btnSaveReading" onclick="saveCurrentReading()" disabled class="w-full bg-brandGreen text-white py-3 rounded-xl font-bold hover:bg-brandGreenHover hover:shadow-lg hover:shadow-brandGreen/25 transition duration-300 disabled:opacity-40 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>Simpan & Analisis Telemetri
                </button>
            </div>
        </div>

        <!-- Result Display Card -->
        <div id="analysisResult" class="hidden">
            <div id="resultCard" class="rounded-2xl shadow-sm border p-6 transition duration-300">
                <div class="flex items-center">
                    <div id="resultIcon" class="w-14 h-14 rounded-2xl flex items-center justify-center text-3xl mr-4 shadow-sm border"></div>
                    <div>
                        <h3 id="resultTitle" class="text-lg font-bold tracking-tight"></h3>
                        <p id="resultMsg" class="text-xs mt-1 text-gray-500"></p>
                    </div>
                </div>
                <div id="resultDetails" class="grid grid-cols-3 gap-3 mt-4 pt-4 border-t border-gray-200/50"></div>
            </div>
        </div>

        <!-- Serial Terminal Monitor -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-150/70 transition hover:shadow-md">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-terminal text-gray-500"></i>
                Serial Monitor Output
            </h3>
            <div id="serialLog" class="bg-gray-950 text-green-400 rounded-xl p-4 h-48 overflow-y-auto font-mono text-xs leading-relaxed border border-gray-800 shadow-inner">
                <p class="text-gray-500">[ SYSTEM ] Menunggu inisiasi koneksi USB sensor...</p>
            </div>
        </div>

        <!-- Recent testing logs list -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-150/70 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/30">
                <h3 class="font-bold font-outfit text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-history text-brandGreen"></i>
                    Riwayat Pengetesan Terakhir
                </h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-50/20 border-b border-gray-100 text-xs text-gray-400 uppercase tracking-wider">
                            <th class="px-6 py-3 font-bold">Waktu</th>
                            <th class="px-6 py-3 font-bold">Sampel</th>
                            <th class="px-6 py-3 font-bold">Suhu</th>
                            <th class="px-6 py-3 font-bold">Gas</th>

                            <th class="px-6 py-3 font-bold text-right">Status Keamanan</th>
                        </tr>
                    </thead>
                    <tbody id="readingsBody" class="divide-y divide-gray-100">
                        @foreach($recentReadings as $r)
                        <tr class="hover:bg-gray-50/30 transition">
                            <td class="px-6 py-3 text-xs text-gray-400">{{ $r->read_at?->format('d/m H:i') }}</td>
                            <td class="px-6 py-3 font-bold text-gray-800">{{ $r->sample_name ?? '-' }}</td>
                            <td class="px-6 py-3 font-semibold">{{ $r->temperature }}°C</td>
                            <td class="px-6 py-3 font-semibold">{{ $r->gas_level }} ppm</td>
                            <td class="px-6 py-3 text-right">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border shadow-sm
                                    @if($r->safety_status==='aman') bg-green-50 text-emerald-700 border-green-200/60
                                    @elseif($r->safety_status==='waspada') bg-yellow-50 text-yellow-700 border-yellow-200/60
                                    @else bg-red-50 text-red-600 border-red-200/60
                                    @endif">
                                    {{ ucfirst($r->safety_status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
let port = null, reader = null, isConnected = false;
let currentData = { temperature: null, humidity: null, gas_level: null, safety_status: null, raw_adc: null };

function log(msg, type = 'info') {
    const el = document.getElementById('serialLog');
    const colors = { info: 'text-green-400', error: 'text-red-400', warn: 'text-yellow-400', data: 'text-cyan-300' };
    const time = new Date().toLocaleTimeString();
    el.innerHTML += `<p class="${colors[type] || colors.info}">[ ${time} ] ${msg}</p>`;
    el.scrollTop = el.scrollHeight;
}

function updateLiveStatusUI(status, label) {
    const badge = document.getElementById('liveStatusBadge');
    if (!badge) return;
    
    if (status === 'aman') {
        badge.className = "text-[9px] font-black uppercase px-2 py-0.5 rounded bg-emerald-500 text-white flex items-center gap-1 shadow-sm animate-pulse";
        badge.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + label.toUpperCase();
    } else if (status === 'waspada') {
        badge.className = "text-[9px] font-black uppercase px-2 py-0.5 rounded bg-amber-500 text-white flex items-center gap-1 shadow-sm animate-pulse";
        badge.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> ' + label.toUpperCase();
    } else if (status === 'bahaya') {
        badge.className = "text-[9px] font-black uppercase px-2 py-0.5 rounded bg-red-500 text-white flex items-center gap-1 shadow-sm animate-pulse";
        badge.innerHTML = '<i class="fa-solid fa-skull-crossbones"></i> ' + label.toUpperCase();
    }
}

async function connectSerial() {
    if (!('serial' in navigator)) {
        alert('Browser tidak mendukung Web Serial API. Gunakan Chrome atau Edge.');
        return;
    }
    try {
        port = await navigator.serial.requestPort();
        const baudRate = parseInt(document.getElementById('baudRateSelect').value) || 115200;
        await port.open({ baudRate: baudRate });
        isConnected = true;
        updateConnectionUI(true);
        log(`✅ Sensor USB terhubung dengan kecepatan ${baudRate} Baud!`);
        readSerialData();
    } catch (e) {
        log('❌ Gagal menghubungkan: ' + e.message, 'error');
    }
}

async function disconnectSerial() {
    if (reader) { await reader.cancel(); reader = null; }
    if (port) { await port.close(); port = null; }
    isConnected = false;
    updateConnectionUI(false);
    log('🔌 Sensor terputus.');
}

async function readSerialData() {
    const decoder = new TextDecoderStream();
    port.readable.pipeTo(decoder.writable);
    reader = decoder.readable.getReader();
    let buffer = '';
    try {
        while (true) {
            const { value, done } = await reader.read();
            if (done) break;
            buffer += value;
            const lines = buffer.split('\n');
            buffer = lines.pop();
            for (const line of lines) {
                parseAndDisplay(line.trim());
            }
        }
    } catch (e) {
        if (isConnected) log('⚠️ Koneksi terputus: ' + e.message, 'warn');
    }
}

function parseAndDisplay(line) {
    if (!line) return;
    log(line, 'data');
    
    let parsedAny = false;

    // Cara 1: Deteksi format JSON (e.g. {"temp": 25.5, "hum": 60, "gas": 120})
    if (line.trim().startsWith('{') && line.trim().endsWith('}')) {
        try {
            const data = JSON.parse(line);
            for (let k in data) {
                const num = parseFloat(data[k]);
                if (isNaN(num)) continue;
                const key = k.trim().toUpperCase();
                if (key.includes('TEMP') || key === 'T') { currentData.temperature = num; document.getElementById('liveTemp').textContent = num.toFixed(2); parsedAny = true; }
                else if (key.includes('HUM') || key === 'H') { currentData.humidity = num; document.getElementById('liveHum').textContent = num.toFixed(2); parsedAny = true; }
                else if (key.includes('GAS') || key === 'G') { currentData.gas_level = num; document.getElementById('liveGas').textContent = num.toFixed(2); parsedAny = true; }
            }
            if (parsedAny) {
                document.getElementById('btnSaveReading').disabled = false;
                return;
            }
        } catch (e) {
            // Bukan JSON valid, lanjut ke parse text biasa
        }
    }

    // Cara 2: Deteksi format Key:Value atau Key=Value (e.g. T:25, H:60 atau temp=25.5, hum=60.0)
    const cleanedLine = line.replace(/=/g, ':');
    const parts = cleanedLine.split(',');
    
    parts.forEach(p => {
        const colonIndex = p.indexOf(':');
        if (colonIndex === -1) return;
        const key = p.substring(0, colonIndex).trim().toUpperCase();
        const val = p.substring(colonIndex + 1).trim();

        // 1. Handle non-numeric "Status" from Arduino
        if (key.includes('STATUS')) {
            const statusUpper = val.toUpperCase();
            if (statusUpper.includes('AMAN')) {
                currentData.safety_status = 'aman';
                updateLiveStatusUI('aman', 'Aman (Optimal)');
            } else if (statusUpper.includes('KONTAMINASI') || statusUpper.includes('TERKONTAMINASI')) {
                currentData.safety_status = 'waspada';
                updateLiveStatusUI('waspada', 'Terkontaminasi');
            } else if (statusUpper.includes('BAHAYA') || statusUpper.includes('BERBAHAYA')) {
                currentData.safety_status = 'bahaya';
                updateLiveStatusUI('bahaya', 'Berbahaya');
            }
            return;
        }

        // 2. Handle raw ADC value from Arduino
        if (key.includes('ADC')) {
            const rawAdc = parseInt(val);
            if (!isNaN(rawAdc)) {
                document.getElementById('liveAdcValue').textContent = rawAdc;
                currentData.raw_adc = rawAdc;
            }
            return;
        }

        const num = parseFloat(val);
        if (isNaN(num)) return;

        if (key.includes('TEMP') || key === 'T' || key.includes('SUHU')) { currentData.temperature = num; document.getElementById('liveTemp').textContent = num.toFixed(2); parsedAny = true; }
        else if (key.includes('HUM') || key === 'H' || key.includes('LEMBAB')) { currentData.humidity = num; document.getElementById('liveHum').textContent = num.toFixed(2); parsedAny = true; }
        else if (key.includes('GAS') || key === 'G') { currentData.gas_level = num; document.getElementById('liveGas').textContent = num.toFixed(2); parsedAny = true; }
    });

    // Cara 3: Deteksi raw data angka saja (e.g. "25.5, 60.1, 120, 6.8")
    if (!parsedAny) {
        const numbers = line.split(/[,\s\t]+/).map(parseFloat).filter(n => !isNaN(n));
        if (numbers.length >= 3) {
            currentData.temperature = numbers[0]; document.getElementById('liveTemp').textContent = numbers[0].toFixed(2);
            currentData.humidity = numbers[1]; document.getElementById('liveHum').textContent = numbers[1].toFixed(2);
            currentData.gas_level = numbers[2]; document.getElementById('liveGas').textContent = numbers[2].toFixed(2);
            parsedAny = true;
        }
    }

    if (parsedAny) {
        document.getElementById('btnSaveReading').disabled = false;
    }
}

function updateConnectionUI(connected) {
    document.getElementById('statusDot').className = `w-2.5 h-2.5 rounded-full mr-3 animate-pulse ${connected ? 'bg-emerald-500 shadow-sm shadow-emerald-400' : 'bg-gray-400'}`;
    document.getElementById('statusText').textContent = connected ? 'Terhubung' : 'Tidak terhubung';
    document.getElementById('statusText').className = `text-xs font-bold ${connected ? 'text-emerald-500' : 'text-gray-400'} uppercase tracking-widest`;
    document.getElementById('connectionStatus').className = `flex items-center mb-4 px-4 py-3.5 rounded-xl ${connected ? 'bg-emerald-50/50 border border-emerald-200/50' : 'bg-gray-50 border border-gray-200/50'}`;
    document.getElementById('btnConnect').classList.toggle('hidden', connected);
    document.getElementById('btnDisconnect').classList.toggle('hidden', !connected);
}

function submitManualReading() {
    currentData.temperature = parseFloat(document.getElementById('manualTemp').value) || null;
    currentData.humidity = parseFloat(document.getElementById('manualHum').value) || null;
    currentData.gas_level = parseFloat(document.getElementById('manualGas').value) || null;
    document.getElementById('liveTemp').textContent = currentData.temperature?.toFixed(1) ?? '--';
    document.getElementById('liveHum').textContent = currentData.humidity?.toFixed(1) ?? '--';
    document.getElementById('liveGas').textContent = currentData.gas_level?.toFixed(0) ?? '--';
    log(`📝 Input manual: T=${currentData.temperature}, H=${currentData.humidity}, G=${currentData.gas_level}`);
    saveCurrentReading();
}

async function saveCurrentReading() {
    const payload = {
        sample_name: document.getElementById('sampleName').value,
        food_category_id: document.getElementById('foodCategory').value || null,
        sensor_device_id: document.getElementById('sensorDevice').value || null,
        notes: (currentData.raw_adc ? `[Raw ADC MQ135: ${currentData.raw_adc}] ` : '') + document.getElementById('notes').value,
        ...currentData
    };
    try {
        const res = await fetch('{{ route("admin.testing.store") }}', {
            method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' },
            body: JSON.stringify(payload)
        });
        const data = await res.json();
        if (data.success) {
            log(`💾 Data tersimpan! Status: ${data.safety_status.toUpperCase()}`, data.is_anomaly ? 'warn' : 'info');
            showResult(data);
            appendReadingToTable(data.reading, data.safety_status);
        }
    } catch (e) { log('❌ Gagal menyimpan: ' + e.message, 'error'); }
}

function appendReadingToTable(r, status) {
    const tbody = document.getElementById('readingsBody');
    const date = new Date();
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const mins = String(date.getMinutes()).padStart(2, '0');
    const timeStr = `${day}/${month} ${hours}:${mins}`;

    let badgeClass = 'bg-green-50 text-emerald-700 border-green-200/60';
    let statusText = 'Aman';
    
    if (status === 'waspada') {
        badgeClass = 'bg-yellow-50 text-yellow-700 border-yellow-200/60';
        statusText = 'Waspada';
    } else if (status === 'bahaya') {
        badgeClass = 'bg-red-50 text-red-600 border-red-200/60';
        statusText = 'Bahaya';
    }

    const tr = document.createElement('tr');
    tr.className = 'hover:bg-gray-50/30 transition animate-pulse';
    tr.innerHTML = `
        <td class="px-6 py-3 text-xs text-gray-400">${timeStr}</td>
        <td class="px-6 py-3 font-bold text-gray-800">${r.sample_name || '-'}</td>
        <td class="px-6 py-3 font-semibold">${r.temperature || '--'}°C</td>
        <td class="px-6 py-3 font-semibold">${r.gas_level || '--'} ppm</td>
        <td class="px-6 py-3 text-right">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border shadow-sm ${badgeClass}">
                ${statusText}
            </span>
        </td>
    `;
    
    tbody.prepend(tr);
    
    // Matikan efek pulse setelah 2 detik
    setTimeout(() => {
        tr.classList.remove('animate-pulse');
    }, 2000);
}

function showResult(data) {
    const el = document.getElementById('analysisResult'); el.classList.remove('hidden');
    const card = document.getElementById('resultCard');
    const icon = document.getElementById('resultIcon');
    const r = data.reading;
    if (data.safety_status === 'aman') {
        card.className = 'rounded-2xl shadow-sm border border-green-200 bg-green-50/50 p-6';
        icon.className = 'w-14 h-14 rounded-2xl flex items-center justify-center text-3xl mr-4 bg-green-100/50 text-emerald-600 border border-green-200/50';
        icon.innerHTML = '<i class="fa-solid fa-shield-halved"></i>';
        document.getElementById('resultTitle').className = 'text-lg font-bold text-emerald-800';
        document.getElementById('resultTitle').textContent = 'AMAN - Tidak Ada Kontaminasi';
    } else if (data.safety_status === 'waspada') {
        card.className = 'rounded-2xl shadow-sm border border-yellow-350 bg-yellow-50/50 p-6';
        icon.className = 'w-14 h-14 rounded-2xl flex items-center justify-center text-3xl mr-4 bg-yellow-100/50 text-yellow-600 border border-yellow-200/50';
        icon.innerHTML = '<i class="fa-solid fa-triangle-exclamation animate-bounce"></i>';
        document.getElementById('resultTitle').className = 'text-lg font-bold text-yellow-800';
        document.getElementById('resultTitle').textContent = 'WASPADA - Terdeteksi Anomali Ringan';
    } else {
        card.className = 'rounded-2xl shadow-sm border border-red-300 bg-red-50/50 p-6';
        icon.className = 'w-14 h-14 rounded-2xl flex items-center justify-center text-3xl mr-4 bg-red-100/50 text-red-600 border border-red-200/50';
        icon.innerHTML = '<i class="fa-solid fa-skull-crossbones animate-pulse"></i>';
        document.getElementById('resultTitle').className = 'text-lg font-bold text-red-800';
        document.getElementById('resultTitle').textContent = 'BAHAYA - Kontaminasi Terdeteksi!';
    }
    document.getElementById('resultMsg').textContent = data.message;
    document.getElementById('resultMsg').className = 'text-xs text-gray-500 mt-1 font-semibold';
    
    document.getElementById('resultDetails').innerHTML = `
        <div class="bg-white/80 rounded-xl p-3 text-center border border-gray-150/45"><p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Suhu</p><p class="font-bold text-gray-800 mt-0.5">${r.temperature ?? '--'}°C</p></div>
        <div class="bg-white/80 rounded-xl p-3 text-center border border-gray-150/45"><p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Humidity</p><p class="font-bold text-gray-800 mt-0.5">${r.humidity ?? '--'}%</p></div>
        <div class="bg-white/80 rounded-xl p-3 text-center border border-gray-150/45"><p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Gas</p><p class="font-bold text-gray-800 mt-0.5">${r.gas_level ?? '--'} ppm</p></div>`;
}
</script>
@endsection
