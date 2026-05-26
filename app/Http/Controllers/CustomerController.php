<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
   public function allCustomers(Request $request)
{
    $search = $request->input('search');

    $query = DB::table('customers');

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', '%' . $search . '%')
              ->orWhere('email', 'LIKE', '%' . $search . '%')
              ->orWhere('phone', 'LIKE', '%' . $search . '%')
              ->orWhere('id', 'LIKE', '%' . $search . '%');
        });
    }

    $allCustomers = $query->orderBy('id', 'desc')->get();

    return view('customers.allcustomers', compact('allCustomers', 'search'));
}

    public function addCustomer()
    {
        return view('customers.addcustomer');
    }

    public function saveCustomer(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email',
        ]);

        DB::beginTransaction();
        try {
            $customer = new Customer;
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->email = $request->email;
            $customer->save();
            
            DB::commit();
            Toastr::success('Create new customer successfully :)', 'Success');
            return redirect()->route('form/allcustomers/page');
            
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Add Customer fail :)', 'Error');
            return redirect()->back();
        }
    }

    public function updateCustomer($id)
    {
        $customerEdit = DB::table('customers')->where('id', $id)->first();
        return view('customers.editcustomer', compact('customerEdit'));
    }

    public function updateRecord(Request $request)
    {
        $request->validate([
            'id'    => 'required|integer|exists:customers,id',
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $request->id,
        ]);

        DB::beginTransaction();
        try {
            $update = [
                'name'  => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
            ];
            
            Customer::where('id', $request->id)->update($update);
        
            DB::commit();
            Toastr::success('Updated customer successfully :)', 'Success');
            return redirect()->route('form/allcustomers/page');
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Update customer fail :)', 'Error');
            return redirect()->back();
        }
    }

    public function deleteRecord(Request $request)
    {
        try {
            Customer::destroy($request->id);
            Toastr::success('Customer deleted successfully :)', 'Success');
            return redirect()->back();
        } catch(\Exception $e) {
            Toastr::error('Customer delete fail :)', 'Error');
            return redirect()->back();
        }
    }
}