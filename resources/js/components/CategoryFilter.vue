<template>
    <div class="bg-gray">
   <div class="container ptb-20">
        <div class="row">
        <div class="col-md-12 text-center">
            <carousel :per-page="8" :step-jump="2" :slides="$store.state.explore.categories">
    <template slot-scope="props">
                    <a href="#" class="btn btn-white">{{props.slide.Subject_name}}</a>
   </template>
  </carousel>
        </div>
    </div>
   </div>
    </div>
</template>
<style scoped>
.leftnav {
    transform: translateY(0%) translateX(130%);
}
.rightnav {
    transform: translateY(0%) translateX(-130%);
}

</style>

<script>
import {mapState} from 'vuex';
import Carousel from './Carousel';
import Slick from 'vue-slick';

export default {
    components: {
    Carousel,
    Slick,
    },
    computed:{
		...mapState({
			'categories': state=>state.explore.categories,
		}),
	},
    data(){
        return {
            slickOptions: {
                 dots: true,
        arrows: false,
        mobileFirst: true,
        infinite: false,
        responsive: [
          {
            breakpoint: 768,
            settings: {            
              arrows: true,
              slidesToShow: 3
            }
          }
        ]
        },
        }
    },
    mounted(){
          this.initSlider();
        // this.$refs.slick.slick({
        //     infinite: true,
        //     slidesToShow: 3,
        //     slidesToScroll: 3
        // });
    },
    watch: {
    categories() {
      this.destroySlider();
      this.$nextTick( () => {
        this.initSlider();  
      });      
    }
  },
    methods:{
          initSlider() {
      $(this.$el).slick( this.sliderOptions );
    },
    destroySlider() {
      $(this.$el).slick('unslick');
    }
        
    },
}
</script>
