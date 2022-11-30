<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedures extends Model
{
    use HasFactory;

    public function dentists(){
      return $this->belongsToMany(Dentist::class, 'dentistProcedures','proceduresF','dentistsF');
    }
}
