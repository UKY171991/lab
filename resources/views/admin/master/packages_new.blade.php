@extends('admin.layouts.app')

@section('title', 'Package Master')
@section('page-title', 'Package Master')
@section('breadcrumb', 'Master / Packages')

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
    background: linear-gradient(45deg, #6f42c1, #5a32a3);
    color: white;
}
.table-actions .btn {
    margin: 0 2px;
}
.modal-header {
    background: linear-gradient(45deg, #6f42c1, #5a32a3);
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
    border-color: #6f42c1;
    box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
}
.test-builder {
    border: 1px solid #dee2e6;
    border-radius: 5px;
    padding: 15px;
    background-color: #f8f9fa;
}
.test-item {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 3px;
    padding: 8px 12px;
    margin: 3px 0;
    display: flex;
    justify-content: between;
    align-items: center;
}
.test-item .test-name {
    flex-grow: 1;
}
.test-item .test-actions {
    margin-left: 10px;
}
.test-item .btn-move {
    padding: 2px 6px;
    margin: 0 2px;
}
.view-table th {
    background-color: #f8f9fa;
    width: 30%;
    font-weight: 600;
}
.view-table td {
    padding: 12px 15px;
}
.select-test-section {
    background: #f8f9fa;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 15px;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-purple card-outline">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
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
                                    <th width="5%">Sr. No.</th>
                                    <th width="25%">Package Name</th>
                                    <th width="15%">Amount</th>
                                    <th width="15%">Tests Count</th>
                                    <th width="12%">Status</th>
                                    <th width="28%">Actions</th>
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
                        <!-- Left Column - Package Details -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="packageName">Package Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="packageName" name="package_name" required>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group">
                                <label for="amount">Amount <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="amount" name="amount" step="0.01" min="0" required>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Package description..."></textarea>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="status" name="status" checked>
                                    <label class="custom-control-label" for="status">Active Status</label>
                                </div>
                            </div>

                            <!-- Select Test Section -->
                            <div class="select-test-section">
                                <h6><i class="fas fa-flask mr-2"></i>Select Test</h6>
                                <div class="row">
                                    <div class="col-md-8">
                                        <select class="form-control" id="testSelect">
                                            <option value="">Choose a test...</option>
                                            @foreach($tests as $test)
                                                <option value="{{ $test->id }}" data-name="{{ $test->test_name }}">
                                                    {{ $test->test_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-primary btn-sm" id="addTestBtn">
                                            <i class="fas fa-plus mr-1"></i>Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Selected Tests -->
                        <div class="col-md-6">
                            <div class="test-builder">
                                <h6><i class="fas fa-list mr-2"></i>Selected Tests</h6>
                                <div id="selectedTests" class="mt-3">
                                    <div class="text-muted text-center py-4">
                                        <i class="fas fa-flask fa-2x mb-2"></i><br>
                                        No tests selected
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Close
                    </button>
                    <button type="button" class="btn btn-warning" id="clearAllTests">
                        <i class="fas fa-eraser mr-2"></i>Clear
                    </button>
                    <button type="submit" class="btn btn-success" id="savePackage">
                        <i class="fas fa-save mr-2"></i>Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Package Modal -->
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

    // Initialize Select2
    $('#testSelect').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose a test...',
        allowClear: true
    });

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
            emptyTable: 'No packages found. <a href="#" id="addFirstPackage" class="btn btn-success btn-sm mt-2"><i class="fas fa-plus"></i> Create First Package</a>'
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
        
        if (!testId) {
            toastr.warning('Please select a test first');
            return;
        }
        
        // Check if test already selected
        if (selectedTests.includes(testId)) {
            toastr.warning('Test already added to package');
            return;
        }
        
        selectedTests.push(testId);
        updateSelectedTestsDisplay();
        $('#testSelect').val('').trigger('change');
        toastr.success('Test added to package');
    });

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
        selectedTests.forEach(function(testId, index) {
            var testName = $('#testSelect option[value="' + testId + '"]').data('name');
            html += `
                <div class="test-item" data-test-id="${testId}">
                    <span class="test-name">${testName}</span>
                    <div class="test-actions">
                        <button type="button" class="btn btn-outline-secondary btn-move btn-sm move-up" title="Move Up" ${index === 0 ? 'disabled' : ''}>
                            <i class="fas fa-arrow-up"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-move btn-sm move-down" title="Move Down" ${index === selectedTests.length - 1 ? 'disabled' : ''}>
                            <i class="fas fa-arrow-down"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-move btn-sm remove-test" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
        });
        
        $('#selectedTests').html(html);
    }

    // Move test up
    $(document).on('click', '.move-up', function() {
        var testId = $(this).closest('.test-item').data('test-id').toString();
        var index = selectedTests.indexOf(testId);
        
        if (index > 0) {
            [selectedTests[index], selectedTests[index - 1]] = [selectedTests[index - 1], selectedTests[index]];
            updateSelectedTestsDisplay();
            toastr.info('Test moved up');
        }
    });

    // Move test down
    $(document).on('click', '.move-down', function() {
        var testId = $(this).closest('.test-item').data('test-id').toString();
        var index = selectedTests.indexOf(testId);
        
        if (index < selectedTests.length - 1) {
            [selectedTests[index], selectedTests[index + 1]] = [selectedTests[index + 1], selectedTests[index]];
            updateSelectedTestsDisplay();
            toastr.info('Test moved down');
        }
    });

    // Remove test
    $(document).on('click', '.remove-test', function() {
        var testId = $(this).closest('.test-item').data('test-id').toString();
        var index = selectedTests.indexOf(testId);
        
        if (index > -1) {
            selectedTests.splice(index, 1);
            updateSelectedTestsDisplay();
            toastr.success('Test removed from package');
        }
    });

    // Clear all tests
    $('#clearAllTests').click(function() {
        if (selectedTests.length > 0) {
            selectedTests = [];
            updateSelectedTestsDisplay();
            toastr.info('All tests cleared');
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
        formData.append('tests', JSON.stringify(selectedTests));
        
        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        
        // Show loading
        $('#savePackage').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Saving...');
        
        $.ajax({
            url: "{{ route('admin.packages.store') }}",
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
                $('#savePackage').prop('disabled', false).html('<i class="fas fa-save mr-2"></i>Save');
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
                $('#amount').val(data.amount);
                $('#description').val(data.description);
                $('#status').prop('checked', data.status);
                
                // Load selected tests
                if (data.tests && Array.isArray(data.tests)) {
                    selectedTests = data.tests.map(String);
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
                if (data.tests && Array.isArray(data.tests) && data.tests.length > 0) {
                    data.tests.forEach(function(testId, index) {
                        var testName = $('#testSelect option[value="' + testId + '"]').data('name') || 'Test #' + testId;
                        testsHtml += `
                            <div class="alert alert-info mb-2">
                                <i class="fas fa-flask mr-2"></i>
                                ${index + 1}. ${testName}
                            </div>
                        `;
                    });
                } else {
                    testsHtml = '<div class="text-muted">No tests included in this package</div>';
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
        var packageName = $(this).closest('tr').find('td:nth-child(2)').text();
        
        if (confirm('Are you sure you want to delete "' + packageName + '"?\n\nThis action cannot be undone.')) {
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
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        $('#status').prop('checked', true);
        selectedTests = [];
        updateSelectedTestsDisplay();
        $('#testSelect').val('').trigger('change');
    }

    // Enable tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush
