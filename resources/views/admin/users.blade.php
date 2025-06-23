@extends('admin.layouts.app')

@section('title', 'Users Management')
@section('page-title', 'Users')
@section('breadcrumb', 'Users')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Users List</h3>
            <a class="btn btn-success" href="javascript:void(0)" id="createNewUser"> Create New User</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="userForm" name="userForm" class="form-horizontal">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                            <span class="text-danger" id="name_error"></span>
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                            <span class="text-danger" id="email_error"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                            <span class="text-danger" id="password_error"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="col-sm-2 control-label">Confirm Password</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                        </div>
                    </div>
      
                    <div class="form-group">
                        <label for="role_id" class="col-sm-2 control-label">Role</label>
                        <div class="col-sm-12">
                            <select name="role_id" id="role_id" class="form-control" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="role_id_error"></span>
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<script type="text/javascript">
  $(function () {
    // CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Render DataTable
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.users') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'role', name: 'role', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
    // Show modal for creating a new user
    $('#createNewUser').click(function () {
        $('#saveBtn').val("create-user");
        $('#user_id').val('');
        $('#userForm').trigger("reset");
        $('#modelHeading').html("Create New User");
        $('#ajaxModel').modal('show');
        $('.text-danger').html(''); // Clear previous errors
    });
    
    // Show modal for editing a user
    $('body').on('click', '.editUser', function () {
      var user_id = $(this).data('id');
      $.get("{{ url('admin/users') }}" +'/' + user_id +'/edit', function (data) {
          $('#modelHeading').html("Edit User");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#user_id').val(data.id);
          $('#name').val(data.name);
          $('#email').val(data.email);
          $('#role_id').val(data.role_id);
          $('.text-danger').html(''); // Clear previous errors
      })
   });
    
    // Handle form submission for create/update
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
        $('.text-danger').html(''); // Clear previous errors
    
        $.ajax({
          data: $('#userForm').serialize(),
          url: "{{ route('admin.users.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
              $('#userForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
              Swal.fire('Success!', data.success, 'success');
          },
          error: function (data) {
              console.log('Error:', data);
              if (data.responseJSON.errors) {
                  $.each(data.responseJSON.errors, function(key, value){
                      $('#' + key + '_error').html(value[0]);
                  });
              }
              $('#saveBtn').html('Save Changes');
          }
      });
    });
    
    // Delete user
    $('body').on('click', '.deleteUser', function () {
        var user_id = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('admin/users') }}"+'/'+user_id,
                    success: function (data) {
                        table.draw();
                        Swal.fire('Deleted!', data.success, 'success');
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });
  });
</script>
@endpush 