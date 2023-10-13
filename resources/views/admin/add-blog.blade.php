<?php
use Illuminate\Support\Facades\Session;
?>
@extends('admin.layouts.app')

@section('title', 'Add blog')

@section('content')
<div id="layoutSidenav_content" class="bg-dark">

    <main class="">
        <div class="container-fluid px-4">

            <h3 class="mt-3 text-white page-ttl pb-3 mb-4">Add Blog</h3>

            <div class="row">
                @if( Session::has('message'))
                <?php echo Session::get('message') ?>
                @endif

                <div class="col-sm-12 bg-light pt-4 pb-3 data-t">
                    <div class="error"></div>
                    <form method="post" onsubmit="return addBlog()" id="addBlog">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">Category</label>
                            <select class="form-control select2" required name="category">
                              
                                @foreach($category as $key => $cate)
                                <option  value="{{$cate->id}}">{{$cate->title}}</option>
                                @endforeach
                            </select>
                            
                        </div>
                        <br>

                        <div class="form-group">
                            <label class="control-label">Sub Category (Optional)</label>
                            <input type="text" class="form-control"  name="sub_category">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Status</label>
                            <select class="form-control " required name="status">
                                <option value="1">Active</option>
                                <option value="0">In-Active</option>
                            </select>
                            
                        </div>
                        <div class="form-group">
                            <label class="control-label">Title</label>
                            <input type="text" required class="form-control"  name="title">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Thumbnail</label>
                            <br>
                            <input type="file" accept="image/*" required name="thumbnail">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Media Type</label>
                            <select class="form-control" onchange="checkMedia(this)" name="media_type"  id="media_type">
                                <option value="">Select Media (Option)</option>
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                                <option value="audio">Audio</option>
                            </select>
                            
                        </div>
                        <div class="form-group">
                            <label class="control-label">Media File (Option)</label>
                            <br>
                            <input type="file"  id="media_file" accept="image/*" name="media_file">
                        </div>

                        

                        <div class="form-group">
                            <label class="control-label">Short Description</label>
                            <textarea  required class="form-control " rows="10" name="sort_description"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Long Description</label>
                            <textarea   class="form-control textarea" name="description"></textarea>
                        </div>

                        
                        <br>

                        <button type="submit" class="btn btn-primary" id="addEmpJobsBtn">Add</button>

                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
@section('script')

<script type="text/javascript">

    function checkMedia(e){
        if(e.value=='image'){
            $('#media_file').attr('required','required')
            $('#media_file').attr('accept','image/*')
        } else if(e.value=='video'){
            $('#media_file').attr('required','required')
            $('#media_file').attr('accept','video/*')
        } else if(e.value=='audio'){
            $('#media_file').attr('required','required')
            $('#media_file').attr('accept','audio/*')
        } else {
            $('#media_file').removeAttr('required')
        }
    }
    function addBlog() {
        event.preventDefault();
        var data = new FormData($('#addBlog')[0]);
        $.ajax({
            url: "{{route('admin.blog.add.post')}}",
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
                $('#addEmpJobsBtn').text('Add');
                if (result.status == 1) {
                    //console.log(result.message);
                    window.location.href = "{{route('admin.blogs')}}";
                } else {
                    //$('.error').html(result.message);
                    toastr["error"](result.message,"Error" )
                }
            }
        });
        return false;
    }

</script>
@endsection

@section('footer')
@include('admin.layouts.footer')
@endsection