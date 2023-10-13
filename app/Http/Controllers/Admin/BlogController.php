<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogModel;
use App\Models\CategoryModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    public function index(Request $request)
	{

		$data = BlogModel::orderBy('listing_order', 'asc')->orderBy('id','desc')
            ->join('category', 'category.id', '=', 'blogs.category')
            ->select('blogs.*','category.title as category_title')
            ->get();
		return view('admin.blogs', compact('data'));
	}

    public function add(Request $request)
	{

		$category = CategoryModel::orderBy('id', 'asc')
            ->get();
		return view('admin.add-blog', compact('category'));
	}
	public function updateBlogOrder(Request $request){

		$orders = $request->orders;
		if(!blank($orders)){
			foreach($orders as $key => $value){
				BlogModel::where('id',$value['id'])->update(['listing_order'=>$key]);
			}
		}

		return response()->json([
			'status'=>1
		]);

	}
	public function updateBlogLatest(Request $request){

		$validator = Validator::make($request->all(),[
			'id'=>[
				'required',
				'exists:blogs,id'
			],
			'is_latest'=>[
				'required',
				Rule::in([0,1])
			]
		]);

		if($validator->fails()){
			$errors = $validator->errors()->all();
			$message = '';
			foreach($errors as $error){
				$message .= $error.'</br>';
			}
			return response()->json([
				'status'=>0,
				'message'=>$message
			]);
		}

		$is_latest = $request->is_latest;
		$id = $request->id;
		BlogModel::where('id',$id)->update(['is_latest'=>$is_latest]);

		return response()->json([
			'status'=>1
		]);

	}
    public function edit(Request $request)
	{
        $validator = Validator::make($request->all(), [
			'id' => [
                'required',
                'exists:blogs,id'
            ],
		]);
		if ($validator->fails()) {
			$errors = $validator->errors()->all();

			foreach ($errors as $error) {
                Session::flash('error', $error);
				return redirect()->route('admin.blogs');
			}
		}
        $blog = BlogModel::where('id',$request->id)->first();
		$category = CategoryModel::orderBy('id', 'asc')
            ->get();
		return view('admin.edit-blog', compact('category','blog'));
	}

	public function EditBlog(Request $request)
	{

		$validator = Validator::make($request->all(), [
            'id' => [
                'required',
                'exists:blogs,id'
            ],
			'title' => 'required',
			'sort_description' => 'required',
			'description' => 'required',
			'category' => [
                'required',
                'exists:category,id'
            ],
            'media_type' => [
                Rule::in(['audio','video','image',''])
            ],
            'status' => [
                Rule::in([1,0])
            ],
            'media_file' => [
                'nullable',
                'mimes:jpeg,gif,png,bmp,jpg,mp4,mp3'
            ],
            'thumbnail' => [
                'mimes:jpeg,gif,png,jpg'
            ],
		]);
		if ($validator->fails()) {
			$errors = $validator->errors()->all();

			foreach ($errors as $error) {
				return response()->json([
					'status' => 0,
					'message' => $error,
				]);
			}
		}

		$slug = Str::slug($request->title);
		$originalSlug = $slug;
		$i = 1;
		while (BlogModel::where('slug', $slug)->where('id','!=',$request->id)->exists()) {
			$slug = $originalSlug . '-' . $i++;
		}

		$insert = BlogModel::where('id',$request->id)->first();
		$insert->sub_category = $request?->sub_category;
		$insert->category = $request->category;
		$insert->status = $request->status;
		$insert->slug = $slug;
		$insert->title = $request->title;
		$insert->media_type = $request->media_type;
		$insert->sort_description = $request->sort_description;
		$insert->description = $request->description;

        if ($request->file('thumbnail')) {
            $fileName = time() . '.' . $request->file('thumbnail')->extension();
            $path = 'uploads/blogs/thumb/';
            $uploadedFile = $request->file('thumbnail')->move(public_path($path), $fileName);
            $insert->thumbnail = $path . $fileName;
        }

        if ($request->file('media_file')) {
            $fileName = time() . '.' . $request->file('media_file')->extension();
            $path = 'uploads/blogs/media_file/';
            $uploadedFile = $request->file('media_file')->move(public_path($path), $fileName);
            $insert->media_file = $path . $fileName;
        }

		$insert->save();
		$json['status'] = 1;
		Session::flash('success', 'Blog has been edited successfully.');
		return response()->json($json);
	}
    public function AddBlog(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'title' => 'required',
			'sort_description' => 'required',
			'description' => 'required',
			'category' => [
                'required',
                'exists:category,id'
            ],
            'media_type' => [
                Rule::in(['audio','video','image',''])
            ],
            'status' => [
                Rule::in([1,0])
            ],
            'media_file' => [
                'nullable',
                'mimes:jpeg,gif,png,bmp,jpg,mp4,mp3'
            ],
            'thumbnail' => [
                'required',
                'mimes:jpeg,gif,png,jpg'
            ],
		]);
		if ($validator->fails()) {
			$errors = $validator->errors()->all();

			foreach ($errors as $error) {
				return response()->json([
					'status' => 0,
					'message' => $error,
				]);
			}
		}

		$slug = Str::slug($request->title);
		$originalSlug = $slug;
		$i = 1;
		while (BlogModel::where('slug', $slug)->exists()) {
			$slug = $originalSlug . '-' . $i++;
		}

		$insert = new BlogModel;
		$insert->category = $request->category;
		$insert->sub_category = $request?->sub_category;
		$insert->status = $request->status;
        $insert->slug = $slug;
		$insert->title = $request->title;
		$insert->media_type = $request->media_type;
		$insert->sort_description = $request->sort_description;
		$insert->description = $request->description;

        if ($request->file('thumbnail')) {
            $fileName = time() . '.' . $request->file('thumbnail')->extension();
            $path = 'uploads/blogs/thumb/';
            $uploadedFile = $request->file('thumbnail')->move(public_path($path), $fileName);
            $insert->thumbnail = $path . $fileName;
        }

        if ($request->file('media_file')) {
            $fileName = time() . '.' . $request->file('media_file')->extension();
            $path = 'uploads/blogs/media_file/';
            $uploadedFile = $request->file('media_file')->move(public_path($path), $fileName);
            $insert->media_file = $path . $fileName;
        }

		$insert->save();
		$json['status'] = 1;
		Session::flash('success', 'Blog has been added successfully.');
		return response()->json($json);
	}


	public function category_update(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'id' => [
				'required',
				'exists:category,id'
			],
			'title' => 'required',
			'color' => 'required',
		]);
		if ($validator->fails()) {
			$errors = $validator->errors()->all();

			foreach ($errors as $error) {
				return response()->json([
					'status' => 0,
					'message' => $error,
				]);
			}
		}

			$slug = Str::slug($request->name);
			$originalSlug = $slug;
			$i = 1;
			while (BlogModel::where('slug', $slug)->where('id', '!=', $request->id)->exists()) {
				$slug = $originalSlug . '-' . $i++;
			}

			$insert = BlogModel::where('id',$request->id)->first();
			$insert->title = $request->title;
			$insert->slug = $request->slug;
			$insert->color = $request->color;

			$insert->save();

			$json['status'] = 1;
			Session::flash('message', '<div class="alert alert-success mt-3">Category has been update successfully.</div>');
			return response()->json($json);
	
	}

	public function delete(Request $request)
	{

		$id = $request->id;
		$run = BlogModel::where('id', $id)->delete();

		Session::flash('message', "<div class='alert alert-success mt-3'>Category deleted successfully.</div>");
		return response()->json(['status'=>1]);
	}
}
