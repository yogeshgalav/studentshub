<template>
    <!-- <div class="card">
                <img class="card-img-top" src="" alt="Card image" style="width:100%">
                <div class="card-body">
                <h4 class="card-title">{{ classroom.category.name }}</h4>
                <p class="card-text">{{ classroom.course.name }}</p>
                <p class="card-text">{{ classroom.subject.name }}</p>
                <p class="card-text">{{ classroom.institute.name }}</p>
                <a v-bind:href="'/classroom/' + classroom.id " class="btn btn-primary">See Classroom</a>
                </div>
            </div> -->
<div class="my-2 md:my-4 h-auto w-full md:w-[20rem] p-4 md:p-6 rounded-md bg-white shadow-lg mx-auto">
  <div class="mx-auto mb-4 flex flex-row items-center"> 
    <div class="h-16 w-16 rounded-full border-2 border-solid border-grey-200 bg-white text-2xl font-semibold text-gray-600 text-center py-3">Pr</div>
    <a href="http://">
      <div class="ml-4 text-xl md:text-2xl font-bold hover:text-blue-800">{{ classroomDetail.teacher }}</div>
    </a>
  </div>
  <hr class="w-[-10rem] h-1 bg-gray-200 rounded border-0">
  <div class="mt-6 text-sm text-slate-700">{{ classroomDetail.category }}</div>
  <div class=""><a :href="'/classroom/'+classroomDetail.id">
      <div class="my-2 text-2xl font-bold hover:text-blue-800">{{ classroomDetail.subject }}</div>
    </a></div>
  <div class="text-sm text-slate-700">{{ classroomDetail.course }}</div>
  <!-- <div class="mx-auto "> -->
      <div class="btn-primary mt-6 mx-auto">Follow</div>
  <!-- </div> -->
</div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
    setup() {
      
    },
    props:[
      'classroomDetail'
    ]
});
</script>