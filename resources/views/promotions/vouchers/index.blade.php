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
        <h3 class="text-themecolor">Vouchers</h3>
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

            <h4 class="card-title"><span class="lstick"></span>List Vouchers
              <a href="{{ route('voucher.create') }}" class="btn waves-effect waves-light btn-sm btn-primary pull-right" title="Add" style="margin-right: 10px;"><i class="fa fa-plus"></i>&nbsp;Add Voucher</a>
            </h4>

            @include('error-template')

            <div class="table-responsive m-t-10">
                <table id="table-type" class="table table-striped table-bordered">
                  <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th width="25%" class="text-center">Name (Code) </th>
                        <th width="10%">Value</th>
                        <th width="15%">Percent/Nominal</th>
                        <th width="">Valid Voucher</th>
                        <th width="5%">Status</th>
                        <th width="10%" class="text-center no-sort">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    @if (count($data) > 0)
                      @foreach ($data as $key => $value)
                        <tr>
                          <td align="center">{{ $key+1 }}</th>
                          <td>{{ $value->name }} ({{ $value->code }})</td>
                          <td>{{ $value->type_voucher == 1 ? $value->value : number_format($value->value, 0, '', '.') }}</td>
                          <td>{{ $value->type_voucher == 1 ? 'Percent' : 'Nominal' }}</td>
                          <td></td>
                          <td class="text-center">
                            <span class="label {{ $value->status_id == 20 ? 'label-success' : 'label-danger' }} label-rounded">{{ $value->status->name  }}</span>
                          </td>
                          <td class="text-center">
                            <form action="{{route('voucher.destroy', ['id' => $value->id])}}" method="post">
                              @csrf
                              <a class="btn btn-info btn-sm" href="{{route('voucher.edit', ['id' => $value->id])}}"><i class="fa fa-pencil"></i></a>
                              @method('DELETE')
                              <button type="submit" name="remove" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
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
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
                        </div>
                        <div class="modal-body" style="text-align: center;">
                            <h4>[Delete]</h4>
                            <p>Are you sure to delete this voucher ?</p>
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


<script>
$(function() {
  $('#table-type').DataTable({
    "aaSorting": []
  });
});
</script>
@endsection
