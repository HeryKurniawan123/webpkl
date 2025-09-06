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
        Schema::create('lokasi_iduka', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iduka_id')->constrained('idukas')->onDelete('cascade');
            $table->string('nama_lokasi'); // contoh: Kantor Pusat, Cabang A
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->integer('radius')->default(100); // dalam meter
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi_iduka');
    }
};
