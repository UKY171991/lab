@extends('admin.layouts.app')

@section('title', 'Laboratory Dashboard')
@section('page-title', 'Laboratory Dashboard')
@section('breadcrumb', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js">
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }
    
    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/><path d="M30 50 L45 65 L70 35" stroke="rgba(255,255,255,0.1)" stroke-width="2" fill="none"/></svg>') repeat;
        background-size: 120px;
        opacity: 0.4;
        animation: float 25s linear infinite;
    }
    
    @keyframes float {
        0% { transform: translate(-50%, -50%) rotate(0deg); }
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }
    
    .stats-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.4s ease;
        border: none;
        height: 170px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
        margin-bottom: 25px;
        cursor: pointer;
    }
    
    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--card-color);
        transition: width 0.3s ease;
    }
    
    .stats-card:hover::before {
        width: 8px;
    }
    
    .stats-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }
    
    .stats-number {
        font-size: 3rem;
        font-weight: bold;
        color: var(--card-color);
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }
    
    .stats-card:hover .stats-number {
        transform: scale(1.05);
    }
    
    .stats-label {
        color: #64748b;
        font-weight: 600;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stats-icon {
        position: absolute;
        top: 25px;
        right: 25px;
        font-size: 2.5rem;
        color: var(--card-color);
        opacity: 0.8;
        transition: all 0.3s ease;
    }
    
    .stats-card:hover .stats-icon {
        transform: scale(1.1) rotate(5deg);
        opacity: 1;
    }
    
    .chart-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }
    
    .chart-container:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    }
    
    .recent-activity {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        padding: 30px;
        transition: all 0.3s ease;
    }
    
    .recent-activity:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    }
    
    .activity-item {
        display: flex;
        align-items: center;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
        background: #f8fafc;
    }
    
    .activity-item:hover {
        background: #e2e8f0;
        transform: translateX(5px);
    }
    
    .activity-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        color: white;
        font-size: 1.2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    .quick-action-btn {
        transition: all 0.3s ease;
        border-radius: 15px !important;
        padding: 25px !important;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
    }
    
    .quick-action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }
    
    .quick-action-btn:hover::before {
        left: 100%;
    }
    
    .quick-action-btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }
    
    .progress-ring {
        width: 60px;
        height: 60px;
        margin: 0 auto 15px;
    }
    
    .progress-ring__circle {
        stroke: #e2e8f0;
        stroke-width: 4;
        fill: transparent;
        r: 26;
        cx: 30;
        cy: 30;
        transform-origin: 50% 50%;
        transform: rotate(-90deg);
        transition: stroke-dasharray 0.5s ease;
    }
    
    .progress-ring__circle--progress {
        stroke: var(--card-color);
        stroke-linecap: round;
    }
    
    /* Real-time indicators */
    .live-indicator {
        display: inline-block;
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        margin-right: 8px;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.2); }
        100% { opacity: 1; transform: scale(1); }
    }
    
    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 25px;
            text-align: center;
        }
        
        .dashboard-header h1 {
            font-size: 1.75rem;
        }
        
        .stats-card {
            height: auto;
            padding: 25px;
            text-align: center;
        }
        
        .stats-number {
            font-size: 2.5rem;
        }
        
        .stats-icon {
            position: static;
            display: block;
            margin: 0 auto 15px;
            font-size: 2.5rem;
        }
        
        .chart-container, .recent-activity {
            padding: 20px;
        }
        
        .activity-item {
            padding: 15px;
        }
        
        .quick-action-btn {
            margin-bottom: 15px;
            padding: 20px !important;
        }
    }
    
    @media (max-width: 576px) {
        .dashboard-header h1 {
            font-size: 1.5rem;
        }
        
        .stats-number {
            font-size: 2rem;
        }
        
        .stats-label {
            font-size: 0.95rem;
        }
    }
    
    /* Loading animations */
    .loading-shimmer {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }
    
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-7 col-12 text-center text-md-left">
                <h1 class="mb-0">
                    <span class="live-indicator"></span>
                    <i class="fas fa-microscope mr-3"></i>Laboratory Management Dashboard
                </h1>
                <p class="mb-0 opacity-75">Real-time overview of your laboratory operations</p>
            </div>
            <div class="col-lg-4 col-md-5 col-12 text-center text-md-right mt-3 mt-md-0">
                <div style="background: rgba(255,255,255,0.15); padding: 20px; border-radius: 15px; display: inline-block;">
                    <div style="font-size: 1.3rem; font-weight: bold;">{{ now()->format('M d, Y') }}</div>
                    <div style="font-size: 1rem; opacity: 0.9;">{{ now()->format('l') }}</div>
                    <div style="font-size: 0.9rem; opacity: 0.8;" id="current-time">{{ now()->format('H:i:s') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stats-card" style="--card-color: #3b82f6;" onclick="location.href='{{ route('admin.reports') }}'">
                <i class="fas fa-file-medical stats-icon"></i>
                <div class="stats-number" id="total-reports">{{ \App\Models\Report::count() }}</div>
                <div class="stats-label">Total Reports</div>
                <svg class="progress-ring">
                    <circle class="progress-ring__circle" r="26" cx="30" cy="30" stroke-dasharray="163.36" stroke-dashoffset="40.84"></circle>
                    <circle class="progress-ring__circle progress-ring__circle--progress" r="26" cx="30" cy="30" stroke-dasharray="163.36" stroke-dashoffset="122.52"></circle>
                </svg>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stats-card" style="--card-color: #10b981;" onclick="location.href='{{ route('admin.patients') }}'">
                <i class="fas fa-users stats-icon"></i>
                <div class="stats-number" id="total-patients">{{ \App\Models\Patient::count() }}</div>
                <div class="stats-label">Total Patients</div>
                <svg class="progress-ring">
                    <circle class="progress-ring__circle" r="26" cx="30" cy="30" stroke-dasharray="163.36" stroke-dashoffset="40.84"></circle>
                    <circle class="progress-ring__circle progress-ring__circle--progress" r="26" cx="30" cy="30" stroke-dasharray="163.36" stroke-dashoffset="81.68"></circle>
                </svg>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stats-card" style="--card-color: #f59e0b;" onclick="location.href='{{ route('admin.reports') }}?status=pending'">
                <i class="fas fa-clock stats-icon"></i>
                <div class="stats-number" id="pending-reports">{{ \App\Models\Report::where('report_status', 'pending')->count() }}</div>
                <div class="stats-label">Pending Reports</div>
                <svg class="progress-ring">
                    <circle class="progress-ring__circle" r="26" cx="30" cy="30" stroke-dasharray="163.36" stroke-dashoffset="40.84"></circle>
                    <circle class="progress-ring__circle progress-ring__circle--progress" r="26" cx="30" cy="30" stroke-dasharray="163.36" stroke-dashoffset="130.69"></circle>
                </svg>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stats-card" style="--card-color: #ef4444;" onclick="location.href='{{ route('admin.tests') }}'">
                <i class="fas fa-flask stats-icon"></i>
                <div class="stats-number" id="total-tests">{{ \App\Models\Test::count() }}</div>
                <div class="stats-label">Available Tests</div>
                <svg class="progress-ring">
                    <circle class="progress-ring__circle" r="26" cx="30" cy="30" stroke-dasharray="163.36" stroke-dashoffset="40.84"></circle>
                    <circle class="progress-ring__circle progress-ring__circle--progress" r="26" cx="30" cy="30" stroke-dasharray="163.36" stroke-dashoffset="65.34"></circle>
                </svg>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Today's Activities -->
        <div class="col-md-8">
            <div class="chart-container">
                <h5 class="mb-4">
                    <i class="fas fa-chart-line mr-2" style="color: #667eea;"></i>Lab Activity Overview
                    <span class="live-indicator"></span>
                </h5>
                <div style="position: relative; height: 350px;">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-md-4">
            <div class="recent-activity">
                <h5 class="mb-4">
                    <i class="fas fa-clock mr-2" style="color: #667eea;"></i>Recent Activity
                    <span class="live-indicator"></span>
                </h5>
                
                <div id="recent-activities">
                    @php
                        $recentReports = \App\Models\Report::with('patient')->latest()->take(5)->get();
                    @endphp
                    
                    @forelse($recentReports as $report)
                    <div class="activity-item">
                        <div class="activity-icon" style="background: #3b82f6;">
                            <i class="fas fa-file-medical"></i>
                        </div>
                        <div class="flex-1">
                            <div style="font-weight: 600; color: #1f2937;">New Report Generated</div>
                            <div style="font-size: 0.9rem; color: #6b7280;">
                                {{ $report->patient ? $report->patient->client_name : 'Unknown Patient' }} - {{ $report->report_number }}
                            </div>
                            <div style="font-size: 0.8rem; color: #9ca3af;">{{ $report->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="activity-item">
                        <div class="activity-icon" style="background: #10b981;">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div class="flex-1">
                            <div style="font-weight: 600; color: #1f2937;">System Ready</div>
                            <div style="font-size: 0.9rem; color: #6b7280;">No recent activity</div>
                            <div style="font-size: 0.8rem; color: #9ca3af;">Start by creating a new report</div>
                        </div>
                    </div>
                    @endforelse
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('admin.reports') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye mr-2"></i>View All Reports
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="chart-container">
                <h5 class="mb-4">
                    <i class="fas fa-bolt mr-2" style="color: #667eea;"></i>Quick Actions
                </h5>
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="{{ route('admin.reports.create') }}" class="btn btn-primary btn-lg btn-block quick-action-btn">
                            <i class="fas fa-plus-circle d-block mb-2" style="font-size: 2.5rem;"></i>
                            Create Report
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="{{ route('admin.patients.create') }}" class="btn btn-success btn-lg btn-block quick-action-btn">
                            <i class="fas fa-user-plus d-block mb-2" style="font-size: 2.5rem;"></i>
                            Add Patient
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="{{ route('admin.tests') }}" class="btn btn-warning btn-lg btn-block quick-action-btn">
                            <i class="fas fa-vial d-block mb-2" style="font-size: 2.5rem;"></i>
                            Manage Tests
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="{{ route('admin.settings') }}" class="btn btn-info btn-lg btn-block quick-action-btn">
                            <i class="fas fa-cog d-block mb-2" style="font-size: 2.5rem;"></i>
                            Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Real-time clock update
    function updateTime() {
        const now = new Date();
        document.getElementById('current-time').textContent = now.toLocaleTimeString();
    }
    setInterval(updateTime, 1000);

    // Add loading animation to stats cards
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);
    });

    // Initialize Chart.js
    const ctx = document.getElementById('activityChart').getContext('2d');
    const activityChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Reports Generated',
                data: [12, 19, 15, 25, 22, 18, 24],
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }, {
                label: 'Patients Registered',
                data: [8, 14, 12, 18, 16, 13, 19],
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart'
            }
        }
    });

    // Auto-refresh dashboard data every 30 seconds
    setInterval(function() {
        refreshDashboardStats();
    }, 30000);

    function refreshDashboardStats() {
        fetch('/admin/dashboard-stats')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('total-reports').textContent = data.stats.reports;
                    document.getElementById('total-patients').textContent = data.stats.patients;
                    document.getElementById('pending-reports').textContent = data.stats.pending;
                    document.getElementById('total-tests').textContent = data.stats.tests;
                }
            })
            .catch(error => console.log('Dashboard refresh error:', error));
    }

    // Add hover effects to quick action buttons
    document.querySelectorAll('.quick-action-btn').forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Progress ring animations
    function animateProgressRings() {
        const rings = document.querySelectorAll('.progress-ring__circle--progress');
        rings.forEach((ring, index) => {
            const circumference = 2 * Math.PI * 26;
            const progress = [75, 50, 20, 60][index]; // Different progress for each card
            const offset = circumference - (progress / 100) * circumference;
            
            setTimeout(() => {
                ring.style.strokeDashoffset = offset;
            }, index * 300);
        });
    }
    
    setTimeout(animateProgressRings, 1000);
});
</script>
@endpush
@endsection