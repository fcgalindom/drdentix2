<?php

namespace App\Repositories;

use App\Models\Branch;
use Illuminate\Http\Client\Request;

class BranchRepository extends BaseRepository
{
    protected $modelBase;

    public function __construct(Branch $modelo)
    {
        $this->modelBase = new BaseRepository($modelo);
        parent::__construct($modelo);
    }

    public function list(Request $request = null)
    {
        return $this->model->orderBy('name')->paginate(cant());
    }
}
