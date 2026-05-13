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
        Schema::create('penilaian_mingguans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('murid_id')->index();
            $table->unsignedBigInteger('indikator_id')->index();
            $table->unsignedBigInteger('user_id_guru')->index();
            $table->date('tanggal');
            $table->integer('minggu_ke'); // Minggu ke berapa (1-4)
            $table->string('skor', 2); // BM, KM, M, K
            $table->timestamps();
            
            $table->foreign('murid_id')->references('id')->on('murid')->onDelete('cascade');
            $table->foreign('indikator_id')->references('id')->on('indikators')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_mingguans');
    }
};
