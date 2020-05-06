<template>
    <div class="banner_post pt-80 pb-80 ">
    <div class="container">
            <carousel>
                <template slot="step1" class="home_slide">
                  <div class="row">
                    <div class="col-md-6">
                            <div class="text-center slider-caption">
                      
                        <h5 class="mt-3 mb-1">Student </h5>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. <br/>
                          It has roots in a piece of classical Latin making it over 2000 years old.</p>
                        </div>


                    </div>
                      <div class="col-md-6">
                      <div class="text-center slider-caption">
                  <img v-lazy="'/images/student.svg'"  class="slide_img_home">
                  </div>

                    </div>
                   </div> 
                </template>
                <template slot="step2" class="home_slide">
                  <div class="row">
                    <div class="col-md-6">
                            <div class="text-center slider-caption">
                      
                        <h5 class="mt-3 mb-1">Student </h5>
                        <p>Hello how are you..Contrary to popular belief, Lorem Ipsum is not simply random text. <br/>
                          It has roots in a piece of classical Latin making it over 2000 years old.</p>
                        </div>


                    </div>
                      <div class="col-md-6">
                      <div class="text-center slider-caption">
                  <img v-lazy="'/images/student.svg'"  class="slide_img_home">
                  </div>

                    </div>
                   </div> 
                </template>
                <template slot="step3" class="home_slide">
                  <div class="row">
                    <div class="col-md-6">
                            <div class="text-center slider-caption">
                      
                        <h5 class="mt-3 mb-1">Student </h5>
                        <p>Hello how are you..Contrary to popular belief, Lorem Ipsum is not simply random text. <br/>
                          It has roots in a piece of classical Latin making it over 2000 years old.</p>
                        </div>


                    </div>
                      <div class="col-md-6">
                      <div class="text-center slider-caption">
                  <img v-lazy="'/images/student.svg'" class="slide_img_home" >
                  </div>

                    </div>
                   </div> 
                </template>
            </carousel>
            </div>
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
.banner_post{background-color:#f6f6f6;}

</style>

<script>
import Carousel from '../../components/Carousel.vue';

export default {
    components: {
      Carousel,
    },
}
</script>
