<template>
    <div class="bg-gray">
   <div class="container category-filter cat_pad">
        <div class="cat">
        <div class="col-md-12 text-center" v-if="categories.length">
            <VueSlickCarousel  :arrows="true" v-bind="slickOptions" ref="slick" class="slick-p" >
                    <a :href="'/category/'+category.category_url" class="btn btn-white cat_btn" v-for="(category,index) in categories" :key="index">{{category.name}}</a>
  </VueSlickCarousel >
        </div>
    </div>
   </div>
    </div>
</template>
<style scoped>

.cat_pad {
    padding: 30px 0;
}
  .slick-slide {
    margin: 0 5px;
  }
  /* the parent */
  .slick-list {
    margin: 0 -5px;
  }
.slick-slider .slick-next
{
    -webkit-appearance: none;
    outline: 0;
    background: transparent;
    border: 0;
    width: 38px;
    height: 38px;
    padding: 10px;
    border-radius: 50%;
    position: absolute;
    z-index: 3000;
    right: -25px;
    box-shadow: 3px 2px 3px #eee;
    top: 12px;
}
.slick-prev:before, .slick-next:before {
  font-family: 'slick';
    font-size: 30px !important;
    line-height: 1;
    color: #171717 !important;
}
.slick-slide {
    margin: 0 5px !important;
}
</style> 

<script>
//import VueSlickCarousel from 'vue-slick-carousel'
// optional style for arrows & dots
//import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

 import VueSlickCarousel from 'vue-slick-carousel'
  import 'vue-slick-carousel/dist/vue-slick-carousel.css'
  // optional style for arrows & dots
  import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css';
  import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'

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
          prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-arrow-left"></i></button>',
          nextArrow: '<button type="button" class="slick-next"><i class="fa fa-arrow-right"></i></button>',
        variableWidth: true,
        infinite: false,
        responsive: [
          {
            breakpoint: 768,
            settings: {            
              arrows: true,
              slidesToShow: 1,
              slidesToScroll: 1,
              width:200,
            }
          }
        ]
        },
        }
    },
}
</script>

