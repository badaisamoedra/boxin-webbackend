@extends('layouts.master')

@section('plugin_css')

@endsection

@section('script_css')

@endsection

@section('content')
<div class="container-fluid">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">List Warehouse</h3>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

              <h4 class="card-title"><span class="lstick"></span>Edit Warehouse</h4>

              @include('error-template')

              <form action="{{ route('warehouses.update', ['id' => $id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-8">

                      <div class="form-group">
                        <label for="">Area <span class="text-danger">*</span></label>
                        <select class="form-control" id="select2" name="area_id" required>
                          @if (!empty($area))
                            @foreach ($area as $key => $value)
                              @if ($value->id == $warehouse->area_id)
                                <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                              @else
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                              @endif
                            @endforeach
                          @endif
                        </select>
                      </div>

                      <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ $warehouse->name }}" required>
                      </div>

                      <div class="form-group">
                        <label>Latitude </label>
                        <input type="text" name="latitude" class="form-control" placeholder="Enter Latitude" value="{{ $warehouse->lat }}" >
                      </div>

                      <div class="form-group">
                        <label>Longitude </label>
                        <input type="text" name="longitude" class="form-control" placeholder="Enter Longitude" value="{{ $warehouse->long }}" >
                      </div>
  
                      <hr>
                      <a href="{{ route('warehouses.index') }}" class="btn btn-secondary waves-effect waves-light m-r-10">Back</a>
                      <button type="submit" class="btn btn-info waves-effect waves-light m-r-10"><i class="fa fa-pencil"></i> Edit</button>
                    </div>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->

</div>
@endsection

@section('close_html')
<!--PLUGIN JS -->

<script>
$(function() {

});
</script>
@endsection