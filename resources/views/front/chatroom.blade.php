@extends('front.layout.app')
@section('content')
<style>
	.myLoader {
		color: #0dcaf0 !important;
		top: 28%;
		position: absolute;
		left: 39%;
		width: 150px;
		height: 150px;
	}

	.personal_chat_list {
		height: 300px;
		overflow: auto;
	}

	.tox-tinymce {
		width: 100% !important;
		height: 55px !important;
	}

	.single_chat .chat-form {
		width: 95% !important;

	}

	.input-group {
		padding: 2px;

	}

	.tox.tox-tinymce.tox-tinymce--toolbar-bottom {
		border: 0;

	}
</style>
<link href="{{asset('uploads/emoji/css/emoji.css')}}" rel="stylesheet">
<div class="main_chat_div container-xxl p-0 ">
	<div class="row m-0">
		<div class="col-12 col-md-12 col-md-4 col-lg-3 p-0 order-md-1 order-2" id="name_list">
			<div class="chat_left">

				<div class="tab_list pb-3 border-bottom mb-0 mb-md-3 mx-0 mx-md-4">
					<ul class="d-flex gap-5 mx-3 mb-0 mb-md-3">
						<li>
							<a class="online active" onclick="openPublicChat()">
								<div class="text-center">
									<img src="{{asset('front/img/user_online.png')}}" style="height: 20px;" class="mb-2">
									<p class="mb-0 fs_15 text-dark">Online</p>
								</div>
							</a>
						</li>
						<li>
							<a class="topic">
								<div class="text-center">
									<img src="{{asset('front/img/stop_circle.png')}}" style="height: 20px;" class="mb-2">
									<p class="mb-0 fs_15 text-dark">Topics</p>
								</div>
							</a>
						</li>
					</ul>
				</div>

				<p class="text-dark fs_18 text-center d-none d-md-block">ONLINE <span class="OnlineUser"><?php echo count($onlineUsers) ?></span></p>

				<div class="chat_list">
					@if(!blank($onlineUsers))
					@foreach($onlineUsers as $key => $onlineUser)
					<x-chat-user-list :user="$onlineUser"></x-chat-user-list>
					@endforeach
					@else
					<p class="alert alert-danger">No one is online right now</p>
					@endif
				</div>


				<div class="topic_list d-none categorylisthtml">
					<?php
					$first_Category = '';
					$first_Blog = '';
					?>
					@if(!blank($latestBlogs))
					@foreach($latestBlogs as $key => $cat)

					<?php
					$blog_id = ($cat->blog_id) ? $cat->blog_id : 0;
					if ($key == 0) {
						$first_Category = $cat->id;
						$first_Blog = $blog_id;
					}
					?>
					<div onclick="open_blog_chatroom(<?php echo $blog_id; ?>,<?php echo $cat->id; ?>);" class="card-body topic_bx-all topic_bx-single-<?php echo $cat->id; ?> <?= ($key == 0) ? 'active' : ''; ?> <?= ($cat?->unread > 0) ? 'is_unread' : '' ?>" style="background: <?php echo $cat->color; ?>;">
						<div class="d-flex align-items-center gap-3">

							<div class="col">
								<div class="d-flex align-items-center">
									<h5 class="me-auto mb-0 fs_18">{{$cat->title}}</h5>
								</div>
							</div>
							<div class="badge badge-circle bg-white text-dark">
								<span class="">{{$cat->unread}}</span>
							</div>
						</div>
					</div>

					@endforeach
					@endif

				</div>
			</div>

		</div>

		<div class="col-12 col-md-12 col-md-8 col-lg-9 p-0 order-md-2 order-1">



			<div class="single_chat chat_right p-3">
				<x-public-chat></x-public-chat>
			</div>


			<!-- <div class="one_person_comment chat_right p-3 d-none">
				<x-single-person-chat></x-single-person-chat>
			</div> -->



			<div class="suggested_topics p-3 p-md-5 bg-white dis-none">
				<div class="">
					<h3 class="fs_30 text-color-707070 fw_6">Suggested Topics</h3>
					<div class="d-flex align-items-center gap-2 gap-md-3 mt-3 flex-wrap">
						@if(!blank($latestBlogs))
						@foreach($latestBlogs as $key => $cat)
						<?php
						$blog_id = ($cat->blog_id) ? $cat->blog_id : 0;
						?>
						<a href="javascript:;" onclick="open_blog_chatroom(<?php echo $blog_id; ?>,<?php echo $cat->id; ?>);" class="topic_bx topic_bx-all topic_bx-single-<?php echo $cat->id; ?> text-dark" style="background: <?php echo $cat->color; ?>;">{{$cat->title}}</a>
						@endforeach
						@endif
					</div>
				</div>
			</div>

		</div>

		<div class="col-12 col-md-12 col-md-8 col-lg-9 p-0 d-block d-md-none order-3">
			<div class="suggested_topics p-3 p-md-5 bg-white">
				<div class="">
					<h3 class="fs_30 text-color-707070 fw_6">Suggested Topics</h3>
					<div class="d-flex align-items-center gap-2 gap-md-3 mt-3 flex-wrap">
						@if(!blank($latestBlogs))
						@foreach($latestBlogs as $key => $cat)

						<?php
						$blog_id = ($cat->blog_id) ? $cat->blog_id : 0;
						?>
						<a href="javascript:;" onclick="open_blog_chatroom(<?php echo $blog_id; ?>,<?php echo $cat->id; ?>);" class="topic_bx topic_bx-all topic_bx-single-<?php echo $cat->id; ?> text-dark" style="background: <?php echo $cat->color; ?>;">{{$cat->title}}</a>
						@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Share</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="share-modal-body">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

@endsection
@section('script')
<script src="https://cdn.tiny.cloud/1/hyi4mzz0mpceuh63zoylk0a0v1a1dkvgpo08fcmrpkkw7oqr/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script async src="https://static.addtoany.com/menu/page.js"></script>
<script type="text/javascript">
	let chat_interval;
	let receiver;
	let category_id = <?php echo $first_Category; ?>;
	let blog_id = <?php echo $first_Blog; ?>;
	let chat_type = 0;
	let last_chat_id = <?php echo $last_chat_id ?>;
	let active_user_id;

	function shareModel(url,icon) {
		$('#shareModal').modal('show');
		let html = `<div class="d-flex align-items-center gap-2 social_icons">

			<!-- AddToAny BEGIN -->
			<div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-icon="${icon}" data-a2a-url="${url}">
			<a class="a2a_button_facebook"></a>
			<a class="a2a_button_twitter"></a>
			<a class="a2a_button_linkedin"></a>
		
			</div>
			<!-- AddToAny END -->
			</div>`;

		$('#share-modal-body').html(html);

		

		a2a.init('page');
	}

	function OpenOneToOneChat(e, id) {
		clearInterval(chat_interval);
		blog_id = <?php echo $first_Blog; ?>;
		category_id = <?php echo $first_Category; ?>;
		receiver = id;
		active_user_id = id;
		$('.single_chat').html('<div class="myLoader spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div>');
		chat_type = 1

		getUserOneToOne();
		GetUserList();
	}

	function openPublicChat() {
		clearInterval(chat_interval);
		receiver = undefined;
		active_user_id = undefined;
		chat_type = 0;
		blog_id = <?php echo $first_Blog; ?>;
		category_id = <?php echo $first_Category; ?>;

		$('.single_chat').html('<div class="myLoader spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div>');
		getUserOneToOne();
		GetUserList();
	}

	function open_blog_chatroom(blog_id1, category_id1) {

		$('.topic_bx-all').removeClass('active');
		$('.topic_bx-single-' + category_id1).addClass('active');
		clearInterval(chat_interval);


		receiver = undefined;
		active_user_id = undefined;


		chat_type = 2;


		blog_id = blog_id1;
		category_id = category_id1;

		$('.single_chat').html('<div class="myLoader spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div>');

		if (!blog_id) {
			$('.single_chat').html('<div class="alert alert-danger">Opps! Sorry In this week ,no topic has been posted for this category.</div>');
			return false;
		}

		getUserOneToOne();

		// $(".topic_list").addClass("d-none");
		// $(".chat_list").removeClass("d-none");
		// $(".topic").removeClass("active");
		// $(".online").addClass("active");

		//GetUserList();
	}

	function showBlogList2(category_id) {
		$(".topic_list").removeClass("d-none");
		$(".chat_list").addClass("d-none");
		$(".topic").addClass("active");
		$(".online").removeClass("active");
		chat_type = 2;
		clearInterval(chat_interval);
		showBlogList(category_id);
		//open_blog_chatroom(blog_id,category_id);
	}

	function showBlogList(category_id) {
		clearInterval(chat_interval);
		receiver = undefined;
		active_user_id = undefined;
		chat_type = 2;
		category_id = category_id;

		if (!category_id) {
			toastr['error']('Something went wrong, try again later', 'Error')
			return false;
		}

		$('.single_chat').html('<div class="myLoader spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div>');



		$.ajax({
			type: 'GET',
			url: "{{route('get-chatroom-blog-list')}}",
			data: {
				category_id: category_id,
			},
			dataType: 'JSON',
			beforeSend: function() {
				$('.single_chat').html('<div class="myLoader spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div>');
			},
			success: function(resp) {
				$('.single_chat').html('');

				if (resp.status == 1) {
					$('.single_chat').html(resp.html);
					last_chat_id = 0;
				} else {
					toastr['error'](resp.message, 'Error')
				}
			},
			error: function(error) {
				$('.single_chat').html('');
				let message;
				if (error?.responseJSON?.message) {
					message = error?.responseJSON?.message;
				} else if (error?.message) {
					message = error?.message;
				} else {
					message = 'Something went wrong, try again later'
				}

				toastr['error'](message, 'Error')
			}
		});
		return false;
	}

	function sendMessage() {
		let formData = new FormData($('#sendMessage')[0]);

		if (chat_type != 1 && chat_type != 2 && chat_type != 0) {
			toastr['error']('Something went wrong, try again later', 'Error')
			return false;
		}

		if (chat_type == 1 && !receiver) {
			toastr['error']('Something went wrong, try again later', 'Error')
			return false;
		}
		if (receiver) {
			formData.append('receiver', receiver)
		}

		if (category_id) {
			formData.append('category_id', category_id)
		}

		if (blog_id) {
			formData.append('blog_id', blog_id)
		}

		formData.append('chat_type', chat_type)

		clearInterval(chat_interval);

		$.ajax({
			type: 'POST',
			url: "{{url('send-message')}}",
			data: formData,
			dataType: 'JSON',
			processData: false,
			contentType: false,
			cache: false,
			beforeSend: function() {
				$('.submit-btn-1').prop('disabled', true);
				$('.submit-btn-1').html('<div class="spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div>');
				$('.error').html('');
			},
			success: function(resp) {
				$('.submit-btn-1').prop('disabled', false);
				$('.submit-btn-1').html('<i class="fa-solid fa-paper-plane text-primary"></i>');
				if (resp.status == 1) {
					last_chat_id = resp.last_chat_id
					startChat();
					$('.emoji-wysiwyg-editor').html('');
					$('#sendMessage')[0].reset();
					$('.personal_chat_list').append(resp.html);
					$('.personal_chat_list').scrollTop($('.personal_chat_list').prop('scrollHeight'));;
				} else {
					toastr['error'](resp.message, 'Error')
				}
			},
			error: function(error) {
				$('.submit-btn-1').prop('disabled', false);
				$('.submit-btn-1').html('<i class="fa-solid fa-paper-plane text-primary"></i>');
				let message;
				if (error?.responseJSON?.message) {
					message = error?.responseJSON?.message;
				} else if (error?.message) {
					message = error?.message;
				} else {
					message = 'Something went wrong, try again later'
				}

				toastr['error'](message, 'Error')
			}
		});
		return false;
	}

	function getUserOneToOne() {
		console.log('getUserOneToOne:chat_type' + chat_type);
		console.log('getUserOneToOne:receiver' + receiver);
		console.log('getUserOneToOne:category_id' + category_id);
		console.log('getUserOneToOne:blog_id' + blog_id);
		if ((chat_type == 1 && !receiver) || (chat_type == 2 && (!category_id || !blog_id))) {
			toastr['error']('Something went wrong, try again later', 'Error')
			return false;
		}

		last_chat_id = 0;

		$.ajax({
			type: 'GET',
			url: "{{route('get-personal-chat')}}",
			data: {
				receiver: receiver,
				chat_type: chat_type,
				category_id: category_id,
				blog_id: blog_id,
				//_token:'{{@csrf_token()}}'
			},
			dataType: 'JSON',
			beforeSend: function() {
				$('.single_chat').html('<div class="myLoader spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div>');
			},
			success: function(resp) {
				$('.single_chat').html('');

				if (resp.status == 1) {
					$('.single_chat').html(resp.html);
					last_chat_id = resp.last_chat_id;
					$('.personal_chat_list').scrollTop($('.personal_chat_list').prop('scrollHeight'));;
					startChat();
					setEmoji();
				} else {
					toastr['error'](resp.message, 'Error')
				}
			},
			error: function(error) {
				$('.submit-btn-1').prop('disabled', false);
				$('.submit-btn-1').html('<span>Update</span>');
				let message;
				if (error?.responseJSON?.message) {
					message = error?.responseJSON?.message;
				} else if (error?.message) {
					message = error?.message;
				} else {
					message = 'Something went wrong, try again later'
				}

				toastr['error'](message, 'Error')
			}
		});
		return false;
	}


	function startChat() {
		getChatMessage();
		chat_interval = setInterval(function() {
			getChatMessage();
		}, 5000);
	}

	function getChatMessage() {

		console.log('getChatMessage:chat_type' + chat_type);
		console.log('getChatMessage:receiver' + receiver);
		console.log('getChatMessage:category_id' + category_id);
		console.log('getChatMessage:blog_id' + blog_id);

		if (chat_type == 0 || (chat_type == 1 && receiver) || (chat_type == 2 && category_id && blog_id)) {

			$.ajax({
				type: 'GET',
				url: "{{route('get-chat-message')}}",
				data: {
					receiver: receiver,
					chat_type: chat_type,
					last_chat_id: last_chat_id,
					category_id: category_id,
					blog_id: blog_id,
					//_token:'{{@csrf_token()}}'
				},
				dataType: 'JSON',
				success: function(resp) {
					if (resp.status == 1 && resp.html) {
						last_chat_id = resp.last_chat_id
						$('.personal_chat_list').append(resp.html);
						$('.personal_chat_list').scrollTop($('.personal_chat_list').prop('scrollHeight'));;
					}
				},
				error: function(error) {
					$('.submit-btn-1').prop('disabled', false);
					$('.submit-btn-1').html('<span>Update</span>');
					let message;
					if (error?.responseJSON?.message) {
						message = error?.responseJSON?.message;
					} else if (error?.message) {
						message = error?.message;
					} else {
						message = 'Something went wrong, try again later'
					}

					toastr['error'](message, 'Error')
				}
			});
		}
		return false;
	}

	function GetUserList() {
		let data = {
			active_user_id: active_user_id
		};
		if (chat_type == 2) {
			data.blog_id = blog_id;
			data.category_id = category_id;
		}

		$.ajax({
			type: 'GET',
			url: "{{route('get-chat-users')}}",
			dataType: 'JSON',
			data: data,
			success: function(resp) {
				if (resp.status == 1) {
					$('.chat_list').html(resp.users);
					$('.OnlineUser').html(resp.count);
					$('.categorylisthtml').html(resp.category);
				}
			},
			error: function(error) {
				let message;
				if (error?.responseJSON?.message) {
					message = error?.responseJSON?.message;
				} else if (error?.message) {
					message = error?.message;
				} else {
					message = 'Something went wrong, try again later'
				}

				toastr['error'](message, 'Error')
			}
		});

		return false;
	}

	function markAsHelpFul(e, status, chat_room_id) {
		$.ajax({
			url: "{{route('chatroom.helpful.action')}}",
			method: 'POST',
			data: {
				_token: '{{@csrf_token()}}',
				chat_room_id: chat_room_id,
				status: status
			},
			dataType: 'json',
			beforeSend: function() {
				$(e).prop('disabled', true);
			},
			success: function(res) {
				$(e).prop('disabled', false);
				if (status == 1) {
					$(e).attr(`onclick`, 'markAsHelpFul(this,0,' + chat_room_id + ')');
					$(e).removeClass(`text-dark`);
					$(e).addClass(`text-warning`);
					toastr['success']('Marked as helpful', "Success")
				} else {
					$(e).attr(`onclick`, 'markAsHelpFul(this,1,' + chat_room_id + ')');
					$(e).addClass(`text-dark`);
					$(e).removeClass(`text-warning`);
					toastr['success']('Un marked as helpful', "Success")
				}

			},
			error: function(error) {
				let message;
				if (error?.message) {
					message = error.message
				}
				if (error?.responseJSON?.message) {
					message = error?.responseJSON?.message
				}
				toastr['error'](message, "Error")
			}
		})
		return false;
	}

	$(document).ready(function() {

		startChat();
		setInterval(function() {
			GetUserList();
		}, 10000)
		$(".online").click(function() {
			$(".topic_list").addClass("d-none");
			$(".chat_list").removeClass("d-none");
			$(".online").addClass("active");
			$(".topic").removeClass("active");
			$(".chat_list_card").removeClass("active");
		});

		$(".topic").click(function() {
			$(".topic_list").removeClass("d-none");
			$(".chat_list").addClass("d-none");
			$(".topic").addClass("active");
			$(".online").removeClass("active");
			chat_type = 2;
			clearInterval(chat_interval);
			//showBlogList(category_id);
			open_blog_chatroom(blog_id, category_id);
		});






		if ($(window).width() < 800) {

			$('#name_list').addClass('d-none');
			$('.order-1').removeClass('d-none');


			$(document).on('click', '.back', function() {
				$('#name_list').removeClass('d-none');
				$('.order-1').addClass('d-none');
			});

			$(document).on('click', '.chat_list_card', function() {
				$('#name_list').addClass('d-none');
				$('.order-1').removeClass('d-none');
			});

			$(document).on('click', '.topic_list .card-body', function() {

				$('#name_list').addClass('d-none');
				$('.order-1').removeClass('d-none');
			});



		}

		setEmoji()




	});


	<?php if (isset($_GET['category_id']) && isset($_GET['blog_id']) && !empty($_GET['category_id']) && !empty($_GET['blog_id'])) { ?>
		$(function() {


			clearInterval(chat_interval);
			receiver = undefined;
			active_user_id = undefined;
			chat_type = 2;
			blog_id = <?= $_GET['blog_id'] ?>;
			category_id = <?= $_GET['category_id'] ?>;

			$('.single_chat').html('<div class="myLoader spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div>');
			getUserOneToOne();

			$(".topic_list").removeClass("d-none");
			$(".chat_list").addClass("d-none");
			$(".topic").addClass("active");
			$(".online").removeClass("active");

			GetUserList();
		})
	<?php } ?>



	function setEmoji() {
		tinymce.execCommand('mceRemoveEditor', false, "mytextarea");
		//tinymce.EditorManager.execCommand('mceAddControl',false, "mytextarea");
		tinymce.init({
			selector: "#mytextarea",
			plugins: "emoticons autoresize",
			toolbar: "emoticons",
			toolbar_location: "bottom",
			menubar: false,
			statusbar: false,
			setup: function(editor) {
				editor.on('change', function() {
					tinymce.triggerSave();
				});
			}
		});
	}

	setInterval(function() {

		let x = document.getElementById("mytextarea_ifr");
		if (x) {
			x.contentWindow.document.body.onkeyup = function(e) {
				console.log('dsfdsf', e)
				if (e.keyCode == 13) {
					sendMessage();
				}
			}
		}



	}, 1000);
</script>
@endsection