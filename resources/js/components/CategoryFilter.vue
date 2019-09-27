<template>
    <div class="bg-gray">
   <div class="container ptb-20">
        <div class="row">
        <div class="col-md-12 text-center">
            <slick :options="slickOptions" ref="slick" >
                    <a :href="'/explore/'+category.Subject_name" class="btn btn-white" v-for="(category,index) in categories" :key="index">{{category.Subject_name}}</a>
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
  /* the parent */
  .slick-list {
    margin: 0 -5px;
  }


</style>

<script>
import Slick from 'vue-slick';

export default {
    components: {
    Slick,
    },
    props:['categories'],
    
    data(){
        return {
            slickOptions: {
                 dots: false,
        arrows: true,
        mobileFirst: true,
          centerPadding: '60px',
          prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-arrow-left"></i></button>',
          nextArrow: '<button type="button" class="slick-next"><i class="fa fa-arrow-right"></i></button>',
        variableWidth: true,
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
