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
            $table->string('skor', 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perkembangan', function (Blueprint $table) {
            $table->tinyInteger('skor')->default(1)->change();
        });
    }
};
