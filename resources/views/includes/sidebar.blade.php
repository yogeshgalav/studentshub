<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
<div class="sidebar">
    <div class="row institution-detail">
        <div class="pl-3">
            <!-- <img src="{{asset('/images/default-avatar.png') }}" alt="Student'sHUB" width="40" class="pl-2"/> -->
            @if(Auth::teacher())
            <profile-image :user-name="{{json_encode(Auth::teacher()->instituteName)}}" avatar="/images/vector.png" />
            @elseif(Auth::student())
            <profile-image :user-name="{{json_encode(Auth::student()->instituteName)}}" avatar="/images/vector.png" />
            @else
            <span class="institution-name ml-1">Student's Hub </span>
            @endif

        </div>
        <div class="pl-1 pr-2">
            @if(Auth::teacher())
            <span class="institution-name ml-1" style="font-weight: 600">{{ Auth::teacher()->instituteName }}
            </span>
            @elseif(Auth::student())
            <span class="institution-name ml-1" style="font-weight: 600">{{ Auth::student()->instituteName }}
            </span>
            @else
            <span class="institution-name ml-1" style="font-weight: 600">Student's Hub </span>
            @endif
        </div>
    </div>

    <div class="sidebar-navigation">
        <ul>
            <li><a href="/classrooms" class="{{\App\Facades\Sthub::currentTab('classroom') ? 'active' : ''}}"><i
                        class="fa fa-desktop " aria-hidden="true"></i><span class="text">Classroom</span></a>
            </li>
            @if(Auth::user()->joinedClassroomCount()>0)
            <li><a href="/my-reports" class="{{\App\Facades\Sthub::currentTab('my-reports') ? 'active' : ''}}"><i
                        class="fa fa-desktop " aria-hidden="true"></i><span class="text">My
                        Reports</span></a>
            </li>
            @endif
            @if(Auth::user()->isInstituteMember())
            <li> <a href="/my-institute" class="{{\App\Facades\Sthub::currentTab('institute') ? 'active' : ''}}"><i
                        class="fas fa-university " aria-hidden="true"></i><span class="text"> My
                        Institute</span></a></li>
            @endif
            <li> <a href="/" class="{{\App\Facades\Sthub::currentTab('post') ? 'active' : ''}}"> <i class="fa fa-home "
                        aria-hidden="true"></i><span class="text">Home</span></a>
            </li>
            @if(Auth::student())
            <li><a href="/doubts" class="{{\App\Facades\Sthub::currentTab('doubt') ? 'active' : ''}}"> <i
                        class="fa fa-question-circle " aria-hidden="true"></i><span class="text">Doubts</span></a>
            </li>
            {{-- <li> <a href="/course/{{Auth::student()->courseUrl}}"
            class="{{\App\Facades\Sthub::currentTab(Auth::student()->courseUrl) ? 'active' : ''}}"> <span
                class="icon"><img src="{{asset('/images/home.png') }}" alt="Student'sHUB" width="20" /></span>
            My
            Course</a></li> --}}
            @endif
            @if(Auth::user()->hasClassroom())
            <li> <a href="/messages" class="{{\App\Facades\Sthub::currentTab('messages') ? 'active' : ''}}"><i
                        class="far fa-comment-dots" aria-hidden="true"></i><span class="text"> Messages
                    </span></a></li>
            @endif
            <li> <a href="/profile/{{Auth::id()}}"
                    class="{{\App\Facades\Sthub::currentTab('profile') ? 'active' : ''}}"><i class="far fa-user"
                        aria-hidden="true"></i><span class="text">
                        Profile</span></a>
            </li>

            @if(Auth::user()->role_intended === 'seeker')
            <li><a href="/check-in"> <span class="icon"><img src="{{asset('/images/logout.png') }}" alt="Student'sHUB"
                            width="20" /></span> Checkin</a></li>
            @endif
        </ul>
    </div>
</div>