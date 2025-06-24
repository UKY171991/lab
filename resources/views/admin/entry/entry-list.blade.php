@extends('admin.layouts.app')

@section('title', 'Entry List')
@section('page-title', 'Entry List')
@section('breadcrumb', 'Entry / Entry List')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

<style>
.content-wrapper {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
}

.page-header {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.page-header h1 {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 2.5rem;
}

.page-header p {
    color: #6c757d;
    font-size: 1.1rem;
    margin: 0;
}

.stats-row {
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 1.5rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    text-align: center;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.stat-card .icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    display: block;
}

.stat-card.booking .icon { color: #27ae60; }
.stat-card.collection .icon { color: #f39c12; }
.stat-card.result .icon { color: #9b59b6; }
.stat-card.total .icon { color: #3498db; }

.stat-card h3 {
    font-size: 2rem;
    font-weight: 700;
    margin: 0.5rem 0;
    color: #2c3e50;
}

.stat-card p {
    margin: 0;
    color: #6c757d;
    font-weight: 500;
}

.main-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.main-card .card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 1.5rem 2rem;
    border-radius: 0;
}

.main-card .card-header h3 {
    margin: 0;
    font-weight: 600;
    font-size: 1.3rem;
}

.main-card .card-body {
    padding: 2rem;
}

.btn-group .btn {
    margin-right: 2px;
}

.badge-status {
    font-size: 0.9em;
    padding: 0.4em 0.8em;
}

.entry-type-booking {
    background: linear-gradient(45deg, #27ae60, #2ecc71);
    color: white;
}

.entry-type-collection {
    background: linear-gradient(45deg, #f39c12, #e67e22);
    color: white;
}

.entry-type-result {
    background: linear-gradient(45deg, #9b59b6, #8e44ad);
    color: white;
}
.stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 20px;
}
.quick-stats {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
}
.filter-section {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    border: 1px solid #dee2e6;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="totalEntries">156</h3>
                    <p>Total Entries</p>
                </div>
                <div class="icon">
                    <i class="fas fa-list"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 id="todayEntries">23</h3>
                    <p>Today's Entries</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 id="pendingEntries">12</h3>
                    <p>Pending Entries</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 id="completedEntries">121</h3>
                    <p>Completed Entries</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-filter mr-2"></i>Filters & Search
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="filterType">Entry Type</label>
                        <select class="form-control select2" id="filterType">
                            <option value="">All Types</option>
                            <option value="booking">Test Booking</option>
                            <option value="collection">Sample Collection</option>
                            <option value="result">Result Entry</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="filterStatus">Status</label>
                        <select class="form-control select2" id="filterStatus">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="filterDate">Date Range</label>
                        <input type="date" class="form-control" id="filterDate" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="filterPatient">Patient</label>
                        <select class="form-control select2" id="filterPatient">
                            <option value="">All Patients</option>
                            <option value="1">John Doe</option>
                            <option value="2">Jane Smith</option>
                            <option value="3">Mike Johnson</option>
                            <option value="4">Sarah Wilson</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary" id="applyFilters">
                        <i class="fas fa-search mr-2"></i>Apply Filters
                    </button>
                    <button type="button" class="btn btn-secondary ml-2" id="resetFilters">
                        <i class="fas fa-undo mr-2"></i>Reset
                    </button>
                    <button type="button" class="btn btn-success ml-2" id="exportData">
                        <i class="fas fa-download mr-2"></i>Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Entry List Table -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list mr-2"></i>All Entries
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success btn-sm" id="refreshTable">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="entryListTable" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Entry ID</th>
                            <th>Type</th>
                            <th>Patient</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Assigned To</th>
                            <th>Progress</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- View Entry Modal -->
<div class="modal fade" id="viewEntryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title">
                    <i class="fas fa-eye mr-2"></i>Entry Details
                </h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="entryDetailsContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4',
        allowClear: true
    });

    // Initialize DataTable
    var table = $('#entryListTable').DataTable({
        responsive: true,
        processing: true,
        serverSide: false, // Using static data for demo
        data: getDemoData(),
        columns: [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; } },
            { data: 'entry_id' },
            { 
                data: 'type',
                render: function(data, type, row) {
                    var badgeClass = '';
                    var icon = '';
                    if (data === 'booking') {
                        badgeClass = 'entry-type-booking';
                        icon = 'fas fa-calendar-plus';
                    } else if (data === 'collection') {
                        badgeClass = 'entry-type-collection';
                        icon = 'fas fa-vial';
                    } else if (data === 'result') {
                        badgeClass = 'entry-type-result';
                        icon = 'fas fa-flask';
                    }
                    return `<span class="badge ${badgeClass}"><i class="${icon} mr-1"></i>${data.charAt(0).toUpperCase() + data.slice(1)}</span>`;
                }
            },
            { data: 'patient' },
            { 
                data: 'date',
                render: function(data, type, row) {
                    return new Date(data).toLocaleDateString();
                }
            },
            { 
                data: 'status',
                render: function(data, type, row) {
                    var badgeClass = '';
                    if (data === 'pending') badgeClass = 'badge-warning';
                    else if (data === 'processing') badgeClass = 'badge-info';
                    else if (data === 'completed') badgeClass = 'badge-success';
                    else if (data === 'cancelled') badgeClass = 'badge-danger';
                    
                    return `<span class="badge ${badgeClass} badge-status">${data.charAt(0).toUpperCase() + data.slice(1)}</span>`;
                }
            },
            { 
                data: 'priority',
                render: function(data, type, row) {
                    var badgeClass = data === 'high' ? 'badge-danger' : (data === 'medium' ? 'badge-warning' : 'badge-success');
                    return `<span class="badge ${badgeClass}">${data.charAt(0).toUpperCase() + data.slice(1)}</span>`;
                }
            },
            { data: 'assigned_to' },
            { 
                data: 'progress',
                render: function(data, type, row) {
                    var progressClass = data >= 75 ? 'bg-success' : (data >= 50 ? 'bg-warning' : 'bg-info');
                    return `
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar ${progressClass}" role="progressbar" style="width: ${data}%">
                                ${data}%
                            </div>
                        </div>
                    `;
                }
            },
            { 
                data: null,
                render: function(data, type, row) {
                    return `
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-info btn-sm viewEntry" data-id="${row.id}" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-sm editEntry" data-id="${row.id}" title="Edit Entry">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-success btn-sm processEntry" data-id="${row.id}" title="Process Entry">
                                <i class="fas fa-play"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm deleteEntry" data-id="${row.id}" title="Delete Entry">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        order: [[4, 'desc']], // Sort by date
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        language: {
            processing: '<i class="fas fa-spinner fa-spin"></i> Loading entries...'
        }
    });

    // Filter functionality
    $('#applyFilters').click(function() {
        applyFilters();
    });

    $('#resetFilters').click(function() {
        resetFilters();
    });

    // Export functionality
    $('#exportData').click(function() {
        Swal.fire({
            icon: 'success',
            title: 'Export Started',
            text: 'Export feature will download filtered data as Excel/CSV',
            timer: 2000,
            showConfirmButton: false
        });
    });

    // Refresh table
    $('#refreshTable').click(function() {
        table.ajax.reload();
        Swal.fire({
            icon: 'info',
            title: 'Table Refreshed',
            timer: 1500,
            showConfirmButton: false
        });
    });

    // View entry details
    $(document).on('click', '.viewEntry', function() {
        var entryId = $(this).data('id');
        viewEntryDetails(entryId);
    });

    // Edit entry
    $(document).on('click', '.editEntry', function() {
        var entryId = $(this).data('id');
        Swal.fire({
            icon: 'info',
            title: 'Edit Entry',
            text: `Edit functionality for Entry ID: ${entryId}`,
            timer: 2000,
            showConfirmButton: false
        });
    });

    // Process entry
    $(document).on('click', '.processEntry', function() {
        var entryId = $(this).data('id');
        Swal.fire({
            icon: 'success',
            title: 'Processing Entry',
            text: `Processing Entry ID: ${entryId}`,
            timer: 2000,
            showConfirmButton: false
        });
    });

    // Delete entry
    $(document).on('click', '.deleteEntry', function() {
        var entryId = $(this).data('id');
        Swal.fire({
            title: 'Delete Entry?',
            text: 'Are you sure you want to delete this entry?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Entry Deleted',
                    text: `Entry ID: ${entryId} deleted`,
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    });

    // Functions
    function getDemoData() {
        return [
            {
                id: 1,
                entry_id: 'ENT-2025-001',
                type: 'booking',
                patient: 'John Doe',
                date: '2025-06-24',
                status: 'completed',
                priority: 'high',
                assigned_to: 'Dr. Smith',
                progress: 100
            },
            {
                id: 2,
                entry_id: 'ENT-2025-002',
                type: 'collection',
                patient: 'Jane Smith',
                date: '2025-06-24',
                status: 'processing',
                priority: 'medium',
                assigned_to: 'Tech. Johnson',
                progress: 65
            },
            {
                id: 3,
                entry_id: 'ENT-2025-003',
                type: 'result',
                patient: 'Mike Johnson',
                date: '2025-06-23',
                status: 'pending',
                priority: 'low',
                assigned_to: 'Dr. Wilson',
                progress: 25
            },
            {
                id: 4,
                entry_id: 'ENT-2025-004',
                type: 'booking',
                patient: 'Sarah Wilson',
                date: '2025-06-23',
                status: 'completed',
                priority: 'high',
                assigned_to: 'Dr. Brown',
                progress: 100
            },
            {
                id: 5,
                entry_id: 'ENT-2025-005',
                type: 'collection',
                patient: 'Robert Davis',
                date: '2025-06-22',
                status: 'processing',
                priority: 'medium',
                assigned_to: 'Tech. Miller',
                progress: 40
            }
        ];
    }

    function applyFilters() {
        var type = $('#filterType').val();
        var status = $('#filterStatus').val();
        var date = $('#filterDate').val();
        var patient = $('#filterPatient').val();
        
        // Apply filters to DataTable
        table.search('').draw(); // Reset search
        Swal.fire({
            icon: 'info',
            title: 'Filters Applied',
            text: 'Filters applied successfully',
            timer: 1500,
            showConfirmButton: false
        });
    }

    function resetFilters() {
        $('#filterType').val('').trigger('change');
        $('#filterStatus').val('').trigger('change');
        $('#filterDate').val('{{ date("Y-m-d") }}');
        $('#filterPatient').val('').trigger('change');
        
        table.search('').draw();
        Swal.fire({
            icon: 'info',
            title: 'Filters Reset',
            timer: 1500,
            showConfirmButton: false
        });
    }

    function viewEntryDetails(entryId) {
        var content = `
            <div class="row">
                <div class="col-md-6">
                    <h6><i class="fas fa-info-circle mr-2"></i>Entry Information</h6>
                    <table class="table table-sm">
                        <tr><td><strong>Entry ID:</strong></td><td>ENT-2025-00${entryId}</td></tr>
                        <tr><td><strong>Type:</strong></td><td>Test Booking</td></tr>
                        <tr><td><strong>Status:</strong></td><td><span class="badge badge-success">Completed</span></td></tr>
                        <tr><td><strong>Priority:</strong></td><td><span class="badge badge-warning">Medium</span></td></tr>
                        <tr><td><strong>Created Date:</strong></td><td>2025-06-24 10:30 AM</td></tr>
                        <tr><td><strong>Updated Date:</strong></td><td>2025-06-24 02:15 PM</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6><i class="fas fa-user mr-2"></i>Patient Information</h6>
                    <table class="table table-sm">
                        <tr><td><strong>Patient:</strong></td><td>John Doe</td></tr>
                        <tr><td><strong>Mobile:</strong></td><td>9876543210</td></tr>
                        <tr><td><strong>Age:</strong></td><td>35 Years</td></tr>
                        <tr><td><strong>Gender:</strong></td><td>Male</td></tr>
                        <tr><td><strong>Assigned To:</strong></td><td>Dr. Smith</td></tr>
                        <tr><td><strong>Progress:</strong></td><td>100%</td></tr>
                    </table>
                </div>
            </div>
            <hr>
            <h6><i class="fas fa-notes-medical mr-2"></i>Tests/Procedures</h6>
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr><th>Test Name</th><th>Status</th><th>Result</th><th>Reference Range</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>Hemoglobin</td><td><span class="badge badge-success">Completed</span></td><td>13.5 g/dL</td><td>12.0-15.5 g/dL</td></tr>
                        <tr><td>White Blood Cells</td><td><span class="badge badge-success">Completed</span></td><td>7.2 K/μL</td><td>4.0-11.0 K/μL</td></tr>
                        <tr><td>Platelets</td><td><span class="badge badge-success">Completed</span></td><td>285 K/μL</td><td>150-450 K/μL</td></tr>
                    </tbody>
                </table>
            </div>
        `;
        
        $('#entryDetailsContent').html(content);
        $('#viewEntryModal').modal('show');
    }

    // Welcome message
    Swal.fire({
        icon: 'success',
        title: 'System Ready',
        text: 'Entry List loaded successfully',
        timer: 2000,
        showConfirmButton: false
    });
});
</script>
@endpush
