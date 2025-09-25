<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jurnals', function (Blueprint $table) {
            $table->foreignId('iduka_id')->nullable()->after('user_id')->constrained('idukas')->nullOnDelete();
            $table->foreignId('pembimbing_id')->nullable()->after('iduka_id')->constrained('gurus')->nullOnDelete();
        });

        // Copy existing relationships from users table
        DB::statement('
            UPDATE jurnals j 
            INNER JOIN users u ON j.user_id = u.id 
            SET j.iduka_id = u.iduka_id, 
                j.pembimbing_id = u.pembimbing_id
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jurnals', function (Blueprint $table) {
            $table->dropForeign(['iduka_id']);
            $table->dropForeign(['pembimbing_id']);
            $table->dropColumn(['iduka_id', 'pembimbing_id']);
        });
    }
};