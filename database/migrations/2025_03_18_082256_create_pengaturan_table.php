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
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('longitude'); // Kolom untuk menyimpan longitude (tipe decimal)
            $table->string('latitude'); // Kolom untuk menyimpan latitude (t~~~~~ipe decimal)
            $table->integer('radius'); // Kolom untuk radius (misalnya dalam meter)
            $table->text('keterangan')->nullable(); // Kolom untuk keterangan (nullable jika tidak wajib)
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
        Schema::dropIfExists('pengaturan');
    }
};
