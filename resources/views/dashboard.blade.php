@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 font-poppins">
    
    <!-- HEADER DASHBOARD -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-100 pb-6 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-[#3A424A]">Selamat Datang, {{ $user->name }}!</h1>
            <p class="text-xs md:text-sm text-[#9AA6B2]">Pantau status kelayakan donor dan atur jadwal kedatangan Anda di sini.</p>
        </div>
        <!-- Badge Golongan Darah User -->
        <div class="flex items-center space-x-3 bg-white border border-gray-100 p-3 rounded-2xl shadow-sm self-start md:self-auto">
            <div class="w-10 h-10 rounded-xl bg-[#BCCCDC] text-[#3A424A] font-bold flex items-center justify-center shadow-inner">
                {{ $user->blood_type ?? '?' }}{{ $user->rhesus }}
            </div>
            <div>
                <p class="text-[10px] text-[#9AA6B2] font-semibold uppercase tracking-wider">Golongan Darah</p>
                <p class="text-xs font-bold text-[#3A424A]">Pendonor Aktif</p>
            </div>
        </div>
    </div>

    <!-- MAIN GRID CONTAINER -->
    <div class="grid lg:grid-cols-3 gap-8">
        
        <!-- KOLOM KIRI & TENGAH: STATUS & FORM PENDAFTARAN -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- KARTU STATUS KELAYAKAN DONOR -->
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                <h3 class="text-sm font-bold text-[#3A424A] mb-4 flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#9AA6B2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Status Kelayakan Anda Hari Ini</span>
                </h3>

                @if($canDonate)
                    <!-- KONDISI BOLEH DONOR -->
                    <div class="p-4 rounded-xl bg-green-50 border border-green-100 flex items-start space-x-3">
                        <div class="p-2 bg-green-500 rounded-lg text-white mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-green-800">Siap Mendonor</h4>
                            <p class="text-xs text-green-700 mt-0.5 leading-relaxed">
                                Jeda waktu sejak donor terakhir Anda sudah melebihi 60 hari. Tubuh Anda dalam masa optimal untuk kembali berbagi harapan.
                            </p>
                        </div>
                    </div>
                @else
                    <!-- KONDISI MASIH MASA TENGGANG -->
                    <div class="p-4 rounded-xl bg-amber-50 border border-amber-100 flex items-start space-x-3">
                        <div class="p-2 bg-amber-500 rounded-lg text-white mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-amber-800">Masa Pemulihan (Tenggang)</h4>
                            <p class="text-xs text-amber-700 mt-0.5 leading-relaxed">
                                Anda belum bisa mendonor saat ini demi menjaga kesehatan sel darah Anda. Anda diperkirakan dapat kembali mendonor setelah tanggal 
                                <strong class="underline">{{ $nextDonationDate ? $nextDonationDate->format('d M Y') : '-' }}</strong>.
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- FORM PENDAFTARAN JADWAL (Hanya Aktif Jika Boleh Donor) -->
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                <h3 class="text-sm font-bold text-[#3A424A] mb-4 flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#9AA6B2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Ajukan Pendaftaran Jadwal Donor</span>
                </h3>

                <!-- Alert Error Validasi Internal Controller -->
                @if($errors->has('donation_error'))
                    <div class="mb-4 p-3 bg-red-50 border border-red-100 text-xs text-red-600 rounded-xl">
                        {{ $errors->first('donation_error') }}
                    </div>
                @endif

                <form action="{{ route('donor.register') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-[#9AA6B2] uppercase mb-1">Pilih Tanggal Kedatangan</label>
                            <input type="date" name="donation_date" 
                                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#9AA6B2] disabled:opacity-50"
                                   {{ !$canDonate ? 'disabled' : '' }} required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#9AA6B2] uppercase mb-1">Lokasi Rumah Sakit/PMI</label>
                            <select name="location" 
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#9AA6B2] disabled:opacity-50"
                                    {{ !$canDonate ? 'disabled' : '' }} required>
                                <option value="PMI Unit Kota A">PMI Unit Kota A</option>
                                <option value="Rumah Sakit Pusat Daerah">Rumah Sakit Pusat Daerah</option>
                                <option value="Mobil Unit Keliling Mal">Mobil Unit Keliling Mal</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full bg-[#3A424A] text-white py-3 rounded-xl font-semibold text-sm hover:bg-[#9AA6B2] transition shadow-sm disabled:opacity-40 disabled:hover:bg-[#3A424A]"
                            {{ !$canDonate ? 'disabled' : '' }}>
                        {{ $canDonate ? 'Konfirmasi Ambil Jadwal' : 'Pendaftaran Terkunci (Masa Pemulihan)' }}
                    </button>
                </form>
            </div>
        </div>

        <!-- KOLOM KANAN: RINGKASAN PROFIL & RIWAYAT -->
        <div class="space-y-8">
            <!-- KARTU DATA MEDIS PENDONOR -->
            <div class="bg-gradient-to-br from-[#BCCCDC]/40 to-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                <h3 class="text-sm font-bold text-[#3A424A] mb-4">Informasi Profil Medis</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between border-b border-gray-100 pb-2 text-xs">
                        <span class="text-[#9AA6B2]">Nama Lengkap</span>
                        <span class="font-semibold text-[#3A424A]">{{ $user->name }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2 text-xs">
                        <span class="text-[#9AA6B2]">Kontak Email</span>
                        <span class="font-semibold text-[#3A424A]">{{ $user->email }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2 text-xs">
                        <span class="text-[#9AA6B2]">Nomor Telepon</span>
                        <span class="font-semibold text-[#3A424A]">{{ $user->phone_number ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between pt-1 text-xs">
                        <span class="text-[#9AA6B2]">Donor Terakhir</span>
                        <span class="font-bold text-[#3A424A]">
                            {{ $user->last_donation_date ? $user->last_donation_date->format('d M Y') : 'Belum Pernah' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- KARTU EDUKASI MINI -->
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-[#9AA6B2]">Tips Sebelum Donor</h4>
                <ul class="text-xs text-[#3A424A] space-y-2 list-disc list-inside leading-relaxed font-light">
                    <li>Tidur minimal 4-5 jam sebelum melakukan donor.</li>
                    <li>Minum banyak air putih & hindari makanan berlemak.</li>
                    <li>Pastikan kadar Hemoglobin (HB) Anda cukup saat dicek.</li>
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection