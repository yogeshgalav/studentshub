<!-- Navbar Header -->
<!-- <div class="container">
    <div class="row">
        <div class="col-md-3">
            <router-link :to="'/'">
                <img src="{{asset('/images/logo.png') }}" alt="Student Hub"/>
            </router-link>
        </div>
        <div class="col-md-6">
		@include('includes.search-form')
            </div>
            <div class="col-md-1 text-right mt-2">
                    <i class="fa fa-bell"></i>
            </div>
            <div class="col-md-2  mt-1">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-default border-radius-12 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="fa fa-user"></i> {{$AuthUser->full_name}}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="d-flex p-2">
										<div class="avatar">
											<img src="/images/4.jpg" class="avatar-img rounded-circle">
										</div>
										<div class="info-post ml-2 mt-2">
                                        <p class="username">{{$AuthUser->full_name}}</p>
                                        </div>
                                </div>
                                <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Profile</a>
                          <a class="dropdown-item" href="#">Account Settings</a>
						  @foreach($notifications as $notification)
                          <a class="dropdown-item" href="#">@lang($notification->text)</a>
						  @endforeach
						  {{--  <a class="dropdown-item" href="#">Something else here</a> --}}
                          <a href="/logout" class="center-block ml-5 mt-1 btn btn-sm btn-default">Logout</a>
                        </div>
                      </div>
            
                </div>
    </div>
</div> -->
<!-- End Navbar -->






<div class="container">
    
<nav class="navbar navbar-expand-lg navbar-light ">
    <div class="logo">
    <router-link :to="'/'">
                <img src="{{asset('/images/logo.png') }}" alt="Student Hub"/>
            </router-link>
</div>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav menu_head dash_search">
      <li class="nav-item active search_box ">
      @include('includes.search-form')
      </li>
      <li class="nav-item">
      <div class="dropdown">
                        <button class="btn btn-sm btn-default border-radius-12 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="fa fa-user"></i> {{$AuthUser->full_name}}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="d-flex p-2">
										<div class="avatar user_img_dash">
											<img src="/images/4.jpg" class="avatar-img">
										</div>
										<div class="info-post ml-2 mt-2">
                                        <p class="username">{{$AuthUser->full_name}}</p>
                                        </div>
                                </div>
                                <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Profile</a>
                          <a class="dropdown-item" href="#">Account Settings</a>
						  @foreach($notifications as $notification)
                          <a class="dropdown-item" href="#">@lang($notification->text)</a>
						  @endforeach
						  {{--  <a class="dropdown-item" href="#">Something else here</a> --}}
                          <a href="/logout" class="center-block ml-3 mt-1 btn btn-sm btn-default">Logout</a>
                        </div>
                      </div>


      </li>
      <!-- <li class="nav-item">
      <router-link class="btn btn-primary weight-400" :to="'/get-started'">Get Started <i class="fas fa-arrow-right text-white"></i> </router-link>

      </li> -->
    </ul>
  </div>
</nav>
</div>
<style>
    .user_img img
    {
        width:50px;
        height:50px;
    }
</style>