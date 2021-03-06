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
        <h3 class="text-themecolor">
          Spaces
        </h3>
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

                <h4 class="card-title"><span class="lstick"></span>List Spaces</h4>

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <table id="table-ingrd" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="10%" class="text-center">Code Number</th>
                          <th width="">Name</th>
                          <th width="10%">Type</th>
                          <th width="12%">Size</th>
                          <th width="15%">Shelves</th>
                          <th width="20%">Location</th>
                          <th width="10%">Status</th>
                          <th width="13%" class="text-center no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
              </div>

              <!-- sample modal content -->
              <div class="modal fade bs-example-modal-lg" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" style="display: none;">
                  <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h4 class="modal-title" id="myLargeModalLabel">Confirmation</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
                          </div>
                          <div class="modal-body" style="text-align: center;">
                              <h4>[Delete]</h4>
                              <p>Are you sure to delete this space ?</p>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">Close</button>
                              <button type="button" data-dismiss="modal" class="btn btn-danger" id="delete">Delete</button>
                          </div>
                      </div>
                      <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->

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


<!--END PLUGIN JS -->


<!--SCRIPT JS -->
<script>
$(function() {

    function action(id){
        $action = '<a class="btn btn-secondary btn-sm" href="{{route('space.index')}}/barcode/' + id + '" target="_blank" title="Print Barcode" style="margin-right:5px;"><i class="mdi mdi-barcode"></i></a>';
        return $action;
    }

    var $table = $('#table-ingrd').dataTable( {
        "autoWidth": true,
        "processing": true,
        "serverSide": true,
        "bFilter": true,
        "order": [[ 2, "desc" ]],
        "columnDefs": [
            { "name": "no", "sClass": "center", "targets": 0, "visible": false },
            { "name": "code_space_small", "targets": 1 },
            { "name": "space_smalls.name",  "targets": 2 },
            { "name": "type_size_name", "targets": 3 },
            { "name": "type_size_size", "targets": 4 },
            { "name": "shelves_name", "sClass": "center", "targets": 5 },
            { "name": "location", "sClass": "right",  "targets": 6 },
            { "name": "status_name", "sClass": "right",  "targets": 7 },
        ],
        "ajax": {
            "url": "{{ route('dashboard.space.ajax') }}",
            "type": "POST",
            "data": function ( d ) {
                d._token = $('meta[name="_token"]').attr('content');
                d.category = $('#category_serch').val();
                // etc
            }
        },
        "oLanguage": {
            "sProcessing": "<div style='top:15%; position: fixed; left: 20%;'><img src='{{asset('assets/images/preloader.gif')}}'></div>"
        },

        "columns": [
            { "data": "no", "bSortable": false },
            { "data": "code_space_small", "bSortable": true },
            { "data": "name", "bSortable": true },
            { "data": "type_size_name", "bSortable": false },
            { "data": "type_size_size", "bSortable": true },
            { "data": "shelves_name", "bSortable": true, "sClass": "right" },
            { "data": "location", "bSortable": true, "sClass": "right" },
            { "data": function ( row, type, val, meta ) { var labelStatus = (row.status_name == 'Empty') ? 'label-warning' : 'label-success'; return '<span class="label ' + labelStatus + ' label-rounded">' + row.status_name + '</span>'; }, "bSortable": false },
            { "data": function ( row, type, val, meta ) { return "" + action(row.id)  ; }, "sClass": "center", "bSortable": false },
        ],
        "initComplete": function( settings, json ) {
            //  $('.count_act').html($count_active);
        }
    });
});
</script>
@endsection
