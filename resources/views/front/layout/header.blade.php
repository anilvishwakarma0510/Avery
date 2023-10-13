<style type="text/css">
    .enter_chat {
    z-index: +1;
}
.backline1.enter_chat:before {
    content: "";
    background: #f0f049;
    height: 20px;
    left: auto;
    top: 16px;
    width: 50%;
    position: absolute;
    z-index: -1;
    right: -13px;
}
footer.footer {
    border-top: 1px solid #d1d1d1;
    padding-top: 45px;
}
</style>
<header>

    <div class="container-fluid">



        <div class="d-flex align-items-center justify-content-between p-1 p-md-4 flex-md-row flex-row-reverse">



            <div class="w-25 w-m-auto">
                <form action="{{route('blog.search')}}" method="get" class="input-group top_search_group border-0 p-0 p-md-2">
                <button class="input-group-text border-0" id="basic-addon1">

                    <i class="fa-solid fa-magnifying-glass fs_sm_25"></i>

</button>

                <input type="text" name="keywords" class="form-control border-0 d-none d-md-block" placeholder="Search">
                </form>

            </div>



            <h3 class="m-0 w-50 text-center text-primary fs_45 fs_sm_25 fw_8"><a href="{{route('home')}}">{{env('APP_NAME')}}</a></h3>



            <div class="d-flex align-items-center gap-0 gap-md-3 w-25 w-m-auto justify-content-start justify-content-md-end">

                <a data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling" class="curser-pointer">

                    <img src="{{ asset('front/img/menu.svg')}}" class="menu_icon">

                </a>

                <p class="m-0 fs_25 fw_8 text-dark d-none d-md-block position-relative backline1 enter_chat">Enter Chat Room</p>

            </div>





        </div>



    </div>


    @yield('header-home')



    



</header>