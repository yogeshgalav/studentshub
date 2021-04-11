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
    <div style="background-color:#f2f2f2;">
      <div
        class="container p-0 text-div"
      >
        <div class="pt-5 pl-5 pb-2 mb-1 row justify-content-md-between align-items-center">
          <div class="col-md-6">
            <div class="sections">
              <h2 class="font-weight-bold">
                Your institute, like you've never seen it before
              </h2>
            </div>
            <div class="sections">
              <p class="font-weight-normal">
                Our industry-leading educational analytics makes exploring your
                data
                and uncovering insights a
                cinch! Understand the dynamics of your institute and see where you need to focus your
                efforts.
              </p>
            </div>
          </div>
          <div class="sections col-md-4">
            <a
              href=""
              class="btn btn-primary"
            >
              Learn More
            </a>
          </div>
        </div>
        <div class="d-flex justify-content-around pt-2 container graph-div">
          <div class="image-div">
            <img
              src="./line.png"
              alt="dual-line-graph"
              height="200px"
              width="200px"
            >
          </div>
          <div class="image-div">
            <img
              src="./barline1.png"
              alt="line-graph"
              height="200px"
              width="200px"
            >
          </div>
          <div class="image-div">
            <img
              src="./Dought.png"
              alt="line-graph"
              height="200px"
              width="200px"
            >
          </div>
          <div class="image-div">
            <img
              src="./Multiple bar.png"
              alt="line-graph"
              height="200px"
              width="200px"
            >
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
        .image-div {
            height: 200px;
            width: 200px;
            padding: 10px;
            box-shadow: 0 0 10px #969696;
        }

        .image-div img {
            height: 100%;
            width: 100%;
        }

        .graph-div {
            position: absolute;
            bottom: -110px;
        }

        .text-div {
            background-color: #f2f2f2;
            position: relative;
            min-height: 500px;
        }
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

