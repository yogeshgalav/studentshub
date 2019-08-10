<template>
    <main>
<carousel :per-page="1"  :mouse-drag="true" :center-mode="true" :pagination-position="'bottom-overlay'">
    <slide>
        <img src="/images/4.jpg"/>
    </slide>
    <slide>
      <img src="/images/4.jpg"/>
    </slide>
  </carousel>
  <category-filter></category-filter>
  <div class="container">
 <div class="row">
   <div class="col-md-12">
     <explore-top-post></explore-top-post>
   </div>
 </div>
 <div class="row">
   <div class="col-md-9">
    <home-post-container></home-post-container>
   </div>
   <div class="col-md-3">
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
import { Carousel, Slide } from 'vue-carousel';
import CategoryFilter from './../../components/CategoryFilter';
import ExploreTopPost from './../../components/ExploreTopPost';
import HomePostContainer from './../../components/HomePostContainer';
import ExploreSidebar from './../../components/ExploreSidebar';
import ExploreBottomPost from './../../components/ExploreBottomPost';
import SiteFooter from './../../components/SiteFooter';
 
export default {
    components: {
    Carousel,
    Slide,
    CategoryFilter,
    ExploreTopPost,
    HomePostContainer,
    ExploreSidebar,
    ExploreBottomPost,
    SiteFooter
  }
}
</script>

