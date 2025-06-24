@extends('admin.layouts.app')

@section('title', 'Create Medical Report')
@section('page-title', 'Create Report')
@section('breadcrumb', 'Reports / Create')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .create-report-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
    }
    
    .form-section {
        background: white;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }
    
    .section-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #374151;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e5e7eb;
        display: flex;
        align-items: center;
    }
    
    .form-group label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }
    
    .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .test-results-section {
        background: #f8fafc;
        border-radius: 10px;
        padding: 20px;
        margin-top: 20px;
    }
    
    .test-row {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 15px;
        border: 1px solid #e5e7eb;
        position: relative;
    }
    
    .test-row .remove-test {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .test-row .remove-test:hover {
        background: #dc2626;
        transform: scale(1.1);
    }
    
    .add-test-btn {
        background: linear-gradient(45deg, #10b981 0%, #34d399 100%);
        border: none;
        border-radius: 8px;
        padding: 12px 25px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .add-test-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
        color: white;
    }
    
    .submit-btn {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 15px 40px;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }
    
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .status-select {
        appearance: none;
        background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6,9 12,15 18,9"/></svg>');
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 20px;
        padding-right: 40px;
    }
    
    .select2-container--default .select2-selection--single {
        height: 45px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 41px;
        padding-left: 15px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 41px;
        right: 10px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Back Button -->
    <div class="mb-3">
        <a href="{{ route('admin.reports') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Reports
        </a>
    </div>

    <div class="create-report-container">
        <!-- Form Header -->
        <div class="form-header">
            <h2 class="mb-0"><i class="fas fa-file-medical mr-3"></i>Create New Medical Report</h2>
            <p class="mb-0 opacity-75">Generate a comprehensive laboratory report with test results</p>
        </div>

        <!-- Form Content -->
        <div class="p-4">
            <form id="createReportForm">
                @csrf
                
                <!-- Basic Information -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-info-circle mr-2"></i>Basic Information
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="patient_id">Patient <span class="text-danger">*</span></label>
                                <select class="form-control patient-select" id="patient_id" name="patient_id" required>
                                    <option value="">Select Patient</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->name }} - {{ $patient->phone }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="doctor_id">Referring Doctor <span class="text-danger">*</span></label>
                                <select class="form-control doctor-select" id="doctor_id" name="doctor_id" required>
                                    <option value="">Select Doctor</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">Dr. {{ $doctor->name }} - {{ $doctor->specialization ?? 'General' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sample_collection_date">Sample Collection Date <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" id="sample_collection_date" name="sample_collection_date" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="technician_name">Lab Technician</label>
                                <input type="text" class="form-control" id="technician_name" name="technician_name" placeholder="Enter technician name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pathologist_name">Pathologist</label>
                                <input type="text" class="form-control" id="pathologist_name" name="pathologist_name" placeholder="Enter pathologist name">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Test Results -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-flask mr-2"></i>Test Results
                    </div>
                    
                    <div class="test-results-section">
                        <div id="testResultsContainer">
                            <!-- Test rows will be added here -->
                        </div>
                        
                        <button type="button" class="btn add-test-btn" onclick="addTestRow()">
                            <i class="fas fa-plus mr-2"></i>Add Test Result
                        </button>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-clipboard mr-2"></i>Additional Information
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="comments">Clinical Comments</label>
                                <textarea class="form-control" id="comments" name="comments" rows="4" placeholder="Enter any clinical observations or recommendations..."></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="total_amount">Total Amount ($)</label>
                                <input type="number" step="0.01" class="form-control" id="total_amount" name="total_amount" placeholder="0.00">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="discount">Discount ($)</label>
                                <input type="number" step="0.01" class="form-control" id="discount" name="discount" placeholder="0.00">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="final_amount">Final Amount ($)</label>
                                <input type="number" step="0.01" class="form-control" id="final_amount" name="final_amount" placeholder="0.00" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="payment_status">Payment Status</label>
                                <select class="form-control status-select" id="payment_status" name="payment_status">
                                    <option value="pending">Pending</option>
                                    <option value="partial">Partial</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn submit-btn">
                        <i class="fas fa-save mr-2"></i>Create Medical Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
let testRowCounter = 0;
const availableTests = @json($tests);

$(document).ready(function() {
    // Initialize Select2
    $('.patient-select, .doctor-select').select2({
        theme: 'bootstrap4',
        placeholder: 'Search and select...',
        allowClear: true
    });
    
    // Set default sample collection date to now
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('sample_collection_date').value = now.toISOString().slice(0, 16);
    
    // Add first test row
    addTestRow();
    
    // Calculate final amount
    $('#total_amount, #discount').on('input', function() {
        calculateFinalAmount();
    });
    
    // Form submission
    $('#createReportForm').on('submit', function(e) {
        e.preventDefault();
        
        if (validateForm()) {
            submitReport();
        }
    });
});

function addTestRow() {
    testRowCounter++;
    
    const testOptions = availableTests.map(test => 
        `<option value="${test.id}">${test.name}</option>`
    ).join('');
    
    const testRow = `
        <div class="test-row" id="testRow${testRowCounter}">
            <button type="button" class="remove-test" onclick="removeTestRow(${testRowCounter})">
                <i class="fas fa-times"></i>
            </button>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Test Name <span class="text-danger">*</span></label>
                        <select class="form-control test-select" name="tests[${testRowCounter}][test_id]" required>
                            <option value="">Select Test</option>
                            ${testOptions}
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Result <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tests[${testRowCounter}][result_value]" placeholder="Enter result" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Reference Range <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tests[${testRowCounter}][reference_range]" placeholder="e.g., 3.5-5.0" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Unit</label>
                        <input type="text" class="form-control" name="tests[${testRowCounter}][unit]" placeholder="e.g., mg/dL">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select class="form-control status-select" name="tests[${testRowCounter}][status]" required>
                            <option value="normal">Normal</option>
                            <option value="high">High</option>
                            <option value="low">Low</option>
                            <option value="critical">Critical</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Remarks</label>
                        <input type="text" class="form-control" name="tests[${testRowCounter}][remarks]" placeholder="Any additional remarks or observations">
                    </div>
                </div>
            </div>
        </div>
    `;
    
    $('#testResultsContainer').append(testRow);
    
    // Initialize Select2 for the new test select
    $(`#testRow${testRowCounter} .test-select`).select2({
        theme: 'bootstrap4',
        placeholder: 'Search and select test...',
        allowClear: true
    });
}

function removeTestRow(rowId) {
    if ($('.test-row').length > 1) {
        $(`#testRow${rowId}`).fadeOut(300, function() {
            $(this).remove();
        });
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Cannot Remove',
            text: 'At least one test result is required.',
            timer: 2000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    }
}

function calculateFinalAmount() {
    const total = parseFloat($('#total_amount').val()) || 0;
    const discount = parseFloat($('#discount').val()) || 0;
    const final = total - discount;
    $('#final_amount').val(final.toFixed(2));
}

function validateForm() {
    // Check if at least one test is added
    if ($('.test-row').length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'No Tests Added',
            text: 'Please add at least one test result.',
            confirmButtonColor: '#ef4444'
        });
        return false;
    }
    
    // Check required fields
    let isValid = true;
    const requiredFields = ['patient_id', 'doctor_id', 'sample_collection_date'];
    
    requiredFields.forEach(field => {
        if (!$(`#${field}`).val()) {
            $(`#${field}`).addClass('is-invalid');
            isValid = false;
        } else {
            $(`#${field}`).removeClass('is-invalid');
        }
    });
    
    // Check test fields
    $('.test-row').each(function() {
        const testId = $(this).find('select[name*="[test_id]"]').val();
        const result = $(this).find('input[name*="[result_value]"]').val();
        const reference = $(this).find('input[name*="[reference_range]"]').val();
        const status = $(this).find('select[name*="[status]"]').val();
        
        if (!testId || !result || !reference || !status) {
            $(this).find('input, select').each(function() {
                if (!$(this).val() && $(this).prop('required')) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                }
            });
        }
    });
    
    if (!isValid) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: 'Please fill in all required fields.',
            confirmButtonColor: '#ef4444'
        });
    }
    
    return isValid;
}

function submitReport() {
    // Show loading
    Swal.fire({
        title: 'Creating Report...',
        text: 'Please wait while we create the medical report.',
        icon: 'info',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    const formData = new FormData($('#createReportForm')[0]);
    
    $.ajax({
        url: '{{ route("admin.reports.store") }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            Swal.close();
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Report Created!',
                    text: response.message,
                    showCancelButton: true,
                    confirmButtonText: 'View Report',
                    cancelButtonText: 'Create Another',
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#6b7280'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `/admin/reports/${response.report_id}`;
                    } else {
                        location.reload();
                    }
                });
            }
        },
        error: function(xhr) {
            Swal.close();
            const errorMessage = xhr.responseJSON?.message || 'An error occurred while creating the report.';
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: errorMessage,
                confirmButtonColor: '#ef4444'
            });
        }
    });
}
</script>
@endpush
@endsection
