<?php

use Illuminate\Support\Facades\Session;
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Avery's Take</title>

    @yield('meta')
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css')}}">
    <link href="{{ asset('front/css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('front/css/new_style.css')}}" rel="stylesheet">
    <link href="{{ asset('front/css/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{ asset('front/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <!-- Template Stylesheet -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('front/js/owl.carousel.js')}}"></script>
    <script src="https://kit.fontawesome.com/107d2907de.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</head>



<body>

    @include('front.layout.header')

    @yield('content')

    @include('front.layout.footer')

    
    @yield('script')
    @yield('scripts')

    <script>
        $(document).ready(function() {

            $('.select2').select2();
            <?php if (Session::has('success')) { ?>
                toastr["success"]('<?php echo Session::get('success') ?>', "Success");
            <?php } ?>
            <?php if (Session::has('error')) { ?>
                toastr["error"]('<?php echo Session::get('error') ?>', "Error");
            <?php } ?>

        })

            

    </script>

    

    
    <script src="{{ asset('front/js/highlight.js')}}"></script>
    <script src="{{ asset('front/js/app.js')}}"></script>

    


</body>



</html>