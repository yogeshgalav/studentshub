<template>
    <div class="bg-gray">
   <div class="container category-filter ptb-20">
        <div class="row">
        <div class="col-md-12 text-center" v-if="categories.length">
            <VueSlickCarousel  :arrows="true" v-bind="slickOptions" ref="slick" >
                    <a :href="'/category/'+category.category_url" class="btn btn-white" v-for="(category,index) in categories" :key="index">{{category.name}}</a>
  </VueSlickCarousel >
        </div>
    </div>
   </div>
    </div>
</template>
<style scoped>
.category-filter .btn {
  font-weight: 400;
  font-size:14px;
  margin: 0 5px;
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
    opacity: 0.75;
    color: #171717 !important;
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
