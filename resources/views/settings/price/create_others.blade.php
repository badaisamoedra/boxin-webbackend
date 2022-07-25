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
        <h3 class="text-themecolor">Add Price Others</h3>
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

              @include('error-template')

              <form action="{{ route('price.store') }}" method="POST" enctype="application/x-www-form-urlencoded">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                      
                      <input type="hidden" class="form-control" id="type_of_box_room_id" name="type_of_box_room_id" value="3">

                      <div class="form-group">
                        <label for="">City <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="city_id" name="city_id" required>
                      </div>

                      <div class="form-group">
                        <label for="">Area <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="area_id" name="area_id" required>
                      </div>

                      <div class="form-group">
                        <label for="">Size <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="typeShelves" name="type_shelves" required>
                          
                        </select>
                      </div>
                    
                      <div class="form-group">
                        <label for="">Duration Price :</label>
                      </div>

                      <div class="form-group row">
                        <div class="col-md-3">
                          <label>Weekly <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                          <input type="number" name="weekly_price" class="form-control" placeholder="Enter Weekly Price"  value="0" min="0" required>
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-md-3">
                          <label>Monthly <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                          <input type="number" name="monthly_price" class="form-control" placeholder="Enter Monthly Price"  value="0" min="0" required>
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-md-3">
                          <label>6month <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                          <input type="number" name="sixmonth_price" class="form-control" placeholder="Enter 6month Price" value="0" min="0" required>
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-md-3">
                          <label>Annual <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                          <input type="number" name="annual_price" class="form-control" placeholder="Enter Annual Price" value="0" min="0" required>
                        </div>
                      </div>

                      <button type="submit" class="btn btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Save</button>
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
<script type="text/javascript">  

  $(document).ready( function() {
 
        var typeOfSize = $('#typeShelves');
        typeOfSize.empty().trigger('change');
        typeOfSize.prepend($(`<option></option>`).html('Loading...'))
        $.ajax({
            url: "{{ url('/shelves/get-shelves') }}",
            dataType: "json",
            type: "GET",
            data: {},
            error: function(res, xhr, status) {
                console.log(res)
            }
        }).then(function(res) {
            typeOfSize.empty();
            $.each(res, (i, data) => {
                typeOfSize.append(
                    `<option value="${data.id}">${data.name}</option>`
                )
            })
        }); 

  });
</script>
@endsection
