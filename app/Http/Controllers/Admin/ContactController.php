<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ContactRequestModel;
use App\Models\ContactAddressModel;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    public function contactRequest(){
        $lists = ContactRequestModel::orderBy('id','desc')->get();
        return view('admin.contact-list',compact("lists"));
    }
    public function contactAddress(){
        $data = ContactAddressModel::orderBy('id','desc')->first();
        return view('admin.contact-address',compact("data"));
    }
    public function updateContactAddress(Request $request){
        $validator = Validator::make($request->all(),[
            'id'=>[
                'required',
                'exists:contact_address,id'
            ],
            'phone'=>[
                'required'
            ],
            'email'=>[
                'required'
            ],
            'address'=>[
                'required'
            ]
            ]);

        if($validator->fails()){
            $errors = $validator->errors()->all();
            foreach($errors as $error){
                return response()->json([
                    'status'=>0,
                    'message'=> $error
                ]);
            }
        }

        $update = ContactAddressModel::where('id',$request->id)->first();

        $update->phone = $request->phone;
        $update->email = $request->email;
        $update->address = $request->address;

        $update->save();

        Session::flash('success',"Address has been updated successfully.");

        return response()->json([
            'status'=>1
        ]);
    }
}
