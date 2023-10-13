<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BlogGrid extends Component
{
    /**
     * Create a new component instance.
     */
    public $blog;
    public $extra_class;
    public function __construct($data)
    {
        
        $this->blog = $data['blog'];
        $this->extra_class = $data['extra_class'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.blog-grid',[
            'blog'=>$this->blog,
            'extra_class'=>$this->extra_class
        ]);
    }
}
