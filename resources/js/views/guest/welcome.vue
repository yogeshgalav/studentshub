<template>
  <main>
    <explore-carousal-post />
    <category-filter :categories="categories" />
    <div
      class="main"
      style="background-image: url(/images/istockphoto-948623158-612x612.jpg);"
    >
      <div class="container row flex-coloumn m-auto">
        <div class="welcome_banner">
          <h1>Use the power of data to drive your growth </h1>
          <div>
            <button class="btn btn-outline-light">
              Learn More
            </button>
          </div>
        </div>
      </div>
    </div>
    <div style="background-color: #2727cced;">
      <div class="container row m-auto">
        <div class="right col-md-4 m-0">
          <img
            src="http://103.93.17.146/clickheld/assets/site/images/app.png"
            alt="Right Image"
          >
        </div>
        <div class="left col-md-8 align-self-center pl-5">
          <h3 class="text-white">
            The Best Educational App
          </h3>
          <p class="text-white">
            Educational App to boost the productivity of Students, Teachers, and Institutes. Learn about your progress, pain points, and student's field of interest.
          </p>
          <a
            href="https://play.google.com/store/apps/details?id=webviewgold.studentshub"
            class=""
          ><img
            src="/images/googleplay.png"
            alt="play store"
            height="100px"
            width="300px"
          >
          </a>
        </div>
      </div>
    </div>
    <div class="bg-dark">
      <div
        class="row align-items-center container m-auto"
        style="height: 100px; max-width: 90%;"
      >
        <div class="col-md-3 p-0">
          <h3 class="text-white">
            Add Your Institute
          </h3>
        </div>
        <div class="col-md-6 p-0">
          <p class="text-white">
            Join the thousands of other institutes who benefits from our data analytics and digital classroom services.
          </p>
        </div>
        <div class="col-md-3 text-right p-0">
          <a
            href="#"
            class="btn btn-primary"
          >
            Request a Demo
          </a>
        </div>
      </div>
    </div>  
    <site-footer />
  </main>
</template>
<style scoped>
h1 {
            font-family: 'Josefin Sans', sans-serif;
            color: #fff;
            font-size: 3.7em;
            font-weight: 700;
            text-align: center;
        }
        .welcome_banner {
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 60vh;
            align-items: center;
        }

        .right img {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 400px;
            height: 537px;
        }

        .right {
            position: relative;
            height: 436px;
        }
</style>
<script>
import {mapState} from 'vuex';
import CategoryFilter from '../category/CategoryFilter';
import ExploreCarousalPost from '../post-containers/ExploreCarousalPost';
import SiteFooter from '../footer/SiteFooter';
 
export default {
	components: {
		CategoryFilter,
		ExploreCarousalPost,
		SiteFooter
	},
	methods:{
		getData(){
			this.$store.dispatch('guest/getWelcomePageContent');
		}
	},
	computed:{
		...mapState({
			'categories': state=>state.guest.categories,
		}),
	},
	mounted(){
		this.getData();
	}
};
</script>

