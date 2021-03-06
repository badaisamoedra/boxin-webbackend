<?php

namespace App\Repositories;

use App\Model\Box;
use App\Model\AdminArea;
use App\Repositories\Contracts\BoxRepository as BoxRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;

class BoxRepository implements BoxRepositoryInterface
{
    protected $model;

    public function __construct(Box $model)
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
        $data = $data->select('boxes.*');
        if(Auth::user()->roles_id == 2){
            $data = $data->leftJoin('shelves', 'shelves.id', '=', 'boxes.shelves_id');
            $data = $data->where('shelves.area_id', $admin->area_id);
        }
        $data = $data->where('boxes.deleted_at', NULL);
        $data = $data->orderBy('boxes.updated_at', 'DESC')->orderBy('boxes.id','DESC');
        $data = $data->get();
        return $data;
    }

    public function getById($id)
    {
        return $this->model->where('deleted_at', NULL)->where('id', $id)->get();
    }

    public function getCount($args = [])
    {
        $query = $this->model->query();
        $query->join("types_of_size", "types_of_size.id", "boxes.types_of_size_id");
        $query->join("shelves", "shelves.id", "boxes.shelves_id");
        $query->join('areas', 'areas.id', '=', 'shelves.area_id');
        $query->join("status", "status.id", "boxes.status_id");
        $query->where('boxes.name', 'like', $args['searchValue'].'%');
        if($args['shelves_id']){
            $query->where('boxes.shelves_id', $args['shelves_id']);
        }
        $query->whereNull('boxes.deleted_at');
        $query->whereNull('shelves.deleted_at');
        $query->whereNull('areas.deleted_at');
        return $query->count();
    }
    
    public function getData($args = [])
    {

        $query = $this->model->query();
        $query->select("boxes.*", "types_of_size.name as type_size_name",
                                     "types_of_size.size", "shelves.name as shelves_name",
                                     "status.name as status_name", "areas.name as area_name");
        $query->join("types_of_size", "types_of_size.id", "boxes.types_of_size_id");
        $query->join("shelves", "shelves.id", "boxes.shelves_id");
        $query->join('areas', 'areas.id', '=', 'shelves.area_id');
        $query->join("status", "status.id", "boxes.status_id");
        $query->orderBy($args['orderColumns'], $args['orderDir']);
        $query->where('boxes.name', 'like', '%'.$args['searchValue'].'%');
        if($args['shelves_id']){
            $query->where('boxes.shelves_id', $args['shelves_id']);
        }
        $query->whereNull('boxes.deleted_at');
        $query->whereNull('shelves.deleted_at');
        $query->whereNull('areas.deleted_at');
        $query->skip($args['start']);
        $query->take($args['length']);
        $data = $query->get();

        return $data->toArray();

    }

    public function getDatas($args = [])
    {
        $query = $this->model->query();
        $query->select('boxes.*');
        $query->leftJoin('shelves', 'shelves.id', '=', 'boxes.shelves_id');

        if(isset($args['orderColumns']) && isset($args['orderDir'])){
            $query->orderBy($args['orderColumns'], $args['orderDir']);
        }
        if(isset($args['status_id'])){
            $query->where('boxes.status_id', $args['status_id']);
        }
        if(isset($args['area_id'])){
            $query->where('shelves.area_id', $args['area_id']);
        }
        if(isset($args['types_of_size_id'])){
            $query->where('boxes.types_of_size_id', $args['types_of_size_id']);
        }
        if(isset($args['start'])){
            $query->skip($args['start']);
        }
        if(isset($args['length'])){
            $query->take($args['length']);
        }
        $query->where('boxes.deleted_at', NULL);
        $box = $query->get();

        return $box;

    }

    public function getEdit($id)
    {
        $data = $this->model->select(array('boxes.*',
                DB::raw('(cities.id) as city_id'), DB::raw('(cities.id_name) as city_id_name'),
                DB::raw('(areas.id) as area_id'), DB::raw('(areas.id_name) as area_id_name'),
                DB::raw('(shelves.id) as shelves_id'), 'shelves.code_shelves'))
                ->leftJoin('shelves', 'shelves.id', '=', 'boxes.shelves_id')
                ->leftJoin('areas', 'areas.id', '=' ,'shelves.area_id')
                ->leftJoin('cities', 'cities.id', '=', 'areas.city_id')
                ->where('boxes.id', $id)
                ->first();

        return $data;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(Box $box, $data)
    {
        return $box->update($data);
    }

    public function delete(Box $box)
    {
        return $box->delete();
    }
}
