<?php

namespace App\Http\Controllers;

use App\Models\BlogModel;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\User as UserModel;
use App\Models\ChatRoomModel;
use App\Models\CommentHelpFulModel;
use App\View\Components\BlogChat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use App\View\Components\OneToOneChat;
use App\View\Components\ChatMessageGrid;
use App\View\Components\ChatUserList;
use App\View\Components\PublicChat;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChatRoomController extends Controller
{

    public function index()
    {
        $category = CategoryModel::get();

        $userid = Auth::id();

        if(!auth()?->user()->age || auth()?->user()->age < 18){
            return redirect()->back()->with('error','You must be at least 18 years old to join the chat room.');
        }
        
        $latestBlogs = CategoryModel::
            //leftJoin('blogs','blogs.category','category.id')
            leftJoin('blogs', function ($join) {
                $join->on('blogs.category', '=', 'category.id')
                ->orderBy('blogs.id','desc');
                //->whereDate('blogs.created_at', '>=', Carbon::now()->startOfWeek());
                //->whereDate('blogs.created_at', '<', Carbon::now()->endOfWeek());
            })
            ->select('category.*')

            ->selectRaw('(select count(id) from chat_room where thread_id=blogs.id and FIND_IN_SET("' . $userid . '", read_by) = 0 and chat_type = 2) as unread')
            ->selectRaw('(select MAX(id) from chat_room where thread_id=blogs.id and chat_type = 2) as max_id')
            ->selectRaw('MAX(blogs.id) as blog_id')
            //->selectRaw('(select message from chat_room where thread_id=blogs.id and chat_type = 2 order by id desc limit 1) as last_message')
            //->selectRaw('(select thread_id from chat_room where thread_id=blogs.id and chat_type = 2 order by id desc limit 1) as blog_id')
          
           
            ->orderBy('max_id', 'desc')
            ->orderBy('blogs.id', 'desc')
            ->groupBy('category.id')
            //->having('max_id','>',0)
            ->get();
        //dd($latestBlogs);

        $onlineUsers = UserModel::where('id', '!=', $userid)
            ->select('users.id', 'users.name', 'users.image')
            ->selectRaw('(select count(id) from chat_room where chat_room.sender=users.id and chat_room.receiver=' . $userid . ' and is_read=0 and chat_type = 1) as unread')
            ->selectRaw('(select MAX(id) from chat_room where ((chat_room.sender=users.id and chat_room.receiver=' . $userid . ') or (chat_room.sender=' . $userid . ' and chat_room.receiver=users.id)) and chat_type = 1) as max_id')
            ->selectRaw('(select message from chat_room where ((chat_room.sender=users.id and chat_room.receiver=' . $userid . ') or (chat_room.sender=' . $userid . ' and chat_room.receiver=users.id)) and chat_type = 1 order by id desc limit 1) as last_message')
            ->orderBy('max_id', 'desc')
            ->get();
        //dd($onlineUsers);

        $last = ChatRoomModel::where('thread_id', 0)->orderBy('id', 'desc')->first('id');

        $last_chat_id = ($last?->id) ? $last?->id : 0;
        return view('front.chatroom', [
            'category' => $category,
            'onlineUsers' => $onlineUsers,
            'last_chat_id' => $last_chat_id,
            'latestBlogs' => $latestBlogs,
        ]);
    }

    public function getPersonChat(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'chat_type' => [
                'required',
                Rule::in([0, 1, 2])
            ],
            'receiver' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('chat_type') == 1;
                }),
                'exists:users,id'
            ],
            'category_id' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('chat_type') == 2;
                }),
                'exists:category,id'
            ],
            'blog_id' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('chat_type') == 2;
                }),
                'exists:blogs,id'
            ],
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors()->all();
            $message = '';
            foreach ($errors as $error) {
                $message .= $error . '<br>';
            }
            return response()->json([
                'status' => 0,
                'message' => $message
            ]);
        }

        $chat_type = $request->chat_type;

        $html = '';
        $userId = Auth::id();
        $thread_id = 0;
        if ($chat_type == 0) {
            $component = new PublicChat();
            $html .= $component->render();
        } else if ($chat_type == 1) {
            $receiver = $request->receiver;
            $component = new OneToOneChat($receiver);
            $html .= $component->render();
            $thread_id = ($userId > $receiver) ? $receiver . '_' . $userId : $userId . '_' . $receiver;
        } else if ($chat_type == 2) {
            $category_id = $request->category_id;
            $blog_id = $request->blog_id;
            $thread_id = $blog_id;

            $blog = BlogModel::where('id', $blog_id)->first();


            $component = new BlogChat($blog);
            $html .= $component->render();
        }


        $last = ChatRoomModel::where('thread_id', $thread_id)->orderBy('id', 'desc')->first('id');

        $last_chat_id = ($last?->id) ? $last?->id : 0;


        return response()->json([
            'status' => 1,
            'message' => 'Success',
            'last_chat_id' => $last_chat_id,
            'html' => $html
        ]);
    }
    public function getChatRoomBlogList(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'category_id' => [
                'required',
                'exists:category,id'
            ]
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors()->all();
            $message = '';
            foreach ($errors as $error) {
                $message .= $error . '<br>';
            }
            return response()->json([
                'status' => 0,
                'message' => $message
            ]);
        }

        $category_id = $request->category_id;

        $blogs = BlogModel::where('category', $category_id)->orderBy('id', 'desc')->get();



        $html = '';
        $userId = Auth::id();

        if (!blank($blogs)) {

            foreach ($blogs as $blog) {
                //dd($blog->blog_category->title);
                $html .= '<div class="row border-bottom">
            <div class="col-md-4 col-6 p-0 p-md-2">
                <img src="' . asset($blog->thumbnail) . '" class="w-100">
            </div>
            <div class="col-md-8 col-6 pe-0 pe-md-2">
                <p class="fs_25 text-color-707070 fs_sm_14 text_clamp_sm mb-1 mb-md-3">' . substr(strip_tags($blog->sort_description), 0, 150) . '</p>
                <div onclick="open_blog_chatroom(' . $blog?->id . ',' . $blog?->blog_category?->id . ');" class="d-flex align-items-center justify-content-between">
                    <h2 class="fw_6 fs_20 fs_sm_15 position-relative backline1 backline4" style="z-index: +1; cursor: pointer;">Open Chat Room <i class="fa-solid fa-arrow-right"></i></h2>
                </div>
            </div>
        </div>';
            }
        } else {
            $html .= '<div class="row border-bottom">
            <div class="col-md-12 col-6 p-0 p-md-2">
                <div class="alert alert-danger">We did not found any topic for this category</div>
            </div></div>';
        }



        return response()->json([
            'status' => 1,
            'message' => 'Success',
            'html' => $html
        ]);
    }
    public function SendMessage(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'chat_type' => [
                'required',
                Rule::in([0, 1, 2])
            ],
            'receiver' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('chat_type') == 1;
                }),
                'exists:users,id'
            ],
            'category_id' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('chat_type') == 2;
                }),
                'exists:category,id'
            ],
            'blog_id' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('chat_type') == 2;
                }),
                'exists:blogs,id'
            ],
            'message' => [
                'required',
            ]

        ]);

        if ($validate->fails()) {
            $errors = $validate->errors()->all();
            $message = '';
            foreach ($errors as $error) {
                $message .= $error . '<br>';
            }
            return response()->json([
                'status' => 0,
                'message' => $message
            ]);
        }

        $userId = Auth::id();

        $chat_type = $request->chat_type;


        if ($chat_type == 0) {
            $thread_id = 0;
        } else if ($chat_type == 1) {
            $receiverID = $request->receiver;
            $thread_id = ($userId > $receiverID) ? $receiverID . '_' . $userId : $userId . '_' . $receiverID;
        } else if ($chat_type == 2) {
            $blog_id = $request->blog_id;
            $thread_id = $blog_id;
        }

        $insert = new ChatRoomModel;
        $insert->sender = $userId;
        $insert->read_by = $userId;
        $insert->receiver = $request?->receiver;
        $insert->message = $request?->message;
        $insert->chat_type = $request?->chat_type;
        $insert->blog_id = $request?->blog_id;
        $insert->category_id = $request?->category_id;
        $insert->thread_id = $thread_id;
        $insert->is_read = 0;
        $insert->is_delivered = 0;

        $insert->save();

        $html = '';
        if($chat_type==1){
            $html = '<div class="chat_box mt-4 mt-md-3">
            <div class="d-flex align-items-center justify-content-end gap-2 gap-md-3 ">

                <div class="message_body">
                    <p class="m-0 text-end fs_15 fs_sm_13">'.strip_tags($insert?->message).'</p>
                </div>

            </div>
        </div>';
        } else {
            $component = new ChatMessageGrid($insert);
            $html .= $component->render();
        }
        


        return response()->json([
            'status' => 1,
            'message' => 'Success',
            'last_chat_id' => $insert->id,
            'html' => $html
        ]);
    }
    public function GetCatMessage(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'chat_type' => [
                'required',
                Rule::in([0, 1, 2])
            ],
            'receiver' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('chat_type') == 1;
                }),
                'exists:users,id'
            ],
            'category_id' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('chat_type') == 2;
                }),
                'exists:category,id'
            ],
            'blog_id' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('chat_type') == 2;
                }),
                'exists:blogs,id'
            ],
            'last_chat_id' => [
                'required'
            ]
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors()->all();
            $message = '';
            foreach ($errors as $error) {
                $message .= $error . '<br>';
            }
            return response()->json([
                'status' => 0,
                'message' => $message
            ]);
        }

        $userId = Auth::id();

        $receiverID = $request->receiver;
        $last_chat_id = $request->last_chat_id;
        $chat_type = $request->chat_type;

        $thread_id = 0;
        if ($chat_type == 1) {
            $thread_id = ($userId > $receiverID) ? $receiverID . '_' . $userId : $userId . '_' . $receiverID;
        } else if ($chat_type == 2) {
            $category_id = $request->category_id;
            $blog_id = $request->blog_id;
            $thread_id = $blog_id;
        }


        $builder = ChatRoomModel::where('thread_id', $thread_id)
            ->where('chat_type', $chat_type)
            ->where('id', '>', $last_chat_id);

        $messages = $builder->get();

        if ($chat_type == 1) {
            ChatRoomModel::where('thread_id', $thread_id)
                ->where('chat_type', $chat_type)
                ->where('is_read', 0)
                ->where('receiver', $userId)
                ->update(['is_read' => 1]);
        }
        $last_chat_id = 0;


        $html = '';
        foreach ($messages as $message) {
            if ($chat_type == 1) {
                $html .= '<div class="chat_box mt-4 mt-md-3">
                <div class="d-flex align-items-center justify-content-start gap-2 gap-md-3">
    
                    <div class="message_body bg-white">
                        <p class="m-0 text-start fs_15 fs_sm_13">' . $message->message . '</p>
                    </div>
                </div>
            </div>';
            } else {
                $component = new ChatMessageGrid($message);
                $html .= $component->render();
            }

            if($chat_type==2){
                if($message->read_by){
                    $message->read_by = $message->read_by.','.$userId;
                } else {
                    $message->read_by =  $userId;
                }
                $message->save();
            }

            $last_chat_id = $message->id;
        }



        return response()->json([
            'status' => 1,
            'message' => 'Success',
            'last_chat_id' => $last_chat_id,
            'html' => $html,
        ]);
    }

    public function GetUserList(Request $request)
    {

        $userId = Auth::id();


        $users = '';
        if ($request->blog_id && !empty($request->blog_id) && 1==2) {

            $category_id = $request?->category_id; 
            $subquery = DB::table('chat_room')
                ->select(DB::raw('MAX(id) as max_id'))
                ->groupBy('sender');

            $onlineUsers = UserModel::where('chat_room.thread_id', $request->blog_id)
                ->where('chat_room.chat_type', 2)
                ->join('chat_room', function ($join) use ($subquery) {
                    $join->on('chat_room.sender', '=', 'users.id')
                        ->whereIn('chat_room.id', $subquery);
                })
                ->select('users.id', 'users.name', 'users.image', 'chat_room.message as last_message')
                ->orderBy('chat_room.id', 'desc')
                ->orderBy(function ($query) use ($subquery) {
                    $query->select('max_id')
                        ->fromSub($subquery, 'sub')
                        ->whereRaw('sub.max_id = chat_room.id');
                }, 'desc')
                ->groupBy('users.id')
                ->get();

            /*$onlineUsers = UserModel::where('chat_room.thread_id', $request->blog_id)
                ->where('chat_room.chat_type', 2)
                ->join('chat_room', 'chat_room.sender', 'users.id')
                ->select('users.id', 'users.name', 'users.image', 'chat_room.message as last_message')
                ->selectRaw('MAX(chat_room.id) as max_id')
                ->orderBy('max_id', 'desc')
                ->groupBy('users.id')
                ->get();*/
        } else {
            $onlineUsers = UserModel::where('id', '!=', $userId)
                ->select('users.id', 'users.name', 'users.image')
                ->selectRaw('(select count(id) from chat_room where chat_room.sender=users.id and chat_room.receiver=' . $userId . ' and is_read=0 and chat_type = 1) as unread')
                ->selectRaw('(select MAX(id) from chat_room where ((chat_room.sender=users.id and chat_room.receiver=' . $userId . ') or (chat_room.sender=' . $userId . ' and chat_room.receiver=users.id)) and chat_type = 1) as max_id')
                ->selectRaw('(select message from chat_room where ((chat_room.sender=users.id and chat_room.receiver=' . $userId . ') or (chat_room.sender=' . $userId . ' and chat_room.receiver=users.id)) and chat_type = 1 order by id desc limit 1) as last_message')
                ->orderBy('max_id', 'desc')
                ->get();
        }
        $active_user_id = $request->active_user_id;

        if (!blank($onlineUsers)) {
            foreach ($onlineUsers as $onlineUser) {
                $component = new ChatUserList($onlineUser, $active_user_id);
                $users .= $component->render();
            }
        } else {
            $users = '<p class="alert alert-danger">No one is online right now</p>';
        }

        $categroyHtml = '';

        $latestBlogs = CategoryModel::
            leftJoin('blogs', function ($join) {
                $join->on('blogs.category', '=', 'category.id')
                ->orderBy('blogs.id','desc');
                //->whereDate('blogs.created_at', '>=', Carbon::now()->startOfWeek());
            })
            ->select('category.*')

            ->selectRaw('(select count(id) from chat_room where thread_id=blogs.id and FIND_IN_SET("' . $userId . '", read_by) = 0 and chat_type = 2) as unread')
            ->selectRaw('(select MAX(id) from chat_room where thread_id=blogs.id and chat_type = 2) as max_id')
            ->selectRaw('MAX(blogs.id) as blog_id')
            ->orderBy('max_id', 'desc')
            ->orderBy('blogs.id', 'desc')
            ->groupBy('category.id')
            //->having('max_id','>',0)
            ->get();
        $category_id = ($request?->category_id) ? $request?->category_id : 0;
        foreach($latestBlogs as $cat){
            $blog_id = ($cat->blog_id) ? $cat->blog_id : 0;

            $active = ($category_id==$cat->id) ? 'active' : '';
            $is_unread = ($cat?->unread > 0) ? 'is_unread' : '';

            $categroyHtml .= '<div onclick="open_blog_chatroom('.$blog_id.','.$cat->id.');" class="card-body topic_bx-all topic_bx-single-'.$cat->id.' '.$active.' '.$is_unread.'" style="background: '.$cat->color.';">
            <div class="d-flex align-items-center gap-3">

                <div class="col">
                    <div class="d-flex align-items-center">
                        <h5 class="me-auto mb-0 fs_18">'.$cat->title.'</h5>
                    </div>
                </div>
                <div class="badge badge-circle bg-white text-dark">
                    <span class="">'.$cat->unread.'</span>
                </div>
            </div>
        </div>';
        }




        return response()->json([
            'status' => 1,
            'message' => 'Success',
            'users' => $users,
            'category' => $categroyHtml,
            'count' => count($onlineUsers),
        ]);
    }

    public function commentHelpFulAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chat_room_id' => [
                'required',
                'exists:chat_room,id'
            ],
            'status' => [
                'required',
                Rule::in([1, 0])
            ],
        ]);



        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $message = '';
            foreach ($errors as $error) {
                $message .= $error . '<br>';
            }
            return response()->json([
                'status' => 0,
                'message' => $message
            ]);
        }

        $userId = Auth::id();


        $check = CommentHelpFulModel::where('chat_room_id', $request->chat_room_id)->where('user_id', $userId)->first();

        if ($check) {
            $check->delete();
        } else {
            $insert = new CommentHelpFulModel;
            $insert->chat_room_id = $request->chat_room_id;
            $insert->user_id = $userId;
            $insert->save();
        }


        return response()->json(['status' => 1]);
    }
}
