<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Mail\CustomMail;
use App\Models\CountryModel;
use App\Models\User as UserModel;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function login(){
        return view('front.login');
    }

    public function registration(){
        $countries = CountryModel::orderBy('name')->get();
        return view('front.registration',[
            'countries'=>$countries
        ]);
    }

    public function forgot_password()
    {
        return view('front.forgot_password');
    }

    public function ResetPassword(Request $request)
    {

        if (session()->has('message') && session()->has('hide_form')) {
            return view('front.reset-password', ['request' => $request, 'hide_form' => session()->get('hide_form')]);
        }

        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                'token' => $request->token
            ])->first();



        if (!$updatePassword) {
            $hide_form = true;
            session()->flash('message', '<div class="alert alert-danger">Link has been expired.</div>');
            return view('front.reset-password', ['request' => $request, 'hide_form' => $hide_form]);
        }
        return view('front.reset-password', ['request' => $request]);
    }
    public function UpdatePassword(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            //return $this->sendError('Validation Error.', $validator->errors()->all());

            $errors = $validator->errors()->all();
            $message = '';
            foreach ($errors as $error) {
                $message .= $error . '</br>';
            }
            $message .= '</div>';
            return back()->withInput()->with('error', $message);
        } else {


            $updatePassword = DB::table('password_reset_tokens')
                ->where([
                    'email' => $request->email,
                    'token' => $request->token
                ])->first();

            if (!$updatePassword) {
                return back()->withInput()->with('message', '<div class="alert alert-danger">Invalid token!</div>');
            }


            $user = UserModel::where('email', $request->email)
                ->update(['password' => Hash::make($request->password)]);

            DB::table('password_reset_tokens')
                ->where(['email' => $request->email])->delete();

            return back()->with(['message' => '<div class="alert alert-success">Your password has been changed!</div>', 'hide_form' => true]);
        }
    }

    public function SendResetPasswordLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users'
        ], [
            'email.exists' => 'This email is not register with us'
        ]);

        if ($validator->fails()) {
            //return $this->sendError('Validation Error.', $validator->errors()->all());

            $errors = $validator->errors()->all();

            foreach ($errors as $error) {

                return response()->json([
                    'status' => 0,
                    'message' => $error
                ], 200);
            }
        } else {

            DB::table('password_reset_tokens')
                ->where(['email' => $request->email])->delete();

            $user = UserModel::where('email', $request->email)->first();

            $token = md5(rand());;

            DB::table('password_reset_tokens')
                ->insert([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => date('Y-m-d H:i:s')
                ]);


            $verificationUrl = URL::to('/') . '/reset-password/' . $token;
            $data['email'] = $user->email;
            $data['subject'] = 'Forgot password';
            $data['data'] = '<p>Hello ' . $user->first_name . ', </p><p>We\'ve received a password reset request for your account (' . $user->email . ').</p>';
            $data['data'] .= '<p>If you initiated this request, please click the link below to reset your password.</p>';
            $data['data'] .= '<p><a href="' . $verificationUrl . '" target="_blank" style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #902F7E; text-decoration: none;  text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #902f7e; display: inline-block;">Reset Password</a></p>';
            try {
                Mail::to($data['email'])->send(new CustomMail($data));
            } catch (\Exception $e) {
                // Get error here
                //dd($e->getMessage());
                //return $this->sendError('Something went wrong, try again later.', ['Something went wrong try again later.']);

                return response()->json([
                    'status' => 0,
                    'message' => 'Something went wrong, try again later.'
                ], 200);
            }

            return response()->json([
                'status' => 1,
                'message' => 'We have e-mailed your password reset link!'
            ], 200);
        }
    }

    
    

    public function loginSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email'
            ],
            'password' => 'required',
        ]);

        

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            foreach ($errors as $error) {

                return redirect()->route('login')
                    ->withInput($request->only('email', 'remember'))
                    ->with('error',$error);
            }
        }

        $credentials = $request->only('email', 'password');

        $remember = $request->remember;

        if (Auth::attempt($credentials, $remember)) {
            //return redirect()->intended('/dashboard');
            return redirect()->route('chat-room')->with('success','You are Logged in successfully.');
        }

        return redirect()->route('login')
            ->withInput($request->only('email', 'remember'))
            ->with('error','These credentials do not match our records');
    }

    public function logout(Request $request){

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

   
    public function signupSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'age' => "required|gte:16|integer",
            'password' => "required|min:8",
            'confirm_password' => "required|min:8|required_with:password|same:password",
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
            foreach ($errors as $error) {
                return response()->json([
                    'status' => 0,
                    'message' => $error
                ], 200);
            }
        }


        $newUser = new UserModel;
        $newUser->name = $request->name;
        $newUser->gender = $request->gender;
        $newUser->country = $request->country;
        $newUser->age = $request->age;
        $newUser->email = $request->email;
        $newUser->password = $request->password;

        $newUser->save();

        if ($newUser->id) {

            Auth::loginUsingId($newUser->id);

            /*$verificationUrl = URL::to('/') . '/verify/' . $newUser->id . '/' . $token;
            $EmailData['email'] = $newUser->email;
            $EmailData['subject'] = 'Registration successful';
            $EmailData['data'] = '<p>Hello ' . $newUser->first_name . ', </p><p>Thank you for registering with us.</p><p>To verify your account click the below link. </p><p><a href="' . $verificationUrl . '">Verify Now</a></p><p>If the above link doesn\'t work. Copy and paste the below link to your browser.</p><p>' . $verificationUrl . '</p>';

            try {
                Mail::to($EmailData['email'])->send(new CustomMail($EmailData));
            } catch (\Exception $e) {
                // Get error here
            }*/


            Session::flash('success','Congratulation your account has been created successfully');

            return response()->json([
                'status' => 1,
                //'message' => 'Registration completed successfully, please verify your email.'
            ], 200);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong, try again later.'
            ], 200);
        }
    }

     /*
    public function emailVerify()
    { 
        $is_verified = false;
        if (auth()->user()->email_verified_at) {
            return redirect()->route('customer.dashboard');
        }
        return view('home.email-verify', compact("is_verified"));
    }

    public function verifyEmail($id = null, $token = null)
    {

        //$user = User::where('id',$id)->where('token',$token)->first();
        $user = UserModel::where('id', $id)->first();
        $message = '<h6 style="color:red">Verification link has been expired.</h6>';
        $status = 0;
        if (!blank($user)) {
            if ($user->email_verified_at && !empty($user->email_verified_at)) {
                $message = '<h6 style="color:green">Your email address already verified.</h6>';
                $status = 1;
            } else if ($token == $user->remember_token) {
                $user->remember_token = '';
                $user->email_verified_at = date('Y-m-d H:i:s');
                $user->save();
                $message = '<h6 style="color:green">Your email address has been verified successfully.</h6>';
                $status = 1;
            }
        }
        $is_verified = true;
        return view('home.email-verify', compact('user', 'message', 'status', "is_verified"));
    }
    public function ResendEmailVerificationLink()
    {
        // echo auth()->user()->id; die();
        if (auth()->user()->email_verified_at) {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong'
            ], 200);
        }

        $user = UserModel::where('id', auth()->user()->id)->first();

        if ($user->remember_token && !empty($user->remember_token)) {
            $token = $user->remember_token;
        } else {
            $token = md5(rand());
        }

        $verificationUrl = URL::to('/') . '/verify/' . $user->id . '/' . $token;
        $EmailData['email'] = $user->email;
        $EmailData['subject'] = 'Registration successful';
        $EmailData['data'] = '<p>Hello ' . $user->first_name . ', </p><p>Thank you for registering with us.</p><p>To verify your account click the below link. </p><p><a href="' . $verificationUrl . '">Verify Now</a></p><p>If the above link doesn\'t work. Copy and paste the below link to your browser.</p><p>' . $verificationUrl . '</p>';

        Mail::to($EmailData['email'])->send(new CustomMail($EmailData));

        return response()->json([
            'status' => 1,
            'message' => 'Sent'
        ], 200);
    }
    */

}
