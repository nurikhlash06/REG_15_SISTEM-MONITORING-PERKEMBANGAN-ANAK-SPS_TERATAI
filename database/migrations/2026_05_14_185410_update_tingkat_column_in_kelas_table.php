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
        \DB::table('kelas')->where('tingkat', 'B1')->update(['tingkat' => 'B']);
        
        Schema::table('kelas', function (Blueprint $table) {
            $table->enum('tingkat', ['A', 'B', 'C'])->default('A')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->enum('tingkat', ['A', 'B', 'B1'])->default('A')->change();
        });
    }
};
