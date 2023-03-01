<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function register(){
        return view('feature-room.auth.register');
    }

    public function storeRegister(Request $request){
        $request->validate([
            'name'=>['required'],
            'email'=>['required','email',Rule::unique('customers','email')],
            'phone'=>['required','min:9','max:11',Rule::unique('customers','phone')],
            'password'=>['required','min:8','max:20']
        ]);

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->gender = $request->gender;
        $customer->password = Hash::make($request->password);
        $customer->save();
        Auth::guard('customer')->login($customer);
        return redirect()->route('feature.room');
    }

    public function login(){
        return view('feature-room.auth.login');
    }

    public function store(Request $request){
        $formData = $request->validate([
            'email'=>['required','email',Rule::exists('customers','email')],
            'password'=>['required']
        ]);
        // dd($formData);
        if(auth()->guard('customer')->attempt($formData)){
            return redirect()->route('feature.room');
        }else{
            return back()->withErrors(['email'=>'These credentials do not match our record.']);
        }
    }

    public function logout(){
        auth()->guard('customer')->logout();
        return redirect()->route('customerLogin');
    }
}
