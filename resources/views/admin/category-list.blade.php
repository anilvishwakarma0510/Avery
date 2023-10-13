<?php
use Illuminate\Support\Facades\Session;
?>
@extends('admin.layouts.app')

@section('content')
<div id="layoutSidenav_content" class="bg-dark">

  <main class="">
    <div class="container-fluid px-4">

      <h3 class="mt-3 text-white page-ttl pb-3 mb-4">Category</h3>
      <!--  <a href="">Add</a> -->
       <!-- <button class="btn btn-primary btn-xs createEventModal" data-bs-toggle="modal" data-bs-target="#createEventModal">Add New</button>  -->
      <div class="row">
        @if( Session::has('message'))

        <?php echo Session::get('message') ?>


        @endif
        <div class="col-sm-12 bg-light pt-4 pb-3 data-t">
          <table id="test" class="display" style="width:100%">
            <thead>
              <tr>
                <th>S.no. </th>
                <th>Name </th>
                <th>Image </th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($data) {
                $cnt = 0;
                foreach ($data as  $data_val) {
                  $cnt++;
              ?>
                  <tr>
                    <td>{{$cnt}}</td>
                    <td style="background-color: <?php echo $data_val->color ?>;">{{$data_val->title}}</td>
                    <td>
                      <img src="{{asset($data_val->icon)}}" width="auth" height="100px"> 
                    </td>
                    <td>
                      <!-- <a href="{{url('admin/edit-category?id='.$data_val->id)}}" class="btn btn-sm btn-danger">Edit</a> -->
                      <button class="btn btn-primary btn-sm editEventModal" data-bs-toggle="modal" data-bs-target="#editEventModal<?php echo $data_val->id; ?>">Edit</button>
                      <!-- <a id="deleteButton<?php echo $data_val->id; ?>" href="javascript:;" onclick="return deleteCategory(<?php echo $data_val->id; ?>);" class="btn btn-sm btn-info">Delete</a> -->
                    </td>
                  </tr>
                  <div id="editEventModal<?php echo $data_val->id; ?>" class="modal fade" aria-labelledby="myModalLabel1" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 id="myModalLabel1"> Edit</h4>
                          <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">x</button>
                        </div>
                        <div id="MessageErrAddEmp"></div>
                        <form method="post" onsubmit="return editCategory(<?php echo $data_val->id; ?>)" id="editCategory<?php echo $data_val->id; ?>">
                          @csrf
                          <div class="modal-body">

                            <div class="form-group">
                              <label class="control-label">Title</label>
                              <input type="hidden" name="id" value="{{$data_val->id}}">
                              <input type="text" class="form-control" name="title" value="{{$data_val->title}}" required />
                            </div>

                            <div class="form-group">
                              <label class="control-label">Background Color</label>
                              <input type="color" class="form-control" name="color" value="{{$data_val->color}}"  required />
                            </div>

                            <div class="form-group">
                              <label class="control-label">Image</label>
                              <br>
                              <input type="file" name="icon" />
                            </div>

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn" data-bs-dismiss="modal" aria-hidden="true">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="addEmpJobsBtn<?php echo $data_val->id; ?>">Save</button>

                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

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

<div id="createEventModal" class="modal fade" aria-labelledby="myModalLabel1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="myModalLabel1"> Add</h4>
        <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div id="MessageErrAddEmp"></div>
      <form method="post" onsubmit="return addCategory()" id="addCategory">
        @csrf
        <div class="modal-body">

          <div class="form-group">
            <label class="control-label">Name</label>
            <input type="text" class="form-control" name="title" required />
          </div>
          <div class="form-group">
            <label class="control-label">Background Color</label>
            <input type="color" class="form-control" name="color" required />
          </div>
          <div class="form-group">
              <label class="control-label">Image</label>
              <br>
              <input type="file" name="icon" required />
            </div>
          <!-- <div class="form-group">
            <label class="control-label">Description</label>
            <textarea class="form-control textarea" id="mytextarea" name="description"></textarea>
          </div> -->

        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-bs-dismiss="modal" aria-hidden="true">Cancel</button>
          <button type="submit" class="btn btn-primary" id="addEmpJobsBtn">Save</button>

        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
  function editCategory(id) {
 
    var data = new FormData($('#editCategory'+id)[0]);
    $.ajax({
      url: "{{route('admin.edit-category')}}",
      data: data,
      processData: false,
      contentType: false,
      type: 'POST',
      dataType: 'json',
      beforeSend: function() {
        $('#addEmpJobsBtn'+id).prop('disabled', true);
        $('#addEmpJobsBtn'+id).text('Processing..');
      },
      success: function(result) {
        $('#addEmpJobsBtn'+id).prop('disabled', false);
        $('#addEmpJobsBtn'+id).text('Add');
        if (result.status == 1) {
          //console.log(result.message);
          window.location.reload();
        } else {
          // $('#img_err').html(result.message);
          
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: result.message,
          })
        }
      }
    });
    return false;
  }
  function deleteCategory(id) {

    if(confirm('Are you sure you want to delete this category'))
 
    
    $.ajax({
      url: "{{route('admin.delete-category')}}",
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
          
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong',
          })
        }
      }
    });
    return false;
  }

  function addCategory() {
    event.preventDefault();
    var data = new FormData($('#addCategory')[0]);
    $.ajax({
      url: "{{route('admin.add-category')}}",
      data: data,
      processData: false,
      contentType: false,
      type: 'POST',
      dataType: 'json',
      beforeSend: function() {
        $('#addEmpJobsBtn').prop('disabled', true);
        $('#addEmpJobsBtn').text('Processing..');
      },
      success: function(result) {
        $('#addEmpJobsBtn').prop('disabled', false);
        $('#addEmpJobsBtn').text('Add');
        if (result.status == 1) {
          //console.log(result.message);
          window.location.reload();
        } else {
          // $('#img_err').html(result.message);
          
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: result.message,
          })
        }
      }
    });
    return false;
  }
</script>
@endsection