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
            <h3 class="mt-3 text-white page-ttl pb-3 mb-4">Change password</h3>
            <div class="row">
                            <div class="col-xl-12">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                  <!-- <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Edit Profile</button>
                                  </li> -->
                                  <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Change Password</button>
                                  </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                  <div class="tab-pane fade show active bg-dark p-4" id="home" role="tabpanel" aria-labelledby="home-tab">
                              <form id="update_password" method="post" onsubmit="return update_password()">
                                  @csrf
                                  <div class="row g-2">
                                  <div class="col-lg-4">
                                    <div>
                                      <label for="oldpasswordInput" class="form-label">Old Password*</label>
                                      <input type="password" name="old_pass" class="form-control" placeholder="Enter current password">
                                    </div>
                                    <div id="result1"></div>
                                  </div>
                                  <!--end col-->
                                  <div class="col-lg-4">
                                    <div>
                                      <label for="newpasswordInput" class="form-label">New Password*</label>
                                      <input type="password" name="new_pass" class="form-control" placeholder="Enter new password">
                                    </div>
                                  </div>
                                  <!--end col-->
                                  <div class="col-lg-4">
                                    <div>
                                      <label for="confirmpasswordInput" class="form-label">Confirm New Password*</label>
                                      <input type="password" name="cnew_pass" class="form-control" placeholder="Confirm password">
                                    </div>
                                  </div>
                                  <!--end col-->
                                  <div class="col-lg-12">
                                    <div class="text-end hstack gap-2 justify-content-end">
                                  <br>
                                  <br>
                                      <button type="submit" class="btn btn-success" id="update">Change Password</button>
                                    </div>
                                  </div>
                                  <!--end col-->
                                </div>
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
  function update_password() {
  $('.alert-danger').remove();
  $.ajax({
    url: "{{route('admin.update_password')}}",
    type: 'POST',
    cache: false,
    contentType: false,
    processData: false,
    data: new FormData($('#update_password')[0]),
    dataType: 'json',
    beforeSend: function() {
      $('#update').prop('disabled', true);
      $('#update').text('Processing..');
    },
    success: function(res) {
      $('#update').prop('disabled', false);
      $('#update').text('Update');
      if (res.status == 1) {

        window.location.reload();
        // alert(res.session)

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
