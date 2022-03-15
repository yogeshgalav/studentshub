<template>
  <main>
    <explore-carousal-post />
    <div class="do_you_know text-white text-center p-4">
      <h3 class="m-0-a">Do you know what is your Interest Field?</h3>  
      <div class="find_out">
        <h3>Find out</h3>
      </div>
    </div>
    <category-filter :categories="categories" />
    <div
      v-lazy:background-image="'/images/welcome/study-background.jpg'"
      class="main"
    >
      <div class="container row flex-coloumn m-auto justify-content-center align-items-center">
        <div class="welcome_banner">
          <h1 class="mb-2 fade-in-out">
            Use the Power of Data to Drive your Growth
          </h1>
          <div>
            <router-link
              class="btn btn-outline-light fade-in-out"
              href="/get-started"
            >
              Get Started <i class="fas fa-arrow-right fade-in-out" />
            </router-link>
          </div>
        </div>
      </div>
    </div>
    <div class="white-space" />
    <div>
      <div
        style="background-color:#f2f2f2;"
        class="container p-0 text-div"
      >
        <div class="pt-5 pl-4 pb-2 mb-1 row justify-content-md-between align-items-center mr-0 ml-0">
          <div class="col-md-6">
            <div class="sections">
              <h2 class="font-weight-bold fade-in-out">
                Want your Institute to outstand from others?
              </h2>
            </div>
            <div class="sections">
              <p class="font-weight-normal fade-in-out">
                Our next generation reporting system will give your Institute new superpowers,
                <br>
                And will provide meaningfull insights to your teachers, students and their parents.
                <br>
                Book a demo now and get started with free account.
              </p>
            </div>
          </div>
          <div class="sections col-md-4">
            <a
              href="/membership-plan"
              class="btn btn-outline-dark fade-in-out"
            >
              Learn More <i class="fas fa-arrow-right" />
            </a>
          </div>
        </div>
        <div class="pt-2 container graph-div">
          <div class="row img-row img-transition">
            <div class="col-12 col-md-3 image-div fade-in-out">
              <img
                v-lazy="'/images/welcome/line.jpg'"
                alt="dual-line-graph"
              >
            </div>
            <div class="col-12 col-md-3 image-div fade-in-out">
              <img
                v-lazy="'/images/welcome/barline.jpg'"
                alt="line-graph"
              >
            </div>
            <div class="col-12 col-md-3 image-div fade-in-out">
              <img
                v-lazy="'/images/welcome/Dought.jpg'"
                alt="line-graph"
              >
            </div>
            <div class="col-12 col-md-3 image-div fade-in-out">
              <img
                v-lazy="'/images/welcome/multibar.jpg'"
                alt="line-graph"
              >
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="white-space-bottom" />
    <div style="background-color: #2727cced;">
      <div class="container row m-auto">
        <div class="right col-md-4 fade-in-out">
          <img
            v-lazy="'/images/mobile.png'"
            alt="Right Image"
          >
        </div>
        <div class="left col-md-8 align-self-center pl-5">
          <h3 class="text-white fade-in-out">
            The Best Educational Social Network
          </h3>
          <p class="text-white fade-in-out">
            Social Network App which helps you to connect with Students, Teachers, and Institutes. Explore Courses, Subjects and Interest Fields.
          </p>
          <a
            href="https://play.google.com/store/apps/details?id=webviewgold.studentshub"
            class="play-store"
          ><img
            v-lazy="'/images/googleplay.png'"
            alt="play store"
            height="100px"
            width="300px"
          >
          </a>
        </div>
      </div>
    </div>
    <div style="background: #f2f2f2;">
      <div
        class="row align-items-center container m-auto"
        style="max-width: 90%; padding: 25px 0;"
      >
        <div class="col-md-3 p-0">
          <h3>
            Add Your Institute
          </h3>
        </div>
        <div class="col-md-6 p-0">
          <p class="mb-0">
            Join the thousands of other institutes who benefits from our Marketing and Branding services.
          </p>
        </div>
        <div class="col-md-3 text-right p-0 fade-in-out">
          <a
            href="/membership-plan#requestDemo"
            class="btn btn-primary"
          >
            Request a Demo <i class="fas fa-arrow-right" />
          </a>
        </div>
      </div>
    </div>
  </main>
</template>
<style scoped>
.showText{
    opacity: 0;
    transform: translateY(8rem);
}
.fade-in-out{
    transition-duration: 0.7s;
}
.white-space{
  height: 150px;
  background: #fff;
}
        .image-div img{
            box-shadow: 0 0 10px #969696;
        }

        .image-div img {
            width: 90%;
            display: block;
            margin: 0 auto;
        }

        .graph-div {
            position: absolute;
            bottom: -55px;
        }

        .text-div {
            background-color: #f2f2f2;
            position: relative;
            min-height: 350px;
        }
h1 {
            font-family: 'Josefin Sans', sans-serif;
            color: #fff;
            font-size: 3.7em;
            font-weight: 700;
            text-align: center;
        }
		.play-store{
			margin-left: -22px;
		}
        .welcome_banner {
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 50vh;
            align-items: center;
        }

        .right img {
                        width: 100%;
            height: auto;
        }

        .right {
            position: relative;
            margin-top: -50px;
        }
		.white-space-bottom{
			height: 220px;
		}
@media (max-width: 768px){
  .right img {
            width: 60%;
            height: auto;
        }
        .right {
            position: relative;
            text-align: center;
        }
		.white-space-bottom{
			height: 120px;
		}
        .left{
          margin-top: 20px;
          text-align: center;
        }
        .graph-div {
            position: static;
        }
		.image-div{
			margin-bottom: 20px;
		}
		.text-right{
			text-align: left !important;
		}
		.white-space{
			display: none;
		}
}
.do_you_know {
  overflow: hidden;
  background: #10069f;
  color: white;
}
.find_out {
  top: 100%;
  position: relative;
  transition: all .3s ease-out;
  height: 100%;
}

.do_you_know:hover > .find_out{
  top: 0;
}
</style>
<script>
import {mapState} from 'vuex';
import CategoryFilter from '../category/CategoryFilter';
import ExploreCarousalPost from '../post-containers/ExploreCarousalPost';
import NoSidebarLayout from '@/Layouts/NoSidebarLayout.vue';

export default {
	layout: NoSidebarLayout,
	components: {
		CategoryFilter,
		ExploreCarousalPost,
	},
	computed:{
		...mapState({
			'categories': state=>state.guest.categories,
		}),

	},
	mounted(){
		this.getData();
		this.startAnimation();
	},
	methods:{
		getData(){
			this.$store.dispatch('guest/getWelcomePageContent');
		},
		startAnimation(){
			// text transition
			const transitionText = document.querySelectorAll('.fade-in-out');
			const transitionTextObserver = new IntersectionObserver((entries,observer)=>{
				const [entry] = entries;
				if(!entry.isIntersecting) return;
				else{
					entry.target.classList.remove('showText');
				}
				observer.unobserve(entry.target);
			},{
				root:null,
				threshold:0.10,
			});
			transitionText.forEach(el=>{
				transitionTextObserver.observe(el);
				el.classList.add('showText');
			});

			// image transitions one by one
			const transitionImg = document.querySelector('.img-transition');

			const transitionImgObserver = new IntersectionObserver((entries,observer)=>{
				let [entry] = entries;
				if(!entry.isIntersecting) return;

				let i = 0;
				let animationInterval = setInterval(() => {
					if(entry.target.childNodes[i] && entry.target.childNodes[i].nodeName !== '#text'){
						entry.target.childNodes[i].classList.remove('showText');
					}
					if(i===10){
						clearInterval(animationInterval);
					}
					i++;
				}, 200);

				observer.unobserve(entry.target);
			},{
				root:null,
				threshold:0.30,
			});
			transitionImgObserver.observe(transitionImg);
			transitionImg.childNodes.forEach(node=>{
				if(node.nodeName === '#text') return;
				node.classList.add('showText');
			});

		}
	},
};
</script>

