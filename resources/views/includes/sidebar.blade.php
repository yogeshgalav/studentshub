<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

<div class="primary-nav">
    <!-- mobile header -->
    <div class="Dsfdad">
        <div class="header_mobile">
            <div class="logo mobile_logo">
                <a href="/">
                    <img src="{{asset('/images/logo.png') }}" alt="Student'sHUB" />
                </a>
            </div>
            <div class="header_mobile_login">
                <ul>
                    <li><button class="hamburger open-panel togle_mobile" id="nav-toggle"
                            @click="toggleSidebar($event)">
                        </button>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-default border-radius-12 dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <span><i class="fa fa-search" aria-hidden="true"></i></span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @include('includes.search-form')
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-default border-radius-12 dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <span><i class="fa fa-bell"></i></span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @foreach($notifications as $notification)
                                      <a class="dropdown-item" href="#">@lang($notification['text'])</a>
                            @endforeach
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-default border-radius-12 dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fa fa-user"></i>
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
                                <a href="/logout" class="center-block ml-3 mt-1 btn btn-sm btn-default">Logout</a>
                            </div>
                        </div>


                    </li>
                </ul>
            </div>
        </div>


    </div>
    <button class="hamburger open-panel togle_web" id="nav-toggle" @click="toggleSidebar($event)">
    </button>
    <!-- web header -->
    <nav role="navigation" class="menu">


        <div class="overflow-container">

            <ul class="menu-dropdown">
            @if(Auth::student())
                <li><a href="/doubts">Doubts</a><span class="icon"><i class="fas fa-question-circle"></i></span></li>
  @endif
                <li><a href="/">Home</a><span class="icon"><i class="fa fa-home"></i></span></li>

                <li><a href="/saved-posts">Saved Posts</a><span class="icon"><i class="fas fa-save"></i></span></li>

                <li><a href="/profile">Profile</a><span class="icon"><i class="fa fa-user"
                            aria-hidden="true"></i></span></li>

                <li><a href="/logout">Logout</a><span class="icon"><i class="fa fa-power-off"></i></span></li>

            </ul>

        </div>

    </nav>

</div>
