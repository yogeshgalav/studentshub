<template>
    <div class="bg-gray">
   <div class="container ptb-20">
        <div class="row">
        <div class="col-md-12">
            <carousel 
            :per-page="8"  
            :navigationEnabled="true"
        :paginationEnabled="false"
       
        :loop="false"
            :mouse-drag="true" 
            :center-mode="true" 
            :navigate-to="navPosition"
            navigation-next-label="<button class='rightnav'>Right</button>"
            navigation-prev-label="<button class='rightnav'>Left</button>">
    <slide v-for="i in 40" :key="i">
                    <a href="#" class="btn btn-white"> Art & Design {{i}}</a>

    </slide>
  </carousel>
  <button class='rightnav' @click="rightnav">Right</button>
        </div>
    </div>
   </div>
    </div>
</template>
<style scoped>
.leftnav {
    transform: translateY(0%) translateX(130%);
}
.rightnav {
    transform: translateY(0%) translateX(-130%);
}

</style>

<script>
import { Carousel, Slide } from 'vue-carousel';

export default {
    components: {
    Carousel,
    Slide,
    }  ,  
    data(){
        return {
            navPosition:1,
        }
    },
    methods:{
        rightnav(){
            this.navPosition++;
        }
    }
}
</script>
