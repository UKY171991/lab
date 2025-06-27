@extends('admin.layouts.app')

@section('title', 'Laboratory Tests')
@section('page-title', 'Laboratory Tests')
@section('breadcrumb', 'Master / Tests')

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.bootstrap4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

<style>
    .tests-header {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        color: white;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(6, 182, 212, 0.3);
    }
    
    .tests-header::before {
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
    
    .tests-header::after {
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
        background: var(--accent-color, #06b6d4);
        border-radius: 15px 15px 0 0;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: var(--accent-color, #06b6d4);
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

    .btn-add-test {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        border: none;
        padding: 12px 25px;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(6, 182, 212, 0.3);
    }

    .btn-add-test:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(6, 182, 212, 0.4);
        color: white;
    }

    .filter-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .filter-row {
        display: flex;
        gap: 15px;
        align-items: end;
        flex-wrap: wrap;
    }

    .filter-group {
        flex: 1;
        min-width: 200px;
    }

    .table-container {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .tests-table {
        margin-bottom: 0;
    }

    .tests-table thead th {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border: none;
        color: #374151;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.875rem;
        padding: 15px 12px;
    }

    .tests-table tbody td {
        padding: 15px 12px;
        vertical-align: middle;
        border-color: #f1f5f9;
    }

    .tests-table tbody tr {
        transition: all 0.2s ease;
    }

    .tests-table tbody tr:hover {
        background: #f8fafc;
        transform: translateX(2px);
    }

    .test-name {
        font-weight: 600;
        color: #1f2937;
    }

    .test-code {
        background: #f3f4f6;
        color: #6b7280;
        padding: 4px 8px;
        border-radius: 6px;
        font-family: 'Courier New', monospace;
        font-size: 0.8rem;
    }

    .specimen-badge {
        background: #dbeafe;
        color: #1e40af;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .unit-display {
        background: #f0fdf4;
        color: #166534;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.8rem;
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
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
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
        border-color: #06b6d4;
        box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1);
    }

    .select2-container--default .select2-selection--single {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        height: 48px;
        padding: 8px 12px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px;
        color: #374151;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #06b6d4;
        box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1);
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
        border-top: 4px solid #06b6d4;
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .tests-header {
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

        .filter-row {
            flex-direction: column;
        }

        .filter-group {
            min-width: auto;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="tests-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0">
                    <i class="fas fa-flask mr-3"></i>Laboratory Tests Management
                </h1>
                <p class="mb-0 mt-2 opacity-75">Manage laboratory tests, specimens, and parameters</p>
            </div>
            <div class="col-md-4 text-right">
                <button class="btn btn-add-test" data-toggle="modal" data-target="#testModal" id="createNewTest">
                    <i class="fas fa-plus mr-2"></i>Add New Test
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-cards">
        <div class="stats-card" style="--accent-color: #06b6d4;">
            <div class="stats-number">{{ \App\Models\Test::count() }}</div>
            <div class="stats-label">Total Tests</div>
        </div>
        <div class="stats-card" style="--accent-color: #059669;">
            <div class="stats-number">{{ \App\Models\Test::where('status', 1)->count() }}</div>
            <div class="stats-label">Active Tests</div>
        </div>
        <div class="stats-card" style="--accent-color: #8b5cf6;">
            <div class="stats-number">{{ \App\Models\TestCategory::count() }}</div>
            <div class="stats-label">Categories</div>
        </div>
        <div class="stats-card" style="--accent-color: #f59e0b;">
            <div class="stats-number">{{ \App\Models\Test::where('created_at', '>=', now()->startOfMonth())->count() }}</div>
            <div class="stats-label">Added This Month</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-card">
        <h6 class="mb-3"><i class="fas fa-filter mr-2"></i>Filters</h6>
        <div class="filter-row">
            <div class="filter-group">
                <label for="categoryFilter">Category</label>
                <select class="form-control" id="categoryFilter">
                    <option value="">All Categories</option>
                    @foreach(\App\Models\TestCategory::where('status', 1)->get() as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label for="statusFilter">Status</label>
                <select class="form-control" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="specimenFilter">Specimen</label>
                <select class="form-control" id="specimenFilter">
                    <option value="">All Specimens</option>
                    <option value="Blood">Blood</option>
                    <option value="Urine">Urine</option>
                    <option value="Stool">Stool</option>
                    <option value="Sputum">Sputum</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="filter-group">
                <button class="btn btn-primary" id="applyFilters">
                    <i class="fas fa-search mr-2"></i>Apply Filters
                </button>
                <button class="btn btn-outline-secondary ml-2" id="clearFilters">
                    <i class="fas fa-times mr-2"></i>Clear
                </button>
            </div>
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

    <!-- Tests Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-striped tests-table" id="testsTable">
                <thead>
                    <tr>
                        <th width="50px">#</th>
                        <th>Test Name</th>
                        <th>Test Code</th>
                        <th>Category</th>
                        <th>Specimen</th>
                        <th>Unit</th>
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

<!-- Add/Edit Test Modal -->
<div class="modal fade" id="testModal" tabindex="-1" role="dialog" aria-labelledby="testModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="testModalLabel">
                    <i class="fas fa-flask mr-2"></i>Add New Test
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="testForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="test_id" name="test_id">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="test_name">Test Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="test_name" name="test_name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="testcode">Test Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="testcode" name="testcode" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select class="form-control select2" id="category_id" name="category_id">
                                    <option value="">Select Category</option>
                                    @foreach(\App\Models\TestCategory::where('status', 1)->get() as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specimen">Specimen <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="specimen" name="specimen" required>
                                    <option value="">Select Specimen</option>
                                    <option value="Blood">Blood</option>
                                    <option value="Urine">Urine</option>
                                    <option value="Stool">Stool</option>
                                    <option value="Sputum">Sputum</option>
                                    <option value="Swab">Swab</option>
                                    <option value="CSF">CSF</option>
                                    <option value="Other">Other</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="unit">Unit</label>
                                <input type="text" class="form-control" id="unit" name="unit" placeholder="e.g., mg/dL, %">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="normal_range">Normal Range</label>
                                <input type="text" class="form-control" id="normal_range" name="normal_range" placeholder="e.g., 70-100">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cost">Cost (₹)</label>
                                <input type="number" class="form-control" id="cost" name="cost" step="0.01" min="0">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="method">Method/Technique</label>
                                <input type="text" class="form-control" id="method" name="method" placeholder="e.g., ELISA, PCR">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="reporting_time">Reporting Time</label>
                                <select class="form-control" id="reporting_time" name="reporting_time">
                                    <option value="">Select Time</option>
                                    <option value="Same Day">Same Day</option>
                                    <option value="Next Day">Next Day</option>
                                    <option value="2-3 Days">2-3 Days</option>
                                    <option value="3-5 Days">3-5 Days</option>
                                    <option value="1 Week">1 Week</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sub_heading">Sub Heading</label>
                                <input type="text" class="form-control" id="sub_heading" name="sub_heading">
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
                    <button type="submit" class="btn btn-primary" id="saveTest">
                        <i class="fas fa-save mr-2"></i>Save Test
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Test Modal -->
<div class="modal fade" id="viewTestModal" tabindex="-1" role="dialog" aria-labelledby="viewTestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewTestModalLabel">
                    <i class="fas fa-eye mr-2"></i>Test Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody id="testDetails">
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
    $('.select2').select2({
        theme: 'default',
        width: '100%'
    });

    // Initialize DataTable
    var table = $('#testsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.tests.data') }}",
            data: function(d) {
                d.category_filter = $('#categoryFilter').val();
                d.status_filter = $('#statusFilter').val();
                d.specimen_filter = $('#specimenFilter').val();
            },
            error: function(xhr, error, thrown) {
                Swal.fire('Error', 'Error loading tests data', 'error');
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'test_name', name: 'test_name', className: 'test-name'},
            {data: 'testcode', name: 'testcode'},
            {data: 'category_name', name: 'category.category_name'},
            {data: 'specimen', name: 'specimen'},
            {data: 'unit', name: 'unit'},
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
            emptyTable: '<div class="text-center"><i class="fas fa-flask fa-3x text-muted mb-3"></i><br>No tests found</div>'
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
        $('#testForm')[0].reset();
        $('#test_id').val('');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').empty();
        $('#status').prop('checked', true);
        $('.select2').val(null).trigger('change');
    }

    // Event Handlers
    $('#createNewTest').click(function() {
        resetForm();
        $('#testModalLabel').html('<i class="fas fa-plus mr-2"></i>Add New Test');
        $('#testModal').modal('show');
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

    $('#applyFilters').click(function() {
        table.ajax.reload();
    });

    $('#clearFilters').click(function() {
        $('#categoryFilter, #statusFilter, #specimenFilter').val('').trigger('change');
        table.ajax.reload();
    });

    // Edit test
    $(document).on('click', '.editTest', function() {
        var id = $(this).data('id');
        showLoading();
        
        $.ajax({
            url: "{{ route('admin.tests.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                hideLoading();
                resetForm();
                
                $('#test_id').val(data.id);
                $('#test_name').val(data.test_name);
                $('#testcode').val(data.testcode);
                $('#category_id').val(data.category_id).trigger('change');
                $('#specimen').val(data.specimen).trigger('change');
                $('#unit').val(data.unit);
                $('#normal_range').val(data.normal_range);
                $('#cost').val(data.cost);
                $('#method').val(data.method);
                $('#reporting_time').val(data.reporting_time);
                $('#description').val(data.description);
                $('#sub_heading').val(data.sub_heading);
                $('#status').prop('checked', data.status == 1);
                
                $('#testModalLabel').html('<i class="fas fa-edit mr-2"></i>Edit Test');
                $('#testModal').modal('show');
            },
            error: function() {
                hideLoading();
                Swal.fire('Error', 'Error loading test data', 'error');
            }
        });
    });

    // View test
    $(document).on('click', '.viewTest', function() {
        var id = $(this).data('id');
        showLoading();
        
        $.ajax({
            url: "{{ route('admin.tests.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                hideLoading();
                
                var detailsHtml = `
                    <tr><th width="200px">Test Name</th><td><strong>${data.test_name || 'N/A'}</strong></td></tr>
                    <tr><th>Test Code</th><td><span class="test-code">${data.testcode || 'N/A'}</span></td></tr>
                    <tr><th>Category</th><td>${data.category ? data.category.category_name : 'N/A'}</td></tr>
                    <tr><th>Specimen</th><td><span class="specimen-badge">${data.specimen || 'N/A'}</span></td></tr>
                    <tr><th>Unit</th><td><span class="unit-display">${data.unit || 'N/A'}</span></td></tr>
                    <tr><th>Normal Range</th><td>${data.normal_range || 'N/A'}</td></tr>
                    <tr><th>Cost</th><td>₹ ${data.cost ? parseFloat(data.cost).toFixed(2) : '0.00'}</td></tr>
                    <tr><th>Method</th><td>${data.method || 'N/A'}</td></tr>
                    <tr><th>Reporting Time</th><td>${data.reporting_time || 'N/A'}</td></tr>
                    <tr><th>Description</th><td>${data.description || 'N/A'}</td></tr>
                    <tr><th>Sub Heading</th><td>${data.sub_heading || 'N/A'}</td></tr>
                    <tr><th>Status</th><td>${data.status ? '<span class="status-badge status-active">Active</span>' : '<span class="status-badge status-inactive">Inactive</span>'}</td></tr>
                    <tr><th>Created</th><td>${data.created_at_formatted || 'N/A'}</td></tr>
                `;
                
                $('#testDetails').html(detailsHtml);
                $('#viewTestModal').modal('show');
            },
            error: function() {
                hideLoading();
                Swal.fire('Error', 'Error loading test data', 'error');
            }
        });
    });

    // Save test
    $('#testForm').submit(function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var url = "{{ route('admin.tests.store') }}";

        showLoading();

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                hideLoading();
                $('#testModal').modal('hide');
                table.ajax.reload();
                
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Test saved successfully',
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

    // Delete test
    $(document).on('click', '.deleteTest', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        
        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to delete the test "${name}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                
                $.ajax({
                    url: "{{ route('admin.tests.destroy', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    success: function(response) {
                        hideLoading();
                        table.ajax.reload();
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message || 'Test deleted successfully',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function() {
                        hideLoading();
                        Swal.fire('Error', 'Error deleting test', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
