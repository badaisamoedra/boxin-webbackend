<?php

namespace App\Repositories;

use App\Model\Shelves;
use App\Model\AdminArea;
use App\Repositories\Contracts\ShelvesRepository as ShelvesRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;

class ShelvesRepository implements ShelvesRepositoryInterface
{
    protected $model;

    public function __construct(Shelves $model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function all()
    {
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $data = $this->model->query();
        $data = $data->select('shelves.id', 'shelves.name', 'shelves.space_id', 'shelves.id_name');
        $data = $data->leftJoin('spaces', 'spaces.id', '=', 'shelves.space_id');
        $data = $data->leftJoin('areas', 'areas.id', '=', 'spaces.area_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->where('areas.id', $admin->area_id);
        }
        $data = $data->where('shelves.deleted_at', NULL);
        $data = $data->where('areas.deleted_at', NULL);
        $data = $data->orderBy('shelves.updated_at', 'DESC')->orderBy('shelves.id','DESC');
        $data = $data->get();
        return $data;
    }

    public function getCount($args = [])
    {
        return $this->model->where('name', 'like', $args['searchValue'].'%')->count();
    }
    public function getData($args = [])
    {
        $space = $this->model->select()
                ->orderBy($args['orderColumns'], $args['orderDir'])
                ->where('name', 'like', '%'.$args['searchValue'].'%')
                ->skip($args['start'])
                ->take($args['length'])
                ->get();

        return $space->toArray();
    }

    public function getSelectBySpace($space_id)
    {
        $shelves = $this->model->select()->where('space_id', $space_id)->where('deleted_at', NULL)->orderBy('name')->get();

        return $shelves;
    }

    public function getSelectByArea($area_id)
    {
        $shelves = $this->model->select()->where('area_id', $area_id)->where('deleted_at', NULL)->orderBy('name')->get();

        return $shelves;
    }

    public function getSelectAll($args = [])
    {
        $data = $this->model->select()->where('deleted_at', NULL)->orderBy('name')->get();

        return $data;
    }

    public function getEdit($id)
    {
        $data = $this->model->select(array('shelves.*',
            DB::raw('(cities.id) as city_id'), DB::raw('(cities.id_name) as city_id_name'),
            DB::raw('(areas.id) as area_id'), DB::raw('(areas.id_name) as area_id_name'),
            DB::raw('(spaces.id) as space_id'), DB::raw('(spaces.id_name) as space_id_name')))
                ->leftJoin('spaces', 'spaces.id', '=', 'shelves.space_id')
                ->leftJoin('areas', 'areas.id', '=' ,'spaces.area_id')
                ->leftJoin('cities', 'cities.id', '=', 'areas.city_id')
                ->where('shelves.id', $id)
                ->first();

        return $data;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(Shelves $shelves, $data)
    {
        return $shelves->update($data);
    }

    public function delete(Shelves $shelves)
    {
        return $shelves->delete();
    }
}
