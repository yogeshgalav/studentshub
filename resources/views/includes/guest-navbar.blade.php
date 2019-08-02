<!-- Navbar Header -->
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <h2>Logo</h2>
        </div>
        <div class="col-md-7">
                <div id="custom-search-input">
                        <div class="input-group col-md-12">
                            <input type="text" class="  search-query form-control" placeholder="Search" />
                            <span class="input-group-btn">
                                <button class="btn btn-danger" type="button">
                                    <i class=" fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
            </div>
            <div class="col-md-3 text-right">
                    <router-link class="btn btn-link" :to="'/login'">Login</router-link>
                    <router-link class="btn btn-primary" :to="'/get-started'">Get Started</router-link>
                </div>
    </div>
</div>
<!-- End Navbar -->
