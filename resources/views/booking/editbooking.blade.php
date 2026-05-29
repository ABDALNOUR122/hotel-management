@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title mt-5">Edit Booking</h3>
                    </div>
                </div>
            </div>
            <form action="{{ route('form/booking/update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $bookingEdit->id }}">
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row formtype">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Booking ID</label>
                                    <input class="form-control" type="text" value="{{ $bookingEdit->id }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Customer Name</label>
                                    <select class="form-control @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id">
                                        <option disabled> --Select Customer-- </option>
                                        @foreach ($customers as $customer)
                                            <option {{ old('customer_id', $bookingEdit->customer_id) == $customer->id ? "selected" : "" }} value="{{ $customer->id }}">
                                                {{ $customer->name }} ({{ $customer->phone }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Room Number / Type</label>
                                    <select class="form-control @error('room_id') is-invalid @enderror" id="room_id" name="room_id">
                                        <option disabled> --Select Room-- </option>
                                        @foreach ($rooms as $room)
                                            <option {{ old('room_id', $bookingEdit->room_id) == $room->id ? "selected" : "" }} value="{{ $room->id }}">
                                                Room No: {{ $room->room_number }} - {{ $room->type }} (${{ $room->price }}/night)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('room_id')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Check In Date</label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker @error('check_in') is-invalid @enderror" id="check_in" name="check_in" value="{{ old('check_in', $bookingEdit->check_in) }}">
                                    </div>
                                    @error('check_in')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Check Out Date</label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker @error('check_out') is-invalid @enderror" id="check_out" name="check_out" value="{{ old('check_out', $bookingEdit->check_out) }}"> 
                                    </div>
                                    @error('check_out')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Days</label>
                                    <input type="number" class="form-control @error('total_days') is-invalid @enderror" id="total_days" name="total_days" value="{{ old('total_days', $bookingEdit->total_days) }}" readonly>
                                    @error('total_days')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary buttonedit">Update</button>
            </form>
        </div>
    </div>

    @section('script')
    <script>
        $(document).ready(function() {
            function calculateDays() {
                var checkInStr = $('#check_in').val();
                var checkOutStr = $('#check_out').val();
                
                if (checkInStr && checkOutStr) {
                    var checkInDate = new Date(checkInStr);
                    var checkOutDate = new Date(checkOutStr);
                    
                    if (checkOutDate > checkInDate) {
                        var diffTime = Math.abs(checkOutDate - checkInDate);
                        var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                        $('#total_days').val(diffDays);
                    } else {
                        $('#total_days').val(0);
                    }
                }
            }

            $(document).on('change', '#check_in, #check_out', function() {
                calculateDays();
            });
        });
    </script>
    @endsection
@endsection