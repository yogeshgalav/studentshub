<template>
    <div class="bg-gray pt-80">
            <VueSlickCarousel  v-bind="slickOptions" ref="slick">
                    <a href="#" class="btn btn-white"><img v-lazy="'/images/slider.jpg'" /></a>
                    <a href="#" class="btn btn-white"><img v-lazy="'/images/5.jpg'"/></a>
                     <template #prevArrow="arrowOption">
      <div class="custom-arrow">
        {{ arrowOption.currentSlide }}/{{ arrowOption.slideCount }}
      </div>
    </template>

    <template #customPaging="page">
      <div class="text-left">
        {{ page }}
      </div>
    </template>
  </VueSlickCarousel>
    </div>
</template>
<style scoped>
  .slick-slide {
    margin: 0 5px;
  }
  .pt-80
  {
    padding-top:80px;
  }
  /* the parent */
  .slick-list {
    margin: 0 -5px;
  }

.slick-dots {
  display:flex;
  justify-content: left;
}
</style>

<script>
import {mapState} from 'vuex';

import VueSlickCarousel from 'vue-slick-carousel'
// optional style for arrows & dots
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'
export default {
    components: {
    VueSlickCarousel,
    },
    computed:{
		...mapState({
			'posts': state=>state.explore.posts.ExploreCarousalPost,
		}),
	},
    data(){
        return {
            slickOptions:{
                adaptiveHeight:false,
                dots: true,
                dotsClass:"slick-dots",
                arrows: false,
                infinite: true,
                speed: 500,
                fade: true,
                cssEase: 'linear'
            }
        }
    },
    mounted(){
        //   this.initSlider();
        // this.$refs.slick.slick({
        //     infinite: true,
        //     slidesToShow: 3,
        //     slidesToScroll: 3
        // });
    },
    watch: {
    ExploreCarousalPost() {
        this.reInit(); 
    }
  },
    methods:{
    
    reInit() {
            // Helpful if you have to deal with v-for to update dynamic lists
            this.$nextTick(() => {
                this.$refs.slick.reSlick();
            });
        },   
    },
}
</script>
