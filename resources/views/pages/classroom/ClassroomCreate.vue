
<template>

  <div class="container mt-5 grid lg:grid-cols-3  lg:gap-10 md:mx-auto">
    <div id="app"
      class="mx-auto w-11/12 md:w-11/12 lg:col-span-2 d-flex my-4 justify-center flex-col flex-wrap rounded-md bg-white p-6 shadow-md">
      <div class="mb-4 text-center text-2xl font-semibold">Create Classroom</div>
      <form @submit.prevent="classroomCreate">
        <div class="form-group">
          <label for="" class="text-md font-xl my-2">Subject Name</label>
          <Autocomplete @setResult="setSubject" @input="onChangeSubject" :items="subjects" />
        </div>
        <div class="form-group">
          <label for="" class="text-md font-xl my-2">Category</label>
          <select v-model="selected" name="category" class="form-control" @change="setCategory">
            <option v-for="(category, index) in categories" :key="index" :value="category.id">
              {{ category.name}}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label for="" class="text-md font-xl my-2">Course Name</label>
          <Autocomplete @setResult="setCourse" @input="onChangeCourse" :items="courses" />
        </div>
        <div class="form-group">
          <label for="" class="text-md font-xl my-2">Institute Name</label>
          <Autocomplete @setResult="setInstitute" @input="onChangeInstitute" :items="institutes" />
        </div>
          <div class="mb-4 mt-6 btn-primary mx-auto" value="submit">Create</div>
      </form>
    </div>
    <div class="mx-auto">
      <ClassroomCard :classroom-detail="classroom_detail"></ClassroomCard>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import Autocomplete from '../../components/Autocomplete.vue';
import ClassroomCard from './ClassroomCard.vue';
import axios from 'axios';

export default defineComponent({
  name: 'App',
  components: {
    Autocomplete, ClassroomCard
  },
  data() {
    return {
      institutes: [],
      courses: [],
      subjects: [],
      categories: '',
      institute: null,
      category: [],
      course: null,
      subject: null,
      selected: '',
      classroom_detail: {
                'id': 1,
                'category': 'Computer Application',
                'subject': 'Electronic device and circuit',
                'subject_alias': 'EDC',
                'institute': 'poornima',
                'course': 'btech',
                'teacher': 'Priya',
                'profile_pic': '/images/1.png'
            }
    };
  },
  mounted() {
    axios.get("/api/categories").then((resp) => {
      this.categories = resp.data.success.categories;
    });
  },
  methods: {

    onChangeInstitute(e) {
      let searchTerm = e.target.value;
      axios.get("/api/institutes?searchTerm=" + searchTerm).then((resp) => {
        this.institutes = resp.data.success.institutes;
      });
    },

    onChangeCourse(e) {
      let searchTerm = e.target.value;
      axios.get("/api/courses?searchTerm=" + searchTerm).then((resp) => {
        this.courses = resp.data.success.courses;
      });
    },

    onChangeSubject(e) {
      let searchTerm = e.target.value;
      axios.get("/api/subjects?searchTerm=" + searchTerm).then((resp) => {
        this.subjects = resp.data.success.subjects;
      });
    },

    setCategory(obj) {
      this.category.id = obj.target.value;
      this.category.name = obj.target.options[obj.target.options.selectedIndex].text;
    },

    setInstitute(obj) {
      this.institute = obj;
    },
    setCourse(obj) {
      this.course = obj;
    },
    setSubject(obj) {
      this.subject = obj;
    },
    classroomCreate() {
      console.log(this.category);
      axios.post('/api/classroom-create', {
        category: this.category,
        course: this.course,
        subject: this.subject,
        institute: this.institute,
      }).then(resp => {
        console.log(resp);
      });

      return true;
    },
  }
})
</script>