<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientStoreRequest;
use App\Mail\EmailVerify;
use App\Mail\RegisterMail;
use App\Repositories\PatientRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;


class PatientController extends Controller
{

    private $patient_repository;
    private $user_repository;

    public function __construct(PatientRepository $patient_repository, UserRepository $user_repository)
    {
        $this->patient_repository = $patient_repository;
        $this->user_repository = $user_repository;
    }

    public function view()
    {
        return Inertia::render('Administrator/Patient');
    }

    public function index(Request $request)
    {
        $patients = $this->patient_repository->list($request->all());

        return response()->json([
            'patients' => $patients,
        ]);
    }



    public function store(PatientStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $prefix = '';
            if ($request->id == 0) :
                $user = $this->user_repository->new();
                $user->id = $this->user_repository->next_id();
                $patients = $this->patient_repository->new();
                $patients->id = $this->patient_repository->next_id();
                $user->password = Hash::make('1234');
                $prefix = '+57';
            else :
                $patients = $this->patient_repository->find($request->id);
                $user = $this->user_repository->find($patients->id_user);
            endif;

            if ($request->birth > date('Y-m-d')) return response()->json(['status' => 422, 'msg' => 'La fecha de nacimiento no puede ser superior a la actual']);

            $user->document = $request->document;
            $user->birth = $request->birth;
            $user->email = $request->email;
            $user->type_user = 'Patient';
            $this->user_repository->save($user);

            $patients->name = $request->name;
            $patients->city = $request->city;
            $patients->telephone = $prefix . $request->telephone;
            $patients->id_user = $user->id;
            $this->patient_repository->save($patients);

            if (empty(Auth::user())) Auth::loginUsingId($user->id);

            if ($request->id == 0 && !empty($request->email)) :
                $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
                $id = base64($user->id, 'encode');
                $patient = base64_encode('Patient');
                $id = $id . 'DrDentix' . $patient;
                $verify = $link . '://' . $_SERVER["HTTP_HOST"] . '/Administrador/email_verify/' . $id;
                $mail = new EmailVerify($verify);
                Mail::to($user->email)->queue($mail);
                $mail = new RegisterMail($patients, $user);
                Mail::to('huberht3402@hotmail.com')->queue($mail);
            endif;
            DB::commit();

            return response()->json([
                'status' => 200,
                'msg' => 'Datos guardados con éxito',
                'prefix' => $prefix,
                'patient' => $patients
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'msg' => 'Error en el servidor',
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $user = $this->patient_repository->find($request->id)->user;
        $user->state = $request->user['state'];
        $user->email = time() . '@gmail.com';
        $user->document = time();
        $user->save();

        return response()->json([
            'status' => 200,
            'msg' => 'Estado actualizado con éxito',
        ]);
    }
}
