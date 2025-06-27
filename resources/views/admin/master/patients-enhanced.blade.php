@extends('admin.layouts.app')

@section('title', 'Patient Management')
@section('page-title', 'Patient Management')
@section('breadcrumb', 'Master / Patients')

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.bootstrap4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

<style>
    .patients-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
    }
    
    .patients-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 120px;
        height: 200%;
        background: rgba(255,255,255,0.1);
        transform: rotate(15deg);
        animation: pulse 4s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 0.1; }
        50% { opacity: 0.2; }
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stats-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border-left: 4px solid var(--accent-color);
        position: relative;
        overflow: hidden;
    }
    
    .stats-card::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 60px;
        height: 60px;
        background: var(--accent-color);
        border-radius: 0 0 0 60px;
        opacity: 0.1;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: var(--accent-color);
        margin-bottom: 5px;
    }
    
    .stats-label {
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
    }
    
    .stats-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 2rem;
        color: var(--accent-color);
        opacity: 0.3;
    }
    
    .main-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: none;
        transition: all 0.3s ease;
    }
    
    .main-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    }
    
    .card-header {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: white;
        border: none;
        padding: 25px 30px;
    }
    
    .search-filters {
        background: #f8fafc;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 20px;
    }
    
    .filter-group {
        display: flex;
        gap: 15px;
        align-items: end;
        flex-wrap: wrap;
    }
    
    .filter-item {
        flex: 1;
        min-width: 200px;
    }
    
    .table thead th {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border: none;
        font-weight: 600;
        color: #374151;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.85rem;
        padding: 20px 15px;
    }
    
    .table tbody tr {
        transition: all 0.3s ease;
    }
    
    .table tbody tr:hover {
        background: #f1f5f9;
        transform: scale(1.005);
    }
    
    .table tbody td {
        padding: 18px 15px;
        border-top: 1px solid #e2e8f0;
        vertical-align: middle;
    }
    
    .patient-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .patient-avatar:hover {
        border-color: #10b981;
        transform: scale(1.1);
    }
    
    .badge {
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .btn-group .btn {
        margin: 0 2px;
        border-radius: 8px !important;
        padding: 8px 12px;
        transition: all 0.3s ease;
    }
    
    .btn-group .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    .action-buttons {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .btn-add-patient {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 25px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }
    
    .btn-add-patient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        color: white;
    }
    
    .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
    }
    
    .modal-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        border: none;
        padding: 25px 30px;
    }
    
    .modal-header .close {
        color: white;
        opacity: 0.9;
        font-size: 1.5rem;
        text-shadow: none;
    }
    
    .form-control {
        border-radius: 10px;
        border: 2px solid #e2e8f0;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
    }
    
    .form-group label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }
    
    .bulk-actions {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: none;
    }
    
    .patient-quick-stats {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .quick-stat {
        background: white;
        padding: 15px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        flex: 1;
    }
    
    .quick-stat-number {
        font-size: 1.5rem;
        font-weight: bold;
        color: #10b981;
    }
    
    .quick-stat-label {
        font-size: 0.8rem;
        color: #6b7280;
        margin-top: 5px;
    }
    
    /* Export buttons */
    .dt-buttons {
        margin-bottom: 15px;
    }
    
    .dt-button {
        background: #6366f1 !important;
        color: white !important;
        border: none !important;
        border-radius: 8px !important;
        padding: 8px 15px !important;
        margin-right: 5px !important;
        font-weight: 600 !important;
        transition: all 0.3s ease !important;
    }
    
    .dt-button:hover {
        background: #4f46e5 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3) !important;
    }
    
    /* Loading states */
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        border-radius: 20px;
    }
    
    .loading-spinner {
        border: 4px solid #e2e8f0;
        border-top: 4px solid #10b981;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .patients-header {
            padding: 25px;
            text-align: center;
        }
        
        .filter-group {
            flex-direction: column;
        }
        
        .filter-item {
            min-width: 100%;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Patients Header -->
    <div class="patients-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0">
                    <i class="fas fa-user-injured mr-3"></i>Patient Management System
                </h1>
                <p class="mb-0 mt-2 opacity-75">Comprehensive patient records and medical history management</p>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route('admin.patients.create') }}" class="btn btn-add-patient">
                    <i class="fas fa-plus mr-2"></i>Add New Patient
                </a>
            </div>
        </div>
    </div>

    <!-- Patient Statistics -->
    <div class="stats-grid">
        <div class="stats-card" style="--accent-color: #10b981;">
            <i class="fas fa-users stats-icon"></i>
            <div class="stats-number">{{ \App\Models\Patient::count() }}</div>
            <div class="stats-label">Total Patients</div>
        </div>
        <div class="stats-card" style="--accent-color: #3b82f6;">
            <i class="fas fa-user-plus stats-icon"></i>
            <div class="stats-number">{{ \App\Models\Patient::where('created_at', '>=', now()->startOfMonth())->count() }}</div>
            <div class="stats-label">New This Month</div>
        </div>
        <div class="stats-card" style="--accent-color: #f59e0b;">
            <i class="fas fa-mars stats-icon"></i>
            <div class="stats-number">{{ \App\Models\Patient::where('sex', 'male')->count() }}</div>
            <div class="stats-label">Male Patients</div>
        </div>
        <div class="stats-card" style="--accent-color: #ec4899;">
            <i class="fas fa-venus stats-icon"></i>
            <div class="stats-number">{{ \App\Models\Patient::where('sex', 'female')->count() }}</div>
            <div class="stats-label">Female Patients</div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="search-filters">
        <div class="filter-group">
            <div class="filter-item">
                <label>Search Patients</label>
                <input type="text" class="form-control" id="searchPatients" placeholder="Search by name, phone, or email...">
            </div>
            <div class="filter-item">
                <label>Filter by Gender</label>
                <select class="form-control" id="filterGender">
                    <option value="">All Genders</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="filter-item">
                <label>Age Range</label>
                <select class="form-control" id="filterAge">
                    <option value="">All Ages</option>
                    <option value="0-18">0-18 years</option>
                    <option value="19-35">19-35 years</option>
                    <option value="36-60">36-60 years</option>
                    <option value="60+">60+ years</option>
                </select>
            </div>
            <div class="filter-item">
                <button class="btn btn-primary" id="applyFilters">
                    <i class="fas fa-filter mr-2"></i>Apply Filters
                </button>
                <button class="btn btn-secondary ml-2" id="clearFilters">
                    <i class="fas fa-times mr-2"></i>Clear
                </button>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="bulk-actions" id="bulkActions">
        <div class="row align-items-center">
            <div class="col-md-6">
                <i class="fas fa-info-circle mr-2"></i>
                <span id="selectedCount">0</span> patient(s) selected
            </div>
            <div class="col-md-6 text-right">
                <button class="btn btn-warning btn-sm" id="bulkExport">
                    <i class="fas fa-download mr-1"></i>Export Selected
                </button>
                <button class="btn btn-danger btn-sm" id="bulkDelete">
                    <i class="fas fa-trash mr-1"></i>Delete Selected
                </button>
            </div>
        </div>
    </div>

    <!-- Patients Table -->
    <div class="main-card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="mb-0">
                        <i class="fas fa-table mr-2"></i>Patients Directory
                    </h4>
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-light btn-sm" id="refreshTable">
                        <i class="fas fa-sync-alt mr-1"></i>Refresh
                    </button>
                    <button class="btn btn-light btn-sm" id="columnToggle">
                        <i class="fas fa-columns mr-1"></i>Columns
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0" style="position: relative;">
            <div class="loading-overlay" id="loadingOverlay" style="display: none;">
                <div class="loading-spinner"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover patients-table" id="patientsTable">
                    <thead>
                        <tr>
                            <th width="40px">
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th width="50px">#</th>
                            <th width="60px">Photo</th>
                            <th>Patient ID</th>
                            <th>Name</th>
                            <th>Age/Gender</th>
                            <th>Contact</th>
                            <th>Blood Group</th>
                            <th>Last Visit</th>
                            <th>Status</th>
                            <th width="150px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Patient Modal -->
<div class="modal fade" id="patientModal" tabindex="-1" role="dialog" aria-labelledby="patientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="patientModalLabel">
                    <i class="fas fa-user-plus mr-2"></i>Add New Patient
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="patientForm">
                    @csrf
                    <input type="hidden" id="patient_id" name="patient_id">
                    
                    <!-- Patient Photo Upload -->
                    <div class="text-center mb-4">
                        <div class="patient-photo-upload">
                            <img id="patientPhoto" src="https://via.placeholder.com/150" class="rounded-circle" width="150" height="150" style="object-fit: cover; border: 5px solid #e2e8f0;">
                            <div class="mt-2">
                                <input type="file" id="photoUpload" class="d-none" accept="image/*">
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('photoUpload').click()">
                                    <i class="fas fa-camera mr-2"></i>Upload Photo
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3"><i class="fas fa-user mr-2"></i>Basic Information</h6>
                            
                            <div class="form-group">
                                <label for="client_name">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="client_name" name="client_name" required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="age">Age <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="age" name="age" min="0" max="150" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sex">Gender <span class="text-danger">*</span></label>
                                        <select class="form-control" id="sex" name="sex" required>
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="date_of_birth">Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                            </div>
                            
                            <div class="form-group">
                                <label for="blood_group">Blood Group</label>
                                <select class="form-control" id="blood_group" name="blood_group">
                                    <option value="">Select Blood Group</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Contact Information -->
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3"><i class="fas fa-phone mr-2"></i>Contact Information</h6>
                            
                            <div class="form-group">
                                <label for="mobile_number">Mobile Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="mobile_number" name="mobile_number" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            
                            <div class="form-group">
                                <label for="emergency_contact">Emergency Contact</label>
                                <input type="tel" class="form-control" id="emergency_contact" name="emergency_contact">
                            </div>
                            
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <!-- Medical Information -->
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3"><i class="fas fa-stethoscope mr-2"></i>Medical Information</h6>
                            
                            <div class="form-group">
                                <label for="father_husband_name">Father/Husband Name</label>
                                <input type="text" class="form-control" id="father_husband_name" name="father_husband_name">
                            </div>
                            
                            <div class="form-group">
                                <label for="occupation">Occupation</label>
                                <input type="text" class="form-control" id="occupation" name="occupation">
                            </div>
                            
                            <div class="form-group">
                                <label for="medical_history">Medical History</label>
                                <textarea class="form-control" id="medical_history" name="medical_history" rows="3" placeholder="Any significant medical history..."></textarea>
                            </div>
                        </div>
                        
                        <!-- Additional Information -->
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3"><i class="fas fa-info-circle mr-2"></i>Additional Information</h6>
                            
                            <div class="form-group">
                                <label for="allergies">Allergies</label>
                                <textarea class="form-control" id="allergies" name="allergies" rows="3" placeholder="Any known allergies..."></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Any additional information..."></textarea>
                            </div>
                            
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="status" name="status" checked>
                                    <label class="form-check-label" for="status">
                                        Active Patient
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary" id="savePatient">
                    <i class="fas fa-save mr-2"></i>Save Patient
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Patient Details Modal -->
<div class="modal fade" id="viewPatientModal" tabindex="-1" role="dialog" aria-labelledby="viewPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewPatientModalLabel">
                    <i class="fas fa-eye mr-2"></i>Patient Details
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img id="viewPatientPhoto" src="https://via.placeholder.com/200" class="rounded-circle mb-3" width="200" height="200" style="object-fit: cover;">
                        <h5 id="viewPatientName">-</h5>
                        <p class="text-muted" id="viewPatientId">-</p>
                    </div>
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody id="patientDetails">
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
                <button type="button" class="btn btn-primary" id="editFromView">
                    <i class="fas fa-edit mr-2"></i>Edit Patient
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
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
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
            url: "{{ route('admin.patients.data') }}",
            data: function (d) {
                d.gender = $('#filterGender').val();
                d.age_range = $('#filterAge').val();
                d.search_term = $('#searchPatients').val();
            }
        },
        columns: [
            {
                data: 'checkbox',
                name: 'checkbox',
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
            {data: 'patient_id', name: 'patient_id'},
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

    // Initialize Select2
    $('#filterGender, #filterAge').select2({
        theme: 'bootstrap4',
        allowClear: true
    });

    // Real-time search
    $('#searchPatients').on('keyup', debounce(function() {
        table.draw();
    }, 500));

    // Apply filters
    $('#applyFilters').click(function() {
        showLoading();
        table.draw();
        hideLoading();
    });

    // Clear filters
    $('#clearFilters').click(function() {
        $('#filterGender, #filterAge').val('').trigger('change');
        $('#searchPatients').val('');
        table.draw();
    });

    // Refresh table
    $('#refreshTable').click(function() {
        showLoading();
        table.ajax.reload();
        hideLoading();
    });

    // Select all functionality
    $('#selectAll').on('click', function() {
        if (this.checked) {
            $('.row-checkbox').prop('checked', true);
        } else {
            $('.row-checkbox').prop('checked', false);
        }
        updateBulkActionsVisibility();
    });

    // Individual checkbox selection
    $(document).on('change', '.row-checkbox', function() {
        updateBulkActionsVisibility();
    });

    // Add new patient
    $('#createNewPatient').click(function() {
        resetForm();
        $('#patientModalLabel').html('<i class="fas fa-user-plus mr-2"></i>Add New Patient');
        $('#patientModal').modal('show');
    });

    // Edit patient
    $(document).on('click', '.editPatient', function() {
        var id = $(this).data('id');
        showLoading();
        
        $.ajax({
            url: "{{ route('admin.patients.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                hideLoading();
                populateForm(data);
                $('#patientModalLabel').html('<i class="fas fa-edit mr-2"></i>Edit Patient');
                $('#patientModal').modal('show');
            },
            error: function() {
                hideLoading();
                Swal.fire('Error', 'Error loading patient data', 'error');
            }
        });
    });

    // View patient details
    $(document).on('click', '.viewPatient', function() {
        var id = $(this).data('id');
        
        $.ajax({
            url: "{{ route('admin.patients.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(data) {
                populateViewModal(data);
                $('#viewPatientModal').modal('show');
            },
            error: function() {
                Swal.fire('Error', 'Error loading patient data', 'error');
            }
        });
    });

    // Save patient
    $('#savePatient').click(function() {
        var formData = new FormData($('#patientForm')[0]);
        var url = $('#patient_id').val() ? 
            "{{ route('admin.patients.update', ':id') }}".replace(':id', $('#patient_id').val()) : 
            "{{ route('admin.patients.store') }}";
        var method = $('#patient_id').val() ? 'PUT' : 'POST';

        showLoading();

        $.ajax({
            url: url,
            method: method,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                hideLoading();
                $('#patientModal').modal('hide');
                table.ajax.reload();
                Swal.fire('Success!', response.message || 'Patient saved successfully', 'success');
            },
            error: function(xhr) {
                hideLoading();
                var message = xhr.responseJSON?.message || 'Error saving patient';
                Swal.fire('Error!', message, 'error');
            }
        });
    });

    // Delete patient
    $(document).on('click', '.deletePatient', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        
        Swal.fire({
            title: 'Are you sure?',
            text: `You want to delete patient "${name}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                
                $.ajax({
                    url: "{{ route('admin.patients.destroy', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        hideLoading();
                        table.ajax.reload();
                        Swal.fire('Deleted!', response.message || 'Patient deleted successfully', 'success');
                    },
                    error: function() {
                        hideLoading();
                        Swal.fire('Error!', 'Error deleting patient', 'error');
                    }
                });
            }
        });
    });

    // Photo upload preview
    $('#photoUpload').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#patientPhoto').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // Auto-calculate age from date of birth
    $('#date_of_birth').change(function() {
        const dob = new Date($(this).val());
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const monthDiff = today.getMonth() - dob.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }
        
        if (age >= 0 && age <= 150) {
            $('#age').val(age);
        }
    });

    // Utility functions
    function resetForm() {
        $('#patientForm')[0].reset();
        $('#patient_id').val('');
        $('#patientPhoto').attr('src', 'https://via.placeholder.com/150');
    }

    function populateForm(data) {
        $('#patient_id').val(data.id);
        $('#client_name').val(data.client_name);
        $('#age').val(data.age);
        $('#sex').val(data.sex);
        $('#date_of_birth').val(data.date_of_birth);
        $('#blood_group').val(data.blood_group);
        $('#mobile_number').val(data.mobile_number);
        $('#email').val(data.email);
        $('#emergency_contact').val(data.emergency_contact);
        $('#address').val(data.address);
        $('#father_husband_name').val(data.father_husband_name);
        $('#occupation').val(data.occupation);
        $('#medical_history').val(data.medical_history);
        $('#allergies').val(data.allergies);
        $('#notes').val(data.notes);
        $('#status').prop('checked', data.status);
        
        if (data.photo) {
            $('#patientPhoto').attr('src', data.photo);
        }
    }

    function populateViewModal(data) {
        $('#viewPatientName').text(data.client_name || 'N/A');
        $('#viewPatientId').text(data.patient_id || 'N/A');
        
        if (data.photo) {
            $('#viewPatientPhoto').attr('src', data.photo);
        }

        var detailsHtml = `
            <tr><th>Age:</th><td>${data.age || 'N/A'} years</td></tr>
            <tr><th>Gender:</th><td>${data.sex || 'N/A'}</td></tr>
            <tr><th>Blood Group:</th><td>${data.blood_group || 'N/A'}</td></tr>
            <tr><th>Mobile:</th><td>${data.mobile_number || 'N/A'}</td></tr>
            <tr><th>Email:</th><td>${data.email || 'N/A'}</td></tr>
            <tr><th>Address:</th><td>${data.address || 'N/A'}</td></tr>
            <tr><th>Emergency Contact:</th><td>${data.emergency_contact || 'N/A'}</td></tr>
            <tr><th>Father/Husband:</th><td>${data.father_husband_name || 'N/A'}</td></tr>
            <tr><th>Occupation:</th><td>${data.occupation || 'N/A'}</td></tr>
            <tr><th>Medical History:</th><td>${data.medical_history || 'N/A'}</td></tr>
            <tr><th>Allergies:</th><td>${data.allergies || 'N/A'}</td></tr>
            <tr><th>Notes:</th><td>${data.notes || 'N/A'}</td></tr>
            <tr><th>Status:</th><td>${data.status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'}</td></tr>
        `;
        $('#patientDetails').html(detailsHtml);
    }

    function updateBulkActionsVisibility() {
        var selectedCount = $('.row-checkbox:checked').length;
        $('#selectedCount').text(selectedCount);
        
        if (selectedCount > 0) {
            $('#bulkActions').show();
        } else {
            $('#bulkActions').hide();
        }
    }

    function showLoading() {
        $('#loadingOverlay').show();
    }

    function hideLoading() {
        $('#loadingOverlay').hide();
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Bulk actions
    $('#bulkDelete').click(function() {
        var selectedIds = $('.row-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            Swal.fire('Warning', 'Please select patients to delete', 'warning');
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: `You want to delete ${selectedIds.length} selected patients?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                
                $.ajax({
                    url: "{{ route('admin.patients.bulk-delete') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        ids: selectedIds
                    },
                    success: function(response) {
                        hideLoading();
                        table.ajax.reload();
                        $('#selectAll').prop('checked', false);
                        updateBulkActionsVisibility();
                        Swal.fire('Deleted!', response.message || 'Patients deleted successfully', 'success');
                    },
                    error: function() {
                        hideLoading();
                        Swal.fire('Error!', 'Error deleting patients', 'error');
                    }
                });
            }
        });
    });

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush
