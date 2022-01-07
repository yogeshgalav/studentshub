<template>
  <div class="navbar fixed-top">
    <div
      v-if="AuthUser"
      class="container-fluid"
    >
      <div class="nav-items">
        <div class="navbar-brand">
          <a href="/">
            <img
              src="/images/logo.png"
              alt="Student Hub"
            >
          </a>
        </div>
        <div class="search-bar col-md-6">
          <search-form />
        </div>
        <div class="notification-dropdown">
          <a
            href="/notifications"
            class="btn"
          >
            <i class="far fa-bell notification-icon" />
          </a>
        </div>
        <div class="profile-dropdown dropleft">
          <profile-dropdown />
        </div>
      </div>

      <!-- mobile header -->
      <div
        id="mobileNavbar"
        class="mobile_navbar"
      >
        <div
          v-if="showMobileLogoBar"
          class="mobile-navbar-brand"
        >
          <a href="/">
            <img
              src="/images/logo.png"
              alt="Student Hub"
            >
          </a>
        </div>
        <div class="mobile-nav-items">
          <button
            id="nav-toggle"
            type="button"
            class="btn"
            @click="toggleSidebar($event)"
          >
            <i
              class="fa fa-bars alignment ml-2"
              aria-hidden="true"
            />
          </button>

          <div class="dropdown">
            <button
              id="dropdownMenuButton"
              class="dropdown-toggle btn"
              type="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <span><i
                class="fa fa-search alignment"
                aria-hidden="true"
              /></span>
            </button>
            <div
              class="dropdown-menu"
              aria-labelledby="dropdownMenuButton"
            >
              <search-form />
            </div>
          </div>

          <div class="dropdown">
            <a
              href="/notifications"
              class="btn"
            >
              <i
                class="far fa-bell notification-icon"
                style="margin-top:4px"
              />
            </a>
          </div>

          <div class="nav-item dropleft">
            <profile-dropdown2 />
          </div>
        </div>
      </div>
    </div>

    <!-- guest navbar uathenticated navbar -->
    <div
      v-else
      class="container-fluid"
    >
      <div class="guest-navbar">
        <div class="guest-navbar-brand">
          <a href="/">
            <img
              src="/images/logo.png"
              alt="Student'sHUB"
            >
          </a>
        </div>
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <div class="line" />
          <div class="line" />
          <div class="line" />
        </button>

        <div class="nav-item search_box">
          <search-form />
        </div>
        <div class="guest-nav-items">
          <div class="nav-item nav-login">
            <router-link
              class="btn btn-link text-blue"
              :href="'/login'"
            >
              Login <i class="fas fa-arrow-right" />
            </router-link>
          </div>
          <div class="nav-item">
            <router-link
              class="btn btn-primary"
              :href="'/get-started'"
            >
              Get Started <i
                class="fas fa-arrow-right text-white"
              />
            </router-link>
          </div>
        </div>
      </div>
      <div
        id="navbarNav"
        class="collapse navbar-collapse"
      >
        <ul class="navbar-nav menu_head">
          <li class="nav-item  search_box">
            <search-form />
          </li>
          <div class="nav-login-get-started">
            <li class="nav-item nav-login">
              <router-link
                class="btn btn-link text-blue"
                :href="'/login'"
              >
                Login <i class="fas fa-arrow-right" />
              </router-link>
            </li>
            <li class="nav-item">
              <router-link
                class="btn btn-primary"
                :href="'/get-started'"
              >
                Get Started <i
                  class="fas fa-arrow-right text-white"
                />
              </router-link>
            </li>
          </div>
        </ul>
      </div>
    </div>
  </div>
</template>
<script>
import ProfileDropdown from'./ProfileDropdown.vue';
import ProfileDropdown2 from'./ProfileDropdown2.vue';
import SearchForm from'./SearchForm.vue';

export default {
	components:{
		ProfileDropdown,
		ProfileDropdown2,
		SearchForm
	},
	mounted(){
		var prevScrollpos = window.pageYOffset;
		window.addEventListener('scroll', ()=>{
			let headerMobile = document.getElementById('mobileNavbar');
			if (headerMobile){
				var currentScrollPos = window.pageYOffset;
				if (prevScrollpos > currentScrollPos) {
					this.showMobileLogoBar = true;
				} else {
					this.showMobileLogoBar = false;
				}
				prevScrollpos = currentScrollPos;
			}
		});
	} 
};
</script>
<style scoped>
@media (max-width: 768px) {
  .navbar .container-fluid { 
    padding: 0;
    margin: 0;
  }
}
</style>