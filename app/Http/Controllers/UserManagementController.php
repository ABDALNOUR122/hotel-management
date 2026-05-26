<?php

namespace App\Http\Controllers;

use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    /** user list */
    public function userList()
    {
        return view('usermanagement.listuser');
    }

    /** add new users */
    public function userAddNew()
    {
        return view('usermanagement.useraddnew');
    }

    /** edit record */
    public function userView($user_id)
    {
        $userData = User::where('user_id', $user_id)->first();
        return view('usermanagement.useredit', compact('userData'));
    }

    /** update record */
    public function userUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $updateRecord = [
                'name'         => $request->name,
                'email'        => $request->email,
                'phone_number' => $request->phone_number,
                'role_name'    => $request->role_name,
                'position'     => $request->position,
                'department'   => $request->department, 
            ];

            User::where('user_id', $request->user_id)->update($updateRecord);
        
            DB::commit();
            Toastr::success('Updated record successfully :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Update record fail :)', 'Error');
            return redirect()->back();
        }
    }

    /** delete record */
    public function userDelete($id)
    {
        try {
            $deleteRecord = User::find($id);
            $deleteRecord->delete();
            Toastr::success('User deleted successfully :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('User delete fail :)', 'Error');
            return redirect()->back();
        }
    }

    /** get users data for DataTables */
    public function getUsersData(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length"); 
        $columnIndex_arr = $request->get('order');
        $columnName_arr  = $request->get('columns');
        $order_arr       = $request->get('order');
        $search_arr      = $request->get('search');

        $columnIndex     = $columnIndex_arr[0]['column']; 
        $columnName      = $columnName_arr[$columnIndex]['data']; 
        $columnSortOrder = $order_arr[0]['dir']; 
        $searchValue     = $search_arr['value']; 

        $users = DB::table('users');
        $totalRecords = $users->count();

        $totalRecordsWithFilter = $users->where(function ($query) use ($searchValue) {
            $query->where('name', 'like', '%' . $searchValue . '%')
                  ->orWhere('email', 'like', '%' . $searchValue . '%')
                  ->orWhere('role_name', 'like', '%' . $searchValue . '%')
                  ->orWhere('position', 'like', '%' . $searchValue . '%')
                  ->orWhere('department', 'like', '%' . $searchValue . '%')
                  ->orWhere('phone_number', 'like', '%' . $searchValue . '%');
        })->count();

        if ($columnName == 'name') {
            $columnName = 'name';
        }

        $records = $users->orderBy($columnName, $columnSortOrder)
            ->where(function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                      ->orWhere('email', 'like', '%' . $searchValue . '%')
                      ->orWhere('role_name', 'like', '%' . $searchValue . '%')
                      ->orWhere('position', 'like', '%' . $searchValue . '%')
                      ->orWhere('department', 'like', '%' . $searchValue . '%')
                      ->orWhere('phone_number', 'like', '%' . $searchValue . '%');
            })
            ->skip($start)
            ->take($rowPerPage)
            ->get();

        $data_arr = [];
        
        foreach ($records as $key => $record) {
            $modify = '
                <td class="text-right">
                    <div class="dropdown dropdown-action">
                        <a href="" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v ellipse_color"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="'.url('users/add/edit/'.$record->user_id).'">
                                <i class="fas fa-pencil-alt m-r-5"></i> Edit
                            </a>
                            <a class="dropdown-item" href="'.url('users/delete/'.$record->id).'">
                                <i class="fas fa-trash-alt m-r-5"></i> Delete
                            </a>
                        </div>
                    </div>
                </td>
            ';

            $data_arr[] = [
                "user_id"      => $record->user_id,
                "name"         => $record->name,
                "email"        => $record->email,
                "role_name"    => $record->role_name,
                "position"     => $record->position,
                "department"   => $record->department,
                "phone_number" => $record->phone_number,
                "modify"       => $modify, 
            ];
        }

        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData"               => $data_arr
        ];

        return response()->json($response);
    }
}