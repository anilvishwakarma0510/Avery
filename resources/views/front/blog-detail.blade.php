@extends('front.layout.app')
@section('meta')
<meta property="og:title" content="{{$blog?->title}}">
<meta property="og:image" content="<?php echo asset($blog?->thumbnail) ?>">
<meta property="og:url" content="{{ route('blog.detail', ['slug' => $blog->slug]) }}">
<meta property="og:type" content="Blogs">
@endsection
@section('content')
<section>

   <div class="container-fluid container-xxl p-0 px-md-5 pt-4 pt-md-0">
      <div class="row">
         <div class="col-md-4 px-3 px-md-4 o2 d-flex align-items-center align-items-md-start p-4 pb-0 p-md-0 flex-row flex-md-column o2_between">
            <div>
               <p class="px-2 py-1 m-0 mt-2 fs_24 fs_sm_18 custom_badge color-sec" style="background: <?php echo $blog?->blog_category->color; ?>;"> {{$blog?->blog_category->title}} </p>
               <p class="px-2 ps-0 ps-md-2 py-1 fw_6 mt-2 fs_40 fs_sm_22  color-sec"> {{$blog?->title}} </p>
            </div>
            <div class="d-flex align-items-end align-items-md-center aut   flex-column flex-md-row">
               <div class="images_aut">
                  <img src="{{ ($admin?->image) ? asset($admin?->image) : asset('front/img/girl1.png')}}" class="img-fluid" alt="">
               </div>
               <div class="ps-sm-4 aut_detail">
                  <p class="m-0 fs_20 fs_sm_15 color-sec text-start"> by {{$admin?->first_name}} {{$admin?->first_name}}</p>
                  <p class="m-0 fs_20  fs_sm_15 color-sec text-start"> {{date('F d, Y',strtotime($blog?->created_at))}} </p>
               </div>
            </div>
            <div class="mt-5 pt-5 d-none d-md-block">
               <p class="fs_18 color-sec fw_6"> Sharing is Caring</p>
               <div class="d-flex align-items-center gap-2 social_icons">

                  <!-- AddToAny BEGIN -->
                  <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                     <a class="a2a_button_facebook"></a>
                     <a class="a2a_button_twitter"></a>
                     <a class="a2a_button_linkedin"></a>
                     <a class="a2a_button_copy_link"></a>
                  </div>
                  <script async src="https://static.addtoany.com/menu/page.js"></script>
                  <!-- AddToAny END -->
               </div>
            </div>
         </div>
         <div class="col-md-8 o1">
            <img src="{{asset($blog?->thumbnail)}}" class="img-fluid w-100" alt="">
            <div class="color07 fs_20 fs_sm_18 d-none d-md-block mt-3 mt-md-4">
               <?php echo $blog?->sort_description ?>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="middle_section">
   <div class="container-fluid container-xxl px-md-5">
      <div class="color07 fs_20 mt-3 mt-md-5  fs_sm_18">
         <?php echo $blog?->description ?>
      </div>
      <?php
      $dayofweek = date('w', strtotime(date('Y-m-d')));
  
      $start_ofWeek = date('Y-m-d',strtotime(date('Y-m-d').' -'.$dayofweek.' days'));
      if(strtotime($blog->created_at) >= strtotime($start_ofWeek) || !$nextBlog){
      ?>
      <div class="d-flex justify-content-center mt-5 ">
         @if(auth()?->user())

            @if(auth()?->user()->age >= 18)

            

            <a href="<?php echo route('chat-room').'?category_id='.$blog->blog_category->id.'&blog_id='.$blog->id; ?>" class="btn btn-primary rounded-0 d-flex gap-1 px-3 py-2 align-items-center  justify-content-center  w-18">
               <img src="{{asset('front/img/msg_icon.png')}}" class="img-fluid" alt="">
               <span class="color-sec fs_20 fs_sm_15">Join LIVE Chat Now</span>
            </a>

            @else

            <a href="javascript:;" onclick="toastr['error']('You must be at least 18 years old to join the chat room.','Error')" class="btn btn-primary rounded-0 d-flex gap-1 px-3 py-2 align-items-center  justify-content-center  w-18">
               <img src="{{asset('front/img/msg_icon.png')}}" class="img-fluid" alt="">
               <span class="color-sec fs_20 fs_sm_15">Join LIVE Chat Now</span>
            </a>

            @endif

         @else

         <a href="<?php echo route('registration') ?>" class="btn btn-primary rounded-0 d-flex gap-1 px-3 py-2 align-items-center  justify-content-center  w-18">
            <img src="{{asset('front/img/msg_icon.png')}}" class="img-fluid" alt="">
            <span class="color-sec fs_20 fs_sm_15">Join LIVE Chat Now</span>
         </a>

         @endif
         
      </div>
      <?php } ?>
      <div class="d-flex justify-content-center mt-3 like">
         @if($blog->isLikeByUser())

         <button class="btn back_cream rounded-0 d-flex gap-2 px-4 py-2 align-items-center justify-content-around w-18" onclick="likePost(this,0)">
            <img src="{{asset('front/img/heart_red.png')}}" class="img-fluid" alt="">
            <span class="color-sec fs_20 fs_sm_15">Hit Unlike Button</span>
         </button>

         @else

         <button class="btn back_cream rounded-0 d-flex gap-2 px-4 py-2 align-items-center justify-content-around w-18" onclick="likePost(this,1)">
            <img src="{{asset('front/img/heart_black.png')}}" class="img-fluid" alt="">
            <span class="color-sec fs_20 fs_sm_15">Hit Like Button</span>
         </button>

         @endif
         
      </div>
      <nav aria-label="..." class="mt-5">
         <ul class="pagination align-items-center justify-content-center">
            @if(!blank($blogs))
            @foreach($blogs as $key => $b)
            <li class="page-item <?php echo ($b->slug==$blog->slug) ? 'active' : '' ?>"><a class="page-link fs_20" href="<?php echo ($b->slug==$blog->slug) ? 'javascript:;' : route('blog.detail', ['slug' => $b->slug]) ?>">{{$key+1}}</a></li>
            @endforeach
            @endif
            @if($nextBlog)
            <li class="page-item  next">
               <a class="page-link fs_20" href="{{ route('blog.detail', ['slug' => $nextBlog->slug]) }}"><span class="d-none d-md-block">Next</span> <img src="{{asset('front/img/arrow-down.png')}}" class="img-fluid" alt=""></a>
            </li>
            @endif
         </ul>
      </nav>
   </div>
</section>
<section class="mt-md-9">
   <div class="container-fluid container-xxl px-3 px-md-5 ">
      <div class="d-flex align-items-md-center flex-column-reverse flex-md-row justify-content-between mt-md-5 align-items-end tand post-comment-hide-parent">
         <div class="post-comment-hide">
            <h2 class="fs_sm_26 fw_6">Leave a Reply</h2>
            <p>Your email address will not be published. Required fields are marked *</p>
         </div>
         <div>
            <h2 onclick="hideShowComment()" class="fw_8 text-secondar mb-0  fs_22 fs_sm_13 position-relative backline1 related form backline3  post-comment-hide"><span>Hide Comments</span> <img src="{{asset('front/img/arrow-up.png')}}" class="img-fluid " alt=""></h2>
            <h2 style="display:none;" onclick="hideShowComment()" class="fw_8 text-secondar mb-0  fs_22 fs_sm_13 position-relative backline1 related form backline3  post-comment-hide"><span>Show Comments</span> <img src="{{asset('front/img/arrow-up.png')}}" class="img-fluid " alt=""></h2>
         </div>
      </div>
      <form id="blog-comment-form" class="post-comment-hide" onsubmit="return add_comment();">
         @csrf
         <input type="hidden" name="blog_id" required value="{{$blog?->id}}">
         <div class="col-md-7">
            <div class="mb-3">
               <input type="name" name="name" value="<?php echo auth()?->user()?->name; ?>" required class="mt-2 input_custom p-3" placeholder="Name*">
            </div>
            <div class="mb-3">
               <input type="email" name="email" required value="<?php echo auth()?->user()?->email; ?>"  class="mt-2 input_custom p-3" placeholder="Email*">
            </div>
            <div class="mb-3 mt-4">
               <label for="" class="form-label ps-3 fs_20">Comment*</label>
               <textarea type="text" class="form-control textarea_custom fs_20" id="formGroupExampleInput2" required name="comments" placeholder=""></textarea>
            </div>

            <div class="text-end text-md-center">
            </div>
         </div>

         <div class="col-md-12 text-center pt-md-5">
            <button type="submit" class="fw_8 text-secondar mb-0  fs_22 fs_sm_18 position-relative backline1 related post backline3 border-0 bg-transparent add-comment-button"><span class="pe-4 pe-md-0"> Post Comment</span> </button>
         </div>
      </form>
   </div>
</section>

<section class="mt-0 mt-md-5 pt-0 ps-2 ps-md-0 pt-md-0 post-comment-hide">
   <div class="container-fluid container-xxl px-3 px-md-5">
      <hr class="my-5 d-none d-md-block">
      <h2 class="fw_6 text-secondar mb-0 ps-0 ps-md-4  fs_22 fs_sm_18 my-4 my-md-5"><span>Read comment</span> </h2>
      <div class="comment-parent-main">
         
      </div>
      <hr class="my-5 d-none d-md-block">
   </div>

</section>
@if(!blank($related))
<section>
   <div class="container-fluid container-xxl px-md-5 px-3 p-0 mb-5 mb-sm-4 ">
      <h2 class="mt-5 fs_25 fs_sm_15 text-primary px-md-5 p-0">You might also like</h2>
      <h2 class="fw_8 text-secondar  fs_sm_18 mb-3 mb-sm-2 px-md-5 p-0 fs_30 position-relative backline1 related backline3 ">Related Articles</h2>
   </div>
   <div class="container-fluid container-xxl p-0 px-md-5">
      <div class="row mt-0 mt-sm-5 row_m_0">
         @foreach($related as $key => $value)
         <div class="col-12 col-sm-4  px-md-5 mb-3 mb-md-0">
            <?php
            $blog_data['blog'] = $value;
            $blog_data['extra_class'] = '';
            ?>
            <x-blog-grid :data="$blog_data"></x-blog-grid>
         </div>

         @endforeach
      </div>
   </div>
</section>



@endif
<x-news-letter></x-news-letter>


<!-- The Modal -->
<div class="modal fade" id="replyCommentModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Reply</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="blog-comment-reply-form" onsubmit="return reply_comment();">
      <!-- Modal body -->
      <div class="modal-body">
         @csrf
         <input type="hidden" name="blog_id" required value="{{$blog?->id}}">
         <input type="hidden" name="parent_id" id="parent_id" required value="">
         <div class="col-md-7">
            <div class="mb-3">
               <input type="name" name="name" value="<?php echo auth()?->user()?->name; ?>" required class="mt-2 input_custom p-3" placeholder="Name*">
            </div>
            <div class="mb-3">
               <input type="email" name="email" required value="<?php echo auth()?->user()?->email; ?>"  class="mt-2 input_custom p-3" placeholder="Email*">
            </div>
            <div class="mb-3 mt-4">
               <label for="" class="form-label ps-3 fs_20">Comment*</label>
               <textarea type="text" class="form-control textarea_custom fs_20" id="formGroupExampleInput2" required name="comments" placeholder=""></textarea>
            </div>

            <div class="text-end text-md-center">
            </div>
         </div>

         
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer">
         <div class="col-md-12 text-center pt-md-5">
            <button type="submit" class="fw_8 text-secondar mb-0  fs_22 fs_sm_18 position-relative backline1 related post backline3 border-0 bg-transparent add-comment-button"><span class="pe-4 pe-md-0"> Post Comment</span> </button>
         </div>
      </div>
   </form>

    </div>
  </div>
</div>
@endsection
@section('scripts')

<script>
   function replyToComment(parent_id){
      $('#replyCommentModal').modal('show');
      $('#parent_id').val(parent_id);
   }
   function hideShowComment(){
      $('.post-comment-hide').toggle();
      if($('.post-comment-hide-parent').hasClass('justify-content-between')){
         $('.post-comment-hide-parent').removeClass('justify-content-between');
         $('.post-comment-hide-parent').addClass('justify-content-end');
      } else {
         $('.post-comment-hide-parent').removeClass('justify-content-end');
         $('.post-comment-hide-parent').addClass('justify-content-between');
      }
      
   }
   function add_comment(){
      $.ajax({
         url:"{{route('add.blog.comment')}}",
         method:'POST',
         data:$('#blog-comment-form').serialize(),
         dataType:'json',
         beforeSend:function(){
            $('.add-comment-button').prop('disabled',true);
            $('.add-comment-button').html('<span class="pe-4 pe-md-0">Processing...</span>');
         },
         success:function(res){
            
            $('.add-comment-button').prop('disabled',false);
            $('.add-comment-button').html('<span class="pe-4 pe-md-0"> Post Comment</span>');
            if(res.status==1){
               $('#formGroupExampleInput2').val('')
               getBlogComment();
               toastr['success'](res.message,"Success")
            } else{
               toastr['error'](res.message,"Error")
            }
            
         },
         error:function(error){
            let message;
            if(error?.message){
               message = error.message
            }
            if(error?.responseJSON?.message){
               message = error?.responseJSON?.message
            }
            toastr['error'](message,"Error")
         }
      })
      return false;
   }
   function reply_comment(){
      let parent_id = $('#parent_id').val();
      $.ajax({
         url:"{{route('reply.blog.comment')}}",
         method:'POST',
         data:$('#blog-comment-reply-form').serialize(),
         dataType:'json',
         beforeSend:function(){
            $('.add-comment-button').prop('disabled',true);
            $('.add-comment-button').html('<span class="pe-4 pe-md-0">Processing...</span>');
         },
         success:function(res){
            
            $('.add-comment-button').prop('disabled',false);
            $('.add-comment-button').html('<span class="pe-4 pe-md-0"> Post Comment</span>');
            if(res.status==1){
               $('#replyCommentModal').modal('hide');
               $('#parent_id').val('');
               $('.comment-parent-'+parent_id).html(res.html);
               
               //getBlogComment();
               toastr['success'](res.message,"Success")
            } else{
               toastr['error'](res.message,"Error")
            }
            
         },
         error:function(error){
            let message;
            if(error?.message){
               message = error.message
            }
            if(error?.responseJSON?.message){
               message = error?.responseJSON?.message
            }
            toastr['error'](message,"Error")
         }
      })
      return false;
   }
   function likePost(e,status){
      $.ajax({
         url:"{{route('blog.like.action')}}",
         method:'POST',
         data:{
            _token:'{{@csrf_token()}}',
            blog_id:'{{$blog?->id}}',
            status:status
         },
         dataType:'json',
         beforeSend:function(){
            $(e).prop('disabled',true);
         },
         success:function(res){
            $(e).prop('disabled',false);
            if(status==1){
               $(e).html(`<img src="{{asset('front/img/heart_red.png')}}" class="img-fluid" alt=""><span class="color-sec fs_20 fs_sm_15">Hit Unlike Button</span>`);
               $(e).attr(`onclick`,'likePost(this,0)');
               toastr['success']('Liked successfully',"Success")
            } else{
               $(e).html(`<img src="{{asset('front/img/heart_black.png')}}" class="img-fluid" alt=""><span class="color-sec fs_20 fs_sm_15">Hit like Button</span>`);
               $(e).attr(`onclick`,'likePost(this,1)');
               toastr['success']('Unliked successfully',"Success")
            }
            
         },
         error:function(error){
            let message;
            if(error?.message){
               message = error.message
            }
            if(error?.responseJSON?.message){
               message = error?.responseJSON?.message
            }
            toastr['error'](message,"Error")
         }
      })
      return false;
   }

   function getBlogComment(){
      $.ajax({
         url:"{{route('get.blog.comment')}}",
         method:'GET',
         data:{
            blog_id:'{{$blog?->id}}'
         },
         success:function(res){
            
            if(res.status==1){
               $('.comment-parent-main').html(res.html)
               if(!res.html){
                  $('.comment-parent-main').html('<div class="p-0 pt-4 p-md-5 comment-parent-0></div>')
               }
               //toastr['success'](res.message,"Success")
            } else{
               toastr['error'](res.message,"Error")
            }
            
         },
         error:function(error){
            let message;
            if(error?.message){
               message = error.message
            }
            if(error?.responseJSON?.message){
               message = error?.responseJSON?.message
            }
            toastr['error'](message,"Error")
         }
      })
      return false;
   }

   getBlogComment();
   
</script>
@endsection