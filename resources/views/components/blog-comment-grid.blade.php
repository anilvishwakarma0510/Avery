<div class="d-flex align-items-center">
    <div class="images_post">
        <img src="{{ ($data?->getUser()?->image) ? asset($data?->getUser()?->image) :asset('uploads/users/user_318-563642.avif')}}" class="img-fluid" alt="">
    </div>
    <div class="ps-3 ps-sm-4">
        <p class="m-0 fs_22 fw_6 fs_sm_15 color-sec"> by {{ ($data?->getUser()?->name) ? $data?->getUser()?->name : $data?->name}}</p>
        <p class="m-0 fs_20  fs_sm_13 color07"> {{date('M d, Y',strtotime($data?->created_at))}} </p>
    </div>
</div>
<p class="color07 fs_22 mt-2 mt-md-3 fs_sm_15">
{{$data?->comments}}

</p>
<button onclick="replyToComment(<?php echo $data?->id; ?>);" class="btn text-primary btn-transparent fs_22 fs_sm_18 p-0">
    Reply
</button>