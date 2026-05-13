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
        Schema::table('perkembangan', function (Blueprint $table) {
            // Skor 1-4 (BB, MB, BSH, BSB)
            $table->tinyInteger('skor')->default(1)->after('aspek');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perkembangan', function (Blueprint $table) {
            $table->dropColumn('skor');
        });
    }
};
