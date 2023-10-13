<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatRoomModel;
use Illuminate\Support\Str;

class BlogChat extends Component
{
    /**
     * Create a new component instance.
     */
    public $blog;
    public function __construct($blog)
    {
        $this->blog = $blog;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $userId = Auth::id();

        $thread_id = $this->blog?->id; 
        
        $chats = ChatRoomModel::where('chat_type',2)
            ->where('thread_id',$thread_id)
            ->get();

        $unreads = ChatRoomModel::where('chat_type',2)
            ->where('thread_id',$thread_id)
            //->whereRaw("FIND_IN_SET('".$userId."', read_by)=0")
            ->where(function ($query) use ($userId) {
                $query->whereNull('read_by')
                ->orWhereRaw("FIND_IN_SET('" . $userId . "', read_by) = 0");
            })
    ->get();
    //dd($unreads);
        if(!blank($unreads)){
            foreach($unreads as $unread){
                if($unread->read_by){
                    $unread->read_by = $unread->read_by.','.$userId;
                } else {
                    $unread->read_by =  $userId;
                }
                $unread->save();
            }
        }

        $pageData = [
            'chats'=>$chats,
            'userId'=>$userId,
            'blog'=>$this->blog,
        ];
        return view('components.blog-chat',$pageData);
    }
}
