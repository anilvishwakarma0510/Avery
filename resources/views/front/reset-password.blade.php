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
            @if (session()->has('message'))

            

            <?php echo session()->get('message'); ?>

            @endif
        </div>
        @if(!isset($hide_form))

        <div class="text-center">
            <h2 class="fw_8 text-secondar mb-3 mb-sm-2 px-md-5 p-0 fs_30 color-sec fs_sm_22">Create New Password</h2>

        </div>
        <form id="form-1" action="{{url('reset-password')}}" method="POST">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <div class="mb-2 mb-md-3">
                <input type="email" name="email" id="email" value="{{ old('email') }}" required class="mt-2 input_custom p-2 p-md-3  input_custom_sm fs_sm_15" placeholder="Email*">
            </div>

            <div class="mb-2 mb-md-3 position-relative">
                <input type="password" required name="password" id="password" class="mt-2 input_custom p-2 p-md-3  input_custom_sm fs_sm_15" placeholder="Password*">
                <i onclick="hideShowPassword(this,'password')" class="fa-regular fa-eye-slash eyep"></i>
            </div>
            <div class="mb-2 mb-md-3 position-relative">
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-2 input_custom p-2 p-md-3  input_custom_sm fs_sm_15" placeholder="Confirm password*">
                <i onclick="hideShowPassword(this,'password_confirmation')" class="fa-regular fa-eye-slash eyep"></i>
            </div>

            <div class="text-center mt-5 mb-4">
                <button class="fw_8 text-secondar mb-0 fs_sm_18  fs_25 position-relative backline1 related post backline3 border-0 bg-transparent submit-btn-1">
                    <span>Submit</span>
                </button>
            </div>
        </form>
        @endif


    </div>
    <div class="text-center mt-4">
        <p class="text-secondary fs_22 fs_sm_18"> Already have an account?<a href="{{route('login')}}" class="text-primary"> Sign In.</a>
        </p>
    </div>
</section>
@endsection

@section('script')
<script>
function hideShowPassword(e,id){
    if($(e).hasClass('fa-eye-slash')){
      $(e).removeClass('fa-eye-slash');
      $(e).addClass('fa-eye');
      $(`#${id}`).attr('type','text')
    } else {
      $(e).removeClass('fa-eye');
      $(e).addClass('fa-eye-slash');
      $(`#${id}`).attr('type','password')
    }
}
</script>
@endsection