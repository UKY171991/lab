@extends('admin.layouts.app')

@section('title', 'Patient Entry')
@section('page-title', 'Patient Entry')
@section('breadcrumb', 'Master / Patients')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

<style>
.card-header {
    background: linear-gradient(45deg, #28a745, #20c997);
    color: white;
}
.table-actions .btn {
    margin: 0 2px;
}
.modal-header {
    background: linear-gradient(45deg, #28a745, #20c997);
    color: white;
}
.modal-header .close {
    color: white;
    opacity: 0.8;
}
.modal-header .close:hover {
    opacity: 1;
}
.form-control:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}
.badge-pink {
    background-color: #e83e8c;
    color: white;
}
.view-table th {
    background-color: #f8f9fa;
    width: 30%;
    font-weight: 600;
}
.view-table td {
    padding: 12px 15px;
}
.uhid-display {
    font-family: 'Courier New', monospace;
    font-weight: bold;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-users mr-2"></i>Patient Entry
                        </h3>
                        <button class="btn btn-light btn-sm" id="createNewPatient">
                            <i class="fas fa-plus mr-2"></i>Add New Patient
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="patientsTable">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">Sr. No.</th>
                                    <th width="20%">Client Name</th>
                                    <th width="15%">Mobile Number</th>
                                    <th width="15%">UHID</th>
                                    <th width="8%">Sex</th>
                                    <th width="8%">Age</th>
                                    <th width="10%">Status</th>
                                    <th width="19%">Actions</th>
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
                                    <button type="button" class="btn btn-primary btn-xs ml-2" id="newClientBtn">
                                        New
                                    </button>
                                </label>
                                <input type="text" class="form-control" id="clientName" name="client_name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mobileNumber">Mobile Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="mobileNumber" name="mobile_number" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fatherHusbandName">Father / Husband</label>
                                <input type="text" class="form-control" id="fatherHusbandName" name="father_husband_name">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="2"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 3 -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sex">Sex</label>
                                <select class="form-control" id="sex" name="sex">
                                    <option value="">Select Sex</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="number" class="form-control" id="age" name="age" min="0" max="150">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="uhid">UHID</label>
                                <input type="text" class="form-control uhid-display" id="uhid" name="uhid" readonly>
                                <small class="form-text text-muted">Auto-generated unique hospital ID</small>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Fields Row -->
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
                                <label for="dateOfBirth">Date of Birth</label>
                                <input type="date" class="form-control" id="dateOfBirth" name="date_of_birth">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 5 -->
                    <div class="row">
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="occupation">Occupation</label>
                                <input type="text" class="form-control" id="occupation" name="occupation">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="emergencyContact">Emergency Contact</label>
                                <input type="text" class="form-control" id="emergencyContact" name="emergency_contact">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 6 -->
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

                    <!-- Row 7 -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
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
                        <i class="fas fa-times mr-2"></i>Close
                    </button>
                    <button type="submit" class="btn btn-success" id="savePatient">
                        <i class="fas fa-save mr-2"></i>Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Patient Modal -->
<div class="modal fade" id="viewPatientModal" tabindex="-1" role="dialog" aria-labelledby="viewPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewPatientModalLabel">
                    <i class="fas fa-eye mr-2"></i>Patient Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered view-table">
                        <tbody id="patientDetails">
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
    var table = $('#patientsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.patients.data') }}",
            error: function(xhr, error, thrown) {
                toastr.error('Error loading patients data');
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'client_name', name: 'client_name'},
            {data: 'mobile_number', name: 'mobile_number'},
            {data: 'uhid', name: 'uhid', className: 'uhid-display'},
            {data: 'sex_badge', name: 'sex', orderable: false},
            {data: 'age_display', name: 'age', orderable: false},
            {data: 'status', name: 'status', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'table-actions text-center'}
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
        $('#patientModalLabel').html('<i class="fas fa-user-plus mr-2"></i>Patient Entry');
        $('#patientModal').modal('show');
        toastr.info('Fill in the patient details');
    });

    // New client button functionality
    $('#newClientBtn').click(function() {
        $('#clientName').val('').focus();
        toastr.info('Enter new client name');
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
                toastr.success(response.success);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        var field = key.replace('_', '');
                        if (key === 'client_name') field = 'clientName';
                        if (key === 'mobile_number') field = 'mobileNumber';
                        if (key === 'father_husband_name') field = 'fatherHusbandName';
                        if (key === 'date_of_birth') field = 'dateOfBirth';
                        if (key === 'blood_group') field = 'bloodGroup';
                        if (key === 'emergency_contact') field = 'emergencyContact';
                        if (key === 'medical_history') field = 'medicalHistory';
                        
                        $('#' + field).addClass('is-invalid');
                        $('#' + field).siblings('.invalid-feedback').text(value[0]);
                    });
                    toastr.error('Please correct the errors and try again');
                } else {
                    toastr.error('An error occurred while saving patient');
                }
            },
            complete: function() {
                $('#savePatient').prop('disabled', false).html('<i class="fas fa-save mr-2"></i>Save');
            }
        });
    });

    // Edit patient
    $(document).on('click', '.editPatient', function() {
        var id = $(this).data('id');
        resetForm();
        
        $.ajax({
            url: "{{ route('admin.patients.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
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
                
                $('#patientModalLabel').html('<i class="fas fa-edit mr-2"></i>Edit Patient');
                $('#patientModal').modal('show');
                toastr.info('Edit patient details');
            },
            error: function() {
                toastr.error('Error loading patient data');
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
                var sexBadge = data.sex ? 
                    '<span class="badge badge-' + (data.sex === 'Male' ? 'primary' : (data.sex === 'Female' ? 'pink' : 'secondary')) + '">' + data.sex + '</span>' : 
                    'N/A';
                
                var detailsHtml = `
                    <tr><th>Client Name</th><td>${data.client_name || 'N/A'}</td></tr>
                    <tr><th>Mobile Number</th><td>${data.mobile_number || 'N/A'}</td></tr>
                    <tr><th>Father / Husband</th><td>${data.father_husband_name || 'N/A'}</td></tr>
                    <tr><th>Address</th><td>${data.address || 'N/A'}</td></tr>
                    <tr><th>Sex</th><td>${sexBadge}</td></tr>
                    <tr><th>Age</th><td>${data.age ? data.age + ' years' : 'N/A'}</td></tr>
                    <tr><th>UHID</th><td><span class="uhid-display">${data.uhid || 'N/A'}</span></td></tr>
                    <tr><th>Email</th><td>${data.email || 'N/A'}</td></tr>
                    <tr><th>Date of Birth</th><td>${data.date_of_birth || 'N/A'}</td></tr>
                    <tr><th>Blood Group</th><td>${data.blood_group || 'N/A'}</td></tr>
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
                toastr.info('Viewing patient details');
            },
            error: function() {
                toastr.error('Error loading patient data');
            }
        });
    });

    // Delete patient
    $(document).on('click', '.deletePatient', function() {
        var id = $(this).data('id');
        var patientName = $(this).closest('tr').find('td:nth-child(2)').text();
        
        if (confirm('Are you sure you want to delete "' + patientName + '"?\n\nThis action cannot be undone.')) {
            $.ajax({
                url: "{{ route('admin.patients.destroy', ':id') }}".replace(':id', id),
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    table.ajax.reload();
                    toastr.success(response.success);
                },
                error: function() {
                    toastr.error('Error deleting patient');
                }
            });
        }
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
