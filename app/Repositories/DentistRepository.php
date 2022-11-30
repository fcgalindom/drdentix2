<?php

namespace App\Repositories;

use App\Models\Dentist;
use Illuminate\Http\Request;

class DentistRepository extends BaseRepository
{
    protected $modelBase;

    public function __construct(Dentist $modelo)
    {
        $this->modelBase = new BaseRepository($modelo);
        parent::__construct($modelo);
    }

    public function list($request)
    {

        $request = new Request($request);

        return $this->model->with(['user', 'procedures'])
            ->where(function ($query) use ($request) {
                if (!empty($request->name)) $query->where('name', 'like', "%$request->name%");
                if (!empty($request->city)) $query->where('city', 'like', "%$request->city%");
                if (!empty($request->document)) $query->whereRelation('user', 'document', 'like', "%$request->document%");
            })
            ->orderBy('name')
            ->paginate(cant());
    }

    public function select_dentist()
    {
        return $this->model->select(['id', 'name'])->whereRelation('user', 'state', 'Activo')->orderBy('name')->get();
    }

}
