@extends('admin.layouts.app')

@section('title', 'Test Booking')
@section('page-title', 'Test Booking')
@section('breadcrumb', 'Entry / Test Booking')

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

<style>
    .booking-header {
        background: linear-gradient(135deg, #16a085 0%, #2ecc71 100%);
        color: white;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(22, 160, 133, 0.3);
    }
    
    .booking-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: none;
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .booking-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 25px 30px;
    }
    
    .step-indicator {
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
    }
    
    .step {
        display: flex;
        align-items: center;
        margin: 0 15px;
    }
    
    .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e2e8f0;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin-right: 10px;
    }
    
    .step.active .step-number {
        background: #16a085;
        color: white;
    }
    
    .step.completed .step-number {
        background: #2ecc71;
        color: white;
    }
    
    .form-section {
        background: #f8fafc;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 25px;
        border: 1px solid #e2e8f0;
    }
    
    .form-section h5 {
        color: #1e293b;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #16a085;
        display: inline-block;
    }
    
    .test-selection {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }
    
    .test-selection:hover {
        border-color: #16a085;
        box-shadow: 0 5px 15px rgba(22, 160, 133, 0.1);
    }
    
    .test-selection.selected {
        border-color: #16a085;
        background: #f0fdfa;
    }
    
    .test-item {
        display: flex;
        align-items: center;
        justify-content: between;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .test-item:last-child {
        border-bottom: none;
    }
    
    .test-details {
        flex: 1;
    }
    
    .test-name {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
    }
    
    .test-price {
        color: #16a085;
        font-weight: 600;
    }
    
    .summary-card {
        background: linear-gradient(135deg, #16a085 0%, #2ecc71 100%);
        color: white;
        border-radius: 15px;
        padding: 25px;
        margin-top: 25px;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    
    .summary-row.total {
        border-top: 1px solid rgba(255, 255, 255, 0.3);
        padding-top: 15px;
        margin-top: 15px;
        font-size: 1.2rem;
        font-weight: 600;
    }
    
    .btn-book {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        border: none;
        border-radius: 12px;
        padding: 15px 40px;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
    }
    
    .btn-book:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(231, 76, 60, 0.4);
        color: white;
    }
    
    @media (max-width: 768px) {
        .booking-header {
            padding: 25px;
            text-align: center;
        }
        
        .step-indicator {
            flex-wrap: wrap;
        }
        
        .step {
            margin: 5px;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="booking-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0">
                    <i class="fas fa-calendar-plus mr-3"></i>Test Booking System
                </h1>
                <p class="mb-0 mt-2 opacity-75">Book laboratory tests for patients</p>
            </div>
            <div class="col-md-4 text-right">
                <div class="text-white">
                    <h4 class="mb-0">{{ now()->format('d M Y') }}</h4>
                    <p class="mb-0">{{ now()->format('l') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Step Indicator -->
    <div class="step-indicator">
        <div class="step active">
            <div class="step-number">1</div>
            <span>Patient Selection</span>
        </div>
        <div class="step">
            <div class="step-number">2</div>
            <span>Test Selection</span>
        </div>
        <div class="step">
            <div class="step-number">3</div>
            <span>Confirmation</span>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Patient Selection -->
            <div class="card booking-card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-user mr-2 text-primary"></i>Patient Information
                    </h4>
                </div>
                <div class="card-body">
                    <div class="form-section">
                        <h5><i class="fas fa-search mr-2"></i>Select Patient</h5>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Search Patient</label>
                                    <select class="form-control" id="patientSelect" style="width: 100%;">
                                        <option value="">Search by name, phone, or UHID...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button class="btn btn-outline-primary btn-block" onclick="showNewPatientModal()">
                                        <i class="fas fa-plus mr-2"></i>Add New Patient
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div id="selectedPatientInfo" style="display: none;">
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle mr-2"></i>Selected Patient</h6>
                                <div id="patientDetails"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Test Selection -->
            <div class="card booking-card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-vials mr-2 text-success"></i>Test Selection
                    </h4>
                </div>
                <div class="card-body">
                    <div class="form-section">
                        <h5><i class="fas fa-flask mr-2"></i>Available Tests</h5>
                        
                        <!-- Test Categories Tabs -->
                        <ul class="nav nav-pills nav-fill mb-3">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#individual-tests">Individual Tests</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#test-packages">Test Packages</a>
                            </li>
                        </ul>
                        
                        <div class="tab-content">
                            <!-- Individual Tests Tab -->
                            <div class="tab-pane fade show active" id="individual-tests">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Search tests..." id="testSearch">
                                </div>
                                
                                <div id="testsList">
                                    <!-- Tests will be loaded here -->
                                    <div class="test-selection">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="test1" value="1">
                                            <label class="custom-control-label" for="test1">
                                                <div class="test-item">
                                                    <div class="test-details">
                                                        <div class="test-name">Complete Blood Count (CBC)</div>
                                                        <small class="text-muted">Blood test to check overall health</small>
                                                    </div>
                                                    <div class="test-price">₹500</div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="test-selection">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="test2" value="2">
                                            <label class="custom-control-label" for="test2">
                                                <div class="test-item">
                                                    <div class="test-details">
                                                        <div class="test-name">Lipid Profile</div>
                                                        <small class="text-muted">Cholesterol and triglycerides test</small>
                                                    </div>
                                                    <div class="test-price">₹800</div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="test-selection">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="test3" value="3">
                                            <label class="custom-control-label" for="test3">
                                                <div class="test-item">
                                                    <div class="test-details">
                                                        <div class="test-name">Thyroid Function Test</div>
                                                        <small class="text-muted">T3, T4, TSH levels</small>
                                                    </div>
                                                    <div class="test-price">₹1200</div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Test Packages Tab -->
                            <div class="tab-pane fade" id="test-packages">
                                <div id="packagesList">
                                    <!-- Packages will be loaded here -->
                                    <div class="test-selection">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="package1" name="package" value="1">
                                            <label class="custom-control-label" for="package1">
                                                <div class="test-item">
                                                    <div class="test-details">
                                                        <div class="test-name">Basic Health Checkup</div>
                                                        <small class="text-muted">CBC, Lipid Profile, Blood Sugar</small>
                                                    </div>
                                                    <div>
                                                        <span class="test-price">₹1500</span>
                                                        <small class="text-muted ml-2">(Save ₹300)</small>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="test-selection">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="package2" name="package" value="2">
                                            <label class="custom-control-label" for="package2">
                                                <div class="test-item">
                                                    <div class="test-details">
                                                        <div class="test-name">Comprehensive Health Checkup</div>
                                                        <small class="text-muted">CBC, Lipid, Thyroid, Liver Function, Kidney Function</small>
                                                    </div>
                                                    <div>
                                                        <span class="test-price">₹3500</span>
                                                        <small class="text-muted ml-2">(Save ₹800)</small>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Booking Summary -->
            <div class="card booking-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt mr-2 text-warning"></i>Booking Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div id="selectedTests">
                        <p class="text-muted text-center">No tests selected</p>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span id="subtotal">₹0</span>
                        </div>
                        <div class="summary-row">
                            <span>Discount:</span>
                            <span id="discount">₹0</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total Amount:</span>
                            <span id="totalAmount">₹0</span>
                        </div>
                        
                        <button class="btn btn-book btn-block mt-3" onclick="confirmBooking()">
                            <i class="fas fa-check mr-2"></i>Confirm Booking
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="card booking-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt mr-2 text-info"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <button class="btn btn-outline-primary btn-block mb-2">
                        <i class="fas fa-history mr-2"></i>Recent Bookings
                    </button>
                    <button class="btn btn-outline-success btn-block mb-2">
                        <i class="fas fa-calendar mr-2"></i>Today's Bookings
                    </button>
                    <button class="btn btn-outline-info btn-block">
                        <i class="fas fa-chart-line mr-2"></i>Booking Reports
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Initialize Select2 for patient selection
    $('#patientSelect').select2({
        ajax: {
            url: '/admin/patients/search', // You'll need to create this endpoint
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: 'Search by name, phone, or UHID...',
        minimumInputLength: 1,
        templateResult: formatPatient,
        templateSelection: formatPatientSelection
    });

    // Handle patient selection
    $('#patientSelect').on('select2:select', function (e) {
        var data = e.params.data;
        showPatientInfo(data);
        updateStepIndicator(2);
    });

    // Handle test selection
    $(document).on('change', '.custom-control-input[type="checkbox"]', function() {
        updateBookingSummary();
    });

    // Handle package selection
    $(document).on('change', '.custom-control-input[type="radio"]', function() {
        $('.custom-control-input[type="checkbox"]').prop('checked', false);
        updateBookingSummary();
    });

    // Test search
    $('#testSearch').on('keyup', function() {
        var searchTerm = $(this).val().toLowerCase();
        $('.test-selection').each(function() {
            var testName = $(this).find('.test-name').text().toLowerCase();
            if (testName.indexOf(searchTerm) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});

function formatPatient(patient) {
    if (patient.loading) {
        return patient.text;
    }
    
    var $container = $(
        "<div class='select2-result-patient clearfix'>" +
        "<div class='select2-result-patient__meta'>" +
        "<div class='select2-result-patient__title'></div>" +
        "<div class='select2-result-patient__description'></div>" +
        "</div>" +
        "</div>"
    );

    $container.find(".select2-result-patient__title").text(patient.client_name);
    $container.find(".select2-result-patient__description").text(patient.mobile_number + " • UHID: " + (patient.uhid || 'N/A'));

    return $container;
}

function formatPatientSelection(patient) {
    return patient.client_name || patient.text;
}

function showPatientInfo(patient) {
    var html = `
        <strong>${patient.client_name}</strong><br>
        <small>Phone: ${patient.mobile_number} • UHID: ${patient.uhid || 'N/A'}</small><br>
        <small>Age: ${patient.age || 'N/A'} • Gender: ${patient.sex || 'N/A'}</small>
    `;
    $('#patientDetails').html(html);
    $('#selectedPatientInfo').show();
}

function updateStepIndicator(activeStep) {
    $('.step').removeClass('active completed');
    
    for (let i = 1; i < activeStep; i++) {
        $(`.step:nth-child(${i})`).addClass('completed');
    }
    
    $(`.step:nth-child(${activeStep})`).addClass('active');
}

function updateBookingSummary() {
    var selectedTests = [];
    var subtotal = 0;
    
    // Check individual tests
    $('.custom-control-input[type="checkbox"]:checked').each(function() {
        var testItem = $(this).closest('.test-selection');
        var testName = testItem.find('.test-name').text();
        var testPrice = parseInt(testItem.find('.test-price').text().replace('₹', '').replace(',', ''));
        
        selectedTests.push({
            name: testName,
            price: testPrice
        });
        subtotal += testPrice;
    });
    
    // Check packages
    $('.custom-control-input[type="radio"]:checked').each(function() {
        var packageItem = $(this).closest('.test-selection');
        var packageName = packageItem.find('.test-name').text();
        var packagePrice = parseInt(packageItem.find('.test-price').text().replace('₹', '').replace(',', ''));
        
        selectedTests.push({
            name: packageName,
            price: packagePrice
        });
        subtotal += packagePrice;
    });
    
    // Update summary display
    if (selectedTests.length > 0) {
        var html = '';
        selectedTests.forEach(function(test) {
            html += `<div class="d-flex justify-content-between mb-2">
                        <span>${test.name}</span>
                        <span>₹${test.price.toLocaleString()}</span>
                     </div>`;
        });
        $('#selectedTests').html(html);
    } else {
        $('#selectedTests').html('<p class="text-muted text-center">No tests selected</p>');
    }
    
    // Update totals
    var discount = 0; // Calculate discount logic here
    var total = subtotal - discount;
    
    $('#subtotal').text('₹' + subtotal.toLocaleString());
    $('#discount').text('₹' + discount.toLocaleString());
    $('#totalAmount').text('₹' + total.toLocaleString());
}

function showNewPatientModal() {
    // You can open a modal to add new patient
    Swal.fire({
        title: 'Add New Patient',
        text: 'Redirect to patient registration?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, go to registration'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '{{ route("admin.patients.create") }}';
        }
    });
}

function confirmBooking() {
    var selectedPatient = $('#patientSelect').val();
    var selectedTests = $('.custom-control-input:checked').length;
    
    if (!selectedPatient) {
        Swal.fire('Error', 'Please select a patient first', 'error');
        return;
    }
    
    if (selectedTests === 0) {
        Swal.fire('Error', 'Please select at least one test', 'error');
        return;
    }
    
    Swal.fire({
        title: 'Confirm Booking',
        text: 'Are you sure you want to book these tests?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, book now!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit booking
            submitBooking();
        }
    });
}

function submitBooking() {
    // Implement booking submission logic
    Swal.fire({
        title: 'Booking Confirmed!',
        text: 'Test booking has been created successfully',
        icon: 'success',
        timer: 2000,
        timerProgressBar: true
    }).then(() => {
        // Reset form or redirect
        location.reload();
    });
}
</script>
@endpush
