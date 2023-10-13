<?php

namespace App\Http\Controllers;

use App\Models\ContactRequestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\ContactAddressModel;
use App\Models\BlogModel;
use App\Models\CategoryModel;
use App\Models\HomeBannerModel;
use App\Models\NewsletterModel;
use Carbon\Carbon;

class HomeController extends Controller
{
    //
    public function home()
    {
        $weekPlaylist = BlogModel::
            //where('blogs.category',3)
            //join('category','category.id','blogs.category')
            whereDate('blogs.created_at', '>=', Carbon::now()->startOfWeek())
            ->whereDate('blogs.created_at', '<=', Carbon::now()->endOfWeek())
            ->where('blogs.status',1)
            ->orderBy('blogs.id','desc')
            //->select('blogs.id','blogs.slug','blogs.title','blogs.thumbnail','category.title as cat_title','category.color as cat_color')
            ->take(10)
            ->get();

        $category = CategoryModel::
            get();
        //dd($weekPlaylist);


        $latest = BlogModel::
            //join('category','category.id','blogs.category')
            where('blogs.status',1)
            ->where('blogs.is_latest',1)
            ->orderBy('blogs.listing_order','asc')
            //->select('blogs.id','blogs.slug','blogs.title','blogs.thumbnail','category.title as cat_title','category.color as cat_color')
            //->take(5)
            ->get();
        //dd($latest);

        $extra = BlogModel::where('blogs.category',6)
            //->join('category','category.id','blogs.category')
            //->whereDate('blogs.created_at', '>', Carbon::now()->startOfWeek())
            //->whereDate('blogs.created_at', '<', Carbon::now()->endOfWeek())
            ->where('blogs.status',1)
            ->orderBy('blogs.id','desc')
            //->select('blogs.id','blogs.slug','blogs.title','blogs.thumbnail','category.title as cat_title','category.color as cat_color')
            ->take(4)
            ->get();

        $extra_banner = HomeBannerModel::where('id',2)
            ->first();
        $home_banner = HomeBannerModel::where('id',1)
            ->first();

        $previous = BlogModel::
            //join('category','category.id','blogs.category')
            where('blogs.status',1)
            ->whereDate('blogs.created_at', '<', Carbon::now()->startOfWeek())
            ->orderBy('blogs.listing_order','asc')
            //->select('blogs.id','blogs.slug','blogs.title','blogs.thumbnail','category.title as cat_title','category.color as cat_color')
            ->take(12)
            ->get();

        
        //dd($extra);

        return view('front.home',[
            "weekPlaylist"=>$weekPlaylist,
            "category"=>$category,
            "latest"=>$latest,
            "extra"=>$extra,
            "extra_banner"=>$extra_banner,
            "home_banner"=>$home_banner,
            "previous"=>$previous,
        ]);
    }

    public function terms()
    {
        return view('front.terms');
    }
    public function privacyPolicy()
    {
        return view('front.privacy-policy');
    }
    public function contact_us()
    {
        $address = ContactAddressModel::orderBy('id','desc')->first();
        return view('front.contact-us',compact("address"));
    }
    public function about_me()
    {
        return view('front.about-me');
    }
    public function contact_us_post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required'
            ],
            'email' => [
                'required',
                'email'
            ],
            'message'=>[
                'required'
            ]
        ]);

        if($validator->fails()){
            $errors = $validator->errors()->all();
            foreach($errors as $key => $error){
                return response()->json([
                    'status'=>0,
                    'message'=>$error
                ]);
            }
        }

        $insert = new ContactRequestModel;
        $insert->name = $request->name;
        $insert->email = $request->email;
        $insert->message = $request->message;
        $insert->save();

        Session::flash('success','Thanks for contact us. Your request has been submitted successfully, We will contact you as soon as possible.');

        return response()->json([
            'status'=>1,
            'message'=>'Your request has been submitted successfully.'
        ]);

    }
    public function subscribe_newsletter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email'
            ]
        ]);

        if($validator->fails()){
            $errors = $validator->errors()->all();
            foreach($errors as $key => $error){
                return response()->json([
                    'status'=>0,
                    'message'=>$error
                ]);
            }
        }

        
        $insert = NewsletterModel::firstOrNew(array('email' => $request->email));
        $insert->status = 1;
        $insert->save();

        

        return response()->json([
            'status'=>1,
            'message'=>'Your request has been submitted successfully.'
        ]);

    }
}
