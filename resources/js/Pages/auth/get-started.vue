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
        <div class="col-md-6 justify-content-center">
          <div class="logn_right">
            <div class="card_title mb-2">
              <h3>{{ 'Get started' }}</h3>
            </div>
            <div class="card_body">
              <VueMultiStepForm
                id="login_form"
                ref="loginForm"
                name="login"
                method="post"
                :action="action"
                :step-data="step_data"
                @valdiateStep="valdiateStep"
              >
                <template slot="header">
                  <input
                    name="_token"
                    :value="csrfToken"
                    type="hidden"
                  >
                  <input
                    name="otp"
                    :value="otp"
                    type="hidden"
                  >
                  <input
                    name="phone_number"
                    :value="phone_number"
                    type="hidden"
                  >
                  <input
                    name="fcmToken"
                    :value="fcmToken"
                    type="hidden"
                  >
                </template>
                <template slot="step0">
                  <div
                    class="form-group"
                  >
                    <label for="phone_number"> {{ 'Enter Your Phone Number' }}</label>
                    <div>
                      <vue-tel-input
                        v-validate="'required'"
                        :validation-value="phone_number"
                        :auto-default-country="true"
                        default-country="IN"
                        name="phone_number"
                        placeholder="Enter Your Mobile Number"
                        @validate="savePhoneNumber"
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
                        :num-inputs="5"
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
                <template slot="step2">
                  <div class="form-group">
                    <label for="role"> {{ "I'm a" }} </label>
                    
                    <select
                      id="role"
                      v-model="role"
                      v-validate="'required'"
                      :disabled="join_id"
                      class="form-control"
                      name="role"
                    >
                      <option
                        selected
                        value="student"
                      >
                        Student
                      </option>
                      <option value="teacher">
                        Teacher
                      </option>
                      <option value="instituteAdmin">
                        Institute Admin
                      </option>
                    </select>
                    <span class="error">{{ formErrors('role') }}</span>
                  </div>
                  <div class="form-group">
                    <label> {{ ('Full Name') }} </label>
                    <input
                      id="full_name"
                      v-model="full_name"
                      v-validate="'required'"
                      type="text"
                      class="form-control"
                      name="full_name"
                      placeholder="Enter Full Name"
                      autofocus
                      maxlength="255"
                    >
                    <span class="error">{{ formErrors('full_name') }}</span>
                  </div>

                  <div class="form-group">
                    <label for="email"> {{ ('E-Mail Address *(Optional)') }}</label>
                    <input
                      id="email"
                      v-model="email"
                      v-validate="'email'"
                      type="email"
                      class="form-control"
                      name="email"
                      placeholder="Email address"
                      maxlength="255"
                    >
                    <span class="error">{{ formErrors('email') }}</span>
                  </div>
                </template>
                <template
                  v-slot:footer="props"
                >
                  <div class="m-0-a">
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
                        {{ nextButtonText(props.stepIndex) }}
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
		srvError:{
			default:false,
		},
		otpError:{
			default:false,
		},
	},
	data(){
		return{
			showLoader:false,
			join_id:null,
			role:'student',
			full_name:'',
			email:'',
			action:'/login',
			phone_number:'',
			country_code:'IN',
			otp:'',
			remember:true,
			fcmToken:'',
			new_user: false,
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
					'laststep': true,
				},
				{
          
					'step_valid': false,
					'step_skip': true,
					'show_back_button': false,
					'show_next_button': true,
					'laststep': true,
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
			if(step===2 && this.new_user){
				return 'Register';
			}else if(step===2){
				return 'Login';
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
		savePhoneNumber(value){
			this.phone_number = value.number;
			this.country_code = value.countryCode;
		},
		valdiateStep(stepIndex){
			if(stepIndex===0){
				// verify phone number and set new user;
				this.validateInput('phone_number').then(resp=>{
					if(!resp) return false;
					let loader = this.$loading.show();
					this.axios.post('/api/verify-contact',{
						'phone_number':this.phone_number,
						'country_code':this.country_code
					}).then(resp=>{
						if(resp.data.success.new_user){
							this.new_user = true;
						  this.step_data[2].step_skip = false;
						  this.step_data[1].last_step =  false;
							this.action = '/register';
						}
						this.step_data[stepIndex]['step_valid']=true;
						this.$refs.loginForm.nextStep();
						loader.hide();
					}).catch(()=>loader.hide());
				});
			}else if(stepIndex===1){
				// login
				this.validateInput('otp').then(resp=>{
					if(!resp) return false;
					this.step_data[stepIndex]['step_valid']=true;
					if(this.new_user){
						this.$refs.loginForm.nextStep();
						return false;
					}else{
						this.$refs.loginForm.submitForm();
					}
				});
			}else if(stepIndex===2){
				// this.addField('otp',this.otp);
				this.validateInput('full_name').then(resp=>{
					if(!resp) return false;
					this.step_data[stepIndex]['step_valid']=true;
					this.$refs.loginForm.submitForm();
				});
			}


		}
	}
};
</script>

