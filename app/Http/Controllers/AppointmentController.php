<?php

namespace App\Http\Controllers;

use App\Mail\DentixMail;
use App\Models\appointment;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Inertia\Inertia;
use App\Models\Patients;
use App\Models\Branch;
use App\Models\Procedures;
use App\Models\Dentist;
use App\Models\DentistProcedures;
use App\Repositories\AppoinmentRepository;
use App\Repositories\BranchRepository;
use App\Repositories\PatientRepository;
use App\Repositories\ProcedureRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{

    private $appoinment_repository;
    private $patient_repository;
    private $procedure_repository;
    private $branch_repository;

    public function __construct(
        AppoinmentRepository $appoinment_repository,
        PatientRepository $patient_repository,
        ProcedureRepository $procedure_repository,
        BranchRepository $branch_repository
    ) {
        $this->appoinment_repository = $appoinment_repository;
        $this->patient_repository = $patient_repository;
        $this->procedure_repository = $procedure_repository;
        $this->branch_repository = $branch_repository;
    }

    public function whatsapp_manual(Request $request)
    {
        $appointment = $this->appoinment_repository->find($request->id);
        $appointment->type_state = 1;
        $appointment->save();
        $msg = '¡Hola!%0A' .
            '*' . $request['d_pacient']['name'] . '*' . '%0A' . " Te escribo de la clínica odontológica Dr.Dentix para confirmar tu cita agendada para el día de mañana " . date("d-m-Y", strtotime($request["day"])) . '%0A' .
            ' Motivo: ' . $request['denpro']['procedures']['name'] . '%0A' .
            ' Hora: ' . date('g:i a', strtotime($request["hour"])) . '%0A' .
            ' Doctor: ' . $request['denpro']['dentists']['name'] . '%0A' . '%0A' .
            'Teléfono: +573156549290' . '%0A' .
            'Dirección:Carrera 4 N° 6-35 Barrio Belalcazar, Yumbo-Valle' . '%0A' .
            'https://maps.app.goo.gl/sVEzWbdSRiC8vq757' . '%0A' . '%0A' .
            '*Dr.Dentix* odontologia especializada al alcanze de todos!' . '%0A' . '%0A' .
            '¡Te esperamos!';
        return response()->json([
            'msg' => $msg,
            'request' => $request->all()
        ]);
    }

    public function cellphone_manual(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->appoinment_repository->changeState($request->id, 2, [], 'type_state');
            DB::commit();

            return response()->json([
                'status' => 200,
                'msg' => 'Estado actualizado a recordado por llamada',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'msg' => 'Error en el servidor',
            ]);
        }
    }

    public function index()
    {
        $patient = null;
        $patients = $this->patient_repository->select2Patient();
        $procedures = $this->procedure_repository->select2();

        if (Auth::user()->type_user != 'Administrator') $patient = $this->patient_repository->patient_auth();

        return response()->json([
            'branchs' => $this->branch_repository->select(),
            'procedures' => $procedures,
            'patients' => $patients,
            'patient' => $patient,
            'min_date' => date('Y-m-d'),
            'user' => Auth::user(),
        ]);
    }

    public function view($id = null)
    {
        if (!is_null($id)) $appointment = appointment::with(['dPacient.user', 'denpro.dentists.user', 'denpro.procedures', 'dbraches'])
            ->find($id);
        else $appointment = '';

        return Inertia::render('Patient/appointment', [
            'id' => $appointment,
            'type_petition' => 1,
        ]);
    }

    public function viewxpatient($id)
    {
        $patient = Patients::find($id);

        // return $patient;

        return Inertia::render('Patient/appointment', [
            'id' => $patient,
            'type_petition' => 2,
        ]);
    }

    public function show()
    {
        $patient = Patients::with(['user'])->where('id_user', Auth::user()->id)->first();
        return Inertia::render('Patient/MyProfile', ['patient' => $patient]);
    }

    public function cancel()
    {
        return Inertia::render('Patient/cancel');
    }

    public function index2(Request $request)
    {
        if (empty($request->id_user)) $id = Auth::user()->patient->id;
        else $id = $request->id;

        $patients = appointment::with(['dPacient.user', 'denpro.dentists.user', 'denpro.procedures', 'dbraches', 'facturas'])
            ->where('patientsF', $id)
            ->orderByDesc('id')
            // ->paginate(cant());
            ->paginate(cant());

        return response()->json([
            'patient' =>  $patients,
        ]);
    }

    public function billing($id)
    {
        $patients = $this->appoinment_repository->appoinment_x_patient($id, ['Pagado']);
        return Inertia::render('Administrator/Billing', ['patients' => $patients]);
    }

    public function download_pdf(Request $request)
    {
        $id = $request["key"];
        $patients = appointment::with(['dPacient.user', 'denpro.dentists.user', 'denpro.procedures', 'dbraches', 'facturas.procedure'])
            ->where('id', $id)
            ->where('state', 'Pagado')
            ->first();

        $pdf = \PDF::loadView('citas', [
            'data' => $patients,
            'logo' => public_path('/images/logo.jpg'),
            'hr' => public_path('/images/hr.jpg'),
        ]);

        return $pdf->stream();
    }

    public function destroy2(Request $request)
    {
        $this->appoinment_repository->changeState($request->id, 'Cancelado');

        return response()->json([
            'status' => 200,
            'msg' => 'Cita cancelada con éxito',
        ]);
    }

    public function viewPaciente()
    {
        return Inertia::render('Administrator/Appoinment');
    }

    public function darHora()
    {
        $shedule =  Schedule::where('dentistF', '=', 1)->get();
        return response()->json(['shedule' => $shedule]);
    }

    public function schedulefordentist(Request $request)
    {
        $schedule = Dentist::find($request->id)->with(['schedulesOne'])->first();
        return response()->json(['schedule' => $schedule,]);
    }

    public function scheduleforprocedure(Request $request)
    {
        $scheduleP = DentistProcedures::with(['dentists.schedulesOne'])->where('proceduresF', $request->id)->get();
        return response()->json(['scheduleP' => $scheduleP,]);
    }

    public function store(Request $request)
    {
        $rules = [
            'day' => 'required|date',
            'hour' => 'required',
            'branchesf' => 'required',
            'dentistf' => 'required',
            'patientsf' => 'required',
            'proceduresf' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return response()->json(['status' => 422, 'msg' => $validator->errors()->first(),]);
        $patientsDentist = DentistProcedures::where('proceduresF', $request->proceduresf)
            ->where("dentistsF", "=", $request->dentistf)->first();

        $day = Appointment::where('patientsF', $request->patientsf)->whereIn('state', ['Activo', 'Recordado'])->first();
        if (!empty($day)) :
            if (Auth::user()->type_user == 'Administrator') :
                if ($request->type != 1) :
                    return response()->json([
                        'status' => 300,
                        'msg' => '¿Este paciente ya tiene una cita activa, estás seguro de agendar?'
                    ]);
                endif;
            else :
                return response()->json([
                    'status' => 422,
                    'msg' => 'Ya tienes una cita activa, comunícate con la administración si deseas agendar otra cita'
                ]);
            endif;
        endif;

        if (empty($request->id)) {
            $appointment = $this->appoinment_repository->new();
            $appointment->id = $this->appoinment_repository->next_id();
        } else {
            $appointment = $this->appoinment_repository->find($request->id);
            $appointment->state = 'Activo';
        }

        $appointment->day = $request->day;
        $appointment->hour = date("H:i", strtotime($request->hour));
        $appointment->branchesF = $request->branchesf;
        $appointment->patientsF = $request->patientsf;
        $appointment->dentistProceduresF =  $patientsDentist->id;
        $this->appoinment_repository->save($appointment);

        $cita = $this->appoinment_repository->find($appointment->id, ['dPacient.user', 'dbraches', 'denpro.dentists', 'denpro.procedures']);

        // $email = $cita->dPacient->user->email;
        // Mail::to($email)->send(new DentixMail($cita, 3));
        // Mail::to('huberht3402@hotmail.com')->send(new DentixMail($cita, 5));

        return response()->json(['status' => 200, 'msg' => 'Datos guardados con éxito']);
    }

    public function val_schedulefordate(Request $request)
    {
        if (date('w', strtotime($request->day)) == 0) return response()->json(['status' => 422, 'msg' => 'Los días domingos no hay disponibilidad']);
        $schedule1 = Schedule::where('dentistF', $request->dentistf)->get();
        $schedule = Schedule::where('dentistF', $request->dentistf)->where('day', date('w', strtotime($request->day)))->first();
        $schedule->hour_end = Carbon::parse($schedule->hour_end)->toTimeString();
        $procedure = $this->procedure_repository->find($request->proceduresf)->duration;
        $appointment = appointment::with(['denpro.procedures'])
            ->where('day', $request->day)
            ->whereRelation('denpro', 'dentistsF', $request->dentistf)
            ->whereIn('state', ['Activo', 'Recordado'])
            ->get();
        $appointment1 = appointment::with(['denpro.procedures'])
            ->whereRelation('denpro', 'dentistsF', $request->dentistf)
            ->whereIn('state', ['Activo', 'Recordado'])
            ->get();
        $data  = $this->schedulefordate($schedule, $procedure, $appointment);
        return response()->json(['hours' => $data, 'schedule1' => $schedule1, 'appointment1' => $appointment1, 'day' => date('w', strtotime($request->day))]);
    }

    public function schedulefordate($schedule, $procedure, $appointment, $response = []): array
    {
        $accountant = 0;
        $hour_end = Carbon::parse($schedule->hour_strart)->addMinutes($procedure)->toTimeString();
        if ($hour_end <= $schedule->hour_end) :
            if (!($schedule->break_strart < $hour_end && $hour_end <= $schedule->break_end)) :
                foreach ($appointment as $row) :
                    $duration = $row->denpro['procedures']['duration'];
                    $hour_end_appointment = Carbon::parse($row->hour)->addMinutes($duration)->toTimeString();
                    if (!($row->hour < $hour_end && $hour_end <= $hour_end_appointment)) $accountant++;
                endforeach;
                if ($accountant == sizeof($appointment)) array_push($response, ["hour_start" => date("g:i a", strtotime($schedule->hour_strart)), "hour_end" => date("g:i a", strtotime($hour_end))]);
            endif;
            $schedule->hour_strart = $hour_end;
            return $this->schedulefordate($schedule, $procedure, $appointment, $response);
        else :
            return $response;
        endif;
    }

    public function delete(Request $request)
    {
        if ($request->state != 'Pagado') :
            $this->appoinment_repository->changeState($request->id, 'Eliminado');
            return response()->json([
                'status' => 200,
                'msg' => 'Cita eliminada con éxito'
            ]);
        else :
            return response()->json([
                'status' => 422,
                'msg' => 'Acción invalida',
            ]);
        endif;
    }

    public function citasPorPacienteDado(Request $request)
    {
        $appoinments = $this->appoinment_repository->citasPorPacienteDado($request->document);
        return response()->json([
            'appoinments' =>  $appoinments,
        ]);
    }

    public function verify_appoinments(Request $request)
    {
        $patient = $this->patient_repository->patient_by_document($request->document);
        if (!empty($patient)) {
            return response()->json([
                'status' => 200,
                'id' => $patient->id
            ]);
        } else {
            return response()->json([
                'status' => 422,
                'document' => $request->document
            ]);
        }
    }
}
