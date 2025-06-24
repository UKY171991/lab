@extends('admin.layouts.app')

@section('title', 'Medical Report - ' . $report->report_number)
@section('page-title', 'Medical Report')
@section('breadcrumb', 'Reports / View')

@push('styles')
<style>
    .medical-report {
        background: white;
        margin: 20px auto;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border-radius: 15px;
        overflow: hidden;
    }
    
    .report-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        position: relative;
    }
    
    .report-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="2"/><path d="M30 50 L45 65 L70 35" stroke="rgba(255,255,255,0.2)" stroke-width="3" fill="none"/></svg>') no-repeat center;
        background-size: 60px;
        opacity: 0.3;
    }
    
    .lab-info {
        text-align: center;
        margin-bottom: 20px;
    }
    
    .lab-name {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .lab-tagline {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 10px;
    }
    
    .lab-contact {
        font-size: 0.9rem;
        opacity: 0.8;
    }
    
    .report-info-section {
        padding: 30px;
        background: #f8fafc;
    }
    
    .patient-doctor-info {
        background: white;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }
    
    .info-row {
        display: flex;
        margin-bottom: 12px;
        align-items: center;
    }
    
    .info-label {
        font-weight: 600;
        color: #374151;
        min-width: 140px;
        display: flex;
        align-items: center;
    }
    
    .info-value {
        color: #1f2937;
        flex: 1;
    }
    
    .section-title {
        font-size: 1.3rem;
        font-weight: bold;
        color: #374151;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e5e7eb;
        display: flex;
        align-items: center;
    }
    
    .tests-table {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }
    
    .tests-table table {
        margin: 0;
    }
    
    .tests-table th {
        background: linear-gradient(135deg, #374151 0%, #4b5563 100%);
        color: white;
        padding: 15px;
        font-weight: 600;
        border: none;
        text-align: center;
    }
    
    .tests-table td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .test-name {
        font-weight: 600;
        color: #374151;
    }
    
    .test-result {
        font-weight: bold;
        font-size: 1.1rem;
    }
    
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-normal {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-high {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .status-low {
        background: #fef3c7;
        color: #92400e;
    }
    
    .status-critical {
        background: #f3e8ff;
        color: #581c87;
    }
    
    .report-footer {
        padding: 30px;
        background: white;
        border-top: 1px solid #e5e7eb;
    }
    
    .signature-section {
        display: flex;
        justify-content: space-between;
        margin-top: 40px;
    }
    
    .signature-box {
        text-align: center;
        flex: 1;
        margin: 0 20px;
    }
    
    .signature-line {
        border-top: 2px solid #374151;
        margin-bottom: 8px;
        margin-top: 40px;
    }
    
    .signature-title {
        font-weight: 600;
        color: #374151;
    }
    
    .signature-name {
        color: #6b7280;
        font-size: 0.9rem;
    }
    
    .print-button {
        position: fixed;
        top: 100px;
        right: 20px;
        z-index: 1000;
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 50px;
        padding: 15px 25px;
        color: white;
        font-weight: 600;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        transition: all 0.3s ease;
    }
    
    .print-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        color: white;
    }
    
    @media print {
        .print-button,
        .main-header,
        .main-sidebar {
            display: none !important;
        }
        
        .content-wrapper {
            margin: 0 !important;
            padding: 0 !important;
        }
        
        .medical-report {
            box-shadow: none;
            border-radius: 0;
            margin: 0;
        }
    }
    
    .reference-range {
        font-size: 0.85rem;
        color: #6b7280;
        font-style: italic;
    }
    
    .test-unit {
        font-size: 0.9rem;
        color: #6b7280;
        margin-left: 5px;
    }
    
    .abnormal-result {
        background: rgba(239, 68, 68, 0.1);
    }
    
    .critical-result {
        background: rgba(139, 69, 19, 0.1);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Print Button -->
    <button class="btn print-button" onclick="window.print()">
        <i class="fas fa-print mr-2"></i>Print Report
    </button>
    
    <!-- Back Button -->
    <div class="mb-3">
        <a href="{{ route('admin.reports') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Reports
        </a>
    </div>

    <!-- Medical Report -->
    <div class="medical-report">        <!-- Report Header -->
        <div class="report-header">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <div style="background: rgba(255,255,255,0.15); border-radius: 15px; padding: 20px; display: inline-block;">
                        <i class="fas fa-hospital" style="font-size: 3rem; color: rgba(255,255,255,0.9);"></i>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="lab-name">{{ config('app.name', 'MEDILAB DIAGNOSTICS') }}</div>
                    <div class="lab-tagline">Advanced Clinical Laboratory & Diagnostic Services</div>
                    <div class="lab-contact">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <i class="fas fa-map-marker-alt mr-2"></i>123 Medical Center Drive, Health City, HC 12345
                            </div>
                            <div class="col-md-6">
                                <i class="fas fa-phone mr-2"></i>+1 (555) 123-4567 | <i class="fas fa-envelope mr-2"></i>info@medlab.com
                            </div>
                        </div>
                        <div class="mt-2">
                            <small><i class="fas fa-certificate mr-2"></i>NABL Accredited | ISO 15189:2012 Certified</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-right">
                    <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 15px;">
                        <div style="font-size: 1.4rem; font-weight: bold; margin-bottom: 5px;">{{ $report->report_number }}</div>
                        <div style="font-size: 0.9rem; opacity: 0.8;">Report ID</div>
                        <div style="font-size: 0.8rem; opacity: 0.7; margin-top: 10px;">
                            Generated: {{ now()->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <h3 style="margin: 0; letter-spacing: 1px; text-transform: uppercase;">
                    <i class="fas fa-file-medical-alt mr-2"></i>LABORATORY INVESTIGATION REPORT
                </h3>
            </div>
        </div>        <!-- Patient & Doctor Information -->
        <div class="report-info-section">
            <div class="row">
                <div class="col-md-6">
                    <div class="patient-doctor-info">
                        <div class="section-title">
                            <i class="fas fa-user-injured mr-2" style="color: #3b82f6;"></i>PATIENT DETAILS
                        </div>
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <tr>
                                    <td style="width: 30%; font-weight: 600; color: #374151;">Patient Name:</td>
                                    <td style="font-weight: 500;">{{ strtoupper($report->patient->name) }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #374151;">Patient ID:</td>
                                    <td style="font-weight: 500;">{{ $report->patient->id ?? 'P' . str_pad($report->patient->id, 6, '0', STR_PAD_LEFT) }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #374151;">Age/Gender:</td>
                                    <td style="font-weight: 500;">{{ $report->patient->age ?? 'Not Specified' }} Years / {{ strtoupper($report->patient->gender ?? 'Not Specified') }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #374151;">Contact:</td>
                                    <td style="font-weight: 500;">{{ $report->patient->phone }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #374151;">Email:</td>
                                    <td style="font-weight: 500; word-break: break-all;">{{ $report->patient->email }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="patient-doctor-info">
                        <div class="section-title">
                            <i class="fas fa-user-md mr-2" style="color: #059669;"></i>REFERRING PHYSICIAN
                        </div>
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <tr>
                                    <td style="width: 30%; font-weight: 600; color: #374151;">Doctor Name:</td>
                                    <td style="font-weight: 500;">Dr. {{ strtoupper($report->doctor->name) }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #374151;">Specialization:</td>
                                    <td style="font-weight: 500;">{{ $report->doctor->specialization ?? 'General Medicine' }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #374151;">Registration:</td>
                                    <td style="font-weight: 500;">{{ $report->doctor->registration_no ?? 'REG' . str_pad($report->doctor->id, 6, '0', STR_PAD_LEFT) }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #374151;">Contact:</td>
                                    <td style="font-weight: 500;">{{ $report->doctor->phone }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #374151;">Email:</td>
                                    <td style="font-weight: 500; word-break: break-all;">{{ $report->doctor->email }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sample & Report Information -->
            <div class="patient-doctor-info">
                <div class="section-title">
                    <i class="fas fa-flask mr-2" style="color: #dc2626;"></i>SAMPLE & REPORT INFORMATION
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td style="font-weight: 600; color: #374151;">Sample Type:</td>
                                <td style="font-weight: 500;">{{ $report->sample_type ?? 'Blood' }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600; color: #374151;">Collection Date:</td>
                                <td style="font-weight: 500;">{{ $report->sample_collection_date->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600; color: #374151;">Collection Time:</td>
                                <td style="font-weight: 500;">{{ $report->sample_collection_date->format('H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-3">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td style="font-weight: 600; color: #374151;">Received Date:</td>
                                <td style="font-weight: 500;">{{ $report->sample_collection_date->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600; color: #374151;">Report Date:</td>
                                <td style="font-weight: 500;">{{ $report->report_date->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600; color: #374151;">Report Time:</td>
                                <td style="font-weight: 500;">{{ $report->report_date->format('H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-3">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td style="font-weight: 600; color: #374151;">Report Status:</td>
                                <td>
                                    <span class="status-badge status-{{ $report->report_status }}">
                                        {{ strtoupper($report->report_status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600; color: #374151;">Payment Status:</td>
                                <td>
                                    <span class="status-badge status-{{ $report->payment_status }}">
                                        {{ strtoupper($report->payment_status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600; color: #374151;">Fasting Status:</td>
                                <td style="font-weight: 500;">{{ $report->fasting_status ?? 'Non-Fasting' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-3">
                        <div style="text-align: center; padding: 10px; background: #f8fafc; border-radius: 8px;">
                            <div style="font-size: 1.2rem; font-weight: bold; color: #1f2937;">URGENT</div>
                            <div style="font-size: 0.8rem; color: #6b7280;">Priority Status</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        <!-- Test Results -->
        <div style="padding: 0 30px;">
            <div class="section-title">
                <i class="fas fa-microscope mr-2" style="color: #7c3aed;"></i>LABORATORY INVESTIGATION RESULTS
            </div>
            
            <div class="tests-table">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 5%;" class="text-center">S.No</th>
                            <th style="width: 35%;">INVESTIGATION</th>
                            <th style="width: 15%;" class="text-center">RESULT</th>
                            <th style="width: 20%;" class="text-center">REFERENCE RANGE</th>
                            <th style="width: 10%;" class="text-center">UNIT</th>
                            <th style="width: 15%;" class="text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report->reportTests as $index => $reportTest)
                        <tr class="{{ in_array($reportTest->status, ['high', 'low']) ? 'abnormal-result' : '' }} {{ $reportTest->status === 'critical' ? 'critical-result' : '' }}">
                            <td class="text-center" style="font-weight: 600;">{{ $index + 1 }}</td>
                            <td>
                                <div class="test-name" style="font-weight: 600; color: #1f2937;">{{ strtoupper($reportTest->test->name) }}</div>
                                @if($reportTest->test->description)
                                <div style="font-size: 0.75rem; color: #6b7280; font-style: italic;">{{ $reportTest->test->description }}</div>
                                @endif
                                @if($reportTest->test->testCategory)
                                <div style="font-size: 0.7rem; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px;">{{ $reportTest->test->testCategory->name }}</div>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="test-result {{ $reportTest->status !== 'normal' ? 'text-danger' : 'text-success' }}" style="font-weight: bold; font-size: 1.1rem;">
                                    {{ $reportTest->result_value }}
                                    @if($reportTest->status !== 'normal')
                                        @if($reportTest->status === 'high')
                                            <i class="fas fa-arrow-up text-danger ml-1"></i>
                                        @elseif($reportTest->status === 'low')
                                            <i class="fas fa-arrow-down text-warning ml-1"></i>
                                        @elseif($reportTest->status === 'critical')
                                            <i class="fas fa-exclamation-triangle text-danger ml-1"></i>
                                        @endif
                                    @endif
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="reference-range" style="font-weight: 500;">{{ $reportTest->reference_range }}</span>
                            </td>
                            <td class="text-center">
                                <span class="test-unit" style="font-weight: 500;">{{ $reportTest->unit ?? '-' }}</span>
                            </td>
                            <td class="text-center">
                                <span class="status-badge status-{{ $reportTest->status }}" style="font-size: 0.75rem; padding: 4px 8px;">
                                    {{ strtoupper($reportTest->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <!-- Test Summary -->
                <div style="background: #f8fafc; padding: 15px; border-top: 2px solid #e5e7eb;">
                    <div class="row">
                        <div class="col-md-8">
                            <small style="color: #6b7280; font-weight: 500;">
                                <i class="fas fa-info-circle mr-1"></i>
                                Total Tests: {{ $report->reportTests->count() }} | 
                                Normal: {{ $report->reportTests->where('status', 'normal')->count() }} | 
                                Abnormal: {{ $report->reportTests->whereIn('status', ['high', 'low'])->count() }} | 
                                Critical: {{ $report->reportTests->where('status', 'critical')->count() }}
                            </small>
                        </div>
                        <div class="col-md-4 text-right">
                            <small style="color: #6b7280; font-weight: 500;">
                                <i class="fas fa-clock mr-1"></i>Processing Time: {{ $report->sample_collection_date->diffInHours($report->report_date) }} hours
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        @if($report->comments)
        <div style="padding: 30px;">
            <div class="section-title">
                <i class="fas fa-comment-medical mr-2"></i>Clinical Comments
            </div>
            <div style="background: #f8fafc; padding: 20px; border-radius: 10px; border-left: 4px solid #667eea;">
                <p style="margin: 0; line-height: 1.6;">{{ $report->comments }}</p>
            </div>
        </div>
        @endif

        <!-- Report Footer -->
        <div class="report-footer">
            <div class="row">
                <div class="col-md-8">
                    <div style="background: #eff6ff; padding: 20px; border-radius: 10px; border-left: 4px solid #3b82f6;">
                        <h6 style="color: #1e40af; font-weight: bold; margin-bottom: 10px;">
                            <i class="fas fa-info-circle mr-2"></i>Important Notes
                        </h6>
                        <ul style="margin: 0; padding-left: 20px; color: #374151;">
                            <li>These results should be interpreted by a qualified physician.</li>
                            <li>Reference ranges may vary based on laboratory methodology and patient demographics.</li>
                            <li>Please consult your healthcare provider for proper interpretation.</li>
                            <li>For any queries, contact our laboratory at the above mentioned contact details.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="background: #f0fdf4; padding: 20px; border-radius: 10px; border-left: 4px solid #22c55e;">
                        <h6 style="color: #166534; font-weight: bold; margin-bottom: 15px;">
                            <i class="fas fa-dollar-sign mr-2"></i>Payment Summary
                        </h6>
                        <div class="info-row" style="margin-bottom: 8px;">
                            <span style="font-weight: 600;">Total Amount:</span>
                            <span style="float: right;">${{ number_format($report->total_amount, 2) }}</span>
                        </div>
                        <div class="info-row" style="margin-bottom: 8px;">
                            <span style="font-weight: 600;">Discount:</span>
                            <span style="float: right;">-${{ number_format($report->discount, 2) }}</span>
                        </div>
                        <hr style="margin: 10px 0;">
                        <div class="info-row" style="font-weight: bold; font-size: 1.1rem;">
                            <span>Final Amount:</span>
                            <span style="float: right;">${{ number_format($report->final_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Signatures -->
            <div class="signature-section">
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-title">Laboratory Technician</div>
                    <div class="signature-name">{{ $report->technician_name ?? 'Lab Technician' }}</div>
                </div>
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-title">Pathologist</div>
                    <div class="signature-name">{{ $report->pathologist_name ?? 'Dr. Pathologist' }}</div>
                </div>
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-title">Report Generated</div>
                    <div class="signature-name">{{ now()->format('M d, Y h:i A') }}</div>
                </div>
            </div>

            <!-- Lab Certification -->
            <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                <p style="margin: 0; color: #6b7280; font-size: 0.85rem;">
                    This laboratory is accredited by CAP and CLIA | License No: LAB123456789
                    <br>This report is electronically generated and does not require a signature.
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto-focus print functionality
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key === 'p') {
        e.preventDefault();
        window.print();
    }
});

// Show success message if coming from form submission
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session("success") }}',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
        toast: true,
        position: 'top-end'
    });
@endif
</script>
@endpush
@endsection
