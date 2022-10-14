<template>

    <div class="container mx-auto">
        <!-- <div class="my-8 mx-4">
            <a class="rounded-lg font-semibold text-lg px-10 py-4 bg-indigo-500 text-white hover:bg-indigo-700"
                href="#">+ Create Classroom</a>
        </div> -->
        <div class="d-flex my-4 mx-auto lg:mx-8 w-4/5 lg:w-2/4 flex-col flex-wrap rounded-md bg-white p-6 shadow-md">
            <div class="mb-4 text-center text-2xl font-semibold">Create Classroom</div>
            <div class="form-group">
                <label for="" class="text-md font-xl my-2">Collage/Institute Name</label>
                <input class="form-control" type="text" placeholder="" />
            </div>
            <div class="form-group">
                <label for="" class="text-md font-xl my-2">Classroom Name</label>
                <input class="form-control" type="text" placeholder="" />
            </div>
            <div class="form-group">
                <label for="" class="text-md font-xl my-2">Program/Course Level</label>
                <input class="form-control" type="text" placeholder="" />
            </div>
            <div class="form-group">
                <label for="" class="text-md font-xl my-2">Subject of Classroom</label>
                <input class="form-control" type="text" placeholder="" />
            </div>
            <div class="mb-4 mt-12 text-right"><a href="#" class="text-md btn-primary">Create</a></div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 m-4">

            <div v-for="(classroom, index) in classrooms" :key="index" class="col-md-4 mb-2">
                <ClassroomCard></ClassroomCard>

            </div>
        </div>
    </div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import axios from 'axios';
import ClassroomCard from './ClassroomCard.vue';
export default defineComponent({
    setup() {
    },
    data() {
        return {
            classrooms: [1, 2, 3, 4, 5],
        };
    },
    mounted() {
        axios.get("/api/classrooms").then((resp) => {
            console.log(resp.data);
            this.classrooms = resp.data.success.classroom;
        });
    },
    components: { ClassroomCard }
})
</script>
