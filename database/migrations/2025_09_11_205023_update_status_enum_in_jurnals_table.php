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
        DB::statement("ALTER TABLE jurnals MODIFY status
            ENUM('pending','approved_iduka','approved_pembimbing','approved','rejected')
            DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE jurnals MODIFY status
            ENUM('pending','approved_iduka','approved_pembimbing','rejected')
            DEFAULT 'pending'");
    }
};
