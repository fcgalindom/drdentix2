<?php

namespace App\Repositories;

use App\Models\Procedures;
use Illuminate\Http\Client\Request;

class ProcedureRepository extends BaseRepository
{
    protected $modelBase;

    public function __construct(Procedures $modelo)
    {
        $this->modelBase = new BaseRepository($modelo);
        parent::__construct($modelo);
    }

    public function list(Request $request = null)
    {
        return $this->model->orderBy('name')->paginate(cant());
    }
}
