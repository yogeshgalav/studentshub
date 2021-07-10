<template>
  <div class="vue-form-wizard">
    <div class="hey">
      <ul class="list-unstyled multi-steps">
        <li :class="activeStep===1 ? 'is-active' : ''">
          Type
        </li>
        <li :class="activeStep===2 ? 'is-active' : ''">
          Content
        </li>
        <li :class="activeStep===3 ? 'is-active' : ''">
          Description
        </li>
      </ul>
    </div>
    <div class="row">
      <slot name="header-row" />
    </div>

    <div
      v-for="step in totalSteps"
      :key="step"
      class="row"
    >
      <div class="col-md-12">
        <slot
          v-if="step===activeStep"
          :name="'step'+step"
        />
      </div>
    </div>
  </div>
</template>
<script>
import ProgressBar from './ProgressBar';
import EventBus from './event-bus';

export default {
	components: {
		ProgressBar
	},
	props:{
		stepData: { type: Array, default: () => [] },
	},
	data(){
		return{
			step_valid:true,
			stepIndex:0,
			emitFunctions:[],
		};
	},
	computed:{
		totalSteps(){
			return this.stepData.length;
		},
		activeStep(){
			return this.stepData[this.stepIndex] ? this.stepData[this.stepIndex].step :0;
		},
		isLastStep(){
			return this.activeStep===this.totalSteps;
		},
		progress(){
			return (this.activeStep/this.totalSteps)*100;
		},
		show_back_button(){
			return this.stepData[this.stepIndex] ? this.stepData[this.stepIndex].backbutton :false;
		},
		show_next_button(){
			return this.stepData[this.stepIndex] ? this.stepData[this.stepIndex].nextTab :true;
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
		}
	},
	mounted(){
		EventBus.$on('nextTab', () => { this.nextTab(); });
		EventBus.$on('prevTab', () => { this.prevTab(); });
		EventBus.$on('validateWizard', (step,valid) => {
			if(step===this.activeStep && valid===true){
				if(this.isLastStep){
					this.$emit('onComplete');
				}else{
					this.nextStep();
				}
				window.scrollTo(0, 0);
			}
			let emit_function=this.stepData[this.stepIndex].emit;
			if(step===this.activeStep && valid==='wait' && emit_function!==''){
				if(!this.emitFunctions.includes(emit_function)){
					this.$emit(emit_function);
					this.emitFunctions.push(emit_function);
				}
			}else if(step===this.activeStep && valid===false && emit_function!==''){
				let emitIndex=this.emitFunctions.indexOf(this.stepData[this.stepIndex].emit);
				if(emitIndex>-1){
					this.emitFunctions.splice(emitIndex, 1);
				}
			}
		});
	},
	methods:{
		trans: function (string, defaultString) {
			// return this.$trans('auth',string,defaultString);
      return string;
		},
		nextTab(){
			if(this.stepData[this.stepIndex].validation===true){
				EventBus.$emit('validateStep'+this.activeStep);
			}else{
				this.nextStep();
			}

		},
		nextStep(){
			this.stepIndex++;
			while(this.stepData[this.stepIndex].stepskip===true){
				this.stepIndex++;
			}
		},
		prevTab(){
			let emitIndex=this.emitFunctions.indexOf(this.stepData[this.stepIndex-1].emit);
			if(emitIndex>-1){
				this.emitFunctions.splice(emitIndex, 1);
			}
			this.stepIndex--;
			while(this.stepData[this.stepIndex].stepskip===true){
				let emitIndex=this.emitFunctions.indexOf(this.stepData[this.stepIndex-1].emit);
				if(emitIndex>-1){
					this.emitFunctions.splice(emitIndex, 1);
				}

				this.stepIndex--;
			}
		}
	}
};
</script>
<style>
    .wizard-progress-bar {
        display: none !important;
    }

    .wizard-nav {
        display: none !important;
    }
    .wizard-header
    {
        visibility: hidden;
    }
    .custom-link .btn
    {
        padding:15px 0;
    }
    .vue-form-wizard .wizard-tab-content {
        min-height: 100px;
        padding: 0px 20px 10px;
    }
    .vue-form-wizard {
        padding-top: 100px;
    }
    /* .vue-form-wizard .wizard-card-footer {
        background: #FFFFFF;
        box-shadow: 0 -2px 50px rgba(0, 0, 0, 0.15);
        position: fixed;
        bottom: 0;
        width: 100%;
        padding: 20px 20% 20px 20%;
        z-index: 300;
        left: 0;
    } */

    .wizard-btn {
        border-radius: 3px;
        text-transform: uppercase;
        border: 0 !important;
        padding: 10px 0 10px 0 !important;
    }
    .finish-button{
      background-color: rgb(16, 6, 159) !important;
      color:white;
    }
.multi-steps > li.is-active:before, .multi-steps > li.is-active ~ li:before {
  content: counter(stepNum);
  font-family: inherit;
  font-weight: 700;
}
.multi-steps > li.is-active:after, .multi-steps > li.is-active ~ li:after {
  background-color: #ededed;
}

.multi-steps {
  display: table;
  table-layout: fixed;
  width: 100%;
}
.multi-steps > li {
  counter-increment: stepNum;
  text-align: center;
  display: table-cell;
  position: relative;
  color: black;
      z-index: 9;
}
.multi-steps > li:before {
  content: '\f00c';
  content: '\2713;';
  content: '\10003';
  content: '\10004';
  content: '\2713';
  display: block;
  margin: 0 auto 4px;
  background-color: #fff;
  width: 36px;
  height: 36px;
  line-height: 32px;
  text-align: center;
  font-weight: bold;
  border-width: 2px;
  border-style: solid;
  /* border-color: tomato; */
  border-radius: 50%;
}
.multi-steps > li:after {
  content: '';
  height: 2px;
  width: 100%;
  background-color: black;
  position: absolute;
  top: 16px;
  left: 50%;
  z-index: -1;
}
.multi-steps > li:last-child:after {
  display: none;
}
.multi-steps > li.is-active:before {
  /* background-color: #fff; */
  /* border-color: tomato; */
      background-color: black;
    color: white;
}
.multi-steps > li.is-active ~ li {
  color: #808080;
}
.multi-steps > li.is-active ~ li:before {
  background-color: #ededed;
  border-color: #ededed;
}
ul.list-unstyled.multi-steps {
    background-color: white;
    padding: 15px 0;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.12);
    border-radius: 4px;
}

    @media only screen and (max-width:768px) {
        /* .vue-form-wizard .wizard-card-footer {
            background: #FFFFFF;
            box-shadow: 0 -2px 50px rgba(0, 0, 0, 0.15);
            position: fixed;
            bottom: 0;
            width: 100%;
            padding: 20px 5% 20px 5%;
            left: 0;
        } */
        .vue-form-wizard .wizard-header
       {
           padding: 0;
       }
        .vue-form-wizard .wizard-tab-content {
            min-height: 100px;
            padding: 30px 0px 10px;
        }
    }
</style>
