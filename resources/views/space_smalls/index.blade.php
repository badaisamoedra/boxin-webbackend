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

                <h4 class="card-title"><span class="lstick"></span>List Spaces
              <a href="{{ route('space.create') }}" class="btn waves-effect waves-light btn-sm btn-primary pull-right"
                title="Add" style="margin-right: 10px;">
                <i class="fa fa-plus"></i>&nbsp;
                Add Space
              </a>
            </h4>

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
                      @if (count($data) > 0)
                        @foreach ($data as $key => $value)
                          <tr>
                            <td align="center">{{ $key+1 }}</th>
                            <td align="center">{{ $value->id_name }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->type_size->name }}</td>
                            <td>{{ $value->type_size->size }}</td>
                            <td>{{ $value->shelves->name }}</td>
                            <td>{{ $value->location }}</td>
                            <td class="text-center">
                              <span class="label {{ $value->status->name == 'Empty' ? 'label-warning' : 'label-success' }} label-rounded">{{ $value->status->name }}</span>
                            </td>
                            <td class="text-center">
                              <form action="{{route('space.destroy', ['id' => $value->id])}}" method="post">
                                @csrf
                                <a class="btn btn-secondary btn-sm" href="{{route('space.barcode', ['id' => $value->id])}}" target="_blank" title="Print Barcode"><i class="mdi mdi-barcode"></i></a>
                                <a class="btn btn-info btn-sm" href="{{route('space.edit', ['id' => $value->id])}}" title="Edit"><i class="fa fa-pencil"></i></a>
                                @method('DELETE')
                                <button type="submit" name="remove" class="btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></button>
                              </form>
                            </td>
                          </tr>
                        @endforeach
                      @endif
                    </tbody>
                </table>
              </div>

              <!-- sample modal content -->
              <div class="modal fade bs-example-modal-lg" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" style="display: none;">
                  <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h4 class="modal-title" id="myLargeModalLabel">Confirmation</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
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
  $('#table-ingrd').DataTable({
    "aaSorting": []
  });


});
</script>
@endsection
