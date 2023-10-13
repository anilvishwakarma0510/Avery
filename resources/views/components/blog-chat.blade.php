<div class="d-flex align-items-center d-md-none">
    <a class="back">
        <p class="fs_18 text-color-707070 fw_6"><i class="fa-solid fa-arrow-left me-3"></i> Go Back</p>
    </a>
</div>
<div class="row border-bottom pb-2 mb-3 mb-md-5 pb-md-5">
    <div class="col-md-4 col-6 p-0 p-md-2">
        <img src="{{asset($blog?->thumbnail)}}" class="w-100">
    </div>
    <div class="col-md-8 col-6 pe-0 pe-md-2">
        <p class="fs_25 text-color-707070 fs_sm_14 text_clamp_sm mb-1 mb-md-3">{{substr(strip_tags($blog->sort_description),0,150)}}</p>
        <div class="d-flex align-items-center justify-content-between">
            <?php
            $link = route('blog.detail', ['slug' => $blog->slug]);
            ?>
            
            <h2 onclick="window.location.href='{{$link}}'" class="fw_6 fs_20 fs_sm_15 position-relative backline1 backline4" style="z-index: +1; cursor: pointer;">Read Blog <i class="fa-solid fa-arrow-right"></i></h2>
            <button onclick="shareModel('<?php echo $link ?>','<?php echo asset($blog?->thumbnail) ?>')" class="btn btn-primary text-dark btn_add">
                <img src="{{asset('front/img/user_add.png')}}" class="add_img">
            </button>
        </div>
    </div>
</div>


<div class="chat_bx position-relative">

    <div class="p-3 p-md-0  personal_chat_list">
    <?php /* */ ?>
        @if(!blank($chats))

            @foreach($chats as $chat)

                <x-chat-message-grid :message="$chat" ></x-chat-message-grid>

            @endforeach

        @endif 
        <?php /* */?>

        <x-chat-send-message-form></x-chat-send-message-form>
</div>

</div>