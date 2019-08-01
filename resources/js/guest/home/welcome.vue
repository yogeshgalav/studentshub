<template>
    <main>
<carousel :per-page="1"  :mouse-drag="true" :center-mode="true" :pagination-position="'bottom-overlay'">
    <slide>
        <img src="/images/session_landing_page_background.jpg"/>
      Slide 1 Content
    </slide>
    <slide>
      Slide 2 Content
    </slide>
  </carousel>
  <category-filter></category-filter>
      <explore-top-post></explore-top-post>
      <home-post-container></home-post-container>
      <explore-sidebar></explore-sidebar>
        <explore-bottom-post></explore-bottom-post>
        <site-footer></site-footer>
    </main>
</template>
<script>
import { Carousel, Slide } from 'vue-carousel';
 
export default {
    components: {
    Carousel,
    Slide
  }
}
</script>

