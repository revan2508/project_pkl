<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('anggota_kelompok', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('kelompok_id');
        $table->unsignedBigInteger('siswa_id');
        $table->timestamps();

        $table->foreign('kelompok_id')->references('id')->on('kelompok')->onDelete('cascade');
        $table->foreign('siswa_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_kelompok');
    }
};
