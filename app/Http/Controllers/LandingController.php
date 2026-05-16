<?php

namespace App\Http\Controllers;

use App\Models\BloodStock;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Menampilkan halaman utama (Landing Page) aplikasi donor darah
     */
    public function index()
    {
        // 1. Ambil seluruh data stok darah untuk tabel informasi di halaman depan
        $bloodStocks = BloodStock::all();

        // 2. Ambil stok darah yang berstatus 'Kritis' atau 'Menipis' untuk komponen Alert/SOS
        $urgentStocks = BloodStock::urgent()->get();

        // 3. Passing data ke view 'landing.blade.php'
        return view('landing', compact('bloodStocks', 'urgentStocks'));
    }

    /**
     * Fitur pencarian cepat stok darah dari halaman depan
     */
    public function search(Request $request)
    {
        $request->validate([
            'blood_type' => 'required|in:A,B,AB,O',
            'rhesus' => 'required|in:+,-',
        ]);

        // Cari data stok darah yang spesifik sesuai inputan visitor
        $searchResult = BloodStock::where('blood_type', $request->blood_type)
            ->where('rhesus', $request->rhesus)
            ->first();

        // Ambil kembali data default agar komponen lain di landing page tidak kosong/error
        $bloodStocks = BloodStock::all();
        $urgentStocks = BloodStock::urgent()->get();

        // Kembalikan ke view landing dengan membawa hasil pencarian
        return view('landing', compact('bloodStocks', 'urgentStocks', 'searchResult'));
    }
}