<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    protected $table = 'tamu';
    protected $fillable = ['nama_lengkap', 'identity_number', 'no_telepon', 'alamat'];

    // Tamu punya banyak booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
