<template>

    <!-- <div class="container mt-5">
    <div class="d-flex justify-content-center align-items-center">
        <div class="col-lg-5 card p-5">
            <div class="h3 text-center">Login Form</div>
            <form @submit.prevent="loginForm">
                <div class="mb-3">
                    <label class="mb-1"> {{ 'Phone Number' }} </label>
					<input
                        v-model="phone_number"
                        type="number"
                        class="form-control"
                        name="phone_number"
                      >
                </div>
                <div class="mb-3">
					<label class="mb-1"> {{ 'OTP' }} </label>
					<input
                        v-model="otp"
                        type="number"
                        class="form-control"
                        name="otp"
                      >
                </div>
                <div class="mb-3">
                    <label class="mb-1"> {{ 'First Name' }} </label>
					<input
                        v-model="first_name"
                        type="text"
                        class="form-control"
                        name="first_name"
                      >
                </div>
                <div class="mb-3">
                    <label class="mb-1"> {{ 'Last Name' }} </label>
					<input
                        v-model="last_name"
                        type="text"
                        class="form-control"
                        name="last_name"
                      >
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div> -->
        <!-- navbar -->
        

        <main class="Container w-100% h-100vh d-flex flex-col items-center lg:flex-row justify-evenly">
            <div class="lg:w-2/4 mx-4 my-4">
                <h1 class="text-3xl lg:text-[3em] font-semibold text-center lg:text-left ">
                    World's First Education Network
                </h1>
                <hr class="w-48 mx-auto lg:mx-0 lg:w-72 h-1 bg-blue-700 rounded border-0 my-4">
                <h2 class="text-justify lg:text-xl font-normal mt-4">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, consequatur repellendus?
                    Beatae natus nulla assumenda modi magnam provident animi blanditiis quos ut iusto. Neque quos
                </h2>
            </div>
            <!-- Login Form -->
            <div class="w-96 my-4 p-6 d-flex flex-col flex-wrap bg-white shadow-md rounded-md">
                <MultiStepForm
                ref="loginForm"
                :steps="step_data"
                @onComplete="submitForm"
                @validateStep="validateStep"
                method="post"
                id="loginForm"
                action="/api/login"
                >
                <template #header>
                <div class="text-2xl mb-4 font-semibold text-center">Login
                </div>
                <input type="hidden" name="_token" :value="$page.props.csrfToken">
                </template>
            
                <template #footer>
                    <button class="btn btn-primary" 
                    type="submit">Get OTP</button>
                </template>
                <template #step1>
                <div class="form-group">
                    <label for="Phonenumber" class="my-2 text-md font-xl">Phone Number</label>
                    <div class="flex">
                        <span
                            class="inline-flex items-center px-3 text-sm text-white bg-blue-700 rounded-l border border-r-0 border-blue-800">
                            +91
                        </span>
                        <input type="tel"
                            class="rounded-r border-2 hover:border-blue-700 focus:outline-none focus:border-blue-800 block flex-1 min-w-0 w-full p-2"
                            placeholder="Enter Your Phone Number" name="phone_number">
                    </div>
                </div>
                </template>
                <template #step2>
                                    <div class="form-group">
                    <label for="otp" class="my-2 text-md font-xl" >OTP</label>
                    <v-otp-input ref="otpInput" input-classes="form-control text-center w-16"
                        separator="&emsp;" :num-inputs="4" @on-change="otpChange" />
                    <input type="hidden" name="otp" :value="login_data.otp">
                </div>
                </template>
                <template #step3>
                <div class=" form-group">
                    <label for="Phonenumber" class="my-2 text-md font-xl">First Name</label>
                    <input class="form-control" type="text" placeholder="Enter Your First Name" name="first_name">
                </div>
                <div class="form-group">
                    <label for="Phonenumber" class="my-2 text-md font-xl">Last Name</label>
                    <input class="form-control" type="text" placeholder="Enter Your Last Name" name="last_name">
                </div>
                </template>
                <div class="text-center mb-4 mt-12"><a href="#" class="text-md btn-primary">Login</a></div>
                </MultiStepForm>
            </div>
        </main>
</template>
<script lang="ts">
import { defineComponent, ref, reactive } from 'vue';
import axios from 'axios';
import MultiStepForm from '../components/MultiStepForm.vue';
import VOtpInput from 'vue3-otp-input';
import { useLoading } from 'vue3-loading-overlay';
    // Import stylesheet
import 'vue3-loading-overlay/dist/vue3-loading-overlay.css';

export default defineComponent({
    components: { VOtpInput , MultiStepForm },

    setup() {
        let login_data = reactive({
            phone_number: '',
            otp: '',
            first_name: '',
            last_name: '',
        });
        let new_user = ref(true);
        let action = ref('');
        const loginForm = ref();
        const fullPage = ref(true);
        let formContainer = ref(null);

        const submit = () => {
          let loader = useLoading();
          loader.show({
            // Optional parameters
            container: this.fullPage ? null : formContainer.value,
            canCancel: true,
            onCancel: onCancel,
          });
                // simulate AJAX
          setTimeout(() => {
            loader.hide()
          },5000)                 
        };

        const onCancel =() => {
          console.log('User cancelled the loader.')
        };   
        
        let step_data = reactive(
            [
            {'step_no':1,'step_valid':false,'step_skip':false},
            {'step_no':2,'step_valid':false,'step_skip':false},
            {'step_no':3,'step_valid':false,'step_skip':false},
            ]
            );

        function otpChange(value: string) {
            login_data.otp = value;
        };
        function validateStep(stepIndex){
			if(stepIndex===0){
				// this.$gtag('event','Phone number input');
				// verify phone number and set new user;
				// validateInput('phone_number').then(resp=>{
					// if(!resp) return false;
					// let loader = $loading.show();
					axios.post('/api/verify-contact',{
						'phone_number':login_data.phone_number,
                        'fcm_token':'abc',
					}).then(resp=>{
						if(resp.data.success.new_user){
							new_user.value = false;
						  step_data[2].step_skip = false;
						  step_data[1].last_step =  false;
							action.value = '/register';
						}
						step_data[stepIndex]['step_valid']=true;
                        loginForm.value.submitStep();
						// loader.hide();
					}).catch(()=>loader.hide());
				// });
			}else if(stepIndex===1){
				// this.$gtag('event','Otp input');
				// login
				// validateInput('otp').then(resp=>{
					// if(!resp) return false;
					step_data[stepIndex]['step_valid']=true;
					// if(new_user){
					// 	$refs.loginForm.nextStep();
					// 	return false;
					// }else{
					// 	$refs.loginForm.submitForm();
					// }
                    loginForm.value.submitStep();
				// });
			}else if(stepIndex===2){
				// $gtag('event','Register');

				// validateInput('full_name').then(resp=>{
					// if(!resp) return false;
					step_data[stepIndex]['step_valid']=true;
                    loginForm.value.submitStep();

				// });
			}


		};

        return { login_data, otpChange, step_data,validateStep,fullPage,formContainer,submit };
    },
    methods:{
        // validateStep(stepIndex){
        //run validation of step
        //if step is valid then
        // this.steps[stepIndex].step_valid=true;
        // this.$refs.multiStepForm.submitStep();
        //else show errors
        // },
        // submitForm(){
            // await axios.get('/sanctum/csrf-cookie');
        //api call to submit all data via post request
        //redirect to somewhere
        // }
    }
})
</script>