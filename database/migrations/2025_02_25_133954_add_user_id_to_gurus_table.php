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
        Schema::table('gurus', function (Blueprint $table) {
            // Menambahkan kolom user_id
            $table->unsignedBigInteger('user_id')->nullable();

            // Menambahkan foreign key yang mengarah ke tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
             // Menghapus foreign key dan kolom user_id
             $table->dropForeign(['user_id']);
             $table->dropColumn('user_id');
        });
    }
};
