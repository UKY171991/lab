@extends('admin.layouts.app')

@section('title', 'Result Entry')
@section('page-title', 'Result Entry')
@section('breadcrumb', 'Entry / Result Entry')

@section('styles')
<!-- Select2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css">

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
.stat-card.progress .icon { color: #f39c12; }
.stat-card.completed .icon { color: #27ae60; }
.stat-card.verified .icon { color: #3498db; }

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

.result-summary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 20px;
}

.test-result-item {
    background: #fff;
    border: 1px solid #e8ecef;
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.test-result-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: #667eea;
}

.test-result-item:hover {
    background: #f8f9ff;
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.1);
    border-color: #667eea;
}
.result-completed {
    border-left: 5px solid #28a745;
    background: #f8fff9;
}
.result-pending {
    border-left: 5px solid #ffc107;
    background: #fffdf5;
}
.result-abnormal {
    border-left: 5px solid #dc3545;
    background: #fff5f5;
}
.reference-range {
    font-size: 0.85em;
    color: #6c757d;
    font-style: italic;
}
.result-input {
    font-weight: bold;
    text-align: center;
    font-size: 1.1em;
}
.validation-error {
    border: 2px solid #dc3545 !important;
    background-color: #f8d7da !important;
}
.validation-warning {
    border: 2px solid #ffc107 !important;
    background-color: #fff3cd !important;
}
.validation-normal {
    border: 2px solid #28a745 !important;
    background-color: #d4edda !important;
}
.progress-tracker {
    background: #fff;
    border-radius: 10px;
    padding: 15px;
    border: 1px solid #dee2e6;
}
.sample-info-card {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 15px;
}
.quick-action-btn {
    transition: all 0.3s ease;
}
.quick-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Result Entry Form -->
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-flask mr-2"></i>Test Result Entry
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Patient & Sample Selection -->
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-search mr-2"></i>Sample Selection
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="sampleSearch">Search Sample <span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="sampleSearch" name="sample_id" required>
                                            <option value="">Search by Sample ID, Patient Name, or Mobile</option>
                                            <option value="1" data-patient="John Doe" data-mobile="9876543210" data-date="2025-06-24" data-tests="5">SAMPLE-2025-001 - John Doe (9876543210)</option>
                                            <option value="2" data-patient="Jane Smith" data-mobile="9876543211" data-date="2025-06-23" data-tests="3">SAMPLE-2025-002 - Jane Smith (9876543211)</option>
                                            <option value="3" data-patient="Mike Johnson" data-mobile="9876543212" data-date="2025-06-22" data-tests="7">SAMPLE-2025-003 - Mike Johnson (9876543212)</option>
                                            <option value="4" data-patient="Sarah Wilson" data-mobile="9876543213" data-date="2025-06-21" data-tests="4">SAMPLE-2025-004 - Sarah Wilson (9876543213)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="technician">Technician</label>
                                        <input type="text" class="form-control" id="technician" name="technician" value="Dr. Lab Tech" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="selectedSampleInfo" class="sample-info-card" style="display: none;">
                                <!-- Selected sample info will be displayed here -->
                            </div>
                        </div>
                    </div>

                    <!-- Test Results Entry -->
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit mr-2"></i>Enter Test Results
                            </h3>
                        </div>
                        <div class="card-body">
                            <div id="testResults">
                                <!-- Results will be loaded when sample is selected -->
                                <div class="text-center text-muted" style="padding: 60px 0;">
                                    <i class="fas fa-search fa-4x mb-3" style="color: #dee2e6;"></i>
                                    <h5>Please select a sample to load test results</h5>
                                    <p>Use the search box above to find a patient sample</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="button" class="btn btn-success btn-lg" id="saveResults" disabled>
                        <i class="fas fa-save mr-2"></i>Save Results
                    </button>
                    <button type="button" class="btn btn-warning btn-lg ml-2" id="saveAsDraft" disabled>
                        <i class="fas fa-edit mr-2"></i>Save as Draft
                    </button>
                    <button type="button" class="btn btn-info btn-lg ml-2" id="previewReport" disabled>
                        <i class="fas fa-eye mr-2"></i>Preview Report
                    </button>
                </div>
            </div>
        </div>

        <!-- Result Summary & Tools -->
        <div class="col-md-4">
            <!-- Result Summary -->
            <div class="result-summary">
                <h5 class="text-center mb-3">
                    <i class="fas fa-chart-line mr-2"></i>Result Summary
                </h5>
                <div class="text-center">
                    <h2 id="completionRate">0%</h2>
                    <small>Completion Rate</small>
                </div>
                <hr style="border-color: rgba(255,255,255,0.3);">
                <div class="row text-center">
                    <div class="col-4">
                        <h4 id="normalCount" class="text-success">0</h4>
                        <small>Normal</small>
                    </div>
                    <div class="col-4">
                        <h4 id="abnormalCount" class="text-danger">0</h4>
                        <small>Abnormal</small>
                    </div>
                    <div class="col-4">
                        <h4 id="pendingCount" class="text-warning">0</h4>
                        <small>Pending</small>
                    </div>
                </div>
            </div>

            <!-- Progress Tracker -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tasks mr-2"></i>Progress Tracker
                    </h3>
                </div>
                <div class="card-body">
                    <div class="progress-tracker">
                        <div class="progress mb-3" style="height: 25px;">
                            <div class="progress-bar bg-gradient-success progress-bar-striped" role="progressbar" style="width: 0%; font-size: 14px; font-weight: bold;" id="progressBar">
                                <span id="progressText">0%</span>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-6">
                                <small class="text-muted">Completed</small>
                                <div><strong id="completedTests" class="text-success" style="font-size: 1.5em;">0</strong></div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Total Tests</small>
                                <div><strong id="totalTests" class="text-info" style="font-size: 1.5em;">0</strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt mr-2"></i>Quick Actions
                    </h3>
                </div>
                <div class="card-body">
                    <button class="btn btn-outline-info btn-block mb-2 quick-action-btn" id="autoCalculate" disabled>
                        <i class="fas fa-calculator mr-2"></i>Auto Calculate
                    </button>
                    <button class="btn btn-outline-warning btn-block mb-2 quick-action-btn" id="flagAbnormal" disabled>
                        <i class="fas fa-flag mr-2"></i>Flag Abnormal
                    </button>
                    <button class="btn btn-outline-success btn-block mb-2 quick-action-btn" id="copyPrevious" disabled>
                        <i class="fas fa-copy mr-2"></i>Copy Previous
                    </button>
                    <button class="btn btn-outline-primary btn-block quick-action-btn" id="generateReport" disabled>
                        <i class="fas fa-file-medical mr-2"></i>Generate Report
                    </button>
                </div>
            </div>

            <!-- Reference Guide -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-book mr-2"></i>Reference Guide
                    </h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Normal Ranges:</strong><br>
                        <span class="badge badge-success mr-1">●</span> Within reference range<br>
                        <span class="badge badge-warning mr-1">●</span> Borderline values<br>
                        <span class="badge badge-danger mr-1">●</span> Outside normal range<br>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Units:</strong><br>
                        <small>mg/dL, g/dL, mEq/L, IU/L, K/μL</small>
                    </div>
                    
                    <div>
                        <strong>Quality Control:</strong><br>
                        <small>
                        • Verify all critical values<br>
                        • Check for dilution factors<br>
                        • Validate abnormal results<br>
                        • Review before finalizing
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    let currentSample = null;
    let testResults = [];

    // Initialize Select2
    $('#sampleSearch').select2({
        theme: 'bootstrap4',
        placeholder: 'Search by Sample ID, Patient Name, or Mobile',
        allowClear: true
    });

    // Sample selection handler
    $('#sampleSearch').on('select2:select', function (e) {
        var data = e.params.data;
        var element = $(data.element);
        
        currentSample = {
            id: data.id,
            text: data.text,
            patient: element.data('patient'),
            mobile: element.data('mobile'),
            date: element.data('date'),
            tests: element.data('tests')
        };
        
        loadSampleInfo(currentSample);
        loadTestResults(currentSample);
        enableButtons();
        Swal.fire({
            icon: 'success',
            title: 'Sample Loaded',
            text: 'Sample loaded: ' + currentSample.patient,
            timer: 2000,
            showConfirmButton: false
        });
    });

    // Clear selection
    $('#sampleSearch').on('select2:clear', function (e) {
        currentSample = null;
        $('#selectedSampleInfo').hide();
        clearTestResults();
        disableButtons();
        Swal.fire({
            icon: 'info',
            title: 'Selection Cleared',
            text: 'Sample selection cleared',
            timer: 1500,
            showConfirmButton: false
        });
    });

    // Event handlers
    $('#saveResults').click(function() {
        if (!validateResults()) {
            Swal.fire({
                icon: 'error',
                title: 'Incomplete Results',
                text: 'Please complete all required results'
            });
            return;
        }
        saveResults('final');
    });

    $('#saveAsDraft').click(function() {
        saveResults('draft');
    });

    $('#previewReport').click(function() {
        previewReport();
    });

    $('#autoCalculate').click(function() {
        autoCalculateResults();
    });

    $('#flagAbnormal').click(function() {
        flagAbnormalResults();
    });

    $('#copyPrevious').click(function() {
        copyPreviousResults();
    });

    $('#generateReport').click(function() {
        generateReport();
    });

    // Functions
    function loadSampleInfo(sample) {
        var infoHtml = `
            <div class="row">
                <div class="col-md-6">
                    <h6><i class="fas fa-vial mr-2"></i>Sample Information</h6>
                    <strong>Sample ID:</strong> SAMPLE-2025-00${sample.id}<br>
                    <strong>Patient:</strong> ${sample.patient}<br>
                    <strong>Mobile:</strong> ${sample.mobile}
                </div>
                <div class="col-md-6">
                    <h6><i class="fas fa-calendar mr-2"></i>Collection Details</h6>
                    <strong>Collection Date:</strong> ${sample.date}<br>
                    <strong>Tests Ordered:</strong> ${sample.tests}<br>
                    <strong>Status:</strong> <span class="badge badge-info">Processing</span>
                </div>
            </div>
        `;
        $('#selectedSampleInfo').html(infoHtml).slideDown();
    }

    function loadTestResults(sample) {
        // Demo test results based on sample
        var tests = getTestsBySample(sample.id);
        var resultsHtml = '';
        
        tests.forEach(function(test, index) {
            resultsHtml += `
                <div class="test-result-item result-pending" data-test-id="${test.id}">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <h6 class="mb-1">${test.name}</h6>
                            <small class="reference-range">Reference: ${test.range}</small>
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control result-input" 
                                   step="${test.step}" 
                                   min="${test.min}" 
                                   max="${test.max}" 
                                   placeholder="Enter result"
                                   data-min="${test.refMin}" 
                                   data-max="${test.refMax}"
                                   data-test-name="${test.name}">
                        </div>
                        <div class="col-md-2">
                            <span class="badge badge-secondary">${test.unit}</span>
                        </div>
                        <div class="col-md-3">
                            <span class="result-status badge badge-warning">Pending</span>
                        </div>
                    </div>
                </div>
            `;
        });

        $('#testResults').html(resultsHtml);
        $('#totalTests').text(tests.length);
        updateProgress();

        // Add input validation
        $('.result-input').on('input', function() {
            validateResult($(this));
            updateProgress();
        });
    }

    function getTestsBySample(sampleId) {
        var allTests = [
            {id: 1, name: 'Hemoglobin', range: '12.0-15.5 g/dL', unit: 'g/dL', step: '0.1', min: '5', max: '20', refMin: 12.0, refMax: 15.5},
            {id: 2, name: 'White Blood Cells', range: '4.0-11.0 K/μL', unit: 'K/μL', step: '0.1', min: '1', max: '25', refMin: 4.0, refMax: 11.0},
            {id: 3, name: 'Platelets', range: '150-450 K/μL', unit: 'K/μL', step: '1', min: '50', max: '800', refMin: 150, refMax: 450},
            {id: 4, name: 'Glucose', range: '70-100 mg/dL', unit: 'mg/dL', step: '1', min: '30', max: '500', refMin: 70, refMax: 100},
            {id: 5, name: 'Creatinine', range: '0.6-1.2 mg/dL', unit: 'mg/dL', step: '0.01', min: '0.1', max: '5.0', refMin: 0.6, refMax: 1.2},
            {id: 6, name: 'Total Cholesterol', range: '<200 mg/dL', unit: 'mg/dL', step: '1', min: '100', max: '400', refMin: 100, refMax: 200},
            {id: 7, name: 'HDL Cholesterol', range: '>40 mg/dL', unit: 'mg/dL', step: '1', min: '20', max: '100', refMin: 40, refMax: 80}
        ];
        
        // Return different number of tests based on sample
        if (sampleId == 1) return allTests.slice(0, 5);
        if (sampleId == 2) return allTests.slice(0, 3);
        if (sampleId == 3) return allTests;
        if (sampleId == 4) return allTests.slice(2, 6);
        return allTests.slice(0, 4);
    }

    function validateResult(input) {
        var value = parseFloat(input.val());
        var min = parseFloat(input.data('min'));
        var max = parseFloat(input.data('max'));
        var testName = input.data('test-name');
        var resultStatus = input.closest('.test-result-item').find('.result-status');
        var testItem = input.closest('.test-result-item');

        // Clear previous classes
        input.removeClass('validation-error validation-warning validation-normal');
        testItem.removeClass('result-abnormal result-completed result-pending');

        if (isNaN(value) || input.val() === '') {
            resultStatus.removeClass().addClass('result-status badge badge-warning').text('Pending');
            testItem.addClass('result-pending');
            return false;
        }

        // Validate range
        if (value < min || value > max) {
            input.addClass('validation-error');
            resultStatus.removeClass().addClass('result-status badge badge-danger').text('Abnormal');
            testItem.addClass('result-abnormal');
            // Show subtle warning for abnormal values
            if (Math.random() > 0.7) { // Only show warning sometimes to avoid spam
                Swal.fire({
                    icon: 'warning',
                    title: 'Abnormal Value',
                    text: `${testName}: ${value} is outside normal range (${min}-${max})`,
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }
        } else if (value <= min * 1.1 || value >= max * 0.9) {
            input.addClass('validation-warning');
            resultStatus.removeClass().addClass('result-status badge badge-warning').text('Borderline');
            testItem.addClass('result-completed');
        } else {
            input.addClass('validation-normal');
            resultStatus.removeClass().addClass('result-status badge badge-success').text('Normal');
            testItem.addClass('result-completed');
        }
        
        return true;
    }

    function updateProgress() {
        var total = $('.result-input').length;
        var completed = $('.result-input').filter(function() { 
            return $(this).val() !== '' && !isNaN(parseFloat($(this).val())); 
        }).length;
        var normal = $('.validation-normal').length;
        var abnormal = $('.validation-error').length;
        var pending = total - completed;

        var percentage = total > 0 ? Math.round((completed / total) * 100) : 0;

        $('#completionRate').text(percentage + '%');
        $('#progressBar').css('width', percentage + '%');
        $('#progressText').text(percentage + '%');
        $('#completedTests').text(completed);
        $('#normalCount').text(normal);
        $('#abnormalCount').text(abnormal);
        $('#pendingCount').text(pending);
    }

    function validateResults() {
        var allValid = true;
        $('.result-input').each(function() {
            if (!$(this).val() || isNaN(parseFloat($(this).val()))) {
                allValid = false;
            }
        });
        return allValid;
    }

    function saveResults(type) {
        var btn = type === 'final' ? $('#saveResults') : $('#saveAsDraft');
        var originalText = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Saving...');

        setTimeout(function() {
            if (type === 'final') {
                Swal.fire({
                    icon: 'success',
                    title: 'Results Saved!',
                    text: 'Results saved successfully',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Draft Saved',
                    text: 'Results saved as draft',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
            btn.prop('disabled', false).html(originalText);
        }, 1500);
    }

    function previewReport() {
        Swal.fire({
            icon: 'info',
            title: 'Opening Preview',
            text: 'Opening report preview...',
            timer: 1500,
            showConfirmButton: false
        });
        // Simulate opening preview modal or window
        setTimeout(function() {
            Swal.fire({
                icon: 'success',
                title: 'Preview Ready',
                text: 'Report preview loaded',
                timer: 2000,
                showConfirmButton: false
            });
        }, 1000);
    }

    function autoCalculateResults() {
        $('.result-input').each(function() {
            if (!$(this).val()) {
                var min = parseFloat($(this).data('min'));
                var max = parseFloat($(this).data('max'));
                var step = parseFloat($(this).attr('step')) || 1;
                
                // Generate normal values within reference range
                var value = (Math.random() * (max - min) + min);
                if (step < 1) {
                    value = parseFloat(value.toFixed(2));
                } else {
                    value = Math.round(value);
                }
                
                $(this).val(value);
                validateResult($(this));
            }
        });
        
        updateProgress();
        Swal.fire({
            icon: 'success',
            title: 'Auto Calculation Complete',
            text: 'Auto calculation completed',
            timer: 2000,
            showConfirmButton: false
        });
    }

    function flagAbnormalResults() {
        var abnormalCount = $('.validation-error').length;
        if (abnormalCount === 0) {
            Swal.fire({
                icon: 'info',
                title: 'No Abnormal Values',
                text: 'No abnormal values detected'
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Abnormal Values Found',
                text: `${abnormalCount} abnormal value(s) flagged for review`
            });
        }
    }

    function copyPreviousResults() {
        Swal.fire({
            icon: 'info',
            title: 'Previous Results',
            text: 'Previous results feature will copy from patient history',
            timer: 2000,
            showConfirmButton: false
        });
    }

    function generateReport() {
        if (!validateResults()) {
            Swal.fire({
                icon: 'error',
                title: 'Incomplete Results',
                text: 'Please complete all test results first'
            });
            return;
        }
        Swal.fire({
            icon: 'success',
            title: 'Generating Report',
            text: 'Generating comprehensive report...',
            timer: 2000,
            showConfirmButton: false
        });
    }

    function enableButtons() {
        $('#saveResults, #saveAsDraft, #previewReport, #autoCalculate, #flagAbnormal, #copyPrevious, #generateReport').prop('disabled', false);
    }

    function disableButtons() {
        $('#saveResults, #saveAsDraft, #previewReport, #autoCalculate, #flagAbnormal, #copyPrevious, #generateReport').prop('disabled', true);
    }

    function clearTestResults() {
        $('#testResults').html(`
            <div class="text-center text-muted" style="padding: 60px 0;">
                <i class="fas fa-search fa-4x mb-3" style="color: #dee2e6;"></i>
                <h5>Please select a sample to load test results</h5>
                <p>Use the search box above to find a patient sample</p>
            </div>
        `);
        updateProgress();
    }

    // Initialize
    Swal.fire({
        icon: 'success',
        title: 'System Ready',
        text: 'Result Entry system ready - Select a sample to begin',
        timer: 2000,
        showConfirmButton: false
    });
});
</script>
@endpush
