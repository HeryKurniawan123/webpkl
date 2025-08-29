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
        Schema::create('absensi_pkl', function (Blueprint $table) {
            $table->id();
            $table->string('nis'); // FK ke users.nip
            $table->enum('status', ['Hadir', 'Pulang', 'Izin', 'sakit']);
            $table->timestamp('waktu')->nullable();
            $table->text('keterangan')->nullable();

            // Tambahan kolom jarak
            $table->decimal('jarak', 8, 2)->nullable();

            $table->timestamps(); // otomatis bikin created_at & updated_at

            $table->foreign('nis')
                ->references('nip')
                ->on('users')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_pkl');
    }
};
