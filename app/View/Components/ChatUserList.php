<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ChatUserList extends Component
{
    /**
     * Create a new component instance.
     */
    public $user;
    public $activeUser;
    public function __construct($user,$activeUser=null)
    {
        $this->user = $user;
        $this->activeUser = $activeUser;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $pageData = [
            'user'=>$this->user,
            'activeUser'=>$this->activeUser,
        ];

        return view('components.chat-user-list',$pageData);
    }
}
