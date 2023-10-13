@extends('front.layout.app')

@section('content')
<style>
  .post.backline3:before {
    right: -22px;
  }

  .nav-pills .nav-link.active,
  .nav-pills .show>.nav-link {
    color: #000;
    background-color: #edf125;
  }
</style>
<div class="gray-back"></div>
<section class="form_top_m position-relative">


  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <x-sidebar></x-sidebar>
      </div>
      <div class="col-md-9">
        <div class="p-3 w-75 mx-auto wm-100">
          <form id="form-1" onsubmit="return submit_form_step1(); ">
            @csrf
            <div class="mb-2 mb-md-3 position-relative">
                <input type="password" required name="old_password" id="old_password" class="mt-2 input_custom p-2 p-md-3  input_custom_sm fs_sm_15" placeholder="Current Password*">
                <i onclick="hideShowPassword(this,'old_password')" class="fa-regular fa-eye-slash eyep"></i>
            </div>
            <div class="mb-2 mb-md-3 position-relative">
                <input type="password" required name="password" id="password" class="mt-2 input_custom p-2 p-md-3  input_custom_sm fs_sm_15" placeholder="Old Password*">
                <i onclick="hideShowPassword(this,'password')" class="fa-regular fa-eye-slash eyep"></i>
            </div>
            <div class="mb-2 mb-md-3 position-relative">
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-2 input_custom p-2 p-md-3  input_custom_sm fs_sm_15" placeholder="Confirm password*">
                <i onclick="hideShowPassword(this,'password_confirmation')" class="fa-regular fa-eye-slash eyep"></i>
            </div>

            
            <div class="text-center mt-5 mb-4">
              <button class="fw_8 text-secondar mb-0 fs_sm_18  fs_25 position-relative backline1 related post backline3 border-0 bg-transparent submit-btn-1">
                <span>Update</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
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
  function submit_form_step1() {
    let formData = new FormData($('#form-1')[0]);
    console.log(formData);
    $.ajax({
      type: 'POST',
      url: "{{url('update-password')}}",
      data: formData,
      dataType: 'JSON',
      processData: false,
      contentType: false,
      cache: false,
      beforeSend: function() {
        $('.submit-btn-1').prop('disabled', true);
        $('.submit-btn-1').html('<div class="spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div>');
        $('.error').html('');
      },
      success: function(resp) {
        $('.submit-btn-1').prop('disabled', false);
        $('.submit-btn-1').html('<span>Update</span>');
        if (resp.status == 1) {

          location.reload();
        } else {
          toastr['error'](resp.message, 'Error')
        }
      },
      error: function(error) {
        $('.submit-btn-1').prop('disabled', false);
        $('.submit-btn-1').html('<span>Update</span>');
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