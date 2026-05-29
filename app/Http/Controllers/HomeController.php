<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Room; 
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $allBookings = Booking::with(['customer', 'room'])->latest()->take(5)->get();
        
        $totalBookings = Booking::count();
        
        $totalCustomers = Customer::distinct('email')->count('email');
        
        $totalAvailableRooms = Room::where('status', 'Available')->count();

        $today = Carbon::today()->format('Y-m-d');
        $todayBookings = Booking::with('room')->where('check_in', $today)->get();
        
        $totalCollections = 0;
        foreach($todayBookings as $bkg) {
            if($bkg->room) {
                $totalCollections += ($bkg->total_days * $bkg->room->price);
            }
        }

        return view('dashboard.home', compact(
            'allBookings', 
            'totalBookings', 
            'totalCustomers',
            'totalAvailableRooms',
            'totalCollections'
        ));
    }

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

public function getDailyPerformanceReport()
{
    $today = Carbon::today()->format('Y-m-d');

    // 1. إجمالي الغرف المتاحة في الفندق (التي ليست تحت الصيانة)
    $totalAvailableRooms = Room::where('status', '!=', 'Maintenance')->count();

    // 2. إجمالي عدد الغرف المباعة (المشغولة فعلياً اليوم)
    $totalSoldRooms = Booking::where('check_in', '<=', $today)
                             ->where('check_out', '>', $today)
                             ->count();

    // 3. إيرادات الغرف الفعلية لليوم (من جدول الإيرادات المخصص للغرف)
    $roomRevenue = DB::table('hotel_revenues')
                     ->where('revenue_date', $today)
                     ->where('service_type', 'Room')
                     ->sum('amount');

    // 4. إيرادات الخدمات الأخرى (مطعم، منتجع، إلخ) لليوم
    $otherServicesRevenue = DB::table('hotel_revenues')
                             ->where('revenue_date', $today)
                             ->whereIn('service_type', ['Restaurant', 'Spa', 'Laundry'])
                             ->sum('amount');

    // --- حساب المؤشرات الفندقية الرئيسية (KPIs) ---

    // أ. متوسط سعر الغرفة اليومي (ADR) = إيرادات الغرف ÷ عدد الغرف المباعة
    $adr = $totalSoldRooms > 0 ? ($roomRevenue / $totalSoldRooms) : 0;

    // ب. معدل الإشغال (Occupancy Rate) = (الغرف المباعة ÷ الغرف المتاحة) × 100
    $occupancyRate = $totalAvailableRooms > 0 ? (($totalSoldRooms / $totalAvailableRooms) * 100) : 0;

    // ج. إيراد الغرفة المتاحة (RevPAR) = إيرادات الغرف ÷ إجمالي الغرف المتاحة
    $revPAR = $totalAvailableRooms > 0 ? ($roomRevenue / $totalAvailableRooms) : 0;

    // د. إجمالي الإيرادات اليومية الكلية = إيرادات الغرف + الخدمات الأخرى
    $totalDailyRevenue = $roomRevenue + $otherServicesRevenue;
return view('reports.daily_performance', compact(
    'today', 'totalSoldRooms', 'roomRevenue', 'otherServicesRevenue', 
    'adr', 'occupancyRate', 'revPAR', 'totalDailyRevenue'
));
}
}