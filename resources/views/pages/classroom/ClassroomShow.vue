<template>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<div class="container-fluid mt-5">
    <div class="h3">
        category id = {{ classroom.category_id }}
    </div>
    <div class="h3">
        course id = {{ classroom.course_id }}
    </div>
    <div class="h3">
        subject id = {{ classroom.subject_id }}
    </div>
    <div class="h3">
        institute id = {{ classroom.institute_id }}
    </div>
</div>
</template>
<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
    setup() {
        
    },
    props: ['classroom'],
    data() {
		return {};
	},
})
</script>
