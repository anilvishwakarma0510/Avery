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
      <h2 class="fw_8 text-secondar mb-3 mb-sm-2 px-md-5 p-0 fs_30 color-sec fs_sm_22">Create Account</h2>
      <p class=" text-secondar mb-3 mb-sm-2 px-md-5 p-0 fs_22 fs_sm_18">to continue live chat</p>
    </div>
    <form id="form-1" onsubmit="return submit_form_step1(); ">
      @csrf
      <div class="mb-2 mb-md-3">
        <input type="text" required name="name" class="mt-2 input_custom p-2 p-md-3  input_custom_sm fs_sm_15" placeholder="Full Name*">
      </div>
      <div class="mb-2 mb-md-3">
        <input type="email" required name="email" class="mt-2 input_custom p-2 p-md-3  input_custom_sm fs_sm_15" placeholder="Email*">
      </div>

      <div class="mb-2 mb-md-3">
        <select class="form-select mt-2 input_custom1 p-3 input_custom_sm  fs_sm_15" aria-label="Default select example" name="country" id="country">

          <option value="">Select Country</option>
          @foreach($countries as $country)
          <option value="{{$country->id}}" data-code="{{strtoupper($country->iso)}}">{{ucfirst($country->name)}}</option>
          @endforeach
        </select>
      </div>

      <div class="mb-2 mb-md-3">
        <select class="form-select mt-2 input_custom1 p-3 input_custom_sm  fs_sm_15" aria-label="Default select example" name="gender" required>
          <option value="">Gender</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <div class="mb-2 mb-md-3">
        <select class="form-select mt-2 input_custom1 p-3 input_custom_sm  fs_sm_15" aria-label="Default select example" name="age" required>
          <option value="">Age</option>
          @for($i=16; $i < 25; $i++)
          <option value="{{$i}}">{{$i}} Years</option>
          @endfor
        </select>
      </div>

      <div class="mb-2 mb-md-3 position-relative">
        <input type="password" required name="password" id="password" class="mt-2 input_custom p-2 p-md-3  input_custom_sm fs_sm_15" placeholder="Password*">
        <i onclick="hideShowPassword(this,'password')" class="fa-regular fa-eye-slash eyep"></i>
      </div>
      <div class="mb-2 mb-md-3 position-relative">
        <input type="password" name="confirm_password" id="confirm_password" class="mt-2 input_custom p-2 p-md-3  input_custom_sm fs_sm_15" placeholder="Confirm password*">
        <i onclick="hideShowPassword(this,'confirm_password')" class="fa-regular fa-eye-slash eyep"></i>
      </div>

      <div class="text-center mt-5 mb-4">
        <button class="fw_8 text-secondar mb-0 fs_sm_18  fs_25 position-relative backline1 related post backline3 border-0 bg-transparent submit-btn-1">
          <span>Sign Up</span>
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
  function hideShowPassword(e, id) {
    if ($(e).hasClass('fa-eye-slash')) {
      $(e).removeClass('fa-eye-slash');
      $(e).addClass('fa-eye');
      $(`#${id}`).attr('type', 'text')
    } else {
      $(e).removeClass('fa-eye');
      $(e).addClass('fa-eye-slash');
      $(`#${id}`).attr('type', 'password')
    }
  }

  function submit_form_step1() {
    let formData = new FormData($('#form-1')[0]);
    console.log(formData);
    $.ajax({
      type: 'POST',
      url: "{{url('sign-up')}}",
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
        $('.submit-btn-1').html('<span>Sign Up</span>');
        if (resp.status == 1) {

          console.log(resp);
          window.location.href = '{{url("chat-room")}}';
          //window.location.href = site_url+'proposals?post_id='+resp.job_id;
          //window.location.href = site_url + 'email-verify';

        } else {
          toastr['error'](resp.message, 'Error')
        }
      },
      error: function(error) {
        $('.submit-btn-1').prop('disabled', false);
        $('.submit-btn-1').html('<span>Sign Up</span>');
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

  $(function(){
    $.get("https://ipinfo.io", function(response) {
      console.log(response);
        if(response?.country){
          let selected = $('#country option').filter(function() {
              console.log($(this).attr('data-code'));
              return $(this).attr('data-code') == response?.country;
          }).prop('selected',true);
         
        }
    }, "jsonp");
  });
</script>
@endsection