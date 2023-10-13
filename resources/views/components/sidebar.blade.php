<ul class="nav nav-pills side-menu  flex-column mb-auto vh-md-100">
    <li class="nav-item">
        <a href="{{route('chat-room')}}" class="nav-link link-dark {{request()->routeIs('chat-room') ? 'active' : ''}}" aria-current="page">
            <i class="fa-solid fa-grip"></i>
            Enter Chat Room
        </a>
    </li>
    <li class="nav-item">
        <a href="{{route('edit-profile')}}" class="nav-link link-dark  {{request()->routeIs('edit-profile') ? 'active' : ''}}">
            <i class="fa-regular fa-user"></i>
            Edit Profile
        </a>
    </li>
    <li class="nav-item">
        <a href="{{route('change-password')}}" class="nav-link link-dark  {{request()->routeIs('change-password') ? 'active' : ''}}">
            <i class="fa-regular fa-gear"></i>
            Change password
        </a>
    </li>
    <li class="nav-item">
        <a href="{{route('logout')}}" class="nav-link link-dark  {{request()->routeIs('logout') ? 'active bg-dark' : ''}}">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            Logout
        </a>
    </li>
</ul>