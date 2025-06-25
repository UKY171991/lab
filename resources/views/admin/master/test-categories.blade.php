@extends('admin.layouts.app')

@section('title', 'Test Categories Management')
@section('page-title', 'Test Categories Management')
@section('breadcrumb', 'Master / Test Categories')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">

<style>
    .categories-header {
        background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        color: white;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    
    .categories-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 100px;
        height: 200%;
        background: rgba(255,255,255,0.1);
        transform: rotate(15deg);
    }
    
    .categories-table-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        padding: 25px;
    }
    
    .table th {
        background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        color: white;
        border: none;
        padding: 15px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    
    .btn-add-category {
        background: linear-gradient(45deg, #3b82f6 0%, #1d4ed8 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 25px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-add-category:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        color: white;
    }
    
    .modal-header {
        background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
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
        border-color: #ec4899;
        box-shadow: 0 0 0 0.2rem rgba(236, 72, 153, 0.25);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="categories-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0">
                    <i class="fas fa-tags mr-3"></i>Test Categories Management
                </h1>
                <p class="mb-0 opacity-75">Organize tests into categories for better management</p>
            </div>
            <div class="col-md-4 text-right">
                <button class="btn btn-add-category" id="createNewCategory">
                    <i class="fas fa-plus mr-2"></i>Add New Category
                </button>
            </div>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="categories-table-container">
        <div class="table-responsive">
            <table class="table table-hover" id="categoriesTable">
                <thead>
                    <tr>
                        <th width="10%">Sr. No.</th>
                        <th width="30%">Category Name</th>
                        <th width="40%">Description</th>
                        <th width="10%">Status</th>
                        <th width="10%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded via Ajax -->
                </tbody>
            </table>
        </div>
    </div>
</div>
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-tags mr-2"></i>Test Category
                        </h3>
                        <button class="btn btn-light btn-sm" id="createNewCategory">
                            <i class="fas fa-plus mr-2"></i>Add Category
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">                        <table class="table table-bordered table-striped table-hover" id="categoriesTable">
                            <thead class="thead-light">
                                <tr>
                                    <th width="10%">Sr. No.</th>
                                    <th width="50%">Category Name</th>
                                    <th width="20%">Tests Count</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Actions</th>
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

<!-- Add/Edit Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">
                    <i class="fas fa-tags mr-2"></i>Add Test Category
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="categoryForm">
                <div class="modal-body">
                    <input type="hidden" id="categoryId" name="category_id">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Category Information</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="categoryName">Category Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="categoryName" name="category_name" required placeholder="Enter category name">
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter category description..."></textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="status" name="status" checked>
                                            <label class="custom-control-label" for="status">Active Status</label>
                                        </div>
                                        <small class="form-text text-muted">Toggle to activate or deactivate this category</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Category Modal -->
<div class="modal fade" id="viewCategoryModal" tabindex="-1" role="dialog" aria-labelledby="viewCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCategoryModalLabel">
                    <i class="fas fa-eye mr-2"></i>Category Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Category Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered view-table">
                                <tbody id="categoryDetails">
                                    <!-- Details will be loaded via Ajax -->
                                </tbody>
                            </table>
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

<script>
$(document).ready(function() {
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

    // Initialize DataTable
    var table = $('#categoriesTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.test-categories.data') }}",
            error: function(xhr, error, thrown) {
                toastr.error('Error loading categories data');
            }        },        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'category_name', name: 'category_name'},
            {data: 'tests_count', name: 'tests_count', orderable: false},
            {data: 'status', name: 'status', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'table-actions text-center'}
        ],
        order: [[1, 'asc']],
        pageLength: 25,
        language: {
            processing: '<i class="fas fa-spinner fa-spin fa-2x"></i><br>Loading...',
            emptyTable: 'No categories found. <a href="#" id="addFirstCategory" class="btn btn-primary btn-sm mt-2"><i class="fas fa-plus"></i> Create First Category</a>'
        }
    });

    // Add first category link handler
    $(document).on('click', '#addFirstCategory', function(e) {
        e.preventDefault();
        $('#createNewCategory').click();
    });    // Create new category (main button)
    $('#createNewCategory').click(function() {
        resetForm();
        $('#categoryModalLabel').html('<i class="fas fa-tags mr-2"></i>Add Test Category');
        $('#categoryModal').modal('show');
        toastr.info('Create a new test category');
    });    // Save category
    $('#categoryForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        
        // Show loading
        var saveBtn = $(this).find('button[type="submit"]');
        var originalText = '<i class="fas fa-save mr-1"></i>Save Category';
        saveBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Processing...');
        
        $.ajax({
            url: "{{ route('admin.test-categories.store') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Reset button first
                saveBtn.prop('disabled', false).html(originalText);
                
                // Close modal and refresh table
                $('#categoryModal').modal('hide');
                table.ajax.reload();
                toastr.success(response.success);
                
                // Reset form
                resetForm();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        var field = key.replace('_', '');
                        if (key === 'category_name') field = 'categoryName';
                        
                        $('#' + field).addClass('is-invalid');
                        $('#' + field).siblings('.invalid-feedback').text(value[0]);
                    });
                    toastr.error('Please correct the errors and try again');
                } else {
                    toastr.error('An error occurred while saving category');
                }
                
                // Reset button on error too
                saveBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Edit category
    $(document).on('click', '.editTestCategory', function() {
        var id = $(this).data('id');
        resetForm();
        
        $.ajax({
            url: "{{ route('admin.test-categories.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                $('#categoryId').val(data.id);
                $('#categoryName').val(data.category_name);
                $('#description').val(data.description);
                $('#status').prop('checked', data.status);
                
                $('#categoryModalLabel').html('<i class="fas fa-edit mr-2"></i>Edit Test Category');
                $('#categoryModal').modal('show');
                toastr.info('Edit category details');
            },
            error: function() {
                toastr.error('Error loading category data');
            }
        });
    });

    // View category
    $(document).on('click', '.viewTestCategory', function() {
        var id = $(this).data('id');
        
        $.ajax({
            url: "{{ route('admin.test-categories.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                var detailsHtml = `
                    <tr><th>Category Name</th><td>${data.category_name || 'N/A'}</td></tr>
                    <tr><th>Description</th><td>${data.description || 'N/A'}</td></tr>
                    <tr><th>Tests Count</th><td><span class="badge badge-info">${data.tests_count || 0} Tests</span></td></tr>
                    <tr><th>Status</th><td>${data.status ? '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Active</span>' : '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Inactive</span>'}</td></tr>
                    <tr><th>Created At</th><td>${new Date(data.created_at).toLocaleString()}</td></tr>
                    <tr><th>Updated At</th><td>${new Date(data.updated_at).toLocaleString()}</td></tr>
                `;
                
                $('#categoryDetails').html(detailsHtml);
                $('#viewCategoryModal').modal('show');
                toastr.info('Viewing category details');
            },
            error: function() {
                toastr.error('Error loading category data');
            }
        });
    });

    // Delete category
    $(document).on('click', '.deleteTestCategory', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        
        if (confirm('Are you sure you want to delete the category "' + name + '"?\n\nNote: Categories with assigned tests cannot be deleted.')) {
            $.ajax({
                url: "{{ route('admin.test-categories.destroy', ':id') }}".replace(':id', id),
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    table.ajax.reload();
                    toastr.success(response.success);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        toastr.error(xhr.responseJSON.error);
                    } else {
                        toastr.error('Error deleting category');
                    }
                }
            });        }
    });    // Modal event handlers to ensure button state is reset
    $('#categoryModal').on('show.bs.modal', function () {
        // Reset button state when modal is shown
        var saveBtn = $(this).find('button[type="submit"]');
        var originalText = '<i class="fas fa-save mr-1"></i>Save Category';
        saveBtn.prop('disabled', false).html(originalText);
    });
    
    $('#categoryModal').on('shown.bs.modal', function () {
        // Focus on first input when modal is fully shown
        $('#categoryName').focus();
    });
    
    $('#categoryModal').on('hidden.bs.modal', function () {
        // Reset everything when modal is hidden
        resetForm();
    });

    // Reset form function
    function resetForm() {
        $('#categoryForm')[0].reset();
        $('#categoryId').val('');
        $('#status').prop('checked', true);
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        
        // Reset button state
        var saveBtn = $('#categoryForm').find('button[type="submit"]');
        var originalText = '<i class="fas fa-save mr-1"></i>Save Category';
        saveBtn.prop('disabled', false).html(originalText);
    }
});
</script>
@endpush
