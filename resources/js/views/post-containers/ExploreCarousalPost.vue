<template>
    <div class="bg-white pt-80 pb-80">
            <carousel>
                <template slot="step1">
                  <div class="text-center slider-caption">
                  <img v-lazy="'/images/student.svg'" />
                  <h5 class="mt-3 mb-1">Student </h5>
                  <p>Contrary to popular belief, Lorem Ipsum is not simply random text. <br/>
                     It has roots in a piece of classical Latin making it over 2000 years old.</p>
                  </div>
                </template>
                <template slot="step2">
                  <div class="text-center slider-caption">
                  <img v-lazy="'/images/student.svg'" />
                  <h5 class="mt-3 mb-1">Student </h5>
                  <p>Contrary to popular belief, Lorem Ipsum is not simply random text. <br/>
                     It has roots in a piece of classical Latin making it over 2000 years old.</p>
                  </div>
                </template>
            </carousel>
    </div>
</template>
<style scoped>
  .slick-slide {
    margin: 0 5px;
  }
  .slider-caption h5, p {

      font-family: 'Open Sans'  !important;
  }
  .pt-80
  {
    padding-top:120px;
  }
  .pb-80 {
    padding-bottom: 40px;
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

import Carousel from '../../components/Carousel.vue';

export default {
    components: {
      Carousel,
    },
}
</script>
