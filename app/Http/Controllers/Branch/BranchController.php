<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchStoreRequest;
use App\Repositories\BranchRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BranchController extends Controller
{

    private $branch_repository;

    public function __construct(BranchRepository $branch_repository)
    {
        $this->branch_repository = $branch_repository;
    }

    public function view()
    {
        return Inertia::render('Administrator/Branch');
    }

    public function index()
    {
        $branch = $this->branch_repository->list();
        return response()->json([
            'branch' => $branch,
        ]);
    }


    public function store(BranchStoreRequest $request)
    {
        if ($request->id == 0) :
            $branch = $this->branch_repository->new();
            $branch->id = $this->branch_repository->next_id();
        else :
            $branch = $this->branch_repository->find($request->id);
        endif;

        foreach ($request->all() as $key => $value) $branch[$key] = $value;
        $this->branch_repository->save($branch);

        return response()->json([
            'msg' => 'datos guardados con éxito',
            'status' => 200
        ]);
    }

    public function destroy(Request $request)
    {
        $this->branch_repository->changeState($request->id, $request->state);

        return response()->json([
            'status' => 200,
            'msg' => 'Estado actualizado con éxito',
        ]);
    }
}
