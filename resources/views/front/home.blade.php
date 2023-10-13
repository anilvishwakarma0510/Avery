@extends('front.layout.app')
@section('header-home')

<style>
.join_class1.position-absolute {
    top: 0;
    left: 0;
    opacity: 0;
    visibility: hidden;
    height: 100%;
    background: #00000059;
    width: 100%;
	display: flex;
    align-items: center;
    justify-content: center;
}
.join_class {
    z-index: +111;
}
.slider_box:hover .join_class1{
	opacity: 1;
	visibility: visible;
}
.join_class1 h3 {
    font-size: 20px;
    font-weight: 600;
    padding: 2px 6px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    width: 150px;
    text-align: center;
	color: #fff;
}
.join_class.join_class2 {
    position: absolute;
    bottom: 0;
    top: auto;
    left: 0;
    right: auto;
}
.join_class.join_class2 h3 {
    font-size: 13px;
    padding: 0px 10px;
    text-align: left;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    width: 130px;
}
.slider_box img {
    display: block;
    width: 100%;
    min-height: 165px;
	
}
.slider_box .join_class img {
	width: 20px !important;
    height: auto;
    min-height: 20px;
    object-fit: contain;
}
.playlist_image .join_class {
    right: 0;
    left: auto;
}
.playlist_image .join_class img {
    box-shadow: none;
}
</style>
<div class="container">

        <h1 class="my-3 my-md-5 fs_70 fw_8 fs_sm_22">MY PLAYLIST OF THE WEEK</h1>

    </div>	
<section class="section section_one">
	<div class="row m-0 align-items-end">
		<div class="col-12 col-md-7 p-0">
			<div class="playlist_image position-relative">
				<div class="join_class position-absolute d-block d-sm-none">
									<div class="d-flex align-items-center gap-1">
										<img src="{{ asset('front/img/msg_icon.png')}}">
										<p class="m-0">Join LIVE Chat Now</p>
									</div>
								</div>
				<img src="{{ asset('front/img/playlist-img.png')}}" class="w-100">
			</div>
		</div>
		@if(!blank($weekPlaylist))
		<div class="col-12 col-md-5 p-0">
			<div class="best_collection">
				<p class="fs_22 fw_5 mb-1">Avery's Best Collection for</p>
				<h3 class="fs_45 fw_8 position-relative backline1 fs_sm_30"><?php echo date('F Y'); ?></h3>
			</div>

			<div class="collection_slider_div">
				<p class="para_slide">This Playlist means a lot to me as this is the only one that is very close to my heart....!</p>

				<div class="collection_slider">
					@if(!blank($weekPlaylist))
					<div id="owl-demo" class="owl-carousel supplierslider">
						
						@foreach($weekPlaylist as $key => $value)
						<div class="item">
							<div class="slider_box position-relative">
								<img src="{{ asset($value->thumbnail)}}">
								<div class="join_class position-absolute">
									<div class="d-flex align-items-center gap-1">
										<img src="{{ asset('front/img/msg_icon.png')}}">
										<p class="m-0"><a  href="<?php echo (auth()?->user()) ? route('chat-room').'?category_id='.$value->blog_category->id.'&blog_id='.$value->id : route('registration') ?>">Join LIVE Chat Now</a></p>
									</div>
								</div>
								<div class="join_class1 position-absolute">
									<div class="d-flex align-items-center gap-1">
										<h3 class="m-0"><a href="{{ route('blog.detail', ['slug' => $value->slug]) }}">{{ $value->title}}</a></h3>
									</div>
								</div>
								<div class="join_class join_class2" style="background:<?php echo $value->blog_category->color ?>">
									<div class="d-flex align-items-center gap-1">
										<h3 class="m-0">{{ $value->blog_category->title}}</h3>
									</div>
								</div>
							</div>
						</div>
						@endforeach
						
					</div>
					@else
					<div class="alert alert-danger">We did not found and topic for this week</div>
					@endif
				</div>
			</div>
		</div>
		@endif
	</div>
</section>
@endsection
@section('content')

@if(!blank($category))
<section class="tranding_topics my-3 my-md-5 px-4" id="trending">
	<div class="container-fluid p-0 pt-4 pt-md-0">
		<h2 class="fw_6 fs_45 fs_sm_22 text-uppercase position-relative backline1 backline2">Trending Topics <i class="fa-solid fa-arrow-right"></i></h2>
	</div>
	<div class="px-0 px-md-5">
		<div id="owl-demo" class="owl-carousel trending_topics_slider mt-3 mt-md-5">
			@foreach($category as $key => $value)
			<div class="item">
			<a href="{{route('blog.search').'?category='.$value->id}}">
				<div class="topics position-relative">
					<h3 class="m-0">{{ $value->title}}</h3>
					<img src="{{ asset($value->icon)}}">
				</div>
				</a>
			</div>
			@endforeach
		</div>

	</div>
</section>

@endif

@if(!blank($latest))
<section class="latest latest_main">
	<div class="mx-0 mx-md-5">
		<div class="container-fluid p-0 px-4 px-md-0">
			<h2 class="fw_8 text-uppercase mt-5 latest_heading position-relative backline1 backline3">Latests</h2>
		</div>

		<div class="row">
			<div class="col-12 col-md-5">
				<a href="{{ route('blog.detail', ['slug' => $latest[0]->slug]) }}">
					<div class="topic_left">
						<div class="topic_left_position_sm">
							<p class="p-2 m-0 mt-3 custom_badge " style="background: <?php echo $latest[0]->blog_category->color; ?>;">
								{{$latest[0]->blog_category->title}}
							</p>
							<h3>{{$latest[0]->title}}</h3>
						</div>
						<div class="position-relative overlay_bx">
							<img src="{{ asset($latest[0]->thumbnail)}}" class="w-100">
							<div class="position-absolute overlay_back">
								<div class="d-flex align-items-center justify-content-between">
									<div class="d-flex align-items-center gap-3">
										<div class="d-flex align-items-center gap-1 like_comment_view">
											<img src="{{ asset('front/img/heart.png')}}">
											<p class="m-0">{{$latest[0]->getLikesCountAttribute()}}</p>
										</div>
										<div class="d-flex align-items-center gap-1 like_comment_view">
											<img src="{{ asset('front/img/comment.png')}}">
											<p class="m-0"></p>
										</div>
									</div>
									<div class="d-flex align-items-center gap-1 like_comment_view">
										<p class="m-0">{{$latest[0]->getBlogViews()}}</p>
										<img src="{{ asset('front/img/eye.png')}}">
									</div>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<?php
			$latest = $latest->forget(0);
			
			?>
			@if(!blank($latest))
			<div class="col-12 col-md-7">
				<div class="row mt-0 mt-md-5 row_m_0">

					@foreach($latest as $key => $value)
					<div class="col-12 col-md-6">
						<?php
						$blog_data['blog'] = $value;
						$blog_data['extra_class'] = '';
						?>
						<x-blog-grid :data="$blog_data"></x-blog-grid>
					</div>
					@endforeach
				
				</div>
			</div>
			@endif
		</div>
	</div>
</section>

@endif

<section class="extra extra_main">
	<div class="mx-0 mx-md-5">
		<div class="container-fluid p-0 px-4 px-md-0">
			<h2 class="fw_8 text-uppercase mt-5 latest_heading position-relative backline1 backline3">Extras</h2>
		</div>

		<div class="row">

			<div class="col-12 col-md-3">
				@foreach($extra as $key => $value)
				<?php
				$blog_data['blog'] = $value;
				$blog_data['extra_class'] = 'd-md-none d-block';
				
				?>
				<x-blog-grid :data="$blog_data"></x-blog-grid>
				
				<?php
				if($key==1){
					break;
				}
				?>
				@endforeach

			

			</div>

			<div class="col-12 col-md-6 p-0">
				<div class="topic_left">
					<div class="topic_left_position_sm">
						<div class="d-flex align-items-baseline justify-content-between flex-wrap flex-md-nowrap px-3 px-md-0" >
							<p class="p-2 m-0 mt-3 custom_badge color_light_orange">
								Funny Videos
							</p>
							<h3 class="text-start text-md-end" style="white-space: break-spaces;"><?php echo $extra_banner?->title; ?></h3>
						</div>
					</div>

					<div class="position-relative overlay_bx">
						<a target="_blank" href="{{ $extra_banner?->link }}"><img src="{{ asset($extra_banner?->image)}}" class="w-100"></a>
						<!-- <div class="position-absolute overlay_back ">
							<div class="d-flex align-items-center justify-content-between">
								<div class="d-flex align-items-center gap-3">
									<div class="d-flex align-items-center gap-1 like_comment_view">
										<img src="{{ asset('front/img/heart.png')}}">
										<p class="m-0">0</p>
									</div>
									<div class="d-flex align-items-center gap-1 like_comment_view">
										<img src="{{ asset('front/img/comment.png')}}">
										<p class="m-0">0</p>
									</div>
								</div>
								<div class="d-flex align-items-center gap-1 like_comment_view">
									<p class="m-0">0</p>
									<img src="{{ asset('front/img/eye.png')}}">
								</div>
							</div>
						</div> -->
					</div>
				</div>
			</div>

			<?php
			if(count($extra) > 2){
				$extra = $extra->forget(0);
				$extra = $extra->forget(1);
			}
			
			?>

			<div class="col-12 col-md-3">

				

			@foreach($extra as $key => $value)
			<?php
				$blog_data['blog'] = $value;
				$blog_data['extra_class'] = 'd-md-none d-block';
				
				?>
				<x-blog-grid :data="$blog_data"></x-blog-grid>
				<?php
				if($key==1){
					break;
				}
				?>
				@endforeach

			</div>
		</div>
		<section class="ad_section my-5">
			<div class="container-fluid">
				<a target="_blank" href="{{$home_banner?->link}}"><img src="{{ asset($home_banner?->image)}}" class="w-100"></a>
			</div>
		</section>
	</div>
</section>

<x-news-letter></x-news-letter>


@if(!blank($previous))
<section class="latest mx-0 mt-3 mx-md-5">
	<div class="container-fluid">
		<h2 class="fw_6 fs_45 fs_sm_22 text-uppercase position-relative backline1 backline4">Previously On Avery's Take <i class="fa-solid fa-arrow-right"></i></h2>
	</div>

	<div class="row mt-5">
		@foreach($previous as $key => $value)
		<div class="col-12 col-md-4">
		<?php
				$blog_data['blog'] = $value;
				$blog_data['extra_class'] = '';
				
				?>
				<x-blog-grid :data="$blog_data"></x-blog-grid>
		</div>
		@endforeach



	</div>
</section>
@endif
@endsection
@section('scripts')
<script>
	$(document).ready(function() {
	if ($(".supplierslider").length > 0) {
                $(".supplierslider").owlCarousel({
                    stagePadding: 50,
                    navigation: false,
                    nav: false,
                    loop: false,
                    margin: 20,
                    responsive: {
                        0: {
                            items: 1,
                            navigation: false,
                            nav: false,
                        },

                        577: {
                            items: 3,
                            navigation: false,
                            nav: false,
                        },

                        768: {
                            items: 1,
                            navigation: false,
                            nav: false,
                        },

                        1024: {
                            items: 2,
                            navigation: false,
                            nav: false,
                        }
                    }
                });
            }

			


            if ($(".trending_topics_slider").length > 0) {
                $(".trending_topics_slider").owlCarousel({
                    navigation: false,
                    nav: true,
                    loop: true,
                    margin: 20,
                    dots: false,
                    navText: ["<i class='fa-solid fa-chevron-left'></i>", "<i class='fa-solid fa-chevron-right'></i>"],
                    responsive: {
                        0: {
                            items: 2,
                            nav: true,
                            dots: false,
                        },
                        578: {
                            items: 3,
                            nav: true,
                            dots: false,
                        },
                        768: {
                            items: 3,
                            nav: false,
                            dots: false,
                        },
                        992: {
                            items: 5,
                            nav: true,
                            dots: false,
                        }
                    }
                });
            }
        });
</script>
@endsection

