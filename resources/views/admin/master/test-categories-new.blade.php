@extends('admin.layouts.app')

@section('title', 'Test Category')
@section('page-title', 'Test Category')
@section('breadcrumb', 'Master / Test Categories')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
.content-wrapper {
    background-color: #f4f6f9;
}
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
.card-primary {
    border-top: 3px solid #007bff;
}
.card-header {
    background: #007bff;
    color: white;
    border-bottom: none;
    font-weight: 600;
}
.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}
.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}
.table-actions .btn {
    margin: 0 2px;
    padding: 5px 10px;
    font-size: 12px;
}
.modal-header {
    background: #007bff;
    color: white;
    border-bottom: none;
}
.modal-header .close {
    color: white;
    opacity: 0.8;
}
.modal-header .close:hover {
    opacity: 1;
}
.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
.category-input-section {
    background: #f8f9fa;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 20px;
}
.category-table-container {
    background: #e8f4f8;
    border-radius: 5px;
    padding: 15px;
}
.category-table-header {
    background: #007bff;
    color: white;
    padding: 10px 15px;
    border-radius: 3px 3px 0 0;
    margin-bottom: 0;
    display: flex;
    justify-content: space-between;
}
.category-table-content {
    background: white;
    border: 1px solid #dee2e6;
    border-top: none;
    border-radius: 0 0 3px 3px;
    padding: 0;
}
.category-table-content table {
    margin-bottom: 0;
}
.view-table th {
    background-color: #f8f9fa;
    width: 30%;
    font-weight: 600;
    padding: 12px 15px;
}
.view-table td {
    padding: 12px 15px;
}
.edit-row {
    background-color: #fff3cd;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
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
                    <!-- Quick Add Section -->
                    <div class="category-input-section">
                        <div class="row">
                            <div class="col-md-8">
                                <label for="quickCategoryName">Category Name</label>
                                <input type="text" class="form-control" id="quickCategoryName" placeholder="Enter category name">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="button" class="btn btn-primary mr-2" id="quickAddBtn">Add</button>
                                <button type="button" class="btn btn-secondary" id="refreshBtn">Refresh</button>
                            </div>
                        </div>
                    </div>

                    <!-- Categories Table Container -->
                    <div class="category-table-container">
                        <div class="category-table-header">
                            <span>Edit</span>
                            <span>Category Name</span>
                        </div>
                        <div class="category-table-content">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover" id="categoriesTable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="8%">Sr. No.</th>
                                            <th width="15%">Edit</th>
                                            <th width="35%">Category Name</th>
                                            <th width="20%">Tests Count</th>
                                            <th width="12%">Status</th>
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
                    
                    <div class="form-group">
                        <label for="categoryName">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="categoryName" name="category_name" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Category description..."></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="status" name="status" checked>
                            <label class="custom-control-label" for="status">Active Status</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
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
                <div class="table-responsive">
                    <table class="table table-bordered view-table">
                        <tbody id="categoryDetails">
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
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {
                data: 'id', 
                name: 'edit',
                orderable: false, 
                searchable: false, 
                className: 'text-center',
                render: function(data, type, row) {
                    return '<button class="btn btn-warning btn-sm editTestCategory" data-id="' + data + '">Edit</button>';
                }
            },
            {data: 'category_name', name: 'category_name'},
            {data: 'tests_count', name: 'tests_count', orderable: false},
            {data: 'status', name: 'status', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'table-actions text-center'}
        ],
        order: [[2, 'asc']],
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
    });

    // Create new category (main button)
    $('#createNewCategory').click(function() {
        resetForm();
        $('#categoryModalLabel').html('<i class="fas fa-tags mr-2"></i>Add Test Category');
        $('#categoryModal').modal('show');
        toastr.info('Create a new test category');
    });

    // Quick add functionality
    $('#quickAddBtn').click(function() {
        var categoryName = $('#quickCategoryName').val().trim();
        
        if (!categoryName) {
            toastr.warning('Please enter a category name');
            $('#quickCategoryName').focus();
            return;
        }

        // Quick save via AJAX
        $.ajax({
            url: "{{ route('admin.test-categories.store') }}",
            type: 'POST',
            data: {
                category_name: categoryName,
                status: true,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#quickCategoryName').val('');
                table.ajax.reload();
                toastr.success(response.success);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    if (errors.category_name) {
                        toastr.error(errors.category_name[0]);
                    }
                } else {
                    toastr.error('Error adding category');
                }
            }
        });
    });

    // Refresh table
    $('#refreshBtn').click(function() {
        table.ajax.reload();
        toastr.info('Table refreshed');
    });

    // Quick add on Enter key
    $('#quickCategoryName').on('keypress', function(e) {
        if (e.which === 13) {
            $('#quickAddBtn').click();
        }
    });

    // Save category
    $('#categoryForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        
        // Show loading
        var saveBtn = $(this).find('button[type="submit"]');
        var originalText = saveBtn.html();
        saveBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Saving...');
        
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
                $('#categoryModal').modal('hide');
                table.ajax.reload();
                toastr.success(response.success);
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
            },
            complete: function() {
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
            });
        }
    });

    // Reset form function
    function resetForm() {
        $('#categoryForm')[0].reset();
        $('#categoryId').val('');
        $('#status').prop('checked', true);
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
    }
});
</script>
@endpush
