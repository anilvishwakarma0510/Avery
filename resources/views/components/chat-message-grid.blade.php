@if($message?->getSender())
@if($message?->getSender()?->id == $userID)
<div class="chat_box mt-4 mt-md-3">
    <div class="d-flex align-items-center justify-content-end gap-2 gap-md-3 ">
        <div class="d-flex align-items-center" style="cursor: pointer;">
            @if($message->isMarkHelpFul())
            <p onclick="markAsHelpFul(this,0,<?= $message?->id?>)" class="text-warning m-0 text-italic fs_15"><span class="dis-none">Helpful</span> <i class="fa-solid fa-thumbs-up"></i></p>
            @else
            <p onclick="markAsHelpFul(this,1,<?= $message?->id?>)" class="text-dark m-0 text-italic fs_15"><span class="dis-none">Helpful</span> <i class="fa-solid fa-thumbs-up"></i></p>
            @endif
        </div>
        <div class="message_body">
            <p class="m-0 text-end fs_15 fs_sm_13"><?= strip_tags($message?->message); ?></p>
        </div>
        <div>
        <img src="{{($message?->getSender()?->image) ? asset($message?->getSender()?->image) : asset('uploads/users/user_318-563642.avif')}}" class="img_round avatar show_comment">
        </div>
    </div>
</div>
@else
<div class="chat_box mt-4 mt-md-3">
    <div class="d-flex align-items-center justify-content-start gap-2 gap-md-3">
    <div>
        <img src="{{($message?->getSender()?->image) ? asset($message?->getSender()?->image) : asset('uploads/users/user_318-563642.avif')}}" class="img_round avatar show_comment">
        </div>
        <div class="message_body bg-white">
            <p class="m-0 text-start fs_15 fs_sm_13"><?= strip_tags($message?->message); ?></p>
        </div>
        <div class="d-flex align-items-center" style="cursor: pointer;">
            @if($message->isMarkHelpFul())
            <p onclick="markAsHelpFul(this,0,<?= $message?->id?>)" class="text-warning m-0 text-italic fs_15"><span class="dis-none">Helpful</span> <i class="fa-solid fa-thumbs-up"></i></p>
            @else
            <p onclick="markAsHelpFul(this,1,<?= $message?->id?>)" class="text-dark m-0 text-italic fs_15"><span class="dis-none">Helpful</span> <i class="fa-solid fa-thumbs-up"></i></p>
            @endif
        </div>
    </div>
</div>
@endif
@endif