@extends('front.layout.app')

@section('content')


<section class="latest mx-0 mt-5 mx-md-5">
	<div class="container-fluid">
		<div class="d-flex align-items-center justify-content-between">
		<h2 class="fw_6 fs_45 fs_sm_22 text-uppercase position-relative backline1 backline4 m-0">Search <i class="fa-solid fa-arrow-right"></i></h2> 
		<h4 class="m-0 fs_22 fs_sm_15">{{$data->total()}} Result Showing <?php echo (isset($_GET['keywords']) && !empty($_GET['keywords'])) ? 'for : '.$_GET['keywords'] : ''; ?></h4>
	</div>
	</div>
	<div class="row mt-3">
    @if(!blank($data))
		@foreach($data as $key => $value)
		<div class="col-12 col-md-4">
		<?php
				$blog_data['blog'] = $value;
				$blog_data['extra_class'] = 'd-md-none d-block';
				
				?>
				<x-blog-grid :data="$blog_data"></x-blog-grid>
		</div>
		@endforeach

        <div class="container-fluid container-xxl px-md-5">

            <div class="pagination text-center">
                {{ $data->links() }}
            </div>

        </div>

    @else

    <div class="alert alert-danger">Records not found</div>

    @endif



	</div>

    
</section>

<!-- <x-news-letter></x-news-letter> -->

@endsection

