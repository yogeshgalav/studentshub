<div class="navbar fixed-top">
    @if(in_array(request()->path(),['reset-password','check-in']) || request()->is('*daily-attempt'))
    <div class="row">
        <div class="col-md-3 col-12">
            <a href="/">
                <img src="{{asset('/images/logo.png') }}" alt="Student Hub" />
            </a>
        </div>
    </div>
    @elseif(Auth::check())
    <div class="row col-md-12 nav-items">
        <div class="navbar-brand">
            <a href="/">
                <img src="{{asset('/images/logo.png') }}" alt="Student Hub" />
            </a>
        </div>
        <div class="search-bar col-md-6">
            @include('includes.search-form')
        </div>
        <div class="notification-dropdown">
            <notifications-dropdown></notifications-dropdown>
        </div>
        <div class="profile-dropdown dropleft">
            @include('includes.profile-dropdown')
        </div>
    </div>

    <!-- mobile header -->
    <div>
        <div class="mobile_navbar" id="header_mobile">

            <button type="button" id="nav-toggle" class="btn btn-sm btn-default border-radius-12"
                @click="toggleSidebar($event)"><i class="fa fa-bars alignment ml-2" aria-hidden="true"></i>
            </button>

            <div class="dropdown">
                <button class="btn btn-sm btn-default border-radius-12 dropdown-toggle" type="button"
                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span><i class="fa fa-search alignment" aria-hidden="true"></i></span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @include('includes.search-form')
                </div>

            </div>

            <div class="dropdown" style="margin-right:40px">
                <notifications-dropdown></notifications-dropdown>
            </div>

            <div class="nav-item dropleft">
                @include('includes.profile-dropdown')
            </div>

        </div>

    </div>
    @else
    <!-- guest navbar uathenticated navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="logo">
            <a href='/'>
                <img src="{{asset('/images/logo.png') }}" alt="Student'sHUB" />
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav menu_head">
                <li class="nav-item  search_box">
                    @include('includes.search-form')
                </li>
                <div class="nav-login-get-started">
                    <li class="nav-item nav-login">
                        <router-link class="btn btn-link text-blue" :to="'/login'">Login <i
                                class="fas fa-arrow-right"></i></router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="btn btn-primary weight-400" :to="'/get-started'">Get Started <i
                                class="fas fa-arrow-right text-white"></i></router-link>
                    </li>
                </div>
            </ul>
        </div>
    </nav>
    @endif

</div>