<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\BloodStock; // Pastikan model BloodStock Anda sudah ada

class BloodStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel terlebih dahulu agar tidak duplikat saat dijalankan ulang
        BloodStock::truncate();

        $stocks = [
            [
                'blood_type' => 'A',
                'rhesus' => '+',
                'bags_quantity' => 45,
                'status' => 'Aman',
                'location' => 'PMI Unit Kota A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blood_type' => 'B',
                'rhesus' => '+',
                'bags_quantity' => 12,
                'status' => 'Menipis',
                'location' => 'PMI Unit Kota A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blood_type' => 'AB',
                'rhesus' => '+',
                'bags_quantity' => 3,
                'status' => 'Kritis',
                'location' => 'Rumah Sakit Pusat Daerah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blood_type' => 'O',
                'rhesus' => '+',
                'bags_quantity' => 60,
                'status' => 'Aman',
                'location' => 'PMI Unit Kota A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blood_type' => 'A',
                'rhesus' => '-',
                'bags_quantity' => 5,
                'status' => 'Menipis',
                'location' => 'Rumah Sakit Pusat Daerah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blood_type' => 'O',
                'rhesus' => '-',
                'bags_quantity' => 2,
                'status' => 'Kritis',
                'location' => 'PMI Unit Kota A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Masukkan data ke database
        // Masukkan data ke database
        foreach ($stocks as $stock) { // <-- Pastikan menggunakan 'as'
            BloodStock::create($stock);
        }
    }
}