<template>
    <div class="bg-gray">
   <div class="container ptb-20">
        <div class="row">
        <div class="col-md-12 text-center" v-if="categories.length">
            <VueSlickCarousel  :arrows="true" v-bind="slickOptions" ref="slick" >
                    <a :href="'/explore/'+category.subject_url" class="btn btn-white" v-for="(category,index) in categories" :key="index">{{category.Subject_name}}</a>
  </VueSlickCarousel >
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
import VueSlickCarousel from 'vue-slick-carousel'
// optional style for arrows & dots
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'
export default {
    components: {
    VueSlickCarousel,
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
}
</script>
