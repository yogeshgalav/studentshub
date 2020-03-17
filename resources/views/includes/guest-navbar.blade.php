<!-- Navbar Header -->
<div class="container">
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
</div>
<!-- End Navbar -->
