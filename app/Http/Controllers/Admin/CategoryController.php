<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\CategoryModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
	public function index(REQUEST $request)
	{

		$data = CategoryModel::orderBy('id', 'desc')->get();
		return view('admin.category-list', compact('data'));
	}

	public function add_category(REQUEST $request)
	{

		//print_r($_REQUEST);



		$validator = Validator::make($request->all(), [
			'title' => 'required',
			'color' => 'required',
			'icon' => [
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
		while (CategoryModel::where('slug', $slug)->exists()) {
			$slug = $originalSlug . '-' . $i++;
		}

		$insert = new CategoryModel;
		$insert->title = $request->title;
		$insert->slug = $request->slug;
		$insert->color = $request->color;

		if ($request->file('icon')) {
            $fileName = time() . '.' . $request->file('icon')->extension();
            $path = 'uploads/category_icon/';
            $uploadedFile = $request->file('icon')->move(public_path($path), $fileName);
            $insert->icon = $path . $fileName;
        }

		$insert->save();
		$json['status'] = 1;
		Session::flash('message', '<div class="alert alert-success mt-3">Category has been added successfully</div>');
		return response()->json($json);
	}


	public function category_update(REQUEST $request)
	{
		$validator = Validator::make($request->all(), [
			'id' => [
				'required',
				'exists:category,id'
			],
			'title' => 'required',
			'color' => 'required',
			'icon' => [
				//'required',
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
			while (CategoryModel::where('slug', $slug)->where('id', '!=', $request->id)->exists()) {
				$slug = $originalSlug . '-' . $i++;
			}

			$insert = CategoryModel::where('id',$request->id)->first();
			$insert->title = $request->title;
			$insert->slug = $slug;
			$insert->color = $request->color;

			if ($request->file('icon')) {
				$fileName = time() . '.' . $request->file('icon')->extension();
				$path = 'uploads/category_icon/';
				$uploadedFile = $request->file('icon')->move(public_path($path), $fileName);
				$insert->icon = $path . $fileName;
			}

			$insert->save();

			$json['status'] = 1;
			Session::flash('message', '<div class="alert alert-success mt-3">Category has been update successfully.</div>');
			return response()->json($json);
	
	}

	public function delete(REQUEST $request)
	{

		$id = $request->id;
		$run = CategoryModel::where('id', $id)->delete();

		Session::flash('message', "<div class='alert alert-success mt-3'>Category deleted successfully.</div>");
		return response()->json(['status'=>1]);
	}
}
