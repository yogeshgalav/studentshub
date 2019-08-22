<template>
    <div class="bg-gray">
   <div class="container ptb-20">
        <div class="row">
        <div class="col-md-12 text-center">
            <carousel :per-page="8" :step-jump="2" :slides="$store.state.explore.categories">
    <template slot-scope="props">
                    <a href="#" class="btn btn-white">{{props.slide.Subject_name}}</a>
   </template>
  </carousel>
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
import Carousel from './Carousel';


export default {
    components: {
    Carousel,
    }  ,  
    data(){
        return {
            
        }
    },
    methods:{
        
    },
}
</script>
