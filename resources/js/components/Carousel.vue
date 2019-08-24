<template>
    <div>
  <div class="slides">
    <transition-group 
      name="slide"
      mode="out-in"
      enter-class="slide-in"
      leave-class="slide-out"
      enter-active-class="animated slide-in-active"
      leave-active-class="animated slide-out-active"
    >
      <div
      v-for="slide in carouselSlides"
      :key="slide.index">
        <slot :slide="slide" v-if="slide.isActive===true">Slide {{slide}}</slot>
      </div>
    </transition-group>
  </div>
  <button
    class="prev"
    @click="prev()"
  >Left
    <i class="fa fa-chevron-left" aria-hidden="true"></i>
  </button>
  <button
    class="next"
    @click="next()"
  >Right
    <i class="fa fa-chevron-right" aria-hidden="true"></i>
  </button>
  <!-- <ul class="dots">
    <li 
      v-for="(dot, index) in slides"
      :key="index"
      :class="{ active: ++index === active }"
      @click="jump(index)"
    ></li>

  </ul> -->
</div>
</template>
<script>
export default {
  props:{
    'stepJump':{
      type:Number,
      default:1
    },
    'perPage':{
      type:Number,
      default:1
    },
    'slides':{
      type:Array,
      default:()=>[]
    },'loop':{
      type:Boolean,
      default:false
    }
  },
  data() {
    return {
      active:0,
    }
  },
  computed:{
    pageFirstIndex(){
      return this.activeIndexes[this.active][0];
    },
    pageLastIndex(){
      return this.activeIndexes[this.active][1];
    },
    slideLastIndex(){
      return this.slides.length-1;
    },
    activeIndexes(){
      let data=[];
      let i=0
      while(i<this.slides.length)
      {
        data.push([i,i+this.stepJump]);
        i=i+this.stepJump;
      }
      return data;
    },
    carouselSlides(){
      return this.slides.map((node,index)=>{
        if(index>=this.pageFirstIndex && index<this.pageLastIndex){
          node.isActive=true;
        }else{
          node.isActive=false;
        }
        node.index=index;
        return node;
      });
    }
  },
  methods: {
    next(){
      if(this.indexExists()){
        this.active++;
      }else if(this.loop===true && !this.indexExists()){
        this.active=0;
      }else{
        return false;
      }
    },
    indexExists(){
       if((this.active+1)<this.activeIndexes.length)
       return true;
       else
       return false;
    },
    prev(){
      if(this.prevIndexExists()){
        this.active--;  
      }else if(this.loop===true && !this.prevIndexExists()){
        this.active=this.activeIndexes[this.activeIndexes.length-1];
      }else{
        return false;
      }      
    },
    prevIndexExists(){
      if((this.active-1)>=0)
       return true;
       else
       return false;
    },
  }
}
</script>
