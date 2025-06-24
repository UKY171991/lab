@extends('admin.layouts.app')

@section('title', 'Tests Management')
@section('page-title', 'Tests Management')
@section('breadcrumb', 'Master / Tests')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<style>
    .tests-header {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    
    .tests-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 100px;
        height: 200%;
        background: rgba(255,255,255,0.1);
        transform: rotate(15deg);
    }
    
    .tests-table-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        padding: 25px;
    }
    
    .table th {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
        border: none;
        padding: 15px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    
    .btn-add-test {
        background: linear-gradient(45deg, #3b82f6 0%, #1d4ed8 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 25px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-add-test:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        color: white;
    }
    
    .modal-header {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
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
        border-color: #8b5cf6;
        box-shadow: 0 0 0 0.2rem rgba(139, 92, 246, 0.25);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="tests-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0">
                    <i class="fas fa-flask mr-3"></i>Tests Management
                </h1>
                <p class="mb-0 opacity-75">Manage laboratory tests and parameters</p>
            </div>
            <div class="col-md-4 text-right">
                <button class="btn btn-add-test" id="addTestBtn">
                    <i class="fas fa-plus mr-2"></i>Add New Test
                </button>
            </div>
        </div>
    </div>

    <!-- Tests Table -->
    <div class="tests-table-container">
        <div class="table-responsive">
            <table id="testsTable" class="table table-hover">
                <thead>
                    <tr>
                        <th width="5%">Sr. No.</th>
                        <th width="25%">Test Name</th>
                        <th width="15%">Specimen</th>
                        <th width="15%">Test Code</th>
                        <th width="10%">Unit</th>
                        <th width="10%">Category</th>
                        <th width="10%">Status</th>
                        <th width="10%">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Test Modal -->
<div class="modal fade" id="testModal" tabindex="-1" role="dialog" aria-labelledby="testModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="testModalLabel">Add New Test</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>            <form id="testForm">
                <div class="modal-body">
                    <input type="hidden" id="test_id" name="test_id">
                    
                    <!-- Basic Test Information -->
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-info-circle"></i> Basic Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="test_name"><i class="fas fa-flask"></i> Test Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="test_name" name="test_name" required placeholder="Enter test name">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="testcode"><i class="fas fa-barcode"></i> Testcode</label>
                                        <input type="text" class="form-control" id="testcode" name="testcode" placeholder="Enter test code">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="specimen"><i class="fas fa-vial"></i> Specimen</label>
                                        <input type="text" class="form-control" id="specimen" name="specimen" placeholder="e.g., Blood, Urine, Serum">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="individual_method"><i class="fas fa-cogs"></i> Individual Method</label>
                                        <input type="text" class="form-control" id="individual_method" name="individual_method" placeholder="Enter method">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Test Results & Values -->
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-line"></i> Results & Values</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="result_default"><i class="fas fa-clipboard-list"></i> Result (Default)</label>
                                        <input type="text" class="form-control" id="result_default" name="result_default" placeholder="Default result">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="unit"><i class="fas fa-ruler"></i> Unit</label>
                                        <input type="text" class="form-control" id="unit" name="unit" placeholder="e.g., mg/dL, μg/L">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="reference_range"><i class="fas fa-arrows-alt-h"></i> Reference Range</label>                                        <input type="text" class="form-control" id="reference_range" name="reference_range" placeholder="e.g., 70-100">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="min_value"><i class="fas fa-arrow-down"></i> Min Value</label>
                                        <input type="number" step="0.01" class="form-control" id="min_value" name="min_value" placeholder="Minimum value">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="max_value"><i class="fas fa-arrow-up"></i> Max Value</label>
                                        <input type="number" step="0.01" class="form-control" id="max_value" name="max_value" placeholder="Maximum value">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Settings & Status -->
                    <div class="card card-outline card-warning">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-cog"></i> Settings</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input type="checkbox" class="custom-control-input" id="is_sub_heading" name="is_sub_heading">
                                            <label class="custom-control-label" for="is_sub_heading">
                                                <i class="fas fa-heading"></i> Sub-Heading
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input type="checkbox" class="custom-control-input" id="status" name="status" checked>
                                            <label class="custom-control-label" for="status">
                                                <i class="fas fa-toggle-on"></i> Active Status
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="saveTestBtn">
                        <i class="fas fa-save"></i> Save Test
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Test Modal -->
<div class="modal fade" id="viewTestModal" tabindex="-1" role="dialog" aria-labelledby="viewTestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="viewTestModalLabel">
                    <i class="fas fa-eye"></i> Test Details
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Basic Information Card -->
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-info-circle"></i> Basic Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-primary"><i class="fas fa-flask"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Test Name</span>
                                        <span class="info-box-number" id="view_test_name"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-success"><i class="fas fa-barcode"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Test Code</span>
                                        <span class="info-box-number" id="view_testcode"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-warning"><i class="fas fa-vial"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Specimen</span>
                                        <span class="info-box-number" id="view_specimen"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-info"><i class="fas fa-cogs"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Individual Method</span>
                                        <span class="info-box-number" id="view_individual_method"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results & Values Card -->
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-chart-line"></i> Results & Values</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-secondary"><i class="fas fa-clipboard-list"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Default Result</span>
                                        <span class="info-box-number" id="view_result_default"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-primary"><i class="fas fa-ruler"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Unit</span>
                                        <span class="info-box-number" id="view_unit"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-success"><i class="fas fa-arrows-alt-h"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Reference Range</span>
                                        <span class="info-box-number" id="view_reference_range"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-danger"><i class="fas fa-arrow-down"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Min Value</span>
                                        <span class="info-box-number" id="view_min_value"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-success"><i class="fas fa-arrow-up"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Max Value</span>
                                        <span class="info-box-number" id="view_max_value"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Settings & Status Card -->
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-cog"></i> Settings & Status</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-info"><i class="fas fa-heading"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Sub-Heading</span>
                                        <span class="info-box-number" id="view_sub_heading"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-success"><i class="fas fa-toggle-on"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Status</span>
                                        <span class="info-box-number" id="view_status"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables  & Plugins -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.2.3/js/buttons.bootstrap4.min.js"></script>

<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Configure toastr
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
    };    // Initialize DataTable
    const table = $('#testsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.tests.data') }}",        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center'},
            {data: 'test_name', name: 'test_name', className: 'font-weight-bold'},
            {data: 'specimen', name: 'specimen'},
            {data: 'testcode', name: 'testcode'},
            {data: 'unit', name: 'unit', className: 'text-center'},
            {data: 'sub_heading', name: 'sub_heading', orderable: false, searchable: false, className: 'text-center'},
            {data: 'status', name: 'status', orderable: false, searchable: false, className: 'text-center'},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
        ],
        responsive: true,
        autoWidth: false,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        pageLength: 10,
        order: [[1, 'asc']],
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
            paginate: {
                first: '<i class="fas fa-angle-double-left"></i>',
                last: '<i class="fas fa-angle-double-right"></i>',
                next: '<i class="fas fa-angle-right"></i>',
                previous: '<i class="fas fa-angle-left"></i>'
            }
        }
    });    // Add Test Button
    $('#addTestBtn').click(function() {
        resetForm();
        $('#testModalLabel').text('Add New Test');
        $('#testModal').modal('show');
        toastr.info('Fill in the form to add a new test', 'Add New Test');
    });

    // Form submission
    $('#testForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const testId = $('#test_id').val();
        
        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        
        // Show loading
        $('#saveTestBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        
        $.ajax({
            url: "{{ route('admin.tests.store') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },            success: function(response) {
                toastr.success(response.success, 'Success');
                $('#testModal').modal('hide');
                table.ajax.reload();
                resetForm();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).siblings('.invalid-feedback').text(value[0]);
                    });
                    toastr.error('Please fix the validation errors.', 'Validation Error');
                } else {
                    toastr.error('An error occurred. Please try again.', 'Error');
                }
            },complete: function() {
                $('#saveTestBtn').prop('disabled', false).html('<i class="fas fa-save"></i> Save Test');
            }
        });
    });

    // View Test
    $(document).on('click', '.viewTest', function() {
        const testId = $(this).data('id');
        
        $.ajax({
            url: '/admin/tests/' + testId + '/edit',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },            success: function(response) {
                populateViewModal(response);
                $('#viewTestModal').modal('show');
                toastr.success('Test details loaded successfully', 'View Test');
            },
            error: function() {
                toastr.error('Failed to load test data.', 'Error');
            }
        });
    });

    // Edit Test
    $(document).on('click', '.editTest', function() {
        const testId = $(this).data('id');
        
        $.ajax({
            url: '/admin/tests/' + testId + '/edit',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },            success: function(response) {
                populateForm(response);
                $('#testModalLabel').text('Edit Test');
                $('#testModal').modal('show');
                toastr.info('Test loaded for editing', 'Edit Test');
            },
            error: function() {
                toastr.error('Failed to load test data.', 'Error');
            }
        });
    });    // Delete Test
    $(document).on('click', '.deleteTest', function() {
        const testId = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/tests/' + testId,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        toastr.success(response.success, 'Success');
                        table.ajax.reload();
                    },
                    error: function() {
                        toastr.error('Failed to delete test.', 'Error');
                    }
                });
            }
        });
    });

    // Modal event handlers
    $('#testModal').on('hidden.bs.modal', function () {
        resetForm();
        toastr.info('Form reset', 'Modal Closed');
    });

    $('#viewTestModal').on('shown.bs.modal', function () {
        toastr.success('Test details displayed', 'View Mode');
    });    // Table reload event
    table.on('draw', function () {
        $('[data-toggle="tooltip"]').tooltip();
        toastr.success('Table data refreshed', 'Data Updated');
    });

    function resetForm() {
        $('#testForm')[0].reset();
        $('#test_id').val('');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        $('#status').prop('checked', true);
    }    function populateForm(data) {
        $('#test_id').val(data.id);
        $('#test_name').val(data.test_name);
        $('#specimen').val(data.specimen);
        $('#result_default').val(data.result_default);
        $('#unit').val(data.unit);
        $('#reference_range').val(data.reference_range);
        $('#min_value').val(data.min_value);
        $('#max_value').val(data.max_value);        $('#testcode').val(data.testcode);
        $('#individual_method').val(data.individual_method);
        
        $('#is_sub_heading').prop('checked', data.is_sub_heading);
        $('#status').prop('checked', data.status);
    }    function populateViewModal(data) {
        $('#view_test_name').text(data.test_name);
        $('#view_specimen').text(data.specimen);
        $('#view_result_default').text(data.result_default);
        $('#view_unit').text(data.unit);
        $('#view_reference_range').text(data.reference_range);
        $('#view_min_value').text(data.min_value);
        $('#view_max_value').text(data.max_value);
        $('#view_testcode').text(data.testcode);
        $('#view_individual_method').text(data.individual_method);
        $('#view_sub_heading').text(data.is_sub_heading ? 'Yes' : 'No');
        $('#view_status').text(data.status ? 'Active' : 'Inactive');
    }
});
</script>
@endpush

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables-responsive/2.2.9/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.2.3/css/buttons.bootstrap4.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
    /* Custom styles for modern design */
    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,.075);
        transition: background-color 0.15s ease-in-out;
    }
    
    .info-box {
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin-bottom: 15px;
    }
    
    .info-box-icon {
        border-radius: 10px 0 0 10px;
    }
    
    .btn-group .btn {
        margin-right: 2px;
        border-radius: 4px;
    }
    
    .card {
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    
    .modal-content {
        border-radius: 10px;
        border: none;
        box-shadow: 0 0 20px rgba(0,0,0,0.2);
    }
    
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }
    
    .thead-dark th {
        background-color: #343a40;
        border-color: #454d55;
        color: #fff;
    }
    
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 4px;
        border: 1px solid #ced4da;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 4px;
        margin: 0 2px;
    }
</style>
@endsection
