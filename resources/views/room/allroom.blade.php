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
                            <h4 class="card-title float-left mt-2">All Rooms</h4>
                            <a href="{{ route('form/addroom/page') }}" class="btn btn-primary float-right veiwbutton">Add Room</a> 
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-5">
                    <form action="{{ route('form/allrooms/page') }}" method="GET"> {{-- تأكد من اسم الـ Route الفعلي لصفحة الغرف في الـ web.php --}}
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search by room number, type, status..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('form/allrooms/page') }}" class="btn btn-secondary">
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
                                            <th>Room ID</th>
                                            <th>Room Number</th>
                                            <th>Room Type</th>
                                            <th>Price (Per Night)</th>
                                            <th>Status</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allRooms as $rooms)
                                        <tr>
                                            <td hidden class="id">{{ $rooms->id }}</td>
                                            
                                            <td>{{ $rooms->id }}</td>
                                            <td><strong>{{ $rooms->room_number }}</strong></td>
                                            <td>{{ $rooms->type }}</td>
                                            <td>{{ $rooms->price }} USD</td>
                                            <td>
                                                <div class="actions">
                                                    @if($rooms->status == 'Available')
                                                        <span class="badge bg-success-light">Available</span>
                                                    @elseif($rooms->status == 'Booked')
                                                        <span class="badge bg-danger-light">Booked</span>
                                                    @else
                                                        <span class="badge bg-warning-light">Maintenance</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v ellipse_color"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item change_status" href="#" data-toggle="modal" data-target="#status_asset" data-id="{{ $rooms->id }}" data-status="{{ $rooms->status }}">
                                                            <i class="fas fa-sync-alt m-r-5"></i> Change Status
                                                        </a>
                                                        <a class="dropdown-item" href="{{ url('form/room/edit/'.$rooms->id) }}">
                                                            <i class="fas fa-pencil-alt m-r-5"></i> Edit Room
                                                        </a>
                                                        <a class="dropdown-item delete_asset" href="#" data-toggle="modal" data-target="#delete_asset">
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
        
        <div id="status_asset" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Room Status</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{ route('room/updateStatus') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" id="status_room_id" name="room_id" value="">
                            <div class="form-group">
                                <label>Select Status</label>
                                <select class="form-control" name="status" id="status_select">
                                    <option value="Available">Available</option>
                                    <option value="Booked">Booked</option>
                                    <option value="Maintenance">Maintenance (Under Repair)</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- delete modal --}}
        <div id="delete_asset" class="modal fade delete-modal" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <form action="{{ route('form/room/delete') }}" method="POST">
                            @csrf
                            <img src="{{ URL::to('assets/img/sent.png') }}" alt="" width="50" height="46">
                            <h3 class="delete_class">Are you sure want to delete this Room?</h3>
                            <div class="m-t-20">
                                <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                <input type="hidden" id="e_id" name="id" value="">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- end delete modal --}}
    </div>

    @section('script')
        <script>
            $(document).on('click', '.delete_asset', function() {
                var _this = $(this).parents('tr');
                $('#e_id').val(_this.find('.id').text().trim());
            });

            $(document).on('click', '.change_status', function() {
                var roomId = $(this).data('id');
                var currentStatus = $(this).data('status');
                
                $('#status_room_id').val(roomId);
                $('#status_select').val(currentStatus);
            });
        </script>
    @endsection
@endsection