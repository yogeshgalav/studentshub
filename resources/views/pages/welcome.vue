
<template>
    <div class="w-100% min-h-screen bg-slate-100">
        <!-- navbar -->
        <nav class="lg:px-16 px-6 bg-white d-flex flex-wrap items-centern shadow-md md:py-3 py-3">
            <div class="flex-1 d-flex justify-between items-center text-2xl">
                <a href="/">
                </a>
            </div>

            <div class="d-flex md:items-center md:w-auto" id="menu">
                <ul class=" hidden md:flex md:items-center md:justify-between text-base text-gray-900 pt-4 md:pt-0">
                    <li><a class="btn" href="#">Home</a></li>
                    <li><a class="btn" href="#">About</a></li>
                    <li><a class="btn" href="#">Documentation</a></li>
                    <li><a class="btn" href="#">Contact</a></li>
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

        <div class="Container w-100% h-100vh d-flex flex-col items-center lg:flex-row justify-around">
            <div class="w-2/5">
                <h1 class="text-[2.5em] mx-4 my-8 font-bold text-center">
                    World's First Education Network
                </h1>
                <h2 class="text-justify text-lg">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, consequatur repellendus?
                    Beatae natus nulla assumenda modi magnam provident animi blanditiis quos ut iusto. Neque quos
                    voluptatibus debitis officia explicabo similique veritatis nostrum perferendis commodi laborum
                    tempore molestiae, ad pariatur dolor quam alias. Harum, facere! Aspernatur?
                </h2>
            </div>
            <!-- Login Form -->
            <div class="w-96 my-4 d-flex flex-col flex-wrap bg-white border border-slate-300">
                <div class="text-2xl my-6 font-semibold text-center">Login
                </div>
                <div class="mx-8 mb-2 d-flex flex-col">
                    <label for="Phonenumber" class="my-2 text-lg font-2xl">Phone Number</label>
                    <input class="form-control" type="tel" placeholder="Enter Phone Number">
                </div>
                <div class="mx-8 my-2 d-flex flex-col">
                    <label class="my-2 text-lg font-2xl" for="otp">OTP</label>
                    <input class="form-control" type="text" inputmode="numeric" required placeholder="Enter OTP">
                </div>
                <div class="mx-8 my-2 d-flex flex-col">
                    <label for="Phonenumber" class="my-2 text-lg font-2xl">First Name</label>
                    <input class="form-control" type="text" placeholder="Enter First Name">
                </div>
                <div class="mx-8 mt-2 d-flex flex-col">
                    <label for="Phonenumber" class="my-2 text-lg font-2xl">Last Name</label>
                    <input class="form-control" type="text" placeholder="Enter Last Name">
                </div>
                <div class="text-center mx-6 mt-14 mb-12"><a href="#" class="text-md btn-primary">Login</a></div>
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
    mounted() {

    }, methods: {
        loginForm() {

            this.axios.post('/api/login', {
                phone_number: this.phone_number,
                otp: this.otp,
                first_name: this.first_name,
                last_name: this.last_name,
            }).then(resp => {
                console.log(resp);
            });

            return true;
        },
    }
})
</script>