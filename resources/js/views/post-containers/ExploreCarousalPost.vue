<template>
  <div class="banner_post pt-80 pb-80 ">
    <div class="container">
      <carousel>
        <template
          slot="step1"
          class="home_slide"
        >
          <div class="row">
            <div class="col-md-6">
              <div class="slider-caption">
                <h2 class="banner_title">
                  Are you a Institute?
                </h2>
                <p>
                  Modernize your institute by combining benifits of physical classes
                  and Digital classrooms. View, analyse and share daily progress of 
                  Students, Batches, Subjects and Teachers.
                </p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="slider-caption">
                <img
                  v-lazy="'/images/institute.svg'"
                  class="slide_img_home"
                >
              </div>
            </div>
          </div>
        </template>
        <template
          slot="step2"
          class="home_slide"
        >
          <div class="row">
            <div class="col-md-6">
              <div class="slider-caption">
                <h2 class="banner_title">
                  Teacher ?
                </h2>
                <p>
                  Get More Clear Insights about Your Student's Progress. 
                  Digitalize Your Classrooms, Create Your Lessons,
                  Daily assignments, Share Resources and Notify your Students.
                </p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="slider-caption">
                <img
                  v-lazy="'/images/teacher.svg'"
                  class="slide_img_home"
                >
              </div>
            </div>
          </div>
        </template>

        <template
          slot="step3"
          class="home_slide"
        >
          <div class="row">
            <div class="col-md-6">
              <div class="slider-caption">
                <h2 class="banner_title">
                  Student ?
                </h2>
                <p>
                  Meet Students from Your Batch, Course and Institute.
                  Learn and Share from People Around You. 
                  Ask Your Doubts,Share Your Knowledge in posts 
                  and Above All Find Your Interest Field.
                </p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="slider-caption">
                <img
                  v-lazy="'/images/student.svg'"
                  class="slide_img_home"
                >
              </div>
            </div>
          </div>
        </template>
        <template
          slot="step4"
          class="home_slide"
        >
          <div class="row">
            <div class="col-md-6">
              <div class="slider-caption">
                <h2 class="banner_title">
                  Knowledge Seeker ?
                </h2>
                <p>
                  Explore Educational content from variety of courses, categories
                  and Seek knowledge in diverse form.
                </p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="slider-caption">
                <img
                  v-lazy="'/images/knowledge seeker.svg'"
                  class="slide_img_home"
                >
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
    .pt-80 {
        padding-top: 120px;
    }

    .pb-80 {
        padding-bottom: 40px;
    }

    /* the parent */
    .slick-list {
        margin: 0 -5px;
    }

    .slick-dots {
        display: flex;
        justify-content: center;
    }

    .banner_post {
        background-color: #f6f6f6;
        position: relative;
    }


    h2.banner_title:before {
        position: absolute;
        content: '';
        background-color: blue;
        width: 100px;
        height: 2px;
        bottom: -15px;
    }


    img.slide_img_home {
        width: 100%;
            height: 380px;
    }





    

</style>

<script>
import Carousel from '../../components/Carousel.vue';



export default {
	components: {
		Carousel,
	},
};

</script>
