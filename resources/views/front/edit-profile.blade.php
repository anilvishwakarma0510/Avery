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
            <div class="mb-2 mb-md-3">
              <input type="text" required="" value="{{$user?->name}}" name="name" class="mt-2 input_custom p-2 p-md-3  input_custom_sm fs_sm_15" placeholder="Full Name*">
            </div>
            <div class="mb-2 mb-md-3">
              <input type="email" value="{{$user?->email}}" readonly class="mt-2 input_custom p-2 p-md-3  input_custom_sm fs_sm_15" placeholder="Email*">
            </div>

            <div class="mb-2 mb-md-3">
              <select class="form-select mt-2 input_custom1 p-3 input_custom_sm  fs_sm_15" aria-label="Default select example" name="country" id="country">

                <option value="">Select Country</option>
                @foreach($countries as $country)
                <option <?php echo ($country?->id==$user?->UserCountry?->id) ? 'selected' : '' ?>  value="{{$country->id}}" data-code="{{strtoupper($country->iso)}}">{{ucfirst($country->name)}}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-2 mb-md-3">
              <select class="form-select mt-2 input_custom1 p-3 input_custom_sm  fs_sm_15" aria-label="Default select example" name="gender" required>
                <option value="">Gender</option>
                <option <?php echo ($user?->gender=='Male') ? 'selected' : '' ?> value="Male">Male</option>
                <option <?php echo ($user?->gender=='Female') ? 'selected' : '' ?> value="Female">Female</option>
                <option <?php echo ($user?->gender=='Other') ? 'selected' : '' ?> value="Other">Other</option>
              </select>
            </div>

            <div class="mb-2 mb-md-3">
              <select class="form-select mt-2 input_custom1 p-3 input_custom_sm  fs_sm_15" aria-label="Default select example" name="age" required>
                <option value="">Age</option>
                @for($i=16; $i < 25; $i++)
                <option <?php echo ($user?->age==$i) ? 'selected' : '' ?> value="{{$i}}">{{$i}} Years</option>
                @endfor
              </select>
            </div>

            <div class="mb-2 mb-md-3">
              <input type="file" name="image" class="mt-2 input_custom p-2 p-md-3  input_custom_sm fs_sm_15">
            </div>

            @if($user?->image)
            <img src="{{asset($user?->image)}}" width="auto" height="150px">
            @endif



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
  function submit_form_step1() {
    let formData = new FormData($('#form-1')[0]);
    console.log(formData);
    $.ajax({
      type: 'POST',
      url: "{{url('update-profile')}}",
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