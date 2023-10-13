<?php
use Illuminate\Support\Facades\Session;
?>
@extends('admin.layouts.app')

@section('content')
<div id="layoutSidenav_content" class="bg-dark">

  <main class="">
    <div class="container-fluid px-4">

      <h3 class="mt-3 text-white page-ttl pb-3 mb-4">Contact List</h3>
      <!--  <a href="">Add</a> -->
       <!-- <a href="{{route('admin.blog.add')}}" class="btn btn-primary btn-xs " >Add New</a>  -->
      <div class="row">
       
        <div class="col-sm-12 bg-light pt-4 pb-3 data-t">
          <table id="test" class="display" style="width:100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($lists) {
                foreach ($lists as $key => $value) {
               
              ?>
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->name}}</td>
                    <td>
                        <a href="mailto:{{$value->email}}" target="_blank">{{$value->email}}</a>
                    </td>
                    <td>
                        <?php echo $value->message; ?>
                    </td>
                    <td>
                    <a href="mailto:{{$value->email}}" target="_blank" class="btn btn-sm btn-success btn-sm">Reply</a>
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
