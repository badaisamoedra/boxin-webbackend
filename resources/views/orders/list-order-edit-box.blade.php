@extends('layouts.master')

@section('plugin_css')
  <!-- page css -->
  <link href="{{asset('assets/css/pages/user-card.css')}}" rel="stylesheet">
  <!-- Popup CSS -->
  <link href="{{asset('assets/plugins/Magnific-Popup-master/dist/magnific-popup.css')}}" rel="stylesheet">
@endsection

@section('script_css')

@endsection

@section('content')
<div class="container-fluid">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
@include('error-template')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">
          Order Edit {{ $detail->types_of_box_room_id == 1 ? 'Box' : 'Space' }}
        </h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
          <button onclick="window.location.href='{{ URL::previous() }}'" class="btn waves-effect waves-light m-r-10" style="background-color: white;"><i class="mdi mdi-arrow-left-bold-circle"></i> Back</button>
        </ol>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->


<div class="col-12">
    <div class="card">
        <div class="card-header">
            <b>Detail Data</b>
            <div class="card-actions" style="float: right;">
                <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
            </div>
        </div>
        <div class="card-body collapse show">
            
            <h5 class="card-title"><span class="lstick"></span><b>* Data Order</b></h5>
            <form class="form-material row">
                <div class="form-group col-md-2">
                    <label for="inputEmail3" class="text-right control-label col-form-label">Order ID</label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control form-control-line" value="{{ $detail->id_name }}" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputEmail3" class="text-right control-label col-form-label">Name {{ $detail->type_size->name }}</label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control form-control-line" value="{{ $detail->name }}" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputEmail3" class="text-right control-label col-form-label">Duration</label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control form-control-line" value="{{ $detail->duration }} {{ $detail->type_duration->alias }}" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputEmail3" class="text-right control-label col-form-label">Amount</label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control form-control-line" value="Rp. {{ number_format($detail->amount, 2, '.', ',') }}" readonly>
                </div>
            </form>
            <form class="form-material" action="{{ route('order.orderDetailBox.updatePlace', ['id' => $id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="inputEmail3" class="text-right control-label col-form-label">Start Date</label>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="date" class="form-control form-control-line" name="start_date" value="{{ $detail->start_date }}">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputEmail3" class="text-right control-label col-form-label">End Date</label>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="date" class="form-control form-control-line" name="end_date" value="{{ $detail->end_date }}">
                    </div>
                </div>

                <h5 class="card-title"><span class="lstick"></span><b>* Data {{ $detail->types_of_box_room_id == 1 ? 'Box' : 'Space' }}</b></h5>
                <div class="row">    
                    <div class="form-group col-md-2">
                        <label for="inputEmail3" class="text-right control-label col-form-label">{{ $detail->types_of_box_room_id == 1 ? 'Box' : 'Space' }} ID</label>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" name="box_or_space_code" class="form-control form-control-line" value="{{ $detail->types_of_box_room_id == 1 ? (isset($detail->box->code_box) ? $detail->box->code_box : '') : (isset($detail->space->code_space_small) ? $detail->space->code_space_small : '') }}">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputEmail3" class="text-right control-label col-form-label">Name </label>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control form-control-line" value="{{ $detail->types_of_box_room_id == 1 ? (isset($detail->box->name) ? $detail->box->name : '') : (isset($detail->space->name) ? $detail->space->name : '') }}" readonly>
                    </div>
                
                
                    <div class="form-group col-md-2">
                        <label for="inputEmail3" class="text-right control-label col-form-label">Place </label>
                    </div>
                    <div class="form-group col-md-4">
                        <select name="place" type="text" class="form-control form-control-line">
                            <option value="warehouse" {{ ($detail->place != 'warehouse') ? '' : 'selected' }}>Warehouse</option>
                            <option value="house" {{ ($detail->place != 'warehouse') ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="row el-element-overlay">
    @foreach ($detail_order_box as $key => $value)
      @if ($value->status_id == 9)
      <div class="col-lg-3 col-md-6">
          <div class="card">
              <div class="el-card-item">
                  <div class="el-card-avatar el-overlay-1"> <img src="{{ $value->images }}" alt="user" />
                      <div class="el-overlay">
                          <ul class="el-info">
                              <li><a class="btn default btn-outline image-popup-vertical-fit" href="{{ $value->images }}"><i class="icon-magnifier"></i></a></li>
                              <li><a class="btn default btn-outline" href="javascript:void(0);"><i class="icon-link"></i></a></li>
                          </ul>
                      </div>
                  </div>
                  <div class="el-card-content">
                    <h3 class="box-title">{{ $value->item_name }}</h3> <small>{{ $value->note }}</small>
                      <br/>
                  </div>
              </div>
          </div>
      </div>
      @endif
    @endforeach

</div>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
</div>
@endsection

@section('close_html')
<!--PLUGIN JS -->


<!--END PLUGIN JS -->


<!--SCRIPT JS -->
<script>
$(function() {
  $('#table-ingrd').DataTable({
    "aaSorting": []
  });


});
</script>
<!-- Magnific popup JavaScript -->
<script src="{{asset('assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js')}}"></script>
@endsection
