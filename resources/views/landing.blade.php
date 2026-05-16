@extends('layouts.app')

@section('content')
<!-- HERO SECTION -->
<section class="bg-gradient-to-b from-[#BCCCDC]/20 to-white py-16 px-4">
    <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center">
        <!-- Teks Hero -->
        <div class="space-y-6">
            <span class="inline-block px-3 py-1 bg-[#BCCCDC] text-[#3A424A] text-xs font-semibold rounded-full tracking-wider uppercase">
                Proyek Mini Donor Darah
            </span>
            <h1 class="text-4xl md:text-5xl font-bold text-[#3A424A] leading-tight">
                Setetes Darah Anda,<br>
                <span class="text-[#9AA6B2]">Harapan</span> Bagi Mereka.
            </h1>
            <p class="text-[#9AA6B2] text-sm md:text-base leading-relaxed max-w-md">
                Bantu sesama dengan lebih mudah. Cek ketersediaan stok darah secara real-time atau daftarkan diri Anda sebagai pendonor sukarela sekarang juga.
            </p>
            <div class="flex flex-wrap gap-4 pt-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-[#3A424A] text-white px-6 py-3 rounded-xl font-medium text-sm hover:bg-[#9AA6B2] transition shadow-md">
                        Buka Dashboard Anda
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-[#3A424A] text-white px-6 py-3 rounded-xl font-medium text-sm hover:bg-[#9AA6B2] transition shadow-md">
                        Mulai Donor Sekarang
                    </a>
                    <a href="#cek-stok" class="border border-[#9AA6B2] text-[#3A424A] px-6 py-3 rounded-xl font-medium text-sm hover:bg-gray-50 transition">
                        Cari Stok Darah
                    </a>
                @endauth
            </div>
        </div>

        <!-- Fitur Pencarian Cepat (Quick Search Form) -->
        <div id="cek-stok" class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
            <h3 class="text-lg font-bold text-[#3A424A] mb-4">Cari Ketersediaan Stok</h3>
            
            <form action="{{ route('stock.search') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-[#9AA6B2] uppercase mb-1">Golongan Darah</label>
                    <select name="blood_type" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#9AA6B2]" required>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#9AA6B2] uppercase mb-1">Rhesus</label>
                    <select name="rhesus" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#9AA6B2]" required>
                        <option value="+">+</option>
                        <option value="-">-</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-[#BCCCDC] text-[#3A424A] py-3 rounded-xl font-semibold text-sm hover:bg-[#9AA6B2] hover:text-white transition shadow-sm">
                    Periksa Ketersediaan
                </button>
            </form>

            <!-- Menampilkan Hasil Pencarian (Jika Dicari) -->
            @if(isset($searchResult))
                <div class="mt-4 p-4 rounded-xl border border-[#9AA6B2] bg-[#BCCCDC]/10 text-center animate-fade-in">
                    <p class="text-xs text-[#9AA6B2]">Hasil Pencarian:</p>
                    <h4 class="text-xl font-bold text-[#3A424A] mt-1">
                        Golongan {{ $searchResult->blood_type }}{{ $searchResult->rhesus }}
                    </h4>
                    <p class="text-sm font-semibold text-[#3A424A] mt-1">
                        Tersedia: <span class="px-2 py-0.5 rounded bg-white font-bold">{{ $searchResult->bags_quantity }} Kantong</span>
                    </p>
                    <p class="text-xs text-[#9AA6B2] mt-2">Lokasi: {{ $searchResult->location }}</p>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- EMERGENCY ALERT SECTION (Dinamis jika ada stok Kritis) -->
@if(isset($urgentStocks) && $urgentStocks->count() > 0)
<section class="bg-red-50 py-4 px-4 border-y border-red-100">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center space-x-3">
            <span class="flex h-3 w-3 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
            </span>
            <p class="text-sm text-red-800 font-medium">
                <strong>Kebutuhan Mendesak:</strong> Stok Golongan Darah 
                @foreach($urgentStocks as $urgent)
                    <span class="bg-white px-2 py-0.5 rounded text-red-600 font-bold border border-red-200">{{ $urgent->blood_type }}{{ $urgent->rhesus }}</span>
                @endforeach 
                sedang menipis di {{ $urgentStocks->first()->location }}.
            </p>
        </div>
        <a href="{{ route('login') }}" class="text-xs bg-red-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-red-700 transition shadow-sm">
            Bantu Donor
        </a>
    </div>
</section>
@endif

<!-- STOCK OVERVIEW SECTION -->
<section class="py-16 px-4 max-w-7xl mx-auto">
    <div class="text-center space-y-2 mb-12">
        <h2 class="text-2xl font-bold text-[#3A424A]">Informasi Stok Darah Terkini</h2>
        <p class="text-xs md:text-sm text-[#9AA6B2]">Pembaruan data jumlah kantong darah secara berkala</p>
    </div>

    <!-- Grid Stok Darah -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
        @forelse($bloodStocks as $stock)
            <div class="bg-white border border-gray-100 rounded-2xl p-6 text-center shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-[#BCCCDC]/40 text-[#3A424A] font-bold text-lg flex items-center justify-center mx-auto mb-4 shadow-inner">
                    {{ $stock->blood_type }}{{ $stock->rhesus }}
                </div>
                <div class="text-2xl font-bold text-[#3A424A]">{{ $stock->bags_quantity }}</div>
                <p class="text-xs text-[#9AA6B2] font-medium mt-1">Kantong Tersedia</p>
                
                <!-- Badge Status Indikator -->
                <span class="inline-block mt-3 px-2.5 py-0.5 rounded-full text-[10px] font-bold 
                    {{ $stock->status == 'Aman' ? 'bg-green-50 text-green-600' : ($stock->status == 'Menipis' ? 'bg-yellow-50 text-yellow-600' : 'bg-red-50 text-red-600') }}">
                    {{ $stock->status }}
                </span>
            </div>
        @empty
            <div class="col-span-4 bg-gray-50 text-center p-8 rounded-2xl text-xs text-[#9AA6B2]">
                Belum ada data stok darah saat ini. Silakan jalankan Database Seeder Anda.
            </div>
        @endforelse
    </div>
</section>

<!-- HOW IT WORKS SECTION -->
<section class="bg-gray-50 py-16 px-4 border-t border-gray-100">
    <div class="max-w-7xl mx-auto">
        <div class="text-center space-y-2 mb-12">
            <h2 class="text-2xl font-bold text-[#3A424A]">Langkah Mudah Menjadi Pendonor</h2>
            <p class="text-xs md:text-sm text-[#9AA6B2]">Proses ringkas untuk menyelamatkan nyawa sesama</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 text-center">
            <!-- Langkah 1 -->
            <div class="space-y-3 p-4">
                <div class="w-10 h-10 bg-[#BCCCDC] text-[#3A424A] font-bold rounded-xl flex items-center justify-center mx-auto text-sm shadow-sm">
                    1
                </div>
                <h4 class="font-bold text-sm text-[#3A424A]">Buat Akun Anda</h4>
                <p class="text-xs text-[#9AA6B2] leading-relaxed">
                    Daftarkan diri dengan email aktif dan masukkan informasi esensial seperti golongan darah Anda.
                </p>
            </div>
            <!-- Langkah 2 -->
            <div class="space-y-3 p-4">
                <div class="w-10 h-10 bg-[#BCCCDC] text-[#3A424A] font-bold rounded-xl flex items-center justify-center mx-auto text-sm shadow-sm">
                    2
                </div>
                <h4 class="font-bold text-sm text-[#3A424A]">Pilih Jadwal & Lokasi</h4>
                <p class="text-xs text-[#9AA6B2] leading-relaxed">
                    Tentukan tanggal kedatangan Anda melalui dashboard yang nyaman tanpa perlu antre lama di lokasi.
                </p>
            </div>
            <!-- Langkah 3 -->
            <div class="space-y-3 p-4">
                <div class="w-10 h-10 bg-[#BCCCDC] text-[#3A424A] font-bold rounded-xl flex items-center justify-center mx-auto text-sm shadow-sm">
                    3
                </div>
                <h4 class="font-bold text-sm text-[#3A424A]">Bantu Sesama</h4>
                <p class="text-xs text-[#9AA6B2] leading-relaxed">
                    Datang ke lokasi penyerahan donor darah membawa bukti pendaftaran digital dari aplikasi Anda.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection