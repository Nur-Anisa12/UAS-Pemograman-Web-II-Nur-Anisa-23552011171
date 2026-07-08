<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';
    protected $primaryKey = 'id';

    protected $fillable = [
        'tamu_id',
        'kamar_id',
        'check_in_date',
        'check_out_date',
        'total_malam',
        'total_harga',
        'status',
        'catatan'
    ];

    public function tamu()
    {
        return $this->belongsTo(Tamu::class, 'tamu_id');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id');
    }

    // ← tambah ini biar Laravel tau pakai kolom apa untuk route binding
    public function getRouteKeyName()
    {
        return 'id';
    }
}