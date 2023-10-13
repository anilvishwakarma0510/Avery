<div class="d-flex align-items-center d-md-none">
    <a class="back">
        <p class="fs_18 text-color-707070 fw_6"><i class="fa-solid fa-arrow-left me-3"></i> Go Back</p>
    </a>
</div>
<div class="welcome_chat chat_right p-0 p-md-3">

    <div class="border-bottom pb-5 mb-3 mb-0">
        <div class="welcom_bx p-3 border-bottom mb-0 mb-md-3">
            <h3 class="fs_35 fs_sm_20">General Discussion Chat Room<br>Welcome {{auth()?->user()?->name}}</h3>
            <p class="fs_sm_16">Please be polite and respectful. Have fun sharing ideas and making friends! </p>
            <!-- <h2>SWAK- Avery</h2> -->
        </div>


        <div class="p-3 p-md-0  personal_chat_list">

    
        <?php /* */ ?>
        @if(!blank($chats))

            @foreach($chats as $chat)

                <x-chat-message-grid :message="$chat" ></x-chat-message-grid>

            @endforeach

        @endif 
        <?php /* */?>
            
        </div>
    </div>

    <x-chat-send-message-form></x-chat-send-message-form>
   

</div>