   
<!-- Removed inline script: moved to /js/patients-enhanced.js -->
@extends('admin.layouts.app')

@section('title', 'Patient Management')
@section('page-title', 'Patient Management')
@section('breadcrumb', 'Master / Patients')

@push('styles')
<!-- DataTables & plugins -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.bootstrap4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<!-- Custom CSS -->
<link rel="stylesheet" href="/css/patients-enhanced.css">
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
    <div class="search-filters shadow-sm p-4 bg-white rounded-4 mb-4 border border-light" style="box-shadow:0 4px 24px 0 rgba(60,72,100,.08);">
        <form id="filterForm" class="row g-3 align-items-end" onsubmit="return false;">
            <div class="col-12 col-md-4 mb-2 mb-md-0">
                <label for="searchPatients" class="form-label fw-semibold text-secondary mb-2">Search Patients</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-white border-0 pe-1"><i class="fas fa-search text-primary"></i></span>
                    <input type="text" class="form-control border-0 bg-light rounded-pill ps-2" id="searchPatients" name="search" placeholder="Search by name, phone, or email..." style="height:48px;">
                </div>
            </div>
            <!-- Gender and Age Range filters removed as requested -->
            <div class="col-12 col-md-4 d-flex gap-2 justify-content-end align-items-center mt-2 mt-md-0">
                <button type="button" class="btn btn-primary px-4 py-2 rounded-pill fw-bold d-flex align-items-center" id="applyFilters">
                    <i class="fas fa-filter me-2"></i>Apply
                </button>
                <button type="button" class="btn btn-outline-secondary px-4 py-2 rounded-pill fw-bold d-flex align-items-center" id="clearFilters">
                    <i class="fas fa-times me-2"></i>Clear
                </button>
            </div>
        </form>
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
                            <!-- Photo column removed -->
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
                    
                    <!-- Patient Photo Upload removed -->

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
                    <div class="col-md-12">
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
<!-- Custom JS -->
<script>
    var patientsDataRoute = "{{ route('admin.patients.data') }}";
</script>
<script src="/js/patients-enhanced.js"></script>
@endpush
