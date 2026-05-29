@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title mt-5">Add Booking</h3>
                    </div>
                </div>
            </div>
            <form action="{{ route('form/booking/save') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row formtype">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Customer Name</label>
                                    <select class="form-control @error('customer_id') is-invalid @enderror" id="customer_id"
                                        name="customer_id">
                                        <option selected disabled> --Select Customer-- </option>
                                        @foreach ($customers as $customer)
                                            <option {{ old('customer_id') == $customer->id ? "selected" : "" }}
                                                value="{{ $customer->id }}">
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
                                    <select class="form-control @error('room_id') is-invalid @enderror" id="room_id"
                                        name="room_id">
                                        <option selected disabled> --Select Room-- </option>
                                        @foreach ($rooms as $room)
                                            <option {{ old('room_id') == $room->id ? "selected" : "" }} value="{{ $room->id }}">
                                                Room No: {{ $room->room_number }} - {{ $room->type }}
                                                (${{ $room->price }}/night)
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
                                        <input type="text"
                                            class="form-control datetimepicker @error('check_in') is-invalid @enderror"
                                            id="check_in" name="check_in" value="{{ old('check_in') }}">
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
                                        <input type="text"
                                            class="form-control datetimepicker @error('check_out') is-invalid @enderror"
                                            id="check_out" name="check_out" value="{{ old('check_out') }}">
                                    </div>
                                    @error('check_out')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Days</label>
                                    <input type="number" class="form-control @error('total_days') is-invalid @enderror"
                                        id="total_days" name="total_days" value="{{ old('total_days') }}" readonly>
                                    @error('total_days')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary buttonedit1">Create Booking</button>
            </form>
        </div>
    </div>

    @section('script')
        <script>
            $(document).ready(function () {
                function parseArabicDate(dateStr) {
                    if (!dateStr) return null;
                    var parts = dateStr.split('/');
                    if (parts.length === 3) {
                        return new Date(parts[2], parts[1] - 1, parts[0]);
                    }
                    return new Date(dateStr);
                }

                function calculateDays() {
                    var checkInStr = $('#check_in').val();
                    var checkOutStr = $('#check_out').val();

                    if (checkInStr && checkOutStr) {
                        var checkInDate = parseArabicDate(checkInStr);
                        var checkOutDate = parseArabicDate(checkOutStr);

                        if (checkInDate && checkOutDate && !isNaN(checkInDate) && !isNaN(checkOutDate)) {
                            if (checkOutDate >= checkInDate) {
                                var diffTime = checkOutDate - checkInDate;
                                var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                                $('#total_days').val(diffDays === 0 ? 1 : diffDays);
                            } else {
                                $('#total_days').val(0);
                            }
                        }
                    }
                }

                $(document).on('change', '#check_in, #check_out', function () {
                    calculateDays();
                });

                $('.datetimepicker').on('dp.change', function () {
                    calculateDays();
                });
            });
        </script>
    @endsection
@endsection