<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas', 50);
            $table->string('kode_kelas', 20)->unique();
            $table->text('deskripsi')->nullable();
            $table->string('wali_kelas', 100)->nullable();
            $table->enum('tingkat', ['A', 'B', 'B1']);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });

        Schema::table('murid', function (Blueprint $table) {
            $table->unsignedBigInteger('kelas_id')->nullable()->after('rombel');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('murid', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
        });

        Schema::dropIfExists('kelas');
    }
};
