@extends('admin.layouts.app')

@section('title', 'Profile Settings')
@section('page-title', 'Profile')
@section('breadcrumb', 'Profile Settings')

@section('content')
<div class="row">
    <div class="col-md-6">
        <!-- Profile Information Card -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user mr-2"></i>Profile Information
                </h3>
            </div>
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Delete Account Card -->
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-trash mr-2"></i>Delete Account
                </h3>
            </div>
            <div class="card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <!-- Update Password Card -->
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-lock mr-2"></i>Update Password
                </h3>
            </div>
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
</div>
@endsection
