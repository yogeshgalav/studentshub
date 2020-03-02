<template>
    <div>
  <div class="slides">
  
    <transition
     name="fade" class="slides-group"
    >
        <slot :name="'step'+currentStep" />
     
     </transition>
     
  
  </div>
  <div class="row">
    <div class="col-md-3">123</div>
    <div class="col-md-offset-8">
    <button type="button" @click="nextSlide" v-if="!lastStep">Next</button>  
    <button type="button" @click="getStarted" v-if="lastStep">Get Started</button>  
    </div>
  </div>
</div>
</template>
<style scoped>

/* FADE IN */ 
.slides ul
{
  margin-bottom:0px;
}
.fade-enter-active {
  transition: opacity 1s;
}
.fade-enter {
  opacity: 0;
}

/* GO TO NEXT SLIDE */
.slide-next-enter-active,
.slide-next-leave-active {
  transition: transform 0.5s ease-in-out;
}
.slide-next-enter {
  transform: translate(100%);
}
.slide-next-leave-to {
  transform: translate(-100%);
}

/* GO TO PREVIOUS SLIDE */
.slide-prev-enter-active,
.slide-prev-leave-active {
  transition: transform 0.5s ease-in-out;
}
.slide-prev-enter {
  transform: translate(-100%);
}
.slide-prev-leave-to {
  transform: translate(100%);
}

.slide {
  width: 100%;
  height: 100vh;
  position: absolute;
  top: 0;
  left: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}

.btn {
  z-index: 10;
  cursor: pointer;
  border: 3px solid #fff;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 70px;
  height: 70px;
  position: absolute;
  top: calc(50% - 35px);
  left: 1%;
  transition: transform 0.3s ease-in-out;
  user-select: none;
}

.btn-next {
  left: auto;
  right: 1%;
}

.btn:hover {
  transform: scale(1.1);
}

.slides ul 
{
  list-style: none;
  padding:0px;
}
.slides ul
{
  display:flex;
  flex-wrap: wrap;
  align-items: center;
}
</style>

<script>
export default {
  props:{
  },
  data() {
    return {
      currentStep:1,
      total_steps:3,
    }
  },
  computed:{
    lastStep(){
      if(this.currentStep===this.total_steps){
        return true;
      }
      return false;
    }
  },
  methods: {
    nextSlide(){
      this.currentStep=this.currentStep+1;
    },
    getStarted(){

    }
}
}
</script>
