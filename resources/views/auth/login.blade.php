@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 font-poppins bg-gradient-to-b from-white to-[#BCCCDC]/10">
    
    <!-- CARD CONTAINER -->
    <div class="bg-white border border-gray-100 p-8 rounded-2xl shadow-xl w-full max-w-md space-y-6">
        
        <!-- HEADER FORM -->
        <div class="text-center space-y-2">
            <h2 class="text-2xl font-bold text-[#3A424A]">Selamat Datang Kembali</h2>
            <p class="text-xs text-[#9AA6B2]">Silakan masuk untuk mengatur jadwal donor Anda</p>
        </div>

        <!-- TAMPILAN ERROR VALIDASI (Jika Login Gagal) -->
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

        <!-- FORM LOGIN -->
        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <!-- INPUT EMAIL -->
            <div>
                <label class="block text-xs font-semibold text-[#9AA6B2] uppercase mb-1 tracking-wider">Alamat Email</label>
                <div class="relative">
                    <input type="email" name="email" value="{{ old('email') }}" 
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#9AA6B2] text-[#3A424A]" 
                           placeholder="nama@email.com" required autofocus>
                </div>
            </div>

            <!-- INPUT PASSWORD -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label class="block text-xs font-semibold text-[#9AA6B2] uppercase tracking-wider">Kata Sandi</label>
                </div>
                <input type="password" name="password" 
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#9AA6B2] text-[#3A424A]" 
                       placeholder="••••••••" required>
            </div>

            <!-- REMEMBER ME CHECKBOX -->
            <div class="flex items-center justify-between pt-1">
                <label class="flex items-center space-x-2 text-xs text-[#3A424A] cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-[#9AA6B2] focus:ring-[#9AA6B2]">
                    <span>Ingat saya di perangkat ini</span>
                </label>
            </div>

            <!-- TOMBOL MASUK -->
            <button type="submit" class="w-full bg-[#3A424A] text-white py-3 rounded-xl font-semibold text-sm hover:bg-[#9AA6B2] transition shadow-md">
                Masuk Ke Akun
            </button>
        </form>

        <!-- FOOTER CARD (OPSIONAL REGISTRASI SIMPEL) -->
        <div class="border-t border-gray-100 pt-4 text-center">
            <p class="text-xs text-[#9AA6B2]">
                Belum terdaftar sebagai pendonor? 
                <a href="#" class="text-[#3A424A] font-semibold hover:underline">Hubungi Admin</a>
            </p>
        </div>

    </div>
</div>
@endsection