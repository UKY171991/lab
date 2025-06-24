@extends('admin.layouts.app')

@section('title', 'Medical Reports')
@section('page-title', 'Medical Reports')
@section('breadcrumb', 'Reports')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
<style>
    .reports-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
    }
    
    .stats-card {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    
    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .stats-label {
        color: #64748b;
        font-weight: 600;
        margin-top: 10px;
    }
    
    .reports-table-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .table th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 15px;
        font-weight: 600;
    }
    
    .btn-create-report {
        background: linear-gradient(45deg, #10b981 0%, #34d399 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-create-report:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="reports-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0"><i class="fas fa-file-medical mr-3"></i>Medical Reports Management</h1>
                <p class="mb-0 opacity-75">Manage patient test reports and results</p>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route('admin.reports.create') }}" class="btn btn-create-report">
                    <i class="fas fa-plus mr-2"></i>Create New Report
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="stats-number">{{ \App\Models\Report::count() }}</div>
                <div class="stats-label">Total Reports</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="stats-number">{{ \App\Models\Report::where('report_status', 'pending')->count() }}</div>
                <div class="stats-label">Pending Reports</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="stats-number">{{ \App\Models\Report::where('report_status', 'completed')->count() }}</div>
                <div class="stats-label">Completed Reports</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="stats-number">{{ \App\Models\Report::whereDate('created_at', today())->count() }}</div>
                <div class="stats-label">Today's Reports</div>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="card reports-table-container">
        <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <h5 class="mb-0"><i class="fas fa-table mr-2"></i>Reports List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="reportsTable">
                    <thead>
                        <tr>
                            <th>Report #</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Report Date</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded via DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable with demo data
    const table = $('#reportsTable').DataTable({
        processing: true,
        serverSide: false, // Using static data for demo
        data: getDemoReportsData(),
        columns: [
            {data: 'report_number', name: 'report_number'},
            {data: 'patient_name', name: 'patient_name'},
            {data: 'doctor_name', name: 'doctor_name'},
            {
                data: 'report_date', 
                name: 'report_date',
                render: function(data) {
                    return new Date(data).toLocaleDateString();
                }
            },
            {
                data: 'status', 
                name: 'status', 
                orderable: false,
                render: function(data) {
                    const colors = {
                        'completed': 'success',
                        'pending': 'warning',
                        'processing': 'info'
                    };
                    return '<span class="badge badge-' + (colors[data] || 'secondary') + '">' + data.charAt(0).toUpperCase() + data.slice(1) + '</span>';
                }
            },
            {
                data: 'payment_status', 
                name: 'payment_status', 
                orderable: false,
                render: function(data) {
                    const colors = {
                        'paid': 'success',
                        'pending': 'warning',
                        'partial': 'info'
                    };
                    return '<span class="badge badge-' + (colors[data] || 'secondary') + '">' + data.charAt(0).toUpperCase() + data.slice(1) + '</span>';
                }
            },
            {
                data: 'final_amount', 
                name: 'final_amount',
                render: function(data) {
                    return '$' + parseFloat(data).toFixed(2);
                }
            },
            {
                data: null, 
                name: 'action', 
                orderable: false, 
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <div class="btn-group" role="group">
                            <a href="#" class="btn btn-info btn-sm" title="View Report">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="#" class="btn btn-success btn-sm" title="Print Report">
                                <i class="fas fa-print"></i>
                            </a>
                            <button class="btn btn-danger btn-sm deleteReport" data-id="${row.id}" title="Delete Report">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        order: [[3, 'desc']],
        pageLength: 25,
        responsive: true,
        language: {
            processing: '<i class="fas fa-spinner fa-spin"></i> Loading reports...'
        }
    });

    // Demo data function
    function getDemoReportsData() {
        return [
            {
                id: 1,
                report_number: 'RPT-2025-001',
                patient_name: 'John Doe',
                doctor_name: 'Dr. Smith',
                report_date: '2025-06-24',
                status: 'completed',
                payment_status: 'paid',
                final_amount: 150.00
            },
            {
                id: 2,
                report_number: 'RPT-2025-002',
                patient_name: 'Jane Smith', 
                doctor_name: 'Dr. Johnson',
                report_date: '2025-06-23',
                status: 'pending',
                payment_status: 'pending',
                final_amount: 200.00
            },
            {
                id: 3,
                report_number: 'RPT-2025-003',
                patient_name: 'Mike Johnson',
                doctor_name: 'Dr. Brown',
                report_date: '2025-06-22',
                status: 'processing',
                payment_status: 'partial',
                final_amount: 175.00
            }
        ];
    }

    // Delete report functionality
    $(document).on('click', '.deleteReport', function() {
        const reportId = $(this).data('id');
        
        Swal.fire({
            title: 'Delete Report',
            text: 'Are you sure you want to delete this report? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/reports/' + reportId,
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                timer: 3000,
                                timerProgressBar: true,
                                showConfirmButton: false,
                                toast: true,
                                position: 'top-end'
                            });
                            table.ajax.reload();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to delete report.',
                            timer: 3000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });
                    }
                });
            }
        });
    });

    // Refresh table every 30 seconds
    setInterval(function() {
        table.ajax.reload(null, false);
    }, 30000);
});
</script>
@endpush
@endsection
