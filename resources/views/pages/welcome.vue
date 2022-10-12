
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
    <div class="w-100% min-h-screen bg-slate-100">
        <!-- navbar -->
        <nav class="lg:px-16 px-6 bg-white d-flex flex-wrap items-centern shadow-md md:py-3 py-3">
            <div class="flex-1 d-flex justify-between items-center text-2xl">
                <a href="#">MyLogo
                </a>
            </div>

            <div class="d-flex md:items-center md:w-auto" id="menu">
                <ul class=" hidden md:flex md:items-center md:justify-between text-base text-gray-900 pt-4 md:pt-0">
                    <li><a class="btn" href="#">Home</a></li>
                    <li><a class="btn" href="#">Item1</a></li>
                    <li><a class="btn" href="#">Item2</a></li>
                    <li><a class="btn" href="#">Item3</a></li>
                </ul>

                <div class=" hidden md:flex md:flex-row"><input
                        class="md:py-1 md:px-4 border rounded-l hover:border-blue-700 focus:outline-none focus:border-blue-700 ml-2 "
                        type="text" placeholder="Search....">
                    <button
                        class="d-flex items-center justify-center px-4 border rounded-r text-gray-700 hover:bg-blue-700 hover:text-white focus:outline-none focus:border-blue-700">
                        <svg class="h-4 w-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M16.32 14.9l5.39 5.4a1 1 0 0 1-1.42 1.4l-5.38-5.38a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z" />
                        </svg>
                    </button>
                </div>

                <button class="md:hidden py-2 px-2 rounded focus:outline-none hover:bg-gray-200">
                    <div class="w-5 h-1 bg-gray-600 mb-1"></div>
                    <div class="w-5 h-1 bg-gray-600 mb-1"></div>
                    <div class="w-5 h-1 bg-gray-600 "></div>
                </button>
            </div>
        </nav>

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
                <div class="text-2xl mb-4 font-semibold text-center">Login
                </div>
                <div class="form-group">
                    <label for="Phonenumber" class="my-2 text-md font-xl">Phone Number</label>
                    <div class="flex">
                        <span
                            class="inline-flex items-center px-3 text-sm text-white bg-blue-700 rounded-l border border-r-0 border-blue-800">
                            +91
                        </span>
                        <input type="tel"
<<<<<<< HEAD
                            class="rounded-r border-2 hover:border-blue-700 focus:outline-none focus:border-blue-800 block flex-1 min-w-0 w-full p-2"
                            placeholder="Enter Your Phone Number">
                    </div>
                </div>
                <div class="form-group">
                    <label for="otp" class="my-2 text-md font-xl" >OTP</label>
                    <input class="form-control" type="text" inputmode="numeric" required placeholder="Enter OTP">
=======
                        v-model="login_data.phone_number"
                            class="rounded-r border-2 focus:outline-none focus:ring-blue-800 focus:border-blue-800 block flex-1 min-w-0 w-full p-2 "
                            placeholder="Enter Phone Number">
                    </div>
                </div>
                <div class="mx-8 my-2 d-flex flex-col">
                    <label class="my-2 text-lg font-2xl" for="otp">OTP</label>
                    <v-otp-input ref="otpInput" input-classes="form-control text-center w-16"
                        separator="&emsp;" :num-inputs="4" @on-change="otpChange" />

>>>>>>> 1e828141246f088b506d124ef3b7b22aabd4cf9a
                </div>
                <div class=" form-group">
                    <label for="Phonenumber" class="my-2 text-md font-xl">First Name</label>
                    <input class="form-control" type="text" placeholder="Enter Your First Name">
                </div>
                <div class="form-group">
                    <label for="Phonenumber" class="my-2 text-md font-xl">Last Name</label>
                    <input class="form-control" type="text" placeholder="Enter Your Last Name">
                </div>
                <div class="text-center mb-4 mt-12"><a href="#" class="text-md btn-primary">Login</a></div>
            </div>
        </main>
    </div>
</template>
<script lang="ts">
import { defineComponent, ref, reactive } from 'vue';
import axios from 'axios';
import VOtpInput from 'vue3-otp-input';

export default defineComponent({
    components: { VOtpInput },
    setup() {
        let login_data = reactive({
            phone_number: '',
            otp: '',
            first_name: '',
            last_name: '',
        });

        function otpChange(value: string) {
            console.log(value);
            login_data.otp = value;
            console.log(login_data,login_data.otp);
        };
        
        function loginForm() {
            axios.post('/api/login', login_data)
                .then(resp => {
                    console.log(resp);
                });

            return true;
        };

        return { login_data, otpChange, loginForm };
    },
})
</script>