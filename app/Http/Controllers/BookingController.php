<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Room; 
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{

public function allbooking(Request $request)
{
    $search = $request->input('search');

    $query = Booking::with(['customer', 'room']);

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->whereHas('customer', function ($customerQuery) use ($search) {
                $customerQuery->where('name', 'LIKE', '%' . $search . '%')
                              ->orWhere('email', 'LIKE', '%' . $search . '%');
            })
            ->orWhereHas('room', function ($roomQuery) use ($search) {
                $roomQuery->where('room_number', 'LIKE', '%' . $search . '%');
            })
            ->orWhere('id', 'LIKE', '%' . $search . '%');
        });
    }

    $allBookings = $query->latest()->get();

    return view('booking.allbookings', compact('allBookings', 'search'));
}

   public function bookingAdd()
{
    $rooms = Room::where('status', '!=', 'Maintenance')->get();
    $customers = Customer::all();
    
    return view('booking.addbooking', compact('rooms', 'customers'));
}
    
    public function bookingEdit(int $id)
    {
        $bookingEdit = Booking::findOrFail($id);
        $rooms = Room::all();
        $customers = Customer::all();
        return view('booking.editbooking', compact('bookingEdit', 'rooms', 'customers'));
    }

public function saveRecord(Request $request)
{
    $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'room_id'     => 'required|exists:rooms,id',
        'check_in'    => 'required|date_format:d/m/Y',
        'check_out'   => 'required|date_format:d/m/Y',
        'total_days'  => 'required|integer|min:1',
    ]);

    $check_in_formatted  = Carbon::createFromFormat('d/m/Y', $request->check_in)->format('Y-m-d');
    $check_out_formatted = Carbon::createFromFormat('d/m/Y', $request->check_out)->format('Y-m-d');

    $isRoomBooked = Booking::where('room_id', $request->room_id)
        ->where(function ($query) use ($check_in_formatted, $check_out_formatted) {
            $query->where(function ($q) use ($check_in_formatted, $check_out_formatted) {
                $q->where('check_in', '<=', $check_in_formatted)
                  ->where('check_out', '>', $check_in_formatted);
            })
            ->orWhere(function ($q) use ($check_in_formatted, $check_out_formatted) {
                $q->where('check_in', '<', $check_out_formatted)
                  ->where('check_out', '>=', $check_out_formatted);
            })
            ->orWhere(function ($q) use ($check_in_formatted, $check_out_formatted) {
                $q->where('check_in', '>=', $check_in_formatted)
                  ->where('check_out', '<=', $check_out_formatted);
            });
        })
        ->exists();

    if ($isRoomBooked) {
        Toastr::error('Sorry, this room is already booked during the selected dates.', 'Error');
        return redirect()->back()->withInput();
    }

    DB::beginTransaction();
    try {
        $booking = new Booking;
        $booking->customer_id = $request->customer_id;
        $booking->room_id     = $request->room_id;
        $booking->check_in    = $check_in_formatted;
        $booking->check_out   = $check_out_formatted;
        $booking->total_days  = $request->total_days;
        $booking->save();

        $room = DB::table('rooms')->where('id', $request->room_id)->first();
        $roomPrice = $room ? $room->price : 0;

        $start_date = Carbon::createFromFormat('Y-m-d', $check_in_formatted);
        $end_date   = Carbon::createFromFormat('Y-m-d', $check_out_formatted);

        for ($date = $start_date; $date->lt($end_date); $date->addDay()) {
            DB::table('hotel_revenues')->insert([
                'booking_id'   => $booking->id,
                'service_type' => 'Room',
                'amount'       => $roomPrice,
                'revenue_date' => $date->format('Y-m-d'),
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
        
        DB::commit();
        Toastr::success('Create new booking successfully', 'Success');
        return redirect()->route('form/allbooking');
        
    } catch(\Exception $e) {
        DB::rollback();
        Toastr::error('Add Booking fail', 'Error');
        return redirect()->back();
    }
}

    public function updateRecord(Request $request)
{
    $request->validate([
        'id'          => 'required|exists:bookings,id',
        'customer_id' => 'required|exists:customers,id',
        'room_id'     => 'required|exists:rooms,id',
        'check_in'    => 'required|date_format:d/m/Y',
        'check_out'   => 'required|date_format:d/m/Y',
        'total_days'  => 'required|integer|min:1',
    ]);

    $check_in_formatted  = Carbon::createFromFormat('d/m/Y', $request->check_in)->format('Y-m-d');
    $check_out_formatted = Carbon::createFromFormat('d/m/Y', $request->check_out)->format('Y-m-d');

    $isRoomBooked = Booking::where('room_id', $request->room_id)
        ->where('id', '!=', $request->id)
        ->where(function ($query) use ($check_in_formatted, $check_out_formatted) {
            $query->where(function ($q) use ($check_in_formatted, $check_out_formatted) {
                $q->where('check_in', '<=', $check_in_formatted)
                  ->where('check_out', '>', $check_in_formatted);
            })
            ->orWhere(function ($q) use ($check_in_formatted, $check_out_formatted) {
                $q->where('check_in', '<', $check_out_formatted)
                  ->where('check_out', '>=', $check_out_formatted);
            })
            ->orWhere(function ($q) use ($check_in_formatted, $check_out_formatted) {
                $q->where('check_in', '>=', $check_in_formatted)
                  ->where('check_out', '<=', $check_out_formatted);
            });
        })
        ->exists();

  if ($isRoomBooked) {
    Toastr::error('Sorry, this room is already booked during the selected dates.', 'Error');
    return redirect()->back()->withInput();
}

    DB::beginTransaction();
    try {
        $booking = Booking::findOrFail($request->id);
        $booking->customer_id = $request->customer_id;
        $booking->room_id     = $request->room_id;
        $booking->check_in    = $check_in_formatted;
        $booking->check_out   = $check_out_formatted;
        $booking->total_days  = $request->total_days;
        $booking->save();
    
        DB::commit();
        Toastr::success('Updated booking successfully', 'Success');
        return redirect()->route('form/allbooking');
    } catch(\Exception $e) {
        DB::rollback();
        Toastr::error('Update booking fail', 'Error');
        return redirect()->back();
    }
}

    public function deleteRecord(Request $request)
    {
        try {
            $booking = Booking::findOrFail($request->id);
            $booking->delete();
            
            Toastr::success('Booking deleted successfully', 'Success');
            return redirect()->back();
        
        } catch(\Exception $e) {
            Toastr::error('Booking delete fail :)', 'Error');
            return redirect()->back();
        }
    }
}