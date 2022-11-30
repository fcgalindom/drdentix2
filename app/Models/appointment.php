<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appointment extends Model
{
    use HasFactory;

    protected $casts = [
        'day' => 'date:d-m-Y',
        'hour' => 'date:g:i a'
    ];

    public function fullDate() : Attribute
    {
        return Attribute::make(
            get: fn() => $this->day . ' ' . $this->hour,
            set: fn ($value) => strtoupper($value),
        );
    }


    public function denpro()
    {
        return $this->belongsTo(DentistProcedures::class, 'dentistProceduresF');
    }

    public function dPacient()
    {
        return $this->belongsTo(Patients::class, 'patientsF');
    }

    public function dbraches()
    {
        return $this->belongsTo(Branch::class, 'branchesF');
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'appoinment_id', 'id');
    }
}
