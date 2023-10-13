@extends('front.layout.app')

@section('content')
<section class="form_top_m ">
    <div class="container">
        <div class="row align-items-center ">
            <div class="col-md-5 p-0 ">
                <div class="back_yellow h-75 p-3 pt-0 p-md-5 rounded-3">
                    <div class="pt-5">
                        <h2 class="pt-0 pt-md-5 color-sec fw-bold fs_50 fs_sm_30 contact_heading">Avery's Take</h2>
                        <p class="color-sec fs_30 fs_sm_22">Always there to help you out</p>
                    </div>
                </div>

            </div>
            <div class="col-md-6 p-0 position-relative">
                <div class="back_frogy_line"></div>
                <div class="back_frogy p-3 p-md-5 rounded-3">

                    <form action="" id="contact-us" onsubmit="return contactUs()">
                        @csrf
                        <div class="mb-3">
                            <input type="name" required name="name" class="mt-2 input_custom input_custom_sm p-3" placeholder="Your Name">
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" required class="mt-2 input_custom input_custom_sm p-3" placeholder="Email">
                        </div>
                        <div class="mb-3 mt-4">
                            <label for="" class="form-label ps-3 fs_20">Message</label>
                            <textarea type="text" name="message" rows="5" class="form-control textarea_custom bg-transparent fs_20 fs_sm_15" id="formGroupExampleInput2" placeholder=""></textarea>
                        </div>
                        <div class="d-flex justify-content-end pe-2 mt-3">
                            <button type="submit" class="btn fw_8 text-secondar mb-0 pe-4 fs_30 color-sec position-relative backline1 submit post backline3 ">
                                <span>Send</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>

        <div class="back_gray p-5 rounded-3">
            <div class="row flex-column flex-md-row">
                <div class="col-md-3 mb-4 mb-md-0">
                    <p class="m-0 fs_22 fs_sm_16">Call Us</p>
                    <p class="m-0 fs_18 fs_sm_14"><a href="tel:<?php echo str_replace(' ','',$address?->phone); ?>"><?php echo $address?->phone; ?></a></p>
                </div>
                <div class="col mb-4 mb-md-0">
                    <p class="m-0 fs_22 fs_sm_16">Email</p>
                    <p class="m-0 fs_18 fs_sm_14"><a href="mailto:<?php echo $address?->email; ?>"><?php echo $address?->email; ?></a></p>
                </div>
                <div class="col mb-4 mb-md-0">
                    <p class="m-0 fs_22 fs_sm_16">Address</p>
                    <p class="m-0 fs_18 fs_sm_14"><?php echo $address?->address; ?></p>
                </div>
            </div>
        </div>




    </div>
</section>

@endsection

@section('script')
<script>
    function contactUs(){
        $.ajax({
            url:"{{route('contact-us-post')}}",
            method:'POST',
            data:$('#contact-us').serialize(),
            beforeSend:function(){
                $('.backline3').prop('disabled',true);
                $('.backline3').html('<span>Processing</span>');
            },
            success:function(res){
                $('.backline3').prop('disabled',false);
                $('.backline3').html('<span>Send</span>');
                if(res.status==1){
                    location.reload();
                } else {
                    toastr['error'](res.message,"Error");
                }
            },
            error:function(error){
                console.log(error);
                let message = error?.responseJSON?.message;
                if(!message){
                    message = error?.message;
                }
                if(!message){
                    message = 'Something went wrong';
                }
                toastr['error'](message,"Error");
            }
        })
        return false;
    }
</script>
@endsection