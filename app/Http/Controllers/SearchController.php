<?php

namespace App\Http\Controllers;

use App\Models\BlogModel;
use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SearchController extends Controller
{
    private $columns = [
        'blogs.id',
        'blogs.slug',
        'blogs.title',
        'blogs.thumbnail',
        'category.title as cat_title',
        'category.color as cat_color'
    ];

    private $per_page = 12;

    private function myBuilder($builder,$request){
        $builder->where('blogs.status', 1);

        
        if($request?->category){
            $builder->where('blogs.category',$request->category);
        }
        if($request?->palylist_of_week==1){

            $builder->whereDate('blogs.created_at', '>', Carbon::now()->startOfWeek())->whereDate('blogs.created_at', '<', Carbon::now()->endOfWeek());
            
        }

    
        if($request?->keywords){

            $keywords = $request->keywords;

            $category = CategoryModel::where('title','like',$keywords.'%')
                      ->pluck('id')
                      ->toArray();

            $builder->where(function($query) use($keywords,$category){

                $query->where('blogs.title','like','%'.$keywords.'%');
                $query->orWhere('blogs.sort_description','like','%'.$keywords.'%');
                $query->orWhere('blogs.description','like','%'.$keywords.'%');
                if(!blank($category)){
                    $query->orWhereIn('blogs.category',$category);
                }
                
            });
        }

        //$builder->orderByRaw("CASE WHEN users.promote_end_date >= NOW() THEN 0 ELSE 1 END, RAND(), users.id desc");
        $builder->orderByRaw("blogs.id desc");

        return $builder;
    }
    public function index(Request $request){

        $builder = BlogModel::join('category','category.id','blogs.category');

        $builder1 = $this->myBuilder($builder,$request);

        $data = $builder1->paginate(
            $perPage = $this->per_page, $columns = $this->columns
        )->withQueryString();

        return view('front.search',compact("data"));
    }
}
