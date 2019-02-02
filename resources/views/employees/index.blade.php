@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
      <div class="card-header">

        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createCompany">Create new Employee</button>

        <!-- Modal -->
        <div class="modal fade" id="createCompany" tabindex="-1" role="dialog" aria-labelledby="createCompanyLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="createCompanyLabel">Create new Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="storeCompany" action="{{ route('employees.store') }}" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                
                    {{ csrf_field() }}
                  <div class="form-group">
                    <label class="col-form-label">First Name:</label>
                    <input type="text" class="form-control" name="first_name" value="{{old('first_name')}}" required>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label">Last Name:</label>
                    <input type="text" class="form-control" name="last_name" value="{{old('last_name')}}" required>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label">Phone:</label>
                    <input type="text" class="form-control" name="phone" value="{{old('phone')}}" required>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label">Email:</label>
                    <input type="text" class="form-control" name="email" value="{{old('email')}}">
                  </div>
                  <div class="form-group">
                    <label class="col-form-label">Company:</label>
                    <select class="form-control" name="company">
                      @forelse($companies as $company)
                        <option value="{{$company->id}}">{{$company->name}}</option>
                      @empty
                        <option value="">no companies</option>
                      @endforelse
                    </select>
                  </div>
                
              </div>
              <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-dismiss="modal" onclick="Custombox.close();">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
              </form>
            </div>
          </div>
        </div>

      </div>
        <div class="card-body">
            <h5 class="card-title">Employees list</h5>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">First Name</th>
                  <th scope="col">Last Name</th>
                  <th scope="col">Phone</th>
                  <th scope="col">Email</th>
                  <th scope="col">Company</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                @forelse($employees as $employee)
                <tr>
                  <th scope="row">{{$employee->first_name}}</th>
                  <td>{{$employee->last_name}}</td>
                  <td>{{$employee->phone}}</td>
                  <td>{{$employee->email}}</td>
                  <td>{{$employee->company ? $employee->company->name : ''}}</td>
                  <td>
                    <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#exampleModal{{$employee->id}}">Edit</button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{$employee->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Employee</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form id="editEmployee" action="{{ route('employees.update', $employee->id) }}" method="post">
                          <div class="modal-body">
                            
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                              <div class="form-group">
                                <label class="col-form-label">First Name:</label>
                                <input type="text" class="form-control" name="first_name" value="{{$employee->first_name}}" required>
                              </div>
                              <div class="form-group">
                                <label class="col-form-label">Last Name:</label>
                                <input type="text" class="form-control" name="last_name" value="{{$employee->last_name}}" required>
                              </div>
                              <div class="form-group">
                                <label class="col-form-label">Phone:</label>
                                <input type="text" class="form-control" name="phone" value="{{$employee->phone}}" required>
                              </div>
                              <div class="form-group">
                                <label class="col-form-label">Email:</label>
                                <input type="text" class="form-control" name="email" value="{{$employee->email}}">
                              </div>
                              <div class="form-group">
                                <label class="col-form-label">Company:</label>
                                <select class="form-control" name="company">
                                  @forelse($companies as $company)
                                    <option value="{{$company->id}}">{{$company->name}}</option>
                                  @empty
                                    <option value="">no companies</option>
                                  @endforelse
                                </select>
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-dismiss="modal" onclick="Custombox.close();">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>

                    <button type="button" class="btn btn-danger delete" id="delete{{ $employee->id }}" data-id="{{ $employee->id }}" data-url="{{ route('employees.destroy', $employee->id) }}">Delete</button>
                </tr>
                @empty
                <tr>
                    <td colspan="5">There are No companies</td>
                </tr>
                @endforelse
              </tbody>
            </table>

            {{ $employees->links() }}
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        console.log('test');
        $('form#storeCompany').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'PUT',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                    if (data.status == true) {
                        var shortCutFunction = 'success';
                        var msg = data.message;
                        var title = 'success';
                        toastr.options = {
                            positionClass: 'toast-top-center',
                            onclick: null,
                            showMethod: 'slideDown',
                            hideMethod: "slideUp",

                        };
                        var $toast = toastr[shortCutFunction](msg, title);
                        $toastlast = $toast;
                        Custombox.close();
                        //$("#name" + data.id).html('inas');
                        location.reload();
                    }

                    if (data.status == false) {
                        var shortCutFunction = 'error';
                        var msg = data.message;
                        var title = 'error';
                        toastr.options = {
                            positionClass: 'toast-top-center',
                            onclick: null,
                            showMethod: 'slideDown',
                            hideMethod: "slideUp",

                        };
                        var $toast = toastr[shortCutFunction](msg, title);
                        $toastlast = $toast;
                    }

                },
                error: function (data) {

                }
            });
        });

        $('form#editEmployee').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'PUT',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                    if (data.status == true) {
                        var shortCutFunction = 'success';
                        var msg = data.message;
                        var title = 'success';
                        toastr.options = {
                            positionClass: 'toast-top-center',
                            onclick: null,
                            showMethod: 'slideDown',
                            hideMethod: "slideUp",

                        };
                        var $toast = toastr[shortCutFunction](msg, title);
                        $toastlast = $toast;
                        Custombox.close();
                        //$("#name" + data.id).html('inas');
                        location.reload();
                    }

                    if (data.status == false) {
                        var shortCutFunction = 'error';
                        var msg = data.message;
                        var title = 'error';
                        toastr.options = {
                            positionClass: 'toast-top-center',
                            onclick: null,
                            showMethod: 'slideDown',
                            hideMethod: "slideUp",

                        };
                        var $toast = toastr[shortCutFunction](msg, title);
                        $toastlast = $toast;
                    }

                },
                error: function (data) {

                }
            });
        });

        $('body').on('click', '.delete', function () {
            var id = $(this).attr('data-id');
            var url = $(this).attr('data-url');
            var $tr = $(this).closest($('#delete' + id).parent().parent());
            swal({
                title: "Are you sure",
                text: "",
                type: "error",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "confirm",
                cancelButtonText: "cancel",
                confirmButtonClass: 'btn-danger waves-effect waves-light',
                closeOnConfirm: true,
                closeOnCancel: true,
            }, function (isConfirm) {
                if (isConfirm) {
                    console.log('confirmed');
                    $.ajax({
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url,
                        success: function (data) {
                            if (data.status == true) {
                                var shortCutFunction = 'success';
                                var msg = 'Employee has been deleted successfully';
                                var title = data.title;
                                toastr.options = {
                                    positionClass: 'toast-top-left',
                                    onclick: null
                                };
                                var $toast = toastr[shortCutFunction](msg, title);
                                $toastlast = $toast;

                                $tr.find('td').fadeOut(1000, function () {
                                    $tr.remove();
                                });
                            }
                            if (data.status == false) {
                                var shortCutFunction = 'error';
                                var msg = data.message;
                                var title = data.title;
                                toastr.options = {
                                    positionClass: 'toast-top-left',
                                    onclick: null
                                };
                                var $toast = toastr[shortCutFunction](msg, title);
                                $toastlast = $toast;
                            }
                        },
                        error: function(data) {
                           console.log(data);
                        }
                    });
                } else {

                    swal({
                        title: "cancelled",
                        text: "",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "confirm",
                        confirmButtonClass: 'btn-info waves-effect waves-light',
                        closeOnConfirm: false,
                        closeOnCancel: false

                    });

                }
            });
        });
    </script>
@endsection