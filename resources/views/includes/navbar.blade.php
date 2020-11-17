<div class="container">
    
<nav class="navbar navbar-expand-lg navbar-light ">
    <div class="logo">
    <a href='/'>
                <img src="{{asset('/images/logo.png') }}" alt="Student'sHUB"/>
    </a>
</div>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav menu_head dash_search">
      <li class="nav-item  search_box ">
      @include('includes.search-form')
      </li>
      {{-- <li>
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
                                      <a class="dropdown-item" href="{{$notification['data']['url']}}">{{ $notification['data']['text'] }}</a>
                                     <p class="dropdown-item"> <i class="fas fa-clock"></i> <span>{{ $notification['time'] }}</span></p>
                            @endforeach
                            </div>
                        </div>
                    </li> --}}
      <li class="nav-item">
        @include('includes.profile-dropdown')
      </li>
      <!-- <li class="nav-item">
      <router-link class="btn btn-primary weight-400" :to="'/get-started'">Get Started <i class="fas fa-arrow-right text-white"></i> </router-link>

      </li> -->
    </ul>
  </div>
</nav>
</div>
