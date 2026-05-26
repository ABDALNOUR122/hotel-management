@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title mt-5">Edit User</h3>
                    </div>
                </div>
            </div>
            <form action="{{ route('users/update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ $userData->user_id }}">
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row formtype">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $userData->name) }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $userData->email) }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number', $userData->phone_number) }}">
                                    @error('phone_number')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Role Name</label>
                                    <select class="form-control @error('role_name') is-invalid @enderror" name="role_name">
                                        <option value="" disabled>-- Select Role --</option>
                                        <option value="Admin" {{ old('role_name', $userData->role_name) == 'Admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="Manager" {{ old('role_name', $userData->role_name) == 'Manager' ? 'selected' : '' }}>Manager</option>
                                        <option value="Staff" {{ old('role_name', $userData->role_name) == 'Staff' ? 'selected' : '' }}>Staff</option>
                                    </select>
                                    @error('role_name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Position</label>
                                    <select class="form-control @error('position') is-invalid @enderror" name="position">
                                        <option value="" disabled>-- Select Position --</option>
                                        <option value="General Manager" {{ old('position', $userData->position) == 'General Manager' ? 'selected' : '' }}>General Manager</option>
                                        <option value="Receptionist" {{ old('position', $userData->position) == 'Receptionist' ? 'selected' : '' }}>Receptionist</option>
                                        <option value="Housekeeper" {{ old('position', $userData->position) == 'Housekeeper' ? 'selected' : '' }}>Housekeeper</option>
                                        <option value="Chef" {{ old('position', $userData->position) == 'Chef' ? 'selected' : '' }}>Chef</option>
                                        <option value="Waiter" {{ old('position', $userData->position) == 'Waiter' ? 'selected' : '' }}>Waiter</option>
                                        <option value="Accountant" {{ old('position', $userData->position) == 'Accountant' ? 'selected' : '' }}>Accountant</option>
                                        <option value="Security Officer" {{ old('position', $userData->position) == 'Security Officer' ? 'selected' : '' }}>Security Officer</option>
                                    </select>
                                    @error('position')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Department</label>
                                    <select class="form-control @error('department') is-invalid @enderror" name="department">
                                        <option value="" disabled>-- Select Department --</option>
                                        <option value="Administration" {{ old('department', $userData->department) == 'Administration' ? 'selected' : '' }}>Administration</option>
                                        <option value="Front Office" {{ old('department', $userData->department) == 'Front Office' ? 'selected' : '' }}>Front Office</option>
                                        <option value="Housekeeping" {{ old('department', $userData->department) == 'Housekeeping' ? 'selected' : '' }}>Housekeeping</option>
                                        <option value="Food & Beverage" {{ old('department', $userData->department) == 'Food & Beverage' ? 'selected' : '' }}>Food & Beverage</option>
                                        <option value="Finance & Accounting" {{ old('department', $userData->department) == 'Finance & Accounting' ? 'selected' : '' }}>Finance & Accounting</option>
                                        <option value="Security" {{ old('department', $userData->department) == 'Security' ? 'selected' : '' }}>Security</option>
                                    </select>
                                    @error('department')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Password (Leave blank to keep current)</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation">
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary buttonedit1">Update</button>
            </form>
        </div>
    </div>
    @section('script')
    <script>
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = document.getElementById("customFile").files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    </script>
    @endsection
@endsection