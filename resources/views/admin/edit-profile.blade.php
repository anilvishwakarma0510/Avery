@extends('admin.layouts.app')

@section('content')
<div id="layoutSidenav_content" class="bg-dark">
    <main class="">
    
     
        <div class="container-fluid px-4">
            @if( Session::has('message')) 

      <div class="alert alert-success mt-3" role="alert">

        <?php echo Session::get('message') ?>

      </div>

      @endif
            <h3 class="mt-3 text-white page-ttl pb-3 mb-4">Edit Profile</h3>
            <div class="row">
                            <div class="col-xl-12">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                  <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Edit Profile</button>
                                  </li>
                                 <!--  <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Change Password</button>
                                  </li> -->
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                  <div class="tab-pane fade show active bg-dark p-4" id="home" role="tabpanel" aria-labelledby="home-tab">
                          <form id="update_form" method="post" onsubmit="return update_form()">
                                          @csrf
                                          <div class="row">
                                            <div class="col-lg-6">
                                              <div class="mb-3">
                                                <label for="firstnameInput" class="form-label">First Name</label>
                                                <input type="hidden" name="id"  value="<?= auth()->guard('admin')->user()->id; ?>">
                                                <input type="text" name="first_name" class="form-control" value="<?= auth()->guard('admin')->user()->first_name; ?>" required>
                                              </div>
                                            </div>
                                            <div class="col-lg-6">
                                              <div class="mb-3">
                                                <label for="firstnameInput" class="form-label">Last Name</label>
                                                <input type="text" name="last_name" class="form-control" value="<?= auth()->guard('admin')->user()->last_name; ?>" required>
                                              </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                              <div class="mb-3">
                                                <label for="emailInput" class="form-label">Email Address</label>
                                                <input type="email" name="email" class="form-control" placeholder="Email" value="<?= auth()->guard('admin')->user()->email; ?>" >
                                              </div>
                                            </div> 

                                            <div class="col-lg-6">
                                              <input type="file" name="image" class="form-control">
                                            </div>

                                              @if(auth()->guard('admin')->user()->image)
                                              <img src="{{asset(auth()->guard('admin')->user()->image)}}" width="auto" height="150px">
                                              @endif
                                                               

                                            <div class="col-lg-12">
                                              <div class="hstack gap-2 justify-content-end">
                                                <button type="submit" class="btn btn-primary" id="sub_btn">Updates</button>
                                              </div>
                                            </div>
                                                                <!--end col-->
                                          </div>
                                                            <!--end row-->
                                        </form>
                                  </div>
                                  
                                </div>
                            </div>
                        </div>
        </div>
    </main>
</div>

@endsection
@section('script')
<script type="text/javascript">
    function update_form() {
        $('.alert-danger').remove();
        $.ajax({
            url: "{{route('admin.update_profile')}}",
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            data: new FormData($('#update_form')[0]),
            dataType: 'json',
            beforeSend: function() {
                $('#sub_btn').prop('disabled', true);
                $('#sub_btn').text('Processing..');
            },
            success: function(res) {
                $('#sub_btn').prop('disabled', false);
                $('#sub_btn').text('Update');
                if (res.status == 1) {

                    window.location.reload();

                } else {

                    $('#result1').html(res.message);
                    for (var err in res.validation) {

                        $("[name='" + err + "']").after("<div  class='label alert-danger'>" + res.validation[err] + "</div>");
                    }
                }
            }
        });
        return false;
    }
  </script>
@endsection