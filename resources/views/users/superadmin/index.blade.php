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
          Super Admin
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
            <div class="card-header">
                <b>Add Super Admin</b>
                <div class="card-actions" style="float: right;">
                    <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                    <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                </div>
            </div>
            <div class="card-body collapse show">
              
              @include('error-template')

              <form action="{{ route('user.superadmin.store') }}" method="POST" enctype="application/x-www-form-urlencoded">
                @csrf
                <div class="row">
                    <div class="col-md-10">
                      <!-- <div class="form-group">
                        <label for="">User <span class="text-danger">*</span></label>
                        <input type="hidden" class="form-control" id="roles_id" name="roles_id" value="3">
                        <input type="text" class="form-control" id="superadmin_id" name="superadmin_id" required>
                      </div> -->
                      <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label for="">First Name <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label for="">Last Name <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label for="">Email <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="email" name="email" required  >
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label for="">Phone <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label for="">Password</label>
                              <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label for="">Password Confirmation</label>
                              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-3">
                            <div class="form-group">
                              <label for="">Status</label>
                              <select class="form-control"  name="status" id="status">
                                  <option value="1">Aktif</option>
                                  <option value="2">Non Aktif</option>
                              </select>
                            </div>
                          </div>
                      </div>
                      <button type="submit" class="btn btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Save </button>
                    </div>
                </div>
              </form>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body">
              <h4 class="card-title"><span class="lstick"></span>List Super Admin</h4>  

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <table id="table-ingrd" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="">Name</th>
                          <th width="15%">Phone</th>
                          <th width="20%">Email</th>
                          <th width="10%" class="text-center no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if (count($user) > 0)
                        @foreach ($user as $key => $value)
                          <tr>
                            <td align="center">{{ $key+1 }}</td>
                            <td>{{ $value->first_name }} {{ $value->last_name }}</td>
                            <td>{{ $value->phone }}</td>
                            <td>{{ $value->email }}</td>          
                            <td class="text-center">
                              <form action="{{route('user.destroy', ['id' => $value->id])}}" method="post">
                                @csrf
                                <a class="btn btn-info btn-sm" href="{{route('user.superadmin.edit', ['id' => $value->id])}}"><i class="fa fa-pencil"></i></a>
                                @method('DELETE')
                                <input type="hidden" class="form-control" id="roles_id" name="roles_id" value="3">
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
                              <p>Are you sure to delete this user ?</p>
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

