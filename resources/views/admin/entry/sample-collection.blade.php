@extends('admin.layouts.app')

@section('title', 'Sample Collection')
@section('page-title', 'Sample Collection')
@section('breadcrumb', 'Entry / Sample Collection')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">

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

.stat-card.pending .icon { color: #e74c3c; }
.stat-card.collected .icon { color: #f39c12; }
.stat-card.processing .icon { color: #3498db; }
.stat-card.completed .icon { color: #27ae60; }

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

.collection-status {
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 20px;
    text-align: center;
}

.status-pending {
    background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    color: white;
}

.status-collected {
    background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
    color: white;
}

.status-processing {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    color: white;
}

.status-completed {
    background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
    color: white;
}

.sample-item {
    background: #fff;    border: 1px solid #e8ecef;
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.sample-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: #667eea;
}

.sample-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.1);
    border-color: #667eea;
}

.urgency-high {
    border-left: 5px solid #e74c3c;
}

.urgency-high::before {
    background: #e74c3c;
}

.urgency-medium {
    border-left: 5px solid #f39c12;
}

.urgency-medium::before {
    background: #f39c12;
}

.urgency-normal {
    border-left: 5px solid #27ae60;
}

.urgency-normal::before {
    background: #27ae60;
}

.collection-stats {
    background: #fff;
    border-radius: 15px;
    padding: 25px;
    text-align: center;
    border: 1px solid #e8ecef;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.btn-modern {
    border-radius: 25px;
    padding: 8px 20px;
    font-weight: 500;
    border: none;
    transition: all 0.3s ease;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.btn-collect {
    background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
    color: white;
}

.btn-reject {
    background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    color: white;
}

.urgency-badge {
    border-radius: 20px;
    padding: 5px 12px;
    font-size: 0.8rem;
    font-weight: 600;
}

.badge-high {
    background: #e74c3c;
    color: white;
}

.badge-medium {
    background: #f39c12;
    color: white;
}

.badge-normal {
    background: #27ae60;
    color: white;
}

.form-control {
    border-radius: 10px;
    border: 2px solid #e8ecef;
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.table {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.table thead th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    font-weight: 600;
    padding: 15px;
}

.table tbody tr {
    transition: all 0.3s ease;
}

.table tbody tr:hover {
    background-color: #f8f9ff;
    transform: scale(1.001);
}

.modal-content {
    border-radius: 20px;
    border: none;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
}

.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 20px 20px 0 0;
    border: none;
}

.modal-body {
    padding: 2rem;
}

@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
        text-align: center;
    }
    
    .page-header h1 {
        font-size: 2rem;
    }
    
    .sample-item {
        padding: 15px;
    }
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1><i class="fas fa-vials text-primary"></i> Sample Collection</h1>
                <p>Manage and track sample collection process</p>
            </div>
            <div class="col-md-6 text-md-right">
                <button class="btn btn-modern btn-collect" onclick="refreshCollection()">
                    <i class="fas fa-sync-alt"></i> Refresh Queue
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Row -->
    <div class="row stats-row">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card pending">
                <i class="fas fa-clock icon"></i>
                <h3 id="pendingCount">12</h3>
                <p>Pending Collection</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card collected">
                <i class="fas fa-vial icon"></i>
                <h3 id="collectedCount">8</h3>
                <p>Collected Today</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card processing">
                <i class="fas fa-cogs icon"></i>
                <h3 id="processingCount">5</h3>
                <p>In Processing</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card completed">
                <i class="fas fa-check-circle icon"></i>
                <h3 id="completedCount">25</h3>
                <p>Completed</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sample Collection Queue -->
        <div class="col-md-8">
            <div class="main-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list-ul mr-2"></i>Sample Collection Queue
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Filter Options -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <select class="form-control" id="urgencyFilter">
                                <option value="">All Urgency</option>
                                <option value="high">High Priority</option>
                                <option value="medium">Medium Priority</option>
                                <option value="normal">Normal Priority</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="collected">Collected</option>
                                <option value="processing">Processing</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="searchPatient" placeholder="Search by patient name or ID...">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-block" id="refreshQueue">
                                <i class="fas fa-sync-alt"></i> Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Sample Collection Items -->
                    <div id="sampleQueue">
                        <!-- High Priority -->
                        <div class="sample-item urgency-high" data-patient-id="1" data-urgency="high" data-status="pending">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <h6 class="mb-1">John Doe</h6>
                                    <small class="text-muted">PAT-2025-0001</small>
                                    <br>
                                    <span class="badge badge-danger">High Priority</span>
                                </div>
                                <div class="col-md-4">
                                    <div class="test-list">
                                        <small><strong>Tests:</strong></small>
                                        <ul class="list-unstyled mb-0">
                                            <li><small>• Complete Blood Count</small></li>
                                            <li><small>• Lipid Profile</small></li>
                                            <li><small>• Thyroid Function</small></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <small class="text-muted">Booked:</small>
                                    <br>
                                    <small>Today 9:30 AM</small>
                                </div>
                                <div class="col-md-2">
                                    <span class="badge badge-warning">Pending</span>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-success btn-sm collect-sample" data-patient-id="1">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Medium Priority -->
                        <div class="sample-item urgency-medium" data-patient-id="2" data-urgency="medium" data-status="pending">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <h6 class="mb-1">Jane Smith</h6>
                                    <small class="text-muted">PAT-2025-0002</small>
                                    <br>
                                    <span class="badge badge-warning">Medium Priority</span>
                                </div>
                                <div class="col-md-4">
                                    <div class="test-list">
                                        <small><strong>Tests:</strong></small>
                                        <ul class="list-unstyled mb-0">
                                            <li><small>• Liver Function Test</small></li>
                                            <li><small>• Kidney Function Test</small></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <small class="text-muted">Booked:</small>
                                    <br>
                                    <small>Today 10:15 AM</small>
                                </div>
                                <div class="col-md-2">
                                    <span class="badge badge-warning">Pending</span>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-success btn-sm collect-sample" data-patient-id="2">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Normal Priority - Collected -->
                        <div class="sample-item urgency-normal" data-patient-id="3" data-urgency="normal" data-status="collected">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <h6 class="mb-1">Mike Johnson</h6>
                                    <small class="text-muted">PAT-2025-0003</small>
                                    <br>
                                    <span class="badge badge-success">Normal Priority</span>
                                </div>
                                <div class="col-md-4">
                                    <div class="test-list">
                                        <small><strong>Tests:</strong></small>
                                        <ul class="list-unstyled mb-0">
                                            <li><small>• Blood Sugar</small></li>
                                            <li><small>• HbA1c</small></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <small class="text-muted">Collected:</small>
                                    <br>
                                    <small>Today 11:00 AM</small>
                                </div>
                                <div class="col-md-2">
                                    <span class="badge badge-info">Collected</span>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-primary btn-sm send-to-lab" data-patient-id="3">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Collection Summary & Actions -->
        <div class="col-md-4">
            <!-- Collection Status Overview -->
            <div class="collection-status status-pending">
                <h5><i class="fas fa-clock mr-2"></i>Today's Collection</h5>
                <h3>8 Pending</h3>
                <small>Samples waiting for collection</small>
            </div>

            <!-- Collection Statistics -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-2"></i>Collection Stats
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="collection-stats border-right">
                                <h4 class="text-success">15</h4>
                                <small>Collected</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="collection-stats">
                                <h4 class="text-warning">8</h4>
                                <small>Pending</small>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <div class="collection-stats border-right">
                                <h4 class="text-info">12</h4>
                                <small>Processing</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="collection-stats">
                                <h4 class="text-primary">35</h4>
                                <small>Total</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt mr-2"></i>Quick Actions
                    </h3>
                </div>
                <div class="card-body">
                    <button class="btn btn-success btn-block mb-2" id="bulkCollection">
                        <i class="fas fa-check-double mr-2"></i>Mark All as Collected
                    </button>
                    <button class="btn btn-info btn-block mb-2" id="printLabels">
                        <i class="fas fa-print mr-2"></i>Print Sample Labels
                    </button>
                    <button class="btn btn-warning btn-block mb-2" id="sendToLab">
                        <i class="fas fa-share mr-2"></i>Send Batch to Lab
                    </button>
                    <button class="btn btn-primary btn-block" id="collectionReport">
                        <i class="fas fa-file-alt mr-2"></i>Collection Report
                    </button>
                </div>
            </div>

            <!-- Collection Guidelines -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i>Collection Guidelines
                    </h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check text-success mr-2"></i>
                            <small>Verify patient identity before collection</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success mr-2"></i>
                            <small>Use proper collection tubes for each test</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success mr-2"></i>
                            <small>Label samples immediately after collection</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success mr-2"></i>
                            <small>Store samples at appropriate temperature</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sample Collection Modal -->
<div class="modal fade" id="collectionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-vial mr-2"></i>Sample Collection
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="collectionForm">
                    <div class="form-group">
                        <label>Patient Information</label>
                        <div id="patientInfo" class="alert alert-info">
                            <!-- Patient info will be loaded here -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Collection Notes</label>
                        <textarea class="form-control" id="collectionNotes" rows="3" placeholder="Enter any notes about the collection..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Collector Name</label>
                        <input type="text" class="form-control" id="collectorName" value="Current User" readonly>
                    </div>
                    <div class="form-group">
                        <label>Collection Time</label>
                        <input type="datetime-local" class="form-control" id="collectionTime" value="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmCollection">
                    <i class="fas fa-check mr-2"></i>Confirm Collection
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>
$(document).ready(function() {
    let currentPatientId = null;

    // Set current time for collection
    $('#collectionTime').val(new Date().toISOString().slice(0, 16));

    // Collect sample button
    $(document).on('click', '.collect-sample', function() {
        currentPatientId = $(this).data('patient-id');
        var patientName = $(this).closest('.sample-item').find('h6').text();
        var patientId = $(this).closest('.sample-item').find('.text-muted').first().text();
        
        $('#patientInfo').html(`<strong>${patientName}</strong><br><small>${patientId}</small>`);
        $('#collectionModal').modal('show');
    });

    // Confirm collection
    $('#confirmCollection').click(function() {
        var btn = $(this);
        var originalText = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Processing...');

        setTimeout(function() {
            // Update the sample item status
            var sampleItem = $(`.sample-item[data-patient-id="${currentPatientId}"]`);
            sampleItem.attr('data-status', 'collected');
            sampleItem.find('.badge-warning').removeClass('badge-warning').addClass('badge-info').text('Collected');
            sampleItem.find('.collect-sample').removeClass('btn-success').addClass('btn-primary')
                .html('<i class="fas fa-arrow-right"></i>').removeClass('collect-sample').addClass('send-to-lab');

            $('#collectionModal').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Sample Collected!',
                text: 'Sample collected successfully',
                timer: 2000,
                showConfirmButton: false
            });
            btn.prop('disabled', false).html(originalText);
            $('#collectionNotes').val('');
        }, 1500);
    });

    // Send to lab button
    $(document).on('click', '.send-to-lab', function() {
        var patientId = $(this).data('patient-id');
        var sampleItem = $(this).closest('.sample-item');
        
        sampleItem.attr('data-status', 'processing');
        sampleItem.find('.badge-info').removeClass('badge-info').addClass('badge-success').text('Processing');
        $(this).prop('disabled', true).html('<i class="fas fa-check"></i>').removeClass('btn-primary').addClass('btn-secondary');
        
        Swal.fire({
            icon: 'success',
            title: 'Sent to Lab!',
            text: 'Sample sent to lab for processing',
            timer: 2000,
            showConfirmButton: false
        });
    });

    // Filter functions
    $('#urgencyFilter').change(function() {
        filterSamples();
    });

    $('#statusFilter').change(function() {
        filterSamples();
    });

    $('#searchPatient').on('input', function() {
        filterSamples();
    });

    // Quick actions
    $('#refreshQueue').click(function() {
        var btn = $(this);
        btn.html('<i class="fas fa-spinner fa-spin"></i>');
        setTimeout(function() {
            btn.html('<i class="fas fa-sync-alt"></i> Refresh');
            Swal.fire({
                icon: 'info',
                title: 'Queue Refreshed',
                timer: 1500,
                showConfirmButton: false
            });
        }, 1000);
    });

    $('#bulkCollection').click(function() {
        var pendingCount = $('.sample-item[data-status="pending"]').length;
        if (pendingCount === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Pending Samples',
                text: 'No pending samples to collect'
            });
            return;
        }

        Swal.fire({
            title: 'Mark Samples as Collected?',
            text: `Mark ${pendingCount} samples as collected?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#27ae60',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, mark as collected!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('.sample-item[data-status="pending"]').each(function() {
                    $(this).attr('data-status', 'collected');
                    $(this).find('.badge-warning').removeClass('badge-warning').addClass('badge-info').text('Collected');
                    $(this).find('.collect-sample').removeClass('btn-success collect-sample').addClass('btn-primary send-to-lab')
                        .html('<i class="fas fa-arrow-right"></i>');
                });
                Swal.fire({
                    icon: 'success',
                    title: 'Samples Collected!',
                    text: `${pendingCount} samples marked as collected`,
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    });

    $('#printLabels').click(function() {
        Swal.fire({
            icon: 'info',
            title: 'Printing Labels',
            text: 'Sample labels are being printed...',
            timer: 2000,
            showConfirmButton: false
        });
    });

    $('#sendToLab').click(function() {
        var collectedCount = $('.sample-item[data-status="collected"]').length;
        if (collectedCount === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Collected Samples',
                text: 'No collected samples to send'
            });
            return;
        }

        Swal.fire({
            title: 'Send Samples to Lab?',
            text: `Send ${collectedCount} samples to lab?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, send to lab!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('.sample-item[data-status="collected"]').each(function() {
                    $(this).attr('data-status', 'processing');
                    $(this).find('.badge-info').removeClass('badge-info').addClass('badge-success').text('Processing');
                    $(this).find('.send-to-lab').prop('disabled', true).html('<i class="fas fa-check"></i>')
                        .removeClass('btn-primary').addClass('btn-secondary');
                });
                Swal.fire({
                    icon: 'success',
                    title: 'Sent to Lab!',
                    text: `${collectedCount} samples sent to lab`,
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    });

    $('#collectionReport').click(function() {
        Swal.fire({
            icon: 'info',
            title: 'Generating Report',
            text: 'Collection report is being generated...',
            timer: 2000,
            showConfirmButton: false
        });
    });

    // Filter samples function
    function filterSamples() {
        var urgencyFilter = $('#urgencyFilter').val();
        var statusFilter = $('#statusFilter').val();
        var searchTerm = $('#searchPatient').val().toLowerCase();

        $('.sample-item').each(function() {
            var show = true;
            
            if (urgencyFilter && $(this).data('urgency') !== urgencyFilter) {
                show = false;
            }
            
            if (statusFilter && $(this).data('status') !== statusFilter) {
                show = false;
            }
            
            if (searchTerm) {
                var patientText = $(this).find('h6').text().toLowerCase() + ' ' + $(this).find('.text-muted').first().text().toLowerCase();
                if (!patientText.includes(searchTerm)) {
                    show = false;
                }
            }
            
            $(this).toggle(show);
        });
    }

    // Initialize with refresh functionality
    function refreshCollection() {
        $('#refreshQueue').click();
    }

    // Expose function to global scope
    window.refreshCollection = refreshCollection;

    // Show welcome message
    Swal.fire({
        icon: 'success',
        title: 'System Ready',
        text: 'Sample Collection system ready',
        timer: 2000,
        showConfirmButton: false
    });
});
</script>
@endpush
