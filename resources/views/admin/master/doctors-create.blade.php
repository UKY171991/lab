@extends('admin.layouts.app')

@section('title', 'Add New Doctor')
@section('page-title', 'Add New Doctor')
@section('breadcrumb', 'Master / Doctors / Add New')

@push('styles')
<!-- Select2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

<style>
    .form-header {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
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
        border-left: 4px solid #3b82f6;
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
        color: #3b82f6;
    }
    
    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    }
    
    .btn-save {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        border: none;
        border-radius: 8px;
        padding: 12px 30px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
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
                    <i class="fas fa-user-md mr-3"></i>Add New Doctor
                </h3>
                <p class="mb-0 mt-2 opacity-75">Enter doctor information to create a new record</p>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('admin.doctors') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Doctors
                </a>
            </div>
        </div>
    </div>

    <form id="doctorForm" action="{{ route('admin.doctors.store') }}" method="POST">
        @csrf
        
        <!-- Basic Information Section -->
        <div class="form-section">
            <div class="section-title">
                <i class="fas fa-user-md"></i>Basic Information
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="doctor_name">Doctor Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="doctor_name" name="doctor_name" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="contact_no">Contact Number <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="contact_no" name="contact_no" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email">
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

        <!-- Professional Details Section -->
        <div class="form-section">
            <div class="section-title">
                <i class="fas fa-graduation-cap"></i>Professional Details
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="hospital_name">Hospital/Clinic Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="hospital_name" name="hospital_name" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="specialization">Specialization <span class="text-danger">*</span></label>
                        <select class="form-control" id="specialization" name="specialization" required>
                            <option value="">Select Specialization</option>
                            <option value="Cardiology">Cardiology</option>
                            <option value="Dermatology">Dermatology</option>
                            <option value="Endocrinology">Endocrinology</option>
                            <option value="Gastroenterology">Gastroenterology</option>
                            <option value="General Medicine">General Medicine</option>
                            <option value="General Surgery">General Surgery</option>
                            <option value="Gynecology">Gynecology</option>
                            <option value="Neurology">Neurology</option>
                            <option value="Oncology">Oncology</option>
                            <option value="Ophthalmology">Ophthalmology</option>
                            <option value="Orthopedics">Orthopedics</option>
                            <option value="Pediatrics">Pediatrics</option>
                            <option value="Psychiatry">Psychiatry</option>
                            <option value="Radiology">Radiology</option>
                            <option value="Urology">Urology</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="qualification">Qualification <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="qualification" name="qualification" required placeholder="e.g., MBBS, MD, MS">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="percent">Commission Percentage</label>
                        <input type="number" class="form-control" id="percent" name="percent" step="0.01" min="0" max="100" placeholder="0.00">
                    </div>
                </div>
            </div>
        </div>

        <!-- License Information Section -->
        <div class="form-section">
            <div class="section-title">
                <i class="fas fa-certificate"></i>License Information
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="license_number">License Number</label>
                        <input type="text" class="form-control" id="license_number" name="license_number">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="license_expiry">License Expiry Date</label>
                        <input type="date" class="form-control" id="license_expiry" name="license_expiry">
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
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" placeholder="Full address including city, state, and postal code"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information Section -->
        <div class="form-section">
            <div class="section-title">
                <i class="fas fa-clipboard"></i>Additional Information
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Any additional information about the doctor..."></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row">
            <div class="col-md-12 text-right">
                <a href="{{ route('admin.doctors') }}" class="btn btn-cancel mr-2">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-save">
                    <i class="fas fa-save mr-2"></i>Save Doctor
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
    $('#specialization').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: 'Select Specialization'
    });

    $('#status').select2({
        theme: 'bootstrap4',
        width: '100%'
    });

    // Form submission
    $('#doctorForm').on('submit', function(e) {
        e.preventDefault();
        
        // Show loading
        Swal.fire({
            title: 'Saving...',
            text: 'Please wait while we save the doctor information.',
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
                    text: 'Doctor has been saved successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '{{ route("admin.doctors") }}';
                });
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred while saving the doctor.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    // Handle validation errors
                    let errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors).flat().join('\n');
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

    // License expiry date validation
    $('#license_expiry').on('change', function() {
        const selectedDate = new Date($(this).val());
        const today = new Date();
        
        if (selectedDate < today) {
            Swal.fire({
                title: 'Warning!',
                text: 'The license expiry date is in the past. Please verify the date.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        }
    });

    // Commission percentage validation
    $('#percent').on('input', function() {
        const value = parseFloat($(this).val());
        if (value > 100) {
            $(this).val(100);
        } else if (value < 0) {
            $(this).val(0);
        }
    });

    // Format contact numbers
    $('#contact_no, #emergency_contact').on('input', function() {
        // Remove non-digit characters
        let value = $(this).val().replace(/\D/g, '');
        
        // Limit to 10 digits
        if (value.length > 10) {
            value = value.substring(0, 10);
        }
        
        $(this).val(value);
    });

    // Auto-focus on first field
    $('#doctor_name').focus();
});
</script>
@endpush
