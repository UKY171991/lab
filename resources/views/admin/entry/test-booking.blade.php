@extends('admin.layouts.app')

@section('title', 'Test Booking')
@section('page-title', 'Test Booking')
@section('breadcrumb', 'Entry / Test Booking')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css">

<style>
    .booking-header {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    
    .booking-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 100px;
        height: 200%;
        background: rgba(255,255,255,0.1);
        transform: rotate(15deg);
    }
    
    .booking-form-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-bottom: 20px;
    }
    
    .booking-summary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
    }
    
    .test-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .test-item:hover {
        background: #f1f5f9;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-color: #3b82f6;
    }
    
    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    }
    
    .btn-book-test {
        background: linear-gradient(45deg, #10b981 0%, #059669 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-book-test:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
        color: white;    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Test Selection -->
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-flask mr-2"></i>Test Booking
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Patient Selection -->
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user mr-2"></i>Patient Information
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="patientSearch">Search Patient <span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="patientSearch" name="patient_id" required>
                                            <option value="">Search by Name, Mobile, or Patient ID</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bookingDate">Booking Date</label>
                                        <input type="date" class="form-control" id="bookingDate" name="booking_date" value="{{ date('Y-m-d') }}">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="selectedPatientInfo" class="alert alert-info" style="display: none;">
                                <!-- Selected patient info will be displayed here -->
                            </div>
                        </div>
                    </div>

                    <!-- Test Selection -->
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-list-alt mr-2"></i>Select Tests
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="testCategory">Filter by Category</label>
                                        <select class="form-control" id="testCategory">
                                            <option value="">All Categories</option>
                                            <option value="biochemistry">Biochemistry</option>
                                            <option value="hematology">Hematology</option>
                                            <option value="microbiology">Microbiology</option>
                                            <option value="pathology">Pathology</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="testSearch">Search Tests</label>
                                        <input type="text" class="form-control" id="testSearch" placeholder="Type to search tests...">
                                    </div>
                                </div>
                            </div>

                            <!-- Available Tests -->
                            <div id="availableTests">
                                <div class="test-item" data-test-id="1" data-test-name="Complete Blood Count (CBC)" data-price="150">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h6 class="mb-1">Complete Blood Count (CBC)</h6>
                                            <small class="text-muted">Hematology • Sample: Blood</small>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="price-tag">₹150</span>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-sm btn-primary add-test">
                                                <i class="fas fa-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="test-item" data-test-id="2" data-test-name="Lipid Profile" data-price="200">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h6 class="mb-1">Lipid Profile</h6>
                                            <small class="text-muted">Biochemistry • Sample: Blood</small>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="price-tag">₹200</span>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-sm btn-primary add-test">
                                                <i class="fas fa-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="test-item" data-test-id="3" data-test-name="Thyroid Function Test" data-price="300">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h6 class="mb-1">Thyroid Function Test</h6>
                                            <small class="text-muted">Biochemistry • Sample: Blood</small>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="price-tag">₹300</span>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-sm btn-primary add-test">
                                                <i class="fas fa-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="test-item" data-test-id="4" data-test-name="Liver Function Test" data-price="250">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h6 class="mb-1">Liver Function Test</h6>
                                            <small class="text-muted">Biochemistry • Sample: Blood</small>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="price-tag">₹250</span>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-sm btn-primary add-test">
                                                <i class="fas fa-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary btn-lg" id="bookTests">
                        <i class="fas fa-calendar-check mr-2"></i>Book Tests
                    </button>
                    <button type="button" class="btn btn-secondary btn-lg ml-2" id="clearBooking">
                        <i class="fas fa-redo mr-2"></i>Clear Booking
                    </button>
                </div>
            </div>
        </div>

        <!-- Booking Summary -->
        <div class="col-md-4">
            <!-- Booking Summary -->
            <div class="booking-summary">
                <h5 class="text-center mb-3">
                    <i class="fas fa-receipt mr-2"></i>Booking Summary
                </h5>
                <div class="total-amount">
                    <div>Total Amount</div>
                    <div id="totalAmount">₹0</div>
                </div>
            </div>

            <!-- Selected Tests -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-check-circle mr-2"></i>Selected Tests
                    </h3>
                </div>
                <div class="card-body">
                    <div id="selectedTests">
                        <div class="text-center text-muted">
                            <i class="fas fa-flask fa-3x mb-3"></i>
                            <p>No tests selected yet</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Package Suggestions -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-box mr-2"></i>Suggested Packages
                    </h3>
                </div>
                <div class="card-body">
                    <div class="package-item mb-2 p-2 border rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Health Checkup Basic</strong>
                                <br>
                                <small class="text-muted">CBC, Lipid Profile, Sugar</small>
                            </div>
                            <div>
                                <span class="badge badge-warning">₹400</span>
                                <br>
                                <button class="btn btn-sm btn-outline-warning mt-1">Add Package</button>
                            </div>
                        </div>
                    </div>

                    <div class="package-item mb-2 p-2 border rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Comprehensive Health</strong>
                                <br>
                                <small class="text-muted">15 Tests included</small>
                            </div>
                            <div>
                                <span class="badge badge-warning">₹800</span>
                                <br>
                                <button class="btn btn-sm btn-outline-warning mt-1">Add Package</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(document).ready(function() {
    let selectedTests = [];
    let totalAmount = 0;

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

    // Initialize Select2 for patient search
    $('#patientSearch').select2({
        theme: 'bootstrap4',
        placeholder: 'Search by Name, Mobile, or Patient ID',
        ajax: {
            delay: 250,
            processResults: function (data) {
                // Simulate patient data
                return {
                    results: [
                        {id: 1, text: 'John Doe - 9876543210 (PAT-2025-0001)'},
                        {id: 2, text: 'Jane Smith - 9876543211 (PAT-2025-0002)'},
                        {id: 3, text: 'Mike Johnson - 9876543212 (PAT-2025-0003)'}
                    ]
                };
            }
        }
    });

    // Patient selection
    $('#patientSearch').on('select2:select', function (e) {
        var data = e.params.data;
        showPatientInfo(data);
        toastr.success('Patient selected: ' + data.text);
    });

    // Add test functionality
    $(document).on('click', '.add-test', function() {
        var testItem = $(this).closest('.test-item');
        var testId = testItem.data('test-id');
        var testName = testItem.data('test-name');
        var price = testItem.data('price');

        // Check if test already selected
        if (selectedTests.find(test => test.id === testId)) {
            toastr.warning('Test already selected!');
            return;
        }

        // Add to selected tests
        selectedTests.push({
            id: testId,
            name: testName,
            price: price
        });

        // Update UI
        testItem.addClass('selected');
        $(this).html('<i class="fas fa-check"></i> Added').removeClass('btn-primary').addClass('btn-success');
        updateSelectedTests();
        updateTotalAmount();
        
        toastr.success('Test added: ' + testName);
    });

    // Remove test functionality
    $(document).on('click', '.remove-test', function() {
        var testId = parseInt($(this).data('test-id'));
        
        // Remove from selected tests
        selectedTests = selectedTests.filter(test => test.id !== testId);
        
        // Update original test item
        var originalTestItem = $(`.test-item[data-test-id="${testId}"]`);
        originalTestItem.removeClass('selected');
        originalTestItem.find('.add-test').html('<i class="fas fa-plus"></i> Add').removeClass('btn-success').addClass('btn-primary');
        
        updateSelectedTests();
        updateTotalAmount();
        
        toastr.info('Test removed');
    });

    // Book tests
    $('#bookTests').click(function() {
        if (!$('#patientSearch').val()) {
            toastr.error('Please select a patient first');
            return;
        }
        
        if (selectedTests.length === 0) {
            toastr.error('Please select at least one test');
            return;
        }

        // Simulate booking
        var btn = $(this);
        var originalText = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Booking...');
        
        setTimeout(function() {
            toastr.success('Tests booked successfully!');
            clearBooking();
            btn.prop('disabled', false).html(originalText);
        }, 2000);
    });

    // Clear booking
    $('#clearBooking').click(function() {
        clearBooking();
        toastr.info('Booking cleared');
    });

    // Test search functionality
    $('#testSearch').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();
        $('.test-item').each(function() {
            var testName = $(this).data('test-name').toLowerCase();
            if (testName.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Category filter
    $('#testCategory').change(function() {
        var category = $(this).val();
        if (category === '') {
            $('.test-item').show();
        } else {
            $('.test-item').hide();
            // Filter logic would go here based on actual data
        }
    });

    // Functions
    function showPatientInfo(patient) {
        var infoHtml = `
            <strong>Selected Patient:</strong> ${patient.text}
            <br><small class="text-muted">Patient information loaded successfully</small>
        `;
        $('#selectedPatientInfo').html(infoHtml).show();
    }

    function updateSelectedTests() {
        var html = '';
        if (selectedTests.length === 0) {
            html = `
                <div class="text-center text-muted">
                    <i class="fas fa-flask fa-3x mb-3"></i>
                    <p>No tests selected yet</p>
                </div>
            `;
        } else {
            selectedTests.forEach(function(test) {
                html += `
                    <div class="selected-test-item mb-2 p-2 border rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>${test.name}</strong>
                                <br>
                                <span class="badge badge-success">₹${test.price}</span>
                            </div>
                            <button type="button" class="btn btn-sm btn-danger remove-test" data-test-id="${test.id}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
            });
        }
        $('#selectedTests').html(html);
    }

    function updateTotalAmount() {
        totalAmount = selectedTests.reduce((sum, test) => sum + test.price, 0);
        $('#totalAmount').text('₹' + totalAmount);
    }

    function clearBooking() {
        selectedTests = [];
        $('.test-item').removeClass('selected');
        $('.add-test').html('<i class="fas fa-plus"></i> Add').removeClass('btn-success').addClass('btn-primary');
        $('#patientSearch').val(null).trigger('change');
        $('#selectedPatientInfo').hide();
        updateSelectedTests();
        updateTotalAmount();
    }

    // Show welcome message
    toastr.info('Test Booking system ready');
});
</script>
@endpush
