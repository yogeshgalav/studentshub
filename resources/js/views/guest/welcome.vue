<template>
    <main>

    <explore-carousal-post></explore-carousal-post>
<br/>
    <category-filter :categories="categories"></category-filter>
  <div class="container">
 <div class="row">
   <div class="col-md-12">
     <explore-top-post></explore-top-post>
   </div>
 </div>
 <div class="row">
   <div class="container">
     <div class=" divider mb-5">

       </div>
     </div>
   </div>
 <div class="row">
   <div class="col-md-8">
     <div class="row">
    <div class="col-md-12">
        <h3 class="card-title weight-800 text-black mt-3 mb-3">
            Latest Post
        </h3>
    </div>
</div>
    <guest-post-container :posts="home_posts"></guest-post-container>
   </div>
   <div class="col-md-4">
      <explore-sidebar></explore-sidebar>
   </div>
 </div>
  </div>
    
<div class="bg-gray ptb-50">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <explore-bottom-post></explore-bottom-post>
            </div>
          </div>
        </div>
        </div>  
     
        <site-footer></site-footer>
    </main>
</template>

<script>
import {mapState} from 'vuex';
// import { Carousel, Slide } from 'vue-carousel';
import Carousel from '../explore/Carousel';
import CategoryFilter from '../category/CategoryFilter';
import ExploreCarousalPost from '../explore/ExploreCarousalPost';
import ExploreTopPost from '../explore/ExploreTopPost';
import GuestPostContainer from '../post/GuestPostContainer';
import ExploreSidebar from '../explore/ExploreSidebar';
import ExploreBottomPost from '../explore/ExploreBottomPost';
import SiteFooter from '../footer/SiteFooter';
 
export default {
    components: {
    Carousel,
    // Slide,
    CategoryFilter,
    ExploreCarousalPost,
    ExploreTopPost,
    GuestPostContainer,
    ExploreSidebar,
    ExploreBottomPost,
    SiteFooter
  },
  methods:{
    getData(){
      this.$store.dispatch('explore/getExplorePageContent');
    }
  },
  computed:{
		...mapState({
			'categories': state=>state.explore.categories,
			'home_posts': state=>state.explore.posts.HomePostContainer,
		}),
	},
  mounted(){
    this.getData();
  }
}
</script>

