@extends('layouts.app')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 py-8 font-poppins bg-gradient-to-b from-white to-[#BCCCDC]/10">
    
    <!-- CARD CONTAINER -->
    <div class="bg-white border border-gray-100 p-8 rounded-2xl shadow-xl w-full max-w-md space-y-6">
        
        <!-- HEADER FORM -->
        <div class="text-center space-y-2">
            <h2 class="text-2xl font-bold text-[#3A424A]">Gabung Sebagai Pendonor</h2>
            <p class="text-xs text-[#9AA6B2]">Daftarkan akun Anda untuk mulai menyelamatkan sesama</p>
        </div>

        <!-- TAMPILAN ERROR VALIDASI -->
        @if ($errors->any())
            <div class="p-3 bg-red-50 border border-red-100 rounded-xl text-xs text-red-600 space-y-1">
                @foreach ($errors->all() as $error)
                    <p class="flex items-center space-x-1">
                        <span>•</span>
                        <span>{{ $error }}</span>
                    </p>
                @endforeach
            </div>
        @endif

        <!-- FORM REGISTRASI -->
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <!-- INPUT NAMA LENGKAP -->
            <div>
                <label class="block text-xs font-semibold text-[#9AA6B2] uppercase mb-1 tracking-wider">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#9AA6B2] text-[#3A424A]" 
                       placeholder="Nama lengkap Anda" required autofocus>
            </div>

            <!-- INPUT EMAIL -->
            <div>
                <label class="block text-xs font-semibold text-[#9AA6B2] uppercase mb-1 tracking-wider">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#9AA6B2] text-[#3A424A]" 
                       placeholder="nama@email.com" required>
            </div>

            <!-- BARIS: GOLONGAN DARAH & RHESUS -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#9AA6B2] uppercase mb-1 tracking-wider">Golongan Darah</label>
                    <select name="blood_type" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#9AA6B2] text-[#3A424A]" required>
                        <option value="A" {{ old('blood_type') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('blood_type') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('blood_type') == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('blood_type') == 'O' ? 'selected' : '' }}>O</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#9AA6B2] uppercase mb-1 tracking-wider">Rhesus</label>
                    <select name="rhesus" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#9AA6B2] text-[#3A424A]" required>
                        <option value="+" {{ old('rhesus') == '+' ? 'selected' : '' }}>+</option>
                        <option value="-" {{ old('rhesus') == '-' ? 'selected' : '' }}>-</option>
                    </select>
                </div>
            </div>

            <!-- INPUT NOMOR TELEPON -->
            <div>
                <label class="block text-xs font-semibold text-[#9AA6B2] uppercase mb-1 tracking-wider">Nomor Telepon / WA</label>
                <input type="text" name="phone_number" value="{{ old('phone_number') }}" 
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#9AA6B2] text-[#3A424A]" 
                       placeholder="Contoh: 08123456789" required>
            </div>

            <!-- INPUT KATA SANDI -->
            <div>
                <label class="block text-xs font-semibold text-[#9AA6B2] uppercase mb-1 tracking-wider">Kata Sandi</label>
                <input type="password" name="password" 
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#9AA6B2] text-[#3A424A]" 
                       placeholder="Minimal 8 karakter" required>
            </div>

            <!-- KONFIRMASI KATA SANDI -->
            <div>
                <label class="block text-xs font-semibold text-[#9AA6B2] uppercase mb-1 tracking-wider">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" 
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#9AA6B2] text-[#3A424A]" 
                       placeholder="Ulangi kata sandi" required>
            </div>

            <!-- TOMBOL DAFTAR -->
            <button type="submit" class="w-full bg-[#3A424A] text-white py-3 rounded-xl font-semibold text-sm hover:bg-[#9AA6B2] transition shadow-md pt-2">
                Buat Akun Pendonor
            </button>
        </form>

        <!-- FOOTER CARD -->
        <div class="border-t border-gray-100 pt-4 text-center">
            <p class="text-xs text-[#9AA6B2]">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="text-[#3A424A] font-semibold hover:underline">Masuk di sini</a>
            </p>
        </div>

    </div>
</div>
@endsection