<nav class="sb-topnav navbar navbar-expand navbar-dark sb-sidenav-dark p-1">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="{{ route('admin.dashboard') }}">
        <!-- <img src="{{ asset('img/logo.png') }}" width="150px;"> -->
        Avery's Take
    </a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
   <a href="#" class="  ms-auto p-0 ps-2 pe-2"> </a>  
    <!--  <form class="d-none d-md-inline-block form-inline me-0 me-md-3 my-2 my-md-0 ms-2">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form> -->
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="{{ route('admin.edit-profile') }}">Profile</a></li>
                 <li><a class="dropdown-item" href="{{ route('admin.change-password') }}">Change password</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.logout') }}">Log out</a></li>
            </ul>
        </li>
    </ul>
</nav>
