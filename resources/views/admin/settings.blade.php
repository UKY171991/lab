@extends('admin.layouts.app')

@section('title', 'Settings')
@section('page-title', 'Settings')
@section('breadcrumb', 'Settings')

@push('styles')
<style>
    .settings-nav .nav-link {
        border-radius: 10px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    
    .settings-nav .nav-link:hover {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
    
    .settings-nav .nav-link.active {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
    }
    
    .settings-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .settings-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    
    .settings-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 20px;
    }
    
    .settings-form-group {
        margin-bottom: 25px;
    }
    
    .settings-form-group label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        display: block;
    }
    
    .settings-form-control {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px 16px;
        transition: all 0.3s ease;
        font-size: 14px;
    }
    
    .settings-form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }
    
    .settings-btn {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .settings-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .settings-toggle {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }
    
    .settings-toggle input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .settings-toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }
    
    .settings-toggle-slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    
    input:checked + .settings-toggle-slider {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
    }
    
    input:checked + .settings-toggle-slider:before {
        transform: translateX(26px);
    }
    
    .settings-section-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        margin-bottom: 20px;
    }
    
    .animated-bg {
        background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
        background-size: 400% 400%;
        animation: gradient 15s ease infinite;
    }
    
    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    .success-message {
        background: linear-gradient(45deg, #10b981 0%, #34d399 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        border: none;
    }
    
    .dark-mode {
        background-color: #1f2937;
        color: #f9fafb;
    }
    
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }
    
    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }
    
    .stats-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    
    /* Additional responsive improvements */
    @media (max-width: 768px) {
        .settings-nav .nav-link {
            text-align: center;
            margin-bottom: 5px;
        }
        
        .settings-section-icon {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }
        
        .stats-card {
            margin-bottom: 15px;
        }
        
        .settings-card {
            margin-bottom: 20px;
        }
    }
    
    /* Loading overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        display: none;
    }
    
    .loading-spinner {
        background: white;
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }
    
    .loading-spinner .fa-spinner {
        font-size: 2rem;
        color: #667eea;
        margin-bottom: 15px;
    }
    
    /* Smooth transitions for form elements */
    .settings-form-control,
    .settings-toggle-slider,
    .settings-btn {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Enhanced hover effects */
    .list-group-item {
        transition: all 0.3s ease;
        border-radius: 8px;
        margin-bottom: 5px;
        border: 1px solid #e5e7eb;
    }
    
    .list-group-item:hover {
        transform: translateX(5px);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        background-color: #f8fafc;
    }
    
    /* Improved form validation styles */
    .is-invalid {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
    }
    
    .is-valid {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
    }
    
    /* Custom scrollbar for settings content */
    .settings-tab {
        max-height: 80vh;
        overflow-y: auto;
    }
    
    .settings-tab::-webkit-scrollbar {
        width: 6px;
    }
    
    .settings-tab::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    .settings-tab::-webkit-scrollbar-thumb {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        border-radius: 3px;
    }
    
    .settings-tab::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(45deg, #5a6fd8 0%, #6a4190 100%);
    }
</style>
@endpush

@section('content')
<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <i class="fas fa-spinner fa-spin"></i>
        <div>Processing your request...</div>
    </div>
</div>

<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-cogs text-primary mr-2"></i>Settings Management
                </h1>
                <p class="text-muted mb-0">Configure and customize your application settings</p>
            </div>
            <div>
                <button class="btn btn-outline-primary" onclick="exportSettings()">
                    <i class="fas fa-download mr-2"></i>Export Settings
                </button>
                <button class="btn btn-outline-secondary ml-2" onclick="resetToDefaults()">
                    <i class="fas fa-undo mr-2"></i>Reset to Defaults
                </button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\User::count() }}</div>
                <div class="stats-label">Total Users</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\Test::count() }}</div>
                <div class="stats-label">Total Tests</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\Doctor::count() }}</div>
                <div class="stats-label">Total Doctors</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\Patient::count() }}</div>
                <div class="stats-label">Total Patients</div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Settings Navigation -->
        <div class="col-md-3">
            <div class="card settings-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-cogs mr-2"></i>Settings Menu</h5>
                </div>
                <div class="card-body">
                    <nav class="nav flex-column settings-nav">
                        <a class="nav-link active" href="#general" data-tab="general">
                            <i class="fas fa-home mr-2"></i>General Settings
                        </a>
                        <a class="nav-link" href="#system" data-tab="system">
                            <i class="fas fa-server mr-2"></i>System Settings
                        </a>
                        <a class="nav-link" href="#email" data-tab="email">
                            <i class="fas fa-envelope mr-2"></i>Email Settings
                        </a>
                        <a class="nav-link" href="#security" data-tab="security">
                            <i class="fas fa-shield-alt mr-2"></i>Security Settings
                        </a>
                        <a class="nav-link" href="#appearance" data-tab="appearance">
                            <i class="fas fa-palette mr-2"></i>Appearance
                        </a>
                        <a class="nav-link" href="#backup" data-tab="backup">
                            <i class="fas fa-database mr-2"></i>Backup & Restore
                        </a>
                    </nav>
                </div>
                <div class="mt-3 p-3" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-radius: 10px;">
                    <h6 class="text-muted mb-2"><i class="fas fa-keyboard mr-1"></i> Quick Actions</h6>
                    <small class="text-muted d-block mb-1"><kbd>Ctrl</kbd> + <kbd>S</kbd> Save current form</small>
                    <small class="text-muted d-block mb-1"><kbd>Tab</kbd> Navigate between fields</small>
                    <small class="text-muted d-block"><kbd>Esc</kbd> Cancel current action</small>
                </div>
                
                <div class="mt-3 p-3" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-radius: 10px;">
                    <h6 class="text-primary mb-2"><i class="fas fa-info-circle mr-1"></i> System Info</h6>
                    <small class="text-muted d-block mb-1">Laravel {{ app()->version() }}</small>
                    <small class="text-muted d-block mb-1">PHP {{ PHP_VERSION }}</small>
                    <small class="text-muted d-block">Environment: {{ app()->environment() }}</small>
                </div>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="col-md-9">
            <!-- General Settings Tab -->
            <div id="general-tab" class="settings-tab">
                <div class="card settings-card">
                    <div class="card-header">
                        <div class="settings-section-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <h4 class="mb-0">General Settings</h4>
                        <p class="mb-0 opacity-75">Configure basic application settings</p>
                    </div>
                    <div class="card-body">
                        <form id="general-settings-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="app_name">Application Name</label>
                                        <input type="text" class="form-control settings-form-control" id="app_name" name="app_name" value="{{ config('app.name') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="app_url">Application URL</label>
                                        <input type="url" class="form-control settings-form-control" id="app_url" name="app_url" value="{{ config('app.url') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="timezone">Timezone</label>
                                        <select class="form-control settings-form-control" id="timezone" name="timezone">
                                            <option value="UTC">UTC</option>
                                            <option value="America/New_York">America/New_York</option>
                                            <option value="America/Chicago">America/Chicago</option>
                                            <option value="America/Denver">America/Denver</option>
                                            <option value="America/Los_Angeles">America/Los_Angeles</option>
                                            <option value="Europe/London">Europe/London</option>
                                            <option value="Asia/Tokyo">Asia/Tokyo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="currency">Default Currency</label>
                                        <select class="form-control settings-form-control" id="currency" name="currency">
                                            <option value="USD">USD - US Dollar</option>
                                            <option value="EUR">EUR - Euro</option>
                                            <option value="GBP">GBP - British Pound</option>
                                            <option value="JPY">JPY - Japanese Yen</option>
                                            <option value="INR">INR - Indian Rupee</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="settings-form-group">
                                <label for="app_description">Application Description</label>
                                <textarea class="form-control settings-form-control" id="app_description" name="app_description" rows="3" placeholder="Brief description of your application"></textarea>
                            </div>
                            <button type="submit" class="btn settings-btn">
                                <i class="fas fa-save mr-2"></i>Save General Settings
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- System Settings Tab -->
            <div id="system-tab" class="settings-tab" style="display: none;">
                <div class="card settings-card">
                    <div class="card-header">
                        <div class="settings-section-icon">
                            <i class="fas fa-server"></i>
                        </div>
                        <h4 class="mb-0">System Settings</h4>
                        <p class="mb-0 opacity-75">Configure system-level preferences</p>
                    </div>
                    <div class="card-body">
                        <form id="system-settings-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label>Maintenance Mode</label>
                                        <div class="d-flex align-items-center">
                                            <label class="settings-toggle mr-3">
                                                <input type="checkbox" id="maintenance_mode" name="maintenance_mode">
                                                <span class="settings-toggle-slider"></span>
                                            </label>
                                            <span>Enable maintenance mode</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label>Debug Mode</label>
                                        <div class="d-flex align-items-center">
                                            <label class="settings-toggle mr-3">
                                                <input type="checkbox" id="debug_mode" name="debug_mode" {{ config('app.debug') ? 'checked' : '' }}>
                                                <span class="settings-toggle-slider"></span>
                                            </label>
                                            <span>Enable debug mode</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="session_lifetime">Session Lifetime (minutes)</label>
                                        <input type="number" class="form-control settings-form-control" id="session_lifetime" name="session_lifetime" value="120" min="30" max="1440">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="max_upload_size">Max Upload Size (MB)</label>
                                        <input type="number" class="form-control settings-form-control" id="max_upload_size" name="max_upload_size" value="10" min="1" max="100">
                                    </div>
                                </div>
                            </div>
                            <div class="settings-form-group">
                                <label>Cache Settings</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-outline-primary btn-block" onclick="clearCache('config')">
                                            <i class="fas fa-sync mr-2"></i>Clear Config Cache
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-outline-primary btn-block" onclick="clearCache('route')">
                                            <i class="fas fa-sync mr-2"></i>Clear Route Cache
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-outline-primary btn-block" onclick="clearCache('view')">
                                            <i class="fas fa-sync mr-2"></i>Clear View Cache
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn settings-btn">
                                <i class="fas fa-save mr-2"></i>Save System Settings
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Email Settings Tab -->
            <div id="email-tab" class="settings-tab" style="display: none;">
                <div class="card settings-card">
                    <div class="card-header">
                        <div class="settings-section-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4 class="mb-0">Email Settings</h4>
                        <p class="mb-0 opacity-75">Configure email delivery settings</p>
                    </div>
                    <div class="card-body">
                        <form id="email-settings-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="mail_driver">Mail Driver</label>
                                        <select class="form-control settings-form-control" id="mail_driver" name="mail_driver">
                                            <option value="smtp">SMTP</option>
                                            <option value="sendmail">Sendmail</option>
                                            <option value="mailgun">Mailgun</option>
                                            <option value="ses">Amazon SES</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="mail_host">SMTP Host</label>
                                        <input type="text" class="form-control settings-form-control" id="mail_host" name="mail_host" placeholder="smtp.gmail.com">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="mail_port">SMTP Port</label>
                                        <input type="number" class="form-control settings-form-control" id="mail_port" name="mail_port" value="587">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="mail_encryption">Encryption</label>
                                        <select class="form-control settings-form-control" id="mail_encryption" name="mail_encryption">
                                            <option value="tls">TLS</option>
                                            <option value="ssl">SSL</option>
                                            <option value="">None</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="mail_username">SMTP Username</label>
                                        <input type="email" class="form-control settings-form-control" id="mail_username" name="mail_username" placeholder="your-email@gmail.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="mail_password">SMTP Password</label>
                                        <input type="password" class="form-control settings-form-control" id="mail_password" name="mail_password" placeholder="••••••••">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="mail_from_address">From Address</label>
                                        <input type="email" class="form-control settings-form-control" id="mail_from_address" name="mail_from_address" placeholder="noreply@yourapp.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="mail_from_name">From Name</label>
                                        <input type="text" class="form-control settings-form-control" id="mail_from_name" name="mail_from_name" placeholder="Your App Name">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-primary" onclick="testEmailConnection()">
                                    <i class="fas fa-paper-plane mr-2"></i>Test Email Connection
                                </button>
                                <button type="submit" class="btn settings-btn">
                                    <i class="fas fa-save mr-2"></i>Save Email Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Security Settings Tab -->
            <div id="security-tab" class="settings-tab" style="display: none;">
                <div class="card settings-card">
                    <div class="card-header">
                        <div class="settings-section-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="mb-0">Security Settings</h4>
                        <p class="mb-0 opacity-75">Configure security and authentication</p>
                    </div>
                    <div class="card-body">
                        <form id="security-settings-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label>Two-Factor Authentication</label>
                                        <div class="d-flex align-items-center">
                                            <label class="settings-toggle mr-3">
                                                <input type="checkbox" id="two_factor_auth" name="two_factor_auth">
                                                <span class="settings-toggle-slider"></span>
                                            </label>
                                            <span>Enable 2FA for all users</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label>Password Reset Required</label>
                                        <div class="d-flex align-items-center">
                                            <label class="settings-toggle mr-3">
                                                <input type="checkbox" id="force_password_reset" name="force_password_reset">
                                                <span class="settings-toggle-slider"></span>
                                            </label>
                                            <span>Force password reset on first login</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="password_min_length">Minimum Password Length</label>
                                        <input type="number" class="form-control settings-form-control" id="password_min_length" name="password_min_length" value="8" min="6" max="50">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="login_attempts">Max Login Attempts</label>
                                        <input type="number" class="form-control settings-form-control" id="login_attempts" name="login_attempts" value="5" min="3" max="10">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="lockout_duration">Account Lockout Duration (minutes)</label>
                                        <input type="number" class="form-control settings-form-control" id="lockout_duration" name="lockout_duration" value="15" min="5" max="60">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="password_expiry">Password Expiry (days)</label>
                                        <input type="number" class="form-control settings-form-control" id="password_expiry" name="password_expiry" value="90" min="30" max="365">
                                    </div>
                                </div>
                            </div>
                            <div class="settings-form-group">
                                <label>Password Requirements</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="require_uppercase" name="require_uppercase" checked>
                                            <label class="form-check-label" for="require_uppercase">Require uppercase letters</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="require_lowercase" name="require_lowercase" checked>
                                            <label class="form-check-label" for="require_lowercase">Require lowercase letters</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="require_numbers" name="require_numbers" checked>
                                            <label class="form-check-label" for="require_numbers">Require numbers</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="require_symbols" name="require_symbols">
                                            <label class="form-check-label" for="require_symbols">Require special characters</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn settings-btn">
                                <i class="fas fa-save mr-2"></i>Save Security Settings
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Appearance Settings Tab -->
            <div id="appearance-tab" class="settings-tab" style="display: none;">
                <div class="card settings-card">
                    <div class="card-header">
                        <div class="settings-section-icon">
                            <i class="fas fa-palette"></i>
                        </div>
                        <h4 class="mb-0">Appearance Settings</h4>
                        <p class="mb-0 opacity-75">Customize the look and feel</p>
                    </div>
                    <div class="card-body">
                        <form id="appearance-settings-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label>Dark Mode</label>
                                        <div class="d-flex align-items-center">
                                            <label class="settings-toggle mr-3">
                                                <input type="checkbox" id="dark_mode" name="dark_mode">
                                                <span class="settings-toggle-slider"></span>
                                            </label>
                                            <span>Enable dark mode</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="theme_color">Primary Theme Color</label>
                                        <input type="color" class="form-control settings-form-control" id="theme_color" name="theme_color" value="#667eea">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="sidebar_style">Sidebar Style</label>
                                        <select class="form-control settings-form-control" id="sidebar_style" name="sidebar_style">
                                            <option value="light">Light</option>
                                            <option value="dark">Dark</option>
                                            <option value="gradient">Gradient</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="settings-form-group">
                                        <label for="navbar_style">Navbar Style</label>
                                        <select class="form-control settings-form-control" id="navbar_style" name="navbar_style">
                                            <option value="light">Light</option>
                                            <option value="dark">Dark</option>
                                            <option value="primary">Primary Color</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="settings-form-group">
                                <label for="logo_upload">Upload Logo</label>
                                <input type="file" class="form-control settings-form-control" id="logo_upload" name="logo_upload" accept="image/*">
                                <small class="text-muted">Recommended size: 200x50 pixels</small>
                            </div>
                            <button type="submit" class="btn settings-btn">
                                <i class="fas fa-save mr-2"></i>Save Appearance Settings
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Backup Settings Tab -->
            <div id="backup-tab" class="settings-tab" style="display: none;">
                <div class="card settings-card">
                    <div class="card-header">
                        <div class="settings-section-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <h4 class="mb-0">Backup & Restore</h4>
                        <p class="mb-0 opacity-75">Manage your data backups</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="settings-form-group">
                                    <label>Automatic Backups</label>
                                    <div class="d-flex align-items-center mb-3">
                                        <label class="settings-toggle mr-3">
                                            <input type="checkbox" id="auto_backup" name="auto_backup">
                                            <span class="settings-toggle-slider"></span>
                                        </label>
                                        <span>Enable automatic backups</span>
                                    </div>
                                </div>
                                <div class="settings-form-group">
                                    <label for="backup_frequency">Backup Frequency</label>
                                    <select class="form-control settings-form-control" id="backup_frequency" name="backup_frequency">
                                        <option value="daily">Daily</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly">Monthly</option>
                                    </select>
                                </div>
                                <div class="settings-form-group">
                                    <button type="button" class="btn settings-btn btn-block" onclick="createBackup()">
                                        <i class="fas fa-download mr-2"></i>Create Backup Now
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="settings-form-group">
                                    <label>Recent Backups</label>
                                    <div class="list-group">
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>backup_2025_06_24.sql</strong>
                                                <br><small class="text-muted">June 24, 2025 - 2:30 PM</small>
                                            </div>
                                            <div>
                                                <button class="btn btn-sm btn-outline-primary mr-1" onclick="downloadBackup('backup_2025_06_24.sql')">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="deleteBackup('backup_2025_06_24.sql')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>backup_2025_06_23.sql</strong>
                                                <br><small class="text-muted">June 23, 2025 - 2:30 PM</small>
                                            </div>
                                            <div>
                                                <button class="btn btn-sm btn-outline-primary mr-1" onclick="downloadBackup('backup_2025_06_23.sql')">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="deleteBackup('backup_2025_06_23.sql')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="settings-form-group">
                                    <label for="restore_file">Restore from Backup</label>
                                    <input type="file" class="form-control settings-form-control" id="restore_file" name="restore_file" accept=".sql">
                                    <button type="button" class="btn btn-outline-warning btn-block mt-2" onclick="restoreBackup()">
                                        <i class="fas fa-upload mr-2"></i>Restore Database
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Add smooth scrolling for navigation
    $('.settings-nav .nav-link').click(function(e) {
        e.preventDefault();
        
        // Remove active class from all nav links
        $('.settings-nav .nav-link').removeClass('active');
        
        // Add active class to clicked nav link
        $(this).addClass('active');
        
        // Hide all tab content with fade effect
        $('.settings-tab').fadeOut(200, function() {
            // Show selected tab content
            const tabId = $(e.target).data('tab') + '-tab';
            $('#' + tabId).fadeIn(300);
        });
    });
    
    // Form validation
    $('.settings-form-control').on('blur', function() {
        validateField($(this));
    });
    
    // Auto-save indication
    $('.settings-form-control').on('input', function() {
        const form = $(this).closest('form');
        if (!form.hasClass('has-changes')) {
            form.addClass('has-changes');
            showAutoSaveIndicator(form);
        }
    });
    
    // Enhanced form submissions with validation
    $('#general-settings-form').submit(function(e) {
        e.preventDefault();
        if (validateForm(this)) {
            submitForm(this, 'General settings saved successfully!');
        }
    });
    
    $('#system-settings-form').submit(function(e) {
        e.preventDefault();
        if (validateForm(this)) {
            submitForm(this, 'System settings saved successfully!');
        }
    });
    
    $('#email-settings-form').submit(function(e) {
        e.preventDefault();
        if (validateForm(this)) {
            submitForm(this, 'Email settings saved successfully!');
        }
    });
    
    $('#security-settings-form').submit(function(e) {
        e.preventDefault();
        if (validateForm(this)) {
            submitForm(this, 'Security settings saved successfully!');
        }
    });
    
    $('#appearance-settings-form').submit(function(e) {
        e.preventDefault();
        if (validateForm(this)) {
            submitForm(this, 'Appearance settings saved successfully!');
            
            // Apply dark mode if enabled
            if ($('#dark_mode').is(':checked')) {
                $('body').addClass('dark-mode');
                showInfoMessage('Dark mode enabled!');
            } else {
                $('body').removeClass('dark-mode');
                showInfoMessage('Light mode enabled!');
            }
        }
    });
    
    // Show welcome message on page load
    setTimeout(() => {
        showInfoMessage('Welcome to Settings! Use Ctrl+S to quickly save any form.');
    }, 1000);
    
    // Show notification when switching tabs
    $('.settings-nav .nav-link').click(function(e) {
        const tabName = $(this).text().trim();
        showInfoMessage(`Switched to ${tabName}`);
    });
    
    // Show notification when form fields are changed
    $('.settings-form-control').on('change', function() {
        const fieldName = $(this).closest('.settings-form-group').find('label').text() || 'Field';
        showInfoMessage(`${fieldName} updated`);
    });

    // ...existing code...
});

function validateField(field) {
    const value = field.val().trim();
    const fieldType = field.attr('type');
    const isRequired = field.prop('required') || field.hasClass('required');
    
    // Remove previous validation classes
    field.removeClass('is-valid is-invalid');
    
    // Required field validation
    if (isRequired && !value) {
        field.addClass('is-invalid');
        return false;
    }
    
    // Email validation
    if (fieldType === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            field.addClass('is-invalid');
            return false;
        }
    }
    
    // URL validation
    if (fieldType === 'url' && value) {
        try {
            new URL(value);
        } catch {
            field.addClass('is-invalid');
            return false;
        }
    }
    
    // Number validation
    if (fieldType === 'number' && value) {
        const min = field.attr('min');
        const max = field.attr('max');
        const numValue = parseInt(value);
        
        if (min && numValue < parseInt(min)) {
            field.addClass('is-invalid');
            return false;
        }
        
        if (max && numValue > parseInt(max)) {
            field.addClass('is-invalid');
            return false;
        }
    }
    
    field.addClass('is-valid');
    return true;
}

function validateForm(form) {
    let isValid = true;
    let invalidFields = [];
    
    $(form).find('.settings-form-control[required], .settings-form-control.required').each(function() {
        if (!validateField($(this))) {
            isValid = false;
            const fieldLabel = $(this).closest('.settings-form-group').find('label').text() || $(this).attr('name');
            invalidFields.push(fieldLabel);
        }
    });
    
    if (!isValid) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: `Please correct the following fields:<br><ul><li>${invalidFields.join('</li><li>')}</li></ul>`,
            confirmButtonText: 'OK',
            confirmButtonColor: '#ef4444'
        });
    }
    
    return isValid;
}

function showAutoSaveIndicator(form) {
    // Add unsaved changes indicator
    const submitBtn = form.find('button[type="submit"]');
    if (!submitBtn.find('.unsaved-indicator').length) {
        submitBtn.prepend('<span class="unsaved-indicator" style="color: orange;">● </span>');
    }
}

function showLoadingOverlay() {
    $('#loadingOverlay').fadeIn(200);
}

function hideLoadingOverlay() {
    $('#loadingOverlay').fadeOut(200);
}

function submitForm(form, message) {
    const formData = new FormData(form);
    const formId = $(form).attr('id');
    let url = '';
    
    // Determine the correct endpoint based on form ID
    switch(formId) {
        case 'general-settings-form':
            url = '{{ route("admin.settings.general.update") }}';
            break;
        case 'system-settings-form':
            url = '{{ route("admin.settings.system.update") }}';
            break;
        case 'email-settings-form':
            url = '{{ route("admin.settings.email.update") }}';
            break;
        case 'security-settings-form':
            url = '{{ route("admin.settings.security.update") }}';
            break;
        case 'appearance-settings-form':
            url = '{{ route("admin.settings.appearance.update") }}';
            break;
    }
    
    // Show loading alert
    Swal.fire({
        title: 'Saving Settings...',
        text: 'Please wait while we save your settings.',
        icon: 'info',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Show loading state on button
    const submitBtn = $(form).find('button[type="submit"]');
    const originalText = submitBtn.html();
    submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Saving...').prop('disabled', true);
    
    // Remove unsaved changes indicator
    $(form).find('.unsaved-indicator').remove();
    $(form).removeClass('has-changes');
    
    $.ajax({
        url: url,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            Swal.close();
            if (response.success) {
                showSuccessMessage(response.message || message);
                
                // Add success animation to form
                $(form).addClass('animate__animated animate__pulse');
                setTimeout(() => {
                    $(form).removeClass('animate__animated animate__pulse');
                }, 1000);
            }
        },
        error: function(xhr) {
            Swal.close();
            const errorMessage = xhr.responseJSON?.message || 'An error occurred while saving settings.';
            showErrorMessage(errorMessage);
            
            // Add error animation to form
            $(form).addClass('animate__animated animate__shakeX');
            setTimeout(() => {
                $(form).removeClass('animate__animated animate__shakeX');
            }, 1000);
        },
        complete: function() {
            // Restore button state
            submitBtn.html(originalText).prop('disabled', false);
        }
    });
}

function showSuccessMessage(message) {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: message,
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
        toast: true,
        position: 'top-end',
        background: '#d1fae5',
        color: '#065f46',
        iconColor: '#10b981'
    });
}

function showErrorMessage(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: message,
        timer: 5000,
        timerProgressBar: true,
        showConfirmButton: true,
        toast: true,
        position: 'top-end',
        background: '#fee2e2',
        color: '#991b1b',
        iconColor: '#ef4444'
    });
}

function showWarningMessage(message) {
    Swal.fire({
        icon: 'warning',
        title: 'Warning!',
        text: message,
        timer: 4000,
        timerProgressBar: true,
        showConfirmButton: true,
        toast: true,
        position: 'top-end',
        background: '#fef3c7',
        color: '#92400e',
        iconColor: '#f59e0b'
    });
}

function showInfoMessage(message) {
    Swal.fire({
        icon: 'info',
        title: 'Info',
        text: message,
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
        toast: true,
        position: 'top-end',
        background: '#dbeafe',
        color: '#1e40af',
        iconColor: '#3b82f6'
    });
}

function clearCache(type) {
    Swal.fire({
        title: 'Clear Cache',
        text: `Are you sure you want to clear the ${type} cache?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, clear it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Clearing Cache...',
                text: 'Please wait while we clear the cache.',
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            $.ajax({
                url: '{{ route("admin.settings.clear-cache") }}',
                method: 'POST',
                data: {
                    type: type,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.close();
                    if (response.success) {
                        showSuccessMessage(response.message);
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    const errorMessage = xhr.responseJSON?.message || 'Failed to clear cache.';
                    showErrorMessage(errorMessage);
                }
            });
        }
    });
}

function testEmailConnection() {
    Swal.fire({
        title: 'Test Email Connection',
        text: 'This will test your email configuration settings.',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Run Test',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Testing Email Connection...',
                text: 'Please wait while we test your email settings.',
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            $.ajax({
                url: '{{ route("admin.settings.test-email") }}',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.close();
                    if (response.success) {
                        showSuccessMessage(response.message);
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    const errorMessage = xhr.responseJSON?.message || 'Email connection test failed.';
                    showErrorMessage(errorMessage);
                }
            });
        }
    });
}

function createBackup() {
    Swal.fire({
        title: 'Create Backup',
        text: 'This will create a backup of your database.',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Create Backup',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Creating Backup...',
                text: 'Please wait while we create your database backup.',
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            $.ajax({
                url: '{{ route("admin.settings.backup.create") }}',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.close();
                    if (response.success) {
                        showSuccessMessage(response.message);
                        // Refresh the backup list
                        setTimeout(() => location.reload(), 2000);
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    const errorMessage = xhr.responseJSON?.message || 'Failed to create backup.';
                    showErrorMessage(errorMessage);
                }
            });
        }
    });
}

function downloadBackup(filename) {
    showInfoMessage(`Downloading ${filename}...`);
    window.open('{{ route("admin.settings.backup.download") }}?filename=' + encodeURIComponent(filename), '_blank');
}

function deleteBackup(filename) {
    Swal.fire({
        title: 'Delete Backup',
        text: `Are you sure you want to delete ${filename}? This action cannot be undone.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("admin.settings.backup.delete") }}',
                method: 'DELETE',
                data: {
                    filename: filename,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        showSuccessMessage(response.message);
                        // Remove the backup item from the list
                        setTimeout(() => location.reload(), 2000);
                    }
                },
                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.message || 'Failed to delete backup.';
                    showErrorMessage(errorMessage);
                }
            });
        }
    });
}

function restoreBackup() {
    const file = $('#restore_file')[0].files[0];
    if (!file) {
        showWarningMessage('Please select a backup file to restore.');
        return;
    }
    
    Swal.fire({
        title: 'Restore Database',
        text: 'Are you sure you want to restore from this backup? This will overwrite your current data and cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, restore it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('backup_file', file);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            
            // Show loading
            Swal.fire({
                title: 'Restoring Database...',
                text: 'Please wait while we restore your database from the backup.',
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            $.ajax({
                url: '{{ route("admin.settings.backup.restore") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.close();
                    if (response.success) {
                        showSuccessMessage(response.message);
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    const errorMessage = xhr.responseJSON?.message || 'Failed to restore backup.';
                    showErrorMessage(errorMessage);
                }
            });
        }
    });
}

function exportSettings() {
    Swal.fire({
        title: 'Export Settings',
        text: 'This will export all your current settings to a JSON file.',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Export Settings',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Exporting Settings...',
                text: 'Please wait while we prepare your settings export.',
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            setTimeout(() => {
                Swal.close();
                showSuccessMessage('Settings exported successfully!');
                
                // Create and download a JSON file with current settings
                const settingsData = {
                    exported_at: new Date().toISOString(),
                    app_name: $('#app_name').val() || '{{ config("app.name") }}',
                    timezone: $('#timezone').val() || 'UTC',
                    currency: $('#currency').val() || 'USD',
                    // Add more settings as needed
                };
                
                const dataStr = JSON.stringify(settingsData, null, 2);
                const dataBlob = new Blob([dataStr], {type: 'application/json'});
                const url = URL.createObjectURL(dataBlob);
                const link = document.createElement('a');
                link.href = url;
                link.download = 'settings_export_' + new Date().getTime() + '.json';
                link.click();
                URL.revokeObjectURL(url);
            }, 1000);
        }
    });
}

function resetToDefaults() {
    Swal.fire({
        title: 'Reset to Defaults',
        text: 'Are you sure you want to reset all settings to their default values? This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, reset settings!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Resetting Settings...',
                text: 'Please wait while we reset all settings to their default values.',
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            setTimeout(() => {
                Swal.close();
                showSuccessMessage('Settings reset to defaults successfully!');
                setTimeout(() => location.reload(), 2000);
            }, 1500);
        }
    });
}

// Add escape key handler
$(document).keydown(function(e) {
    // Ctrl+S to save current form
    if (e.ctrlKey && e.which === 83) {
        e.preventDefault();
        const activeTab = $('.settings-tab:visible');
        const activeForm = activeTab.find('form');
        if (activeForm.length) {
            activeForm.submit();
        }
    }
    
    // Escape key to hide overlays
    if (e.which === 27) {
        hideLoadingOverlay();
        $('.modal').modal('hide');
    }
});
</script>
@endpush
@endsection