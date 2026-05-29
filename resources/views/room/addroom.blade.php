@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title mt-5">Add New Room</h3>
                    </div>
                </div>
            </div>
            
            <form action="{{ route('form/room/save') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row formtype">
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Room Number</label>
                                    <input type="text" class="form-control @error('room_number') is-invalid @enderror" id="room_number" name="room_number" value="{{ old('room_number') }}" placeholder="e.g. 101, 204">
                                    @error('room_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Room Type</label>
                                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                                        <option selected disabled> --Select Room Type-- </option>
                                        <option value="Single" {{ old('type') == 'Single' ? 'selected' : '' }}>Single</option>
                                        <option value="Double" {{ old('type') == 'Double' ? 'selected' : '' }}>Double</option>
                                        <option value="Suite" {{ old('type') == 'Suite' ? 'selected' : '' }}>Suite</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Price (Per Night)</label>
                                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" placeholder="0.00">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="Available" {{ old('status') == 'Available' ? 'selected' : '' }}>Available </option>
                                        <option value="Booked" {{ old('status') == 'Booked' ? 'selected' : '' }}>Booked </option>
                                        <option value="Maintenance" {{ old('status') == 'Maintenance' ? 'selected' : '' }}>Maintenance </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary buttonedit ml-2">Save Room</button>
                    <a href="{{ route('form/allrooms/page') }}" class="btn btn-secondary buttonedit">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection