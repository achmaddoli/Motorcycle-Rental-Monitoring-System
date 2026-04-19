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
        Schema::create('monitoring', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kendaraan'); // Kolom id_kendaraan untuk menghubungkan ke tabel kendaraan
            $table->unsignedBigInteger('id_sewa'); // Kolom id_kendaraan untuk menghubungkan ke tabel kendaraan
            $table->string('longitude'); // Kolom untuk menyimpan longitude (tipe string)
            $table->string('latitude'); // Kolom untuk menyimpan latitude (tipe decimal)
            $table->boolean('is_inside'); // Kolom untuk menyimpan latitude (tipe decimal)
            // Kolom untuk menyimpan ID pengguna yang membuat, mengupdate, atau menghapus data
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring');
    }
};
