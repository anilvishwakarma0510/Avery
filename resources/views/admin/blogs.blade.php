<?php
use Illuminate\Support\Facades\Session;
?>
@extends('admin.layouts.app')

@section('content')
<div id="layoutSidenav_content" class="bg-dark">

  <main class="">
    <div class="container-fluid px-4">

      <h3 class="mt-3 text-white page-ttl pb-3 mb-4">Blogs</h3>
      <!--  <a href="">Add</a> -->
       <a href="{{route('admin.blog.add')}}" class="btn btn-primary btn-xs " >Add New</a> 
      <div class="row">
        @if( Session::has('message'))

        <?php echo Session::get('message') ?>


        @endif
        <div class="col-sm-12 bg-light pt-4 pb-3 data-t">
          <table id="table" class="display DataTable" style="width:100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Title</th>
                <th>Cateogry</th>
                <th>Status</th>
                <th>Is Latest</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($data) {
                $cnt = 0;
                foreach ($data as $key => $value) {
               
              ?>
                  <tr class="row1" data-id="{{ $value->id }}">
                    <td>{{$key+1}}</td>
                    <td>{{$value->title}}</td>
                    <td>{{$value->category_title}}</td>
                    <td>
                        @if($value->status==1)
                        <span class="badge bg-success">Active</span>
                        @else
                        <span class="badge bg-danger">In-active</span>
                        @endif
                    </td>
                    <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input" onchange="changeLatest(this,<?= $value->id ?>)" value="1" <?= ($value->is_latest==1) ? 'checked' : ''; ?> type="checkbox" id="flexSwitchCheckDefault{{ $value->id }}">
                        <label class="form-check-label" for="flexSwitchCheckDefault{{ $value->id }}"> Latest</label>
                      </div>
                    </td>
                    <td>
                    <a href="{{ route('admin.blog.edit').'?id='.$value->id }}" class="btn btn-sm btn-danger">Edit</a>
                      <a id="deleteButton<?php echo $value->id; ?>" href="javascript:;" onclick="return deleteCategory(<?php echo $value->id; ?>);" class="btn btn-sm btn-info">Delete</a>
                    </td>
                  </tr>
              <?php
                }
              }
              ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
</div>
@endsection
@section('script')

<script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">
$(function () {

  $( "#table" ).sortable({
    items: "tr",
    cursor: 'move',
    opacity: 0.6,
    update: function() {
        sendOrderToServer();
    }
  });

  
  function sendOrderToServer() {

    var order = [];
    $('tr.row1').each(function(index,element) {
      order.push({
        id: $(this).attr('data-id'),
        position: index+1
      });
    });

    $.ajax({
      type: "PUT", 
      dataType: "json", 
      url: "{{ route('admin.blog.order.update') }}",
      data: {
        orders:order,
        _token: '{{csrf_token()}}'
      },
      success: function(response) {
          if (response.status == 1) {
            toastr['success']("Blog order has been updated successfully.","Success")
          } else {
            toastr['error'](response.message,"Error")
          }
      },
      error:function(error){
        let error_message = error?.message;
        if(!error_message){
          error_message = error?.responseJSON?.message;
        }
        if(!error_message){
          error_message = 'Something went wrong, try again later!';
        }

        toastr['error'](error_message,"Error")
      }
    });

  }
});

function changeLatest(e,id){
    let is_latest;
    let message
    if($('#flexSwitchCheckDefault'+id).is(':checked')){
      is_latest = 1;
      message = "Blog marked as latest";
    } else {
      is_latest = 0;
      message = "Blog un marked as latest";
    }

    $.ajax({
      type: "PUT", 
      dataType: "json", 
      url: "{{ route('admin.blog.latest.update') }}",
      data: {
        is_latest:is_latest,
        id:id,
        _token: '{{csrf_token()}}'
      },
      success: function(response) {
          if (response.status == 1) {
            toastr['success'](message,"Success")
          } else {
            toastr['error'](response.message,"Error")
          }
      },
      error:function(error){
        let error_message = error?.message;
        if(!error_message){
          error_message = error?.responseJSON?.message;
        }
        if(!error_message){
          error_message = 'Something went wrong, try again later!';
        }

        toastr['error'](error_message,"Error")
      }
    });
  }

 
  function deleteCategory(id) {

    if(confirm('Are you sure you want to delete this blog?'))
 
    
    $.ajax({
      url: "{{route('admin.blog.delete')}}",
      data: {
        id:id,
        _token:'{{@csrf_token()}}'
      },
      type: 'DELETE',
      dataType: 'json',
      beforeSend: function() {
        $('#deleteButton'+id).prop('disabled', true);
        $('#deleteButton'+id).text('Processing..');
      },
      success: function(result) {
        
        if (result.status == 1) {
          //console.log(result.message);
          window.location.reload();
        } else {
          // $('#img_err').html(result.message);

          $('#deleteButton'+id).prop('disabled', false);
            $('#deleteButton'+id).text('Delete');

            toastr["error"]("Something went wrong","Error" )
         
        }
      }
    });
    return false;
  }

</script>
@endsection
