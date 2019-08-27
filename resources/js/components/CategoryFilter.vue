<template>
    <div class="bg-gray">
   <div class="container ptb-20">
        <div class="row">
        <div class="col-md-12 text-center">
            <slick :options="slickOptions" ref="slick" >
                    <a href="#" class="btn btn-white" v-for="(category,index) in categories" :key="index">{{category.Subject_name}}</a>
  </slick>
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
.slick-slider .slick-prev
{
    -webkit-appearance: none;
    outline: 0;
    background: #fff;
    border: 0;
    width: 38px;
    height: 38px;
    padding: 10px;
    border-radius: 50%;
    position: absolute;
    z-index: 3000;
    left: -30px;
    box-shadow: 3px 2px 3px #eee;
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
                 dots: false,
        arrows: false,
        mobileFirst: true,
        infinite: false,
        responsive: [
          {
            breakpoint: 768,
            settings: {            
              arrows: true,
              slidesToShow: 8,
              slidesToScroll: 3,
              width:200,
            }
          }
        ]
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
