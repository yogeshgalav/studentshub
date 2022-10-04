<template>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<div class="container-fluid mt-5">
    <div class="row">
        <div
            v-for="(classroom, index) in classrooms"
            :key="index"
            class="col-md-4 mb-2"
          >
            <div class="card">
                <img class="card-img-top" src="" alt="Card image" style="width:100%">
                <div class="card-body">
                <h4 class="card-title">{{ classroom.category.name }}</h4>
                <p class="card-text">{{ classroom.course.name }}</p>
                <p class="card-text">{{ classroom.subject.name }}</p>
                <p class="card-text">{{ classroom.institute.name }}</p>
                <a v-bind:href="'/classroom/' + classroom.id " class="btn btn-primary">See Classroom</a>
                </div>
            </div>
          </div>
    </div>
</div>
</template>
<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
    setup() {
        
    },
    props: ['classrooms'],
    data() {
		return {};
	},
    
})
</script>
