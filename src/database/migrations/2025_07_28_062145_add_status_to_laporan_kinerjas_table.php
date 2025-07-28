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
        Schema::table('laporan_kinerjas', function (Blueprint $table) {
            $table->string('status')->default('draft');
            $table->string('prioritas')->default('sedang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_kinerjas', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('prioritas');
        });
    }
};
