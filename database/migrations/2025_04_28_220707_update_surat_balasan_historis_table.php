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
        Schema::table('surat_balasan_histories', function (Blueprint $table) {
            // Hapus foreign key lama dan kolom cetak_usulan_id
            $table->dropForeign(['cetak_usulan_id']);
            $table->dropColumn('cetak_usulan_id');

            // Tambahkan kolom baru pengajuan_pkl_id
            $table->foreignId('pengajuan_pkl_id')->after('id')->constrained('pengajuan_pkls')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_balasan_histories', function (Blueprint $table) {
            // Hapus foreign key baru dan kolom pengajuan_pkl_id
            $table->dropForeign(['pengajuan_pkl_id']);
            $table->dropColumn('pengajuan_pkl_id');

            // Tambahkan kembali kolom cetak_usulan_id
            $table->foreignId('cetak_usulan_id')->constrained()->onDelete('cascade');
        });
    }
};
