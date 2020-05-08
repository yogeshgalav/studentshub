<template>
    <div class="bg-gray">
   <div class="container category-filter cat_pad">
        
        <!-- <div class="col-md-12 text-center" v-if="categories.length">
            <VueSlickCarousel  :arrows="true" v-bind="slickOptions" ref="slick" class="slick-p" >
                    <a :href="'/category/'+category.category_url" class="btn btn-white cat_btn" v-for="(category,index) in categories" :key="index">{{category.name}}</a>
  </VueSlickCarousel >
        </div> -->
        <div class="cat_menu">
            <div class="cat_menu_list">
                    <a :href="'/category/'+category.category_url" 
                    class="btn btn-white cat_btn" 
                    v-for="(category,index) in categories"
                    :style="'background:'+getBack(index)" 
                    :key="index">
                    {{category.name}}
                    </a>

            </div>
        
        </div>
    
   </div>
    </div>
</template>
<style scoped>

.cat_pad {
    padding: 30px 0;
}

</style> 

<script>
//import VueSlickCarousel from 'vue-slick-carousel'
// optional style for arrows & dots
//import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

//  import VueSlickCarousel from 'vue-slick-carousel'
//   import 'vue-slick-carousel/dist/vue-slick-carousel.css'
//   // optional style for arrows & dots
//   import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css';

export default {
    // components: {
    // VueSlickCarousel,
    // },
    props:['categories'],
    
    data(){
        return {
          bakcolors:['#001f3f','#0074D9','#2ECC40','#FF4136','#85144b','#111111'],
          aftcolors:['#39CCCC','#7FDBFF','#01FF70','#FF851B','#F012BE','#AAAAAA'],
        //     slickOptions: {
        //          dots: false,
        // arrows: true,
        // mobileFirst: true,
        //   centerPadding: '60px',
        //   prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-arrow-left"></i></button>',
        //   nextArrow: '<button type="button" class="slick-next"><i class="fa fa-arrow-right"></i></button>',
        // variableWidth: true,
        // infinite: false,
        // responsive: [
        //   {
        //     breakpoint: 768,
        //     settings: {            
        //       arrows: true,
        //       slidesToShow: 1,
        //       slidesToScroll: 1,
        //       width:200,
        //     }
        //   }
        // ]
        // },
        }
    },
    methods:{
      getBack(index){
        let key=index>6 ? index%6 : index;
        return this.bakcolors[key];
      }
    }
}
</script>

