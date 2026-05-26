@extends('layouts.master')
@section('content')
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title mt-5">Edit Customer</h3>
                    </div>
                </div>
            </div>
            <form action="{{ route('form/customer/update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $customerEdit->id }}">
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row formtype">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name', $customerEdit->name) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" value="{{ old('phone', $customerEdit->phone) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" value="{{ old('email', $customerEdit->email) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary buttonedit ml-2">Update</button>
                    <a href="{{ route('form/allcustomers/page') }}" class="btn btn-secondary buttonedit">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection