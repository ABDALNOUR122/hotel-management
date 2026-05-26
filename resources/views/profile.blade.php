@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header mt-5">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">User Profile</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card text-center shadow-sm mb-4">
                        <div class="card-body">
                            <div class="position-relative d-inline-block mb-3">
                                <img class="rounded-circle img-thumbnail p-2 shadow-sm" alt="Hotel Logo"
                                    src="{{ URL::to('assets/img/hotel_logo.png') }}"
                                    style="width: 130px; height: 200; object-fit: contain; background: #044e38;">
                            </div>
                            <h4 class="font-weight-bold mb-1 text-dark">{{ Auth::user()->name }}</h4>
                            <p class="text-muted small mb-3">
                                <span class="badge badge-pill badge-primary px-3 py-2">{{ Auth::user()->role_name }}</span>
                            </p>
                            <hr>
                            <div class="text-left px-3">
                                <p class="small text-muted mb-1"><i class="fas fa-calendar-alt mr-2"></i> Member Since</p>
                                <h6 class="text-dark font-weight-bold mb-0">{{ Auth::user()->join_date ?? 'N/A' }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="profile-menu mb-3">
                        <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#per_details_tab">
                                    <i class="fas fa-user mr-1"></i> Personal Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#password_tab">
                                    <i class="fas fa-lock mr-1"></i> Security & Password
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content profile-tab-cont">
                        <div class="tab-pane fade show active" id="per_details_tab">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white font-weight-bold text-dark p-3">
                                    <i class="fas fa-id-card text-primary mr-2"></i> Overview Information
                                </div>
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="text-muted small font-weight-bold text-uppercase">Full
                                                Name</label>
                                            <div class="d-flex align-items-center bg-light p-3 rounded">
                                                <i class="fas fa-user-circle text-secondary mr-3 fa-lg"></i>
                                                <span class="text-dark font-weight-bold">{{ Auth::user()->name }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label class="text-muted small font-weight-bold text-uppercase">Email
                                                Address</label>
                                            <div class="d-flex align-items-center bg-light p-3 rounded">
                                                <i class="fas fa-envelope text-secondary mr-3 fa-lg"></i>
                                                <span class="text-dark">{{ Auth::user()->email }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label class="text-muted small font-weight-bold text-uppercase">Phone
                                                Number</label>
                                            <div class="d-flex align-items-center bg-light p-3 rounded">
                                                <i class="fas fa-phone text-secondary mr-3 fa-lg"></i>
                                                <span class="text-dark">{{ Auth::user()->phone_number ?? 'Not Set' }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label class="text-muted small font-weight-bold text-uppercase">Current
                                                Position</label>
                                            <div class="d-flex align-items-center bg-light p-3 rounded">
                                                <i class="fas fa-briefcase text-secondary mr-3 fa-lg"></i>
                                                <span
                                                    class="text-dark font-weight-bold">{{ Auth::user()->position ?? 'Staff' }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="text-muted small font-weight-bold text-uppercase">Assigned
                                                Department</label>
                                            <div class="d-flex align-items-center bg-light p-3 rounded">
                                                <i class="fas fa-building text-secondary mr-3 fa-lg"></i>
                                                <span class="text-dark">{{ Auth::user()->department ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="password_tab" class="tab-pane fade">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white font-weight-bold text-dark p-3">
                                    <i class="fas fa-shield-alt text-primary mr-2"></i> Account Security
                                </div>
                                <div class="card-body p-4">

                                    @if(session('success'))
                                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    <form action="{{ route('profile.change-password') }}" method="POST">
                                        @csrf

                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold text-muted small">Current Password</label>
                                            <input type="password"
                                                class="form-control @error('current_password') is-invalid @enderror"
                                                name="current_password" placeholder="••••••••"
                                                value="{{ old('current_password') }}">
                                            @error('current_password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold text-muted small">New Password</label>
                                            <input type="password"
                                                class="form-control @error('new_password') is-invalid @enderror"
                                                name="new_password" placeholder="Minimum 8 characters">
                                            @error('new_password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-4">
                                            <label class="font-weight-bold text-muted small">Confirm New Password</label>
                                            <input type="password" class="form-control" name="new_password_confirmation"
                                                placeholder="Repeat new password">
                                        </div>

                                        <button class="btn btn-primary px-4" type="submit">Update Password</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('active_tab') == 'security')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let securityTabLink = document.querySelector('a[href="#password_tab"]');
                if (securityTabLink) {
                    securityTabLink.click();
                }
            });
        </script>
    @endif
@endsection