<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kamar;
use App\Models\Fasilitas;

class TipeKamar extends Model
{
    protected $table = 'tipe_kamar';

    protected $fillable = [
        'nama_tipe_kamar',
        'deskripsi_kamar',
        'harga_per_malam',
        'kapasitas'
    ];

    // Satu tipe kamar memiliki banyak kamar
    public function kamar()
    {
        return $this->hasMany(Kamar::class, 'tipe_kamar_id');
    }

    // Satu tipe kamar memiliki banyak fasilitas
    public function fasilitas()
    {
        return $this->belongsToMany(
            Fasilitas::class,
            'fasilitas_tipe_kamar',
            'tipe_kamar_id',
            'fasilitas_id'
        );
    }
}