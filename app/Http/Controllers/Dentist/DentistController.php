<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use App\Http\Requests\DentistStoreRequest;
use App\Mail\EmailVerify;
use App\Mail\Factura;
use App\Models\Factura as FacturasModel;
use App\Models\appointment;
use App\Models\Dentist;
use App\Models\Procedures;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Patients;
use App\Repositories\DentistRepository;
use App\Repositories\ProcedureRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;

class DentistController extends Controller
{

    private $dentist_repository;
    private $procedure_repository;
    private $user_repository;

    public function __construct(DentistRepository $dentist_repository, ProcedureRepository $procedure_repository, UserRepository $user_repository)
    {
        $this->dentist_repository = $dentist_repository;
        $this->procedure_repository = $procedure_repository;
        $this->user_repository = $user_repository;
    }

    public function view()
    {
        return Inertia::render('Administrator/Dentis');
    }

    public function index(Request $request)
    {
        $dentist = $this->dentist_repository->list($request->all());
        $procedures = $this->procedure_repository->select2();

        return response()->json([
            'dentist' => $dentist,
            'procedures' => $procedures,
        ]);
    }

    public function store(DentistStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            if ($request->id == 0) :
                $user = $this->user_repository->new();
                $user->id = $this->user_repository->next_id();;
                $dentist = $this->dentist_repository->new();
                $dentist->id = $this->dentist_repository->next_id();
                $user->password = Hash::make($request->password);
            else :
                $dentist = $this->dentist_repository->find($request->id);
                $user = $this->user_repository->find($dentist->id_user);
            endif;

            $user->document = $request->document;
            $user->email = $request->email;
            $user->type_user = 'Dentist';
            $this->user_repository->save($user);

            $dentist->name = $request->name;
            $dentist->city = $request->city;
            $dentist->id_user = $user->id;
            $dentist = $this->dentist_repository->save($dentist);
            $dentist->procedures()->sync(array_column($request->procedures, 'id'));

            $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
            $id = base64($user->id, 'encode');
            $dentist = base64_encode('dentist');
            $id = $id . 'DrDentix' . $dentist;
            $verify = $link . '://' . $_SERVER["HTTP_HOST"] . '/Administrador/email_verify/' . $id;

            if ($request->id == 0 && !empty($request->email)) :
                $mail = new EmailVerify($verify);
                Mail::to($user->email)->send($mail);
            endif;

            DB::commit();

            return response()->json([
                'status' => 200,
                'msg' => 'Datos guardados con éxito'
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
        $user = $this->dentist_repository->find($request->id)->user;
        $user->state = $request->user['state'];
        $user->save();
        return response()->json([
            'status' => 200,
            'msg' => 'Estado actualizado con éxito',
        ]);
    }

    public function show()
    {

        $patient = Dentist::with(['user', 'procedures'])->where('id_user', Auth::user()->id)->first();
        return Inertia::render('Patient/MyProfile', ['patient' => $patient]);
    }

    public function view2()
    {
        return Inertia::render('Odontologos/MyAppointment');
    }

    public function index2(Request $request)
    {
        $dentists = appointment::with(['denpro.dentists', 'dPacient.user', 'denpro.procedures', 'dbraches'])
            ->whereRelation('denpro', 'dentistsF', 1)
            ->where(function ($query) use ($request) {
                if ($request->time == 'De hoy') :
                    $query->where('day', date('Y-m-d'));
                endif;
            })
            ->orderByDesc('id')
            ->paginate(cant());
        return response()->json([
            'dentists' => $dentists,
        ]);
    }

    public function change(Request $request)
    {
        // return $request->all();
        $price = 0;
        foreach ($request->pagos as $key) {
            if (!is_null($key['price']) && !empty($key['procedure'])) :
                $nuevo = new FacturasModel();
                $nuevo->price = $key['price'];
                $nuevo->procedure_id = $key['procedure'];
                $nuevo->appoinment_id = $request->id;
                $nuevo->save();
                $price += $key['price'];
            endif;
        }

        $appointment = appointment::with(['denpro.dentists', 'dPacient.user', 'denpro.procedures', 'dbraches', 'facturas.procedure'])->find($request->id);

        if ($request->state == 'Asistio') $request->state = 'Pagado';
        $appointment->pay = $price;
        $appointment->state = $request->state;
        $appointment->save();

        if ($appointment->state != 'No asistio') :
            $name = public_path() . '/pdf/facturas' . time() . '.pdf';
            $pdf = PDF::loadView('citas', [
                'data' => $appointment,
                'logo' => public_path('/images/logo.jpg'),
                'hr' => public_path('/images/hr.jpg'),
            ])->save($name);

            $pdf->stream();

            $patient = Patients::with(['user'])->find($request->patientsF);
            Mail::to($patient->user['email'])->send(new Factura("dasda", $name));
        endif;


        return response()->json([
            'status' => 200,
            'msg' => 'Estado actualizado con éxito',
            'cita' => $appointment,
        ]);
    }

    public function hourSohow()
    {
        return Inertia::render('Odontologos/Horario');
    }

    public function schedule($id = -1)
    {
        return Inertia::render('Odontologos/MySchedule', ['id' => $id]);
    }

    public function myschedule(Request $request)
    {
        // return $request->all();
        if (Auth::user()->type_user == 'Administrator') $id = $request->id;
        elseif (Auth::user()->type_user == 'Dentist') $id = Auth::user()->id;

        $schedules = Dentist::where('id_user', $id)->first()->schedules;
        $dentist = Dentist::where('id_user', $id)->first();
        return response()->json([
            'schedules' => $schedules,
            'dentist' => $dentist,
        ]);
    }

    public function store_schedule(Request $request)
    {
        if (Auth::user()->type_user == 'Administrator') $id = $request->id;
        elseif (Auth::user()->type_user == 'Dentist') $id = Auth::user()->id;

        $schedules = Dentist::where('id_user', $id)->first()->schedules;
        $dentistF = Dentist::where('id_user', $id)->first()->id;
        for ($index = 0; $index < 6; $index++) {
            if (sizeof($schedules) == 0) $schedule = new Schedule();
            else  $schedule = Schedule::find($schedules[$index]["id"]);

            $schedule->day = $index + 1;
            $schedule->break = $request[2][$index];
            $schedule->hour_strart = $request[0][$index];
            $schedule->hour_end = $request[1][$index];
            $schedule->break_strart = $request[3][$index];
            $schedule->break_end = $request[4][$index];
            $schedule->attend = $request[5][$index];
            $schedule->dentistF = $dentistF;
            $schedule->save();
        }

        return response()->json([
            'status' => 200,
            'msg' => 'Tu horario ha sido guardado con éxito'
        ]);
    }
}
