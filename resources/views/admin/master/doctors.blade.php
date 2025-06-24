@extends('admin.layouts.app')

@section('title', 'Doctor Management')
@section('page-title', 'Doctor Management')
@section('breadcrumb', 'Master / Doctors')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

<style>
    .doctors-header {
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        color: white;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    
    .doctors-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 100px;
        height: 200%;
        background: rgba(255,255,255,0.1);
        transform: rotate(15deg);
    }
    
    .doctors-table-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        padding: 25px;
    }
    
    .table th {
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        color: white;
        border: none;
        padding: 15px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    
    .btn-add-doctor {
        background: linear-gradient(45deg, #3b82f6 0%, #1d4ed8 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 25px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-add-doctor:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        color: white;
    }
    
    .modal-header {
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
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
        border-color: #0ea5e9;
        box-shadow: 0 0 0 0.2rem rgba(14, 165, 233, 0.25);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="doctors-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0">
                    <i class="fas fa-user-md mr-3"></i>Doctor Management
                </h1>
                <p class="mb-0 opacity-75">Manage referring physicians and specialists</p>
            </div>
            <div class="col-md-4 text-right">
                <button class="btn btn-add-doctor" id="createNewDoctor">
                    <i class="fas fa-plus mr-2"></i>Add New Doctor
                </button>
            </div>
        </div>
    </div>

    <!-- Doctors Table -->
    <div class="doctors-table-container">
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

<!-- Add/Edit Doctor Modal -->
<div class="modal fade" id="doctorModal" tabindex="-1" role="dialog" aria-labelledby="doctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="doctorModalLabel">
                    <i class="fas fa-user-md mr-2"></i>Add New Doctor
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="doctorForm">
                <div class="modal-body">
                    <input type="hidden" id="doctorId" name="doctor_id">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="doctorName">Doctor Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="doctorName" name="doctor_name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hospitalName">Hospital Name</label>
                                <input type="text" class="form-control" id="hospitalName" name="hospital_name">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contactNo">Contact No.</label>
                                <input type="text" class="form-control" id="contactNo" name="contact_no">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="percent">Reference % <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="percent" name="percent" min="0" max="100" step="0.01" value="0">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specialization">Specialization</label>
                                <input type="text" class="form-control" id="specialization" name="specialization">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="qualification">Qualification</label>
                                <input type="text" class="form-control" id="qualification" name="qualification">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emergencyContact">Emergency Contact</label>
                                <input type="text" class="form-control" id="emergencyContact" name="emergency_contact">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="licenseNumber">License Number</label>
                                <input type="text" class="form-control" id="licenseNumber" name="license_number">
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
                                <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'doctor_name', name: 'doctor_name'},
            {data: 'hospital_name', name: 'hospital_name'},
            {data: 'contact_no', name: 'contact_no'},
            {data: 'percent_display', name: 'percent', orderable: false},
            {data: 'status', name: 'status', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'table-actions text-center'}
        ],
        order: [[1, 'asc']],
        pageLength: 25,
        language: {
            processing: '<i class="fas fa-spinner fa-spin fa-2x"></i><br>Loading...',
            emptyTable: 'No doctors found. <a href="#" id="addFirstDoctor" class="btn btn-primary btn-sm mt-2"><i class="fas fa-plus"></i> Add First Doctor</a>'
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
    });

    // Save doctor
    $('#doctorForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var isEdit = $('#doctorId').val() !== '';
        
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
                toastr.success(response.success);
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
                $('#licenseNumber').val(data.license_number);
                $('#licenseExpiry').val(data.license_expiry);
                $('#notes').val(data.notes);
                $('#status').prop('checked', data.status);
                
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
        
        $.ajax({
            url: "{{ route('admin.doctors.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                var detailsHtml = `
                    <tr><th>Doctor Name</th><td>${data.doctor_name || 'N/A'}</td></tr>
                    <tr><th>Hospital Name</th><td>${data.hospital_name || 'N/A'}</td></tr>
                    <tr><th>Contact No.</th><td>${data.contact_no || 'N/A'}</td></tr>
                    <tr><th>Address</th><td>${data.address || 'N/A'}</td></tr>
                    <tr><th>Reference %</th><td><span class="badge badge-info badge-percent">${data.percent}%</span></td></tr>
                    <tr><th>Specialization</th><td>${data.specialization || 'N/A'}</td></tr>
                    <tr><th>Qualification</th><td>${data.qualification || 'N/A'}</td></tr>
                    <tr><th>Email</th><td>${data.email || 'N/A'}</td></tr>
                    <tr><th>Emergency Contact</th><td>${data.emergency_contact || 'N/A'}</td></tr>
                    <tr><th>License Number</th><td>${data.license_number || 'N/A'}</td></tr>
                    <tr><th>License Expiry</th><td>${data.license_expiry || 'N/A'}</td></tr>
                    <tr><th>Notes</th><td>${data.notes || 'N/A'}</td></tr>
                    <tr><th>Status</th><td>${data.status ? '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Active</span>' : '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Inactive</span>'}</td></tr>
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
        
        if (confirm('Are you sure you want to delete "' + doctorName + '"?\n\nThis action cannot be undone.')) {
            $.ajax({
                url: "{{ route('admin.doctors.destroy', ':id') }}".replace(':id', id),
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    table.ajax.reload();
                    toastr.success(response.success);
                },
                error: function() {
                    toastr.error('Error deleting doctor');
                }
            });
        }
    });

    // Reset form function
    function resetForm() {
        $('#doctorForm')[0].reset();
        $('#doctorId').val('');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        $('#status').prop('checked', true);
    }

    // Enable tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush
