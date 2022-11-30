<?php

use App\Http\Controllers\Administrator\ProcedureController;
use App\Http\Controllers\AdministratorCitaController;
use App\Http\Controllers\Branch\BranchController;
use App\Http\Controllers\Dentist\DentistController;
use App\Http\Controllers\Patients\PatientController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\GraphController;
use App\Http\Controllers\ProdutsController;
use App\Http\Controllers\PromotionController;

Route::middleware('adminM', 'auth')->group(function () {

    Route::post('/patients_for_top', [AdministratorCitaController::class, '__index__'])->name('administrator.patients_top');

    //-------------------------------------------------------------------------------------------------------------------------------
    //  Branch
    //-------------------------------------------------------------------------------------------------------------------------------

    Route::get('/', [BranchController::class, 'view'])->name('administrator.branch.view');
    Route::get('/prueba', [AdministratorCitaController::class, 'driverSQL'])->name('administrator.branch.driver');
    Route::get('/index', [BranchController::class, 'index'])->name('administrator.branch.index');
    Route::post('/store', [BranchController::class, 'store'])->name('administrator.branch.store');
    Route::post('/destroy-brach', [BranchController::class, 'destroy'])->name('administrator.branch.destroy');

    //-------------------------------------------------------------------------------------------------------------------------------
    //  Procedures
    //-------------------------------------------------------------------------------------------------------------------------------

    Route::get('/Procedimientos', [ProcedureController::class, 'view']);
    Route::get('/Procedimientos-index', [ProcedureController::class, 'index']);
    Route::post('/destroy-procedure', [ProcedureController::class, 'destroy']);
    Route::post('/store-procedure', [ProcedureController::class, 'store']);

    //-------------------------------------------------------------------------------------------------------------------------------
    //  dentist
    //-------------------------------------------------------------------------------------------------------------------------------

    Route::get('/Odontologo', [DentistController::class, 'view']);
    Route::put('/Odontologo-index', [DentistController::class, 'index'])->name('administrator.dentist.index');
    Route::post('/Odontologo-store', [DentistController::class, 'store'])->name('administrator.dentist.store');
    Route::post('/destroy-Odontologo', [DentistController::class, 'destroy']);


    //-------------------------------------------------------------------------------------------------------------------------------
    //  pacient
    //-------------------------------------------------------------------------------------------------------------------------------

    Route::get('/Paciente', [PatientController::class, 'view']);
    Route::put('/Paciente-index', [PatientController::class, 'index'])->name('administrator.patient.index');
    Route::post('/Paciente-destroy', [PatientController::class, 'destroy']);

    //-------------------------------------------------------------------------------------------------------------------------------
    //  Citas
    //-------------------------------------------------------------------------------------------------------------------------------

    Route::get('/verCitas/{id?}', [AdministratorCitaController::class, 'verCitas']);
    Route::put('/citasdiarias', [AdministratorCitaController::class, 'index']);
    Route::post('/change_state', [DentistController::class, 'change']);

    Route::get('/citasAdministrador/{id?}', [AppointmentController::class, 'view']);
    Route::get('/citaAdminxPaciente/{id?}', [AppointmentController::class, 'viewxpatient']);
    Route::post('/Paciente-citas', [AppointmentController::class, 'index']);
    Route::post('/delete-citas', [AppointmentController::class, 'delete']);
    Route::post('/whatsapp_manual',[AppointmentController::class, 'whatsapp_manual']);
    Route::post('/cellphone_manual',[AppointmentController::class, 'cellphone_manual'])->name('adminsitrator.citas.cellphone');


    Route::post('/citasPorPacienteDado',[AppointmentController::class, 'citasPorPacienteDado'])->name('administrator.citas.pacienteDado');

    //-------------------------------------------------------------------------------------------------------------------------------
    //  Promociones
    //-------------------------------------------------------------------------------------------------------------------------------

    Route::get('/Promociones', [PromotionController::class, 'view']);
    Route::put('/Promociones', [PromotionController::class, 'index']);
    Route::post('/CrearPromocion', [PromotionController::class, 'store']);
    Route::post('/EliminarPromocion', [PromotionController::class, 'destroy']);

    //-------------------------------------------------------------------------------------------------------------------------------
    //  Schedule
    //-------------------------------------------------------------------------------------------------------------------------------

    Route::get('/MySchedule/{id?}', [DentistControllerF::class, 'schedule']);
    Route::post('/MySchedule/{id?}', [DentistController::class, 'store_schedule']);
    Route::put('/MySchedule/{id?}', [DentistController::class, 'myschedule']);
    //-------------------------------------------------------------------------------------------------------------------------------
    //  Products
    //-------------------------------------------------------------------------------------------------------------------------------
    Route::get('/Products', [ProdutsController::class, 'view']);
    Route::post('/StoreProducts', [ProdutsController::class, 'store'])->name('administrator.products.store');
    Route::get('/indexProducts', [ProdutsController::class, 'index'])->name('administrator.products.index');
    Route::post('/destroy-products', [BranchController::class, 'destroy'])->name('administrator.products.destroy');

    //-------------------------------------------------------------------------------------------------------------------------------
    //  Products
    //-------------------------------------------------------------------------------------------------------------------------------
    Route::post('/verify_appoinments', [AppointmentController::class, 'verify_appoinments'])->name('administrator.verify_appoinments');
});
//-------------------------------------------------------------------------------------------------------------------------------
//  User
//-------------------------------------------------------------------------------------------------------------------------------

Route::get('/email_verify/{id}', [UserController::class, 'email_verify']);

//-------------------------------------------------------------------------------------------------------------------------------
//  pacient
//-------------------------------------------------------------------------------------------------------------------------------

Route::post('/Paciente-store', [PatientController::class, 'store'])->name('administrator.patient.store');
Route::get('/Datas', [GraphController::class, 'index'])->name('administrator.graph.index');