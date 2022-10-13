
<template>

	<div class="container mt-5">
    <div class="d-flex justify-content-center align-items-center">
        <div class="col-lg-5 card p-5">
            <div class="h3 text-center">Classroom Create</div>
            <form @submit.prevent="classroomCreate">
                <div class="mb-3">
                    <label class="mb-1"> {{ 'Category' }} </label>
					          <select
                        name="category"
                        class="form-control"
                      >
                        <option v-for="(classroom, index) in classrooms" 
                        :key="index"
                        :value="classroom.category.name">
                          {{ classroom.category.name}}
                        </option>
                      </select>
                </div>
                <div class="mb-3">
					<label class="mb-1"> {{ 'Course' }} </label>
					          <select
                        name="course"
                        class="form-control"
                      >
                        <option v-for="(classroom, index) in classrooms" 
                        :key="index"
                        :value="classroom.course.name">
                          {{ classroom.course.name}}
                        </option>
                      </select>
                </div>
                <div class="mb-3">
                    <label class="mb-1"> {{ 'Subject' }} </label>
                    <select
                        name="subject"
                        class="form-control"
                      >
                        <option v-for="(classroom, index) in classrooms" 
                        :key="index"
                        :value="classroom.subject.name">
                          {{ classroom.subject.name}}
                        </option>
                      </select>
                </div>
                <div class="mb-3">
                    <label class="mb-1"> {{ 'Institute' }} </label>
                    <select
                        name="institute"
                        class="form-control"
                      >
                        <option v-for="(classroom, index) in classrooms"
                         :key="index" 
                         :value="classroom.institute.name">
                          {{ classroom.institute.name }}
                        </option>
                      </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import axios from 'axios';

export default defineComponent({
    setup() {
		
    },
	data() {
		return {
			category_id: '',
			course_id: '',
			subject_id: '',
      institute_id: '',
      classrooms:'',
		};
	},
	mounted(){

      axios.get("/api/classrooms").then((resp) => {
              console.log(resp.data);
              this.classrooms = resp.data.success.classroom;
          });
		
	},methods:{
		classroomCreate() {

					axios.post('/api/classroom/create', {
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