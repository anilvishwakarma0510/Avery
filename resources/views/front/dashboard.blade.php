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

      </div>
    </div>
  </div>


</section>
@endsection