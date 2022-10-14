<template>

    <div class="container mx-auto">
        <!-- <div class="my-8 mx-4">
            <a class="rounded-lg font-semibold text-lg px-10 py-4 bg-indigo-500 text-white hover:bg-indigo-700"
                href="#">+ Create Classroom</a>
        </div> -->
        

        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 m-4">

            <div v-for="(classroom, index) in classrooms" :key="index" class="col-md-4 mb-2">
                <ClassroomCard :classroom-detail="classroom_detail"></ClassroomCard>

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
            classroom_detail:{
                'id':1,
                'category':'Computer Application',
                'subject':'Electronic device and circuit',
                'subject_alias':'EDC',
                'institute':'poornima',
                'course':'btech',
                'teacher':'Priya',
                'profile_pic':'/images/1.png'
            }
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
