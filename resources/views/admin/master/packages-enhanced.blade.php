@extends('admin.layouts.app')

@section('title', 'Test Packages')
@section('page-title', 'Test Packages')
@section('breadcrumb', 'Master / Packages')

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.bootstrap4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

<style>
    .packages-header {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(245, 158, 11, 0.3);
    }
    
    .packages-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 120px;
        height: 120px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }
    
    .packages-header::after {
        content: '';
        position: absolute;
        bottom: -30px;
        left: -30px;
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 4s ease-in-out infinite reverse;
    }

    .stats-cards {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .stats-card {
        flex: 1;
        min-width: 200px;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--accent-color, #f59e0b);
        border-radius: 15px 15px 0 0;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: var(--accent-color, #f59e0b);
        margin-bottom: 10px;
        line-height: 1;
    }

    .stats-label {
        color: #64748b;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.875rem;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn-add-package {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: none;
        padding: 12px 25px;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }

    .btn-add-package:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        color: white;
    }

    .table-container {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .packages-table {
        margin-bottom: 0;
    }

    .packages-table thead th {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border: none;
        color: #374151;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.875rem;
        padding: 15px 12px;
    }

    .packages-table tbody td {
        padding: 15px 12px;
        vertical-align: middle;
        border-color: #f1f5f9;
    }

    .packages-table tbody tr {
        transition: all 0.2s ease;
    }

    .packages-table tbody tr:hover {
        background: #f8fafc;
        transform: translateX(2px);
    }

    .package-name {
        font-weight: 600;
        color: #1f2937;
    }

    .amount-badge {
        background: #dcfce7;
        color: #166534;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .test-count-badge {
        background: #dbeafe;
        color: #1e40af;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-active {
        background: #dcfce7;
        color: #166534;
    }

    .status-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .action-btn {
        padding: 6px 12px;
        border-radius: 6px;
        border: none;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        margin: 0 2px;
    }

    .action-btn-edit {
        background: #fef3c7;
        color: #92400e;
    }

    .action-btn-edit:hover {
        background: #fbbf24;
        color: white;
    }

    .action-btn-delete {
        background: #fee2e2;
        color: #991b1b;
    }

    .action-btn-delete:hover {
        background: #ef4444;
        color: white;
    }

    .action-btn-view {
        background: #dbeafe;
        color: #1e40af;
    }

    .action-btn-view:hover {
        background: #3b82f6;
        color: white;
    }

    /* Modal Enhancements */
    .modal-content {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        border-radius: 15px 15px 0 0;
        border: none;
        padding: 20px 25px;
    }

    .modal-header .close {
        color: white;
        opacity: 0.8;
        text-shadow: none;
    }

    .modal-header .close:hover {
        opacity: 1;
    }

    .modal-body {
        padding: 25px;
    }

    .form-group label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    .select2-container--default .select2-selection--multiple {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        min-height: 48px;
        padding: 4px 8px;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    .test-selection-container {
        background: #f8fafc;
        border-radius: 10px;
        padding: 20px;
        margin-top: 15px;
    }

    .selected-tests {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }

    .test-tag {
        background: #f59e0b;
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .test-tag .remove {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        width: 16px;
        height: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 10px;
    }

    .test-tag .remove:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    .modal-footer {
        border: none;
        padding: 20px 25px;
        background: #f8fafc;
        border-radius: 0 0 15px 15px;
    }

    /* Loading States */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loading-spinner {
        width: 60px;
        height: 60px;
        border: 4px solid #f3f4f6;
        border-top: 4px solid #f59e0b;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        33% { transform: translate(30px, -30px) rotate(120deg); }
        66% { transform: translate(-20px, 20px) rotate(240deg); }
    }

    /* Package Tests Display */
    .package-tests-list {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 15px;
        background: #f9fafb;
    }

    .package-test-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .package-test-item:last-child {
        border-bottom: none;
    }

    .package-test-name {
        font-weight: 500;
        color: #374151;
    }

    .package-test-code {
        font-size: 0.8rem;
        color: #6b7280;
        font-family: 'Courier New', monospace;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .packages-header {
            padding: 25px;
            text-align: center;
        }

        .stats-cards {
            flex-direction: column;
        }

        .action-buttons {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="packages-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0">
                    <i class="fas fa-box mr-3"></i>Test Packages Management
                </h1>
                <p class="mb-0 mt-2 opacity-75">Create and manage laboratory test packages with bundled pricing</p>
            </div>
            <div class="col-md-4 text-right">
                <button class="btn btn-add-package" data-toggle="modal" data-target="#packageModal" id="createNewPackage">
                    <i class="fas fa-plus mr-2"></i>Add New Package
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-cards">
        <div class="stats-card" style="--accent-color: #f59e0b;">
            <div class="stats-number">{{ \App\Models\Package::count() }}</div>
            <div class="stats-label">Total Packages</div>
        </div>
        <div class="stats-card" style="--accent-color: #059669;">
            <div class="stats-number">{{ \App\Models\Package::where('status', 1)->count() }}</div>
            <div class="stats-label">Active Packages</div>
        </div>
        <div class="stats-card" style="--accent-color: #dc2626;">
            <div class="stats-number">{{ \App\Models\Package::where('status', 0)->count() }}</div>
            <div class="stats-label">Inactive Packages</div>
        </div>
        <div class="stats-card" style="--accent-color: #06b6d4;">
            <div class="stats-number">{{ \App\Models\Package::avg('amount') ? number_format(\App\Models\Package::avg('amount'), 0) : 0 }}</div>
            <div class="stats-label">Avg Package Cost</div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <button class="btn btn-outline-secondary" id="refreshTable">
            <i class="fas fa-sync-alt mr-2"></i>Refresh
        </button>
        <button class="btn btn-outline-info" id="exportData">
            <i class="fas fa-download mr-2"></i>Export Excel
        </button>
        <button class="btn btn-outline-success" id="bulkImport">
            <i class="fas fa-upload mr-2"></i>Bulk Import
        </button>
    </div>

    <!-- Packages Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-striped packages-table" id="packagesTable">
                <thead>
                    <tr>
                        <th width="50px">#</th>
                        <th>Package Name</th>
                        <th width="120px">Amount</th>
                        <th width="100px">Test Count</th>
                        <th>Description</th>
                        <th width="100px">Status</th>
                        <th width="150px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Package Modal -->
<div class="modal fade" id="packageModal" tabindex="-1" role="dialog" aria-labelledby="packageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="packageModalLabel">
                    <i class="fas fa-box mr-2"></i>Add New Package
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="packageForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="package_id" name="package_id">
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="package_name">Package Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="package_name" name="package_name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="amount">Package Amount (₹) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="amount" name="amount" step="0.01" min="0" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Test Selection -->
                    <div class="test-selection-container">
                        <h6><i class="fas fa-flask mr-2"></i>Select Tests for Package</h6>
                        <div class="form-group mt-3">
                            <label for="tests">Available Tests</label>
                            <select class="form-control select2-tests" id="tests" name="tests[]" multiple>
                                @foreach(\App\Models\Test::where('status', 1)->orderBy('test_name')->get() as $test)
                                    <option value="{{ $test->id }}" data-code="{{ $test->testcode }}" data-cost="{{ $test->cost }}">
                                        {{ $test->test_name }} ({{ $test->testcode }}) - ₹{{ $test->cost }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <div class="selected-tests" id="selectedTests">
                            <!-- Selected tests will appear here -->
                        </div>
                        
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Individual Test Cost: ₹<span id="individualCost">0.00</span></strong>
                                </div>
                                <div class="col-md-6 text-right">
                                    <strong>Package Savings: ₹<span id="packageSavings">0.00</span></strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="validity_days">Validity (Days)</label>
                                <input type="number" class="form-control" id="validity_days" name="validity_days" min="1" value="30">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-control custom-switch mt-4">
                                    <input type="checkbox" class="custom-control-input" id="status" name="status" checked>
                                    <label class="custom-control-label" for="status">Active Status</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="savePackage">
                        <i class="fas fa-save mr-2"></i>Save Package
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
                            <table class="table table-bordered">
                                <tbody id="packageDetails">
                                    <!-- Details will be loaded via Ajax -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-flask mr-2"></i>Included Tests</h6>
                        <div id="packageTests" class="package-tests-list">
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

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>
@endsection

@push('scripts')
<!-- DataTables & plugins -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Initialize Select2
    $('.select2-tests').select2({
        theme: 'default',
        width: '100%',
        placeholder: 'Search and select tests...',
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
                Swal.fire('Error', 'Error loading packages data', 'error');
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'package_name', name: 'package_name', className: 'package-name'},
            {data: 'amount_display', name: 'amount', orderable: false},
            {data: 'test_count', name: 'test_count', orderable: false},
            {data: 'description', name: 'description'},
            {data: 'status', name: 'status', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                className: 'btn-primary d-none',
                text: '<i class="fas fa-file-excel"></i> Export Excel'
            }
        ],
        order: [[1, 'asc']],
        pageLength: 25,
        language: {
            processing: '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"></div></div>',
            emptyTable: '<div class="text-center"><i class="fas fa-box fa-3x text-muted mb-3"></i><br>No packages found</div>'
        }
    });

    // Utility Functions
    function showLoading() {
        $('#loadingOverlay').show();
    }

    function hideLoading() {
        $('#loadingOverlay').hide();
    }

    function resetForm() {
        $('#packageForm')[0].reset();
        $('#package_id').val('');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').empty();
        $('#status').prop('checked', true);
        $('.select2-tests').val(null).trigger('change');
        $('#selectedTests').empty();
        updateCostCalculations();
    }

    function updateCostCalculations() {
        var selectedOptions = $('.select2-tests').find(':selected');
        var totalCost = 0;
        
        selectedOptions.each(function() {
            totalCost += parseFloat($(this).data('cost')) || 0;
        });
        
        var packageAmount = parseFloat($('#amount').val()) || 0;
        var savings = totalCost - packageAmount;
        
        $('#individualCost').text(totalCost.toFixed(2));
        $('#packageSavings').text(savings > 0 ? savings.toFixed(2) : '0.00');
    }

    function updateSelectedTests() {
        var selectedOptions = $('.select2-tests').find(':selected');
        var container = $('#selectedTests');
        container.empty();
        
        selectedOptions.each(function() {
            var testName = $(this).text().split(' (')[0];
            var testCode = $(this).data('code');
            var testCost = $(this).data('cost');
            
            var tag = $(`
                <div class="test-tag">
                    <span>${testName} (${testCode}) - ₹${testCost}</span>
                    <span class="remove" data-test-id="${$(this).val()}">×</span>
                </div>
            `);
            
            container.append(tag);
        });
        
        updateCostCalculations();
    }

    // Event Handlers
    $('.select2-tests').on('change', function() {
        updateSelectedTests();
    });

    $('#amount').on('input', function() {
        updateCostCalculations();
    });

    $(document).on('click', '.test-tag .remove', function() {
        var testId = $(this).data('test-id');
        var select = $('.select2-tests');
        var values = select.val() || [];
        values = values.filter(id => id != testId);
        select.val(values).trigger('change');
    });

    $('#createNewPackage').click(function() {
        resetForm();
        $('#packageModalLabel').html('<i class="fas fa-plus mr-2"></i>Add New Package');
        $('#packageModal').modal('show');
    });

    $('#refreshTable').click(function() {
        table.ajax.reload();
        Swal.fire({
            icon: 'success',
            title: 'Refreshed',
            text: 'Table data refreshed successfully',
            timer: 1500,
            showConfirmButton: false
        });
    });

    $('#exportData').click(function() {
        $('.buttons-excel').click();
    });

    // Edit package
    $(document).on('click', '.editPackage', function() {
        var id = $(this).data('id');
        showLoading();
        
        $.ajax({
            url: "{{ route('admin.packages.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                hideLoading();
                resetForm();
                
                $('#package_id').val(data.id);
                $('#package_name').val(data.package_name);
                $('#amount').val(data.amount);
                $('#description').val(data.description);
                $('#validity_days').val(data.validity_days || 30);
                $('#status').prop('checked', data.status == 1);
                
                // Set selected tests
                if (data.tests && data.tests.length > 0) {
                    var testIds = data.tests.map(test => test.id.toString());
                    $('.select2-tests').val(testIds).trigger('change');
                }
                
                $('#packageModalLabel').html('<i class="fas fa-edit mr-2"></i>Edit Package');
                $('#packageModal').modal('show');
            },
            error: function() {
                hideLoading();
                Swal.fire('Error', 'Error loading package data', 'error');
            }
        });
    });

    // View package
    $(document).on('click', '.viewPackage', function() {
        var id = $(this).data('id');
        showLoading();
        
        $.ajax({
            url: "{{ route('admin.packages.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                hideLoading();
                
                var detailsHtml = `
                    <tr><th width="200px">Package Name</th><td><strong>${data.package_name || 'N/A'}</strong></td></tr>
                    <tr><th>Amount</th><td><span class="amount-badge">₹ ${data.amount ? parseFloat(data.amount).toFixed(2) : '0.00'}</span></td></tr>
                    <tr><th>Description</th><td>${data.description || 'N/A'}</td></tr>
                    <tr><th>Validity</th><td>${data.validity_days || 'N/A'} days</td></tr>
                    <tr><th>Status</th><td>${data.status ? '<span class="status-badge status-active">Active</span>' : '<span class="status-badge status-inactive">Inactive</span>'}</td></tr>
                    <tr><th>Created</th><td>${data.created_at_formatted || 'N/A'}</td></tr>
                `;
                
                $('#packageDetails').html(detailsHtml);
                
                // Display included tests
                var testsHtml = '';
                if (data.tests && data.tests.length > 0) {
                    data.tests.forEach(function(test) {
                        testsHtml += `
                            <div class="package-test-item">
                                <div>
                                    <div class="package-test-name">${test.test_name}</div>
                                    <div class="package-test-code">${test.testcode}</div>
                                </div>
                                <div class="text-right">
                                    <span class="test-count-badge">₹${test.cost || '0.00'}</span>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    testsHtml = '<div class="text-center text-muted">No tests included</div>';
                }
                
                $('#packageTests').html(testsHtml);
                $('#viewPackageModal').modal('show');
            },
            error: function() {
                hideLoading();
                Swal.fire('Error', 'Error loading package data', 'error');
            }
        });
    });

    // Save package
    $('#packageForm').submit(function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var url = "{{ route('admin.packages.store') }}";

        showLoading();

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                hideLoading();
                $('#packageModal').modal('hide');
                table.ajax.reload();
                
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Package saved successfully',
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function(xhr) {
                hideLoading();
                
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        $('#' + field).addClass('is-invalid');
                        $('#' + field).siblings('.invalid-feedback').text(messages[0]);
                    });
                } else {
                    Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                }
            }
        });
    });

    // Delete package
    $(document).on('click', '.deletePackage', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        
        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to delete the package "${name}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                
                $.ajax({
                    url: "{{ route('admin.packages.destroy', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    success: function(response) {
                        hideLoading();
                        table.ajax.reload();
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message || 'Package deleted successfully',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function() {
                        hideLoading();
                        Swal.fire('Error', 'Error deleting package', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
