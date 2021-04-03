<div class="container-fluid">
@if(in_array(request()->path(),['reset-password','check-in']) || request()->is('*daily-attempt'))
<div class="row">
    <div class="col-md-3 col-12">
        <a href="/">
            <img src="{{asset('/images/logo.png') }}" alt="Student Hub"/>
        </a>
    </div>
</div>
@elseif(Auth::check())
<nav class="navbar navbar-expand-lg navbar-light auth-navbar">
  <div class="logo">
    <a href='/'>
      <img src="{{asset('/images/logo.png') }}" alt="Student'sHUB"/>
    </a>
  </div>
  <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button> -->
  <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav menu_head dash_search">
        <li class="nav-item  search_box ">
        @include('includes.search-form')
        </li>
        <li>
        <li><button 
                type="button" 
                data-toggle="dropdown"
                class="btn btn-sm btn-default border-radius-12 dropdown-toggle"
                @click="showNotificationDropdown=!showNotificationDropdown"
            ><i class="far fa-bell" aria-hidden="true"></i>
            </button>
        </li>
        </li>
        <li class="nav-item">
          @include('includes.profile-dropdown')
        </li>
      </ul>
  </div>
  <div>
    <notifications-dropdown v-if="showNotificationDropdown"></notifications-dropdown>
  </div>
</nav>
@else
<nav class="navbar navbar-expand-lg navbar-light">
  <div class="logo">
    <a href='/'>
      <img src="{{asset('/images/logo.png') }}" alt="Student'sHUB"/>
    </a>
  </div>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav menu_head">
        <li class="nav-item  search_box">
          @include('includes.search-form')
        </li>
        <div class="nav-login-get-started">
        <li class="nav-item nav-login">
          <router-link class="btn btn-link text-blue" :to="'/login'">Login <i class="fas fa-arrow-right"></i></router-link>
        </li>
        <li class="nav-item">
          <router-link class="btn btn-primary weight-400" :to="'/get-started'">Get Started <i class="fas fa-arrow-right text-white"></i></router-link>
        </li>
        </div>
      </ul>
    </div>
</nav>
@endif
</div>
