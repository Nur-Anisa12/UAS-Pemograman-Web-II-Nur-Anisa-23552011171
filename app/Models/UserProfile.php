<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{

    protected $table      = 'user_profiles';
    protected $primaryKey = 'id_user_profile';

    protected $fillable = ['id_user', 'no_telepon', 'jenis_kelamin', 'avatar'];

    // Balik ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

}
