@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
      <div class="card-header">

        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createCompany">Create new company</button>

        <!-- Modal -->
        <div class="modal fade" id="createCompany" tabindex="-1" role="dialog" aria-labelledby="createCompanyLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="createCompanyLabel">Create new Company</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="storeCompany" action="{{ route('companies.store') }}" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                
                    {{ csrf_field() }}
                  <div class="form-group">
                    <label class="col-form-label">Name:</label>
                    <input type="text" class="form-control" name="name" value="{{old('name')}}" required>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label">Email:</label>
                    <input type="text" class="form-control" name="email" value="{{old('email')}}">
                  </div>
                  <div class="form-group">
                    <label class="col-form-label">Website:</label>
                    <input type="text" class="form-control" name="website" value="{{old('website')}}">
                  </div>
                  <div class="form-group">
                    <label class="col-form-label">Address:</label>
                    <input type="text" class="form-control" name="address" value="{{old('address')}}">
                  </div>

                  <div class="form-group">
                    <label class="col-form-label">Logo:</label>
                    <input type="file" class="form-control-file" name="logo">
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
            <h5 class="card-title">Companies list</h5>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Address</th>
                  <th scope="col">Website</th>
                  <th scope="col">Email</th>
                  <th scope="col">Logo</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                @forelse($companies as $company)
                <tr>
                  <th scope="row">{{$company->name}}</th>
                  <td>{{$company->address}}</td>
                  <td>{{$company->website}}</td>
                  <td>{{$company->email}}</td>
                  <td>
                    @if($company->logo != '')
                        <img style="width: 100px; height: 100px;" class="avatar" src="{{ asset('storage/'.$company->logo) }}"/>
                    @endif
                    </td>
                  <td>
                    <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#exampleModal">Edit</button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Company</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form id="editCompany" action="{{ route('companies.update', $company->id) }}" method="post" enctype="multipart/form-data">
                          <div class="modal-body">
                            
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                              <div class="form-group">
                                <label class="col-form-label">Name:</label>
                                <input type="text" class="form-control" name="name" value="{{$company->name}}" required>
                              </div>
                              <div class="form-group">
                                <label class="col-form-label">Email:</label>
                                <input type="text" class="form-control" name="email" value="{{$company->email}}">
                              </div>
                              <div class="form-group">
                                <label class="col-form-label">Website:</label>
                                <input type="text" class="form-control" name="website" value="{{$company->website}}">
                              </div>
                              <div class="form-group">
                                <label class="col-form-label">Address:</label>
                                <input type="text" class="form-control" name="address" value="{{$company->address}}">
                              </div>

                              <div class="form-group">
                                <label class="col-form-label">Logo:</label>
                                <input type="file" class="form-control-file" name="logo">
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

                    <button type="button" class="btn btn-danger delete" id="delete{{ $company->id }}" data-id="{{ $company->id }}" data-url="{{ route('companies.destroy', $company->id) }}">Delete</button>
                </tr>
                @empty
                <tr>
                    <td colspan="5">There are No companies</td>
                </tr>
                @endforelse
              </tbody>
            </table>
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
                        //$("#order_status" + data.id).html('سارى');
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

        $('form#editCompany').on('submit', function (e) {
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
                        //$("#order_status" + data.id).html('سارى');
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
                                var msg = 'company has been deleted successfully';
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