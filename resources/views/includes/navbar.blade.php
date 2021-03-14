<div class="container">
@if(in_array(request()->path(),['reset-password','check-in']) || request()->is('*daily-attempt'))
<div class="row">
    <div class="col-md-3 col-12 text-center">
        <a href="/">
            <img src="{{asset('/images/logo.png') }}" alt="Student'sHub"/>
        </a>
    </div>
</div>
@else
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
    @if(Auth::check())
      <ul class="navbar-nav menu_head dash_search">
        <li class="nav-item  search_box ">
        @include('includes.search-form')
        </li>
        <li>
          <div class="mr-2">
            <notifications-dropdown></notifications-dropdown>
          </div>
        </li>
        <li class="nav-item">
          @include('includes.profile-dropdown')
        </li>
      </ul>
    @else
      <ul class="navbar-nav menu_head">
        <li class="nav-item  search_box">
          @include('includes.search-form')
        </li>
        <li class="nav-item">
          <router-link class="btn btn-link text-blue" :to="'/login'">Login</router-link>
        </li>
        <li class="nav-item">
          <router-link class="btn btn-primary weight-400" :to="'/get-started'">Get Started <i class="fas fa-arrow-right text-white"></i> </router-link>
        </li>
      </ul>
    @endif
  </div>
</nav>
@endif
</div>
