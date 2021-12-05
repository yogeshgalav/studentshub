<template>
  <div class="row">
    <div class="col-md-12 mt-3">
      <h1>{{ institute_name ? institute_name : 'My Institute' }}</h1>
    </div>
    <hr>
    <div
      v-if="!AuthUser.preferred_institute_id"
      class="col-md-12"
    >
      <div class="row">
        <div class="col-md-8 col-12">
          <p class="text-blue weight-600 mb-2 mt-3">
            Enter your preferred institute name to see Teachers and Students.
          </p>
          <select-institute v-model="selected_institute" />
        </div>
        <div class="col-md-3 col-12">
          <button
            v-if="isCourseValid"
            type="button"
            @click="submitCourse"
          >
            Submit
          </button>
        </div>
        <div class="col-md-12">
          <p class="mt-1 mb-2">
            You can change your preferred institute from account setting.
          </p>
        </div>
      </div>
    </div>
    <div
      v-if="AuthUser.preferred_institute_id"
      class="col-md-12"
    >
      <nav-tabs
        :tabs="tabs"
        :initial-tab="initialTab"
      >
        <template slot="tab-heading-subjects">
          {{ 'Subjects' }}
        </template>
        <template slot="tab-panel-subjects">
          <div class="row">
            <div class="col-md-7">
              <div 
                v-for="(subject,index) in subjects"
                :key="index"
                class="card mb-2"
              >
                <a
                  :href="'/subject/'+subject.slug" 
                  class="text-black font-size-18"
                >{{ subject.subject_name }}</a>
              </div>
            </div>
          </div>
        </template>
        <template slot="tab-heading-teachers">
          {{ 'Teachers' }}
        </template>
        <template slot="tab-panel-teachers">
          <div
            v-if="!teachers.length"
            class="row"
          >
            <div class="col-md-10">
              <div class="card">
                <p>Invite your teachers to join StudentsHub.</p>
              </div>
            </div>
          </div>
          <div
            v-else
            class="row"
          >
            <div class="col-md-5 center-col">
              <div
                v-for="(teacher,index) in teachers"
                :key="index"
              >
                <div>teacher</div>
              </div>
            </div>
          </div>
        </template>
        <template slot="tab-heading-students">
          {{ 'Students' }}
        </template>
        <template slot="tab-panel-students">
          <div
            v-if="!students.length"
            class="row"
          >
            <div class="col-md-10">
              <div class="card">
                <p>Invite your friends to join StudentsHub.</p>
              </div>
            </div>
          </div>
          <div
            v-else
            class="row"
          >
            <div class="col-md-5 center-col">
              <div
                v-for="(student,index) in students"
                :key="index"
              >
                <div>student</div>
              </div>
            </div>
          </div>
        </template>
      </nav-tabs>
    </div>
  </div>
</template>
<style scoped></style>
<script>
import NavTabs from '../../components/NavTabs';
import SelectInstitute from '../../components/SelectInstitute.vue';

export default {
	components: {
		NavTabs, SelectInstitute
	},
	data() {
		return {
			institute_name: '',
			teachers: [],
			students: [],
			initialTab: 'subjects',
			tabs: ['subjects','posts'],
			showLoader: false,
			selected_institute : {
				'id': null,
				'institute_name':'',
			}
		};
	},
	computed:{
		isCourseValid(){
			return true;
		}
	},
	mounted() {
		let institute_id = this.AuthUser.preferred_institute_id;

		if(!institute_id) return false;
    
		this.axios
			.get('/api/get-institute-details/' + (institute_id ? institute_id : ''))
			.then(resp => {
				this.teachers = resp.data.success.teachers;
				this.institute_name = resp.data.success.institute.name;
				this.students = resp.data.success.students;
			});
	},
	methods: {
		submitCourse(){
			this.axios
				.put('/api/preferred-institute')
				.then(resp => {
					this.teachers = resp.data.success.teachers;
					this.institute_name = resp.data.success.institute.name;
					this.students = resp.data.success.students;
				});
		}
	}
};
</script>
