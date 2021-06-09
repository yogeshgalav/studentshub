<div class="navbar fixed-top">
    <div class="row col-md-12 nav-items">
        <div class="navbar-brand">
            <a href="/">
                <img src="{{asset('/images/logo.png') }}" alt="Student Hub" />
            </a>
        </div>
        <div class="search-bar col-md-6">
            @include('includes.search-form')
        </div>
        <div class="notification-dropdown">
            <notifications-dropdown></notifications-dropdown>
        </div>
        <div class="profile-dropdown">
            @include('includes.profile-dropdown')
        </div>
    </div>

    <!-- mobile header -->
    <div>
        <div class="mobile_navbar" id="header_mobile">

            <button type="button" id="nav-toggle" class="btn btn-sm btn-default border-radius-12"
                @click="toggleSidebar($event)"><i class="fa fa-bars alignment ml-2" aria-hidden="true"></i>
            </button>

            <div class="dropdown">
                <button class="btn btn-sm btn-default border-radius-12 dropdown-toggle" type="button"
                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span><i class="fa fa-search alignment" aria-hidden="true"></i></span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @include('includes.search-form')
                </div>

            </div>

            <div class="dropdown" style="margin-right:40px">
                <notifications-dropdown></notifications-dropdown>
            </div>

            <div class="nav-item">
                @include('includes.profile-dropdown')
            </div>

        </div>

    </div>

</div>