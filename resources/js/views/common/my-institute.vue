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
        <div class="col-md-8 col-12">
          <button
            v-if="isCourseValid"
            type="button"
            class="btn btn-md btn-primary mt-1"
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
                <div class="card-body">
                  <p>Invite your teachers to join StudentsHub..</p>
                </div>
              </div>
            </div>
          </div>
          <div
            v-else
            class="row"
          >
            <div class="col-md-8 col-12">
              <div
                v-for="(teacher,index) in teachers"
                :key="index"
                class="card mb-2"
              >
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="text-center">
                        <div style="text-align: -webkit-center">
                          <profile-image
                            :user-name="teacher.full_name"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-10">
                      <p class="mb-0 font-weight-bold text-black">
                        <a :href="'/profile/'+teacher.id"> {{ teacher.full_name }}</a>
                      </p>
                      <span class="font-weight-normal">
                        {{ teacher.preferred_course ? teacher.preferred_course.course_name : '' }}
                      </span>
                    </div>
                  </div>
                </div>
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
                <div class="card-body">
                  <p>Invite your friends to join Student's Hub.</p>
                </div>
              </div>
            </div>
          </div>
          <div
            v-else
            class="row"
          >
            <div class="col-md-8 col-12">
              <div
                v-for="(student,index) in students"
                :key="index"
                class="card mb-2"
              >
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="text-center">
                        <div style="text-align: -webkit-center">
                          <profile-image
                            :user-name="student.full_name"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-10">
                      <p class="mb-0 font-weight-bold text-black">
                        <a :href="'/profile/'+student.id"> {{ student.full_name }}</a>
                      </p>
                      <span class="font-weight-normal">
                        {{ student.preferred_course ? student.preferred_course.course_name : '' }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>

        <template slot="tab-heading-posts">
          {{ 'Posts' }}
        </template>
        <template slot="tab-panel-posts">
          <div class="row">
            <div class="col-md-10">
              <div class="card mb-3 mt-2 pt-0 pb-0">
                <div class="card-body">
                  <div class="row pl-3">
                    <profile-image
                      size="small"
                      :user-name="AuthUser.full_name"
                      :avatar="AuthUser.avatar_url"
                    />&nbsp;&nbsp;
                    {{ AuthUser.full_name }}
                  </div>
                  <a
                    :href="'/share-your-knowledge'"
                  > 
                    <img
                      src="/images/knowledge.svg"
                      alt=""
                    >&emsp;
                    Share Your Knowledge &emsp;<span><i
                      class="fa fa-arrow-right"
                      aria-hidden="true"
                    /></span>  
                  </a>
                  <profile-image />
                </div>
              </div>
              <div
                v-if="!posts.length"
                class="card"
              >
                <div class="card-body">
                  <p>Currently no post have been shared yet to this institute.</p>
                </div>
              </div>
              <div v-else>
                <div
                  v-for="(post,index) in posts"
                  :key="index"
                >
                  <post-card :post="post" />
                </div>
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
import PostCard from '../post/PostCard';

export default {
	components: {
		NavTabs, PostCard, SelectInstitute
	},
	data() {
		return {
			institute_name: '',
			teachers: [],
			students: [],
			posts: [],
			initialTab: 'teachers',
			tabs: ['teachers','students','posts'],
			showLoader: false,
			selected_institute : {
				'id': null,
				'name':'',
			}
		};
	},
	computed:{
		isCourseValid(){
			if(this.selected_institute && this.selected_institute.name){
				return true;
			}
			return false;
		}
	},
	mounted() {
		let institute_id = this.AuthUser.preferred_institute_id;

		if(!institute_id) return false;
    
		this.axios
			.get('/api/institute/' + (institute_id ? institute_id : ''))
			.then(resp => {
				this.teachers = resp.data.success.teachers;
				this.institute_name = resp.data.success.institute.name;
				this.students = resp.data.success.students;
				this.posts = resp.data.success.posts;
				this.$forceUpdate();
			});
	},
	methods: {
		submitCourse(){
			this.axios
				.put('/api/preferred-institute',{
					preferred_institute:this.selected_institute,
				})
				.then(resp => {
					window.location.reload();
				});
		}
	}
};
</script>
