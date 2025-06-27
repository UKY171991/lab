@extends('admin.layouts.app')

@section('title', 'Test Categories')
@section('page-title', 'Test Categories')
@section('breadcrumb', 'Master / Test Categories')

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.bootstrap4.min.css">

<style>
    .test-categories-header {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(139, 92, 246, 0.3);
    }
    
    .test-categories-header::before {
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
    
    .test-categories-header::after {
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
        background: var(--accent-color, #8b5cf6);
        border-radius: 15px 15px 0 0;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: var(--accent-color, #8b5cf6);
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
    }

    .btn-add-category {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        border: none;
        padding: 12px 25px;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
    }

    .btn-add-category:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
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

    .category-table {
        margin-bottom: 0;
    }

    .category-table thead th {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border: none;
        color: #374151;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.875rem;
        padding: 15px 12px;
    }

    .category-table tbody td {
        padding: 15px 12px;
        vertical-align: middle;
        border-color: #f1f5f9;
    }

    .category-table tbody tr {
        transition: all 0.2s ease;
    }

    .category-table tbody tr:hover {
        background: #f8fafc;
        transform: translateX(2px);
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
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
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
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
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
        border-top: 4px solid #8b5cf6;
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
        .test-categories-header {
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
    <div class="test-categories-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0">
                    <i class="fas fa-layer-group mr-3"></i>Test Categories Management
                </h1>
                <p class="mb-0 mt-2 opacity-75">Organize and manage laboratory test categories</p>
            </div>
            <div class="col-md-4 text-right">
                <button class="btn btn-add-category" data-toggle="modal" data-target="#categoryModal" id="createNewCategory">
                    <i class="fas fa-plus mr-2"></i>Add New Category
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-cards">
        <div class="stats-card" style="--accent-color: #8b5cf6;">
            <div class="stats-number">{{ \App\Models\TestCategory::count() }}</div>
            <div class="stats-label">Total Categories</div>
        </div>
        <div class="stats-card" style="--accent-color: #059669;">
            <div class="stats-number">{{ \App\Models\TestCategory::where('status', 1)->count() }}</div>
            <div class="stats-label">Active Categories</div>
        </div>
        <div class="stats-card" style="--accent-color: #dc2626;">
            <div class="stats-number">{{ \App\Models\TestCategory::where('status', 0)->count() }}</div>
            <div class="stats-label">Inactive Categories</div>
        </div>
        <div class="stats-card" style="--accent-color: #f59e0b;">
            <div class="stats-number">{{ \App\Models\TestCategory::where('created_at', '>=', now()->startOfMonth())->count() }}</div>
            <div class="stats-label">Added This Month</div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <button class="btn btn-outline-secondary" id="refreshTable">
            <i class="fas fa-sync-alt mr-2"></i>Refresh
        </button>
        <button class="btn btn-outline-info" id="exportData">
            <i class="fas fa-download mr-2"></i>Export
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

    <!-- Categories Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-striped category-table" id="categoriesTable">
                <thead>
                    <tr>
                        <th width="50px">
                            <input type="checkbox" id="selectAll" class="form-check-input">
                        </th>
                        <th width="50px">#</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th width="100px">Status</th>
                        <th width="120px">Created</th>
                        <th width="150px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">
                    <i class="fas fa-layer-group mr-2"></i>Add New Category
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="categoryForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="category_id" name="category_id">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_name">Category Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="category_name" name="category_name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_code">Category Code</label>
                                <input type="text" class="form-control" id="category_code" name="category_code">
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
                                <label for="sort_order">Sort Order</label>
                                <input type="number" class="form-control" id="sort_order" name="sort_order" min="0" value="0">
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
                    <button type="submit" class="btn btn-primary" id="saveCategory">
                        <i class="fas fa-save mr-2"></i>Save Category
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
    var table = $('#categoriesTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.test-categories.data') }}",
            error: function(xhr, error, thrown) {
                Swal.fire('Error', 'Error loading categories data', 'error');
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
            {data: 'category_name', name: 'category_name'},
            {data: 'description', name: 'description'},
            {data: 'status', name: 'status', orderable: false},
            {data: 'created_at_formatted', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                className: 'btn-primary',
                text: '<i class="fas fa-file-excel"></i> Export Excel'
            },
            {
                extend: 'pdf',
                className: 'btn-danger',
                text: '<i class="fas fa-file-pdf"></i> Export PDF'
            }
        ],
        order: [[2, 'asc']],
        pageLength: 25,
        language: {
            processing: '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"></div></div>',
            emptyTable: '<div class="text-center"><i class="fas fa-layer-group fa-3x text-muted mb-3"></i><br>No test categories found</div>'
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
        $('#categoryForm')[0].reset();
        $('#category_id').val('');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').empty();
        $('#status').prop('checked', true);
    }

    function updateBulkActionsVisibility() {
        var selectedCount = $('input[name="category_select"]:checked').length;
        $('#selectedCount').text(selectedCount + ' selected');
        
        if (selectedCount > 0) {
            $('#bulkActions').addClass('show');
        } else {
            $('#bulkActions').removeClass('show');
        }
    }

    // Event Handlers
    $('#selectAll').change(function() {
        $('input[name="category_select"]').prop('checked', this.checked);
        updateBulkActionsVisibility();
    });

    $(document).on('change', 'input[name="category_select"]', function() {
        updateBulkActionsVisibility();
    });

    $('#createNewCategory').click(function() {
        resetForm();
        $('#categoryModalLabel').html('<i class="fas fa-plus mr-2"></i>Add New Category');
        $('#categoryModal').modal('show');
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

    // Edit category
    $(document).on('click', '.editCategory', function() {
        var id = $(this).data('id');
        showLoading();
        
        $.ajax({
            url: "{{ route('admin.test-categories.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                hideLoading();
                resetForm();
                
                $('#category_id').val(data.id);
                $('#category_name').val(data.category_name);
                $('#category_code').val(data.category_code);
                $('#description').val(data.description);
                $('#sort_order').val(data.sort_order || 0);
                $('#status').prop('checked', data.status == 1);
                
                $('#categoryModalLabel').html('<i class="fas fa-edit mr-2"></i>Edit Category');
                $('#categoryModal').modal('show');
            },
            error: function() {
                hideLoading();
                Swal.fire('Error', 'Error loading category data', 'error');
            }
        });
    });

    // Save category
    $('#categoryForm').submit(function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var url = $('#category_id').val() ? 
            "{{ route('admin.test-categories.store') }}" : 
            "{{ route('admin.test-categories.store') }}";

        showLoading();

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                hideLoading();
                $('#categoryModal').modal('hide');
                table.ajax.reload();
                
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Category saved successfully',
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

    // Delete category
    $(document).on('click', '.deleteCategory', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        
        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to delete the category "${name}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                
                $.ajax({
                    url: "{{ route('admin.test-categories.destroy', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    success: function(response) {
                        hideLoading();
                        table.ajax.reload();
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message || 'Category deleted successfully',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function() {
                        hideLoading();
                        Swal.fire('Error', 'Error deleting category', 'error');
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
        var selectedIds = $('input[name="category_select"]:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            Swal.fire('Warning', 'Please select categories to delete', 'warning');
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to delete ${selectedIds.length} selected categories?`,
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
        var selectedIds = $('input[name="category_select"]:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            Swal.fire('Warning', 'Please select categories first', 'warning');
            return;
        }

        showLoading();

        $.ajax({
            url: "{{ route('admin.test-categories.store') }}", // This should be a bulk action route
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
                    text: response.message || `Categories ${action}d successfully`,
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
