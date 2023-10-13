<?php

namespace App\Http\Controllers;
use App\Models\BlogModel;
use App\Models\CategoryModel;
use App\Models\BlogCommentModel;
use App\Models\BlogLikeModel;
use App\Models\BlogViewModel;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\View\Components\BlogCommentGrid;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    public function blog_detail(Request $request, $slug=null){
        $validator = Validator::make(['slug'=>$slug],[
            'slug'=>[
                'required',
                'exists:blogs,slug'
            ]
            ],[
                'slug'=>[
                    'required'=>'invalid blog url',
                    'exists'=>'invalid blog url'
                ]
            ]
        );
        if($validator->fails()){
            $errors = $validator->errors()->all();
            $message = "";
            foreach($errors as $error){
                $message .= $error."<br>";
            }
            Session::flash('error',$message);
            return redirect()->route('home');

        }

        //$blog = BlogModel::with('category')->where('slug', $slug)->get();
        //dd($blog->category);

        $blog = BlogModel::where('blogs.slug',$slug)
            //->join('category','category.id','blogs.category')
            ->where('blogs.status',1)
            //->select('blogs.*','category.title as cat_title','category.color as cat_color','category.slug as cat_slug')
            ->first();
        $admin = AdminModel::where('id',1)
            ->first();

        //$isLiked = $blog->isLikeByUser();
        
        
        $insert = BlogViewModel::firstOrNew([
            'ip'=>request()->ip(),
            'blog_id'=>$blog->id
        ]);
        $insert->save();


        $related = BlogModel::where('category',$blog->category)
            //->join('category','category.id','blogs.category')
            ->where('status',1)
            ->where('id','!=',$blog->id)
            //->select('blogs.slug','blogs.thumbnail','blogs.title','category.color as cat_color','category.slug as cat_slug')
            ->take(3)
            ->get();

        $nextBlog = BlogModel::where('category',$blog->category)
            ->where('blogs.status',1)
            ->where('blogs.id','>',$blog->id)
            ->select('slug')
            ->orderBy('id','asc')
            ->first();

        $blogs = BlogModel::where('category',$blog->category)
            ->where('blogs.status',1)
            ->select('slug')
            ->orderBy('id','asc')
            ->get();

           
            
        return view('front.blog-detail',compact("blog","related","admin","nextBlog","blogs"));
    }

    public function add_comment(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=>[
                'required',
                'email'
            ],
            'name'=>[
                'required',
            ],
            'comments'=>[
                'required',
            ],
            'blog_id'=>[
                'required',
                'exists:blogs,id'
            ],
        ]);

        if($validator->fails()){
            $errors = $validator->errors()->all();
            $message = '';
            foreach($errors as $error){
                $message .= $error.'<br>';
            }
            return response()->json([
                'status'=>0,
                'message'=>$message
            ]);
        }

        $insert = new BlogCommentModel;
        $insert->name = $request->name;
        $insert->email = $request->email;
        $insert->comments = $request->comments;
        $insert->blog_id = $request->blog_id;
        $insert->user_id = auth()?->user()?->id;
        $insert->save();

        return response()->json([
            'status'=>1,
            'message'=>'Comment has been added successfully.'
        ]);

    }
    public function reply_comment(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=>[
                'required',
                'email'
            ],
            'name'=>[
                'required',
            ],
            'comments'=>[
                'required',
            ],
            'blog_id'=>[
                'required',
                'exists:blogs,id'
            ],
            'parent_id'=>[
                'required',
                'exists:blog_comments,id'
            ],
        ]);

        if($validator->fails()){
            $errors = $validator->errors()->all();
            $message = '';
            foreach($errors as $error){
                $message .= $error.'<br>';
            }
            return response()->json([
                'status'=>0,
                'message'=>$message
            ]);
        }

        $insert = new BlogCommentModel;
        $insert->name = $request->name;
        $insert->email = $request->email;
        $insert->comments = $request->comments;
        $insert->blog_id = $request->blog_id;
        $insert->parent_id = $request->parent_id;
        $insert->user_id = auth()?->user()?->id;
        $insert->save();

    
        return response()->json([
            'status'=>1,
            'message'=>'Comment has been added successfully.',
            'html'=>$this->getComments($request->blog_id,$request->parent_id),
        ]);

    }
    public function blogLikeAction(Request $request){
        $validator = Validator::make($request->all(),[
            'blog_id'=>[
                'required',
                'exists:blogs,id'
            ],
            'status'=>[
                'required',
                Rule::in([1,0])
            ],
        ]);



        if($validator->fails()){
            $errors = $validator->errors()->all();
            $message = '';
            foreach($errors as $error){
                $message .= $error.'<br>';
            }
            return response()->json([
                'status'=>0,
                'message'=>$message
            ]);
        }


        $check = BlogLikeModel::where('blog_id',$request->blog_id)->where('ip',request()->ip())->first();

        if($check){
           
            $check->delete();
        } else {
            $insert = new BlogLikeModel;
            $insert->blog_id = $request->blog_id;
            $insert->user_id = auth()?->user()?->id;
            $insert->ip = request()->ip();
            $insert->save();
        }

    
        return response()->json(['status'=>1]);

    }
   

    public function getBlogComment(Request $request){
        $validator = Validator::make($request->all(),[
            'blog_id'=>[
                'required',
                'exists:blogs,id'
            ]
        ]);

        if($validator->fails()){
            $errors = $validator->errors()->all();
            $message = '';
            foreach($errors as $error){
                $message .= $error.'<br>'; 
            }
            return response()->json([
                'status'=>0,
                'message'=>$message,
            ]);


        }

        return response()->json([
            'status'=>1,
            'html'=>$this->getComments($request->blog_id,0),
            'message'=>'Success',
        ]);
    }

    private function getComments($blog_id,$parent_id=0){
        $html = '';
        $comments = BlogCommentModel::where('blog_id',$blog_id)->where('parent_id',$parent_id)->orderBy('id','desc')->get();
        
        $html .= '<div class="comment-parent-'.$parent_id.'">';
        if(!blank($comments)){
            //print_r($comments);
            foreach($comments as $key => $comment){
                
                $html .= '<div class="p-0 pt-4 p-md-5">';

                $component = new BlogCommentGrid($comment);
                $html .= $component->render();

                $checkClield = BlogCommentModel::where('blog_id',$blog_id)->where('parent_id',$comment->id)->count();

                //$html .= '<h1>'.$checkClield.'-'.$comment->id.'-'.$blog_id.'</h1>';
              
                if($checkClield > 0){
                    $html .= $this->getComments($blog_id,$comment->id);
                } else {
                    $html .= '<div class="comment-parent-'.$comment->id.'"></div>';
                }
                $html .= '</div>';
                
            }
        } else if($parent_id==0) {
            $html .= '<div class="alert alert-danger">No comments</div>';
        }
        $html .= '</div>';
        return $html;
    }
}
