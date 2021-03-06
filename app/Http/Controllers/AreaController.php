<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Area;
use App\Model\City;
use App\Model\Space;
use App\Model\Shelves;
use App\Model\Box;
use App\Model\Price;
use App\Model\DeliveryFee;
use Carbon;
use App\Repositories\AreaRepository;
use DB;

class AreaController extends Controller
{
    protected $repository;

    public function __construct(AreaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
      $area   = $this->repository->all();
      return view('areas.index', compact('area'));
    }

    public function create()
    {
      abort('404');
    }

    public function store(Request $request)
    {
      $split    = explode('##', $request->city_id);
      $city_id  = $split[0];

      $area = Area::create([
        'name'      => $request->name,
        'city_id'   => $city_id,
        'id_name'   => $request->id_name_area,
        'latitude'  => $request->latitude,
        'longitude' => $request->longitude,
      ]);

      if($area){
        $this->repository->insertDeliveryFee($area->id);
        $this->repository->insertPrice($area->id);
        return redirect()->route('area.index')->with('success', 'Area ['.$request->name.'] added.');
      } else {
        return redirect()->route('area.index')->with('error', 'Add New Area failed.');
      }
    }

    public function show($id)
    {
      abort('404');
    }

    public function edit($id)
    {
      $area   = $this->repository->find($id);
      return view('areas.edit', compact('area', 'id'));
    }

    public function update(Request $request, $id)
    {
      $split      = explode('##', $request->city_id);
      $city_id    = $split[0];

      $area             = $this->repository->find($id);
      $area->name       = $request->name;
      $area->latitude   = $request->latitude;
      $area->longitude  = $request->longitude;
      if($area->city_id != $city_id){
        $area->city_id = $city_id;
        $area->id_name = $request->id_name_area;
      }
      $area->save();

      if($area){
        return redirect()->route('area.index')->with('success', 'Area ['.$request->name.'] edited.');
      } else {
        return redirect()->route('area.index')->with('error', 'Edit Area failed.');
      }

    }

    public function destroy($id)
    {

      //delete area
      $area = $this->repository->find($id);
      $name = $area->name;
      $area->deleted_at = Carbon\Carbon::now();
      $area->save();

      $shelves          = Shelves::where('area_id', $id)->get();

      if(count($shelves) > 0){
          return redirect()->route('area.index')->with('error', "Can't delete area, the area has a relation to the shelves");
      }
      // foreach ($shelves as $k => $v) {

      //     //delete box
      //     $boxes       = Box::where('shelves_id', $v->id)->get();
      //     foreach ($boxes as $key => $val) {
      //       $box = Box::find($val->id);
      //       $box->deleted_at = Carbon\Carbon::now();
      //       $box->save();
      //     }

      //     //delete shelves
      //     $shelves = Shelves::find($v->id);
      //     $shelves->deleted_at = Carbon\Carbon::now();
      //     $shelves->save();
      // }

      //delete price
      $now = Carbon\Carbon::now();
      Price::where('area_id', $id)->update(['deleted_at' => $now]);
      
      //delete delivery-fee
      $deliveryfee_       = DeliveryFee::where('area_id', $id)->get();
      $count_deliveryfee  = count($deliveryfee_);
      for ($d = 0; $d < $count_deliveryfee; $d++) {
        $deliveryfee = DeliveryFee::find($deliveryfee_[$d]->id);
        $deliveryfee->deleted_at = Carbon\Carbon::now();
        $deliveryfee->save();
      }

      if($area){
        return redirect()->route('area.index')->with('success', 'Area ['.$name.'] deleted.');
      } else {
        return redirect()->route('area.index')->with('error', 'Delete Area failed.');
      }

    }

    public function getDataSelectByCity($city_id, Request $request)
    {
        $areas = $this->repository->getSelect($city_id);
        $arrAreas = array();
        foreach ($areas as $arrVal) {
            $arr = array(
                      'id'    => $arrVal->id . '##' . $arrVal->id_name,
                      'text'  =>  $arrVal->name);
            $arrAreas[] = $arr;
        }
        echo(json_encode($arrAreas));
    }

    public function getDataSelectAll(Request $request)
    {
        $areas = $this->repository->getSelectAll();
        $arrAreas = array();
        foreach ($areas as $arrVal) {
            $arr = array(
                      'id'    => $arrVal->id . '##' . $arrVal->id_name,
                      'text'  =>  $arrVal->name);
            $arrAreas[] = $arr;
        }
        echo(json_encode($arrAreas));
    }

    public function getNumber(Request $request)
    {
        $sql     = Area::where('city_id', '=', $request->input('city_id'))->where('deleted_at', NULL)->orderBy('id_name', 'desc')->first();
        $id_number   = isset($sql->id_name) ? substr($sql->id_name, 2) : 0;
        $code        = str_pad($id_number + 1, 2, "0", STR_PAD_LEFT);

        return $code;
    }

}
