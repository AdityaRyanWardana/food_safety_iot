@extends('layouts.admin')
@section('title', 'Kategori Pangan - FoodDetect Admin')
@section('breadcrumb', 'Kategori Pangan')

@section('content')
<!-- Header Section -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h2 class="text-2xl font-bold font-outfit text-gray-900 tracking-tight">Kategori Pangan</h2>
        <p class="text-gray-500 text-sm mt-1">Klasifikasi jenis bahan makanan dan konfigurasi parameter pemantauan sensor.</p>
    </div>
    
    <button onclick="document.getElementById('addCatModal').classList.remove('hidden')" class="group inline-flex items-center justify-center px-5 py-3 text-sm font-extrabold text-white rounded-2xl bg-brandGreen hover:bg-brandGreenHover hover:shadow-lg hover:shadow-brandGreen/25 transition duration-300 gap-2">
        <i class="fa-solid fa-plus"></i>
        Tambah Kategori Baru
    </button>
</div>

<!-- Categories Grid (Light Mode) -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($categories as $cat)
    <div class="relative overflow-hidden bg-white rounded-2xl p-6 shadow-sm border border-gray-150/70 transition hover:shadow-md group flex flex-col justify-between h-56">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-green-50/30 rounded-full group-hover:scale-110 transition duration-300"></div>
        
        <div>
            <div class="flex items-start justify-between mb-4 relative">
                <!-- Icon Frame (brandGreen text & border) -->
                <div class="w-12 h-12 rounded-xl bg-green-50 text-brandGreen flex items-center justify-center text-xl shadow-sm border border-green-100/50 group-hover:scale-105 transition duration-300">
                    <i class="{{ $cat->icon }}"></i>
                </div>
                
                <!-- Action Delete -->
                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')" class="relative z-10">
                    @csrf @method('DELETE')
                    <button class="p-2 rounded-lg text-gray-300 hover:text-red-500 hover:bg-red-50 transition opacity-0 group-hover:opacity-100 duration-300" title="Hapus Kategori">
                        <i class="fa-solid fa-trash-can text-sm"></i>
                    </button>
                </form>
            </div>
            
            <h3 class="text-lg font-bold text-gray-900 group-hover:text-brandGreen transition duration-300">{{ $cat->name }}</h3>
            <p class="text-gray-450 text-xs mt-1.5 line-clamp-2 pr-6 leading-relaxed">{{ $cat->description ?? 'Deskripsi kategori belum ditambahkan.' }}</p>
        </div>
        
        <!-- Metrics Indicator -->
        <div class="flex gap-4 text-[10px] font-bold text-gray-400 border-t border-gray-105 pt-4 mt-4 relative">
            <span class="flex items-center gap-1.5 bg-gray-50 px-2.5 py-1 rounded border border-gray-100">
                <i class="fa-solid fa-database text-blue-400"></i>
                {{ $cat->sensor_readings_count }} LOGS
            </span>
            <span class="flex items-center gap-1.5 bg-gray-50 px-2.5 py-1 rounded border border-gray-100">
                <i class="fa-solid fa-triangle-exclamation text-brandGreen"></i>
                {{ $cat->contamination_logs_count }} ANOMALI
            </span>
        </div>
    </div>
    @empty
    <div class="col-span-full bg-white rounded-2xl shadow-sm border border-gray-150 p-16 text-center text-gray-400">
        <div class="max-w-sm mx-auto">
            <div class="w-16 h-16 mx-auto bg-gray-50 rounded-full flex items-center justify-center text-gray-450 mb-4 border border-gray-100">
                <i class="fa-solid fa-boxes-stacked text-2xl"></i>
            </div>
            <p class="font-bold text-gray-800">Belum ada Kategori</p>
            <p class="text-xs text-gray-400 mt-1">Daftarkan kategori komoditi makanan terlebih dahulu untuk memandu pemetaan anomali sensor.</p>
        </div>
    </div>
    @endforelse
</div>

@if($categories->hasPages())
<div class="mt-6 flex justify-end">
    {{ $categories->links() }}
</div>
@endif

<!-- Add Category Modal -->
<div id="addCatModal" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm transition duration-300">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md border border-gray-100 transform transition-all duration-300">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
            <h3 class="text-lg font-bold font-outfit text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-circle-plus text-brandGreen"></i>
                Tambah Kategori Pangan
            </h3>
            <button onclick="document.getElementById('addCatModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-lg hover:bg-gray-100 transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        
        <form action="{{ route('admin.categories.store') }}" method="POST" class="p-6 space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nama Kategori</label>
                <input type="text" name="name" required placeholder="Daging & Olahan" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#8DC63F]/30 focus:border-brandGreen bg-white outline-none transition duration-300">
            </div>
            
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Deskripsi Singkat</label>
                <textarea name="description" rows="3" placeholder="Deskripsi singkat jenis pangan..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#8DC63F]/30 focus:border-brandGreen bg-white outline-none resize-none transition duration-300"></textarea>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Icon (FontAwesome Class)</label>
                <input type="text" name="icon" value="fa-solid fa-drumstick-bite" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#8DC63F]/30 focus:border-brandGreen bg-white outline-none transition duration-300">
            </div>
            
            <button type="submit" class="w-full bg-brandGreen text-white py-3 rounded-xl font-bold hover:bg-brandGreenHover hover:shadow-lg hover:shadow-brandGreen/25 transition duration-300 flex items-center justify-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                Simpan Kategori
            </button>
        </form>
    </div>
</div>

@endsection
