<?php

use App\Http\Controllers\UserController;
use App\Models\appointment;
use App\Models\Patients;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
// use GuzzleHttp;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//-------------------------------------------------------------------------------------------------------------------------------
//  Login (Patient and Dentist)
//-------------------------------------------------------------------------------------------------------------------------------

// Route::get('/', function () {
//     return hours_format(['13:00', '14:00'], 'g:i a');
// });

Route::get('/', [UserController::class, 'index'])->name('web.login');
Route::get('/log', [UserController::class, 'isLog'])->name('web.is_log');
Route::get('/loginAdministrador', [UserController::class, 'loginAdmin'])->name('web.login_admin');
Route::get('/logout', [UserController::class, 'logout']);
Route::get('/Mail', [UserController::class, 'mail']);

Route::post('/loginAdministrador', [UserController::class, 'loginAdm']);
Route::post('/loginP', [UserController::class, 'loginP']);

//-------------------------------------------------------------------------------------------------------------------------------
//  Errores
//-------------------------------------------------------------------------------------------------------------------------------

Route::get('403', [UserController::class, 'error403'])->name('403');

//-------------------------------------------------------------------------------------------------------------------------------
//  CRUD
//-------------------------------------------------------------------------------------------------------------------------------

Route::post('upload_photo', [UserController::class, 'update']);


Route::get('cambios',  [UserController::class, 'cambios']);

Route::get('/select2', function () {
    $users = Patients::all();
    $products = ['id' => $users->pluck('id'), 'name' => $users->pluck('name')];
    return Inertia::render('prueba2', [
        'products' => $products
    ]);
});

Route::get('/select3', function (Request $request) {
    $term = trim($request->query('search'));
    return appointment::search($term)->paginate(20);
});


Route::get('/message/{message}', [UserController::class, 'send_whatsapp']);
// Route::get('/whatsApp/{message}', [UserController::class, 'send_what']);
Route::get('/whatsApp', [UserController::class, 'sendw']);


Route::middleware(['auth:sanctum', 'verified'])->get('/jobs/create', [UserController::class, 'create']);

Route::get('/home', function () {
    return Inertia::render('Administrator/Home');
})->name('web.home_admin');

Route::get('/home-publicity', function(){
    $carrousel = asset('images/publicity/brackets.jpeg');
    return Inertia::render('publicity/Home',[
        'carrousel' => $carrousel
    ]);
});


Route::get('/promociones', function(){
    // $image = asset('images/logo.png');
    return Inertia::render('publicity/Home',[
        // 'image' => $image
    ]);
});

Route::post('/navegacion', function(){
    return asset('images/logo.png');
});

Route::get('/financiacion', function(){
    $imagenes = [ asset('images/publicity/listo.png'), asset('images/publicity/logo-sistecredito.png'), asset('images/publicity/addi.png') ];
    return Inertia::render('publicity/Financiacion',[
        'imagenes' => $imagenes,
    ]);
});

Route::get('/testimonios', function(){
    $image = asset('images/publicity/before-after.jpeg');
    return Inertia::render('publicity/Testimonios',[
        'image' => $image
    ]);
});




Route::get('/test_of_seed', function () {
    $json = json_decode(file_get_contents(storage_path("backup_json/users.json")), true);

    foreach ($json["RECORDS"] as $key) :
        $user = new User();
        $user->document = $key['document'];
        $user->birth = $key['birth'];
        $user->email = $key['email'];
        $user->password = $key['password'];
        $user->type_user = $key['type_user'];
        $user->verify_birth = $key['verify_birth'];
        $user->verify_email = $key['verify_email'];
        $user->state = $key['state'];
        $user->photo = $key['photo'];
        $user->save();
    endforeach;
});
