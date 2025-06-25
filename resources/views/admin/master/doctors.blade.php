@extends('admin.layouts.app')

@section('title', 'Doctor Management')
@section('page-title', 'Doctor Management')
@section('breadcrumb', 'Master / Doctors')

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

<style>
    /* Header card styling */
    .doctors-header-card {
        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        border: none;
        border-radius: 15px;
        color: white;
        margin-bottom: 25px;
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
        position: relative;
        overflow: hidden;
    }
    
    .doctors-header-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 150px;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(15deg);
    }
    
    .doctors-header-card .card-body {
        padding: 30px;
        position: relative;
        z-index: 1;
    }
    
    .doctors-header-card h2 {
        margin: 0;
        font-size: 2rem;
        font-weight: 600;
    }
    
    .doctors-header-card p {
        margin: 8px 0 0 0;
        opacity: 0.9;
        font-size: 1.1rem;
    }
    
    /* Data table card styling */
    .doctors-table-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .doctors-table-card .card-header {
        background: white;
        border-bottom: 1px solid #e2e8f0;
        padding: 20px 25px;
    }
    
    .doctors-table-card .card-body {
        padding: 0;
    }
    
    /* Button styling */
    .btn-add-doctor {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 24px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }
    
    .btn-add-doctor:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        color: white;
    }
    
    /* DataTable styling */
    .table {
        margin-bottom: 0;
    }
    
    .table thead th {
        background: linear-gradient(135deg, #475569 0%, #334155 100%);
        color: white;
        border: none;
        padding: 18px 15px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        border-top: none;
    }
    
    .table tbody td {
        padding: 15px;
        vertical-align: middle;
        border-color: #f1f5f9;
    }
    
    .table tbody tr:hover {
        background: #f8fafc;
    }
    
    /* Action buttons */
    .btn-action {
        padding: 6px 12px;
        margin: 2px;
        border-radius: 6px;
        font-size: 0.85rem;
        border: none;
        transition: all 0.2s ease;
    }
    
    .btn-view {
        background: #3b82f6;
        color: white;
    }
    
    .btn-view:hover {
        background: #2563eb;
        color: white;
        transform: translateY(-1px);
    }
    
    .btn-edit {
        background: #f59e0b;
        color: white;
    }
    
    .btn-edit:hover {
        background: #d97706;
        color: white;
        transform: translateY(-1px);
    }
    
    .btn-delete {
        background: #ef4444;
        color: white;
    }
    
    .btn-delete:hover {
        background: #dc2626;
        color: white;
        transform: translateY(-1px);
    }
      /* Status badges - match backend styling */
    .badge-success {
        background: #28a745 !important;
        color: white !important;
        padding: 6px 10px;
        border-radius: 15px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    
    .badge-danger {
        background: #dc3545 !important;
        color: white !important;
        padding: 6px 10px;
        border-radius: 15px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    
    .badge-info {
        background: #17a2b8 !important;
        color: white !important;
        padding: 6px 10px;
        border-radius: 15px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    
    .badge-percent {
        background: #dbeafe;
        color: #1e40af;
        padding: 6px 10px;
        border-radius: 15px;
        font-weight: 600;
    }
    
    /* Modal styling */
    .modal-content {
        border: none;
        border-radius: 15px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }
    
    .modal-header {
        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        color: white;
        border-radius: 15px 15px 0 0;
        border-bottom: none;
        padding: 20px 25px;
    }
    
    .modal-title {
        font-weight: 600;
        font-size: 1.2rem;
    }
    
    .modal-body {
        padding: 25px;
    }
    
    .modal-footer {
        border-top: 1px solid #e2e8f0;
        padding: 20px 25px;
    }
    
    /* Form styling */
    .form-group label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }
    
    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 15px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }
    
    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }
    
    .form-control.is-invalid {
        border-color: #ef4444;
    }
    
    .invalid-feedback {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 5px;
    }
    
    /* Custom switch */
    .custom-switch .custom-control-label::before {
        border-radius: 20px;
        background: #e2e8f0;
    }
    
    .custom-switch .custom-control-input:checked ~ .custom-control-label::before {
        background: #3b82f6;
        border-color: #3b82f6;
    }
    
    .custom-switch .custom-control-label::after {
        border-radius: 50%;
    }
    
    /* View table styling */
    .view-table th {
        background: #f8fafc;
        color: #374151;
        font-weight: 600;
        width: 200px;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
    }
    
    .view-table td {
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
    }
    
    /* DataTables customization */
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 20px;
    }
    
    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 12px;
        margin-left: 8px;
    }
    
    .dataTables_wrapper .dataTables_length select {
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 6px 10px;
        margin: 0 8px;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 6px;
        margin: 0 2px;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #3b82f6;
        border-color: #3b82f6;
        color: white !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .doctors-header-card .card-body {
            padding: 20px;
            text-align: center;
        }
        
        .doctors-header-card h2 {
            font-size: 1.5rem;
        }
        
        .btn-add-doctor {
            width: 100%;
            margin-top: 15px;
        }
        
        .modal-dialog {
            margin: 10px;
        }
        
        .table-responsive {
            border-radius: 0;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header Card -->
    <div class="card doctors-header-card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-7">
                    <h2 class="mb-0">
                        <i class="fas fa-user-md mr-3"></i>Doctor Management
                    </h2>
                    <p class="mb-0">Manage referring physicians and specialists</p>
                </div>
                <div class="col-lg-4 col-md-5 text-lg-right text-center">
                    <button class="btn btn-add-doctor" id="createNewDoctor">
                        <i class="fas fa-plus mr-2"></i>Add New Doctor
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Doctors Table Card -->
    <div class="card doctors-table-card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list mr-2"></i>Doctors List
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="doctorsTable">
                    <thead>
                        <tr>
                            <th width="5%">Sr. No.</th>
                            <th width="20%">Doctor Name</th>
                            <th width="15%">Hospital</th>
                            <th width="12%">Contact No.</th>
                            <th width="15%">Specialization</th>
                            <th width="10%">Ref. %</th>
                            <th width="8%">Status</th>
                            <th width="15%">Actions</th>
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

<!-- Add/Edit Doctor Modal -->
<div class="modal fade" id="doctorModal" tabindex="-1" role="dialog" aria-labelledby="doctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="doctorModalLabel">
                    <i class="fas fa-user-md mr-2"></i>Add New Doctor
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="doctorForm">
                <div class="modal-body">
                    <input type="hidden" id="doctorId" name="doctor_id">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="doctorName">
                                    Doctor Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="doctorName" name="doctor_name" required placeholder="Enter doctor's full name">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hospitalName">Hospital Name</label>
                                <input type="text" class="form-control" id="hospitalName" name="hospital_name" placeholder="Enter hospital/clinic name">
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
                                <label for="percent">
                                    Reference % <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control" id="percent" name="percent" min="0" max="100" step="0.01" value="0" placeholder="0.00">
                                <small class="form-text text-muted">Referral percentage (0-100)</small>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specialization">Specialization</label>
                                <input type="text" class="form-control" id="specialization" name="specialization" placeholder="e.g., Cardiology, Orthopedics">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="qualification">Qualification</label>
                                <input type="text" class="form-control" id="qualification" name="qualification" placeholder="e.g., MBBS, MD">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="doctor@example.com">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emergencyContact">Emergency Contact</label>
                                <input type="text" class="form-control" id="emergencyContact" name="emergency_contact" placeholder="Emergency contact number">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="licenseNumber">License Number</label>
                                <input type="text" class="form-control" id="licenseNumber" name="license_number" placeholder="Medical license number">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="licenseExpiry">License Expiry</label>
                                <input type="date" class="form-control" id="licenseExpiry" name="license_expiry">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter complete address"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Additional notes or comments"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="status" name="status" checked>
                                    <label class="custom-control-label" for="status">Active Status</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="saveDoctor">
                        <i class="fas fa-save mr-2"></i>Save Doctor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Doctor Modal -->
<div class="modal fade" id="viewDoctorModal" tabindex="-1" role="dialog" aria-labelledby="viewDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDoctorModalLabel">
                    <i class="fas fa-eye mr-2"></i>Doctor Details
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered view-table">
                        <tbody id="doctorDetails">
                            <!-- Details will be loaded via Ajax -->
                        </tbody>
                    </table>
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
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
    var table = $('#doctorsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.doctors.data') }}",
            error: function(xhr, error, thrown) {
                toastr.error('Error loading doctors data');
            }
        },        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'doctor_name', name: 'doctor_name'},
            {data: 'hospital_name', name: 'hospital_name'},
            {data: 'contact_no', name: 'contact_no'},
            {data: 'specialization', name: 'specialization'},
            {
                data: 'percent', 
                name: 'percent',
                render: function(data, type, row) {
                    return '<span class="badge badge-percent">' + data + '%</span>';
                }
            },
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
        ],
        order: [[1, 'asc']],
        pageLength: 25,
        language: {
            processing: '<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i><br><span class="text-muted">Loading doctors...</span></div>',
            emptyTable: '<div class="text-center py-4"><i class="fas fa-user-md fa-3x text-muted mb-3"></i><br><h5>No doctors found</h5><p class="text-muted">Get started by adding your first doctor</p><button class="btn btn-primary" id="addFirstDoctor"><i class="fas fa-plus mr-2"></i>Add First Doctor</button></div>'
        },
        drawCallback: function() {
            // Enable tooltips
            $('[title]').tooltip();
        }
    });

    // Add first doctor link handler
    $(document).on('click', '#addFirstDoctor', function(e) {
        e.preventDefault();
        $('#createNewDoctor').click();
    });

    // Create new doctor
    $('#createNewDoctor').click(function() {
        resetForm();
        $('#doctorModalLabel').html('<i class="fas fa-user-md mr-2"></i>Add New Doctor');
        $('#doctorModal').modal('show');
    });    // Save doctor
    $('#doctorForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var isEdit = $('#doctorId').val() !== '';
        
        // Explicitly handle status checkbox
        formData.delete('status'); // Remove any existing status
        formData.append('status', $('#status').is(':checked') ? '1' : '0');
        
        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        
        // Show loading
        $('#saveDoctor').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Saving...');
        
        $.ajax({
            url: "{{ route('admin.doctors.store') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#doctorModal').modal('hide');
                table.ajax.reload();
                toastr.success(response.success || 'Doctor saved successfully!');
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        var field = key.replace('_', '');
                        if (key === 'doctor_name') field = 'doctorName';
                        if (key === 'hospital_name') field = 'hospitalName';
                        if (key === 'contact_no') field = 'contactNo';
                        if (key === 'emergency_contact') field = 'emergencyContact';
                        if (key === 'license_number') field = 'licenseNumber';
                        if (key === 'license_expiry') field = 'licenseExpiry';
                        
                        $('#' + field).addClass('is-invalid');
                        $('#' + field).siblings('.invalid-feedback').text(value[0]);
                    });
                    toastr.error('Please correct the errors and try again');
                } else {
                    toastr.error('An error occurred while saving doctor');
                }
            },
            complete: function() {
                $('#saveDoctor').prop('disabled', false).html('<i class="fas fa-save mr-2"></i>Save Doctor');
            }
        });
    });

    // Edit doctor
    $(document).on('click', '.editDoctor', function() {
        var id = $(this).data('id');
        resetForm();
        
        // Show loading
        toastr.info('Loading doctor data...');
        
        $.ajax({
            url: "{{ route('admin.doctors.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                $('#doctorId').val(data.id);
                $('#doctorName').val(data.doctor_name);
                $('#hospitalName').val(data.hospital_name);
                $('#contactNo').val(data.contact_no);
                $('#address').val(data.address);
                $('#percent').val(data.percent);
                $('#specialization').val(data.specialization);
                $('#qualification').val(data.qualification);
                $('#email').val(data.email);
                $('#emergencyContact').val(data.emergency_contact);
                $('#licenseNumber').val(data.license_number);                $('#licenseExpiry').val(data.license_expiry);
                $('#notes').val(data.notes);
                
                // Handle status checkbox correctly
                if (data.status == 1) {
                    $('#status').prop('checked', true);
                } else {
                    $('#status').prop('checked', false);
                }
                
                $('#doctorModalLabel').html('<i class="fas fa-edit mr-2"></i>Edit Doctor');
                $('#doctorModal').modal('show');
            },
            error: function() {
                toastr.error('Error loading doctor data');
            }
        });
    });

    // View doctor
    $(document).on('click', '.viewDoctor', function() {
        var id = $(this).data('id');
        
        // Show loading
        toastr.info('Loading doctor details...');
        
        $.ajax({
            url: "{{ route('admin.doctors.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {                var detailsHtml = `
                    <tr><th>Doctor Name</th><td>${data.doctor_name || 'N/A'}</td></tr>
                    <tr><th>Hospital Name</th><td>${data.hospital_name || 'N/A'}</td></tr>
                    <tr><th>Contact No.</th><td>${data.contact_no || 'N/A'}</td></tr>
                    <tr><th>Address</th><td>${data.address || 'N/A'}</td></tr>
                    <tr><th>Reference %</th><td><span class="badge badge-percent">${data.percent}%</span></td></tr>
                    <tr><th>Specialization</th><td>${data.specialization || 'N/A'}</td></tr>
                    <tr><th>Qualification</th><td>${data.qualification || 'N/A'}</td></tr>
                    <tr><th>Email</th><td>${data.email || 'N/A'}</td></tr>
                    <tr><th>Emergency Contact</th><td>${data.emergency_contact || 'N/A'}</td></tr>
                    <tr><th>License Number</th><td>${data.license_number || 'N/A'}</td></tr>
                    <tr><th>License Expiry</th><td>${data.license_expiry || 'N/A'}</td></tr>
                    <tr><th>Notes</th><td>${data.notes || 'N/A'}</td></tr>
                    <tr><th>Status</th><td>${data.status == 1 ? '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Active</span>' : '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Inactive</span>'}</td></tr>
                    <tr><th>Created At</th><td>${new Date(data.created_at).toLocaleString()}</td></tr>
                    <tr><th>Updated At</th><td>${new Date(data.updated_at).toLocaleString()}</td></tr>
                `;
                
                $('#doctorDetails').html(detailsHtml);
                $('#viewDoctorModal').modal('show');
            },
            error: function() {
                toastr.error('Error loading doctor data');
            }
        });
    });

    // Delete doctor
    $(document).on('click', '.deleteDoctor', function() {
        var id = $(this).data('id');
        var doctorName = $(this).closest('tr').find('td:nth-child(2)').text();
        
        // SweetAlert confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete "${doctorName}". This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.doctors.destroy', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        table.ajax.reload();
                        toastr.success(response.success || 'Doctor deleted successfully!');
                    },
                    error: function() {
                        toastr.error('Error deleting doctor');
                    }
                });
            }
        });
    });

    // Reset form function
    function resetForm() {
        $('#doctorForm')[0].reset();
        $('#doctorId').val('');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        $('#status').prop('checked', true);
    }

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush
