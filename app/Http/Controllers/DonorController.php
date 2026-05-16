<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonorController extends Controller
{
    /**
     * Menampilkan halaman dashboard pendonor (setelah login)
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Cek status apakah user sudah boleh mendonor lagi atau masih masa tenggang
        $canDonate = $user->canDonateAgain();

        // Hitung perkiraan tanggal kapan user boleh donor lagi jika sekarang belum boleh
        $nextDonationDate = null;
        if (!$canDonate && $user->last_donation_date) {
            $nextDonationDate = $user->last_donation_date->addDays(60);
        }

        return view('dashboard', compact('user', 'canDonate', 'nextDonationDate'));
    }

    /**
     * Memproses form pendaftaran jadwal donor darah baru
     */
    public function registerDonor(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi kelayakan berdasarkan aturan jeda 60 hari dari Model User
        if (!$user->canDonateAgain()) {
            return redirect()->back()->withErrors([
                'donation_error' => 'Maaf, Anda belum memenuhi syarat jeda waktu 60 hari sejak donor terakhir Anda.'
            ]);
        }

        // 2. Validasi input data jadwal
        $request->validate([
            'donation_date' => ['required', 'date', 'after:today'], // Harus tanggal besok atau setelahnya
            'location' => ['required', 'string', 'max:255'],
        ]);

        // 3. Update data tanggal donor terakhir pada user
        // Catatan: Jika proyek Anda berkembang, bagian ini disarankan menggunakan tabel riwayat terpisah
        $user->update([
            'last_donation_date' => $request->donation_date
        ]);

        return redirect()->route('dashboard')->with('success', 'Pendaftaran jadwal donor berhasil! Silakan datang ke lokasi sesuai jadwal.');
    }
}