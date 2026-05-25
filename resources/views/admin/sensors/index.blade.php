@extends('layouts.admin')

@section('title', 'Data Sensor IoT - FoodDetect Admin')
@section('breadcrumb', 'Data Sensor IoT')

@section('content')
<!-- Header Section -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h2 class="text-2xl font-bold font-outfit text-gray-900 tracking-tight">Data Sensor IoT</h2>
        <p class="text-gray-500 text-sm mt-1">Manajemen perangkat sensor yang terhubung ke jaringan pemantauan pangan.</p>
    </div>
    
    <button onclick="document.getElementById('addDeviceModal').classList.remove('hidden')" class="group inline-flex items-center justify-center px-5 py-3 text-sm font-extrabold text-white rounded-2xl bg-brandGreen hover:bg-brandGreenHover hover:shadow-lg hover:shadow-brandGreen/25 transition duration-300 gap-2">
        <i class="fa-solid fa-plus"></i>
        Tambah Sensor Baru
    </button>
</div>

<!-- Stats Dashboard Grid (Gaya Sego) -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Active Stats -->
    <div class="relative overflow-hidden bg-white rounded-2xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md group">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-green-50 rounded-full group-hover:scale-110 transition duration-300"></div>
        <div class="flex items-center gap-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-green-50 text-emerald-500 flex items-center justify-center text-xl shadow-sm border border-green-100/50">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Perangkat Aktif</p>
                <h3 class="text-2xl font-black text-gray-900 mt-0.5 font-outfit">{{ $totalActive }} <span class="text-xs font-bold text-gray-400">Unit</span></h3>
            </div>
        </div>
    </div>

    <!-- Inactive Stats -->
    <div class="relative overflow-hidden bg-white rounded-2xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md group">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-gray-50 rounded-full group-hover:scale-110 transition duration-300"></div>
        <div class="flex items-center gap-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-gray-100 text-gray-450 flex items-center justify-center text-xl shadow-sm border border-gray-200/50">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Perangkat Nonaktif</p>
                <h3 class="text-2xl font-black text-gray-900 mt-0.5 font-outfit">{{ $totalInactive }} <span class="text-xs font-bold text-gray-400">Unit</span></h3>
            </div>
        </div>
    </div>

    <!-- Maintenance Stats -->
    <div class="relative overflow-hidden bg-white rounded-2xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md group">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-green-50 rounded-full group-hover:scale-110 transition duration-300"></div>
        <div class="flex items-center gap-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-green-50 text-brandGreen flex items-center justify-center text-xl shadow-sm border border-green-100/50">
                <i class="fa-solid fa-wrench"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pemeliharaan</p>
                <h3 class="text-2xl font-black text-gray-900 mt-0.5 font-outfit">{{ $totalMaintenance }} <span class="text-xs font-bold text-gray-400">Unit</span></h3>
            </div>
        </div>
    </div>
</div>

<!-- Devices Card Table -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
        <div>
            <h3 class="font-bold font-outfit text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-microchip text-brandGreen"></i>
                Daftar Perangkat Sensor
            </h3>
            <p class="text-xs text-gray-400 mt-0.5">Seluruh unit sensor terdaftar dalam database.</p>
        </div>
        <span class="text-xs font-bold text-brandGreen bg-brandGreen/10 px-3 py-1.5 rounded-xl border border-brandGreen/20">
            Total: {{ $devices->total() }} perangkat
        </span>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-gray-50/20 border-b border-gray-100 text-xs text-gray-400 uppercase tracking-wider">
                    <th class="px-6 py-4 font-bold">Kode Perangkat</th>
                    <th class="px-6 py-4 font-bold">Nama Sensor</th>
                    <th class="px-6 py-4 font-bold">Tipe Sensor</th>
                    <th class="px-6 py-4 font-bold">Lokasi Penempatan</th>
                    <th class="px-6 py-4 font-bold">Pembacaan</th>
                    <th class="px-6 py-4 font-bold">Aktivitas Terakhir</th>
                    <th class="px-6 py-4 font-bold text-center">Status</th>
                    <th class="px-6 py-4 font-bold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($devices as $device)
                <tr class="hover:bg-gray-50/30 transition group">
                    <!-- Code -->
                    <td class="px-6 py-4">
                        <span class="font-bold text-gray-900 font-mono text-xs tracking-wide bg-gray-50 px-2.5 py-1 rounded-md border border-gray-100">
                            {{ $device->device_code }}
                        </span>
                    </td>
                    
                    <!-- Name -->
                    <td class="px-6 py-4 font-bold text-gray-800">
                        {{ $device->name }}
                    </td>
                    
                    <!-- Type Badge -->
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold border
                            @if($device->type === 'multi') bg-purple-50 text-purple-600 border-purple-200/50
                            @elseif($device->type === 'temperature') bg-orange-50 text-orange-600 border-orange-200/50
                            @elseif($device->type === 'humidity') bg-blue-50 text-blue-600 border-blue-200/50
                            @elseif($device->type === 'gas') bg-yellow-50 text-yellow-600 border-yellow-200/50
                            @else bg-teal-50 text-teal-600 border-teal-200/50
                            @endif">
                            <i class="
                                @if($device->type === 'multi') fa-solid fa-microchip
                                @elseif($device->type === 'temperature') fa-solid fa-temperature-half
                                @elseif($device->type === 'humidity') fa-solid fa-droplet
                                @elseif($device->type === 'gas') fa-solid fa-smog
                                @else fa-solid fa-vial
                                @endif mr-1.5 text-[10px]"></i>
                            {{ ucfirst($device->type) }}
                        </span>
                    </td>
                    
                    <!-- Location -->
                    <td class="px-6 py-4 text-gray-600 font-semibold">
                        {{ $device->location ?? '-' }}
                    </td>
                    
                    <!-- Reading count -->
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-500 bg-gray-50 px-2.5 py-1 rounded-lg border border-gray-100">
                            <i class="fa-solid fa-database text-gray-400"></i>
                            {{ $device->readings_count }} logs
                        </span>
                    </td>
                    
                    <!-- Last Active -->
                    <td class="px-6 py-4 text-gray-400 text-xs font-semibold">
                        {{ $device->last_reading_at ? $device->last_reading_at->diffForHumans() : 'Belum Terdeteksi' }}
                    </td>
                    
                    <!-- Status Badge -->
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border shadow-sm
                            @if($device->status === 'active') bg-green-50 text-emerald-700 border-green-200/60
                            @elseif($device->status === 'maintenance') bg-green-55 text-brandGreen border-brandGreen/20
                            @else bg-gray-50 text-gray-500 border-gray-250/60
                            @endif">
                            <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                @if($device->status === 'active') bg-emerald-500 animate-pulse
                                @elseif($device->status === 'maintenance') bg-brandGreen
                                @else bg-gray-400
                                @endif"></span>
                            {{ ucfirst($device->status) }}
                        </span>
                    </td>
                    
                    <!-- Action Delete -->
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('admin.sensors.destroy', $device) }}" method="POST" class="inline" onsubmit="return confirm('Hapus sensor ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 rounded-lg text-gray-450 hover:text-red-500 hover:bg-red-50 transition" title="Hapus Sensor">
                                <i class="fa-solid fa-trash-can text-sm"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-16 text-center text-gray-400">
                        <div class="max-w-sm mx-auto">
                            <div class="w-16 h-16 mx-auto bg-gray-50 rounded-full flex items-center justify-center text-gray-400 mb-4 border border-gray-100">
                                <i class="fa-solid fa-microchip text-2xl"></i>
                            </div>
                            <p class="font-bold text-gray-800">Belum ada perangkat sensor</p>
                            <p class="text-xs text-gray-400 mt-1">Tambahkan perangkat baru untuk merekam data pangan Anda secara periodik.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($devices->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/20">
        {{ $devices->links() }}
    </div>
    @endif
</div>

<!-- Add Device Modal -->
<div id="addDeviceModal" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm transition duration-300">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md border border-gray-100 transform transition-all duration-300">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
            <h3 class="text-lg font-bold font-outfit text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-circle-plus text-brandGreen"></i>
                Tambah Sensor Baru
            </h3>
            <button onclick="document.getElementById('addDeviceModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-lg hover:bg-gray-100 transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        
        <form action="{{ route('admin.sensors.store') }}" method="POST" class="p-6 space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Kode Perangkat</label>
                <input type="text" name="device_code" required placeholder="SENS-DG-01" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#8DC63F]/30 focus:border-brandGreen bg-white outline-none transition duration-300">
            </div>
            
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nama Sensor</label>
                <input type="text" name="name" required placeholder="Sensor Suhu Gudang A" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#8DC63F]/30 focus:border-brandGreen bg-white outline-none transition duration-300">
            </div>
            
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Tipe Sensor</label>
                <select name="type" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#8DC63F]/30 focus:border-brandGreen bg-white outline-none transition duration-300">
                    <option value="multi">👨‍💻 Multi-Sensor</option>
                    <option value="temperature">🌡️ Temperature</option>
                    <option value="humidity">💧 Humidity</option>
                    <option value="gas">💨 Gas</option>
                    <option value="ph">🧪 pH</option>
                </select>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Lokasi Penempatan</label>
                <input type="text" name="location" placeholder="Gudang Penyimpanan A" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#8DC63F]/30 focus:border-brandGreen bg-white outline-none transition duration-300">
            </div>
            
            <button type="submit" class="w-full bg-brandGreen text-white py-3 rounded-xl font-bold hover:bg-brandGreenHover hover:shadow-lg hover:shadow-brandGreen/25 transition duration-300 flex items-center justify-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                Simpan Perangkat
            </button>
        </form>
    </div>
</div>

@if(session('success'))
<script>alert('{{ session('success') }}')</script>
@endif
@endsection
