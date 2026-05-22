@extends('layouts.admin')

@section('title', 'Dashboard - FoodDetect Admin')
@section('breadcrumb', 'Dashboard Overview')

@section('content')
<!-- Header Section -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
    <div>
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brandGreen opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-brandGreen"></span>
            </span>
            <h2 class="text-2xl font-bold font-outfit text-gray-900 tracking-tight">Real-time Monitoring System</h2>
        </div>
        <p class="text-gray-500 text-sm mt-1">Status keamanan pangan termonitor secara langsung dari seluruh jaringan sensor IoT.</p>
    </div>
    
    <a href="{{ route('admin.testing.index') }}" class="group inline-flex items-center justify-center px-5 py-3 text-sm font-extrabold text-white rounded-2xl bg-brandGreen hover:bg-brandGreenHover hover:shadow-lg hover:shadow-brandGreen/25 transition duration-300 gap-2">
        <i class="fa-solid fa-flask"></i>
        Mulai Tes Pangan Baru
    </a>
</div>

<!-- Stats Dashboard Grid (Gaya Sego - Brand Green) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Active Sensors Card -->
    <div class="relative overflow-hidden bg-white rounded-2xl p-6 shadow-sm border border-gray-105 transition hover:shadow-md group">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-110 transition duration-300"></div>
        <div class="flex justify-between items-start mb-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-xl shadow-sm border border-blue-100/50">
                <i class="fa-solid fa-microchip"></i>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600">
                LIVE
            </span>
        </div>
        <div class="relative z-10">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Sensor Aktif</p>
            <h3 class="text-3xl font-black text-gray-900 mt-1 font-outfit">{{ $activeSensors }} <span class="text-xs font-bold text-gray-400">Unit</span></h3>
            <p class="text-[10px] text-brandGreen mt-2 font-bold flex items-center gap-1">
                <i class="fa-solid fa-circle-check"></i> Seluruh sensor online
            </p>
        </div>
    </div>
    
    <!-- Today Warnings Card -->
    <div class="relative overflow-hidden bg-white rounded-2xl p-6 shadow-sm border border-gray-105 transition hover:shadow-md group">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-red-50 rounded-full group-hover:scale-110 transition duration-300"></div>
        <div class="flex justify-between items-start mb-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-500 flex items-center justify-center text-xl shadow-sm border border-red-100/50">
                <i class="fa-solid fa-triangle-exclamation animate-pulse"></i>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold @if($warningsToday > 0) bg-red-100 text-red-650 animate-pulse @else bg-gray-50 text-gray-500 @endif">
                HARI INI
            </span>
        </div>
        <div class="relative z-10">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Peringatan Hari Ini</p>
            <h3 class="text-3xl font-black text-gray-900 mt-1 font-outfit">{{ $warningsToday }} <span class="text-xs font-bold text-gray-400">Log</span></h3>
            @if($warningsToday > 0)
            <p class="text-[10px] text-red-500 mt-2 font-bold flex items-center gap-1">
                <i class="fa-solid fa-circle-exclamation"></i> Segera lakukan investigasi!
            </p>
            @else
            <p class="text-[10px] text-brandGreen mt-2 font-bold flex items-center gap-1">
                <i class="fa-solid fa-circle-check"></i> Lingkungan terkendali
            </p>
            @endif
        </div>
    </div>

    <!-- Avg Temperature Card (Hijau Aksen) -->
    <div class="relative overflow-hidden bg-white rounded-2xl p-6 shadow-sm border border-gray-105 transition hover:shadow-md group">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-green-50/50 rounded-full group-hover:scale-110 transition duration-300"></div>
        <div class="flex justify-between items-start mb-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-green-50 text-brandGreen flex items-center justify-center text-xl shadow-sm border border-green-100/50">
                <i class="fa-solid fa-temperature-half"></i>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-50 text-brandGreen">
                RATA-RATA
            </span>
        </div>
        <div class="relative z-10">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Rata-rata Suhu</p>
            <h3 class="text-3xl font-black text-gray-900 mt-1 font-outfit">{{ number_format($avgTemp, 1) }} <span class="text-lg font-bold text-gray-400">°C</span></h3>
            <p class="text-[10px] text-gray-400 mt-2 font-bold flex items-center gap-1">
                <i class="fa-solid fa-snowflake text-blue-400"></i> Cold storage stabil
            </p>
        </div>
    </div>

    <!-- Avg Humidity Card -->
    <div class="relative overflow-hidden bg-white rounded-2xl p-6 shadow-sm border border-gray-105 transition hover:shadow-md group">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-110 transition duration-300"></div>
        <div class="flex justify-between items-start mb-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shadow-sm border border-emerald-100/50">
                <i class="fa-solid fa-droplet"></i>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600">
                RATA-RATA
            </span>
        </div>
        <div class="relative z-10">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Rata-rata Kelembapan</p>
            <h3 class="text-3xl font-black text-gray-900 mt-1 font-outfit">{{ number_format($avgHum, 1) }} <span class="text-lg font-bold text-gray-400">%</span></h3>
            <p class="text-[10px] text-gray-400 mt-2 font-bold flex items-center gap-1">
                <i class="fa-solid fa-wind text-gray-400"></i> Kelembapan sirkulasi optimal
            </p>
        </div>
    </div>
</div>

<!-- Main Section: Log Pemantauan Real-time (Sego Tabbed View) -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Card Header -->
    <div class="px-6 py-5 border-b border-gray-100 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 bg-gray-50/30">
        <div>
            <h3 class="font-bold font-outfit text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-brandGreen"></i>
                Log Pemantauan Real-time
            </h3>
            <p class="text-xs text-gray-400 mt-0.5">Histori pembacaan data sensor IoT terbaru dari laboratorium.</p>
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
                            <span class="font-bold text-gray-900 font-mono text-xs tracking-wide bg-gray-50 px-2.5 py-1 rounded-md border border-gray-100">
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
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-gray-50 text-gray-400 text-xs font-bold border border-gray-100" title="pH tidak terukur">
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
                            <button type="button" onclick="confirmReadingsDelete(this)" class="p-2 rounded-lg text-gray-450 hover:text-red-500 hover:bg-red-50 transition flex items-center gap-1" title="Hapus Log">
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
                            <p class="text-xs text-gray-450 mt-1 font-medium">Belum ada rekaman pemantauan sensor untuk kategori pangan ini.</p>
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

<script>
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
    button.classList.remove('text-gray-404', 'hover:text-red-500', 'hover:bg-red-50');
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
    button.classList.add('text-gray-404', 'hover:text-red-500', 'hover:bg-red-50');
    
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
    text.textContent = 'Bersihkan Semua Log';

    const cancelBtn = button.closest('form').querySelector('.bulk-cancel');
    if (cancelBtn) cancelBtn.classList.add('hidden');
}

function filterCategory(categoryName, btn) {
    // 1. Update button states
    document.querySelectorAll('.category-tab-btn').forEach(b => {
        b.className = "px-3.5 py-1.5 rounded-xl hover:bg-gray-100 hover:text-gray-700 transition category-tab-btn";
    });
    btn.className = "px-3.5 py-1.5 rounded-xl bg-brandGreen text-white shadow-sm shadow-brandGreen/25 category-tab-btn active";

    // 2. Filter rows
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

    // 3. Show/hide dynamic empty state
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
