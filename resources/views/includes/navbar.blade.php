<!-- Navbar Header -->
<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">

<div class="container-fluid">
    <div class="collapse" id="search-nav">
        <form method="GET" action="#" class="navbar-left navbar-form nav-search mr-md-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <button type="submit" class="btn btn-search pr-1">
                        <i class="fa fa-search search-icon"></i>
                    </button>
                </div>
                <input type="text" id="q" name="q" value="{{ Request::get('q') }}" placeholder="{{__('app.search_placeholder')}}" class="form-control">
            </div>
        </form>
    </div>
    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
        <li class="nav-item toggle-nav-search hidden-caret">
            <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
                <i class="fa fa-search"></i>
            </a>
        </li>
        
        <li class="nav-item dropdown hidden-caret">
            <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bell"></i>
                @if ( $AuthUser->notificationCount() > 0 ) {
                    <span class="notification">{{ $AuthUser->notificationCount() }}</span>
                @endif
            </a>
            <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                <li>
                    <div class="dropdown-title">{{ trans_choice('app.notificationsMenuHeader', $AuthUser->notificationCount(), ['notification_count' => $AuthUser->notificationCount()] )}}</div>
                </li>
                <li>
                    <div class="notif-scroll scrollbar-outer">
                        <div class="notif-center">
                            <!-- <a href="#">
                                <div class="notif-icon notif-primary"> <i class="fa fa-user-plus"></i> </div>
                                <div class="notif-content">
                                        <span class="block">
                                            New user registered
                                        </span>
                                    <span class="time">5 minutes ago</span>
                                </div>
                            </a> -->
                            
                        </div>
                    </div>
                </li>
                <li>
                    <a class="see-all" href="javascript:void(0);">{{__('app.allNotification')}}<i class="fa fa-angle-right"></i> </a>
                </li>
            </ul>
        </li>
        
        <li class="nav-item dropdown hidden-caret">
            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                <div class="avatar-sm">
                    @if($AuthUser->avatar_url)
                    <img src="{{ asset('avatars/' . $AuthUser->avatar_url) }}" alt="{{$AuthUser->full_name}}" class="avatar-img rounded-circle">
                    @else
                    <img src="{{ asset('images/default-avatar.png') }}" alt="" class="avatar-img rounded-circle">
                    @endif
                </div>
            </a>
            <ul class="dropdown-menu dropdown-user animated fadeIn">
                <div class="dropdown-user-scroll scrollbar-outer">
                    <li>
                        <div class="user-box">
                            <div class="avatar-lg">
                            @if($AuthUser->avatar_url)
                            <img src="{{ asset('avatars/' . $AuthUser->avatar_url) }}" alt="{{$AuthUser->full_name}}" class="avatar-img rounded">
                            @else
                            <img src="{{ asset('images/default-avatar.png') }}" alt="" class="avatar-img rounded">
                            @endif
                            </div>
                            <div class="u-text">
                                <h4>{{$AuthUser->full_name}}</h4>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">{{__('app.Account Settings')}}</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('Logout')}}">{{__('app.logout')}}</a>
                    </li>
                </div>
            </ul>
        </li>
    </ul>
</div>
</nav>
<!-- End Navbar -->
