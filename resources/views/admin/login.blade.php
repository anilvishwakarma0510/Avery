<?php
use Illuminate\Support\Facades\Session;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ env('APP_NAME') }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- Favicon -->
    <!-- <link href="{{ asset('admin/img/fav.png') }}" rel="icon"> -->
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">

    <style type="text/css">
    .bg-dark{
        background-color: #fff!important;
        box-shadow: 0px 1px 28px -18px grey;
    }
</style>
</head>

<body>   

<div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-6 m-auto mt-5 mb-5">
                <div class="bg-dark p-5">
                     <div class="mb-5 text-center">
                        <h1 class="mb-2 ">Avery's Take</h1>
                        <h3 class="mb-2 ">Log In</h3>
                    </div>
                   <form class="login-form" method="post" action="{{ route('admin.do_login') }}">
                    @csrf
                        <div class="row g-3">
                            @if( Session::has('error')) 

                                  <div class="alert alert-danger mt-3" role="alert">

                                    <?php echo Session::get('error') ?>

                                </div>

                                  @endif
                            <div class="col-lg-12">
                                <label>Username</label>
                                <input type="email" name="email" class="form-control bg-light border-0 pt-2" placeholder="Username">
                            </div>
                            <div class="col-lg-12">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control bg-light border-0 pt-2" placeholder="Password">
                            </div>
                           <!--  <div class="col-lg-6">                  
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck1">
                                <label class="form-check-label" for="gridCheck1">
                                  Keep me logged in. 
                                </label>
                              </div>    
                            </div> -->
                         <!--    <div class="col-lg-6 text-end">                  
                              <div class="form-check">
                                <label class="form-check-label" for="gridCheck1">
                                  <a href="password_reset.php">forgot password</a>
                                </label>
                              </div>    
                            </div> -->
                            <div class="col-lg-12">
                                <button class="btn btn-primary w-100" type="submit">Log In</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  <a href="#" class="btn btn-dark py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>   
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Template Javascript -->
</body>

</html>