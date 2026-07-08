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
        Schema::create('kamar', function (Blueprint $table) {
            $table->increments('id');
            // Relasi ke tipe kamar
            $table->unsignedInteger('tipe_kamar_id');
            $table->foreign('tipe_kamar_id')
                    ->references('id')
                    ->on('tipe_kamar')
                    ->onDelete('cascade');
            // Nomor kamar
            $table->string('nomor_kamar')->unique(); // 101, 202, 303
            // Status kamar
            $table->enum('status', [
                'tersedia',
                'terisi',
                'perawatan'
            ])->default('tersedia');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamar');
    }
};
