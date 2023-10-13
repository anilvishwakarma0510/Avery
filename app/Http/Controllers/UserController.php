<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CountryModel;
use App\Models\User as UserModel;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function editProfile(){
        $countries = CountryModel::orderBy('name')->get();
        $user = UserModel::find(auth()?->user()?->id);

        //dd($user?->UserCountry?->id);
        return view('front.edit-profile',[
            'countries'=>$countries,
            'user'=>$user,
        ]);
    }
    public function changePassword(){
        return view('front.change-password');
    }
    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required'
        ]);

        if ($validator->fails()) {
            //return $this->sendError('Validation Error.', $validator->errors()->all());

            $errors = $validator->errors()->all();
            $message = '';
            foreach ($errors as $error) {
                $message .=  $error . '</br>';
            }
            return response()->json([
                'status' => 0,
                'message' => $message
            ], 200);
        } else {

            $input = $request->all();

            $user = auth()->user();

            if (!Hash::check($input['old_password'], $user->password)) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Old password not matched.'
                ], 200);
            }

            $password = Hash::make($input['password']);
            $user = UserModel::where('id', $user->id)->update(['password' => $password]);
            Session::flash('success','Your password has been changed successfully.');
            return response()->json([
                'status' => 1
            ], 200);
        }
    }
    public function updateProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'age' => 'required|gte:16|numeric|integer',
            'image' => [
                'mimes:jpeg,gif,png,jpg'
            ],
            'gender' => [
                'required',
                Rule::in(['Male','Female','Other'])
            ],
            'country'=>[
                'required',
                'exists:country,id'
            ]
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $message = '';
            foreach ($errors as $error) {
                $message .= $error.'<br>';
            }

            return response()->json([
                'status' => 0,
                'message' => $message
            ], 200);
        }


        $newUser = UserModel::where('id',auth()?->user()?->id)->first();
        $newUser->name = $request->name;
        $newUser->age = $request->age;
        $newUser->gender = $request->gender;
        $newUser->country = $request->country;

        if ($request->file('image')) {
            $fileName = time() . '.' . $request->file('image')->extension();
            $path = 'uploads/users/';
            $uploadedFile = $request->file('image')->move(public_path($path), $fileName);
            $newUser->image = $path . $fileName;
        }

        $newUser->save();

        Session::flash('success','Your pofile has been updated successfully.');

        return response()->json([
            'status' => 1,
        ], 200);
    }
        
}
