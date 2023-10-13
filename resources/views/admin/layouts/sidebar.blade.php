
<div id="layoutSidenav">
  <div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
      <div class="sb-sidenav-menu">
        <div class="nav mt-4">
          <a class="nav-link {{request()->routeIs('admin.dashboard') ? 'active bg-dark' : ''}}" href="{{route('admin.dashboard')}}">
            <div class="sb-nav-link-icon">
              <i class="fas fa-home"></i>
            </div>
            Dashboard
          </a>

          <a class="nav-link {{request()->routeIs('admin.category') ? 'active bg-dark' : ''}}" href="{{route('admin.category')}}">
            <div class="sb-nav-link-icon">
              <i class="fas fa-home"></i>
            </div>
            Cateogry Management
          </a>
        
          <a class="nav-link " href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="true" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
            Blogs Management
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
          </a>
          <?php
          $allowedRoutes = [
            'admin.blogs',
            'admin.blog.add',
            'admin.blog.edit',
          ];
          ?>
          <div class="collapse {{in_array(request()->route()->getName(), $allowedRoutes) ? 'show' : ''}}" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion" style="">
            <nav class="sb-sidenav-menu-nested nav">
              <a class="nav-link  {{request()->routeIs('admin.blog.add') ? 'active bg-dark' : ''}}" href="{{route('admin.blog.add')}}">
                <div class="sb-nav-link-icon">
                  <i class="fa-regular fa-circle"></i>
                </div>
                Add Blog
              </a>
              <a class="nav-link  {{request()->routeIs('admin.blogs') ? 'active bg-dark' : ''}}" href="{{route('admin.blogs')}}">
                <div class="sb-nav-link-icon">
                  <i class="fa-regular fa-circle"></i>
                </div>
                Blogs List
              </a>
             
            </nav>
          </div>

          <a class="nav-link " href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts2" aria-expanded="true" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
            Contact Management
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
          </a>
          <?php
          $allowedRoutes = [
            'admin.contact-request',
            'admin.contact-address',
          ];
          ?>
          <div class="collapse {{in_array(request()->route()->getName(), $allowedRoutes) ? 'show' : ''}}" id="collapseLayouts2" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion" style="">
            <nav class="sb-sidenav-menu-nested nav">
              <a class="nav-link  {{request()->routeIs('admin.contact-address') ? 'active bg-dark' : ''}}" href="{{route('admin.contact-address')}}">
                <div class="sb-nav-link-icon">
                  <i class="fa-regular fa-circle"></i>
                </div>
                Edit Contact Address
              </a>
              <a class="nav-link  {{request()->routeIs('admin.contact-request') ? 'active bg-dark' : ''}}" href="{{route('admin.contact-request')}}">
                <div class="sb-nav-link-icon">
                  <i class="fa-regular fa-circle"></i>
                </div>
                Contact Requests
              </a>
             
            </nav>
          </div>


          <a class="nav-link " href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts3" aria-expanded="true" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
            Home Page Setting
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
          </a>
          <?php
          $allowedRoutes = [
            'admin.home-page-banner',
            'admin.home-extra-work-banner',
            'admin.social-link',
            'admin.news-letter',
          ];
          ?>
          <div class="collapse {{in_array(request()->route()->getName(), $allowedRoutes) ? 'show' : ''}}" id="collapseLayouts3" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion" style="">
            <nav class="sb-sidenav-menu-nested nav">
              <a class="nav-link  {{request()->routeIs('admin.home-page-banner') ? 'active bg-dark' : ''}}" href="{{route('admin.home-page-banner')}}">
                <div class="sb-nav-link-icon">
                  <i class="fa-regular fa-circle"></i>
                </div>
                Home Page Banner
              </a>
              <a class="nav-link  {{request()->routeIs('admin.home-extra-work-banner') ? 'active bg-dark' : ''}}" href="{{route('admin.home-extra-work-banner')}}">
                <div class="sb-nav-link-icon">
                  <i class="fa-regular fa-circle"></i>
                </div>
                Home Page Extra Banner
              </a>
              <a class="nav-link  {{request()->routeIs('admin.social-link') ? 'active bg-dark' : ''}}" href="{{route('admin.social-link')}}">
                <div class="sb-nav-link-icon">
                  <i class="fa-regular fa-circle"></i>
                </div>
                Social Link
              </a>
              <a class="nav-link  {{request()->routeIs('admin.news-letter') ? 'active bg-dark' : ''}}" href="{{route('admin.news-letter')}}">
                <div class="sb-nav-link-icon">
                  <i class="fa-regular fa-circle"></i>
                </div>
                Newsletter
              </a>
             
            </nav>
          </div>


        </div>
      </div>
    </nav>
  </div>