<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Customer;


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

        // 4. إحصائية: الإيرادات اليومية (تم وضعها 0 مؤقتاً)
        $totalCollections = 0; 

        // إرسال المتغيرات المطلوبة فقط إلى واجهة العرض
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
}