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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('jenis', 100);
            $table->string('judul');
            $table->text('pesan')->nullable();
            $table->string('url_aksi')->nullable();
            $table->json('data_tambahan')->nullable();
            $table->boolean('sudah_dibaca')->default(false);
            $table->timestamps();
            $table->index(['id_user', 'sudah_dibaca']);
            $table->index('jenis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
