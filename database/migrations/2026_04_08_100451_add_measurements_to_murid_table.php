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
            $table->float('berat_badan')->nullable()->after('tanggal_lahir');
            $table->float('tinggi_badan')->nullable()->after('berat_badan');
            $table->float('lingkar_kepala')->nullable()->after('tinggi_badan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('murid', function (Blueprint $table) {
            $table->dropColumn(['berat_badan', 'tinggi_badan', 'lingkar_kepala']);
        });
    }
};
