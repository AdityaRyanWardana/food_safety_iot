@extends('layouts.admin')

@section('title', 'Edit Profil - FoodDetect Admin')
@section('breadcrumb', 'Pengaturan / Profil')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold font-outfit text-gray-900 tracking-tight">Pengaturan Profil</h2>
        <p class="text-gray-500 text-sm mt-1">Kelola informasi dasar akun, hak akses administrator, dan pembaharuan kata sandi.</p>
    </div>



    <div class="bg-white rounded-2xl shadow-sm border border-gray-150/70 overflow-hidden transition duration-300">
        <div class="p-8">
            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Basic Info -->
                    <div class="space-y-6">
                        <h3 class="text-base font-bold text-gray-800 border-b border-gray-100 pb-2.5 flex items-center gap-2">
                            <i class="fa-solid fa-circle-info text-blue-500"></i>
                            Informasi Dasar
                        </h3>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-3 border border-gray-205 rounded-xl bg-white outline-none focus:ring-2 focus:ring-[#8DC63F]/30 focus:border-brandGreen transition duration-300" required>
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3 border border-gray-205 rounded-xl bg-white outline-none focus:ring-2 focus:ring-[#8DC63F]/30 focus:border-brandGreen transition duration-300" required>
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Security -->
                    <div class="space-y-6">
                        <h3 class="text-base font-bold text-gray-800 border-b border-gray-100 pb-2.5 flex items-center gap-2">
                            <i class="fa-solid fa-shield-halved text-purple-500"></i>
                            Keamanan Akun
                        </h3>
                        
                        <p class="text-[10px] font-medium text-gray-400 italic">Biarkan kosong jika Anda tidak berencana mengganti kata sandi lama.</p>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Kata Sandi Baru</label>
                            <input type="password" name="password" class="w-full px-4 py-3 border border-gray-205 rounded-xl bg-white outline-none focus:ring-2 focus:ring-[#8DC63F]/30 focus:border-brandGreen transition duration-300" placeholder="••••••••">
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" class="w-full px-4 py-3 border border-gray-205 rounded-xl bg-white outline-none focus:ring-2 focus:ring-[#8DC63F]/30 focus:border-brandGreen transition duration-300" placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="group inline-flex items-center justify-center px-6 py-3 text-sm font-extrabold text-white rounded-2xl bg-brandGreen hover:bg-brandGreenHover hover:shadow-lg hover:shadow-brandGreen/25 transition duration-300 gap-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
