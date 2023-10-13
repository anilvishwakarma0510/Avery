@extends('front.layout.app')

@section('content')
<style>
    .post.backline3:before {
        right: -22px;
    }
</style>
<div class="gray-back"></div>
<section class="form_top_m position-relative">
    <div class="form_back_y"><img src="{{asset('front/img/back_yellow_shap.png')}}" class="img-fluid" alt=""></div>
    <div class=" form_back mx-auto">
        <div class="text-center">
            <h2 class="fw_8 text-secondar mb-3 mb-sm-2 px-md-5 p-0 fs_30 color-sec fs_sm_22">Forgot Password</h2>
           
        </div>
        <form id="form-1" onsubmit="return submit_form_step1()" action="" method="POST">
            @csrf
            <div class="mb-2 mb-md-3">
                <input type="email" required name="email" id="email" class="mt-2 input_custom p-2 p-md-3  input_custom_sm fs_sm_15" placeholder="Email*">
            </div>

            <div class="text-center mt-5 mb-4">
                <button class="fw_8 text-secondar mb-0 fs_sm_18  fs_25 position-relative backline1 related post backline3 border-0 bg-transparent submit-btn-1">
                    <span>Submit</span>
                </button>
            </div>
        </form>


    </div>
    <div class="text-center mt-4">
        <p class="text-secondary fs_22 fs_sm_18"> Already have an account?<a href="{{route('login')}}" class="text-primary"> Sign In.</a>
        </p>
    </div>
</section>
@endsection

@section('script')
<script>
  
    function submit_form_step1() {
        let formData = new FormData($('#form-1')[0]);
        console.log(formData);
        $.ajax({
            type: 'POST',
            url: "{{route('send-reset-password-link')}}",
            data: formData,
            dataType: 'JSON',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('.submit-btn-1').prop('disabled', true);
                $('.submit-btn-1').html('<span>Processing...</span>');
                $('.error').html('');
            },
            success: function(resp) {
                $('.submit-btn-1').prop('disabled', false);
                $('.submit-btn-1').html('<span>Submit</span>');
                if (resp.status == 1) {

                    $('#email').val('');

                    toastr['success'](resp.message, 'Success')

                } else {
                    toastr['error'](resp.message, 'Error')
                }
            },
            error: function(error) {
                $('.submit-btn-1').prop('disabled', false);
                $('.submit-btn-1').html('<span>Submit</span>');
                let message;
                if (error?.responseJSON?.message) {
                    message = error?.responseJSON?.message;
                } else if (error?.message) {
                    message = error?.message;
                } else {
                    message = 'Something went wrong, try again later'
                }

                toastr['error'](message, 'Error')
            }
        });
        return false;
    }
</script>
@endsection