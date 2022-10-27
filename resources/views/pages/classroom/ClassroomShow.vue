<template>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
<div class="container-fluid mt-5">
    <NavTab :tabs="['Tab1', 'Tab2', 'Tab3']"></NavTab>
    <!-- <div class="h3">
        category id = {{ classroom.category.name }}
    </div>
    <div class="h3">
        course id = {{ classroom.course.name }}
    </div>
    <div class="h3">
        subject id = {{ classroom.subject.name }}
    </div>
    <div class="h3">
        institute id = {{ classroom.institute.name }}
    </div> -->
</div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import axios from 'axios';
import ClassroomCreateVue from './ClassroomCreate.vue';
import MultiStepForm from '../components/MultiStepForm.vue';
import NavTab from '../../components/NavTab.vue';

export default defineComponent({
    setup() {
    },
    component: { NavTab },
    data() {
        return {
            classroom: [],
        };
    },
    mounted() {
        axios.get("/api/classroom/" + this.classroom.id).then((resp) => {
            console.log(resp.data);
            this.classroom = resp.data.success.classroom;
        });
    },
    components: { NavTab }
})
</script>
