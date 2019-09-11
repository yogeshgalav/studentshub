<template>
    <div class="bg-gray pt-80">
   <div class="container ptb-20">
        <div class="row">
        <div class="col-md-12 text-center">
            <slick :options="slickOptions" ref="slick" >
                    <a href="#" class="btn btn-white"><img v-lazy="'/images/slider.jpg'" /></a>
                    <a href="#" class="btn btn-white"><img v-lazy="'/images/5.jpg'"/></a>
                    <a href="#" class="btn btn-white"><img v-lazy="'/images/slider.jpg'" /></a>
  </slick>
        </div>
    </div>
   </div>
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
  justify-content: center;
}
</style>

<script>
import {mapState} from 'vuex';
import Slick from 'vue-slick';

export default {
    components: {
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
			 accessibility: true,
			infinite: true,
			dots: true,
			autoplay: true,
			arrows: false,
			autoplaySpeed: 2000,
			slidesToShow: 1,
			},
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
    categories() {
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
