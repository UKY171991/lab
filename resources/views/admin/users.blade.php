@extends('admin.layouts.app')

@section('title', 'Users Management')
@section('page-title', 'Users Management')
@section('breadcrumb', 'Users')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.bootstrap4.min.css">

<style>
    .users-header {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: white;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
    }
    
    .users-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 120px;
        height: 200%;
        background: rgba(255,255,255,0.1);
        transform: rotate(15deg);
        animation: float 20s linear infinite;
    }
    
    @keyframes float {
        from { transform: rotate(15deg) translateX(-20px); }
        to { transform: rotate(15deg) translateX(20px); }
    }
    
    .users-table-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        padding: 30px;
        transition: all 0.3s ease;
    }
    
    .users-table-container:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    }
    
    .btn-add-user {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 25px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }
    
    .btn-add-user:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        color: white;
    }
    
    .table thead th {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border: none;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.85rem;
        padding: 20px 15px;
    }
    
    .table tbody tr {
        transition: all 0.3s ease;
    }
    
    .table tbody tr:hover {
        background: #f8fafc;
        transform: scale(1.01);
    }
    
    .table tbody td {
        padding: 18px 15px;
        border-top: 1px solid #e2e8f0;
        vertical-align: middle;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .user-avatar:hover {
        border-color: #6366f1;
        transform: scale(1.1);
    }
    
    .badge {
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .btn-group .btn {
        margin-right: 5px;
        border-radius: 8px;
        padding: 8px 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-group .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    .modal-header {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: white;
        border-radius: 15px 15px 0 0;
        border: none;
    }
    
    .modal-content {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }
    
    .form-control {
        border-radius: 10px;
        border: 2px solid #e2e8f0;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
    }
    
    .form-group label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }
    
    .bulk-actions {
        background: #f8fafc;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: none;
    }
    
    .user-stats {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .stat-item {
        background: white;
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        flex: 1;
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #6366f1;
    }
    
    .stat-label {
        color: #6b7280;
        font-size: 0.9rem;
        margin-top: 5px;
    }
    
    /* Loading states */
    .loading-row {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
        height: 60px;
    }
    
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Users Header -->
    <div class="users-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0">
                    <i class="fas fa-users mr-3"></i>User Management System
                </h1>
                <p class="mb-0 mt-2 opacity-75">Manage system users, roles, and permissions</p>
            </div>
            <div class="col-md-4 text-right">
                <button class="btn btn-add-user" data-toggle="modal" data-target="#ajaxModel" id="createNewUser">
                    <i class="fas fa-plus mr-2"></i>Add New User
                </button>
            </div>
        </div>
    </div>

    <!-- User Statistics -->
    <div class="user-stats">
        <div class="stat-item">
            <div class="stat-number">{{ \App\Models\User::count() }}</div>
            <div class="stat-label">Total Users</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ \App\Models\User::where('created_at', '>=', now()->startOfMonth())->count() }}</div>
            <div class="stat-label">New This Month</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ \App\Models\User::whereHas('role', function($q) { $q->where('name', 'admin'); })->count() }}</div>
            <div class="stat-label">Administrators</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ \App\Models\User::where('created_at', '>=', now()->startOfDay())->count() }}</div>
            <div class="stat-label">Active Today</div>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="bulk-actions" id="bulkActions">
        <div class="row align-items-center">
            <div class="col-md-6">
                <span id="selectedCount">0</span> user(s) selected
            </div>
            <div class="col-md-6 text-right">
                <button class="btn btn-warning btn-sm" id="bulkDeactivate">
                    <i class="fas fa-ban mr-1"></i>Deactivate
                </button>
                <button class="btn btn-danger btn-sm" id="bulkDelete">
                    <i class="fas fa-trash mr-1"></i>Delete Selected
                </button>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="users-table-container">
        <div class="table-responsive">
            <table class="table table-striped data-table" id="usersTable">
                <thead>
                    <tr>
                        <th width="50px">
                            <input type="checkbox" id="selectAll" class="form-check-input">
                        </th>
                        <th width="50px">#</th>
                        <th width="60px">Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th width="150px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        padding: 25px;
    }
    
    .table th {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: white;
        border: none;
        padding: 15px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    
    .btn-add-user {
        background: linear-gradient(45deg, #3b82f6 0%, #1d4ed8 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 25px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-add-user:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        color: white;
    }
    
    .modal-header {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: white;
        border-radius: 15px 15px 0 0;
        border-bottom: none;
        padding: 20px 25px;
    }
    
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }
    
    .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="users-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0">
                    <i class="fas fa-users mr-3"></i>Users Management
                </h1>
                <p class="mb-0 opacity-75">Manage system users and their access levels</p>
            </div>
            <div class="col-md-4 text-right">
                <button class="btn btn-add-user" id="createNewUser">
                    <i class="fas fa-user-plus mr-2"></i>Add New User
                </button>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="users-table-container">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Name</th>
                        <th width="25%">Email</th>
                        <th width="15%">Role</th>
                        <th width="15%">Status</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
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
        ajax: "{{ route('admin.users.data') }}",
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