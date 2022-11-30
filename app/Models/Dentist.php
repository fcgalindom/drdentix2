<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dentist extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function procedures()
    {
        return $this->belongsToMany(Procedures::class, 'dentistProcedures', 'dentistsF' ,'proceduresF');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'dentistF');
    }

    public function schedulesOne()
    {
        return $this->hasMany(Schedule::class, 'dentistF')->where('attend',1);
    }
}
