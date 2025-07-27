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
        Schema::create('peta_kerusakans', function (Blueprint $table) {
            $table->id();
            $table->string('lokasi');
            $table->text('deskripsi');
            $table->enum('tingkat_kerusakan', ['ringan', 'sedang', 'berat']);
            $table->string('gambar')->nullable();
            $table->date('tanggal_inspeksi');
            $table->unsignedBigInteger('semua_laporan_id')->nullable();
            $table->foreign('semua_laporan_id')->references('id')->on('semua_laporans')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peta_kerusakans');
    }
};
