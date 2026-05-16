<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodStock extends Model
{
    use HasFactory;

    protected $table = 'blood_stocks';

    protected $fillable = [
        'blood_type',
        'rhesus',
        'bags_quantity',
        'location',
        'status',
    ];

    /**
     * Scope untuk memfilter stok darah yang berstatus 'Kritis' atau 'Menipis'.
     * Berguna untuk menampilkan peringatan/alert di Landing Page.
     */
    public function scopeUrgent($query)
    {
        return $query->whereIn('status', ['Kritis', 'Menipis']);
    }
}