@extends('admin.layouts.app')

@section('title', 'Medical Reports')
@section('page-title', 'Medical Reports')
@section('breadcrumb', 'Reports')

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.bootstrap4.min.css">
<!-- Date Range Picker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

<style>
    .reports-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }
    
    .reports-header::before {
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
    
    .reports-header::after {
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
        background: var(--accent-color, #667eea);
        border-radius: 15px 15px 0 0;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: var(--accent-color, #667eea);
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

    .btn-add-report {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px 25px;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-add-report:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
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

    .reports-table {
        margin-bottom: 0;
    }

    .reports-table thead th {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border: none;
        color: #374151;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.875rem;
        padding: 15px 12px;
    }

    .reports-table tbody td {
        padding: 15px 12px;
        vertical-align: middle;
        border-color: #f1f5f9;
    }

    .reports-table tbody tr {
        transition: all 0.2s ease;
    }

    .reports-table tbody tr:hover {
        background: #f8fafc;
        transform: translateX(2px);
    }

    .report-id {
        font-weight: 600;
        color: #667eea;
        font-family: 'Courier New', monospace;
    }

    .patient-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .patient-name {
        font-weight: 600;
        color: #1f2937;
    }

    .patient-id {
        color: #6b7280;
        font-size: 0.875rem;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-in-progress {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-completed {
        background: #dcfce7;
        color: #166534;
    }

    .status-delivered {
        background: #e0e7ff;
        color: #3730a3;
    }

    .priority-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .priority-low {
        background: #f0fdf4;
        color: #166534;
    }

    .priority-normal {
        background: #f0f9ff;
        color: #0369a1;
    }

    .priority-high {
        background: #fef2f2;
        color: #991b1b;
    }

    .priority-urgent {
        background: #fdf2f8;
        color: #be185d;
    }

    .action-btn {
        padding: 6px 12px;
        border-radius: 6px;
        border: none;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        margin: 0 2px;
    }

    .action-btn-view {
        background: #dbeafe;
        color: #1e40af;
    }

    .action-btn-view:hover {
        background: #3b82f6;
        color: white;
    }

    .action-btn-edit {
        background: #fef3c7;
        color: #92400e;
    }

    .action-btn-edit:hover {
        background: #fbbf24;
        color: white;
    }

    .action-btn-print {
        background: #f3e8ff;
        color: #7c3aed;
    }

    .action-btn-print:hover {
        background: #8b5cf6;
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

    /* Modal Enhancements */
    .modal-content {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .modal-footer {
        border: none;
        padding: 20px 25px;
        background: #f8fafc;
        border-radius: 0 0 15px 15px;
    }

    /* Report Timeline */
    .report-timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        position: relative;
    }

    .timeline-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
        margin-right: 15px;
        position: relative;
        z-index: 2;
    }

    .timeline-icon::after {
        content: '';
        position: absolute;
        top: 40px;
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        height: 30px;
        background: #e5e7eb;
        z-index: -1;
    }

    .timeline-item:last-child .timeline-icon::after {
        display: none;
    }

    .timeline-content {
        flex: 1;
    }

    .timeline-title {
        font-weight: 600;
        color: #374151;
        margin-bottom: 2px;
    }

    .timeline-time {
        color: #6b7280;
        font-size: 0.875rem;
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
        border-top: 4px solid #667eea;
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
        .reports-header {
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
    <div class="reports-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0">
                    <i class="fas fa-file-medical-alt mr-3"></i>Medical Reports Management
                </h1>
                <p class="mb-0 mt-2 opacity-75">Track and manage laboratory test reports and results</p>
            </div>
            <div class="col-md-4 text-right">
                <button class="btn btn-add-report" data-toggle="modal" data-target="#reportModal" id="createNewReport">
                    <i class="fas fa-plus mr-2"></i>Create New Report
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-cards">
        <div class="stats-card" style="--accent-color: #667eea;">
            <div class="stats-number">{{ \App\Models\Report::count() }}</div>
            <div class="stats-label">Total Reports</div>
        </div>
        <div class="stats-card" style="--accent-color: #fbbf24;">
            <div class="stats-number">{{ \App\Models\Report::where('report_status', 'pending')->count() }}</div>
            <div class="stats-label">Pending Reports</div>
        </div>
        <div class="stats-card" style="--accent-color: #06b6d4;">
            <div class="stats-number">{{ \App\Models\Report::where('report_status', 'in_progress')->count() }}</div>
            <div class="stats-label">In Progress</div>
        </div>
        <div class="stats-card" style="--accent-color: #10b981;">
            <div class="stats-number">{{ \App\Models\Report::where('report_status', 'completed')->count() }}</div>
            <div class="stats-label">Completed</div>
        </div>
        <div class="stats-card" style="--accent-color: #8b5cf6;">
            <div class="stats-number">{{ \App\Models\Report::where('created_at', '>=', now()->startOfDay())->count() }}</div>
            <div class="stats-label">Today's Reports</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-card">
        <h6 class="mb-3"><i class="fas fa-filter mr-2"></i>Filters</h6>
        <div class="filter-row">
            <div class="filter-group">
                <label for="statusFilter">Status</label>
                <select class="form-control" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                    <option value="delivered">Delivered</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="priorityFilter">Priority</label>
                <select class="form-control" id="priorityFilter">
                    <option value="">All Priorities</option>
                    <option value="low">Low</option>
                    <option value="normal">Normal</option>
                    <option value="high">High</option>
                    <option value="urgent">Urgent</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="dateRangeFilter">Date Range</label>
                <input type="text" class="form-control" id="dateRangeFilter" placeholder="Select date range">
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
        <button class="btn btn-outline-success" id="bulkPrint">
            <i class="fas fa-print mr-2"></i>Bulk Print
        </button>
        <button class="btn btn-outline-warning" id="generateStatistics">
            <i class="fas fa-chart-bar mr-2"></i>Statistics
        </button>
    </div>

    <!-- Reports Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-striped reports-table" id="reportsTable">
                <thead>
                    <tr>
                        <th width="50px">#</th>
                        <th>Report ID</th>
                        <th>Patient Info</th>
                        <th>Doctor</th>
                        <th>Tests</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Created</th>
                        <th width="150px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- View Report Modal -->
<div class="modal fade" id="viewReportModal" tabindex="-1" role="dialog" aria-labelledby="viewReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewReportModalLabel">
                    <i class="fas fa-eye mr-2"></i>Report Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody id="reportDetails">
                                    <!-- Details will be loaded via Ajax -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6><i class="fas fa-history mr-2"></i>Report Timeline</h6>
                        <div class="report-timeline" id="reportTimeline">
                            <!-- Timeline will be loaded via Ajax -->
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h6><i class="fas fa-flask mr-2"></i>Test Results</h6>
                    <div id="testResults" class="table-responsive">
                        <!-- Test results will be loaded via Ajax -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i>Close
                </button>
                <button type="button" class="btn btn-primary" id="printReport">
                    <i class="fas fa-print mr-2"></i>Print Report
                </button>
                <button type="button" class="btn btn-success" id="downloadReport">
                    <i class="fas fa-download mr-2"></i>Download PDF
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Create/Edit Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">
                    <i class="fas fa-file-medical-alt mr-2"></i>Create New Report
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="reportForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="report_id" name="report_id">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="patient_id">Patient <span class="text-danger">*</span></label>
                                <select class="form-control" id="patient_id" name="patient_id" required>
                                    <option value="">Select Patient</option>
                                    @foreach(\App\Models\Patient::orderBy('client_name')->get() as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->client_name }} ({{ $patient->uhid }})</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="doctor_id">Doctor</label>
                                <select class="form-control" id="doctor_id" name="doctor_id">
                                    <option value="">Select Doctor</option>
                                    @foreach(\App\Models\Doctor::where('status', 1)->orderBy('doctor_name')->get() as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->doctor_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="report_status">Status</label>
                                <select class="form-control" id="report_status" name="report_status">
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="delivered">Delivered</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="priority">Priority</label>
                                <select class="form-control" id="priority" name="priority">
                                    <option value="normal">Normal</option>
                                    <option value="low">Low</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="test_date">Test Date</label>
                                <input type="date" class="form-control" id="test_date" name="test_date" value="{{ date('Y-m-d') }}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="delivery_date">Expected Delivery</label>
                                <input type="date" class="form-control" id="delivery_date" name="delivery_date">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tests">Select Tests <span class="text-danger">*</span></label>
                        <select class="form-control" id="tests" name="tests[]" multiple required>
                            @foreach(\App\Models\Test::where('status', 1)->orderBy('test_name')->get() as $test)
                                <option value="{{ $test->id }}">{{ $test->test_name }} ({{ $test->testcode }})</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="saveReport">
                        <i class="fas fa-save mr-2"></i>Save Report
                    </button>
                </div>
            </form>
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
<!-- Date Range Picker -->
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
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

    // Initialize Date Range Picker
    $('#dateRangeFilter').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('#dateRangeFilter').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });

    $('#dateRangeFilter').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    // Initialize DataTable
    var table = $('#reportsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.reports.data') }}",
            data: function(d) {
                d.status_filter = $('#statusFilter').val();
                d.priority_filter = $('#priorityFilter').val();
                d.date_range = $('#dateRangeFilter').val();
            },
            error: function(xhr, error, thrown) {
                Swal.fire('Error', 'Error loading reports data', 'error');
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'report_id', name: 'report_id', className: 'report-id'},
            {data: 'patient_info', name: 'patient_info', orderable: false},
            {data: 'doctor_name', name: 'doctor_name'},
            {data: 'test_count', name: 'test_count', orderable: false},
            {data: 'status', name: 'report_status', orderable: false},
            {data: 'priority', name: 'priority', orderable: false},
            {data: 'created_at_formatted', name: 'created_at'},
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
        order: [[7, 'desc']],
        pageLength: 25,
        language: {
            processing: '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"></div></div>',
            emptyTable: '<div class="text-center"><i class="fas fa-file-medical-alt fa-3x text-muted mb-3"></i><br>No reports found</div>'
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
        $('#reportForm')[0].reset();
        $('#report_id').val('');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').empty();
        $('#test_date').val('{{ date("Y-m-d") }}');
    }

    // Event Handlers
    $('#createNewReport').click(function() {
        resetForm();
        $('#reportModalLabel').html('<i class="fas fa-plus mr-2"></i>Create New Report');
        $('#reportModal').modal('show');
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
        $('#statusFilter, #priorityFilter').val('');
        $('#dateRangeFilter').val('');
        table.ajax.reload();
    });

    // View report
    $(document).on('click', '.viewReport', function() {
        var id = $(this).data('id');
        showLoading();
        
        $.ajax({
            url: "{{ route('admin.reports.show', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                hideLoading();
                
                // Populate report details
                var detailsHtml = `
                    <tr><th width="200px">Report ID</th><td><span class="report-id">${data.report_number || 'N/A'}</span></td></tr>
                    <tr><th>Patient</th><td><strong>${data.patient ? data.patient.client_name : 'N/A'}</strong> (${data.patient ? data.patient.uhid : 'N/A'})</td></tr>
                    <tr><th>Doctor</th><td>${data.doctor ? data.doctor.doctor_name : 'N/A'}</td></tr>
                    <tr><th>Status</th><td><span class="status-badge status-${data.report_status}">${data.report_status ? data.report_status.replace('_', ' ').toUpperCase() : 'N/A'}</span></td></tr>
                    <tr><th>Priority</th><td><span class="priority-badge priority-${data.priority}">${data.priority ? data.priority.toUpperCase() : 'N/A'}</span></td></tr>
                    <tr><th>Test Date</th><td>${data.test_date || 'N/A'}</td></tr>
                    <tr><th>Delivery Date</th><td>${data.delivery_date || 'N/A'}</td></tr>
                    <tr><th>Notes</th><td>${data.notes || 'N/A'}</td></tr>
                    <tr><th>Created</th><td>${data.created_at_formatted || 'N/A'}</td></tr>
                `;
                
                $('#reportDetails').html(detailsHtml);
                
                // Populate timeline
                var timelineHtml = '';
                if (data.timeline && data.timeline.length > 0) {
                    data.timeline.forEach(function(item) {
                        var iconColor = {
                            'created': '#667eea',
                            'in_progress': '#06b6d4',
                            'completed': '#10b981',
                            'delivered': '#8b5cf6'
                        }[item.status] || '#6b7280';
                        
                        timelineHtml += `
                            <div class="timeline-item">
                                <div class="timeline-icon" style="background: ${iconColor}">
                                    <i class="fas fa-${getTimelineIcon(item.status)}"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-title">${item.title}</div>
                                    <div class="timeline-time">${item.time}</div>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    timelineHtml = '<div class="text-center text-muted">No timeline data available</div>';
                }
                
                $('#reportTimeline').html(timelineHtml);
                
                // Populate test results
                var testsHtml = '';
                if (data.tests && data.tests.length > 0) {
                    testsHtml = `
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Test Name</th>
                                    <th>Result</th>
                                    <th>Normal Range</th>
                                    <th>Unit</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                    
                    data.tests.forEach(function(test) {
                        testsHtml += `
                            <tr>
                                <td><strong>${test.test_name}</strong><br><small class="text-muted">${test.testcode}</small></td>
                                <td>${test.result || '<span class="text-muted">Pending</span>'}</td>
                                <td>${test.normal_range || 'N/A'}</td>
                                <td>${test.unit || 'N/A'}</td>
                                <td>${test.status ? '<span class="badge badge-success">Completed</span>' : '<span class="badge badge-warning">Pending</span>'}</td>
                            </tr>
                        `;
                    });
                    
                    testsHtml += '</tbody></table>';
                } else {
                    testsHtml = '<div class="text-center text-muted">No tests found for this report</div>';
                }
                
                $('#testResults').html(testsHtml);
                $('#viewReportModal').modal('show');
            },
            error: function() {
                hideLoading();
                Swal.fire('Error', 'Error loading report data', 'error');
            }
        });
    });

    function getTimelineIcon(status) {
        var icons = {
            'created': 'plus',
            'in_progress': 'spinner',
            'completed': 'check',
            'delivered': 'check-double'
        };
        return icons[status] || 'circle';
    }

    // Save report
    $('#reportForm').submit(function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var url = "{{ route('admin.reports.store') }}";

        showLoading();

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                hideLoading();
                $('#reportModal').modal('hide');
                table.ajax.reload();
                
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Report saved successfully',
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

    // Print report
    $('#printReport').click(function() {
        var reportId = $(this).data('report-id');
        window.open("{{ route('admin.reports.print', ':id') }}".replace(':id', reportId), '_blank');
    });

    // Download report
    $('#downloadReport').click(function() {
        var reportId = $(this).data('report-id');
        window.location.href = "{{ route('admin.reports.download', ':id') }}".replace(':id', reportId);
    });

    // Delete report
    $(document).on('click', '.deleteReport', function() {
        var id = $(this).data('id');
        var reportNumber = $(this).data('report-number');
        
        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to delete the report "${reportNumber}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                
                $.ajax({
                    url: "{{ route('admin.reports.destroy', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    success: function(response) {
                        hideLoading();
                        table.ajax.reload();
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message || 'Report deleted successfully',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function() {
                        hideLoading();
                        Swal.fire('Error', 'Error deleting report', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
