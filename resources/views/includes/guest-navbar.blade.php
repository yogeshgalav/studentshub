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
            <div class="col-md-3 text-right">
                    <router-link class="btn btn-link text-black" :to="'/login'">Login</router-link>
                    <router-link class="btn btn-primary weight-400" :to="'/get-started'">Get Started <i class="fas fa-arrow-right text-white"></i> </router-link>
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
    <ul class="navbar-nav menu_head">
      <li class="nav-item active search_box">
      @include('includes.search-form')
      </li>
      <li class="nav-item">
      <router-link class="btn btn-link text-black" :to="'/login'">Login</router-link>


      </li>
      <li class="nav-item">
      <router-link class="btn btn-primary weight-400" :to="'/get-started'">Get Started <i class="fas fa-arrow-right text-white"></i> </router-link>

      </li>
    </ul>
  </div>
</nav>
</div>

