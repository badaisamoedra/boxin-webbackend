<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Setting;
use Validator;
use DB;

class SettingController extends Controller
{
    
    public function index()
    {
        $data   = Setting::get();
        return view('settings.others.index', compact('data'));
    }

    public function create()
    {
        abort('404');
    }

    public function show($id)
    {
      abort('404');
    }

    public function edit($id)
    {
        $data = Setting::select(array('settings.*'))->get();
        return view('settings.others.edit', compact('data', 'id'));
    }

    public function update(Request $request, $id)
    {
        $data          = Setting::find($id);
        $data->area_id = $area_id;
        $data->fee     = $request->fee;
        $data->save();

        if($data){
            return redirect()->route('delivery-fee.index')->with('success', 'Edit Data Delivery Fee success.');
        } else {
            return redirect()->route('delivery-fee.index')->with('error', 'Edit Data Delivery Fee failed.');
        }
    }

    public function destroy($id)
    {
      
    }
}
