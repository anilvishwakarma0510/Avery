<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeBannerModel;
use App\Models\SocialLinkModel;
use App\Models\NewsletterModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class GeneralController extends Controller
{
    public function home_page_banner(){
        $data = HomeBannerModel::orderBy('id','desc')->where('id',1)->first();
        return view('admin.home-page-banner',compact("data"));
    }

    public function home_extra_work_banner(){
        $data = HomeBannerModel::orderBy('id','desc')->where('id',2)->first();
        return view('admin.home-extra-work-banner',compact("data"));
    }

    public function social_link(){
        $data = SocialLinkModel::orderBy('id','desc')->first();
        return view('admin.social-link',compact("data"));
    }
    public function news_letter(){
        $lists = NewsletterModel::orderBy('id','desc')->get();
        return view('admin.newsletter',compact("lists"));
    }

    public function home_page_banner_update(Request $request){
        $validator = Validator::make($request->all(),[
            
            'link'=>[
                'required'
            ],
            'image' => [
                'mimes:jpeg,gif,png,jpg'
            ],
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

        $update = HomeBannerModel::where('id',1)->first();

        $update->link = $request->link;

        if ($request->file('image')) {
            $fileName = time() . '.' . $request->file('image')->extension();
            $path = 'uploads/home_banner/';
            $uploadedFile = $request->file('image')->move(public_path($path), $fileName);
            $update->image = $path . $fileName;
        }

        $update->save();

        Session::flash('success',"Banner has been updated successfully.");

        return response()->json([
            'status'=>1
        ]);
    }
    public function editor_media(Request $request){
        $validator = Validator::make($request->all(),[
            'file' => [
                'required',
                'mimes:jpeg,gif,png,jpg'
            ],
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

        $fileName = time() . '.' . $request->file('file')->extension();
        $path = 'uploads/editor_media/';
        $uploadedFile = $request->file('file')->move(public_path($path), $fileName);
        $imagePath = ($path . $fileName);

            

        return response()->json([
            'status'=>1,
            'message'=>'File has been upploaded successfully.',
            'file_path'=>$imagePath,
            
        ]);
    }
    public function home_extra_work_banner_update(Request $request){
        $validator = Validator::make($request->all(),[
            'link'=>[
                'required'
            ],
            'image' => [
                'mimes:jpeg,gif,png,jpg'
            ],
            'title' => [
                'required'
            ],
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

        $update = HomeBannerModel::where('id',2)->first();

        $update->link = $request->link;
        $update->title = $request->title;

        if ($request->file('image')) {
            $fileName = time() . '.' . $request->file('image')->extension();
            $path = 'uploads/home_banner/';
            $uploadedFile = $request->file('image')->move(public_path($path), $fileName);
            $update->image = $path . $fileName;
        }

        $update->save();

        Session::flash('success',"Banner has been updated successfully.");

        return response()->json([
            'status'=>1
        ]);
    }

    public function social_link_update(Request $request){
       
        $update = SocialLinkModel::where('id',1)->first();

        $update->facebook = $request->facebook;
        $update->instagram = $request->instagram;
        $update->twitter = $request->twitter;
        $update->linkedin = $request->linkedin;

        $update->save();

        Session::flash('success',"Social link has been updated successfully.");

        return response()->json([
            'status'=>1
        ]);
    }
}
