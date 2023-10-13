<?php
use App\Models\SocialLinkModel;
$socialLinks = SocialLinkModel::where('id',1)->first();
?>
<footer class="footer  container-xxl mt-3 mt-md-5 px-3 px-md-5">
    <div class="footer_top">
        <div class="row align-items-baseline align-items-md-center gap-0 gap-md-0">
            <div class="col-8 col-md-3">
                <h3 class="m-0 text-primary fs_45 fs_sm_30 fw_6 text-start text-md-left">Avery's Take</h3>
                <div class="d-block d-md-none align-items-center gap-2 social_icons justify-content-center justify-content-md-end mt-3">
                    <a target="_blank" href="<?php echo $socialLinks?->facebook ?>"><img src="{{ asset('front/img/fb.png')}}"></a>
                    <a target="_blank" href="<?php echo $socialLinks?->instagram ?>"><img src="{{ asset('front/img/insta.png')}}"></a>
                    <a target="_blank" href="<?php echo $socialLinks?->twitter ?>"><img src="{{ asset('front/img/twitter.png')}}"></a>
                    <a target="_blank" href="<?php echo $socialLinks?->linkedin ?>"><img src="{{ asset('front/img/linkedin.png')}}"></a>
                </div>
            </div>

            <div class="col-4 col-md-6">
                <ul class="bottom_menu">
                    <li><a href="{{route('about-me')}}">About Me</a></li>
                    <li><a href="{{route('blog.search')}}?category=2">Fashion</a></li>
                    <li><a href="{{route('home')}}#trending">Trending</a></li>
                    <li><a href="{{route('blog.search')}}?category=5">Money Tips</a></li>
                </ul>
            </div>

            <div class="col-6 col-md-3 d-none d-md-block">
                <div class="d-none d-md-flex align-items-center gap-2 social_icons justify-content-center justify-content-md-end">
                    <a target="_blank" href="<?php echo $socialLinks?->facebook ?>"><img src="{{ asset('front/img/fb.png')}}"></a>
                    <a target="_blank" href="<?php echo $socialLinks?->instagram ?>"><img src="{{ asset('front/img/insta.png')}}"></a>
                    <a target="_blank" href="<?php echo $socialLinks?->twitter ?>"><img src="{{ asset('front/img/twitter.png')}}"></a>
                    <a target="_blank" href="<?php echo $socialLinks?->linkedin ?>"><img src="{{ asset('front/img/linkedin.png')}}"></a>
                </div>
            </div>
        </div>
    </div>

    <div class="footer_bottom my-5">
        <ul class="bottom_menu bottom_terms">
            
            <li class="border-0"><a href="{{route('terms-and-condition')}}" class="ps-0">Terms &amp; Conditions</a></li>
            <li><a href="{{route('privacy-policy')}}">Privacy Policy</a></li>
            <li><a href="{{route('contact-us')}}">Contact Us</a></li>
            <li><a onclick="alert('coming soon'); return false;" href="chatroom.php">join Live Chat</a></li>
        </ul>
    </div>
</footer>



<div class="offcanvas offcanvas-end w-100 border-0" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
    <div class="offcanvas-header justify-content-start justify-content-md-end me-0 ms-0 ms-md-0 me-md-5">
        <button type="button" class="btn-close text-reset fs_30 fs_sm_25" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <ul class="top_menu">
             @if(auth()?->user())
            <li><a href="{{route('edit-profile')}}" class="ps-0">Profile Setting</a></li>
            <li><a href="{{route('chat-room')}}">Enter Chat</a></li>
            @else
            <li><a href="{{route('registration')}}">Create Account</a></li>
            <li><a href="{{route('registration')}}">Enter Chat</a></li>
            @endif

            <li><a href="{{route('about-me')}}">About</a></li>
            <li><a href="{{route('contact-us')}}">Contact Us</a></li>
            <li><a href="{{route('blog.search')}}?palylist_of_week=1">PlayList of the week</a></li>
        </ul>
    </div>
</div>

