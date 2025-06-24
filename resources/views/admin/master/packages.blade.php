@extends('admin.layouts.app')

@section('title', 'Package Management')
@section('page-title', 'Package Management')
@section('breadcrumb', 'Master / Packages')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

<style>
    .packages-header {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    
    .packages-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 100px;
        height: 200%;
        background: rgba(255,255,255,0.1);
        transform: rotate(15deg);
    }
    
    .packages-table-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        padding: 25px;
    }
    
    .table th {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        border: none;
        padding: 15px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    
    .btn-add-package {
        background: linear-gradient(45deg, #3b82f6 0%, #1d4ed8 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 25px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-add-package:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        color: white;
    }
    
    .modal-header {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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
        border-color: #f59e0b;
        box-shadow: 0 0 0 0.2rem rgba(245, 158, 11, 0.25);
    }
    
    .test-list-container {
        background: #fef3c7;
        border-radius: 10px;
        min-height: 300px;
        padding: 15px;
        border: 2px dashed #f59e0b;
    }
    
    .test-item {
        background: white;
        border: 1px solid #fbbf24;
        border-radius: 8px;
        padding: 10px 15px;
        margin: 5px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }
      .test-item:hover {
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-box mr-2"></i>Package Master
                        </h3>
                        <button class="btn btn-light btn-sm" id="createNewPackage">
                            <i class="fas fa-plus mr-2"></i>Create Package
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="packagesTable">
                            <thead class="thead-light">
                                <tr>
                                    <th width="8%">Sr. No.</th>
                                    <th width="30%">Package Name</th>
                                    <th width="15%">Amount</th>
                                    <th width="15%">Tests Count</th>
                                    <th width="12%">Status</th>
                                    <th width="20%">Actions</th>
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

<!-- Add/Edit Package Modal -->
<div class="modal fade" id="packageModal" tabindex="-1" role="dialog" aria-labelledby="packageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="packageModalLabel">
                    <i class="fas fa-box mr-2"></i>Create Package
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="packageForm">
                <div class="modal-body">
                    <input type="hidden" id="packageId" name="package_id">
                    
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="packageName">Package Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="packageName" name="package_name" required>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group">
                                <label for="amount">Amount <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="amount" name="amount" step="0.01" min="0" required readonly>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Package description..."></textarea>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="status" name="status" checked>
                                    <label class="custom-control-label" for="status">Active Status</label>
                                </div>
                            </div>

                            <!-- Select Test Section -->
                            <div class="select-test-row">
                                <label>Select Test</label>
                                <div class="form-row">
                                    <div class="col-md-8">
                                        <select class="form-control" id="testSelect">
                                            <option value="">Choose a test...</option>
                                            @foreach($tests as $test)
                                                <option value="{{ $test->id }}" 
                                                        data-name="{{ $test->test_name }}" 
                                                        data-amount="{{ $test->amount }}">
                                                    {{ $test->test_name }} (₹{{ number_format($test->amount, 2) }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-primary btn-sm btn-block" id="addTestBtn">
                                            Add
                                        </button>
                                        <button type="button" class="btn btn-action up btn-sm mr-1" id="upBtn" title="Move Up">
                                            Up
                                        </button>
                                        <button type="button" class="btn btn-action down btn-sm" id="downBtn" title="Move Down">
                                            Down
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="test-list-container">
                                <div class="test-header">
                                    <span>Delete</span>
                                    <span style="float: right;">test</span>
                                </div>
                                <div class="test-content" id="selectedTests">
                                    <!-- Selected tests will appear here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Clear</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
                    </div><!-- View Package Modal -->
<div class="modal fade" id="viewPackageModal" tabindex="-1" role="dialog" aria-labelledby="viewPackageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewPackageModalLabel">
                    <i class="fas fa-eye mr-2"></i>Package Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-bordered view-table">
                                <tbody id="packageDetails">
                                    <!-- Details will be loaded via Ajax -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-flask mr-2"></i>Included Tests</h6>
                        <div id="packageTests" class="mt-3">
                            <!-- Tests will be loaded via Ajax -->
                        </div>
                    </div>
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
    // Store selected tests array
    let selectedTests = [];
    let selectedTestIndex = -1;

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
    var table = $('#packagesTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.packages.data') }}",
            error: function(xhr, error, thrown) {
                toastr.error('Error loading packages data');
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'package_name', name: 'package_name'},
            {data: 'amount_display', name: 'amount', orderable: false},
            {data: 'test_count', name: 'test_count', orderable: false},
            {data: 'status', name: 'status', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'table-actions text-center'}
        ],
        order: [[1, 'asc']],
        pageLength: 25,
        language: {
            processing: '<i class="fas fa-spinner fa-spin fa-2x"></i><br>Loading...',
            emptyTable: 'No packages found. <a href="#" id="addFirstPackage" class="btn btn-primary btn-sm mt-2"><i class="fas fa-plus"></i> Create First Package</a>'
        }
    });

    // Add first package link handler
    $(document).on('click', '#addFirstPackage', function(e) {
        e.preventDefault();
        $('#createNewPackage').click();
    });

    // Create new package
    $('#createNewPackage').click(function() {
        resetForm();
        $('#packageModalLabel').html('<i class="fas fa-box mr-2"></i>Create Package');
        $('#packageModal').modal('show');
        toastr.info('Create a new test package');
    });

    // Add test to package
    $('#addTestBtn').click(function() {
        var testId = $('#testSelect').val();
        var testName = $('#testSelect option:selected').data('name');
        var testAmount = parseFloat($('#testSelect option:selected').data('amount')) || 0;
        
        if (!testId) {
            toastr.warning('Please select a test first');
            return;
        }
        
        // Check if test already selected
        if (selectedTests.some(test => test.id === testId)) {
            toastr.warning('Test already added to package');
            return;
        }
        
        selectedTests.push({
            id: testId,
            name: testName,
            amount: testAmount
        });
        
        updateSelectedTestsDisplay();
        updatePackageAmount();
        $('#testSelect').val('').trigger('change');
        toastr.success('Test added to package');
    });

    // Update package amount based on selected tests
    function updatePackageAmount() {
        var totalAmount = selectedTests.reduce((sum, test) => sum + test.amount, 0);
        $('#amount').val(totalAmount.toFixed(2));
    }

    // Update selected tests display
    function updateSelectedTestsDisplay() {
        if (selectedTests.length === 0) {
            $('#selectedTests').html(`
                <div class="text-muted text-center py-4">
                    <i class="fas fa-flask fa-2x mb-2"></i><br>
                    No tests selected
                </div>
            `);
            return;
        }
        
        let html = '';
        selectedTests.forEach(function(test, index) {
            let isSelected = (index === selectedTestIndex);
            html += `
                <div class="test-item ${isSelected ? 'bg-primary text-white' : ''}" data-test-id="${test.id}" data-index="${index}">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="test-name">${test.name}</span>
                        <button type="button" class="btn btn-action delete btn-sm remove-test" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        });
        
        $('#selectedTests').html(html);
    }

    // Select test item for Up/Down actions
    $(document).on('click', '.test-item', function() {
        $('.test-item').removeClass('bg-primary text-white');
        $(this).addClass('bg-primary text-white');
        selectedTestIndex = parseInt($(this).data('index'));
    });

    // Move test up
    $('#upBtn').click(function() {
        if (selectedTestIndex > 0) {
            [selectedTests[selectedTestIndex], selectedTests[selectedTestIndex - 1]] = 
            [selectedTests[selectedTestIndex - 1], selectedTests[selectedTestIndex]];
            selectedTestIndex--;
            updateSelectedTestsDisplay();
            toastr.info('Test moved up');
        } else {
            toastr.warning('Please select a test to move up');
        }
    });

    // Move test down
    $('#downBtn').click(function() {
        if (selectedTestIndex >= 0 && selectedTestIndex < selectedTests.length - 1) {
            [selectedTests[selectedTestIndex], selectedTests[selectedTestIndex + 1]] = 
            [selectedTests[selectedTestIndex + 1], selectedTests[selectedTestIndex]];
            selectedTestIndex++;
            updateSelectedTestsDisplay();
            toastr.info('Test moved down');
        } else {
            toastr.warning('Please select a test to move down');
        }
    });

    // Remove test
    $(document).on('click', '.remove-test', function(e) {
        e.stopPropagation();
        var index = parseInt($(this).closest('.test-item').data('index'));
        
        if (index > -1) {
            selectedTests.splice(index, 1);
            selectedTestIndex = -1;
            updateSelectedTestsDisplay();
            updatePackageAmount();
            toastr.success('Test removed from package');
        }
    });

    // Clear form data (modal footer Clear button)
    $(document).on('click', '[data-dismiss="modal"]', function() {
        if ($(this).text().trim() === 'Clear') {
            resetForm();
            toastr.info('Form cleared');
        }
    });

    // Save package
    $('#packageForm').on('submit', function(e) {
        e.preventDefault();
        
        if (selectedTests.length === 0) {
            toastr.warning('Please add at least one test to the package');
            return;
        }
        
        var formData = new FormData(this);
        formData.append('tests', JSON.stringify(selectedTests.map(test => test.id)));
        
        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        
        // Show loading
        var saveBtn = $(this).find('button[type="submit"]');
        var originalText = saveBtn.html();
        saveBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Saving...');
        
        var url = $('#packageId').val() ? 
            "{{ route('admin.packages.store') }}" : 
            "{{ route('admin.packages.store') }}";
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#packageModal').modal('hide');
                table.ajax.reload();
                toastr.success(response.success);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        var field = key.replace('_', '');
                        if (key === 'package_name') field = 'packageName';
                        
                        $('#' + field).addClass('is-invalid');
                        $('#' + field).siblings('.invalid-feedback').text(value[0]);
                    });
                    toastr.error('Please correct the errors and try again');
                } else {
                    toastr.error('An error occurred while saving package');
                }
            },
            complete: function() {
                saveBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Edit package
    $(document).on('click', '.editPackage', function() {
        var id = $(this).data('id');
        resetForm();
        
        $.ajax({
            url: "{{ route('admin.packages.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                $('#packageId').val(data.id);
                $('#packageName').val(data.package_name);
                $('#amount').val(parseFloat(data.amount).toFixed(2));
                $('#description').val(data.description);
                $('#status').prop('checked', data.status);
                
                // Load selected tests
                if (data.tests && Array.isArray(data.tests)) {
                    selectedTests = [];
                    data.tests.forEach(function(testId) {
                        var option = $('#testSelect option[value="' + testId + '"]');
                        if (option.length) {
                            selectedTests.push({
                                id: testId,
                                name: option.data('name'),
                                amount: parseFloat(option.data('amount')) || 0
                            });
                        }
                    });
                    updateSelectedTestsDisplay();
                }
                
                $('#packageModalLabel').html('<i class="fas fa-edit mr-2"></i>Edit Package');
                $('#packageModal').modal('show');
                toastr.info('Edit package details');
            },
            error: function() {
                toastr.error('Error loading package data');
            }
        });
    });

    // View package
    $(document).on('click', '.viewPackage', function() {
        var id = $(this).data('id');
        
        $.ajax({
            url: "{{ route('admin.packages.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                var detailsHtml = `
                    <tr><th>Package Name</th><td>${data.package_name || 'N/A'}</td></tr>
                    <tr><th>Amount</th><td><span class="badge badge-success">₹ ${data.amount ? parseFloat(data.amount).toFixed(2) : '0.00'}</span></td></tr>
                    <tr><th>Description</th><td>${data.description || 'N/A'}</td></tr>
                    <tr><th>Status</th><td>${data.status ? '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Active</span>' : '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Inactive</span>'}</td></tr>
                    <tr><th>Created At</th><td>${new Date(data.created_at).toLocaleString()}</td></tr>
                    <tr><th>Updated At</th><td>${new Date(data.updated_at).toLocaleString()}</td></tr>
                `;
                
                $('#packageDetails').html(detailsHtml);
                
                // Load package tests
                var testsHtml = '';
                if (data.tests && data.tests.length > 0) {
                    data.tests.forEach(function(testId, index) {
                        var testOption = $('#testSelect option[value="' + testId + '"]');
                        if (testOption.length) {
                            testsHtml += `
                                <div class="test-item mb-2">
                                    <span class="badge badge-primary mr-2">${index + 1}</span>
                                    ${testOption.data('name')}
                                </div>
                            `;
                        }
                    });
                } else {
                    testsHtml = '<div class="text-muted">No tests included</div>';
                }
                
                $('#packageTests').html(testsHtml);
                $('#viewPackageModal').modal('show');
                toastr.info('Viewing package details');
            },
            error: function() {
                toastr.error('Error loading package data');
            }
        });
    });

    // Delete package
    $(document).on('click', '.deletePackage', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        
        if (confirm('Are you sure you want to delete the package "' + name + '"?')) {
            $.ajax({
                url: "{{ route('admin.packages.destroy', ':id') }}".replace(':id', id),
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    table.ajax.reload();
                    toastr.success(response.success);
                },
                error: function() {
                    toastr.error('Error deleting package');
                }
            });
        }
    });

    // Reset form function
    function resetForm() {
        $('#packageForm')[0].reset();
        $('#packageId').val('');
        selectedTests = [];
        selectedTestIndex = -1;        updateSelectedTestsDisplay();
        $('#amount').val('0.00');
        $('#status').prop('checked', true);
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
    }
});
</script>
@endpush
