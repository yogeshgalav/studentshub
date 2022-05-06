<template>
  <div>
    <nav-tabs
      :tabs="tabs"
      :initial-tab="initialTab"
      @changeTab="changeTab"
    >
      <template slot="tab-heading-posts">
        Posts
      </template>
      <template slot="tab-panel-posts">
        <div class="row">
          <div
            v-if="!posts.length"
            class="col-md-10"
          >
            <p>No search result found.</p>
          </div>
          <div class="col-md-10">
            <div
              v-for="(post,index) in posts"
              :key="index"
            >
              <post-card :post="post" />
            </div>
          </div>
        </div>
      </template>
      <template slot="tab-heading-students">
        Students
      </template>
      <template slot="tab-panel-students">
        <div class="row">
          <div
            v-if="!users.length"
            class="col-md-10"
          >
            <p>No search result found.</p>
          </div>
          <div class="col-md-10">
            <div 
              v-for="(user,index) in users"
              :key="index"
              class="card mb-2"
            >
              <div class="card-body">
                <a
                  class="text-black"
                  :href="'/profile/'+user.id"
                >
                  <div class="card-body">
                    <div class="dashboard_post">
                      <div class="avatar">
                        <profile-image
                          :user-name="user.full_name"
                          :avatar="user.avatar_url"
                        />
                      </div>
                      <div class="info-post ml-2 dash_insititue_name">
                        <p class="font-size-14 mb-0 dash_user_date">
                          {{ user.full_name }}
                        </p>
                        <p class="font-size-14 mb-0">
                          {{ user.institute_name }}
                        </p>
                        <p class="font-size-14 mb-0">
                          {{ user.course_name }}
                        </p>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </template>
      <template slot="tab-heading-teachers">
        Teachers
      </template>
      <template slot="tab-panel-teachers">
        <div class="row">
          <div
            v-if="!users.length"
            class="col-md-10"
          >
            <p>No search result found.</p>
          </div>
          <div class="col-md-10">
            <div 
              v-for="(user,index) in users"
              :key="index"
              class="card mb-2"
            >
              <div class="card-body">
                <a
                  class="text-black"
                  :href="'/profile/'+user.id"
                >
                  <div class="card-body">
                    <div class="dashboard_post">
                      <div class="avatar">
                        <profile-image
                          :user-name="user.full_name"
                          :avatar="user.avatar_url"
                        />
                      </div>
                      <div class="info-post ml-2 dash_insititue_name">
                        <p class="font-size-14 mb-0 dash_user_date">
                          {{ user.full_name }}
                        </p>
                        <p class="font-size-14 mb-0">
                          {{ user.institute_name }}
                        </p>
                        <p class="font-size-14 mb-0">
                          {{ user.course_name }}
                        </p>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </template>
      <template slot="tab-heading-subjects">
        Subjects
      </template>
      <template slot="tab-panel-subjects">
        <div class="row">
          <div
            v-if="!subjects.length"
            class="col-md-10"
          >
            <p>No search result found.</p>
          </div>
          <div class="col-md-10">
            <div 
              v-for="(subject,index) in subjects"
              :key="index"
              class="card mb-2"
            >
              <div class="card-body">
                <a
                  :href="'/subject/'+subject.slug" 
                  class="text-black font-size-18"
                >{{ subject.subject_name }}</a>
              </div>
            </div>
          </div>
        </div>
      </template>
      <template slot="tab-heading-courses">
        Courses
      </template>
      <template slot="tab-panel-courses">
        <div class="row">
          <div
            v-if="!courses.length"
            class="col-md-10"
          >
            <p>No search result found.</p>
          </div>
          <div class="col-md-10">
            <div 
              v-for="(course,index) in courses"
              :key="index"
              class="card mb-2"
            >
              <div class="card-body">
                <a
                  :href="'/course/'+course.slug" 
                  class="text-black font-size-18"
                >
                  {{ course.course_name }}
                </a>
              </div>
            </div>
          </div>
        </div>
      </template>
      <template slot="tab-heading-institutes">
        Institutes
      </template>
      <template slot="tab-panel-institutes">
        <div class="row">
          <div
            v-if="!institutes.length"
            class="col-md-10"
          >
            <p>No search result found.</p>
          </div>
          <div class="col-md-10">
            <div 
              v-for="(institute,index) in institutes"
              :key="index"
              class="card mb-2"
            >
              <div class="card-body">
                {{ institute.name }}
              </div>
            </div>
          </div>
        </div>
      </template>
    </nav-tabs>
  </div>
</template>
<script>
import NavTabs from '@/components/NavTabs.vue';
import CommonLayout from '@/Layouts/CommonLayout.vue';
import PostCard from '../post/PostCard';

export default {
	layout:CommonLayout,
	components:{
		NavTabs,PostCard,
	},
	props:['searchQuery'],
	data(){
		return {
			tabs:['posts','teachers','students','subjects','courses','institutes'],
			initialTab: 'posts',
			posts:[],
			subjects:[],
			courses:[],
			institutes:[],
			users:[],
		};
	},
	mounted(){
		this.searchPost();
	},
	methods:{
		changeTab(tabName){
			switch(tabName) {
			case 'posts':
				this.searchPost();
				break;
			case 'students':
				this.searchUser('student');
				break;
			case 'teachers':
				this.searchUser('teacher');
				break;
			case 'subjects':
				this.searchSubject();
				break;
			case 'courses':
				this.searchCourse();
				break;
			case 'institutes':
				this.searchInstitute();
				break;
			}
		},
		searchPost(){
			this.axios.get('/api/search-posts?searchTerm='+this.searchQuery).then((resp)=>{
				this.posts = resp.data.success.posts;
			});
		},
		searchUser(role){
			this.axios.get('/api/search-user?role='+role+'&searchTerm='+this.searchQuery).then((resp)=>{
				this.users = resp.data.success.users;
			});
		},
		searchSubject(){
			this.axios.get('/api/search-subject?searchTerm='+this.searchQuery).then((resp)=>{
				this.subjects = resp.data.success.subjects;
			});
		},
		searchCourse(){
			this.axios.get('/api/search-course?searchTerm='+this.searchQuery).then((resp)=>{
				this.courses = resp.data.success.courses;
			});
		},
		searchInstitute(){
			this.axios.get('/api/search-institute?searchTerm='+this.searchQuery).then((resp)=>{
				this.institutes = resp.data.success.institutes;
			});
		},
	}
};
</script>
