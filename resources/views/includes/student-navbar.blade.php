<!-- Navbar Header -->
<div class="container">

    <nav class="navbar navbar-expand-lg navbar-light main_header_mobile ">
        <div class="logo">
            <a href="/">
                <img src="{{asset('/images/logo.png') }}" alt="Student Hub" />
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav menu_head dash_search">
                <li class="nav-item  search_box ">
                    @include('includes.search-form')
                </li>
                <li>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-default border-radius-12 dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <span><i class="fa fa-bell"></i></span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                             
                                <a class="dropdown-item" href="#">Lipsum generator: Lorem Ipsum - All the facts Lipsum generator: Lorem Ipsum - All the facts</a>
                               
                            </div>
                        </div>
                    </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-default border-radius-12 dropdown-toggle" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user"></i> {{$AuthUser->full_name}}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <div class="d-flex p-2">
                                <div class="avatar user_img_dash">
                                    <img src="/images/4.jpg" class="avatar-img" style="width:50px;height:50px;">
                                </div>
                                <div class="info-post ml-2 mt-2">
                                    <p class="username">{{$AuthUser->full_name}}</p>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Profile</a>
                            <a class="dropdown-item" href="#">Account Settings</a>
                            @foreach($notifications as $notification)
                            <a class="dropdown-item" href="#">@lang($notification->text)</a>
                            @endforeach
                            <a href="/logout" class="center-block ml-3 mt-1 btn btn-sm btn-default logout_btn">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>
