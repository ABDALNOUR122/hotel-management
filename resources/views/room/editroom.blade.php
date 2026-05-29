@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title mt-5">Edit Room</h3>
                    </div>
                </div>
            </div>

            <form action="{{ route('form/room/update') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row formtype">

                            <input type="hidden" name="id" value="{{ $roomEdit->id }}">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Room Number</label>
                                    <input class="form-control @error('room_number') is-invalid @enderror" type="text"
                                        name="room_number" value="{{ old('room_number', $roomEdit->room_number) }}">
                                    @error('room_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Room Type</label>
                                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                                        <option value="Single" {{ old('type', $roomEdit->type) == 'Single' ? 'selected' : '' }}>Single</option>
                                        <option value="Double" {{ old('type', $roomEdit->type) == 'Double' ? 'selected' : '' }}>Double</option>
                                        <option value="Suite" {{ old('type', $roomEdit->type) == 'Suite' ? 'selected' : '' }}>
                                            Suite</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Price (Per Night)</label>
                                    <input class="form-control @error('price') is-invalid @enderror" type="number"
                                        step="0.01" id="price" name="price" value="{{ old('price', $roomEdit->price) }}">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status"
                                        name="status">
                                        <option value="Available" {{ old('status', $roomEdit->status) == 'Available' ? 'selected' : '' }}>Available </option>
                                        <option value="Booked" {{ old('status', $roomEdit->status) == 'Booked' ? 'selected' : '' }}>Booked </option>
                                        <option value="Maintenance" {{ old('status', $roomEdit->status) == 'Maintenance' ? 'selected' : '' }}>Maintenance </option>
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
                    <button type="submit" class="btn btn-primary buttonedit ml-2">Update Room</button>
                    <a href="{{ route('form/allrooms/page') }}" class="btn btn-secondary buttonedit">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection