@extends('layouts.admin')

@section('title', 'Edit Profil - FoodDetect Admin')
@section('breadcrumb', 'Pengaturan / Profil')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-brandDark">Pengaturan Profil</h2>
        <p class="text-gray-500 text-sm mt-1">Kelola informasi akun dan keamanan Anda.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-brandGreen px-4 py-3 rounded-lg mb-6 flex items-center">
            <i class="fa-solid fa-circle-check mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8">
            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Basic Info -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-brandDark border-b pb-2">Informasi Dasar</h3>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-brandGreen outline-none transition" required>
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-brandGreen outline-none transition" required>
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Security -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-brandDark border-b pb-2">Keamanan</h3>
                        
                        <p class="text-xs text-gray-400 italic">Kosongkan jika tidak ingin mengubah password.</p>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Password Baru</label>
                            <input type="password" name="password" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-brandGreen outline-none transition" placeholder="••••••••">
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-brandGreen outline-none transition" placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="mt-10 pt-6 border-t flex justify-end">
                    <button type="submit" class="bg-brandGreen text-white font-bold py-3 px-8 rounded-lg hover:bg-green-600 shadow-md shadow-brandGreen/20 transition duration-300 flex items-center">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
