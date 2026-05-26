<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /** show register page */
    public function register()
    {
        return view('auth.register');
    }

    /** store new user */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users',
            'role_name'             => 'required|string|max:255',
            'phone_number'          => 'required|string|max:255',
            'position'              => 'required|string|max:255',
            'department'            => 'required|string|max:255',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);
        
        $dt        = Carbon::now();
        $join_date = Carbon::now()->toDateTimeString();   

        $user = new User();
        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->phone_number = $request->phone_number;
        $user->join_date    = $join_date;
        $user->role_name    = $request->role_name;
        $user->position     = $request->position;
        $user->department   = $request->department;
        
        
        $user->password     = Hash::make($request->password);
        $user->save();
       
        Toastr::success('Create new account successfully', 'Success');
        return redirect('login');
    }
}