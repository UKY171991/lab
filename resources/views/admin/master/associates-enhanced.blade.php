@extends('admin.layouts.app')

@section('title', 'Associates Management')
@section('page-title', 'Associates Management')
@section('breadcrumb', 'Master / Associates')

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.bootstrap4.min.css">

<style>
    .associates-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
    }
    
    .associates-header::before {
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
    
    .associates-header::after {
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
        background: var(--accent-color, #10b981);
        border-radius: 15px 15px 0 0;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: var(--accent-color, #10b981);
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

    .btn-add-associate {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        padding: 12px 25px;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-add-associate:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .bulk-actions {
        display: none;
        gap: 10px;
        align-items: center;
        background: #f8fafc;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        border: 2px dashed #cbd5e1;
    }

    .bulk-actions.show {
        display: flex;
    }

    .table-container {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .associates-table {
        margin-bottom: 0;
    }

    .associates-table thead th {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border: none;
        color: #374151;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.875rem;
        padding: 15px 12px;
    }

    .associates-table tbody td {
        padding: 15px 12px;
        vertical-align: middle;
        border-color: #f1f5f9;
    }

    .associates-table tbody tr {
        transition: all 0.2s ease;
    }

    .associates-table tbody tr:hover {
        background: #f8fafc;
        transform: translateX(2px);
    }

    .associate-name {
        font-weight: 600;
        color: #1f2937;
    }

    .associate-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e5e7eb;
    }

    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .phone-number {
        color: #10b981;
        font-weight: 500;
    }

    .email-address {
        color: #6b7280;
        font-size: 0.875rem;
    }

    .commission-badge {
        background: #dcfce7;
        color: #166534;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .type-badge {
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
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
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
        border-top: 4px solid #10b981;
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

    /* Avatar Upload */
    .avatar-upload {
        position: relative;
        display: inline-block;
    }

    .avatar-preview {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 3px solid #e5e7eb;
        object-fit: cover;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
        font-size: 2rem;
    }

    .avatar-upload-btn {
        position: absolute;
        bottom: 0;
        right: 0;
        background: #10b981;
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .associates-header {
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

        .bulk-actions {
            flex-direction: column;
            gap: 15px;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="associates-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0">
                    <i class="fas fa-handshake mr-3"></i>Associates Management
                </h1>
                <p class="mb-0 mt-2 opacity-75">Manage laboratory partners, agents, and referral sources</p>
            </div>
            <div class="col-md-4 text-right">
                <button class="btn btn-add-associate" data-toggle="modal" data-target="#associateModal" id="createNewAssociate">
                    <i class="fas fa-plus mr-2"></i>Add New Associate
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-cards">
        <div class="stats-card" style="--accent-color: #10b981;">
            <div class="stats-number">{{ \App\Models\Associate::count() }}</div>
            <div class="stats-label">Total Associates</div>
        </div>
        <div class="stats-card" style="--accent-color: #059669;">
            <div class="stats-number">{{ \App\Models\Associate::where('status', 1)->count() }}</div>
            <div class="stats-label">Active Associates</div>
        </div>
        <div class="stats-card" style="--accent-color: #dc2626;">
            <div class="stats-number">{{ \App\Models\Associate::where('status', 0)->count() }}</div>
            <div class="stats-label">Inactive Associates</div>
        </div>
        <div class="stats-card" style="--accent-color: #f59e0b;">
            <div class="stats-number">{{ \App\Models\Associate::where('created_at', '>=', now()->startOfMonth())->count() }}</div>
            <div class="stats-label">Added This Month</div>
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
        <div class="ml-auto">
            <span class="text-muted" id="selectedCount">0 selected</span>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="bulk-actions" id="bulkActions">
        <span class="font-weight-bold text-dark">Bulk Actions:</span>
        <button class="btn btn-success btn-sm" id="bulkActivate">
            <i class="fas fa-check mr-1"></i>Activate
        </button>
        <button class="btn btn-warning btn-sm" id="bulkDeactivate">
            <i class="fas fa-ban mr-1"></i>Deactivate
        </button>
        <button class="btn btn-danger btn-sm" id="bulkDelete">
            <i class="fas fa-trash mr-1"></i>Delete Selected
        </button>
    </div>

    <!-- Associates Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-striped associates-table" id="associatesTable">
                <thead>
                    <tr>
                        <th width="50px">
                            <input type="checkbox" id="selectAll" class="form-check-input">
                        </th>
                        <th width="50px">#</th>
                        <th width="60px">Avatar</th>
                        <th>Associate Name</th>
                        <th>Contact Info</th>
                        <th>Type</th>
                        <th>Commission</th>
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

<!-- Add/Edit Associate Modal -->
<div class="modal fade" id="associateModal" tabindex="-1" role="dialog" aria-labelledby="associateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="associateModalLabel">
                    <i class="fas fa-handshake mr-2"></i>Add New Associate
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="associateForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="associate_id" name="associate_id">
                    
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Avatar</label>
                                <div class="avatar-upload">
                                    <div class="avatar-preview" id="avatarPreview">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;">
                                    <button type="button" class="avatar-upload-btn" onclick="$('#avatar').click()">
                                        <i class="fas fa-camera"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="associate_name">Associate Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="associate_name" name="associate_name" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="organization">Organization/Institution</label>
                                        <input type="text" class="form-control" id="organization" name="organization">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_number">Contact Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="associate_type">Associate Type</label>
                                <select class="form-control" id="associate_type" name="associate_type">
                                    <option value="">Select Type</option>
                                    <option value="Doctor">Doctor</option>
                                    <option value="Hospital">Hospital</option>
                                    <option value="Clinic">Clinic</option>
                                    <option value="Agent">Agent</option>
                                    <option value="Institution">Institution</option>
                                    <option value="Other">Other</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="commission_rate">Commission Rate (%)</label>
                                <input type="number" class="form-control" id="commission_rate" name="commission_rate" step="0.01" min="0" max="100">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="state">State</label>
                                <input type="text" class="form-control" id="state" name="state">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pincode">Pin Code</label>
                                <input type="text" class="form-control" id="pincode" name="pincode">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specialization">Specialization</label>
                                <input type="text" class="form-control" id="specialization" name="specialization">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="registration_number">Registration Number</label>
                                <input type="text" class="form-control" id="registration_number" name="registration_number">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_active_referrer" name="is_active_referrer">
                                    <label class="custom-control-label" for="is_active_referrer">Active Referrer</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
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
                    <button type="submit" class="btn btn-primary" id="saveAssociate">
                        <i class="fas fa-save mr-2"></i>Save Associate
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Associate Modal -->
<div class="modal fade" id="viewAssociateModal" tabindex="-1" role="dialog" aria-labelledby="viewAssociateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewAssociateModalLabel">
                    <i class="fas fa-eye mr-2"></i>Associate Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody id="associateDetails">
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

    // Initialize DataTable
    var table = $('#associatesTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.associates.data') }}",
            error: function(xhr, error, thrown) {
                Swal.fire('Error', 'Error loading associates data', 'error');
            }
        },
        columns: [
            {
                data: 'select',
                name: 'select',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {
                data: 'avatar',
                name: 'avatar',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {data: 'associate_name', name: 'associate_name', className: 'associate-name'},
            {data: 'contact_info', name: 'contact_info', orderable: false},
            {data: 'type_display', name: 'associate_type'},
            {data: 'commission_display', name: 'commission_rate', orderable: false},
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
        order: [[3, 'asc']],
        pageLength: 25,
        language: {
            processing: '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"></div></div>',
            emptyTable: '<div class="text-center"><i class="fas fa-handshake fa-3x text-muted mb-3"></i><br>No associates found</div>'
        },
        drawCallback: function() {
            updateBulkActionsVisibility();
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
        $('#associateForm')[0].reset();
        $('#associate_id').val('');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').empty();
        $('#status').prop('checked', true);
        $('#avatarPreview').html('<i class="fas fa-user"></i>');
    }

    function updateBulkActionsVisibility() {
        var selectedCount = $('input[name="associate_select"]:checked').length;
        $('#selectedCount').text(selectedCount + ' selected');
        
        if (selectedCount > 0) {
            $('#bulkActions').addClass('show');
        } else {
            $('#bulkActions').removeClass('show');
        }
    }

    // Avatar preview
    $('#avatar').change(function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#avatarPreview').html(`<img src="${e.target.result}" class="avatar-preview" alt="Avatar">`);
            };
            reader.readAsDataURL(file);
        }
    });

    // Event Handlers
    $('#selectAll').change(function() {
        $('input[name="associate_select"]').prop('checked', this.checked);
        updateBulkActionsVisibility();
    });

    $(document).on('change', 'input[name="associate_select"]', function() {
        updateBulkActionsVisibility();
    });

    $('#createNewAssociate').click(function() {
        resetForm();
        $('#associateModalLabel').html('<i class="fas fa-plus mr-2"></i>Add New Associate');
        $('#associateModal').modal('show');
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

    // Edit associate
    $(document).on('click', '.editAssociate', function() {
        var id = $(this).data('id');
        showLoading();
        
        $.ajax({
            url: "{{ route('admin.associates.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                hideLoading();
                resetForm();
                
                $('#associate_id').val(data.id);
                $('#associate_name').val(data.associate_name);
                $('#organization').val(data.organization);
                $('#contact_number').val(data.contact_number);
                $('#email').val(data.email);
                $('#associate_type').val(data.associate_type);
                $('#commission_rate').val(data.commission_rate);
                $('#address').val(data.address);
                $('#city').val(data.city);
                $('#state').val(data.state);
                $('#pincode').val(data.pincode);
                $('#specialization').val(data.specialization);
                $('#registration_number').val(data.registration_number);
                $('#notes').val(data.notes);
                $('#is_active_referrer').prop('checked', data.is_active_referrer == 1);
                $('#status').prop('checked', data.status == 1);
                
                if (data.avatar) {
                    $('#avatarPreview').html(`<img src="${data.avatar}" class="avatar-preview" alt="Avatar">`);
                }
                
                $('#associateModalLabel').html('<i class="fas fa-edit mr-2"></i>Edit Associate');
                $('#associateModal').modal('show');
            },
            error: function() {
                hideLoading();
                Swal.fire('Error', 'Error loading associate data', 'error');
            }
        });
    });

    // View associate
    $(document).on('click', '.viewAssociate', function() {
        var id = $(this).data('id');
        showLoading();
        
        $.ajax({
            url: "{{ route('admin.associates.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                hideLoading();
                
                var detailsHtml = `
                    <tr><th width="200px">Associate Name</th><td><strong>${data.associate_name || 'N/A'}</strong></td></tr>
                    <tr><th>Organization</th><td>${data.organization || 'N/A'}</td></tr>
                    <tr><th>Contact Number</th><td><span class="phone-number">${data.contact_number || 'N/A'}</span></td></tr>
                    <tr><th>Email</th><td><span class="email-address">${data.email || 'N/A'}</span></td></tr>
                    <tr><th>Type</th><td><span class="type-badge">${data.associate_type || 'N/A'}</span></td></tr>
                    <tr><th>Commission Rate</th><td><span class="commission-badge">${data.commission_rate ? data.commission_rate + '%' : 'N/A'}</span></td></tr>
                    <tr><th>Address</th><td>${data.address || 'N/A'}</td></tr>
                    <tr><th>City</th><td>${data.city || 'N/A'}</td></tr>
                    <tr><th>State</th><td>${data.state || 'N/A'}</td></tr>
                    <tr><th>Pin Code</th><td>${data.pincode || 'N/A'}</td></tr>
                    <tr><th>Specialization</th><td>${data.specialization || 'N/A'}</td></tr>
                    <tr><th>Registration</th><td>${data.registration_number || 'N/A'}</td></tr>
                    <tr><th>Notes</th><td>${data.notes || 'N/A'}</td></tr>
                    <tr><th>Active Referrer</th><td>${data.is_active_referrer ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-secondary">No</span>'}</td></tr>
                    <tr><th>Status</th><td>${data.status ? '<span class="status-badge status-active">Active</span>' : '<span class="status-badge status-inactive">Inactive</span>'}</td></tr>
                    <tr><th>Created</th><td>${data.created_at_formatted || 'N/A'}</td></tr>
                `;
                
                $('#associateDetails').html(detailsHtml);
                $('#viewAssociateModal').modal('show');
            },
            error: function() {
                hideLoading();
                Swal.fire('Error', 'Error loading associate data', 'error');
            }
        });
    });

    // Save associate
    $('#associateForm').submit(function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var url = "{{ route('admin.associates.store') }}";

        showLoading();

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                hideLoading();
                $('#associateModal').modal('hide');
                table.ajax.reload();
                
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Associate saved successfully',
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

    // Delete associate
    $(document).on('click', '.deleteAssociate', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        
        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to delete the associate "${name}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                
                $.ajax({
                    url: "{{ route('admin.associates.destroy', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    success: function(response) {
                        hideLoading();
                        table.ajax.reload();
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message || 'Associate deleted successfully',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function() {
                        hideLoading();
                        Swal.fire('Error', 'Error deleting associate', 'error');
                    }
                });
            }
        });
    });

    // Bulk actions
    $('#bulkActivate').click(function() {
        performBulkAction('activate');
    });

    $('#bulkDeactivate').click(function() {
        performBulkAction('deactivate');
    });

    $('#bulkDelete').click(function() {
        var selectedIds = $('input[name="associate_select"]:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            Swal.fire('Warning', 'Please select associates to delete', 'warning');
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to delete ${selectedIds.length} selected associates?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (result.isConfirmed) {
                performBulkAction('delete');
            }
        });
    });

    function performBulkAction(action) {
        var selectedIds = $('input[name="associate_select"]:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            Swal.fire('Warning', 'Please select associates first', 'warning');
            return;
        }

        showLoading();

        $.ajax({
            url: "{{ route('admin.associates.store') }}", // This should be a bulk action route
            method: 'POST',
            data: {
                action: 'bulk_' + action,
                ids: selectedIds
            },
            success: function(response) {
                hideLoading();
                table.ajax.reload();
                $('#selectAll').prop('checked', false);
                updateBulkActionsVisibility();
                
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || `Associates ${action}d successfully`,
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function() {
                hideLoading();
                Swal.fire('Error', `Error performing bulk ${action}`, 'error');
            }
        });
    }
});
</script>
@endpush
