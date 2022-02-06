<template>
  <div class="bg-gray">
    <div class="container category-filter cat_pad">
      <div class="text-center mt-2 mb-2">
        <h3> Categories</h3>
      </div>
      <div class="cat_menu">
        <div class="cat_menu_list">
          <router-link
            v-for="(category,index) in categories"
            :key="index"
            :href="'/category/'+category.category_url"
            class="button-28 cat_btn"
          >
            {{ category.name }}
          </router-link>
        </div>
      </div>

      <div class="category_btn justify-center mb-2 mt-3">
        <router-link :href="'/get-started'" style="padding:15px 80px;">
          Find Out &nbsp;&nbsp;<span><i
            class="fa fa-arrow-right"
            aria-hidden="true"
          /></span>
        </router-link>
      </div>
    </div>
  </div>
</template>
<style scoped>

/* CSS */
.button-28 {
  appearance: none;
  background-color: transparent;
  border: 2px solid #1A1A1A;
  border-radius: 15px;
  box-sizing: border-box;
  color: #3B3B3B;
  cursor: pointer;
  display: inline-block;
  font-family: Roobert,-apple-system,BlinkMacSystemFont,"Segoe UI",Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
  font-size: 16px;
  font-weight: 600;
  line-height: normal;
  min-height: 60px;
  min-width: 0;
  outline: none;
  padding: 16px 24px;
  text-align: center;
  text-decoration: none;
  transition: all 300ms cubic-bezier(.23, 1, 0.32, 1);
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  will-change: transform;
}

.button-28:disabled {
  pointer-events: none;
}

.button-28:hover {
  color: #fff;
  background-color: #1A1A1A;
  box-shadow: rgba(0, 0, 0, 0.25) 0 8px 15px;
  transform: translateY(-2px);
}

.button-28:active {
  box-shadow: none;
  transform: translateY(0);
}
</style>

<script>
// //import VueSlickCarousel from 'vue-slick-carousel'
// // optional style for arrows & dots
// //import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

// // import VueSlickCarousel from 'vue-slick-carousel'
// import 'vue-slick-carousel/dist/vue-slick-carousel.css'
// // optional style for arrows & dots
// import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css';

export default {
	components: {
		// VueSlickCarousel,
	},
	props: ['categories'],

	data() {
		return {
			colors: ['001f3f/39CCCC', '0074D9/7FDBFF', '2ECC40/01FF70', 'FF4136\FF851B', '85144b\F012BE',
				'111111\AAAAAA'
			],
			slickOptions: {
				dots: false,
				arrows: true,
				mobileFirst: true,
				centerPadding: '60px',
				prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-arrow-left"></i></button>',
				nextArrow: '<button type="button" class="slick-next"><i class="fa fa-arrow-right"></i></button>',
				variableWidth: true,
				infinite: false,
				responsive: [{
					breakpoint: 768,
					settings: {
						arrows: true,
						slidesToShow: 1,
						slidesToScroll: 1,
						width: 200,
					}
				}]
			},
		};
	},
};

</script>
