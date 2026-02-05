<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kelas_id')
                ->constrained('kelas')
                ->cascadeOnDelete();

            $table->foreignId('mapel_id')
                ->constrained('mapel')
                ->cascadeOnDelete();

            $table->string('judul');
            $table->string('perintah');
            $table->text('deskripsi');
            $table->dateTime('deadline');
            $table->enum('tipe', ['individu', 'kelompok']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
