@extends('layouts.admin')

@section('title', 'Log Kontaminasi - FoodDetect Admin')
@section('breadcrumb', 'Log Kontaminasi')

@section('content')
<!-- Header Section -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h2 class="text-2xl font-bold font-outfit text-gray-900 tracking-tight">Log Kontaminasi</h2>
        <p class="text-gray-500 text-sm mt-1">Riwayat deteksi anomali, investigasi pembusukan, dan kontaminasi pangan.</p>
    </div>
    
    @if($logs->count() > 0)
    <form action="{{ route('admin.contamination.clear') }}" method="POST" class="inline-flex items-center gap-2">
        @csrf @method('DELETE')
        <button type="button" onclick="confirmBulkDelete(this)" class="bg-red-50 text-red-600 hover:text-white hover:bg-red-600 border border-red-200/50 px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-sm shadow-red-100">
            <i class="fa-solid fa-trash-can pointer-events-none"></i>
            <span class="bulk-text pointer-events-none">Hapus Semua Log</span>
        </button>
        <button type="button" onclick="cancelBulkDelete(this)" class="hidden bulk-cancel bg-gray-100 text-gray-600 border border-gray-200 px-3 py-2.5 rounded-xl text-xs font-bold transition hover:bg-gray-200">Batal</button>
    </form>
    @endif
</div>

<!-- Stats Dashboard Grid (Gaya Sego - brandGreen) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Kritis Aktif -->
    <div class="relative overflow-hidden bg-white rounded-2xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md group">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-red-50 rounded-full group-hover:scale-110 transition duration-300"></div>
        <div class="flex items-center gap-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-500 flex items-center justify-center text-xl shadow-sm border border-red-100/50">
                <i class="fa-solid fa-skull-crossbones animate-pulse"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kritis Aktif</p>
                <h3 class="text-2xl font-black text-gray-900 mt-0.5 font-outfit">{{ $totalCritical }} <span class="text-xs font-bold text-gray-400">Kasus</span></h3>
            </div>
        </div>
    </div>

    <!-- Terdeteksi (brandGreen) -->
    <div class="relative overflow-hidden bg-white rounded-2xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md group">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-green-50 rounded-full group-hover:scale-110 transition duration-300"></div>
        <div class="flex items-center gap-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-green-50 text-brandGreen flex items-center justify-center text-xl shadow-sm border border-green-100/50">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Terdeteksi</p>
                <h3 class="text-2xl font-black text-gray-900 mt-0.5 font-outfit">{{ $totalDetected }} <span class="text-xs font-bold text-gray-400">Kasus</span></h3>
            </div>
        </div>
    </div>

    <!-- Investigasi -->
    <div class="relative overflow-hidden bg-white rounded-2xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md group">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-110 transition duration-300"></div>
        <div class="flex items-center gap-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-550 flex items-center justify-center text-xl shadow-sm border border-blue-100/50">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Investigasi</p>
                <h3 class="text-2xl font-black text-gray-900 mt-0.5 font-outfit">{{ $totalInvestigating }} <span class="text-xs font-bold text-gray-400">Kasus</span></h3>
            </div>
        </div>
    </div>

    <!-- Teratasi -->
    <div class="relative overflow-hidden bg-white rounded-2xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md group">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-green-50 rounded-full group-hover:scale-110 transition duration-300"></div>
        <div class="flex items-center gap-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-green-50 text-emerald-500 flex items-center justify-center text-xl shadow-sm border border-green-100/50">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Teratasi</p>
                <h3 class="text-2xl font-black text-gray-900 mt-0.5 font-outfit">{{ $totalResolved }} <span class="text-xs font-bold text-gray-400">Kasus</span></h3>
            </div>
        </div>
    </div>
</div>

<!-- Logs Card Table -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
        <div>
            <h3 class="font-bold font-outfit text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-history text-brandGreen"></i>
                Riwayat Log Kontaminasi
            </h3>
            <p class="text-xs text-gray-400 mt-0.5">Daftar anomali sensor yang terekam sistem deteksi otomatis.</p>
        </div>
        <span class="text-xs font-bold text-brandGreen bg-brandGreen/10 px-3 py-1.5 rounded-xl border border-brandGreen/20">
            Total: {{ $logs->total() }} Log
        </span>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-gray-50/20 border-b border-gray-100 text-xs text-gray-400 uppercase tracking-wider">
                    <th class="px-6 py-4 font-bold">Waktu Deteksi</th>
                    <th class="px-6 py-4 font-bold">Tipe Kontaminasi</th>
                    <th class="px-6 py-4 font-bold">Kategori Pangan</th>
                    <th class="px-6 py-4 font-bold text-center">Tingkat Bahaya</th>
                    <th class="px-6 py-4 font-bold text-center">Status Tindakan</th>
                    <th class="px-6 py-4 font-bold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50/30 transition group">
                    <!-- Detected Time -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2.5">
                            <div class="p-2 rounded-lg bg-gray-50 text-gray-400 group-hover:text-brandGreen transition">
                                <i class="fa-regular fa-clock text-xs"></i>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800">{{ $log->detected_at?->format('d M Y') ?? '-' }}</div>
                                <div class="text-[10px] text-gray-400 mt-0.5 font-bold">{{ $log->detected_at?->format('H:i:s') }}</div>
                            </div>
                        </div>
                    </td>
                    
                    <!-- Contamination Type -->
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900">
                            {{ $log->type }}
                        </div>
                        <div class="text-xs text-gray-450 mt-0.5 max-w-xs truncate" title="{{ $log->description }}">
                            {{ $log->description }}
                        </div>
                    </td>
                    
                    <!-- Food Category -->
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-gray-50 text-gray-600 text-xs font-semibold border border-gray-100">
                            <i class="{{ $log->foodCategory->icon ?? 'fa-solid fa-box' }} mr-1.5 text-gray-450"></i>
                            {{ $log->foodCategory->name ?? 'Tanpa Kategori' }}
                        </span>
                    </td>
                    
                    <!-- Severity Badge -->
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold border
                            @if($log->severity==='kritis') bg-red-50 text-red-600 border-red-200/50
                            @elseif($log->severity==='tinggi') bg-orange-50 text-orange-600 border-orange-200/50
                            @elseif($log->severity==='sedang') bg-yellow-50 text-yellow-600 border-yellow-200/50
                            @else bg-blue-50 text-blue-600 border-blue-200/50
                            @endif">
                            {{ ucfirst($log->severity) }}
                        </span>
                    </td>
                    
                    <!-- Status Badge -->
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border shadow-sm
                            @if($log->status==='terdeteksi') bg-red-50 text-red-600 border-red-200/60
                            @elseif($log->status==='investigasi') bg-blue-50 text-blue-600 border-blue-200/60
                            @else bg-green-50 text-emerald-700 border-green-200/60
                            @endif">
                            <span class="w-1.5 h-1.5 rounded-full mr-1.5 animate-pulse
                                @if($log->status==='terdeteksi') bg-red-500
                                @elseif($log->status==='investigasi') bg-blue-500
                                @else bg-emerald-500
                                @endif"></span>
                            {{ ucfirst($log->status) }}
                        </span>
                    </td>
                    
                    <!-- Action -->
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            @if($log->status !== 'teratasi')
                            <form action="{{ route('admin.contamination.updateStatus', $log) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="teratasi">
                                <button class="text-emerald-600 hover:text-white hover:bg-emerald-500 border border-emerald-200/50 px-3 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1 shadow-sm shadow-emerald-50">
                                    <i class="fa-solid fa-check text-[10px]"></i> Selesai
                                </button>
                            </form>
                            @else
                            <span class="text-[10px] font-bold text-gray-400 bg-gray-50 px-2.5 py-1.5 rounded-xl border border-gray-100" title="Kasus Selesai">
                                {{ $log->resolved_at ? $log->resolved_at->diffForHumans() : 'Selesai' }}
                            </span>
                            @endif
                            
                            <form action="{{ route('admin.contamination.destroy', $log) }}" method="POST" class="inline flex items-center gap-1.5 justify-end">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)" class="p-2 rounded-lg text-gray-455 hover:text-red-550 hover:bg-red-50 transition flex items-center gap-1" title="Hapus Log">
                                    <i class="fa-solid fa-trash-can text-sm pointer-events-none"></i>
                                    <span class="text-xs font-bold hidden delete-text pointer-events-none">Yakin?</span>
                                </button>
                                <button type="button" onclick="cancelDelete(this)" class="hidden cancel-btn text-xs text-gray-400 hover:text-gray-600 transition font-semibold px-2 py-1">Batal</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center text-gray-450">
                        <div class="max-w-sm mx-auto">
                            <div class="w-16 h-16 mx-auto bg-gray-50 rounded-full flex items-center justify-center text-gray-400 mb-4 border border-gray-100">
                                <i class="fa-solid fa-shield-halved text-2xl"></i>
                            </div>
                            <p class="font-bold text-gray-800">Sistem Steril & Aman</p>
                            <p class="text-xs text-gray-400 mt-1">Belum ada riwayat kontaminasi atau anomali pangan berbahaya yang terekam pada sistem IoT.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($logs->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/20">
        {{ $logs->links() }}
    </div>
    @endif
</div>

<script>
function confirmDelete(button) {
    if (button.classList.contains('confirm-state')) {
        button.closest('form').submit();
        return;
    }
    
    document.querySelectorAll('.confirm-state').forEach(btn => {
        if (btn.classList.contains('bg-red-50') || btn.querySelector('.bulk-text')) {
            resetBulkDelete(btn);
        } else {
            resetDeleteButton(btn);
        }
    });

    button.classList.add('confirm-state');
    button.classList.remove('text-gray-455', 'hover:text-red-550', 'hover:bg-red-50');
    button.classList.add('text-white', 'bg-red-500', 'hover:bg-red-600', 'px-2.5', 'py-1', 'rounded-lg', 'shadow-sm');
    
    const icon = button.querySelector('i');
    icon.classList.remove('fa-trash-can');
    icon.classList.add('fa-triangle-exclamation', 'mr-1');
    
    const text = button.querySelector('.delete-text');
    if (text) text.classList.remove('hidden');

    const cancelBtn = button.closest('form').querySelector('.cancel-btn');
    if (cancelBtn) cancelBtn.classList.remove('hidden');

    button.timeoutId = setTimeout(() => {
        resetDeleteButton(button);
    }, 4000);
}

function cancelDelete(cancelBtn) {
    const button = cancelBtn.closest('form').querySelector('button');
    resetDeleteButton(button);
}

function resetDeleteButton(button) {
    if (button.timeoutId) {
        clearTimeout(button.timeoutId);
    }
    button.classList.remove('confirm-state', 'text-white', 'bg-red-500', 'hover:bg-red-600', 'px-2.5', 'py-1', 'rounded-lg', 'shadow-sm');
    button.classList.add('text-gray-450', 'hover:text-red-550', 'hover:bg-red-50');
    
    const icon = button.querySelector('i');
    icon.classList.remove('fa-triangle-exclamation', 'mr-1');
    icon.classList.add('fa-trash-can');
    
    const text = button.querySelector('.delete-text');
    if (text) text.classList.add('hidden');

    const cancelBtn = button.closest('form').querySelector('.cancel-btn');
    if (cancelBtn) cancelBtn.classList.add('hidden');
}

function confirmBulkDelete(button) {
    if (button.classList.contains('confirm-state')) {
        button.closest('form').submit();
        return;
    }
    
    document.querySelectorAll('.confirm-state').forEach(btn => {
        if (btn.classList.contains('bg-red-50') || btn.querySelector('.bulk-text')) {
            resetBulkDelete(btn);
        } else {
            resetDeleteButton(btn);
        }
    });

    button.classList.add('confirm-state');
    button.classList.remove('bg-red-50', 'text-red-600', 'border-red-200/50', 'hover:bg-red-600');
    button.classList.add('bg-red-600', 'text-white', 'border-red-600', 'hover:bg-red-700');
    
    const icon = button.querySelector('i');
    icon.classList.remove('fa-trash-can');
    icon.classList.add('fa-triangle-exclamation');
    
    const text = button.querySelector('.bulk-text');
    text.textContent = 'Yakin Hapus Semua?';

    const cancelBtn = button.closest('form').querySelector('.bulk-cancel');
    if (cancelBtn) cancelBtn.classList.remove('hidden');

    button.timeoutId = setTimeout(() => {
        resetBulkDelete(button);
    }, 5000);
}

function cancelBulkDelete(cancelBtn) {
    const button = cancelBtn.closest('form').querySelector('button');
    resetBulkDelete(button);
}

function resetBulkDelete(button) {
    if (button.timeoutId) {
        clearTimeout(button.timeoutId);
    }
    button.classList.remove('confirm-state', 'bg-red-600', 'text-white', 'border-red-600', 'hover:bg-red-700');
    button.classList.add('bg-red-50', 'text-red-600', 'border-red-200/50', 'hover:bg-red-600');
    
    const icon = button.querySelector('i');
    icon.classList.remove('fa-triangle-exclamation');
    icon.classList.add('fa-trash-can');
    
    const text = button.querySelector('.bulk-text');
    text.textContent = 'Hapus Semua Log';

    const cancelBtn = button.closest('form').querySelector('.bulk-cancel');
    if (cancelBtn) cancelBtn.classList.add('hidden');
}
</script>

@if(session('success'))
<script>alert('{{ session('success') }}')</script>
@endif
@endsection
