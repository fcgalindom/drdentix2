<?php

use App\Http\Controllers\Dentist\DentistController;
use Illuminate\Support\Facades\Route;

Route::middleware('dentistM', 'auth')->group(function () {
//-------------------------------------------------------------------------------------------------------------------------------
//  Branch
//-------------------------------------------------------------------------------------------------------------------------------

Route::get('/citas',[DentistController::class, 'view2']);

Route::get('/index',[DentistController::class, 'index2']);
Route::post('/change_state',[DentistController::class, 'change']);
Route::get('/MyProfile',[DentistController::class, 'show']);
Route::get('/MySchedule',[DentistController::class, 'schedule']);
Route::post('/MySchedule',[DentistController::class, 'store_schedule']);
Route::put('/MySchedule',[DentistController::class, 'myschedule']);

Route::get('/horario',[DentistController::class, 'hourSohow']);

});
