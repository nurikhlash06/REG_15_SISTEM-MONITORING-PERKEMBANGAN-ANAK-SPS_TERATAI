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
            $table->string('nama_orang_tua')->nullable()->after('id_user_orangtua');
            $table->string('email_orang_tua')->nullable()->after('nama_orang_tua');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('murid', function (Blueprint $table) {
            $table->dropColumn(['nama_orang_tua', 'email_orang_tua']);
        });
    }
};
