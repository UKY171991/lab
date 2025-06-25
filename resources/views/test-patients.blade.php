<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test Patients Table</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css">
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Patients Table Test</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="patientsTable">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Patient Name</th>
                                        <th>Mobile Number</th>
                                        <th>UHID</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Registration Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            console.log('Initializing DataTable...');
            
            var table = $('#patientsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('test.patients.data') }}",
                    error: function(xhr, error, thrown) {
                        console.error('AJAX Error:', xhr, error, thrown);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error loading patients data: ' + xhr.responseText,
                            timer: 5000
                        });
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'client_name', name: 'client_name'},
                    {data: 'mobile_number', name: 'mobile_number'},
                    {data: 'uhid', name: 'uhid'},
                    {data: 'sex_badge', name: 'sex', orderable: false},
                    {data: 'age_display', name: 'age', orderable: false},
                    {data: 'created_at_formatted', name: 'created_at'},
                    {data: 'status', name: 'status', orderable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
                ],
                order: [[1, 'asc']],
                pageLength: 25,
                language: {
                    processing: '<i class="fas fa-spinner fa-spin fa-2x"></i><br>Loading...',
                    emptyTable: 'No patients found.'
                }
            });
            
            console.log('DataTable initialized successfully');
        });
    </script>
</body>
</html>
