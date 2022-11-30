<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcedureRequest;
use App\Repositories\ProcedureRepository;
use Illuminate\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ProcedureController extends Controller
{

    private $procedure_repository;

    public function __construct(ProcedureRepository $procedure_repository)
    {
        $this->procedure_repository = $procedure_repository;
    }

    public function view()
    {
        return Inertia::render('Administrator/Procedure');
    }

    public function index()
    {
        $procedures = $this->procedure_repository->list();
        return response()->json([ 'procedures' => $procedures ]);
    }

    public function store(ProcedureRequest $request)
    {
        try {
            DB::beginTransaction();

            if ($request->id == 0) :
                $procedure = $this->procedure_repository->new();
                $procedure->id = $this->procedure_repository->next_id();
            else :
                $procedure = $this->procedure_repository->find($request->id);
            endif;

            $procedure->name = $request->name;
            $procedure->duration = $request->duration;
            $this->procedure_repository->save($procedure);

            DB::commit();

            return response()->json([
                'status' => 200,
                'msg' => 'Datos guardados con éxito'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'msg' => 'Error en el servidor'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $this->procedure_repository->changeState($request->id, $request->state);

        return response()->json([
            'status' => 200,
            'msg' => 'Estado actualizado con éxito',
        ]);
    }
}
