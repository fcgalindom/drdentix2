<?php

namespace App\Repositories;

use App\Models\appointment;
use Illuminate\Http\Client\Request;

class AppoinmentRepository extends BaseRepository
{
    protected $modelBase;

    public function __construct(appointment $modelo)
    {
        $this->modelBase = new BaseRepository($modelo);
        parent::__construct($modelo);
    }

    public function appoinment_x_patient($id, $states = [])
    {
        return $this->model->with(['dPacient', 'denpro.dentists', 'denpro.procedures', 'dbraches'])
            ->where('patientsF', $id)
            ->where(function ($query) use ($states) {
                $query->whereIn('state', $states);
            })
            ->orderByDesc('day')
            ->orderByDesc('hour')
            ->get();
    }

    public function citasPorPacienteDado($document)
    {
        return $this->model->with(['dPacient.user', 'denpro.dentists.user', 'denpro.procedures', 'dbraches', 'facturas'])
            ->whereRelation('dPacient.user', 'document', $document)
            ->orderByDesc('day')
            ->orderByDesc('hour')
            ->orderByDesc('id')
            ->paginate(cant());
    }
    public function verify_appoinments($request)
    {
        $appoiments = $this->model->with(['dPacient.user', 'denpro.dentists.user', 'denpro.procedures', 'dbraches', 'facturas'])
            ->whereRelation('dPacient.user', 'document', $request->document)
            ->orderByDesc('day')
            ->orderByDesc('hour')
            ->orderByDesc('id')
            ->get();

        // ->paginate(cant());

        return $appoiments;
    }
}
