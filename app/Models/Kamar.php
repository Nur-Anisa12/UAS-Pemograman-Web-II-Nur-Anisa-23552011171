<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $table = 'kamar';
    protected $fillable = ['tipe_kamar_id', 'nomor_kamar', 'status', 'deskripsi'];

    // Kamar punya satu tipe kamar
    public function tipeKamar()
    {
        return $this->belongsTo(TipeKamar::class);
    }

    // Kamar punya banyak bookings
    public function bookings()
    {
        return $this->hasMany(booking::class);
    }
}
