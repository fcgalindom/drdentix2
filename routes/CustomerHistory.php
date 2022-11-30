<?php

use App\Http\Controllers\CustomerHistory;
use Illuminate\Support\Facades\Route;

Route::middleware('adminM', 'auth')->group(function () {

    Route::get('/busqueda', [CustomerHistory::class, 'index']);

});
