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
        Schema::table('murid', function (Blueprint $table) {
            $table->unique('nik')->nullable();
            $table->unique('nisn')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('murid', function (Blueprint $table) {
            $table->dropUnique(['nik']);
            $table->dropUnique(['nisn']);
        });
    }
};
