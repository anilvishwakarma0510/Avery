<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class ChatMessageGrid extends Component
{
    /**
     * Create a new component instance.
     */
    public $message;
    public function __construct($message=null)
    {
        $this->message = $message;
        //dd($this->message->getSender()->name);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $userID = Auth::id();
        $pageData = [
            'message' => $this->message,
            'userID' => $userID,
        ];

        return view('components.chat-message-grid',$pageData);
    }
}
