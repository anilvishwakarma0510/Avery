@extends('admin.layouts.app')
@section('content')
<div id="layoutSidenav_content" class="bg-dark">

    <main class="">
        <div class="container-fluid px-4">

            <h3 class="mt-3 text-white page-ttl pb-3 mb-4">Edit Conatct address</h3>

            <div class="row">
             
                <div class="col-sm-12 bg-light pt-4 pb-3 data-t">
                    <div class="error"></div>
                    <form method="post" onsubmit="return editBlog()" id="editBlog">
                        <input type="hidden" name="id" value="{{$data?->id}}">
                        @csrf
                       
                        <div class="form-group">
                            <label class="control-label">Contact Phone Number</label>
                            <input type="text" value="{{$data?->phone}}" name="phone" required class="form-control" >
                        </div>

                        <div class="form-group">
                            <label class="control-label">Contact Email</label>
                            <input type="email" value="{{$data?->email}}" name="email" required class="form-control" >
                        </div>

                     
                        <div class="form-group">
                            <label class="control-label">Conatact Address</label>
                            <textarea  required class="form-control" rows="5" name="address">{{$data?->address}}</textarea>
                        </div>

                        <br>

                        <button type="submit" class="btn btn-primary" id="addEmpJobsBtn">Edit</button>

                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
@section('script')

<script type="text/javascript">

 
    function editBlog() {
        event.preventDefault();
        var data = new FormData($('#editBlog')[0]);
        $.ajax({
            url: "{{route('admin.update-contact-address')}}",
            data: data,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {
                $('#addEmpJobsBtn').prop('disabled', true);
                $('#addEmpJobsBtn').text('Processing..');
                $('.error').html('');
            },
            success: function(result) {
                $('#addEmpJobsBtn').prop('disabled', false);
                $('#addEmpJobsBtn').text('Edit');
                if (result.status == 1) {
                    //console.log(result.message);
                    location.reload();
                } else {
                    //$('.error').html(result.message);
                    toastr["error"](result.message,"Error" )
                }
            },
            error:function(error){
                $('#addEmpJobsBtn').prop('disabled', false);
                $('#addEmpJobsBtn').text('Edit');

                console.log(error);
                let message = error?.responseJSON?.message;
                if(!message){
                    message = error?.message;
                }
                if(!message){
                    message = 'Something went wrong';
                }
                toastr['error'](message,"Error");
            }
        });
        return false;
    }
</script>
@endsection

@section('footer')
@include('admin.layouts.footer')
@endsection