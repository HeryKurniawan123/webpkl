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
        Schema::table('surat_pengantars', function (Blueprint $table) {
            $table->date('tanggal_awal')->nullable();
        $table->date('tanggal_akhir')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_pengantars', function (Blueprint $table) {
            $table->dropColumn(['tanggal_awal', 'tanggal_akhir']);
        });
    }
};
