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
        Schema::create('booking', function (Blueprint $table) {
             $table->increments('id');

        // Data tamu yang melakukan reservasi
        $table->unsignedInteger('tamu_id');
        $table->foreign('tamu_id')
            ->references('id')
            ->on('tamu')
            ->onDelete('cascade');

        // Kamar yang dipesan
        $table->unsignedInteger('kamar_id');
        $table->foreign('kamar_id')
            ->references('id')
            ->on('kamar')
            ->onDelete('cascade');


        // Tanggal check-in
        $table->date('check_in_date');

        // Tanggal check-out
        $table->date('check_out_date');

        // Total lama menginap (malam)
        $table->integer('total_malam');

        // Total biaya menginap
        $table->decimal('total_harga', 10, 2);

        // Status reservasi
        $table->enum('status', [
            'pending',
            'confirmed',
            'checked_in',
            'checked_out',
            'cancelled'
        ])->default('pending');

        // Catatan tambahan
        $table->text('catatan')->nullable();

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
