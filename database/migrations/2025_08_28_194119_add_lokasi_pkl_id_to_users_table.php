<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('lokasi_pkl_id')->nullable()->after('iduka_id');

            // bikin relasi ke tabel lokasi_pkl
            $table->foreign('lokasi_pkl_id')->references('id')->on('lokasi_pkl')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['lokasi_pkl_id']);
            $table->dropColumn('lokasi_pkl_id');
        });
    }
};
