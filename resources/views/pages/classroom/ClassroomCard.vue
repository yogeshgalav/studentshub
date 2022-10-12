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
<div class="mx-auto my-4 h-96 w-80 rounded-md bg-white shadow-lg lg:mx-4">
  <div>
    <img class="object-fill h-28 w-80 rounded-t-md" src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxfDB8MXxyYW5kb218MHx8fHx8fHx8MTYzNDY4MTc2Mg&ixlib=rb-1.2.1&q=80&utm_campaign=api-credit&utm_medium=referral&utm_source=unsplash_source&w=1080" alt="">
  </div>
  <div class="mx-6 flex flex-row items-center">
    <img class="h-16 w-16 -translate-y-6 rounded-full border-2 border-solid border-white" src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
    <a href="http://">
      <div class="ml-4 -translate-y-2 text-2xl font-bold hover:text-indigo-800">John</div>
    </a>
  </div>
  <hr class=" mx-auto w-72 h-1 bg-gray-200 rounded border-0">
  <div class="mx-8 mt-6 text-sm text-slate-700">Category > Subcategory</div>
  <div class="mx-8"><a href="http://">
      <div class="my-2 text-3xl font-bold hover:text-indigo-800">Subject Name</div>
    </a></div>
  <div class="mx-8 text-sm text-slate-700">About Course</div>
  <div class="mx-4 mb-4 mt-6">
    <a href="#">
      <div class="rounded-lg bg-indigo-700 px-8 py-2 text-center text-lg font-semibold text-white hover:bg-indigo-800">Follow</div>
    </a>
  </div>
</div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
    setup() {
    },
});
</script>