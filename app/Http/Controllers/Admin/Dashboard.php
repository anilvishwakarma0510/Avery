<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class Dashboard extends Controller
{
    public function index() {
        return view('admin.dashboard');
    }

    public function Edit_profile(Request $request){

    	return view('admin.edit-profile');
    }
}
