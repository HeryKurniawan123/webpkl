<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('data_pribadis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('nip')->unique();
            $table->string('konsentrasi_keahlian');
            $table->string('kelas');
            $table->string('email')->unique();

            $table->string('name_ayh');
            $table->string('name_ibu');
            $table->string('nik')->unique();
            $table->text('alamat')->nullable();
            $table->string('email_ortu')->unique();
            $table->string('no_tlp')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pribadis');
    }
};
