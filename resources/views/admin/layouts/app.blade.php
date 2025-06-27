<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <meta name="author" content="Laboratory Management System">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/2.4.0/css/OverlayScrollbars.min.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css">
    
    <!-- Custom Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin-responsive.css') }}">
    
    <!-- Enhanced AdminLTE3 Customizations -->
    <link rel="stylesheet" href="{{ asset('css/admin-enhanced.css') }}">
    
    <!-- Global Enhanced CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin-global-enhanced.css') }}">
    
    @yield('styles')
    
    <!-- Custom User Menu Styles -->
    <style>
        .navbar-nav .user-menu .user-image {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            margin-right: 10px;
            margin-top: -2px;
        }
        
        .navbar-nav .user-menu .dropdown-menu {
            border-top-right-radius: 0;
            border-top-left-radius: 0;
            padding: 0;
            width: 280px;
        }
        
        .user-header {
            height: 175px;
            padding: 10px;
            text-align: center;
        }
        
        .user-header > img {
            z-index: 5;
            height: 90px;
            width: 90px;
            border: 3px solid;
            border-color: transparent;
            border-color: rgba(255, 255, 255, 0.2);
        }
        
        .user-footer {
            background-color: #f4f4f4;
            padding: 10px;
        }
        
        .user-footer .btn-default {
            color: #666;
        }
        
        /* Enhanced Mobile Responsiveness */
        @media (max-width: 767px) {
            .navbar-nav .user-menu .dropdown-menu {
                width: 280px;
                margin-left: -79px;
            }
            
            .content-wrapper {
                padding: 10px;
            }
            
            .content-header h1 {
                font-size: 1.5rem;
            }
            
            .breadcrumb {
                font-size: 0.8rem;
            }
        }
        
        /* Improved Sidebar */
        .main-sidebar .nav-sidebar .nav-item > .nav-link {
            padding: 0.7rem 1rem;
            transition: all 0.3s ease;
            border-radius: 0.25rem;
            margin: 0.1rem 0.5rem;
        }
        
        .main-sidebar .nav-sidebar .nav-item > .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        
        .main-sidebar .nav-sidebar .nav-item > .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            border-left: 3px solid #fff;
            font-weight: 600;
        }

        /* Sidebar Headers */
        .nav-header {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1rem 1rem 0.5rem 1rem;
            margin-top: 1rem;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Treeview Improvements */
        .nav-treeview .nav-item .nav-link {
            padding-left: 3rem;
            font-size: 0.9rem;
        }

        .nav-treeview .nav-item .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.05);
            padding-left: 3.2rem;
        }

        .nav-treeview .nav-item .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 0.25rem;
            margin: 0.1rem 0.5rem;
            font-weight: 500;
        }

        /* Brand Link Enhancement */
        .brand-link {
            padding: 0.8rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .brand-link:hover {
            text-decoration: none;
            background-color: rgba(255, 255, 255, 0.05);
        }

        /* User Panel Enhancement */
        .user-panel {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-panel .info a {
            color: #c2c7d0;
            font-weight: 500;
        }

        /* Icon Improvements */
        .nav-icon {
            margin-right: 0.5rem;
            width: 1.2rem;
            text-align: center;
        }

        /* Sidebar Animation */
        .main-sidebar {
            transition: all 0.3s ease;
        }

        /* Mobile Sidebar */
        @media (max-width: 767px) {
            .main-sidebar {
                margin-left: -250px;
            }
            
            .sidebar-open .main-sidebar {
                margin-left: 0;
            }
        }

        /* Dark Mode Sidebar Enhancements */
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active {
            background-color: #007bff;
            color: #fff;
            box-shadow: 0 2px 4px rgba(0, 123, 255, 0.3);
        }

        .sidebar-dark-primary .nav-treeview > .nav-item > .nav-link.active {
            background-color: rgba(0, 123, 255, 0.8);
            color: #fff;
        }
        
        /* Enhanced Cards */
        .card {
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            border: none;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        /* Alert Improvements */
        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
        }
        
        /* Button Enhancements */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-1px);
        }
        
        /* Table Improvements */
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        
        .table thead th {
            border-bottom: none;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .table tbody tr:hover {
            background-color: #f8fafc;
        }
        
        /* Remove unwanted outlines globally */
        * {
            outline: none !important;
        }
        
        *:focus {
            outline: none !important;
        }
        
        /* Browser focus indicator override */
        :focus-visible {
            outline: none !important;
            box-shadow: none !important;
        }
        
        /* Remove any default browser outlines */
        input:focus,
        textarea:focus,
        select:focus,
        button:focus,
        a:focus,
        div:focus {
            outline: none !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3) !important;
        }
        
        /* Remove outlines from containers */
        .container,
        .container-fluid,
        .card,
        .table-responsive,
        .modal,
        .row,
        .col,
        [class*="col-"] {
            outline: none !important;
            border: none !important;
        }
        
        /* Restore important borders where needed */
        .table {
            border: none !important;
        }
        
        .table th,
        .table td {
            border-top: 1px solid #dee2e6 !important;
            border-bottom: none !important;
            border-left: none !important;
            border-right: none !important;
        }
        
        .card {
            border: 1px solid rgba(0,0,0,.125) !important;
        }
    </style>
    
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="fas fa-home mr-1"></i>Home
                    </a>
                </li>
            </ul>

            <!-- Center Title for Mobile -->
            <div class="navbar-nav mx-auto d-sm-none">
                <span class="nav-link font-weight-bold">@yield('page-title', 'Dashboard')</span>
            </div>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                
                <!-- User Account: style can be found in dropdown.less -->
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/img/user2-160x160.jpg" class="user-image img-circle elevation-2" alt="User Image">
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-primary">
                            <img src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                            <p>
                                {{ Auth::user()->name }}
                                <small>{{ Auth::user()->role->name ?? 'User' }}</small>
                            </p>
                        </li>
                        
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <a href="{{ route('profile.edit') }}" class="btn btn-default btn-flat">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="float-right">
                                @csrf
                                <button type="submit" class="btn btn-default btn-flat">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Sign out
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('admin.dashboard') }}" class="brand-link">
                <i class="fas fa-microscope brand-image img-circle elevation-3 text-white" style="opacity: .8; margin-left: 0.5rem; margin-right: 0.5rem;"></i>
                <span class="brand-text font-weight-light">Lab Management</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- Divider -->
                        <li class="nav-header">LABORATORY MANAGEMENT</li>

                        <!-- Patient Management -->
                        <li class="nav-item {{ request()->is('admin/patients*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('admin/patients*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-injured"></i>
                                <p>
                                    Patient Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.patients') }}" class="nav-link {{ request()->routeIs('admin.patients') && !request()->routeIs('admin.patients.create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Patients</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.patients.create') }}" class="nav-link {{ request()->routeIs('admin.patients.create') ? 'active' : '' }}">
                                        <i class="far fa-plus-square nav-icon"></i>
                                        <p>Add New Patient</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Test Management -->
                        <li class="nav-item {{ request()->is('admin/tests*') || request()->is('admin/test-categories*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('admin/tests*') || request()->is('admin/test-categories*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-vials"></i>
                                <p>
                                    Test Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.test-categories') }}" class="nav-link {{ request()->routeIs('admin.test-categories*') ? 'active' : '' }}">
                                        <i class="far fa-folder nav-icon"></i>
                                        <p>Test Categories</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.tests') }}" class="nav-link {{ request()->routeIs('admin.tests*') ? 'active' : '' }}">
                                        <i class="far fa-flask nav-icon"></i>
                                        <p>Laboratory Tests</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.packages') }}" class="nav-link {{ request()->routeIs('admin.packages*') ? 'active' : '' }}">
                                        <i class="far fa-box nav-icon"></i>
                                        <p>Test Packages</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Report Management -->
                        <li class="nav-item {{ request()->is('admin/reports*') || request()->is('admin/entry*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('admin/reports*') || request()->is('admin/entry*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-medical-alt"></i>
                                <p>
                                    Report Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.entry.test-booking') }}" class="nav-link {{ request()->routeIs('admin.entry.test-booking*') ? 'active' : '' }}">
                                        <i class="far fa-calendar-plus nav-icon"></i>
                                        <p>Test Booking</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.entry.sample-collection') }}" class="nav-link {{ request()->routeIs('admin.entry.sample-collection*') ? 'active' : '' }}">
                                        <i class="far fa-syringe nav-icon"></i>
                                        <p>Sample Collection</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.entry.result-entry') }}" class="nav-link {{ request()->routeIs('admin.entry.result-entry*') ? 'active' : '' }}">
                                        <i class="far fa-edit nav-icon"></i>
                                        <p>Result Entry</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.reports') }}" class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                                        <i class="far fa-file-alt nav-icon"></i>
                                        <p>All Reports</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.entry.entry-list') }}" class="nav-link {{ request()->routeIs('admin.entry.entry-list*') ? 'active' : '' }}">
                                        <i class="far fa-list nav-icon"></i>
                                        <p>Entry List</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Doctor Management -->
                        <li class="nav-item {{ request()->is('admin/doctors*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('admin/doctors*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-md"></i>
                                <p>
                                    Doctor Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.doctors') }}" class="nav-link {{ request()->routeIs('admin.doctors') && !request()->routeIs('admin.doctors.create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Doctors</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.doctors.create') }}" class="nav-link {{ request()->routeIs('admin.doctors.create') ? 'active' : '' }}">
                                        <i class="far fa-plus-square nav-icon"></i>
                                        <p>Add New Doctor</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Divider -->
                        <li class="nav-header">BUSINESS MANAGEMENT</li>

                        <!-- Finance & Billing -->
                        <li class="nav-item {{ request()->is('admin/billing*') || request()->is('admin/invoices*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('admin/billing*') || request()->is('admin/invoices*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-receipt"></i>
                                <p>
                                    Finance & Billing
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-money-bill-alt nav-icon"></i>
                                        <p>Billing</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-file-invoice nav-icon"></i>
                                        <p>Invoices</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-chart-bar nav-icon"></i>
                                        <p>Revenue Reports</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Partner Management -->
                        <li class="nav-item {{ request()->is('admin/associates*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('admin/associates*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-handshake"></i>
                                <p>
                                    Partner Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.associates') }}" class="nav-link {{ request()->routeIs('admin.associates*') ? 'active' : '' }}">
                                        <i class="far fa-building nav-icon"></i>
                                        <p>Associates</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-percentage nav-icon"></i>
                                        <p>Commission Management</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Divider -->
                        <li class="nav-header">SYSTEM MANAGEMENT</li>

                        <!-- User Management -->
                        <li class="nav-item {{ request()->is('admin/users*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>
                                    User Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                                        <i class="far fa-users nav-icon"></i>
                                        <p>All Users</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-user-shield nav-icon"></i>
                                        <p>Roles & Permissions</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Reports & Analytics -->
                        <li class="nav-item {{ request()->is('admin/analytics*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('admin/analytics*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>
                                    Reports & Analytics
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-chart-pie nav-icon"></i>
                                        <p>Laboratory Analytics</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-calendar-check nav-icon"></i>
                                        <p>Daily Reports</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-calendar-alt nav-icon"></i>
                                        <p>Monthly Reports</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-file-export nav-icon"></i>
                                        <p>Export Data</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Settings -->
                        <li class="nav-item {{ request()->is('admin/settings*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Settings
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                                        <i class="far fa-cog nav-icon"></i>
                                        <p>General Settings</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-envelope nav-icon"></i>
                                        <p>Email Settings</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-database nav-icon"></i>
                                        <p>Backup & Restore</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-shield-alt nav-icon"></i>
                                        <p>Security Settings</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Divider -->
                        <li class="nav-header">QUICK ACTIONS</li>

                        <!-- Quick Add -->
                        <li class="nav-item">
                            <a href="#" class="nav-link" data-toggle="modal" data-target="#quickAddModal" title="Ctrl + N">
                                <i class="nav-icon fas fa-plus-circle text-success"></i>
                                <p>Quick Add Patient</p>
                            </a>
                        </li>

                        <!-- Quick Search -->
                        <li class="nav-item">
                            <a href="#" class="nav-link" data-toggle="modal" data-target="#quickSearchModal" title="Ctrl + F">
                                <i class="nav-icon fas fa-search text-info"></i>
                                <p>Quick Search</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">@yield('breadcrumb', 'Dashboard')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            {{ session('warning') }}
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="alert alert-info alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="fas fa-info-circle mr-2"></i>
                            {{ session('info') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <strong>Copyright &copy; {{ date('Y') }} <a href="{{ config('app.url') }}">{{ config('app.name') }}</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/2.4.0/js/OverlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize AdminLTE
            if (typeof $.AdminLTE !== 'undefined') {
                $.AdminLTE.init();
            }
            
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
            
            // Mobile sidebar behavior
            if ($(window).width() <= 768) {
                $('body').addClass('sidebar-collapse');
            }
            
            $(window).resize(function() {
                if ($(window).width() <= 768) {
                    $('body').addClass('sidebar-collapse');
                } else {
                    $('body').removeClass('sidebar-collapse');
                }
            });
            
            // Smooth scrolling for anchor links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if( target.length ) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 1000);
                }
            });
            
            // Add loading spinner to forms
            $('form').on('submit', function() {
                var submitBtn = $(this).find('button[type="submit"]');
                if (submitBtn.length) {
                    submitBtn.prop('disabled', true);
                    submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Processing...');
                }
            });
            
            // Remove any unwanted outlines that might appear
            function removeOutlines() {
                $('*').css('outline', 'none');
                $('.table, th, td').css('border', ''); // Preserve table borders
            }
            
            // Call removeOutlines periodically and on focus events
            removeOutlines();
            setInterval(removeOutlines, 2000);
            
            $(document).on('focusin', '*', function() {
                $(this).css('outline', 'none');
            });
            
            // Keyboard Shortcuts
            $(document).keydown(function(e) {
                // Ctrl + N for Quick Add Patient
                if (e.ctrlKey && e.keyCode === 78) {
                    e.preventDefault();
                    $('#quickAddModal').modal('show');
                    return false;
                }
                
                // Ctrl + F for Quick Search
                if (e.ctrlKey && e.keyCode === 70) {
                    e.preventDefault();
                    $('#quickSearchModal').modal('show');
                    setTimeout(() => {
                        $('#searchQuery').focus();
                    }, 500);
                    return false;
                }
                
                // Escape to close modals
                if (e.keyCode === 27) {
                    $('.modal').modal('hide');
                }
            });
            
            // Add tooltips for keyboard shortcuts
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    
    @stack('scripts')

    <!-- Quick Add Patient Modal -->
    <div class="modal fade" id="quickAddModal" tabindex="-1" role="dialog" aria-labelledby="quickAddModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white" id="quickAddModalLabel">
                        <i class="fas fa-plus-circle mr-2"></i>Quick Add Patient
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="quickAddForm">
                        <div class="form-group">
                            <label for="patientName">Patient Name</label>
                            <input type="text" class="form-control" id="patientName" placeholder="Enter patient name" required>
                        </div>
                        <div class="form-group">
                            <label for="patientPhone">Phone Number</label>
                            <input type="tel" class="form-control" id="patientPhone" placeholder="Enter phone number" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="patientAge">Age</label>
                                    <input type="number" class="form-control" id="patientAge" placeholder="Age" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="patientGender">Gender</label>
                                    <select class="form-control" id="patientGender" required>
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="saveQuickPatient()">
                        <i class="fas fa-save mr-2"></i>Save Patient
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Search Modal -->
    <div class="modal fade" id="quickSearchModal" tabindex="-1" role="dialog" aria-labelledby="quickSearchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-white" id="quickSearchModalLabel">
                        <i class="fas fa-search mr-2"></i>Quick Search
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="searchQuery">Search for patients, reports, or tests</label>
                        <input type="text" class="form-control form-control-lg" id="searchQuery" placeholder="Type to search..." oninput="performQuickSearch(this.value)">
                    </div>
                    <div id="searchResults" class="mt-3">
                        <div class="text-center text-muted">
                            <i class="fas fa-search fa-2x mb-2"></i>
                            <p>Start typing to search...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Quick Add Patient Function
        function saveQuickPatient() {
            const name = document.getElementById('patientName').value;
            const phone = document.getElementById('patientPhone').value;
            const age = document.getElementById('patientAge').value;
            const gender = document.getElementById('patientGender').value;
            
            if (!name || !phone || !age || !gender) {
                Swal.fire('Error', 'Please fill all required fields', 'error');
                return;
            }
            
            // Here you would typically make an AJAX call to save the patient
            // For demo purposes, we'll just show a success message
            Swal.fire({
                title: 'Success!',
                text: 'Patient added successfully',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                $('#quickAddModal').modal('hide');
                document.getElementById('quickAddForm').reset();
            });
        }
        
        // Quick Search Function
        function performQuickSearch(query) {
            const resultsDiv = document.getElementById('searchResults');
            
            if (query.length < 2) {
                resultsDiv.innerHTML = `
                    <div class="text-center text-muted">
                        <i class="fas fa-search fa-2x mb-2"></i>
                        <p>Start typing to search...</p>
                    </div>
                `;
                return;
            }
            
            // Simulate search results (replace with actual AJAX call)
            resultsDiv.innerHTML = `
                <div class="text-center">
                    <i class="fas fa-spinner fa-spin"></i> Searching...
                </div>
            `;
            
            setTimeout(() => {
                resultsDiv.innerHTML = `
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><i class="fas fa-user mr-2"></i>John Doe</h6>
                                <small>Patient</small>
                            </div>
                            <p class="mb-1">Phone: +1234567890</p>
                            <small>Last visit: 2 days ago</small>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><i class="fas fa-file-medical mr-2"></i>Report #RPT001</h6>
                                <small>Report</small>
                            </div>
                            <p class="mb-1">Patient: Jane Smith</p>
                            <small>Created: 1 week ago</small>
                        </div>
                    </div>
                `;
            }, 500);
        }
    </script>
</body>
</html>