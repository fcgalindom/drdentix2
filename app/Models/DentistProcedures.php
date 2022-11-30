<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DentistProcedures extends Model
{
    use HasFactory;
    protected $table = 'dentistProcedures';


    public function dentists(){
        return $this->belongsTo(Dentist::class, 'dentistsF');
    }

    public function procedures(){
        return $this->belongsTo(Procedures::class, 'proceduresF');
    }


}
