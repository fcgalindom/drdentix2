<?php

namespace App\Http\Controllers;

use App\Models\appointment;
use App\Models\Patients;
use App\Models\Procedures;
use App\Repositories\DentistRepository;
use App\Repositories\PatientRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AdministratorCitaController extends Controller
{

    protected $days = [];
    protected $month = [];
    private $patient_repository;
    private $dentistRepository;

    public function __construct(PatientRepository $patient_repository, DentistRepository $dentistRepository)
    {
        $this->patient_repository = $patient_repository;
        $this->dentistRepository = $dentistRepository;
    }

    public function __index__()
    {
        $patients = $this->patient_repository->select2Patient();

        return response()->json([
            'patients' => $patients
        ]);
    }

    public function init_dates()
    {
        $this->days = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado"];
        $this->month = [null, "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    }

    public function index(Request $request)
    {
        $this->init_dates();
        $carbon = Carbon::parse(date('Y-m-d'))->addDays($request->avance);
        $date = [
            "name_day" =>  $this->days[date('w', strtotime($carbon))],
            "day" => $carbon->day,
            "month" => $this->month[$carbon->month],
            "year" => $carbon->year,
        ];

        $carbon = $carbon->format('Y-m-d');

        $citas = appointment::with(['denpro.dentists', 'dPacient.user', 'denpro.procedures', 'dbraches'])
            ->where(function ($query) use ($request, $carbon) {
                if (!empty($request->paciente)) :
                    $query->whereRelation('dPacient', 'name', 'like', "%$request->paciente%")
                        ->orWhere(function ($query) use ($request) {
                            $query->whereRelation('dPacient.user', 'document', 'like', "%$request->paciente%");
                        });
                endif;
                if (!empty($request->dia_fin)) $query->where('day', '<=', $request->dia_fin);
                if (!empty($request->dentist_id)) $query->whereRelation('denpro', 'dentistsF', $request->dentist_id);
                if (!empty($request->estado)) $query->where('state', 'like', "%$request->estado%");
                if (empty($request->dia_inicio) && empty($request->dia_fin) && empty($request->paciente)) $query->where('day', $carbon);
                if (!empty($request->dia_inicio)) $query->where('day', '>=', $request->dia_inicio);
            })
            ->whereNotIn('state', ['Eliminado'])
            ->orderBy(DB::raw($this->driverSQL()));

        if (empty($request->excel)) :

            return response()->json([
                'totales' => $this->ingresos_citas($citas->get()),
                'citas' => $citas->paginate(cant()),
                'date' => $date,
                'procedures' => Procedures::where('state', 'Activo')->orderBy('name')->get(),
            ]);
        else :
            $citas = $citas->get();
            return view('Excel.citas')->with(['citas' => $citas]);
        endif;
    }

    protected function ingresos_citas($array): array
    {
        $total_ingresos = 0;
        $total_citas = 0;
        foreach ($array as $row) :
            if ($row->state == 'Activo' || $row->state == 'Recordado') $total_citas++;
            $total_ingresos += $row->pay;
        endforeach;

        return ['total_ingresos' => $total_ingresos, 'total_citas' => $total_citas];
    }

    public function verCitas($id = null)
    {
        if (!is_null($id)) $patient = $this->patient_repository->find($id)->name;
        else $patient = '';
        $dentist = $this->dentistRepository->select_dentist();

        $patients = $this->patient_repository->select2User();
        return Inertia::render('Administrator/Citas', [
            'id' => $patient,
            'patients' => $patients,
            'dentist' => $dentist
        ]);
    }

    public function driverSQL(): String
    {
        if (env("DB_CONNECTION") == 'mysql') :
            return "FIELD(state, 'Activo', 'Recordado', 'Cancelado', 'No asistio' , 'Pagado')";
        else :
            return "CASE WHEN state = 'Activo' THEN 1
            WHEN state = 'Recordado' THEN 2
            WHEN state = 'Cancelado' THEN 3
            WHEN state = 'No asistio' THEN 4
            WHEN state = 'Pagado' THEN 5
            ELSE 6
            END";
        endif;
    }
}
