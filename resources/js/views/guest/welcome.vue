<template>
  <main>
    <explore-carousal-post />
    <category-filter :categories="categories" />
    <div
      class="main"
      style="background-image: url(/images/welcome/study-background.jpg);"
    >
      <div class="container row flex-coloumn m-auto justify-content-center align-items-center">
        <div class="welcome_banner">
          <h1 class="mb-2 fade-in-out">
            Use the Power of Data to Drive your Growth
          </h1>
          <div>
            <a
              class="btn btn-outline-light fade-in-out"
              href="/membership-plan"
            >
              Learn More <i class="fas fa-arrow-right fade-in-out" />
            </a>
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
                Your institute, like you've never seen it before
              </h2>
            </div>
            <div class="sections">
              <p class="font-weight-normal fade-in-out">
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
                src="/images/welcome/line.jpg"
                alt="dual-line-graph"
              >
            </div>
            <div class="col-12 col-md-3 image-div fade-in-out">
              <img
                src="/images/welcome/barline.jpg"
                alt="line-graph"
              >
            </div>
            <div class="col-12 col-md-3 image-div fade-in-out">
              <img
                src="/images/welcome/Dought.jpg"
                alt="line-graph"
              >
            </div>
            <div class="col-12 col-md-3 image-div fade-in-out">
              <img
                src="/images/welcome/multibar.jpg"
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
            src="/images/mobile.png"
            alt="Right Image"
          >
        </div>
        <div class="left col-md-8 align-self-center pl-5">
          <h3 class="text-white fade-in-out">
            The Best Educational App
          </h3>
          <p class="text-white fade-in-out">
            Educational App to boost the productivity of Students, Teachers, and Institutes. Learn about your progress, pain points, and student's field of interest.
          </p>
          <a
            href="https://play.google.com/store/apps/details?id=webviewgold.studentshub"
            class="play-store"
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
            Join the thousands of other institutes who benefits from our data analytics and digital classroom services.
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
    <site-footer />
  </main>
</template>
<style >
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
		},
	},
	computed:{
		...mapState({
			'categories': state=>state.guest.categories,
		}),

	},
	mounted(){
		this.getData();
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
			setInterval(() => {
				if(entry.target.childNodes[i].nodeName !== '#text') entry.target.childNodes[i].classList.remove('showText');
				i++;
			}, 200);

			console.log(entry);
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
};
</script>

