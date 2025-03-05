<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('data_pribadis', function (Blueprint $table) {
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('konke_id')->constrained('konkes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('data_pribadis', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropForeign(['konke_id']);
            $table->dropColumn(['kelas_id', 'konke_id']);
        });
    }
};
