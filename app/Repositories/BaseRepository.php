<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id, $with = [])
    {
        return $this->model->with($with)->find($id);
    }

    public function new()
    {
        return new $this->model();
    }

    public function next_id($column = 'id')
    {
        return $this->model->max($column) + 1;
    }

    public function save(Model $model)
    {
        $model->save();

        return $model;
    }

    public function delete($id)
    {
        $model = $this->model->find($id);
        $model->delete();

        return $model;
    }

    public function changeState($id, $estado, $with = [], $column = 'state')
    {
        $model = $this->model->with($with)->find($id);
        $model[$column] = $estado;
        $model->save();

        return $model;
    }

    public function select2($text = 'name')
    {
        return $this->model->where('state', 'Activo')->get()->map(function ($value) use ($text) {
            return [
                'id' => $value->id,
                'text' => $value[$text]
            ];
        });
    }

    public function select2User($text = 'name')
    {
        return $this->model->whereRelation('user', 'state', 'Activo')->get()->map(function ($value) use ($text) {
            return [
                'id' => $value->id,
                'text' => $value[$text]
            ];
        });
    }

    public function select($order = 'name')
    {
        return $this->model->orderBy($order)->where('state', 'Activo')->get();
    }

    public function active_data($key = 'state', $value = 1)
    {
        $this->model->where($key, $value)->get();
    }

    // public function pdf($vista, $data = [], $nombre = 'archivo', $is_stream = true)
    // {
    //     $pdf = \PDF::loadview($vista, compact('data'));

    //     $nombre =  $nombre . '.pdf';
    //     if ($is_stream) return $pdf->stream($nombre);
    //     else return $pdf->download($nombre);
    // }
}
