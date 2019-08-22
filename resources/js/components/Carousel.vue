<template>
    <div>
  <div class="slides">
  
    <transition-group tag="ul"
     name="fade" class="slides-group"
    >
     
      <li v-for="slide in carouselSlides"
      :key="slide.index"
      v-if="slide.isActive===true"
      
      >
      <slot :slide="slide" >Slide {{slide}}</slot>
      </li>
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
<style scoped>

/* FADE IN */
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
        data.push([i,i+this.perPage]);
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
