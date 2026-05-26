@extends('layouts.master')
@section('content')

    <?php
    $hour = date("G");
    $minute = date("i");
    $second = date("s");
    $msg = " Today is " . date("l, M. d, Y.");

    if ($hour >= 0 && $hour <= 9 && $minute <= 59 && $second <= 59) {
        $greet = "Good Morning,";
    } else if ($hour >= 10 && $hour <= 11 && $minute <= 59 && $second <= 59) {
        $greet = "Good Day,";
    } else if ($hour >= 12 && $hour <= 15 && $minute <= 59 && $second <= 59) {
        $greet = "Good Afternoon,";
    } else if ($hour >= 16 && $hour <= 23 && $minute <= 59 && $second <= 59) {
        $greet = "Good Evening,";
    } else {
        $greet = "Welcome,";
    }
    ?>

    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12 mt-5">
                        <h6>{{$msg}}</h6>
                        <h3 class="page-title mt-3">{{ $greet }} {{ Auth::user()->name }}!</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card board1 fill">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <div>
                                    <h3 class="card_widget_header">{{ $totalBookings }}</h3>
                                    <h6 class="text-muted">Total Booking</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted">
                                        <i class="fas fa-hotel fa-2x text-primary"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card board1 fill">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <div>
                                    <h3 class="card_widget_header">{{ $totalCustomers }}</h3>
                                    <h6 class="text-muted">Total Customers</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted">
                                        <i class="fas fa-users fa-2x text-success"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card board1 fill">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <div>
                                    <h3 class="card_widget_header">{{ $totalAvailableRooms }}</h3>
                                    <h6 class="text-muted">Available Rooms</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted">
                                        <i class="fas fa-door-open fa-2x text-info"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card board1 fill">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <div>
                                    <h3 class="card_widget_header">${{ number_format($totalCollections, 2) }}</h3>
                                    <h6 class="text-muted">Daily Revenue</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted">
                                        <i class="fas fa-dollar-sign fa-2x text-warning"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 d-flex">
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h4 class="card-title float-left mt-2">Recent Bookings</h4>
                            <a href="{{ route('form/allbooking') }}" class="btn btn-primary float-right veiwbutton">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center">
                                    <thead>
                                        <tr>
                                            <th>Booking ID</th>
                                            <th>Customer Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th class="text-center">Room Type</th>
                                            <th class="text-right">Room Number</th>
                                            <th class="text-center">Dates (In -> Out)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($allBookings as $booking)
                                            <tr>
                                                <td class="text-nowrap">
                                                    <div>BKG-{{ $booking->id }}</div>
                                                </td>
                                                <td class="text-nowrap">{{ $booking->customer->name ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="mailto:{{ $booking->customer->email ?? '' }}">{{ $booking->customer->email ?? 'N/A' }}</a>
                                                </td>
                                                <td>{{ $booking->customer->phone ?? 'N/A' }}</td>
                                                <td class="text-center">{{ $booking->room->type ?? 'N/A' }}</td>
                                                <td class="text-right"><strong>{{ $booking->room->room_number ?? 'N/A' }}</strong></td>
                                                <td class="text-center">
                                                    <span class="badge badge-pill bg-success text-white">
                                                        {{ \Carbon\Carbon::parse($booking->check_in)->format('d/m/Y') }} to {{ \Carbon\Carbon::parse($booking->check_out)->format('d/m/Y') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">No bookings found in the database.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection