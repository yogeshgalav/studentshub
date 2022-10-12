
<template>

	<div class="container mt-5">
    <div class="d-flex justify-content-center align-items-center">
        <div class="col-lg-5 card p-5">
            <div class="h3 text-center">Classroom Create</div>
            <form @submit.prevent="classroomCreate">
                <div class="mb-3">
                    <label class="mb-1"> {{ 'Category' }} </label>
					<input
                        v-model="category_id"
                        type="number"
                        class="form-control"
                        name="category_id"
                      >
                </div>
                <div class="mb-3">
					<label class="mb-1"> {{ 'Course' }} </label>
					<input
                        v-model="course_id"
                        type="number"
                        class="form-control"
                        name="course_id"
                      >
                </div>
                <div class="mb-3">
                    <label class="mb-1"> {{ 'Subject' }} </label>
					<input
                        v-model="subject_id"
                        type="number"
                        class="form-control"
                        name="subject_id"
                      >
                </div>
                <div class="mb-3">
                    <label class="mb-1"> {{ 'Institute' }} </label>
					<input
                        v-model="institute_id"
                        type="number"
                        class="form-control"
                        name="institute_id"
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
			category_id: '',
			course_id: '',
			subject_id: '',
            institute_id: '',
		};
	},
	mounted(){
		
	},methods:{
		classroomCreate() {

					this.axios.post('/api/classroom/create', {
						category_id: this.category_id,
						course_id: this.course_id,
						subject_id: this.subject_id,
                        institute_id: this.institute_id,
					}).then(resp=>{
						console.log(resp);
						});

			return true;
		},
	}
})
</script>