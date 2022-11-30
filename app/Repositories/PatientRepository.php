<?php

namespace App\Repositories;

use App\Models\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientRepository extends BaseRepository
{
    protected $modelBase;

    public function __construct(Patients $modelo)
    {
        $this->modelBase = new BaseRepository($modelo);
        parent::__construct($modelo);
    }

    public function list($request)
    {
        $request = new Request($request);
        return $this->model->with(['user'])
            ->withCount(['appoinmets' => function ($query) {
                $query->where('state', 'Pagado');
            }])
            ->where(function ($query) use ($request) {
                if (!empty($request->name)) $query->where('name', 'like', "%$request->name%");
                if (!empty($request->city)) $query->where('city', 'like', "%$request->city%");
                if (!empty($request->document)) $query->whereRelation('user', 'document', 'like', "%$request->document%");
            })
            ->orderByDesc('appoinmets_count')
            ->orderBy('name')
            ->paginate(15);
    }

    public function select2Patient()
    {
        return $this->model->select(['id', 'id_user', 'name'])
            ->with(['user:id,document,state'])->orderBy('name')
            ->whereRelation('user', 'state', 'Activo')->get()
            ->map(function ($value) {
                return [
                    'id' => $value->id,
                    'text' => $value->user->document . ' - ' . $value->name,
                ];
            });
    }

    public function patient_auth()
    {
        return $this->model->where('id_user', Auth::user()->id)->first();
    }

    public function patient_by_document($document)
    {
        if (empty($document)) return null;
        else return $this->model->whereRelation('user', 'document', $document)->first();
    }
}
