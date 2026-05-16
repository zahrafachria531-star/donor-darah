<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'blood_type',
        'rhesus',
        'last_donation_date',
    ];

    /**
     * Atribut yang harus disembunyikan untuk serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast tipe data kolom tertentu.
     */
    protected $casts = [
        'last_donation_date' => 'date',
    ];

    /**
     * Custom Method: Mengecek apakah user sudah boleh mendonor lagi.
     * Jeda waktu minimal donor darah adalah 60 hari.
     *
     * @return bool
     */
    public function canDonateAgain()
    {
        if (!$this->last_donation_date) {
            return true; // Jika belum pernah donor, otomatis boleh
        }

        // Hitung selisih hari dari donor terakhir hingga hari ini
        return Carbon::parse($this->last_donation_date)->diffInDays(Carbon::now()) >= 60;
    }
}