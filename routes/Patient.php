<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

Route::middleware('patientM', 'auth')->group(function () {


//-----------------------------------------------------------------------------------------------------------------------------
// Facturacion
//-----------------------------------------------------------------------------------------------------------------------------



});
Route::post('/Paciente-citas', [AppointmentController::class, 'index']);

Route::get('/citasPaciente/{id}',[AppointmentController::class, 'billing'])->name('patient.citas.facturas');
Route::get('/download_pdf',[AppointmentController::class, 'download_pdf']);
Route::get('/darhora',[AppointmentController::class, 'darHora']);

//-----------------------------------------------------------------------------------------------------------------------------
// Citas
//-----------------------------------------------------------------------------------------------------------------------------

Route::get('/citas',[AppointmentController::class, 'view'])->name('patient.citas');
Route::post('/Paciente-citasStore',[AppointmentController::class, 'store']);

Route::get('/citasPorPaciente',[AppointmentController::class, 'cancel']);
Route::get('/citasPorPacienteDado',[AppointmentController::class, 'index2']);
Route::post('/citasPorPacienteCancelar',[AppointmentController::class, 'destroy2']);
Route::get('/MyProfile',[AppointmentController::class, 'show']);

Route::post('/schedulefordentist',[AppointmentController::class, 'schedulefordentist']);

Route::post('/scheduleforprocedure',[AppointmentController::class, 'scheduleforprocedure']);
Route::post('/schedulefordate',[AppointmentController::class, 'val_schedulefordate']);
