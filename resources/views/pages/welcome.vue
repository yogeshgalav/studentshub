
<template>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<div class="container mt-5">
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
</div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
    setup() {
		
    },
	data() {
		return {
			phone_number: '',
			otp: '',
			first_name: '',
            last_name: '',
		};
	},
	mounted(){
		
	},methods:{
		loginForm() {

					this.axios.post('/api/login', {
						phone_number: this.phone_number,
						otp: this.otp,
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