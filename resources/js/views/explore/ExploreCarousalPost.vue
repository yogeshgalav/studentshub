<template>
    <div class="bg-gray pt-80">
            <carousel>
                <template slot="step1">
                  <div>
                  <img v-lazy="'/images/slider.jpg'" />
                  </div>
                </template>
                <template slot="step2">
                  <div>
                  <img v-lazy="'/images/5.jpg'" />
                  </div>
                </template>
                <template slot="step3">
                  step3
                </template>
            </carousel>
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
  justify-content: left;
}
</style>

<script>
import {mapState} from 'vuex';

import Carousel from './Carousel';

export default {
    components: {
      Carousel,
    },
}
</script>
