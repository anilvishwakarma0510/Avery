<div onclick="OpenOneToOneChat(this,<?= $user->id; ?>)" class="card-body chat_list_card <?php echo ($user?->id==$activeUser) ? 'active' : '';?>  <?php echo ($user?->unread > 0) ? 'is_unread' : '' ?>">
    <div class="d-flex align-items-center gap-3">
        <div class="col-auto">
            <div class="avatar avatar-online">
                <img src="{{($user?->image) ? asset($user?->image) : asset('front/img/01.jpg')}}" alt="#" class="avatar avatar-img img_round">
            </div>
        </div>

        <div class="col">
            <div class="d-flex align-items-center">
                <h5 class="me-auto mb-0 fs_18">{{$user?->name}}</h5>
            </div>

            <div class="d-flex align-items-center">
                <div class="line-clamp me-auto fs_14">
                    <?= substr(strip_tags($user?->last_message),0,20); ?>...
                </div>
            </div>
        </div>
        @if($user?->unread > 0)
        <div class="badge badge-circle bg-white text-dark badge_fix">
            <span>{{$user?->unread}}</span>
        </div>
        @endif
    </div>
</div>