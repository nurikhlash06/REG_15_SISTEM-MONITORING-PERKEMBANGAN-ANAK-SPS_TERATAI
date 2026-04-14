<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perkembangan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('murid_id')->index();
            $table->unsignedBigInteger('user_id_guru')->index();
            $table->date('tanggal');
            $table->string('aspek'); // Motorik / Kognitif / Bahasa / Sosial / dll
            $table->text('catatan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perkembangan');
    }
};

