
<template>

	<div class="container mt-5">
    <div id="app" class="d-flex my-4 mx-auto lg:mx-8 w-4/5 lg:w-2/4 flex-col flex-wrap rounded-md bg-white p-6 shadow-md">
            <div class="mb-4 text-center text-2xl font-semibold">Create Classroom</div>
            <form @submit.prevent="classroomCreate">
              <div class="form-group">
                <label for="" class="text-md font-xl my-2">Subject Name</label>
                <Autocomplete
                @setResult="setSubject"
                  @input="onChangeSubject"
                  :items="subjects"
                />
            </div>
            <div class="form-group">
              <label for="" class="text-md font-xl my-2">Category</label>
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
            <div class="form-group">
                <label for="" class="text-md font-xl my-2">Course Name</label>
                <Autocomplete
                @setResult="setCourse"
                  @input="onChangeCourse"
                  :items="courses"
                />
            </div>
            <div class="form-group">
                <label for="" class="text-md font-xl my-2">Institute Name</label>
                <Autocomplete
                  @setResult="setInstitute"
                  @input="onChangeInstitute"
                  :items="institutes"
                />
            </div>
            <div class="mb-4 mt-12 text-right"><a href="#" class="text-md btn-primary">Create</a></div>
            </form>
        </div>
</div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import Autocomplete from '../../components/Autocomplete.vue';
import axios from 'axios';

export default defineComponent({
  name: 'App',
    components: {
      Autocomplete
    },
    data(){
        return {
            institutes:[],
            courses:[],
            subjects:[],
            institute:null,
            categories:'',
            category:null,
            course:null,
            subject:null,
        };
    },
    mounted(){
      axios.get("/api/categories").then((resp) => {
              console.log(resp.data);
              this.categories = resp.data.success.categories;
          });
    },
  methods:{

    onChangeInstitute(e){
            let searchTerm =e.target.value;
            axios.get("/api/institutes?searchTerm="+searchTerm).then((resp) => {
              this.institutes = resp.data.success.institutes;
          });
        },

        onChangeCourse(e){
            let searchTerm =e.target.value;
            axios.get("/api/courses?searchTerm="+searchTerm).then((resp) => {
              this.courses = resp.data.success.courses;
          });
        },

    onChangeSubject(e){
            let searchTerm =e.target.value;
            axios.get("/api/subjects?searchTerm="+searchTerm).then((resp) => {
              this.subjects = resp.data.success.subjects;
          });
        },

        setInstitute(obj){
          this.institute = obj;
        },
        setCourse(obj){
          this.course = obj;
        },
        setSubject(obj){
          this.subject = obj;
        },

    classroomCreate() {
					axios.get('/api/classroom/create', {
						category: this.categories,
						course: this.course,
						subject: this.subject,
            institute: this.institute,
					}).then(resp=>{
						console.log(resp);
						});

			return true;
		},
	}
})
</script>