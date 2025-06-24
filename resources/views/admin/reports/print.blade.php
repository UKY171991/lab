<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Report - {{ $report->report_number }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @page {
            size: A4;
            margin: 0.5in;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.3;
            color: #000;
        }
        
        .report-container {
            max-width: 100%;
            margin: 0 auto;
            background: white;
        }
        
        .report-header {
            border: 2px solid #000;
            padding: 15px;
            margin-bottom: 15px;
            background: #f8f9fa;
        }
        
        .lab-name {
            font-size: 20px;
            font-weight: bold;
            color: #000;
            text-align: center;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }
        
        .lab-tagline {
            font-size: 12px;
            color: #000;
            text-align: center;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .lab-contact {
            font-size: 9px;
            color: #000;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        
        .report-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin: 15px 0;
            text-decoration: underline;
            letter-spacing: 1px;
        }
        
        .info-section {
            margin-bottom: 15px;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 10px;
        }
        
        .info-table td {
            padding: 4px 8px;
            border: 1px solid #000;
            vertical-align: top;
        }
        
        .info-label {
            font-weight: bold;
            background-color: #f0f0f0;
            width: 25%;
        }
        
        .patient-info {
            width: 48%;
            float: left;
            margin-right: 2%;
        }
        
        .doctor-info {
            width: 48%;
            float: right;
            margin-left: 2%;
        }
        
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
        
        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 10px;
        }
        
        .results-table th {
            background-color: #000;
            color: white;
            padding: 8px 5px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #000;
            font-size: 9px;
        }
        
        .results-table td {
            padding: 6px 5px;
            border: 1px solid #000;
            vertical-align: middle;
            text-align: center;
        }
        
        .test-name {
            text-align: left !important;
            font-weight: 600;
        }
        
        .abnormal {
            background-color: #ffebee !important;
            font-weight: bold;
        }
        
        .critical {
            background-color: #f3e5f5 !important;
            font-weight: bold;
        }
        
        .status-normal {
            color: #2e7d32;
            font-weight: bold;
        }
        
        .status-high {
            color: #d32f2f;
            font-weight: bold;
        }
        
        .status-low {
            color: #f57c00;
            font-weight: bold;
        }
        
        .status-critical {
            color: #7b1fa2;
            font-weight: bold;
        }
        
        .comments-section {
            margin: 15px 0;
            border: 1px solid #000;
            padding: 10px;
            background: #f9f9f9;
        }
        
        .signature-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }
        
        .signature-box {
            width: 30%;
            float: left;
            text-align: center;
            margin: 0 1.5%;
        }
        
        .signature-line {
            border-top: 1px solid #000;
            margin: 40px 0 5px 0;
        }
        
        .footer-info {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .reference-range {
            font-size: 8px;
            color: #666;
        }
        
        .report-number-box {
            float: right;
            border: 2px solid #000;
            padding: 10px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="report-container">
        <!-- Report Header -->
        <div class="report-header">
            <div class="row">
                <div class="col-md-9">
                    <div class="lab-name">{{ strtoupper(config('app.name', 'MEDILAB DIAGNOSTICS')) }}</div>
                    <div class="lab-tagline">ADVANCED CLINICAL LABORATORY & DIAGNOSTIC SERVICES</div>
                    <div class="lab-contact">
                        📍 123 Medical Center Drive, Health City, HC 12345 | 📞 +1 (555) 123-4567 | 📧 info@medlab.com<br>
                        🏥 NABL Accredited | ISO 15189:2012 Certified | License No: LAB123456789
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="report-number-box">
                        <div style="font-weight: bold; font-size: 12px;">{{ $report->report_number }}</div>
                        <div style="font-size: 8px;">REPORT ID</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="report-title">LABORATORY INVESTIGATION REPORT</div>

        <!-- Patient and Doctor Information -->
        <div class="info-section clearfix">
            <div class="patient-info">
                <table class="info-table">
                    <tr>
                        <td colspan="2" style="background: #000; color: white; text-align: center; font-weight: bold;">PATIENT DETAILS</td>
                    </tr>
                    <tr>
                        <td class="info-label">Patient Name</td>
                        <td>{{ strtoupper($report->patient->name) }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Patient ID</td>
                        <td>{{ 'P' . str_pad($report->patient->id, 6, '0', STR_PAD_LEFT) }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Age / Gender</td>
                        <td>{{ $report->patient->age ?? 'NS' }} Years / {{ strtoupper($report->patient->gender ?? 'NS') }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Contact</td>
                        <td>{{ $report->patient->phone }}</td>
                    </tr>
                </table>
            </div>
            
            <div class="doctor-info">
                <table class="info-table">
                    <tr>
                        <td colspan="2" style="background: #000; color: white; text-align: center; font-weight: bold;">REFERRING PHYSICIAN</td>
                    </tr>
                    <tr>
                        <td class="info-label">Doctor Name</td>
                        <td>Dr. {{ strtoupper($report->doctor->name) }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Specialization</td>
                        <td>{{ $report->doctor->specialization ?? 'General Medicine' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Registration</td>
                        <td>{{ $report->doctor->registration_no ?? 'REG' . str_pad($report->doctor->id, 6, '0', STR_PAD_LEFT) }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Contact</td>
                        <td>{{ $report->doctor->phone }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Sample Information -->
        <div class="info-section">
            <table class="info-table">
                <tr>
                    <td colspan="8" style="background: #000; color: white; text-align: center; font-weight: bold;">SAMPLE & REPORT INFORMATION</td>
                </tr>
                <tr>
                    <td class="info-label">Sample Type</td>
                    <td>{{ $report->sample_type ?? 'Blood' }}</td>
                    <td class="info-label">Collection Date</td>
                    <td>{{ $report->sample_collection_date->format('d/m/Y') }}</td>
                    <td class="info-label">Collection Time</td>
                    <td>{{ $report->sample_collection_date->format('H:i') }}</td>
                    <td class="info-label">Report Date</td>
                    <td>{{ $report->report_date->format('d/m/Y H:i') }}</td>
                </tr>
            </table>        </div>

        <!-- Test Results -->
        <div class="info-section">
            <table class="results-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">S.No</th>
                        <th style="width: 35%;">INVESTIGATION</th>
                        <th style="width: 15%;">RESULT</th>
                        <th style="width: 20%;">REFERENCE RANGE</th>
                        <th style="width: 10%;">UNIT</th>
                        <th style="width: 15%;">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($report->reportTests as $index => $reportTest)
                    <tr class="{{ in_array($reportTest->status, ['high', 'low']) ? 'abnormal' : '' }} {{ $reportTest->status === 'critical' ? 'critical' : '' }}">
                        <td>{{ $index + 1 }}</td>
                        <td class="test-name">
                            <strong>{{ strtoupper($reportTest->test->name) }}</strong>
                            @if($reportTest->test->description)
                            <br><small style="font-size: 8px; font-weight: normal; color: #666;">{{ $reportTest->test->description }}</small>
                            @endif
                        </td>
                        <td style="font-weight: bold; text-align: center;">
                            {{ $reportTest->result_value }}
                            @if($reportTest->status === 'high')
                                ↑
                            @elseif($reportTest->status === 'low')
                                ↓
                            @elseif($reportTest->status === 'critical')
                                ⚠
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <span class="reference-range">{{ $reportTest->reference_range }}</span>
                        </td>
                        <td style="text-align: center;">{{ $reportTest->unit ?? '-' }}</td>
                        <td style="text-align: center;">
                            <span class="status-{{ $reportTest->status }}">{{ strtoupper($reportTest->status) }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Comments Section -->
        @if($report->comments)
        <div class="comments-section">
            <div style="font-weight: bold; margin-bottom: 8px; text-decoration: underline;">CLINICAL COMMENTS:</div>
            <p style="margin: 0; text-align: justify;">{{ $report->comments }}</p>
        </div>
        @endif

        <!-- Important Notes -->
        <div style="background: #f8f9fa; border: 1px solid #dee2e6; padding: 10px; margin: 15px 0; font-size: 9px;">
            <div style="font-weight: bold; margin-bottom: 5px;">IMPORTANT NOTES:</div>
            <ul style="margin: 0; padding-left: 15px;">
                <li>These results should be interpreted by a qualified physician.</li>
                <li>Reference ranges may vary based on laboratory methodology.</li>
                <li>Please consult your healthcare provider for proper interpretation.</li>
                <li>For any queries, contact our laboratory at the above contact details.</li>
            </ul>
        </div>

        <!-- Payment Summary -->
        <div style="float: right; width: 250px; border: 1px solid #000; padding: 10px; margin: 15px 0;">
            <div style="font-weight: bold; text-align: center; margin-bottom: 8px; text-decoration: underline;">PAYMENT SUMMARY</div>
            <table style="width: 100%; font-size: 10px;">
                <tr>
                    <td style="padding: 2px;">Total Amount:</td>
                    <td style="text-align: right; padding: 2px;">${{ number_format($report->total_amount, 2) }}</td>
                </tr>
                <tr>
                    <td style="padding: 2px;">Discount:</td>
                    <td style="text-align: right; padding: 2px;">-${{ number_format($report->discount, 2) }}</td>
                </tr>
                <tr style="border-top: 1px solid #000;">
                    <td style="padding: 2px; font-weight: bold;">Final Amount:</td>
                    <td style="text-align: right; padding: 2px; font-weight: bold;">${{ number_format($report->final_amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="clearfix"></div>

        <!-- Signatures -->
        <div class="signature-section clearfix">
            <div class="signature-box">
                <div class="signature-line"></div>
                <div style="font-weight: bold; font-size: 10px;">Laboratory Technician</div>
                <div style="font-size: 9px;">{{ $report->technician_name ?? 'Lab Technician' }}</div>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <div style="font-weight: bold; font-size: 10px;">Pathologist</div>
                <div style="font-size: 9px;">{{ $report->pathologist_name ?? 'Dr. Pathologist' }}</div>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <div style="font-weight: bold; font-size: 10px;">Authorized Signatory</div>
                <div style="font-size: 9px;">Laboratory Director</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-info">
            <p style="margin: 5px 0;">This laboratory is accredited by CAP and CLIA | License No: LAB123456789</p>
            <p style="margin: 5px 0;">This report is electronically generated and does not require a signature.</p>
            <p style="margin: 5px 0;">Report generated on: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
            body { print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="watermark">{{ config('app.name') }}</div>
    
    <div class="report-container">
        <!-- Print Button (hidden when printing) -->
        <div class="no-print" style="text-align: right; margin-bottom: 20px;">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Print Report
            </button>
            <button onclick="window.close()" class="btn btn-secondary ml-2">
                <i class="fas fa-times"></i> Close
            </button>
        </div>

        <!-- Report Header -->
        <div class="report-header">
            <div class="lab-name">{{ config('app.name', 'MEDICAL LABORATORY') }}</div>
            <div class="lab-tagline">Advanced Diagnostic & Pathology Services</div>
            <div class="lab-contact">
                Email: info@medlab.com | Phone: +1 (555) 123-4567 | Address: 123 Medical Center Dr, Health City, HC 12345
            </div>
            <div style="margin-top: 15px;">
                <strong>NABL Accredited | CAP Certified | ISO 15189:2012</strong>
            </div>
        </div>

        <!-- Report Title -->
        <div class="report-title">LABORATORY INVESTIGATION REPORT</div>

        <!-- Report Number and Date -->
        <table class="info-table">
            <tr>
                <td class="info-label">Report No:</td>
                <td><strong>{{ $report->report_number }}</strong></td>
                <td class="info-label">Report Date:</td>
                <td><strong>{{ $report->report_date->format('d-M-Y h:i A') }}</strong></td>
            </tr>
            <tr>
                <td class="info-label">Collection Date:</td>
                <td><strong>{{ $report->sample_collection_date->format('d-M-Y h:i A') }}</strong></td>
                <td class="info-label">Status:</td>
                <td><strong>{{ strtoupper($report->report_status) }}</strong></td>
            </tr>
        </table>

        <!-- Patient Information -->
        <div class="info-section">
            <h4 style="background-color: #ecf0f1; padding: 8px; margin: 0; font-size: 14px;">PATIENT INFORMATION</h4>
            <table class="info-table">
                <tr>
                    <td class="info-label">Patient Name:</td>
                    <td><strong>{{ strtoupper($report->patient->name) }}</strong></td>
                    <td class="info-label">Age/Gender:</td>
                    <td><strong>{{ $report->patient->age ?? 'N/A' }} / {{ strtoupper($report->patient->gender ?? 'N/A') }}</strong></td>
                </tr>
                <tr>
                    <td class="info-label">Phone:</td>
                    <td>{{ $report->patient->phone }}</td>
                    <td class="info-label">Email:</td>
                    <td>{{ $report->patient->email }}</td>
                </tr>
                @if($report->patient->address)
                <tr>
                    <td class="info-label">Address:</td>
                    <td colspan="3">{{ $report->patient->address }}</td>
                </tr>
                @endif
            </table>
        </div>

        <!-- Doctor Information -->
        <div class="info-section">
            <h4 style="background-color: #ecf0f1; padding: 8px; margin: 0; font-size: 14px;">REFERRING PHYSICIAN</h4>
            <table class="info-table">
                <tr>
                    <td class="info-label">Doctor Name:</td>
                    <td><strong>Dr. {{ strtoupper($report->doctor->name) }}</strong></td>
                    <td class="info-label">Specialization:</td>
                    <td><strong>{{ strtoupper($report->doctor->specialization ?? 'GENERAL MEDICINE') }}</strong></td>
                </tr>
                <tr>
                    <td class="info-label">Phone:</td>
                    <td>{{ $report->doctor->phone }}</td>
                    <td class="info-label">Email:</td>
                    <td>{{ $report->doctor->email }}</td>
                </tr>
            </table>
        </div>

        <!-- Test Results -->
        <div class="info-section">
            <h4 style="background-color: #ecf0f1; padding: 8px; margin: 0; font-size: 14px;">INVESTIGATION RESULTS</h4>
            <table class="results-table">
                <thead>
                    <tr>
                        <th style="width: 35%;">INVESTIGATION</th>
                        <th style="width: 20%;">RESULT</th>
                        <th style="width: 20%;">REFERENCE VALUES</th>
                        <th style="width: 15%;">UNIT</th>
                        <th style="width: 10%;">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($report->reportTests as $reportTest)
                    <tr class="{{ $reportTest->status !== 'normal' ? ($reportTest->status === 'critical' ? 'critical' : 'abnormal') : '' }}">
                        <td class="test-name">{{ strtoupper($reportTest->test->name) }}</td>
                        <td><strong>{{ $reportTest->result_value }}</strong></td>
                        <td>{{ $reportTest->reference_range }}</td>
                        <td>{{ $reportTest->unit ?? '-' }}</td>
                        <td class="status-{{ $reportTest->status }}">
                            <strong>{{ strtoupper($reportTest->status) }}</strong>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Comments -->
        @if($report->comments)
        <div class="info-section">
            <h4 style="background-color: #ecf0f1; padding: 8px; margin: 0; font-size: 14px;">CLINICAL INTERPRETATION</h4>
            <div style="border: 1px solid #bdc3c7; padding: 15px; margin-top: 0;">
                {{ $report->comments }}
            </div>
        </div>
        @endif

        <!-- Payment Information -->
        <div class="info-section">
            <h4 style="background-color: #ecf0f1; padding: 8px; margin: 0; font-size: 14px;">BILLING INFORMATION</h4>
            <table class="info-table">
                <tr>
                    <td class="info-label">Total Amount:</td>
                    <td><strong>${{ number_format($report->total_amount, 2) }}</strong></td>
                    <td class="info-label">Discount:</td>
                    <td><strong>${{ number_format($report->discount, 2) }}</strong></td>
                </tr>
                <tr>
                    <td class="info-label">Final Amount:</td>
                    <td><strong>${{ number_format($report->final_amount, 2) }}</strong></td>
                    <td class="info-label">Payment Status:</td>
                    <td><strong>{{ strtoupper($report->payment_status) }}</strong></td>
                </tr>
            </table>
        </div>

        <!-- Important Notes -->
        <div style="border: 2px solid #e74c3c; padding: 10px; margin: 20px 0; background-color: #ffebee;">
            <h5 style="color: #c62828; margin: 0 0 10px 0; font-size: 12px;"><i class="fas fa-exclamation-triangle"></i> IMPORTANT NOTES:</h5>
            <ul style="margin: 0; padding-left: 20px; font-size: 10px;">
                <li>This report should be interpreted in correlation with clinical findings.</li>
                <li>Reference ranges may vary with age, sex, and methodology used.</li>
                <li>Values marked as HIGH or LOW are outside the reference range.</li>
                <li>CRITICAL values require immediate medical attention.</li>
                <li>Please consult your physician for proper interpretation of results.</li>
            </ul>
        </div>

        <!-- Signatures -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line"></div>
                <div style="font-weight: bold;">Lab Technician</div>
                <div>{{ $report->technician_name ?? 'Lab Tech.' }}</div>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <div style="font-weight: bold;">Pathologist</div>
                <div>{{ $report->pathologist_name ?? 'Dr. Pathologist' }}</div>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <div style="font-weight: bold;">Report Verified</div>
                <div>{{ now()->format('d-M-Y h:i A') }}</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-note">
            <p><strong>{{ config('app.name') }}</strong> - Quality Healthcare Solutions</p>
            <p>This is a computer-generated report and does not require a physical signature.</p>
            <p>Laboratory License: LAB123456789 | NABL Certificate: TC-1234 | Valid until: Dec 2025</p>
        </div>
    </div>

    <script>
        // Auto-print when opened in new window
        window.onload = function() {
            // Uncomment the line below if you want auto-print
            // window.print();
        };
        
        // Keyboard shortcut for printing
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });
    </script>
</body>
</html>
