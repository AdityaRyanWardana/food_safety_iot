@extends('layouts.admin')

@section('title', 'Dashboard - FoodDetect Admin')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="flex justify-between items-end mb-6">
    <div>
        <h2 class="text-2xl font-bold text-brandDark">Real-time Monitoring System</h2>
        <p class="text-gray-500 text-sm mt-1">Status pemantauan keamanan pangan dari seluruh sensor IoT aktif.</p>
    </div>
    <button class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg shadow-sm text-sm font-medium hover:bg-gray-50 transition flex items-center">
        <i class="fa-solid fa-download mr-2"></i> Unduh Laporan PDF
    </button>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center">
        <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center text-xl mr-4">
            <i class="fa-solid fa-microchip"></i>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase">Sensor Aktif</p>
            <h3 class="text-2xl font-bold text-brandDark">24</h3>
        </div>
    </div>
    
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center relative overflow-hidden">
        <div class="absolute right-0 top-0 bottom-0 w-1 bg-red-500"></div>
        <div class="w-12 h-12 rounded-lg bg-red-50 text-red-500 flex items-center justify-center text-xl mr-4">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase">Peringatan Hari Ini</p>
            <h3 class="text-2xl font-bold text-brandDark">3</h3>
        </div>
    </div>

    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center">
        <div class="w-12 h-12 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center text-xl mr-4">
            <i class="fa-solid fa-temperature-half"></i>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase">Rata-rata Suhu</p>
            <h3 class="text-2xl font-bold text-brandDark">4.2 °C</h3>
        </div>
    </div>

    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center">
        <div class="w-12 h-12 rounded-lg bg-brandGreen/10 text-brandGreen flex items-center justify-center text-xl mr-4">
            <i class="fa-solid fa-droplet"></i>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase">Rata-rata Kelembapan</p>
            <h3 class="text-2xl font-bold text-brandDark">68 %</h3>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <h3 class="font-bold text-brandDark">Log Pemantauan Real-time</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-white border-b border-gray-100 text-xs text-gray-400 uppercase">
                    <th class="px-6 py-4 font-semibold">ID Perangkat</th>
                    <th class="px-6 py-4 font-semibold">Kategori Makanan</th>
                    <th class="px-6 py-4 font-semibold text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <tr>
                    <td class="px-6 py-4 font-semibold text-brandDark">SENS-DG-01</td>
                    <td class="px-6 py-4 text-gray-600">Daging Sapi Mentah</td>
                    <td class="px-6 py-4 text-right">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-brandGreen">Aman</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
