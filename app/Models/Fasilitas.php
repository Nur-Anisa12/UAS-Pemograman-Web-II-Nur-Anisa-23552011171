<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';
    protected $fillable = ['nama_fasilitas', 'deskripsi_fasilitas'];

    // Many-to-Many balik ke tipe kamar
    public function Tipekamar()
    {
        return $this->belongsToMany(TipeKamar::class, 'fasilitas_tipe_kamar');
    }
}
