@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="mt-5">
                            <h4 class="card-title float-left mt-2">Bookings List</h4>
                            <a href="{{ route('form/booking/add') }}" class="btn btn-primary float-right veiwbutton ">Add
                                Booking</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-5">
                    <form action="{{ route('form/allbooking') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by name, email, room..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('form/allbooking') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Clear
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body booking_card">
                            <div class="table-responsive">
                                <table class="datatable table table-stripped table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Booking ID</th>
                                            <th>Customer Name</th>
                                            <th>Room Number</th>
                                            <th>Room Type</th>
                                            <th>Check In Date</th>
                                            <th>Check Out Date</th>
                                            <th>Total Days</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allBookings as $bookings)
                                            <tr>
                                                <td>BKG-{{ $bookings->id }}</td>
                                                <td>
                                                    {{ $bookings->customer->name ?? 'N/A' }}
                                                </td>
                                                <td>
                                                    <span class="badge badge-pill bg-info-light">Room
                                                        {{ $bookings->room->room_number ?? 'N/A' }}</span>
                                                </td>
                                                <td>{{ $bookings->room->type ?? 'N/A' }}</td>
                                                <td>{{ $bookings->check_in }}</td>
                                                <td>{{ $bookings->check_out }}</td>
                                                <td>{{ $bookings->total_days }} Days</td>
                                                <td class="text-right">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v ellipse_color"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item"
                                                                href="{{ url('form/booking/edit/' . $bookings->id) }}">
                                                                <i class="fas fa-pencil-alt m-r-5"></i> Edit
                                                            </a>
                                                            <a class="dropdown-item bookingDelete" data-toggle="modal"
                                                                data-target="#delete_asset" data-id="{{ $bookings->id }}">
                                                                <i class="fas fa-trash-alt m-r-5"></i> Delete
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Model delete --}}
        <div id="delete_asset" class="modal fade delete-modal" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('form/booking/delete') }}" method="POST">
                        @csrf
                        <div class="modal-body text-center">
                            <img src="{{ URL::to('assets/img/sent.png') }}" alt="" width="50" height="46">
                            <h3 class="delete_class">Are you sure want to delete this Booking?</h3>
                            <div class="m-t-20">
                                <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                <input class="form-control" type="hidden" id="e_id" name="id" value="">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End Model delete --}}

    </div>
    @section('script')
        {{-- delete model --}}
        <script>
            $(document).on('click', '.bookingDelete', function () {
                $('#e_id').val($(this).data('id'));
            });
        </script>
    @endsection
@endsection