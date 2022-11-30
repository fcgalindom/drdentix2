<?php

namespace App\Repositories;

use App\Models\appointment;
use App\Models\Product;
use Illuminate\Http\Client\Request;

class ProductRepository extends BaseRepository
{
    protected $modelBase;

    public function __construct(Product $modelo)
    {
        $this->modelBase = new BaseRepository($modelo);
        parent::__construct($modelo);
    }
    public function list()
    {
        return $this->model->paginate(cant());
    }

    
}
