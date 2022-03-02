<template>
  <section class="container">
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <div class="login_card">
      <div class="row  login">
        <div class="col-md-6">
          <div class="login_img">
            <img
              v-lazy="'/images/Group.svg'"
              alt=""
            >
          </div>
        </div>
        <div class="col-md-6 ">
          <div class="logn_right">
            <div class="card_title mb-2">
              <h3>{{ 'Get started' }}</h3>
            </div>
            <div class="card_body">
              <VueMultiStepForm
                id="login_form"
                ref="loginForm"
                name="login"
                :step-data="step_data"
                @valdiateStep="valdiateStep"
              >
                <template slot="step0">
                  <div
                    class="form-group"
                  >
                    <label for="phone_number"> {{ 'Enter Your Phone Number' }}</label>
                    <div>
                      <vue-tel-input
                        v-model="phone"
                        v-validate="'required'"
                        :validation-value="phone"
                        :auto-default-country="true"
                        default-country="IN"
                        name="phone_number"
                        placeholder="Enter Your Mobile Number"
                      />
                      <span class="error">{{ formErrors('phone_number') }}</span>
                    </div>
                  </div>
                </template>
                <template slot="step1">
                  <div
                    class="form-group"
                  >
                    <label
                      for="verify_otp"
                      class="pl-2"
                    > {{ 'Verify OTP' }}</label>
                    <div>
                      <otp-input
                        ref="otpInput"
                        v-validate="'required'"
                        name="otp"
                        input-classes="otp-input"
                        separator=" "
                        :num-inputs="4"
                        :should-auto-focus="true"
                        :is-input-num="true"
                        :validation-input="'otp'"
                        :validation-value="otp"
                        @on-change="OtpChange"
                      />
                      <span class="error">{{ formErrors('verify_otp') }}</span>
                    </div>
                  </div>
                </template>
                <template
                  v-slot:footer="props"
                >
                  <div class="form-group  mb-0">
                    <div class="row">
                      <button
                        v-if="!props.isFirstStep"
                        type="button"
                        class="btn btn-md btn-primary m-0-a"
                        @click="prevClick"
                      >
                        {{ 'back' }}
                      </button>
                      <button
                        type="button"
                        class="btn btn-md btn-primary m-0-a"
                        @click="nextClick"
                      >
                        {{ nextButtonText(props.currentStep) }}
                      </button>
                    </div>
                  </div>
                </template>
              </VueMultiStepForm>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<style scoped>
.inner-addon {
  position: relative;
}
.login .form-control
{

    height: 48px !important;
    color: #000;
    border-radius: 0;
}
/* style glyph */
.inner-addon .fa {
  position: absolute;
  padding: 18px;
  pointer-events: none;
}

/*adding style to eye icon */
.input_icon_frm .input-group-append{
  cursor: pointer;
}

/* align glyph */
.left-addon .fa  { left:  0px;}
.right-addon .fa { right: 0px;}

/* add padding  */
/* .left-addon input  { padding-left:  35px; } */
</style>
<script>
import FormMixin from '@/components/mixins/form-mixin.js' ;
import VueMultiStepForm from '@/components/VueMultiStepForm.vue' ;
import NoSidebarNoFooterLayout from '@/Layouts/NoSidebarNoFooterLayout';
import OtpInput from '@bachdgvn/vue-otp-input';
import {VueTelInput} from 'vue-tel-input';
import 'vue-tel-input/dist/vue-tel-input.css';

export default {
	layout:NoSidebarNoFooterLayout,
	components:{
		OtpInput,
		VueTelInput,
		VueMultiStepForm
	},
	mixins: [FormMixin],
	props: {
		srvError401:{
			default:false,
		},
		srvErrorUnknown:{
			default:false,
		}, 
		emailError:{
			default:false,
		} 
	},
	data(){
		return{
			showLoader:false,
			phone:'',
			otp:'',
			remember:true,
			fcmToken:'',
			is_user_registered: false,
			step_data:[
				{
					'step_valid': false,
					'step_skip': false,
					'show_back_button': false,
					'show_next_button': true,
					'laststep': false,
				},
				{
					'step_valid': false,
					'step_skip': false,
					'show_back_button': true,
					'show_next_button': true,
					'laststep': false,
				},
				{
          
					'step_valid': true,
					'step_skip': false,
					'show_back_button': false,
					'show_next_button': true,
					'laststep': false,
				}
			]
		};
	},
	mounted(){
		if(localStorage.getItem('fcmToken')){
			this.fcmToken = localStorage.getItem('fcmToken');
		}
	},
	methods:{
		nextButtonText(step){
			if(step===2 && this.is_user_registered){
				return 'Login';
			}else if(step===2){
				return 'Register';
			}
			return 'Next';
		},
		nextClick: function (e) {
			this.$refs.loginForm.nextStep();
		},
		prevClick: function (e) {
			this.$refs.loginForm.prevStep();
		},
		OtpChange(value){
			this.otp = value;
		},
		valdiateStep(stepIndex){
      console.log(stepIndex);
			if(stepIndex===0){
				// this.addField('phone_number',this.phone_number);
				this.validateInput('phone_number').then(resp=>{
					if(!resp) return false;
					this.axios.post('/api/send-otp',{
						'phone_number':this.phone_number
					});
					this.step_data[stepIndex]['step_valid']=true;
				});
			}else if(stepIndex===1){
				// this.addField('otp',this.otp);
				this.validateInput('otp').then(resp=>{
					if(!resp) return false;
					this.axios.post('/api/verify-otp',{
						'otp':this.otp
					});
					this.step_data[stepIndex]['step_valid']=true;
				});
			}
		}
	}
};
</script>

