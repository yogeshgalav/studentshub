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
                    <li class="nav-item">
                    <div class="dropdown" style="margin-right:40px">
                    <notifications-dropdown></notifications-dropdown>
                    </div>
                    </li>
                    <li class="nav-item">

                        @include('includes.profile-dropdown')
                    </li>

                </ul>

            </div>
        </div>


    </div>
    <!-- web header -->
    <nav role="navigation" class="menu">


        <div class="overflow-container" id="sidebarContainer">
            <div class="row mb-2">
                <div class="pl-3">
                    <img src="{{asset('/images/default-avatar.png') }}" alt="Student'sHUB" width="40" class="pl-2"/>
                </div>
                <div class="pl-1 pr-2">
                    @if(Auth::teacher())
                    <span class="sidebar_heading ml-1">{{ Auth::teacher()->instituteName }} </span>
                    @elseif(Auth::student())
                    <span class="sidebar_heading ml-1">{{ Auth::student()->instituteName }} </span>
                    @else
                    <span class="sidebar_heading ml-1">Student's Hub </span>
                    @endif
                </div>
            </div>

            <ul class="menu-dropdown">
            <li><a href="/classrooms" class="{{\App\Facades\Sthub::currentTab('classroom') ? 'active' : ''}}"><i class="fa fa-desktop sidebar" aria-hidden="true"></i><span class="text">Classroom</span></a></li>
            @if(Auth::user()->isInstituteMember())
            <li> <a href="/my-institute" class="{{\App\Facades\Sthub::currentTab('institute') ? 'active' : ''}}"><span class="icon"><img src="{{asset('/images/university.png') }}" alt="Student'sHUB" width="20"/></span> My Institute</a></li>
            @endif
                <li> <a href="/" class="{{\App\Facades\Sthub::currentTab('post') ? 'active' : ''}}"> <i class="fa fa-home sidebar" aria-hidden="true"></i><span class="text">Home</span></a></li>
            @if(Auth::student())
                <li> <a href="/doubts" class="{{\App\Facades\Sthub::currentTab('doubt') ? 'active' : ''}}"> <i class="fa fa-question-circle sidebar" aria-hidden="true"></i><span class="text">Doubts</span></a></li>
                {{-- <li> <a href="/course/{{Auth::student()->courseUrl}}" class="{{\App\Facades\Sthub::currentTab(Auth::student()->courseUrl) ? 'active' : ''}}"> <span class="icon"><img src="{{asset('/images/home.png') }}" alt="Student'sHUB" width="20"/></span> My Course</a></li> --}}
                @endif
            @if(Auth::user()->hasClassroom())
            <li> <a href="/messages" class="{{\App\Facades\Sthub::currentTab('messages') ? 'active' : ''}}"><span class="icon"><i class="far fa-comment-alt"></i></span> Messages </a></li>
            @endif
                <li> <a href="/profile/{{Auth::id()}}"  class="{{\App\Facades\Sthub::currentTab('profile') ? 'active' : ''}}"> <span class="icon"><img src="{{asset('/images/user.png') }}" alt="Student'sHUB" width="20"/></span> Profile</a></li>

            @if(Auth::user()->role_intended === 'seeker')
                <li><a href="/check-in"> <span class="icon"><img src="{{asset('/images/logout.png') }}" alt="Student'sHUB" width="20"/></span> Checkin</a></li>
            @endif
                <li><a href="/logout"> <span class="icon"><img src="{{asset('/images/logout.png') }}" alt="Student'sHUB" width="20"/></span> Logout</a></li>
            </ul>

        </div>

    </nav>

</div>
