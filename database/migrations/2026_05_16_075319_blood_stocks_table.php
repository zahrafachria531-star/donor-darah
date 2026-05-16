<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blood_stocks', function (Blueprint $table) {
            $table->id();
            $table->enum('blood_type', ['A', 'B', 'AB', 'O']);
            $table->enum('rhesus', ['+', '-'])->default('+');
            $table->integer('bags_quantity')->default(0); // Jumlah kantong darah yang tersedia
            $table->string('location')->default('PMI Pusat'); // Lokasi bank darah/RS
            $table->enum('status', ['Aman', 'Menipis', 'Kritis'])->default('Aman'); // Indikator visual di landing page
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_stocks');
    }
};