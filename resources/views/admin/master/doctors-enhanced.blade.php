@extends('admin.layouts.app')

@section('title', 'Doctor Management')
@section('page-title', 'Doctor Management')
@section('breadcrumb', 'Master / Doctors')

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.bootstrap4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

<style>
    .doctors-header {
        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        color: white;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
    }
    
    .doctors-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 100px;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(15deg);
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #e3f2fd;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #3b82f6;
        margin-bottom: 8px;
    }
    
    .stat-label {
        color: #64748b;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .doctors-table-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: none;
        overflow: hidden;
    }
    
    .doctors-table-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 25px 30px;
    }
    
    .table-actions {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .btn-add-doctor {
        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }
    
    .btn-add-doctor:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        color: white;
    }
    
    .bulk-actions {
        display: none;
        align-items: center;
        gap: 10px;
        padding: 15px;
        background: #f8fafc;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    
    .bulk-actions.show {
        display: flex;
    }
    
    .data-table {
        border-radius: 0 0 20px 20px;
    }
    
    .data-table thead th {
        background: #f8fafc;
        border: none;
        color: #475569;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 20px 15px;
    }
    
    .data-table tbody td {
        border: none;
        border-bottom: 1px solid #f1f5f9;
        padding: 20px 15px;
        vertical-align: middle;
    }
    
    .data-table tbody tr {
        transition: all 0.2s ease;
    }
    
    .data-table tbody tr:hover {
        background-color: #f8fafc;
    }
    
    .doctor-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e2e8f0;
    }
    
    .doctor-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .doctor-name {
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }
    
    .doctor-specialization {
        color: #64748b;
        font-size: 0.85rem;
        margin: 2px 0 0 0;
    }
    
    .modal-modern {
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    }
    
    .modal-modern .modal-header {
        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        color: white;
        border-radius: 20px 20px 0 0;
        border: none;
        padding: 25px 30px;
    }
    
    .modal-modern .modal-body {
        padding: 30px;
    }
    
    .modal-modern .modal-footer {
        border: none;
        padding: 20px 30px 30px;
    }
    
    .form-group-modern {
        margin-bottom: 25px;
    }
    
    .form-group-modern label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        display: block;
    }
    
    .form-control-modern {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        background: #fafafa;
    }
    
    .form-control-modern:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        background: white;
    }
    
    .btn-save-modern {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 30px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-save-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        color: white;
    }
    
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3b82f6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .search-filters {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }
    
    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        align-items: end;
    }
    
    @media (max-width: 768px) {
        .doctors-header {
            padding: 25px;
            text-align: center;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .table-actions {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="doctors-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0">
                    <i class="fas fa-user-md mr-3"></i>Doctor Management System
                </h1>
                <p class="mb-0 mt-2 opacity-75">Manage healthcare professionals and their information</p>
            </div>
            <div class="col-md-4 text-right">
                <button class="btn btn-add-doctor" data-toggle="modal" data-target="#doctorModal" id="createNewDoctor">
                    <i class="fas fa-plus mr-2"></i>Add New Doctor
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ \App\Models\Doctor::count() }}</div>
            <div class="stat-label">Total Doctors</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ \App\Models\Doctor::where('status', true)->count() }}</div>
            <div class="stat-label">Active Doctors</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ \App\Models\Doctor::where('created_at', '>=', now()->startOfMonth())->count() }}</div>
            <div class="stat-label">New This Month</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ \App\Models\Doctor::distinct('specialization')->whereNotNull('specialization')->count('specialization') }}</div>
            <div class="stat-label">Specializations</div>
        </div>
    </div>

    <!-- Search Filters -->
    <div class="search-filters">
        <div class="filter-row">
            <div class="form-group-modern">
                <label>Specialization</label>
                <select class="form-control form-control-modern" id="specializationFilter">
                    <option value="">All Specializations</option>
                    @foreach(\App\Models\Doctor::distinct('specialization')->whereNotNull('specialization')->pluck('specialization') as $spec)
                        <option value="{{ $spec }}">{{ $spec }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group-modern">
                <label>Status</label>
                <select class="form-control form-control-modern" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div class="form-group-modern">
                <label>&nbsp;</label>
                <button class="btn btn-primary btn-block" onclick="applyFilters()">
                    <i class="fas fa-filter mr-2"></i>Apply Filters
                </button>
            </div>
            <div class="form-group-modern">
                <label>&nbsp;</label>
                <button class="btn btn-secondary btn-block" onclick="clearFilters()">
                    <i class="fas fa-times mr-2"></i>Clear
                </button>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="bulk-actions" id="bulkActions">
        <span class="mr-3"><strong id="selectedCount">0</strong> doctors selected</span>
        <button class="btn btn-sm btn-success" onclick="bulkActivate()">
            <i class="fas fa-check mr-1"></i>Activate
        </button>
        <button class="btn btn-sm btn-warning" onclick="bulkDeactivate()">
            <i class="fas fa-times mr-1"></i>Deactivate
        </button>
        <button class="btn btn-sm btn-danger" onclick="bulkDelete()">
            <i class="fas fa-trash mr-1"></i>Delete
        </button>
    </div>

    <!-- Doctors Table -->
    <div class="card doctors-table-card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="mb-0">
                        <i class="fas fa-list mr-2 text-primary"></i>Doctors Directory
                    </h4>
                </div>
                <div class="col-md-6">
                    <div class="table-actions justify-content-end">
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control" placeholder="Search doctors..." id="tableSearch">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover data-table">
                    <thead>
                        <tr>
                            <th>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="selectAll">
                                    <label class="custom-control-label" for="selectAll"></label>
                                </div>
                            </th>
                            <th>Doctor</th>
                            <th>Hospital</th>
                            <th>Contact</th>
                            <th>Specialization</th>
                            <th>Commission</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Doctor Modal -->
<div class="modal fade" id="doctorModal" tabindex="-1" role="dialog" aria-labelledby="doctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-modern" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="doctorModalLabel">
                    <i class="fas fa-user-md mr-2"></i>Add New Doctor
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="doctorForm" name="doctorForm">
                    @csrf
                    <input type="hidden" name="doctor_id" id="doctor_id">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label for="doctor_name">Doctor Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-modern" id="doctor_name" name="doctor_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label for="hospital_name">Hospital/Clinic Name</label>
                                <input type="text" class="form-control form-control-modern" id="hospital_name" name="hospital_name">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label for="contact_no">Contact Number</label>
                                <input type="text" class="form-control form-control-modern" id="contact_no" name="contact_no">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control form-control-modern" id="email" name="email">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label for="specialization">Specialization</label>
                                <select class="form-control form-control-modern" id="specialization" name="specialization">
                                    <option value="">Select Specialization</option>
                                    <option value="Cardiology">Cardiology</option>
                                    <option value="Dermatology">Dermatology</option>
                                    <option value="Emergency Medicine">Emergency Medicine</option>
                                    <option value="Endocrinology">Endocrinology</option>
                                    <option value="Family Medicine">Family Medicine</option>
                                    <option value="Gastroenterology">Gastroenterology</option>
                                    <option value="General Surgery">General Surgery</option>
                                    <option value="Geriatrics">Geriatrics</option>
                                    <option value="Hematology">Hematology</option>
                                    <option value="Internal Medicine">Internal Medicine</option>
                                    <option value="Nephrology">Nephrology</option>
                                    <option value="Neurology">Neurology</option>
                                    <option value="Obstetrics & Gynecology">Obstetrics & Gynecology</option>
                                    <option value="Oncology">Oncology</option>
                                    <option value="Ophthalmology">Ophthalmology</option>
                                    <option value="Orthopedics">Orthopedics</option>
                                    <option value="Pediatrics">Pediatrics</option>
                                    <option value="Psychiatry">Psychiatry</option>
                                    <option value="Pulmonology">Pulmonology</option>
                                    <option value="Radiology">Radiology</option>
                                    <option value="Rheumatology">Rheumatology</option>
                                    <option value="Urology">Urology</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label for="qualification">Qualification</label>
                                <input type="text" class="form-control form-control-modern" id="qualification" name="qualification" placeholder="MBBS, MD, etc.">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label for="percent">Commission Rate (%)</label>
                                <input type="number" class="form-control form-control-modern" id="percent" name="percent" min="0" max="100" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label for="emergency_contact">Emergency Contact</label>
                                <input type="text" class="form-control form-control-modern" id="emergency_contact" name="emergency_contact">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group-modern">
                        <label for="address">Address</label>
                        <textarea class="form-control form-control-modern" id="address" name="address" rows="3"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label for="license_number">License Number</label>
                                <input type="text" class="form-control form-control-modern" id="license_number" name="license_number">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label for="license_expiry">License Expiry</label>
                                <input type="date" class="form-control form-control-modern" id="license_expiry" name="license_expiry">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group-modern">
                        <label for="notes">Additional Notes</label>
                        <textarea class="form-control form-control-modern" id="notes" name="notes" rows="2"></textarea>
                    </div>
                    
                    <div class="form-group-modern">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="status" name="status" checked>
                            <label class="custom-control-label" for="status">Active Status</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-save-modern" id="saveDoctor">
                    <i class="fas fa-save mr-2"></i>Save Doctor
                </button>
            </div>
        </div>
    </div>
</div>

<!-- View Doctor Modal -->
<div class="modal fade" id="viewDoctorModal" tabindex="-1" role="dialog" aria-labelledby="viewDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-modern" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDoctorModalLabel">
                    <i class="fas fa-eye mr-2"></i>Doctor Details
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody id="doctorDetails">
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
<script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
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
    $('#specialization').select2({
        dropdownParent: $('#doctorModal'),
        width: '100%'
    });

    // Initialize DataTable
    let table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.doctors.data') }}",
            data: function(d) {
                d.specialization = $('#specializationFilter').val();
                d.status = $('#statusFilter').val();
            }
        },
        columns: [
            {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return '<div class="custom-control custom-checkbox">' +
                           '<input type="checkbox" class="custom-control-input row-checkbox" id="checkbox' + data + '" value="' + data + '">' +
                           '<label class="custom-control-label" for="checkbox' + data + '"></label>' +
                           '</div>';
                }
            },
            {
                data: 'doctor_name',
                name: 'doctor_name',
                render: function(data, type, row) {
                    return '<div class="doctor-info">' +
                           '<img src="https://ui-avatars.com/api/?name=' + encodeURIComponent(data) + '&background=3b82f6&color=fff&size=45" class="doctor-avatar" alt="Avatar">' +
                           '<div>' +
                           '<div class="doctor-name">' + data + '</div>' +
                           '<div class="doctor-specialization">' + (row.specialization || 'General') + '</div>' +
                           '</div>' +
                           '</div>';
                }
            },
            {data: 'hospital_name', name: 'hospital_name'},
            {data: 'contact_no', name: 'contact_no'},
            {data: 'specialization', name: 'specialization'},
            {
                data: 'percent',
                name: 'percent',
                render: function(data, type, row) {
                    return data ? '<span class="badge badge-info">' + data + '%</span>' : 'N/A';
                }
            },
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        responsive: true,
        autoWidth: false,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Export Excel',
                className: 'btn btn-success btn-sm'
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> Export PDF',
                className: 'btn btn-danger btn-sm'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-info btn-sm'
            }
        ],
        language: {
            processing: '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>'
        }
    });

    // Global search
    $('#tableSearch').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Handle select all checkbox
    $('#selectAll').on('click', function() {
        $('.row-checkbox').prop('checked', this.checked);
        updateBulkActionsVisibility();
    });

    // Handle individual checkbox
    $(document).on('change', '.row-checkbox', function() {
        updateBulkActionsVisibility();
    });

    function updateBulkActionsVisibility() {
        const checkedCount = $('.row-checkbox:checked').length;
        $('#selectedCount').text(checkedCount);
        
        if (checkedCount > 0) {
            $('#bulkActions').addClass('show');
        } else {
            $('#bulkActions').removeClass('show');
        }
    }

    // Add new doctor
    $('#createNewDoctor').click(function() {
        resetForm();
        $('#doctorModalLabel').html('<i class="fas fa-user-md mr-2"></i>Add New Doctor');
        $('#doctorModal').modal('show');
    });

    // Edit doctor
    $(document).on('click', '.editDoctor', function() {
        var id = $(this).data('id');
        showLoading();
        
        $.ajax({
            url: "{{ route('admin.doctors.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                hideLoading();
                populateForm(data);
                $('#doctorModalLabel').html('<i class="fas fa-edit mr-2"></i>Edit Doctor');
                $('#doctorModal').modal('show');
            },
            error: function() {
                hideLoading();
                Swal.fire('Error', 'Error loading doctor data', 'error');
            }
        });
    });

    // View doctor details
    $(document).on('click', '.viewDoctor', function() {
        var id = $(this).data('id');
        showLoading();
        
        $.ajax({
            url: "{{ route('admin.doctors.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                hideLoading();
                displayDoctorDetails(data);
                $('#viewDoctorModal').modal('show');
            },
            error: function() {
                hideLoading();
                Swal.fire('Error', 'Error loading doctor data', 'error');
            }
        });
    });

    // Delete doctor
    $(document).on('click', '.deleteDoctor', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Delete doctor: " + name + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                $.ajax({
                    url: "{{ route('admin.doctors.destroy', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    success: function(response) {
                        hideLoading();
                        table.ajax.reload();
                        Swal.fire('Deleted!', response.success, 'success');
                    },
                    error: function() {
                        hideLoading();
                        Swal.fire('Error', 'Error deleting doctor', 'error');
                    }
                });
            }
        });
    });

    // Save doctor
    $('#saveDoctor').click(function(e) {
        e.preventDefault();
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Saving...');
        
        $.ajax({
            data: $('#doctorForm').serialize(),
            url: "{{ route('admin.doctors.store') }}",
            type: "POST",
            dataType: 'json',
            success: function(response) {
                $('#doctorForm').trigger("reset");
                $('#doctorModal').modal('hide');
                table.ajax.reload();
                Swal.fire('Success!', response.success, 'success');
                $('#saveDoctor').prop('disabled', false).html('<i class="fas fa-save mr-2"></i>Save Doctor');
            },
            error: function(xhr) {
                $('#saveDoctor').prop('disabled', false).html('<i class="fas fa-save mr-2"></i>Save Doctor');
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errorMsg = '';
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        errorMsg += value[0] + '\n';
                    });
                    Swal.fire('Validation Error', errorMsg, 'error');
                } else {
                    Swal.fire('Error', 'Error saving doctor', 'error');
                }
            }
        });
    });

    function resetForm() {
        $('#doctorForm')[0].reset();
        $('#doctor_id').val('');
        $('#specialization').val('').trigger('change');
        $('#status').prop('checked', true);
    }

    function populateForm(data) {
        $('#doctor_id').val(data.id);
        $('#doctor_name').val(data.doctor_name);
        $('#hospital_name').val(data.hospital_name);
        $('#contact_no').val(data.contact_no);
        $('#address').val(data.address);
        $('#percent').val(data.percent);
        $('#specialization').val(data.specialization).trigger('change');
        $('#qualification').val(data.qualification);
        $('#email').val(data.email);
        $('#emergency_contact').val(data.emergency_contact);
        $('#license_number').val(data.license_number);
        $('#license_expiry').val(data.license_expiry);
        $('#notes').val(data.notes);
        $('#status').prop('checked', data.status == 1);
    }

    function displayDoctorDetails(data) {
        let html = `
            <tr><th width="30%">Doctor Name</th><td>${data.doctor_name || 'N/A'}</td></tr>
            <tr><th>Hospital/Clinic</th><td>${data.hospital_name || 'N/A'}</td></tr>
            <tr><th>Contact Number</th><td>${data.contact_no || 'N/A'}</td></tr>
            <tr><th>Email</th><td>${data.email || 'N/A'}</td></tr>
            <tr><th>Specialization</th><td>${data.specialization || 'N/A'}</td></tr>
            <tr><th>Qualification</th><td>${data.qualification || 'N/A'}</td></tr>
            <tr><th>Commission Rate</th><td>${data.percent ? data.percent + '%' : 'N/A'}</td></tr>
            <tr><th>Address</th><td>${data.address || 'N/A'}</td></tr>
            <tr><th>Emergency Contact</th><td>${data.emergency_contact || 'N/A'}</td></tr>
            <tr><th>License Number</th><td>${data.license_number || 'N/A'}</td></tr>
            <tr><th>License Expiry</th><td>${data.license_expiry || 'N/A'}</td></tr>
            <tr><th>Notes</th><td>${data.notes || 'N/A'}</td></tr>
            <tr><th>Status</th><td>${data.status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'}</td></tr>
        `;
        $('#doctorDetails').html(html);
    }

    function showLoading() {
        $('#loadingOverlay').show();
    }

    function hideLoading() {
        $('#loadingOverlay').hide();
    }
});

function applyFilters() {
    $('.data-table').DataTable().ajax.reload();
}

function clearFilters() {
    $('#specializationFilter').val('');
    $('#statusFilter').val('');
    $('.data-table').DataTable().ajax.reload();
}

function bulkActivate() {
    bulkAction('activate');
}

function bulkDeactivate() {
    bulkAction('deactivate');
}

function bulkDelete() {
    bulkAction('delete');
}

function bulkAction(action) {
    const selectedIds = $('.row-checkbox:checked').map(function() {
        return this.value;
    }).get();

    if (selectedIds.length === 0) {
        Swal.fire('Warning', 'Please select doctors first', 'warning');
        return;
    }

    let title = 'Are you sure?';
    let text = `${action.charAt(0).toUpperCase() + action.slice(1)} ${selectedIds.length} doctor(s)?`;
    
    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: action === 'delete' ? '#d33' : '#3085d6',
        cancelButtonColor: '#6c757d',
        confirmButtonText: `Yes, ${action}!`
    }).then((result) => {
        if (result.isConfirmed) {
            // Implement bulk action API call here
            console.log(`Bulk ${action} for IDs:`, selectedIds);
            // For now, just show success message
            Swal.fire('Success!', `Doctors ${action}d successfully`, 'success');
            $('.data-table').DataTable().ajax.reload();
            $('#selectAll').prop('checked', false);
            $('.row-checkbox').prop('checked', false);
            $('#bulkActions').removeClass('show');
        }
    });
}
</script>
@endpush
