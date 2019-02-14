<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ReturnBoxPayment;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\OrderDetailBox;
use App\Model\ChangeBox;
use App\Repositories\ChangeBoxPaymentRepository;
use DB;

class ChangeBoxPaymentController extends Controller
{
    protected $repository;

    public function __construct(ChangeBoxPaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {      
      $data = $this->repository->all();
      return view('payment.change_box.index', compact('data'));
    }

    public function create()
    {
      abort('404');
    }

    public function store(Request $request)
    {
      abort('404');   
    }

    public function show($id)
    {
      abort('404');
    }

    public function edit($id)
    {
      $data     = $this->repository->getById($id);
      return view('payment.change_box.edit', compact('data', 'id'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status_id'  => 'required',
        ]);

        $order_detail_id        = $request->order_detail_id; 
        $status                 = $request->status_id;
        
        $orderdetail            = OrderDetail::find($order_detail_id);
        $orderdetail->status_id = $status;
        $orderdetail->save();
        
        $payment                 = $this->repository->find($id);
        $payment->status_id      = $status;
        $payment->save();

        //change status on table change_boxes
        $order_detail_box = OrderDetailBox::where('order_detail_id', $order_detail_id)->get();
        if(count($order_detail_box) > 0){
            for ($a = 0; $a < count($order_detail_box); $a++) {
                DB::table('change_boxes')->where('order_detail_id', $order_detail_id)->update(['status_id' => $status]);
            }
        }

        if($payment){
            return redirect()->route('change-box-payment.index')->with('success', 'Edit status order change box payment success.');
        } else {
            return redirect()->route('change-box-payment.index')->with('error', 'Edit status order change box payment failed.');
        }
    }

    public function destroy($id)
    {
      
    }
}
