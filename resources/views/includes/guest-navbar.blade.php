<!-- Navbar Header -->
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <router-link :to="'/'">
                <img src="{{asset('/images/logo.png') }}" alt="Student Hub"/>
            </router-link>
        </div>
        <div class="col-md-6">
            <form action="/explore" method="GET">
                <div id="custom-search-input">
                        <div class="input-group col-md-12">
                            <input type="text" class="search-query form-control" name="search" placeholder="What do you want to learn ?" />
                            <span class="input-group-btn">
                                <button class="btn btn-link" type="submit">
                                    <i class=" fa fa-search text-black weight-400"></i>
                                </button>
                            </span>
                        </div>
                    </div>
            </div>
            <div class="col-md-3 text-right">
                    <router-link class="btn btn-link text-black" :to="'/login'">Login</router-link>
                    <router-link class="btn btn-primary weight-400" :to="'/get-started'">Get Started <i class="fas fa-arrow-right text-white"></i> </router-link>
                </div>
    </div>
</div>
<!-- End Navbar -->
