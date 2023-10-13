<?php

namespace App\View\Components;

use App\Models\ChatRoomModel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Auth;

class OneToOneChat extends Component
{
    /**
     * Create a new component instance.
     */
    public $receiver;
    public function __construct($receiver=null)
    {
        $this->receiver = $receiver;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $receiverd = UserModel::where('id',$this->receiver)->select('id','name','image')->first();
        $userId = Auth::id();
        $receiverID = $this->receiver;

        $thread_id = ($userId > $receiverID) ? $receiverID.'_'.$userId : $userId.'_'.$receiverID; 
        
        $chats = ChatRoomModel::where('chat_type',1)
            ->where('thread_id',$thread_id)
            ->get();

        ChatRoomModel::where('thread_id',$thread_id)
            ->where('chat_type',1)
            ->where('is_read',0)
            ->where('receiver',$userId)
            ->update(['is_read'=>1]);

        $pageData = [
            'chats'=>$chats,
            'receiver'=>$receiverd,
            'userId'=>$userId,
        ];
        return view('components.one-to-one-chat',$pageData);
    }
}
