@extends('admin.layouts.app')

@section('title', 'Associates Management')
@section('page-title', 'Associates Management')
@section('breadcrumb', 'Master / Associates')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 100px;
        height: 200%;
        background: rgba(255,255,255,0.1);
        transform: rotate(15deg);
    }
    
    .page-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .page-header .subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }
    
    .card-modern {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .card-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 1.5rem 2rem;
    }
    
    .card-header-modern h3 {
        margin: 0;
        font-weight: 600;
        font-size: 1.3rem;
    }
    
    .btn-primary-modern {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 25px;
        padding: 0.75rem 2rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        color: white;
    }
    
    .btn-secondary-modern {
        background: linear-gradient(45deg, #6c757d 0%, #495057 100%);
        border: none;
        border-radius: 25px;
        padding: 0.75rem 2rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-secondary-modern:hover {
        transform: translateY(-2px);
        color: white;
    }
    
    .table-modern {
        margin-bottom: 0;
    }
    
    .table-modern thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        vertical-align: middle;
    }
    
    .table-modern tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-color: #f8f9fa;
    }
    
    .table-modern tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .modal-modern .modal-content {
        border: none;
        border-radius: 15px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }
    
    .modal-modern .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 15px 15px 0 0;
        padding: 1.5rem 2rem;
    }
    
    .modal-modern .modal-title {
        font-weight: 600;
        font-size: 1.3rem;
    }
    
    .modal-modern .modal-body {
        padding: 2rem;
    }
    
    .modal-modern .modal-footer {
        border: none;
        padding: 1.5rem 2rem;
        background-color: #f8f9fa;
    }
    
    .form-control-modern {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .form-group label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }
    
    .badge-modern {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    
    .badge-success-modern {
        background: linear-gradient(45deg, #28a745 0%, #20c997 100%);
        color: white;
    }
    
    .badge-danger-modern {
        background: linear-gradient(45deg, #dc3545 0%, #e83e8c 100%);
        color: white;
    }
    
    .badge-primary-modern {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        align-items: center;
    }
    
    .btn-action {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-view {
        background: linear-gradient(45deg, #17a2b8 0%, #138496 100%);
        color: white;
    }
    
    .btn-edit {
        background: linear-gradient(45deg, #ffc107 0%, #e0a800 100%);
        color: white;
    }
    
    .btn-delete {
        background: linear-gradient(45deg, #dc3545 0%, #c82333 100%);
        color: white;
    }
    
    .btn-action:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        font-size: 1.2rem;
        color: #667eea;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%) !important;
        border-color: #667eea !important;
        color: white !important;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #667eea !important;
        border-color: #667eea !important;
        color: white !important;
    }
    
    @media (max-width: 768px) {
        .page-header {
            text-align: center;
            padding: 1.5rem;
        }
        
        .page-header h1 {
            font-size: 2rem;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 0.25rem;
        }
        
        .btn-action {
            width: 30px;
            height: 30px;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-12">
                <h1>
                    <i class="fas fa-handshake mr-3"></i>Associates Management
                </h1>
                <p class="subtitle">Manage collection centers and business associates efficiently</p>
            </div>
            <div class="col-lg-4 col-md-12 text-lg-right text-center mt-3 mt-lg-0">
                <button class="btn btn-primary-modern" id="createNewAssociate">
                    <i class="fas fa-plus mr-2"></i>Add New Associate
                </button>
            </div>
        </div>
    </div>

    <!-- Associates Table Card -->
    <div class="card card-modern">
        <div class="card-header card-header-modern">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-0">
                        <i class="fas fa-users mr-2"></i>Associates List
                    </h3>
                </div>                <div class="col-md-4 text-right">
                    <div class="d-flex align-items-center justify-content-end">
                        <button class="btn btn-light btn-sm mr-2" id="refreshTable" title="Refresh Data">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                        <span class="badge badge-light" id="totalAssociates">
                            <i class="fas fa-chart-bar mr-1"></i>Total: 0
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern table-hover" id="associatesTable">                    <thead>
                        <tr>
                            <th width="8%">Sr. No.</th>
                            <th width="22%">Associate Name</th>
                            <th width="18%">Hospital Name</th>
                            <th width="15%">Contact Number</th>
                            <th width="20%">Address</th>
                            <th width="10%">Commission</th>
                            <th width="10%">Status</th>
                            <th width="12%">Actions</th>
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

<!-- Add/Edit Associate Modal -->
<div class="modal fade modal-modern" id="associateModal" tabindex="-1" role="dialog" aria-labelledby="associateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="associateModalLabel">
                    <i class="fas fa-users mr-2"></i>Add Associate
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="associateForm">
                <div class="modal-body">
                    <input type="hidden" id="associateId" name="associate_id">
                    
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 text-primary">
                                        <i class="fas fa-user mr-2"></i>Basic Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Associate Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-modern" id="name" name="name" 
                                               required placeholder="Enter associate name">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="hospitalName">Hospital/Organization Name</label>
                                        <input type="text" class="form-control form-control-modern" id="hospitalName" 
                                               name="hospital_name" placeholder="Enter hospital or organization name">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="contactNo">Contact Number</label>
                                        <input type="text" class="form-control form-control-modern" id="contactNo" 
                                               name="contact_no" placeholder="Enter contact number">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Address & Commission -->
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 text-primary">
                                        <i class="fas fa-map-marker-alt mr-2"></i>Address & Commission
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="address">Complete Address</label>
                                        <textarea class="form-control form-control-modern" id="address" name="address" 
                                                  rows="3" placeholder="Enter complete address..."></textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="percent">Commission Percentage (%)</label>
                                        <input type="number" class="form-control form-control-modern" id="percent" 
                                               name="percent" min="0" max="100" step="0.01" placeholder="Enter percentage">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="status" name="status" checked>
                                            <label class="custom-control-label" for="status">
                                                <strong>Active Status</strong>
                                            </label>
                                        </div>
                                        <small class="form-text text-muted">
                                            <i class="fas fa-info-circle mr-1"></i>Toggle to activate or deactivate this associate
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary-modern" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary-modern" id="saveBtn">
                        <i class="fas fa-save mr-2"></i>Save Associate
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Associate Modal -->
<div class="modal fade modal-modern" id="viewAssociateModal" tabindex="-1" role="dialog" aria-labelledby="viewAssociateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewAssociateModalLabel">
                    <i class="fas fa-eye mr-2"></i>Associate Details
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless" id="associateDetailsTable">
                                <tbody id="associateDetails">
                                    <!-- Details will be loaded via Ajax -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary-modern" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay" style="display: none;">
    <div class="text-center">
        <i class="fas fa-spinner fa-spin fa-3x mb-3"></i>
        <div>Loading...</div>
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
    // Add debugging for route testing
    console.log('Associates Data Route URL:', "{{ route('admin.associates.data') }}");
    
    // Test if the route is accessible
    $.get("{{ route('admin.associates.data') }}")
        .done(function(data) {
            console.log('Route test successful:', data);
        })
        .fail(function(xhr, status, error) {
            console.error('Route test failed:', xhr.status, xhr.responseText);
            if (xhr.status === 404) {
                toastr.error('Associates data route not found. Please check your routes configuration.');
            }
        });

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

    // Show loading overlay
    function showLoading() {
        $('#loadingOverlay').fadeIn();
    }

    // Hide loading overlay
    function hideLoading() {
        $('#loadingOverlay').fadeOut();
    }    // Initialize DataTable
    var table = $('#associatesTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,        ajax: {
            url: "{{ route('admin.associates.data') }}",
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {
                showLoading();
            },
            complete: function() {
                hideLoading();
            },
            error: function(xhr, error, thrown) {
                hideLoading();
                console.error('DataTable AJAX Error:', xhr.responseText);
                console.error('Error details:', error, thrown);
                console.error('Status:', xhr.status);
                console.error('Response Headers:', xhr.getAllResponseHeaders());
                
                let errorMessage = 'Error loading associates data.';
                if (xhr.status === 500) {
                    errorMessage = 'Server error occurred. Please check if the associates data route is working properly.';
                } else if (xhr.status === 404) {
                    errorMessage = 'Associates data endpoint not found. Please check the routes.';
                } else if (xhr.status === 0) {
                    errorMessage = 'Network error. Please check your internet connection.';
                } else if (xhr.status === 200 && xhr.responseText && !xhr.responseText.startsWith('{')) {
                    errorMessage = 'Invalid JSON response. The server may be returning HTML instead of JSON.';
                    console.error('Response content:', xhr.responseText.substring(0, 500));
                }
                
                toastr.error(errorMessage);
                
                // Show a user-friendly error in the table
                $('#associatesTable tbody').html(
                    '<tr><td colspan="8" class="text-center py-4">' +
                    '<i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i><br>' +
                    '<h5>Error Loading Data</h5>' +
                    '<p class="text-muted">' + errorMessage + '</p>' +
                    '<button class="btn btn-primary-modern" onclick="location.reload()"><i class="fas fa-refresh mr-2"></i>Refresh Page</button>' +
                    '</td></tr>'
                );
            }
        },columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'hospital_name', name: 'hospital_name'},
            {data: 'contact_no', name: 'contact_no'},
            {data: 'address', name: 'address'},
            {data: 'percent_display', name: 'percent_display', orderable: false, searchable: false},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
        ],
        order: [[1, 'asc']],
        pageLength: 25,
        dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>rtip',
        language: {
            processing: '<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i><br><strong>Loading Associates...</strong></div>',
            emptyTable: '<div class="text-center py-4"><i class="fas fa-users fa-3x text-muted mb-3"></i><br><h5>No Associates Found</h5><p class="text-muted">Start by adding your first associate</p><button class="btn btn-primary-modern" id="addFirstAssociate"><i class="fas fa-plus mr-2"></i>Add First Associate</button></div>',
            lengthMenu: 'Show _MENU_ associates per page',
            search: 'Search associates:',
            info: 'Showing _START_ to _END_ of _TOTAL_ associates',
            infoEmpty: 'No associates available',
            infoFiltered: '(filtered from _MAX_ total associates)'
        },
        drawCallback: function(settings) {
            // Update total count
            var api = this.api();
            var total = api.page.info().recordsTotal;
            $('#totalAssociates').html('<i class="fas fa-chart-bar mr-1"></i>Total: ' + total);
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
        $('#associateModalLabel').html('<i class="fas fa-users mr-2"></i>Add New Associate');
        $('#associateModal').modal('show');
        toastr.info('Ready to add a new associate');
    });

    // Modal event handlers for button state management
    $('#associateModal').on('show.bs.modal', function() {
        resetButtonState();
    });

    $('#associateModal').on('hidden.bs.modal', function() {
        resetForm();
        resetButtonState();
    });

    // Save associate
    $('#associateForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        
        // Show loading on button
        var saveBtn = $('#saveBtn');
        var originalText = '<i class="fas fa-save mr-2"></i>Save Associate';
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
                // Reset button state immediately
                saveBtn.prop('disabled', false).html(originalText);
                
                $('#associateModal').modal('hide');
                table.ajax.reload();
                toastr.success(response.success || 'Associate saved successfully!');
            },
            error: function(xhr) {
                // Reset button state immediately
                saveBtn.prop('disabled', false).html(originalText);
                
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
                    toastr.error('An error occurred while saving associate. Please try again.');
                }
            }
        });
    });

    // Edit associate
    $(document).on('click', '.editAssociate', function() {
        var id = $(this).data('id');
        resetForm();
        showLoading();
        
        $.ajax({
            url: "{{ route('admin.associates.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                hideLoading();
                $('#associateId').val(data.id);
                $('#name').val(data.name);
                $('#hospitalName').val(data.hospital_name);
                $('#contactNo').val(data.contact_no);
                $('#address').val(data.address);
                $('#percent').val(data.percent);
                $('#status').prop('checked', data.status);
                
                $('#associateModalLabel').html('<i class="fas fa-edit mr-2"></i>Edit Associate');
                $('#associateModal').modal('show');
                toastr.info('Ready to edit associate details');
            },
            error: function() {
                hideLoading();
                toastr.error('Error loading associate data. Please try again.');
            }
        });
    });

    // View associate
    $(document).on('click', '.viewAssociate', function() {
        var id = $(this).data('id');
        showLoading();
        
        $.ajax({
            url: "{{ route('admin.associates.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                hideLoading();
                var statusBadge = data.status 
                    ? '<span class="badge badge-success-modern"><i class="fas fa-check-circle mr-1"></i>Active</span>' 
                    : '<span class="badge badge-danger-modern"><i class="fas fa-times-circle mr-1"></i>Inactive</span>';
                
                var detailsHtml = `
                    <tr>
                        <th width="30%" class="text-muted"><i class="fas fa-user mr-2"></i>Name</th>
                        <td><strong>${data.name || 'N/A'}</strong></td>
                    </tr>
                    <tr>
                        <th class="text-muted"><i class="fas fa-hospital mr-2"></i>Hospital Name</th>
                        <td>${data.hospital_name || 'N/A'}</td>
                    </tr>
                    <tr>
                        <th class="text-muted"><i class="fas fa-phone mr-2"></i>Contact No.</th>
                        <td>${data.contact_no || 'N/A'}</td>
                    </tr>
                    <tr>
                        <th class="text-muted"><i class="fas fa-map-marker-alt mr-2"></i>Address</th>
                        <td>${data.address || 'N/A'}</td>
                    </tr>
                    <tr>
                        <th class="text-muted"><i class="fas fa-percentage mr-2"></i>Commission</th>
                        <td><span class="badge badge-primary-modern">${data.percent || 0}%</span></td>
                    </tr>
                    <tr>
                        <th class="text-muted"><i class="fas fa-toggle-on mr-2"></i>Status</th>
                        <td>${statusBadge}</td>
                    </tr>
                    <tr>
                        <th class="text-muted"><i class="fas fa-calendar-plus mr-2"></i>Created At</th>
                        <td>${new Date(data.created_at).toLocaleString()}</td>
                    </tr>
                    <tr>
                        <th class="text-muted"><i class="fas fa-calendar-edit mr-2"></i>Updated At</th>
                        <td>${new Date(data.updated_at).toLocaleString()}</td>
                    </tr>
                `;
                
                $('#associateDetails').html(detailsHtml);
                $('#viewAssociateModal').modal('show');
                toastr.info('Viewing associate details');
            },
            error: function() {
                hideLoading();
                toastr.error('Error loading associate data. Please try again.');
            }
        });
    });

    // Delete associate
    $(document).on('click', '.deleteAssociate', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        
        // Enhanced confirmation dialog
        if (confirm(`⚠️ Are you sure you want to delete "${name}"?\n\nThis action cannot be undone and will permanently remove all associated data.`)) {
            showLoading();
            
            $.ajax({
                url: "{{ route('admin.associates.destroy', ':id') }}".replace(':id', id),
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    hideLoading();
                    table.ajax.reload();
                    toastr.success(response.success || 'Associate deleted successfully!');
                },
                error: function(xhr) {
                    hideLoading();
                    if (xhr.status === 422) {
                        toastr.error(xhr.responseJSON.error || 'Cannot delete this associate.');
                    } else {
                        toastr.error('Error deleting associate. Please try again.');
                    }
                }
            });
        }
    });

    // Manual refresh button
    $('#refreshTable').click(function() {
        var btn = $(this);
        var originalText = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Refreshing...');
        
        table.ajax.reload(function() {
            btn.prop('disabled', false).html(originalText);
            toastr.success('Data refreshed successfully!');
        }, false);
    });

    // Reset form function
    function resetForm() {
        $('#associateForm')[0].reset();
        $('#associateId').val('');
        $('#status').prop('checked', true);
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
    }

    // Reset button state function
    function resetButtonState() {
        var saveBtn = $('#saveBtn');
        var originalText = '<i class="fas fa-save mr-2"></i>Save Associate';
        saveBtn.prop('disabled', false).html(originalText);
    }

    // Auto-refresh table every 5 minutes
    setInterval(function() {
        table.ajax.reload(null, false);
    }, 300000);

    // Enhanced error handling for AJAX requests
    $(document).ajaxError(function(event, xhr, settings, thrownError) {
        if (xhr.status === 419) {
            toastr.error('Session expired. Please refresh the page.');
        } else if (xhr.status === 500) {
            toastr.error('Server error occurred. Please contact administrator.');
        }
    });
});
</script>
@endpush
