<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;



class GraphController extends Controller
{

    public function index()
    {
         $dentist = User::with(['dentist'])->where('state','Activo')->get();
         return $dentist;
    }
}
