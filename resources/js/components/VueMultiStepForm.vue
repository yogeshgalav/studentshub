<template>
  <form
    :id="id"
    class="vue-multi-form"
    :name="name"
  >
    <div class="row">
      <slot name="header" />
    </div>

    <div
      v-for="(step,index) in stepData"
      :key="index"
    >
      <Transition name="slide">
        <slot
          v-if="index===stepIndex"
          :id="'step'+index"
          :name="'step'+index"
          class="vue-form-step"
        />
      </Transition>
    </div>

    <div class="row">
      <slot
        name="footer"
        :isFirstStep="isFirstStep"
        :isLastStep="isLastStep"
        :currentStep="currentStep"
      >
        <button
          v-if="stepIndex!==0"
          type="button"
          class="btn btn-md btn-primary"
          @click="prevStep"
        >
          {{ 'Previous' }}
        </button>

        <button
          type="button"
          class="btn btn-md btn-primary"
          @click="nextStep"
        >
          {{ isLastStep ? 'Submit' : 'Next' }}
        </button>
      </slot>
    </div>
  </form>
</template>
<script>
export default {
	props:{
		id: { 
			type: String, 
			default: 'vue_multi_step_form' 
		},
		name: { 
			type: String, 
			default: 'vue_multi_step_form'
		},
		stepData: { 
			type: Array, 
			default: () => [] 
		},
	},
	data(){
		return{
			stepIndex:0,
			emitFunctions:[],
		};
	},
	computed:{
		totalSteps(){
			return this.stepData.length;
		},
		currentStep(){
			return this.stepData[this.stepIndex] ? this.stepData[this.stepIndex] : null;
		},
		isFirstStep(){
			if(!this.stepData.length) return false;
			else if(!this.stepData[0].stepskip && this.stepIndex!==0) return false;
			else if(!this.stepData[0].stepskip && this.stepIndex===0) return true;
			return this.stepIndex===this.stepData.findIndex(el=>el.stepskip===false);
		},
		isLastStep(){
			if(this.stepIndex === (this.totalSteps-1)) return true;
      
			return (this.currentStep && this.currentStep.laststep) ? this.currentStep.laststep : false;
		},
		progress(){
			return ((this.stepIndex+1)/this.totalSteps)*100;
		},
		show_back_button(){
			return (this.currentStep && this.currentStep.show_back_button) ? this.currentStep.show_back_button :false;
		},
		show_next_button(){
			return (this.currentStep && this.currentStep.show_next_button) ? this.currentStep.show_next_button :true;
		},
		step_valid(){
			return (this.currentStep && this.currentStep.step_valid) ? this.currentStep.step_valid :true;
		},
		step_skip(){
			return (this.currentStep && this.currentStep.step_skip) ? this.currentStep.step_skip :false;
		},
	},
	watch:{
		stepData(val){
			if(val.length){
				let i=0;
				while(val[i].stepskip===true){
					this.stepIndex++;
					i++;
				}
				val[i].backbutton=false;
			}
		},
	},
	mounted(){
		var self=this;
		window.addEventListener('hashchange', ()=>{
			let stepHash=parseInt(window.location.hash.replace('#',''));
			if(stepHash){
				if(self.stepIndex>stepHash && self.show_back_button===false){
					window.location.href=window.location.href.replace(location.hash,'');
				}else if(self.stepIndex>stepHash && self.show_back_button===true){
					self.prevTab();
				}
			} 
		});
	},
	methods:{
		nextStep(){
			if(!this.step_valid){
        console.log('valdiateStep',this.stepIndex);
				this.$emit('valdiateStep', this.stepIndex);
				return false;
			}
			if(this.isLastStep){
				this.$emit('onComplete');
				return false;
			}
			this.stepIndex++;
			while(this.step_skip===true){
				this.stepIndex++;
			}
			window.location.hash = this.stepIndex;
		},
		prevStep(){
			this.stepIndex--;
			while(this.step_skip===true){
				this.stepIndex--;
			}
			window.location.hash = this.stepIndex;
		}
	}
};
</script>
<style>
.vue-multi-form {
  overflow: hidden;
}

.vue-form-step {
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right:0;
}

.slide-leave-active,
.slide-enter-active {
  transition: 1s;
}
.slide-enter {
  transform: translate(100%, 0);
}
.slide-leave-to {
  transform: translate(-100%, 0);
}
</style>
