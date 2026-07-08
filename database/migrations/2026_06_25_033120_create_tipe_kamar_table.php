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
        Schema::create('tipe_kamar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_tipe_kamar'); // Standard, Deluxe, Suite
            $table->text('deskripsi_kamar')->nullable();
            $table->decimal('harga_per_malam', 10, 2);  // harga per malam
            $table->integer('kapasitas');                // max tamu
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipe_kamar');
    }
};
