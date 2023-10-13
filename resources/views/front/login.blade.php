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
      <h2 class="fw_8 text-secondar mb-3 mb-sm-2 px-md-5 p-0 fs_30 fs_sm_22 color-sec">Sign in</h2>
      <p class=" text-secondar mb-3 mb-sm-2 px-md-5 p-0 fs_22 fs_sm_18 ">to continue live chat</p>
    </div>
    <form id="form-1" method="POST" action="{{ route('login') }}">
    @csrf
      <div class="mb-2 mb-md-3">
        <input type="email" required name="email" class="mt-2 input_custom fs_sm_15 p-2 p-md-3 input_custom_sm" placeholder="Email*">
      </div>
      <div class="mb-2 mb-md-3 position-relative">
        <input type="password" id="password" required name="password" class="mt-2 input_custom p-2 p-md-3 fs_sm_15 input_custom_sm" placeholder="Password*">
        <i onclick="hideShowPassword(this,'password')" class="fa-regular fa-eye-slash eyep"></i>
      </div>
      <div class="text-center mt-5 mb-4">
        <button class="fw_8 text-secondar mb-0  fs_25 fs_sm_18 position-relative backline1 related post backline3 border-0 bg-transparent">
          <span>Sign In</span></button> 
      </div>
    </form>
    <div class="text-center">
      <a href="{{route('forgot-password')}}" class="btn text-primary btn-transparent fs_18 fs_sm_15 p-0"> Forgot Password? </a>
    </div>
    <div class="position-relative mt-4 mt-md-5 mb-4">
      <hr>
      <p class="sign_with">Or Sign in with</p>
    </div>
    <div class="d-flex align-items-center gap-2 social_icons social_icons_sm justify-content-center">
      <a onclick="alert('coming soon!'); return false;" href="#">
        <img src="{{asset('front/img/fb.png')}}">
      </a>
      <a onclick="alert('coming soon!'); return false;" href="#">
        <img src="{{asset('front/img/google.png')}}">
      </a>
      <a onclick="alert('coming soon!'); return false;" href="#">
        <img src="{{asset('front/img/twitter.png')}}">
      </a>
    </div>
  </div>
  <div class="text-center mt-4">
    <p class="text-secondary fs_22 fs_sm_18"> Don't have an account? <a href="{{route('registration')}}" class="text-primary"> Create an account.</a>
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