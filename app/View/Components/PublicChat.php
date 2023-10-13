<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\ChatRoomModel;
use Illuminate\Support\Facades\Auth;

class PublicChat extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $userId = Auth::id();

        $thread_id = 0; 
        
        $chats = ChatRoomModel::where('chat_type',0)
            //->where('thread_id',$thread_id)
            ->get();

        $pageData = [
            'chats'=>$chats,
            'userId'=>$userId,
        ];
        //dd($pageData);
        return view('components.public-chat',$pageData);
    }
}
