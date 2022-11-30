<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerHistory extends Controller
{
    public function index()
    {
        return Inertia::render('CustomerHistory/Search');
    }
}
