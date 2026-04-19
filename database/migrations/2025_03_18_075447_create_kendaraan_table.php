<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->id();
            $table->string('tipe_kendaraan'); // Kolom tipe kendaraan
            $table->string('nomor_kendaraan')->unique(); // Kolom nomor kendaraan
            $table->string('foto')->nullable(); // Kolom untuk menyimpan foto kendaraan (nullable jika tidak wajib)
            $table->string('status_kendaraan');
            $table->unsignedBigInteger('created_by')->nullable(); // Menghubungkan dengan tabel users
            $table->unsignedBigInteger('updated_by')->nullable(); // Menghubungkan dengan tabel users
            $table->unsignedBigInteger('deleted_by')->nullable(); // Menghubungkan dengan tabel users
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraan');
    }
};
