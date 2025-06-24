@extends('admin.layouts.app')

@section('title', 'Associates Management')
@section('page-title', 'Associates Management')
@section('breadcrumb', 'Master / Associates')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">

<style>
    .associates-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    
    .associates-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 100px;
        height: 200%;
        background: rgba(255,255,255,0.1);
        transform: rotate(15deg);
    }
    
    .associates-table-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        padding: 25px;
    }
    
    .table th {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        padding: 15px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    
    .btn-add-associate {
        background: linear-gradient(45deg, #3b82f6 0%, #1d4ed8 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 25px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-add-associate:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        color: white;
    }
    
    .modal-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
        border-color: #10b981;
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="associates-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0">
                    <i class="fas fa-handshake mr-3"></i>Associates Management
                </h1>
                <p class="mb-0 opacity-75">Manage collection centers and business associates</p>
            </div>
            <div class="col-md-4 text-right">
                <button class="btn btn-add-associate" id="createNewAssociate">
                    <i class="fas fa-plus mr-2"></i>Add New Associate
                </button>
            </div>
        </div>
    </div>

    <!-- Associates Table -->
    <div class="associates-table-container">
        <div class="table-responsive">
            <table class="table table-hover" id="associatesTable">
                <thead>
                    <tr>
                        <th width="5%">Sr. No.</th>
                        <th width="20%">Associate Name</th>
                        <th width="15%">Contact Person</th>
                        <th width="12%">Phone</th>
                        <th width="20%">Address</th>
                        <th width="10%">Commission %</th>
                        <th width="8%">Status</th>
                        <th width="10%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded via Ajax -->
                </tbody>
            </table>
        </div>
    </div>
</div>
                        </h3>
                        <button class="btn btn-light btn-sm" id="createNewAssociate">
                            <i class="fas fa-plus mr-2"></i>Add Associate
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="associatesTable">
                            <thead class="thead-light">
                                <tr>
                                    <th width="8%">Sr. No.</th>
                                    <th width="25%">Name</th>
                                    <th width="25%">Hospital Name</th>
                                    <th width="20%">Contact No.</th>
                                    <th width="10%">Percent</th>
                                    <th width="8%">Status</th>
                                    <th width="4%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded via Ajax -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Associate Modal -->
<div class="modal fade" id="associateModal" tabindex="-1" role="dialog" aria-labelledby="associateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="associateModalLabel">
                    <i class="fas fa-users mr-2"></i>Add Associate
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="associateForm">
                <div class="modal-body">
                    <input type="hidden" id="associateId" name="associate_id">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Associate Information</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name" required placeholder="Enter associate name">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="hospitalName">Hospital Name</label>
                                                <input type="text" class="form-control" id="hospitalName" name="hospital_name" placeholder="Enter hospital name">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="contactNo">Contact No.</label>
                                                <input type="text" class="form-control" id="contactNo" name="contact_no" placeholder="Enter contact number">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="percent">Percent (%)</label>
                                                <input type="number" class="form-control" id="percent" name="percent" min="0" max="100" step="0.01" placeholder="Enter percentage">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter complete address..."></textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="status" name="status" checked>
                                            <label class="custom-control-label" for="status">Active Status</label>
                                        </div>
                                        <small class="form-text text-muted">Toggle to activate or deactivate this associate</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>Save Associate
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Associate Modal -->
<div class="modal fade" id="viewAssociateModal" tabindex="-1" role="dialog" aria-labelledby="viewAssociateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewAssociateModalLabel">
                    <i class="fas fa-eye mr-2"></i>Associate Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Associate Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered view-table">
                                <tbody id="associateDetails">
                                    <!-- Details will be loaded via Ajax -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables & plugins -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(document).ready(function() {
    // Configure toastr options
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    // Initialize DataTable
    var table = $('#associatesTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.associates.data') }}",
            error: function(xhr, error, thrown) {
                toastr.error('Error loading associates data');
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'hospital_name', name: 'hospital_name'},
            {data: 'contact_no', name: 'contact_no'},
            {data: 'percent_display', name: 'percent_display', orderable: false},
            {data: 'status', name: 'status', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'table-actions text-center'}
        ],
        order: [[1, 'asc']],
        pageLength: 25,
        language: {
            processing: '<i class="fas fa-spinner fa-spin fa-2x"></i><br>Loading...',
            emptyTable: 'No associates found. <a href="#" id="addFirstAssociate" class="btn btn-primary btn-sm mt-2"><i class="fas fa-plus"></i> Create First Associate</a>'
        }
    });

    // Add first associate link handler
    $(document).on('click', '#addFirstAssociate', function(e) {
        e.preventDefault();
        $('#createNewAssociate').click();
    });

    // Create new associate
    $('#createNewAssociate').click(function() {
        resetForm();
        $('#associateModalLabel').html('<i class="fas fa-users mr-2"></i>Add Associate');
        $('#associateModal').modal('show');
        toastr.info('Create a new associate');
    });

    // Save associate
    $('#associateForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        
        // Show loading
        var saveBtn = $(this).find('button[type="submit"]');
        var originalText = saveBtn.html();
        saveBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Saving...');
        
        $.ajax({
            url: "{{ route('admin.associates.store') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#associateModal').modal('hide');
                table.ajax.reload();
                toastr.success(response.success);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        var field = key.replace('_', '');
                        if (key === 'hospital_name') field = 'hospitalName';
                        if (key === 'contact_no') field = 'contactNo';
                        
                        $('#' + field).addClass('is-invalid');
                        $('#' + field).siblings('.invalid-feedback').text(value[0]);
                    });
                    toastr.error('Please correct the errors and try again');
                } else {
                    toastr.error('An error occurred while saving associate');
                }
            },
            complete: function() {
                saveBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Edit associate
    $(document).on('click', '.editAssociate', function() {
        var id = $(this).data('id');
        resetForm();
        
        $.ajax({
            url: "{{ route('admin.associates.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                $('#associateId').val(data.id);
                $('#name').val(data.name);
                $('#hospitalName').val(data.hospital_name);
                $('#contactNo').val(data.contact_no);
                $('#address').val(data.address);
                $('#percent').val(data.percent);
                $('#status').prop('checked', data.status);
                
                $('#associateModalLabel').html('<i class="fas fa-edit mr-2"></i>Edit Associate');
                $('#associateModal').modal('show');
                toastr.info('Edit associate details');
            },
            error: function() {
                toastr.error('Error loading associate data');
            }
        });
    });

    // View associate
    $(document).on('click', '.viewAssociate', function() {
        var id = $(this).data('id');
        
        $.ajax({
            url: "{{ route('admin.associates.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                var detailsHtml = `
                    <tr><th>Name</th><td>${data.name || 'N/A'}</td></tr>
                    <tr><th>Hospital Name</th><td>${data.hospital_name || 'N/A'}</td></tr>
                    <tr><th>Contact No.</th><td>${data.contact_no || 'N/A'}</td></tr>
                    <tr><th>Address</th><td>${data.address || 'N/A'}</td></tr>
                    <tr><th>Percent</th><td><span class="badge badge-primary">${data.percent || 0}%</span></td></tr>
                    <tr><th>Status</th><td>${data.status ? '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Active</span>' : '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Inactive</span>'}</td></tr>
                    <tr><th>Created At</th><td>${new Date(data.created_at).toLocaleString()}</td></tr>
                    <tr><th>Updated At</th><td>${new Date(data.updated_at).toLocaleString()}</td></tr>
                `;
                
                $('#associateDetails').html(detailsHtml);
                $('#viewAssociateModal').modal('show');
                toastr.info('Viewing associate details');
            },
            error: function() {
                toastr.error('Error loading associate data');
            }
        });
    });

    // Delete associate
    $(document).on('click', '.deleteAssociate', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        
        if (confirm('Are you sure you want to delete "' + name + '"?')) {
            $.ajax({
                url: "{{ route('admin.associates.destroy', ':id') }}".replace(':id', id),
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    table.ajax.reload();
                    toastr.success(response.success);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        toastr.error(xhr.responseJSON.error);
                    } else {
                        toastr.error('Error deleting associate');
                    }
                }
            });
        }
    });

    // Reset form function
    function resetForm() {
        $('#associateForm')[0].reset();
        $('#associateId').val('');
        $('#status').prop('checked', true);
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
    }
});
</script>
@endpush
