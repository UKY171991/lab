@extends('admin.layouts.app')

@section('title', 'Add New Patient')
@section('page-title', 'Add New Patient')
@section('breadcrumb', 'Master / Patients / Add New')

@push('styles')
<!-- Select2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

<style>
    .form-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    
    .form-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 100px;
        height: 200%;
        background: rgba(255,255,255,0.1);
        transform: rotate(15deg);
    }
    
    .form-section {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
        border-left: 4px solid #10b981;
    }
    
    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }
    
    .section-title i {
        margin-right: 10px;
        color: #10b981;
    }
    
    .form-control:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
    }
    
    .btn-save {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        border-radius: 8px;
        padding: 12px 30px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
        color: white;
    }
    
    .btn-cancel {
        background: #6c757d;
        border: none;
        border-radius: 8px;
        padding: 12px 30px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-cancel:hover {
        background: #5a6268;
        transform: translateY(-2px);
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Form Header -->
    <div class="form-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3 class="mb-0">
                    <i class="fas fa-user-plus mr-3"></i>Add New Patient
                </h3>
                <p class="mb-0 mt-2 opacity-75">Enter patient information to create a new record</p>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('admin.patients') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Patients
                </a>
            </div>
        </div>
    </div>

    <form id="patientForm" action="{{ route('admin.patients.store') }}" method="POST">
        @csrf
        
        <!-- Basic Information Section -->
        <div class="form-section">
            <div class="section-title">
                <i class="fas fa-user"></i>Basic Information
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="client_name">Patient Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="client_name" name="client_name" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mobile_number">Mobile Number <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="mobile_number" name="mobile_number" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="father_husband_name">Father/Husband Name</label>
                        <input type="text" class="form-control" id="father_husband_name" name="father_husband_name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Details Section -->
        <div class="form-section">
            <div class="section-title">
                <i class="fas fa-id-card"></i>Personal Details
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="age">Age <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="age" name="age" min="0" max="150" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="sex">Gender <span class="text-danger">*</span></label>
                        <select class="form-control" id="sex" name="sex" required>
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="blood_group">Blood Group</label>
                        <select class="form-control" id="blood_group" name="blood_group">
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
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="occupation">Occupation</label>
                        <input type="text" class="form-control" id="occupation" name="occupation">
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information Section -->
        <div class="form-section">
            <div class="section-title">
                <i class="fas fa-address-book"></i>Contact Information
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="emergency_contact">Emergency Contact</label>
                        <input type="tel" class="form-control" id="emergency_contact" name="emergency_contact">
                    </div>
                </div>
            </div>
        </div>

        <!-- Medical Information Section -->
        <div class="form-section">
            <div class="section-title">
                <i class="fas fa-stethoscope"></i>Medical Information
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="medical_history">Medical History</label>
                        <textarea class="form-control" id="medical_history" name="medical_history" rows="3" placeholder="Any significant medical history..."></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="allergies">Allergies</label>
                        <textarea class="form-control" id="allergies" name="allergies" rows="3" placeholder="Any known allergies..."></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="notes">Additional Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Any additional information..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row">
            <div class="col-md-12 text-right">
                <a href="{{ route('admin.patients') }}" class="btn btn-cancel mr-2">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-save">
                    <i class="fas fa-save mr-2"></i>Save Patient
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.form-control').select2({
        theme: 'bootstrap4',
        width: '100%'
    });

    // Form submission
    $('#patientForm').on('submit', function(e) {
        e.preventDefault();
        
        // Show loading
        Swal.fire({
            title: 'Saving...',
            text: 'Please wait while we save the patient information.',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        // Submit form
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Patient has been saved successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '{{ route("admin.patients") }}';
                });
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred while saving the patient.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    // Auto-generate UHID
    function generateUHID() {
        const date = new Date();
        const year = date.getFullYear().toString().substr(-2);
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const random = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
        return 'PAT' + year + month + random;
    }

    // Set auto-generated UHID if needed
    if ($('#uhid').length && !$('#uhid').val()) {
        $('#uhid').val(generateUHID());
    }

    // Calculate age from date of birth
    $('#date_of_birth').on('change', function() {
        const dob = new Date($(this).val());
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const monthDiff = today.getMonth() - dob.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }
        
        if (age >= 0 && age <= 150) {
            $('#age').val(age);
        }
    });
});
</script>
@endpush
