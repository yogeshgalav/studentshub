<template>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
 rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
 crossorigin="anonymous">

<div class="container mt-5">
<div class="d-flex justify-content-center align-items-center">
    <div class="col-lg-5 card p-5">
        <div class="h3 text-center">Login Form</div>
        <VueMultiStepForm
        id="loginForm"
        name="loginForm"
        ref="multiStepForm"
        method="post"
        :action="action"
        :steps="steps"
        @validateStep="validateStep"
        @onComplete="submitForm"
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
                <!-- <div class="col-md-12">
                    <div
                    v-if="otpError"
                    class="form-group row danger danger-alert"
                    >
                        <span>{{' Invalid otp ,please try again '}}</span>
                    </div>
                    <div
                    v-if="srvError"
                    class="form-group row danger danger-alert"
                    >
                        <span>{{' server error occured '}}</span>
                    </div>
                </div> -->
            </template>
            <template slot="step1">
                <div class="form-group">
                    <label for="phone_number"> {{ ('Enter Your Phone Number') }}</label>
                    <input
                    id="phone_number"
                    v-model="phone_number"
                    v-validate="'required|digits:10'"
                    type="number"
                    name="phone_number"
                    class="form-control"
                    placeholder="Enter your mobile number"
                    >
                    <!-- <span class="error"> {{ formErrors('phone_number')}}</span> -->
                </div>
            </template>
            <template slot="step2">
                <div class="form-group">
                    <label for="verify_otp"> {{ ('Enter Your otp') }}</label>
                    <input
                    id="verify_otp"
                    v-model="verify_otp"
                    v-validate="'required|digits:4'"
                    type="number"
                    name="verify_otp"
                    class="form-control"
                    placeholder="Enter your otp"
                    >
                    <!-- <span class="error"> {{ formErrors('verify_otp')}}</span> -->
                </div>
                <div style="display: flex; flex-direction: row;">
                    <v-otp-input
                      ref="otpInput"
                      input-classes="otp-input"
                      separator="-"
                      :num-inputs="4"
                      :should-auto-focus="true"
                      :is-input-num="true"
                      :conditionalClass="['one', 'two', 'three', 'four']"
                      :placeholder="['*', '*', '*', '*']"
                    />
                  </div>
            </template>
            <template slot="step3">
                <div class="form-group">
                    <label for="role"> {{ ('Enter Your role') }}</label>
                    <select
                    id="role"
                    v-model="role"
                    v-validate="'required'"
                    name="role"
                    class="form-control"
                    >
                    <option value="teacher">Teacher</option>
                    </select>
                    <!-- <span class="error"> {{ formErrors('role')}}</span> -->
                </div>
                <div class="form-group">
                    <label> {{ ('First Name') }} </label>
                    <input
                      id="first_name"
                      v-model="first_name"
                      v-validate="'required'"
                      type="text"
                      class="form-control"
                      name="first_name"
                      placeholder="Enter First Name"
                      autofocus
                      maxlength="255"
                    >
                    <!-- <span class="error">{{ formErrors('first_name') }}</span> -->
                  </div>
                  <div class="form-group">
                    <label> {{ ('Last Name') }} </label>
                    <input
                      id="last_name"
                      v-model="last_name"
                      v-validate="'required'"
                      type="text"
                      class="form-control"
                      name="last_name"
                      placeholder="Enter Last Name"
                      autofocus
                      maxlength="255"
                    >
                    <!-- <span class="error">{{ formErrors('last_name') }}</span> -->
                  </div>
            </template>
            <template
                  v-slot:footer="props"
                >
                  <div>
                    <div class="row">
                      <button
                        type="button"
                        class="btn btn-primary"
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
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import VueMultiStepForm from '@/views/components/VueMultiStepForm.vue' ;
import axios from 'axios';
import VOtpInput from 'vue3-otp-input';

export default defineComponent({
    setup() {
		
    },
    components:{
		VueMultiStepForm,
    VOtpInput,
	},
    data(){
        return {
			role:'',
      first_name:'',
			last_name:'',
			action:'/api/login',
			phone_number:'',
			verify_otp:'',
			fcmToken:'',
			steps:[
				{
					'step_valid': false,
					'step_skip': false,
					'show_back_button': false,
					'show_next_button': true,
					'last_step': false,
				},
				{
					'step_valid': false,
					'step_skip': false,
					'show_back_button': true,
					'show_next_button': true,
					'last_step': true,
				},
				{
          
					'step_valid': false,
					'step_skip': true,
					'show_back_button': false,
					'show_next_button': true,
					'last_step': true,
				}
			]
        };
    },
	mounted(){
		
	},methods:{
        validateStep(stepIndex){
        this.steps[stepIndex].step_valid=true;
        this.$refs.multiStepForm.submitStep();
        },

        submitForm() {

            axios.post('/api/login', {
						phone_number: this.phone_number,
						verify_otp: this.verify_otp,
						role: this.role,
						first_name: this.first_name,
                        last_name: this.last_name,
					}).then(resp=>{
						console.log(resp);
						});

			return true;
		},
	}
})
</script>