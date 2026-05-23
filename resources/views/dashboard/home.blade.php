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
                {{-- بطاقة عدد الحجوزات --}}
                <div class="col-xl-4 col-sm-6 col-12">
                    <div class="card board1 fill">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <div>
                                    <h3 class="card_widget_header">{{ $totalBookings }}</h3>
                                    <h6 class="text-muted">Total Booking</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24"
                                            fill="none" stroke="#009688" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-user-plus">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="8.5" cy="7" r="4"></circle>
                                            <line x1="20" y1="8" x2="20" y2="14"></line>
                                            <line x1="23" y1="11" x2="17" y2="11"></line>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- بطاقة عدد العملاء --}}
                <div class="col-xl-4 col-sm-6 col-12">
                    <div class="card board1 fill">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <div>
                                    <h3 class="card_widget_header">{{ $totalCustomers }}</h3>
                                    <h6 class="text-muted">Total Customers</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24"
                                            fill="none" stroke="#009688" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-users">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- بطاقة الإيرادات اليومية --}}
                <div class="col-xl-4 col-sm-6 col-12">
                    <div class="card board1 fill">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <div>
                                    <h3 class="card_widget_header">${{ number_format($totalCollections, 2) }}</h3>
                                    <h6 class="text-muted">Daily Revenue</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24"
                                            fill="none" stroke="#009688" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-dollar-sign">
                                            <line x1="12" y1="1" x2="12" y2="23"></line>
                                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- جدول الحجوزات الحديثة (تم الإبقاء عليه لكونه جزءاً أساسياً من البيانات) --}}
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
                                                    <div>{{ $booking->bkg_id ?? 'BKG-'.$booking->id }}</div>
                                                </td>
                                                <td class="text-nowrap">{{ $booking->name }}</td>
                                                <td>
                                                    <a href="mailto:{{ $booking->email }}">{{ $booking->email }}</a>
                                                </td>
                                                <td>{{ $booking->ph_number }}</td>
                                                <td class="text-center">{{ $booking->room_type }}</td>
                                                <td class="text-right">{{ $booking->total_numbers }}</td>
                                                <td class="text-center">
                                                    <span class="badge badge-pill bg-success text-white">
                                                        {{ $booking->date }} to {{ $booking->depature_date }}
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