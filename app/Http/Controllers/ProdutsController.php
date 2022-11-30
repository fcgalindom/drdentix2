<?php

namespace App\Http\Controllers;

use App\Models\Product;

use App\Repositories\ProductRepository;

use Illuminate\Http\Request;

use Inertia\Inertia;

use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;

class ProdutsController extends Controller
{
    private  $productRepository;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function view()
    {
        return Inertia::render('Productions/index');
    }
    public function index()
    {
        $products = $this->productRepository->list();
        return response()->json([
            'products' => $products,
        ]);
    }
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ])->validate();

        if ($request->id == 0) :
            $product = new Product();
            $product->id = $this->productRepository->next_id();


        else :
            $product = Product::find($request->id);
        endif;


        foreach ($request->all() as $key => $value) $product[$key] = $value;


        $date = Carbon::parse($request->expiration_date);
        $now = Carbon::now();

        $diff = $date->diffInMonths($now);





        if ($diff >= 12) {
            $product->semaphore = 'verde';
        } else if ($diff >= 3 &&  $diff <= 6) {
            $product->semaphore = 'amarillo';
        } else {
            $product->semaphore = 'rojo';
        }


        $this->productRepository->save($product);










        return response()->json([
            'msg' => 'datos guardados con éxito',
            'status' => 200
        ]);
    }

    public function destroy(Request $request)
    {
        $this->productRepository->changeState($request->id, $request->state);

        return response()->json([
            'status' => 200,
            'msg' => 'Estado actualizado con éxito',
        ]);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
}
