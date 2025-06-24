@extends('admin.layouts.app')

@section('title', 'Laboratory Dashboard')
@section('page-title', 'Laboratory Dashboard')
@section('breadcrumb', 'Dashboard')

@push('styles')
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    
    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/><path d="M30 50 L45 65 L70 35" stroke="rgba(255,255,255,0.1)" stroke-width="2" fill="none"/></svg>') repeat;
        background-size: 80px;
        opacity: 0.3;
        animation: float 20s linear infinite;
    }
    
    @keyframes float {
        0% { transform: translate(-50%, -50%) rotate(0deg); }
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }
    
    .stats-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: none;
        height: 150px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
        margin-bottom: 20px;
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
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    
    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: var(--card-color);
        margin-bottom: 10px;
    }
    
    .stats-label {
        color: #64748b;
        font-weight: 600;
        font-size: 1rem;
    }
    
    .stats-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 2rem;
        color: var(--card-color);
        opacity: 0.7;
    }
    
    .chart-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-bottom: 30px;
    }
    
    .recent-activity {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        padding: 25px;
    }
    
    .activity-item {
        display: flex;
        align-items: center;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }
    
    .activity-item:hover {
        background: #f8fafc;
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: white;
        font-size: 1rem;
    }
    
    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 20px;
            text-align: center;
        }
        
        .dashboard-header h1 {
            font-size: 1.5rem;
        }
        
        .stats-card {
            height: auto;
            padding: 20px;
            text-align: center;
        }
        
        .stats-number {
            font-size: 2rem;
        }
        
        .stats-icon {
            position: static;
            display: block;
            margin: 0 auto 10px;
            font-size: 2.5rem;
        }
        
        .chart-container {
            padding: 15px;
        }
        
        .recent-activity {
            padding: 15px;
        }
        
        .activity-item {
            padding: 10px;
        }
        
        .quick-action-btn {
            margin-bottom: 15px;
            padding: 15px;
        }
    }
    
    @media (max-width: 576px) {
        .dashboard-header h1 {
            font-size: 1.25rem;
        }
        
        .stats-number {
            font-size: 1.75rem;
        }
        
        .stats-label {
            font-size: 0.9rem;
        }
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
                    <i class="fas fa-microscope mr-3"></i>Laboratory Management Dashboard
                </h1>
                <p class="mb-0 opacity-75">Welcome back! Here's your lab overview for today.</p>
            </div>
            <div class="col-lg-4 col-md-5 col-12 text-center text-md-right mt-3 mt-md-0">
                <div style="background: rgba(255,255,255,0.15); padding: 15px; border-radius: 10px; display: inline-block;">
                    <div style="font-size: 1.2rem; font-weight: bold;">{{ now()->format('M d, Y') }}</div>
                    <div style="font-size: 0.9rem; opacity: 0.8;">{{ now()->format('l') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stats-card" style="--card-color: #3b82f6;">
                <i class="fas fa-file-medical stats-icon"></i>
                <div class="stats-number">{{ \App\Models\Report::count() }}</div>
                <div class="stats-label">Total Reports</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stats-card" style="--card-color: #10b981;">
                <i class="fas fa-users stats-icon"></i>
                <div class="stats-number">{{ \App\Models\Patient::count() }}</div>
                <div class="stats-label">Total Patients</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stats-card" style="--card-color: #f59e0b;">
                <i class="fas fa-clock stats-icon"></i>
                <div class="stats-number">{{ \App\Models\Report::where('report_status', 'pending')->count() }}</div>
                <div class="stats-label">Pending Reports</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stats-card" style="--card-color: #ef4444;">
                <i class="fas fa-flask stats-icon"></i>
                <div class="stats-number">{{ \App\Models\Test::count() }}</div>
                <div class="stats-label">Available Tests</div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Today's Activities -->
        <div class="col-md-8">
            <div class="chart-container">
                <h5 class="mb-4">
                    <i class="fas fa-chart-line mr-2" style="color: #667eea;"></i>Lab Activity Overview
                </h5>
                <div style="height: 300px; display: flex; align-items: center; justify-content: center; background: #f8fafc; border-radius: 10px;">
                    <div class="text-center">
                        <i class="fas fa-chart-area" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 15px;"></i>
                        <p style="color: #64748b; margin: 0;">Chart visualization will be implemented here</p>
                        <small style="color: #94a3b8;">Integration with Chart.js or similar library</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-md-4">
            <div class="recent-activity">
                <h5 class="mb-4">
                    <i class="fas fa-clock mr-2" style="color: #667eea;"></i>Recent Activity
                </h5>
                
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
                        <div style="font-size: 0.85rem; color: #6b7280;">
                            {{ $report->patient ? $report->patient->client_name : 'Unknown Patient' }} - {{ $report->report_number }}
                        </div>
                        <div style="font-size: 0.75rem; color: #9ca3af;">{{ $report->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                @empty
                <div class="activity-item">
                    <div class="activity-icon" style="background: #10b981;">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="flex-1">
                        <div style="font-weight: 600; color: #1f2937;">System Ready</div>
                        <div style="font-size: 0.85rem; color: #6b7280;">No recent activity</div>
                        <div style="font-size: 0.75rem; color: #9ca3af;">Start by creating a new report</div>
                    </div>
                </div>
                @endforelse

                <div class="text-center mt-3">
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
                        <a href="{{ route('admin.reports.create') }}" class="btn btn-primary btn-lg btn-block quick-action-btn" style="border-radius: 10px; padding: 20px;">
                            <i class="fas fa-plus-circle d-block mb-2" style="font-size: 2rem;"></i>
                            Create Report
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="{{ route('admin.patients') }}" class="btn btn-success btn-lg btn-block quick-action-btn" style="border-radius: 10px; padding: 20px;">
                            <i class="fas fa-user-plus d-block mb-2" style="font-size: 2rem;"></i>
                            Add Patient
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="{{ route('admin.tests') }}" class="btn btn-warning btn-lg btn-block quick-action-btn" style="border-radius: 10px; padding: 20px;">
                            <i class="fas fa-vial d-block mb-2" style="font-size: 2rem;"></i>
                            Manage Tests
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="{{ route('admin.settings') }}" class="btn btn-info btn-lg btn-block quick-action-btn" style="border-radius: 10px; padding: 20px;">
                            <i class="fas fa-cog d-block mb-2" style="font-size: 2rem;"></i>
                            Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add loading animation to stats cards
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.5s ease';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 150);
    });
    
    // Add loading animation to chart container
    const chartContainer = document.querySelector('.chart-container');
    if (chartContainer) {
        chartContainer.style.opacity = '0';
        chartContainer.style.transform = 'translateY(20px)';
        chartContainer.style.transition = 'all 0.5s ease';
        
        setTimeout(() => {
            chartContainer.style.opacity = '1';
            chartContainer.style.transform = 'translateY(0)';
        }, 600);
    }
    
    // Add loading animation to recent activity
    const recentActivity = document.querySelector('.recent-activity');
    if (recentActivity) {
        recentActivity.style.opacity = '0';
        recentActivity.style.transform = 'translateY(20px)';
        recentActivity.style.transition = 'all 0.5s ease';
        
        setTimeout(() => {
            recentActivity.style.opacity = '1';
            recentActivity.style.transform = 'translateY(0)';
        }, 800);
    }
    
    // Add loading animation to quick actions
    const quickActions = document.querySelectorAll('.quick-action-btn');
    quickActions.forEach((btn, index) => {
        btn.style.opacity = '0';
        btn.style.transform = 'translateY(20px)';
        btn.style.transition = 'all 0.5s ease';
        
        setTimeout(() => {
            btn.style.opacity = '1';
            btn.style.transform = 'translateY(0)';
        }, 1000 + (index * 100));
    });
    
    // Add click animation to quick action buttons
    quickActions.forEach(btn => {
        btn.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            ripple.style.left = e.offsetX + 'px';
            ripple.style.top = e.offsetY + 'px';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
});

// Add ripple effect CSS
const style = document.createElement('style');
style.textContent = `
    .quick-action-btn {
        position: relative;
        overflow: hidden;
    }
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>
@endpush
@endsection 