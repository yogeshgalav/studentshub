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
                            <div class="dropdown-menu noti_design" aria-labelledby="dropdownMenuButton">
                            <p class="n_head dropdown-item">Recent Notification</p>
                            @foreach($notifications as $notification)
                                    <hr/>
                                      <a class="dropdown-item" href="{{ $notification['data']['url'] }}">{{ $notification['data']['text'] }}</a>
                                      <p class="dropdown-item"> <i class="fas fa-clock"></i> <span>{{ $notification['time'] }}</span></p>
                            @endforeach
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                       
                        @include('includes.profile-dropdown')
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
            <li><a href="/classrooms">	<span class="icon"><i class="fa fa-book-open"></i></span>Classrooms</a><span class="icon"></li>
                <li><a href="/my-institute">My Institute</a><span class="icon"><i class="fa fa-university"></i></span></li>
                <li><a href="/">Home</a><span class="icon"><i class="fa fa-home"></i></span></li>

                <li><a href="/profile/{{Auth::id()}}">Profile</a><span class="icon"><i class="fa fa-user"
                            aria-hidden="true"></i></span></li>

                <li><a href="/logout">Logout</a><span class="icon"><i class="fa fa-power-off"></i></span></li>

            </ul>

        </div>

    </nav>

</div>
