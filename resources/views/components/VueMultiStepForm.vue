<template>
  <form 
  @submit.prevent="submitStep"
  :id="loginForm"
  :action="action" 
  :method="post"
  >
  <div
  v-for="(step,index) in steps"
  :key="index" :id="'step'+(index+1)"
>
  <div
    v-show="activeStepIndex===index" 
    :name="'step'+(index+1)"
  >
    <slot
      :id="'step'+index"
      :name="'step'+index"
      :currentStep="currentStep"
      :stepIndex="stepIndex"
    />
  </div>
  </div>
<slot name="footer">
  <button type="submit">Next</button>
</slot>
</form>
</template>
<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  setup() {
      
  },
  props:['steps','id','action','method'],
  data() {
      return {
          activeStepIndex:0,
          phone_number: '',
          otp: '',
          first_name: '',
          last_name: '',
      };
  },
  mounted(){
      
  },methods:{
    submitStep(){
        if(!this.steps[this.activeStepIndex].step_valid){
            this.$emit('valdiateStep', this.stepIndex);
            return false;
        }
        isLastStep = (this.activeStepIndex==this.steps.length);
        if(isLastStep && this.action){
            this.submitForm();
            return true;
        }
        if(isLastStep){
            this.$emit('onComplete');
            return true;
        }
        this.activeStepIndex++;
        while(this.steps[this.activeStepIndex].step_skip===true){
            this.activeStepIndex++;
        }
     
    }
}
})
</script>