<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $allBookings = Booking::all();
        $totalBookings = Booking::count();
        $totalCustomers = Customer::distinct('email')->count('email');
        $totalCollections = 0; 

        return view('dashboard.home', compact(
            'allBookings', 
            'totalBookings', 
            'totalCustomers',
            'totalCollections'
        ));
    }

    /**
     * Profile page
     */
    public function profile()
    {
        return view('profile');
    }
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password'     => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'The current password field is required.',
            'new_password.required'     => 'The new password field is required.',
            'new_password.min'          => 'The new password must be at least 8 characters.',
            'new_password.confirmed'    => 'The new password confirmation does not match.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput()
                             ->with('active_tab', 'security');
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                             ->withErrors(['current_password' => 'The provided current password does not match our records.'])
                             ->withInput()
                             ->with('active_tab', 'security');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()
                         ->with('success', 'Your password has been changed successfully!')
                         ->with('active_tab', 'security');
    }

}