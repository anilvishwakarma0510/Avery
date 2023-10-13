<div class="d-flex align-items-center d-md-none">
    <a class="back">
        <p class="fs_18 text-color-707070 fw_6"><i class="fa-solid fa-arrow-left me-3"></i> Go Back</p>
    </a>
</div>

<div class="pb-5 mb-5 mb-md-3">
    <div class="d-flex align-items-center justify-content-between mb-5">

        <div class="d-flex align-items-center gap-3">
            <div class="col-auto">
                <div class="avatar avatar-online">
                    <img src="{{($receiver?->image) ? asset($receiver?->image) : asset('uploads/users/user_318-563642.avif')}}" alt="#" class="avatar avatar-img img_round">
                </div>
            </div>

            <div class="col">
                <div class="d-flex align-items-center">
                    <h5 class="me-auto mb-0 fs_18">{{$receiver?->name}}</h5>
                </div>

                <!-- <div class="d-flex align-items-center">
                    <div class="line-clamp me-auto fs_14">
                        Do you know where mona lisa is from?
                    </div>
                </div> -->
            </div>

        </div>

      

    </div>

    <div class="all_messages personal_chat_list">
        @if(!blank($chats))

        @foreach($chats as $chat)

        @if($chat->sender==$userId)
        
        <div class="chat_box mt-4 mt-md-3">
            <div class="d-flex align-items-center justify-content-end gap-2 gap-md-3 ">

                <div class="message_body">
                    <p class="m-0 text-end fs_15 fs_sm_13"><?= strip_tags($chat?->message); ?></p>
                </div>

            </div>
        </div>

        @else

        <div class="chat_box mt-4 mt-md-3">
            <div class="d-flex align-items-center justify-content-start gap-2 gap-md-3">

                <div class="message_body bg-white">
                    <p class="m-0 text-start fs_15 fs_sm_13"><?= strip_tags($chat->message) ?></p>
                </div>
            </div>
        </div>

        

        @endif


        @endforeach

        @endif

        
    </div>
</div>


<x-chat-send-message-form></x-chat-send-message-form>