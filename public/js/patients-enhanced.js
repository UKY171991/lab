// Patients Enhanced Custom JS
$(document).ready(function() {
    // Initialize DataTable with enhanced features
    var table = $('.patients-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        select: {
            style: 'multi',
            selector: 'td:first-child input[type="checkbox"]'
        },
        ajax: {
            url: patientsDataRoute,
            data: function (d) {
                d.gender = $('#filterGender').val();
                d.age_range = $('#filterAge').val();
                d.search_term = $('#searchPatients').val();
            }
        },
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false, className: 'text-center'},
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'avatar', name: 'avatar', orderable: false, searchable: false, className: 'text-center'},
            {data: 'client_name', name: 'client_name'},
            {data: 'age_gender', name: 'age_gender', orderable: false},
            {data: 'mobile_number', name: 'mobile_number'},
            {data: 'blood_group', name: 'blood_group'},
            {data: 'last_visit', name: 'last_visit', orderable: false},
            {data: 'status', name: 'status', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                className: 'btn-primary',
                text: '<i class="fas fa-file-excel mr-1"></i> Excel'
            },
            {
                extend: 'pdf',
                className: 'btn-primary',
                text: '<i class="fas fa-file-pdf mr-1"></i> PDF'
            },
            {
                extend: 'print',
                className: 'btn-primary',
                text: '<i class="fas fa-print mr-1"></i> Print'
            }
        ],
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        language: {
            processing: '<i class="fas fa-spinner fa-spin"></i> Loading patients...',
            emptyTable: 'No patients found',
            zeroRecords: 'No matching patients found'
        },
        drawCallback: function() {
            $('[data-toggle="tooltip"]').tooltip();
            updateBulkActionsVisibility();
        }
    });

    // ...existing code for all event handlers and utility functions from the Blade file...
});
// Place all utility functions, event handlers, and modal logic here as in the Blade file.
