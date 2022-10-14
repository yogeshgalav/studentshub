
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
                        <option v-for="(category, index) in categories" 
                        :key="index"
                        :value="category.id">
                          {{ category.name}}
                        </option>
                      </select>
                </div>
                <div class="mb-3">
					<label class="mb-1"> {{ 'Course' }} </label>
                    <select
                        name="course"
                        class="form-control"
                      >
                        <option v-for="(course, index) in courses" 
                        :key="index"
                        :value="course.id">
                          {{ course.name}}
                        </option>
                      </select>
                </div>
                <div class="mb-3">
                    <label class="mb-1"> {{ 'Subject' }} </label>
                    <select
                        name="subject"
                        class="form-control"
                      >
                        <option v-for="(subject, index) in subjects" 
                        :key="index"
                        :value="subject.id">
                          {{ subject.name}}
                        </option>
                      </select>
                </div>
                <div class="mb-3">
                    <label class="mb-1"> {{ 'Institute' }} </label>
                    <select
                        name="institute"
                        class="form-control"
                      >
                        <option v-for="(institute, index) in institutes"
                         :key="index" 
                         :value="institute.id">
                          {{ institute.name }}
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
			categories: '',
			courses: '',
			subjects: '',
      institutes: '',
		};
	},
	mounted(){

        axios.get("/api/subjects").then((resp) => {
              console.log(resp.data);
              this.subjects = resp.data.success.subjects;
          });

          axios.get("/api/categories").then((resp) => {
              console.log(resp.data);
              this.categories = resp.data.success.categories;
          });

          axios.get("/api/courses").then((resp) => {
              console.log(resp.data);
              this.courses = resp.data.success.courses;
          });

          axios.get("/api/institutes").then((resp) => {
              console.log(resp.data);
              this.institutes = resp.data.success.institutes;
          });

          // alert(this.category.categories.id);
		
	},methods:{
    
    classroomCreate() {
					axios.get('/api/classroom/create', {
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