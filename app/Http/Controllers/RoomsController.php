<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomsController extends Controller
{
 public function allrooms(Request $request)
{
    $search = $request->input('search');

    $query = Room::query();

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('room_number', 'LIKE', '%' . $search . '%')
              ->orWhere('type', 'LIKE', '%' . $search . '%')
              ->orWhere('status', 'LIKE', '%' . $search . '%')
              ->orWhere('price', 'LIKE', '%' . $search . '%')
              ->orWhere('id', 'LIKE', '%' . $search . '%');
        });
    }

    $allRooms = $query->orderBy('id', 'desc')->get();

    return view('room.allroom', compact('allRooms', 'search'));
}

    public function addRoom()
    {
        return view('room.addroom');
    }

    
    public function editRoom($id)
    {
        $roomEdit = Room::findOrFail($id);
        return view('room.editroom', compact('roomEdit'));
    }

    public function saveRecordRoom(Request $request)
    {
        $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number',
            'type'        => 'required|in:Single,Double,Suite',
            'price'       => 'required|numeric|min:0',
            'status'      => 'required|in:Available,Booked,Maintenance',
        ]);

        DB::beginTransaction();
        try {
            $room = new Room;
            $room->room_number = $request->room_number;
            $room->type        = $request->type;
            $room->price       = $request->price;
            $room->status      = $request->status;
            $room->save();
            
            DB::commit();
            Toastr::success('Create new room successfully :)', 'Success');
            return redirect()->route('form/allrooms/page');
            
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Add Room fail :)', 'Error');
            return redirect()->back();
        }
    }

    public function updateRecord(Request $request)
    {
        $request->validate([
            'id'          => 'required|exists:rooms,id',
            'room_number' => 'required|string|max:255|unique:rooms,room_number,' . $request->id,
            'type'        => 'required|in:Single,Double,Suite',
            'price'       => 'required|numeric|min:0',
            'status'      => 'required|in:Available,Booked,Maintenance',
        ]);

        DB::beginTransaction();
        try {
            $room = Room::findOrFail($request->id);
            $room->room_number = $request->room_number;
            $room->type        = $request->type;
            $room->price       = $request->price;
            $room->status      = $request->status;
            $room->save();
        
            DB::commit();
            Toastr::success('Updated room successfully :)', 'Success');
            return redirect()->route('form/allrooms/page');
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Update room fail :)', 'Error');
            return redirect()->back();
        }
    }

    public function deleteRecord(Request $request)
    {
        try {
            Room::destroy($request->id);
            
            Toastr::success('Room deleted successfully :)', 'Success');
            return redirect()->back();
        
        } catch(\Exception $e) {
            Toastr::error('Room delete fail :)', 'Error');
            return redirect()->back();
        }
    }
    public function updateStatus(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'status'  => 'required|in:Available,Booked,Maintenance',
        ]);

        try {
            $room = Room::findOrFail($request->room_id);
            $room->status = $request->status;
            $room->save();

            Toastr::success('Room status updated successfully :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Failed to update room status', 'Error');
            return redirect()->back();
        }
    }
}