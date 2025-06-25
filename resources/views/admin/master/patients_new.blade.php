@extends('admin.layouts.app')

@section('title', 'Patient Management')
@section('page-title', 'Patient Management')
@section('breadcrumb', 'Master / Patients')

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

<style>
    .patients-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    
    .patients-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 100px;
        height: 200%;
        background: rgba(255,255,255,0.1);
        transform: rotate(15deg);
    }
    
    .stats-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border-left: 4px solid var(--accent-color);
        margin-bottom: 20px;
    }
    
    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .main-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: none;
    }
    
    .card-header {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: white;
        border: none;
        padding: 20px 25px;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
        color: #374151;
        background: #f8fafc;
    }
    
    .table-hover tbody tr:hover {
        background-color: #f1f5f9;
    }
    
    .btn-group .btn {
        margin: 0 1px;
        border-radius: 6px !important;
    }
    
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }
    
    .modal-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    
    .modal-header .close {
        color: white;
        opacity: 0.8;
        font-size: 1.5rem;
        text-shadow: none;
    }
    
    .modal-header .close:hover {
        opacity: 1;
        color: white;
    }
    
    .form-control:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
    }
    
    .form-group label {
        font-weight: 600;
        color: #374151;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 5px 10px;
        border-radius: 12px;
    }
    
    .badge-success {
        background: linear-gradient(45deg, #10b981, #059669);
    }
    
    .badge-danger {
        background: linear-gradient(45deg, #ef4444, #dc2626);
    }
    
    .badge-primary {
        background: linear-gradient(45deg, #3b82f6, #2563eb);
    }
    
    .badge-pink {
        background: linear-gradient(45deg, #ec4899, #db2777);
    }
    
    .badge-secondary {
        background: linear-gradient(45deg, #6b7280, #4b5563);
    }
    
    .uhid-display {
        font-family: 'Courier New', monospace;
        font-weight: bold;
        color: #059669;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="patients-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-2">
                    <i class="fas fa-users mr-3"></i>Patient Management
                </h2>
                <p class="mb-0 opacity-75">Manage patient information and medical records</p>
            </div>
            <div class="col-md-4 text-right">
                <button type="button" class="btn btn-light btn-lg" id="createNewPatient">
                    <i class="fas fa-user-plus mr-2"></i>Add New Patient
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card" style="--accent-color: #3b82f6;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1" style="color: #3b82f6; font-weight: bold;">{{ \App\Models\Patient::count() }}</h5>
                        <p class="mb-0 text-muted">Total Patients</p>
                    </div>
                    <i class="fas fa-users fa-2x" style="color: #3b82f6; opacity: 0.7;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="--accent-color: #10b981;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1" style="color: #10b981; font-weight: bold;">{{ \App\Models\Patient::where('created_at', '>=', now()->subDays(30))->count() }}</h5>
                        <p class="mb-0 text-muted">New This Month</p>
                    </div>
                    <i class="fas fa-user-plus fa-2x" style="color: #10b981; opacity: 0.7;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="--accent-color: #f59e0b;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1" style="color: #f59e0b; font-weight: bold;">{{ \App\Models\Patient::where('status', true)->count() }}</h5>
                        <p class="mb-0 text-muted">Active Patients</p>
                    </div>
                    <i class="fas fa-file-medical fa-2x" style="color: #f59e0b; opacity: 0.7;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="--accent-color: #ef4444;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1" style="color: #ef4444; font-weight: bold;">{{ \App\Models\Patient::where('created_at', '>=', now()->subDay())->count() }}</h5>
                        <p class="mb-0 text-muted">Today's Registrations</p>
                    </div>
                    <i class="fas fa-calendar-day fa-2x" style="color: #ef4444; opacity: 0.7;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card main-card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-table mr-2"></i>Patients List
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="patientsTable">
                    <thead>
                        <tr>
                            <th width="5%">Sr. No.</th>
                            <th width="20%">Patient Name</th>
                            <th width="15%">Mobile Number</th>
                            <th width="12%">UHID</th>
                            <th width="8%">Gender</th>
                            <th width="8%">Age</th>
                            <th width="12%">Registration Date</th>
                            <th width="10%">Status</th>
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
</div>

<!-- Add/Edit Patient Modal -->
<div class="modal fade" id="patientModal" tabindex="-1" role="dialog" aria-labelledby="patientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="patientModalLabel">
                    <i class="fas fa-user-plus mr-2"></i>Patient Entry
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="patientForm">
                <div class="modal-body">
                    <input type="hidden" id="patientId" name="patient_id">
                    
                    <!-- Row 1 -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="clientName">
                                    Client Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="clientName" name="client_name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mobileNumber">
                                    Mobile Number <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="mobileNumber" name="mobile_number" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fatherHusbandName">Father/Husband Name</label>
                                <input type="text" class="form-control" id="fatherHusbandName" name="father_husband_name">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 3 -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sex">Gender</label>
                                <select class="form-control" id="sex" name="sex">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="number" class="form-control" id="age" name="age" min="0" max="150">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="dateOfBirth">Date of Birth</label>
                                <input type="date" class="form-control" id="dateOfBirth" name="date_of_birth">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 4 -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bloodGroup">Blood Group</label>
                                <select class="form-control" id="bloodGroup" name="blood_group">
                                    <option value="">Select Blood Group</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="occupation">Occupation</label>
                                <input type="text" class="form-control" id="occupation" name="occupation">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 5 -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emergencyContact">Emergency Contact</label>
                                <input type="text" class="form-control" id="emergencyContact" name="emergency_contact">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="uhid">UHID</label>
                                <input type="text" class="form-control" id="uhid" name="uhid" readonly>
                                <small class="form-text text-muted">Auto-generated if left empty</small>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 6 -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="2"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 7 -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="medicalHistory">Medical History</label>
                                <textarea class="form-control" id="medicalHistory" name="medical_history" rows="3"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="allergies">Allergies</label>
                                <textarea class="form-control" id="allergies" name="allergies" rows="3"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 8 -->
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="status" name="status" checked>
                                    <label class="custom-control-label" for="status">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-success" id="savePatient">
                        <i class="fas fa-save mr-2"></i>Save Patient
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Patient Modal -->
<div class="modal fade" id="viewPatientModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user mr-2"></i>Patient Details
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-borderless" id="patientDetails">
                        <!-- Patient details will be loaded here -->
                    </table>
                </div>
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
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#patientsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.patients.data') }}",
            error: function(xhr, error, thrown) {
                console.error('DataTable AJAX Error:', xhr, error, thrown);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error loading patients data. Please try refreshing the page.',
                    timer: 5000,
                    timerProgressBar: true
                });
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'client_name', name: 'client_name'},
            {data: 'mobile_number', name: 'mobile_number'},
            {data: 'uhid', name: 'uhid', className: 'uhid-display'},
            {data: 'sex_badge', name: 'sex', orderable: false},
            {data: 'age_display', name: 'age', orderable: false},
            {data: 'created_at_formatted', name: 'created_at'},
            {data: 'status', name: 'status', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
        ],
        order: [[1, 'asc']],
        pageLength: 25,
        language: {
            processing: '<i class="fas fa-spinner fa-spin fa-2x"></i><br>Loading...',
            emptyTable: 'No patients found. <a href="#" id="addFirstPatient" class="btn btn-success btn-sm mt-2"><i class="fas fa-plus"></i> Add First Patient</a>'
        }
    });

    // Add first patient link handler
    $(document).on('click', '#addFirstPatient', function(e) {
        e.preventDefault();
        $('#createNewPatient').click();
    });

    // Create new patient
    $('#createNewPatient').click(function() {
        resetForm();
        $('#patientModalLabel').html('<i class="fas fa-user-plus mr-2"></i>Add New Patient');
        $('#patientModal').modal('show');
        Swal.fire({
            icon: 'info',
            title: 'Add New Patient',
            text: 'Fill in the patient details',
            timer: 2000,
            timerProgressBar: true,
            toast: true,
            position: 'top-end',
            showConfirmButton: false
        });
    });

    // Auto-calculate age from date of birth
    $('#dateOfBirth').change(function() {
        var dob = new Date($(this).val());
        var today = new Date();
        var age = today.getFullYear() - dob.getFullYear();
        var monthDiff = today.getMonth() - dob.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }
        
        if (age >= 0 && age <= 150) {
            $('#age').val(age);
        }
    });

    // Save patient
    $('#patientForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var isEdit = $('#patientId').val() !== '';
        
        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        
        // Show loading
        $('#savePatient').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Saving...');
        
        $.ajax({
            url: "{{ route('admin.patients.store') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#patientModal').modal('hide');
                table.ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.success,
                    timer: 3000,
                    timerProgressBar: true,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false
                });
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        var field = key.replace(/_([a-z])/g, function(match, letter) {
                            return letter.toUpperCase();
                        });
                        field = field.charAt(0).toLowerCase() + field.slice(1);
                        
                        // Handle special field mappings
                        var fieldMappings = {
                            'clientName': 'client_name',
                            'mobileNumber': 'mobile_number',
                            'fatherHusbandName': 'father_husband_name',
                            'dateOfBirth': 'date_of_birth',
                            'bloodGroup': 'blood_group',
                            'emergencyContact': 'emergency_contact',
                            'medicalHistory': 'medical_history'
                        };
                        
                        Object.keys(fieldMappings).forEach(function(jsField) {
                            if (fieldMappings[jsField] === key) {
                                field = jsField;
                            }
                        });
                        
                        $('#' + field).addClass('is-invalid');
                        $('#' + field).siblings('.invalid-feedback').text(value[0]);
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while saving the patient',
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
            },
            complete: function() {
                $('#savePatient').prop('disabled', false).html('<i class="fas fa-save mr-2"></i>Save Patient');
            }
        });
    });

    // Edit patient
    $(document).on('click', '.editPatient', function() {
        var id = $(this).data('id');
        
        $.ajax({
            url: "{{ route('admin.patients.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                resetForm();
                $('#patientModalLabel').html('<i class="fas fa-edit mr-2"></i>Edit Patient');
                
                // Fill form with data
                $('#patientId').val(data.id);
                $('#clientName').val(data.client_name);
                $('#mobileNumber').val(data.mobile_number);
                $('#fatherHusbandName').val(data.father_husband_name);
                $('#address').val(data.address);
                $('#sex').val(data.sex);
                $('#age').val(data.age);
                $('#uhid').val(data.uhid);
                $('#email').val(data.email);
                $('#dateOfBirth').val(data.date_of_birth);
                $('#bloodGroup').val(data.blood_group);
                $('#occupation').val(data.occupation);
                $('#emergencyContact').val(data.emergency_contact);
                $('#medicalHistory').val(data.medical_history);
                $('#allergies').val(data.allergies);
                $('#notes').val(data.notes);
                $('#status').prop('checked', data.status);
                
                $('#patientModal').modal('show');
                
                Swal.fire({
                    icon: 'info',
                    title: 'Edit Patient',
                    text: 'Update patient information',
                    timer: 2000,
                    timerProgressBar: true,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error loading patient data',
                    timer: 3000,
                    timerProgressBar: true
                });
            }
        });
    });

    // View patient
    $(document).on('click', '.viewPatient', function() {
        var id = $(this).data('id');
        
        $.ajax({
            url: "{{ route('admin.patients.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                var detailsHtml = `
                    <tr><th width="30%">Patient Name</th><td><strong>${data.client_name}</strong></td></tr>
                    <tr><th>Mobile Number</th><td>${data.mobile_number}</td></tr>
                    <tr><th>UHID</th><td><span class="uhid-display">${data.uhid || 'N/A'}</span></td></tr>
                    <tr><th>Father/Husband Name</th><td>${data.father_husband_name || 'N/A'}</td></tr>
                    <tr><th>Email</th><td>${data.email || 'N/A'}</td></tr>
                    <tr><th>Gender</th><td>${data.sex ? '<span class="badge badge-' + (data.sex === 'Male' ? 'primary' : data.sex === 'Female' ? 'pink' : 'secondary') + '">' + data.sex + '</span>' : 'N/A'}</td></tr>
                    <tr><th>Age</th><td>${data.age ? data.age + ' years' : 'N/A'}</td></tr>
                    <tr><th>Date of Birth</th><td>${data.date_of_birth || 'N/A'}</td></tr>
                    <tr><th>Blood Group</th><td>${data.blood_group || 'N/A'}</td></tr>
                    <tr><th>Address</th><td>${data.address || 'N/A'}</td></tr>
                    <tr><th>Occupation</th><td>${data.occupation || 'N/A'}</td></tr>
                    <tr><th>Emergency Contact</th><td>${data.emergency_contact || 'N/A'}</td></tr>
                    <tr><th>Medical History</th><td>${data.medical_history || 'N/A'}</td></tr>
                    <tr><th>Allergies</th><td>${data.allergies || 'N/A'}</td></tr>
                    <tr><th>Notes</th><td>${data.notes || 'N/A'}</td></tr>
                    <tr><th>Status</th><td>${data.status ? '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Active</span>' : '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Inactive</span>'}</td></tr>
                    <tr><th>Created At</th><td>${new Date(data.created_at).toLocaleString()}</td></tr>
                    <tr><th>Updated At</th><td>${new Date(data.updated_at).toLocaleString()}</td></tr>
                `;
                $('#patientDetails').html(detailsHtml);
                $('#viewPatientModal').modal('show');
                
                Swal.fire({
                    icon: 'info',
                    title: 'Patient Details',
                    text: 'Viewing patient details',
                    timer: 2000,
                    timerProgressBar: true,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error loading patient data',
                    timer: 3000,
                    timerProgressBar: true
                });
            }
        });
    });

    // Delete patient
    $(document).on('click', '.deletePatient', function() {
        var id = $(this).data('id');
        var patientName = $(this).closest('tr').find('td:nth-child(2)').text();
        
        Swal.fire({
            title: 'Delete Patient?',
            text: `Are you sure you want to delete "${patientName}"? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.patients.destroy', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.success,
                            timer: 3000,
                            timerProgressBar: true,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error deleting patient',
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                });
            }
        });
    });

    // Reset form function
    function resetForm() {
        $('#patientForm')[0].reset();
        $('#patientId').val('');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        $('#status').prop('checked', true);
        $('#uhid').val(''); // Clear UHID for new patients
    }

    // Enable tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush
