@extends('admin.layouts.app')
@section('content')
<div id="layoutSidenav_content" class="bg-dark">
<style>
    label.control-label{
        text-transform: capitalize;
    }
</style>
    <main class="">
        <div class="container-fluid px-4">

            <h3 class="mt-3 text-white page-ttl pb-3 mb-4">Social Links</h3>

            <div class="row">
             
                <div class="col-sm-12 bg-light pt-4 pb-3 data-t">
                    <div class="error"></div>
                    <form method="post" onsubmit="return editBlog()" id="editBlog">
                        <input type="hidden" name="id" value="{{$data?->id}}">
                        @csrf
                       
                        <div class="form-group">
                            <label class="control-label">facebook</label>
                            <input type="url" value="{{$data?->facebook}}" name="facebook" required class="form-control" >
                        </div>
                        <div class="form-group">
                            <label class="control-label">instagram</label>
                            <input type="url" value="{{$data?->instagram}}" name="instagram" required class="form-control" >
                        </div>
                        <div class="form-group">
                            <label class="control-label">twitter</label>
                            <input type="url" value="{{$data?->twitter}}" name="twitter" required class="form-control" >
                        </div>
                        <div class="form-group">
                            <label class="control-label">linkedin</label>
                            <input type="url" value="{{$data?->linkedin}}" name="linkedin" required class="form-control" >
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
            url: "{{route('admin.social-link-update')}}",
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