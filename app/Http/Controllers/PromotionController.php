<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class PromotionController extends Controller
{

    public function view()
    {
        return Inertia::render('Promociones/index');
    }

    public function store(Request $request)
    {
        $rules = [
            'date_start' => 'required',
            'date_end' => 'required',
            'details' => 'required|max:600',
            'discount' => 'required|integer',
            'limit_patients' => 'required|integer|max:300',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) :
            return response()->json([
                'status' => 422,
                'msg' => $validator->errors()->first(),
            ]);
        endif;
        if ($request->id == null) {
            $promocion = new Promotion();
            $promocion->id = Promotion::max('id') + 1;
        } else {
            $promocion = Promotion::find($request->id);
        }
        $promocion->date_start = $request->date_start;
        $promocion->date_end = $request->date_end;
        $promocion->details = $request->details;
        $promocion->discount = $request->discount;
        $promocion->limit_patients = $request->limit_patients;
        $promocion->save();

        return response()->json([
            'status' => 200,
            'msg' => 'Datos guardados con éxito'
        ]);
    }

    public function index()
    {
        $promocion = Promotion::orderByDesc('date_start')->paginate(cant());
        return response()->json([
            'promocion' => $promocion,

        ]);
    }

    public function destroy(Request $request)
    {
        $promocion = Promotion::find($request->id);
        $promocion->status = 0;
        $promocion->save();
    }
}
