<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminModel;
use Session;
use Hash;
use Validator;
use Mail;

class AuthController extends Controller
{
   
	public function login(){
     	if(!Auth::guard('admin')->check()){

            return view('admin.login');
        }else{
        	//dd('hello');
            return redirect()->route('admin.dashboard');
		}
	}

	public function do_login(Request $request)
    {
    	//dd($request);
    	
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
       
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){
        	
           return redirect()->route('admin.dashboard')->with('success','You are Logged in successfully.');
        }else {
            return back()->with('error','Invalid login details');
        }
    }

   public function logout(Request $request){
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin');
    }

}
