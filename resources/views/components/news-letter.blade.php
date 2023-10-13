<section class="newsletter my-5">
	<div class="container-fluid px-0 px-md-5">
		<div class="row">
			<div class="col-12 col-md-9">
				<div class="news_letter_bx">
					<h3 class="text-uppercase">Get the Avery's Take Daily<br>Newsletter</h3>
					<p>Your go-to source for the latest in fashion, beauty, entertainment, music, and more, so you’ll always be the most in-the-know person in the group chat.</p>

					<div class="subscribe_div w-75">
					
						<input type="email" name="email" id="newsletter_email" class="mt-2 input_custom" placeholder="youname@example.com">
						<div class="text-end">
							<a onclick="submitNewsletter(this)" href="javascript:;" class="btn_subscribe">Subscribe <i class="fa-solid fa-chevron-right"></i></a>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@section('script')
<script>
	function submitNewsletter(e){
		let email = $('#newsletter_email').val();
		if(!email){
			toastr['error']("Please enter email","Error")
			return false;
		}

		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)==false){
			toastr['error']("Please enter valid email","Error")
			return false;
		}

		$.ajax({
			url:"{{route('subscribe.newsletter')}}",
			method:'post',
			data:{
				email:email,
				_token:'{{@csrf_token()}}'
			},
			beforeSend:function(){

			},
			success:function(resp){
				if(resp.status==1){
					toastr['success']("Congratulation you have subscribed our newsletter successfully.","Success")
					$('#newsletter_email').val('');
				} else {
					toastr['error']("Something went wrong, try again later","Error")
				}
			},
			error:function(e){
				let error = e?.message;
				if(!error){
					error = e?.responseJSON?.message;
				}
				if(!error){
					error = 'Something went wrong, try again later';
				}
				toastr['error'](error,"Error")
			}
		})
	}
</script>
@endsection