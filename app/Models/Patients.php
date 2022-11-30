<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function appoinmets()
    {
        return $this->hasMany(appointment::class, 'patientsF');
    }

    public function user_act()
    {
        return $this->belongsTo(User::class, 'id_user')->where('state', 'Activo');
    }
}
