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
        Schema::table('semua_laporans', function (Blueprint $table) {
            $table->unsignedBigInteger('ditugaskan_kepada_id')->nullable()->after('id');
            // Jika ingin relasi foreign key:
            // $table->foreign('ditugaskan_kepada_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('semua_laporans', function (Blueprint $table) {
            //
        });
    }
};
