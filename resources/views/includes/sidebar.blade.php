<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
<div class="sidebar">
    <div class="sidebar-navigation mt-5">
        <ul>
            <a href="/" class="{{\App\Facades\Sthub::currentTab('post') ? 'active' : ''}}">
                <li> <i class="fa fa-home " aria-hidden="true"></i><span class="text">Home</span>

                </li>
            </a>
            <a href="/doubts" class="{{\App\Facades\Sthub::currentTab('doubt') ? 'active' : ''}}">
                <li> <i class="fa fa-question-circle " aria-hidden="true"></i>
                    <span class="text">Doubts</span>
                </li>
            </a>
            @if(Auth::student())
            {{-- <a href="/my-course"
                class="{{\App\Facades\Sthub::currentTab('my-course') ? 'active' : ''}}">
                <li><i class="fas fa-book-open" aria-hidden="true"></i>
                    <span class="text">My Course</span>
                </li>
            </a> --}}
            @endif
            <a href="/classrooms" class="{{\App\Facades\Sthub::currentTab('classroom') ? 'active' : ''}}">
                <li><i class="fa fa-desktop " aria-hidden="true"></i><span class="text">Classrooms</span>

                </li>
            </a>
            @if(Auth::user()->role_intended==='student')
            <a href="/my-reports" class="{{\App\Facades\Sthub::currentTab('my-reports') ? 'active' : ''}}">
                <li><i class="fas fa-chart-line" aria-hidden="true"></i>
                    <span class="text">My Reports</span>
                </li>
            </a>
            @endif
            <a href="/messages" class="{{\App\Facades\Sthub::currentTab('messages') ? 'active' : ''}}">
                <li> <i class="far fa-comment-dots" aria-hidden="true"></i>
                    <span class="text"> Messages</span>
                </li>
            </a>
            @if(Auth::user()->role_intended==='instituteAdmin')
            <a href="/my-institute" class="{{\App\Facades\Sthub::currentTab('institute') ? 'active' : ''}}">
                <li> <i class="fas fa-university " aria-hidden="true"></i><span class="text"> My
                        Institute</span>
                </li>
            </a>
            @endif
            @if(Auth::user()->hasInstituteUserAccess())
            <a href="/students" class="{{\App\Facades\Sthub::currentTab('students') ? 'active' : ''}}">
                <li> <i class="fas fa-users " aria-hidden="true"></i>
                <span class="text">Students</span>
                </li>
            </a>
            @endif
            
            @if(Auth::user()->role_intended==='student')
            <a href="/classmates" class="{{\App\Facades\Sthub::currentTab('classmates') ? 'active' : ''}}">
                <li><i class="fas fa-users" aria-hidden="true"></i><span class="text">
                        Classmates</span>
                </li>
            </a>
            <a href="/more-apps" class="{{\App\Facades\Sthub::currentTab('more-apps') ? 'active' : ''}}">
                <li> <i class="fas fa-tablet-alt" aria-hidden="true"></i>
                    <span class="text">More Apps</span>
                </li>
            </a>
            @endif
            <a href="/profile/{{Auth::id()}}" class="{{\App\Facades\Sthub::currentTab('profile') ? 'active' : ''}}">
                <li> <i class="far fa-user" aria-hidden="true"></i>
                    <span class="text">Profile</span>
                </li>
            </a>
        </ul>
    </div>
</div>