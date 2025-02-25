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
        Schema::table('usulan_idukas', function (Blueprint $table) {
            $table->unsignedBigInteger('konkes_id')->after('user_id')->nullable();

            // Jika ada relasi ke tabel konkes, tambahkan foreign key
            $table->foreign('konkes_id')->references('id')->on('konkes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usulan_idukas', function (Blueprint $table) {
            $table->dropForeign(['konkes_id']);
            $table->dropColumn('konkes_id');
        });
    }
};
