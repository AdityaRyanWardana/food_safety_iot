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

<!-- ==================== GRAFIK TELEMETRI SENSOR ==================== -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8 mt-2">
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/30 flex items-center justify-between">
        <div>
            <h3 class="font-bold font-outfit text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-chart-area text-blue-500"></i>
                Grafik Telemetri Real-Time
            </h3>
            <p class="text-xs text-gray-400 mt-0.5">Visualisasi data suhu, kelembaban, dan kadar gas dari sensor aktif.</p>
        </div>
        <div class="flex gap-2">
            <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-gray-500 px-2.5 py-1 bg-white border border-gray-200 rounded-lg"><span class="w-2 h-2 rounded-full bg-red-500"></span> Suhu (°C)</span>
            <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-gray-500 px-2.5 py-1 bg-white border border-gray-200 rounded-lg"><span class="w-2 h-2 rounded-full bg-blue-500"></span> Kelembaban (%)</span>
            <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-gray-500 px-2.5 py-1 bg-white border border-gray-200 rounded-lg"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Gas (ppm/10)</span>
        </div>
    </div>
    <div class="p-5">
        <div class="h-[300px] w-full">
            <canvas id="telemetryChart"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- ==================== TABEL LOG DATABASE ==================== -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
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
<!-- ==================== JAVASCRIPT SIMULATION ==================== -->
<script>
    // -----------------------------------------------------------------
    // Chart.js Setup
    // -----------------------------------------------------------------
    let telemetryChart;
    const maxDataPoints = 20;
    const chartLabels = Array(maxDataPoints).fill('');
    const chartDataTemp = Array(maxDataPoints).fill(0);
    const chartDataHum = Array(maxDataPoints).fill(0);
    const chartDataGas = Array(maxDataPoints).fill(0);

    function initChart() {
        const ctx = document.getElementById('telemetryChart').getContext('2d');
        telemetryChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Suhu (°C)',
                        data: chartDataTemp,
                        borderColor: '#EF4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 2,
                        pointRadius: 2,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Kelembaban (%)',
                        data: chartDataHum,
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        pointRadius: 2,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Gas (ppm/10)',
                        data: chartDataGas,
                        borderColor: '#F59E0B',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        borderWidth: 2,
                        pointRadius: 2,
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 0
                },
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#F3F4F6' },
                        ticks: {
                            font: { size: 10, family: "'Plus Jakarta Sans', sans-serif" }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { display: false }
                    }
                }
            }
        });
    }

    // -----------------------------------------------------------------
    // Chart Live Simulation Logic
    // -----------------------------------------------------------------
    let autoSimTime = 0;

    function updateCalibration(t, h, g) {
        // Update Chart
        if (telemetryChart) {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', { hour12: false, hour: "numeric", minute: "numeric", second: "numeric" });
            
            // Push new data
            telemetryChart.data.labels.push(timeStr);
            telemetryChart.data.datasets[0].data.push(t);
            telemetryChart.data.datasets[1].data.push(h);
            telemetryChart.data.datasets[2].data.push(g / 10); // Scale down gas for charting

            // Remove oldest data if exceeding max length
            if (telemetryChart.data.labels.length > maxDataPoints) {
                telemetryChart.data.labels.shift();
                telemetryChart.data.datasets[0].data.shift();
                telemetryChart.data.datasets[1].data.shift();
                telemetryChart.data.datasets[2].data.shift();
            }

            telemetryChart.update();
        }
    }

    function fetchRealTimeData() {
        setInterval(() => {
            fetch('/api/latest-metric')
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        let t_val = parseFloat(data.temperature) || 0;
                        let h_val = parseFloat(data.humidity) || 0;
                        let g_val = parseInt(data.gas_level) || 0;
                        updateCalibration(t_val, h_val, g_val);
                    } else {
                        updateCalibration(0, 0, 0);
                    }
                })
                .catch(err => {
                    console.error('Failed to fetch telemetry:', err);
                    updateCalibration(0, 0, 0);
                });
        }, 2000);
    }

    // Initialize chart and simulation on load
    window.addEventListener('DOMContentLoaded', () => {
        initChart();
        fetchRealTimeData();
    });

    // -----------------------------------------------------------------
    // Legacy / Tabular logs controls & filters (Preserved functionality)
    // -----------------------------------------------------------------
    function confirmReadingsDelete(button) {
        if (button.classList.contains('confirm-state')) {
            if (button.dataset.submitting) return;
            button.dataset.submitting = 'true';
            button.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i>...';
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
            if (button.dataset.submitting) return;
            button.dataset.submitting = 'true';
            button.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Proses...';
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

@endsection
