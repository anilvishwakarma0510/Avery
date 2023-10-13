<a href="{{ route('blog.detail', ['slug' => $blog->slug]) }}">
    <div class="latest_bx position-relative m-0 mb-0 mb-md-3 mb-md-4">
        <div class="position-relative overlay_bx">
            <img src="{{ asset($blog->thumbnail)}}" class="w-100">
            <div class="position-absolute overlay_back {{$extra_class}}">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center gap-1 like_comment_view">
                            <img src="{{ asset('front/img/heart.png')}}">
                            <p class="m-0">{{$blog->getLikesCountAttribute()}}</p>
                        </div>
                        <div class="d-flex align-items-center gap-1 like_comment_view">
                            <img src="{{ asset('front/img/comment.png')}}">
                            <p class="m-0">{{$blog->getCommentsCountAttribute()}}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-1 like_comment_view">
                        <p class="m-0">{{$blog->getBlogViews()}}</p>
                        <img src="{{ asset('front/img/eye.png')}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="topic_left_position_sm">
            <p class="px-2 py-1 m-0 mt-2 custom_badge" style="background: <?php echo $blog?->blog_category?->color; ?>;">{{$blog?->blog_category?->title}}</p>
            <p class="mt-2">{{$blog?->title}}</p>
        </div>

    </div>
</a>