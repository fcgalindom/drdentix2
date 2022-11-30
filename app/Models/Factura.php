<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    public function appoinment()
    {
        return $this->belongsTo(appointment::class, 'appoinment_id');
    }

    public function procedure()
    {
        return $this->hasOne(Procedures::class, 'id', 'procedure_id');
    }
}
