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
    <welcome-post-container ></welcome-post-container>
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
<style scoped>
.card-title {
  font-family: 'Open Sans'  !important;
}
</style>
<script>
import {mapState} from 'vuex';
import CategoryFilter from '../category/CategoryFilter';
import ExploreCarousalPost from '../post-containers/ExploreCarousalPost';
import ExploreTopPost from '../post-containers/ExploreTopPost';
import WelcomePostContainer from '../post-containers/WelcomePostContainer';
import ExploreSidebar from '../post-containers/ExploreSidebar';
import ExploreBottomPost from '../post-containers/ExploreBottomPost';
import SiteFooter from '../footer/SiteFooter';
 
export default {
    components: {
    CategoryFilter,
    ExploreCarousalPost,
    ExploreTopPost,
    WelcomePostContainer,
    ExploreSidebar,
    ExploreBottomPost,
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
}
</script>

