<style>

</style>
<form class="chat-form mb-4 me-4 border-top pt-3" id="sendMessage" onsubmit="return sendMessage()" data-emoji-form="">
    @csrf
    <div class="row align-items-center gx-0">
        <div class="col bg-white">
            <div class="input-group">
                <input type="text" class="form-control px-3 border-0 bg_tranparent" placeholder="Enter your message here" data-emojiable="true"   name="message" id="mytextarea"  >

            
            </div>
        </div>

        <div class="col-auto">
            <button class="btn btn-icon bg-white shadow-lg ms-3 submit-btn-1 sm_pd">
                <i class="fa-solid fa-paper-plane text-primary"></i>
            </button>
        </div>
    </div>
</form>


<script>
 

</script>