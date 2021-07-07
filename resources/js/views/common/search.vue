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
          <div class="col-md-7 center-col">
            <div
              v-for="(post,index) in posts"
              :key="index"
            >
              <post-card :post="post" />
            </div>
          </div>
        </div>
      </template>
      <template slot="tab-heading-users">
        Users
      </template>
      <template slot="tab-panel-users">
        <div class="row">
          <div class="col-md-7 center-col">
            <div 
              v-for="(user,index) in users"
              :key="index"
              class="card mb-2"
            >
              <div class="card_post">
                <div class="card_box">
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
                    </div>
                  </div>
                </div>
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
          <div class="col-md-7 center-col">
            <div 
              v-for="(subject,index) in subjects"
              :key="index"
              class="card mb-2"
            >
              {{ subject.subject_name }}
            </div>
          </div>
        </div>
      </template>
      <template slot="tab-heading-courses">
        Courses
      </template>
      <template slot="tab-panel-courses">
        <div class="row">
          <div class="col-md-7 center-col">
            <div 
              v-for="(course,index) in courses"
              :key="index"
              class="card mb-2"
            >
              {{ course.course_name }}
            </div>
          </div>
        </div>
      </template>
      <template slot="tab-heading-institutes">
        Institutes
      </template>
      <template slot="tab-panel-institutes">
        <div class="row">
          <div class="col-md-7 center-col">
            <div 
              v-for="(institute,index) in institutes"
              :key="index"
              class="card mb-2"
            >
              {{ institute.name }}
            </div>
          </div>
        </div>
      </template>
    </nav-tabs>
  </div>
</template>
<script>
import NavTabs from '../../components/NavTabs.vue';
import PostCard from '../post/PostCard';

export default {
	components:{
		NavTabs,PostCard,
	},
	props:['searchQuery'],
	data(){
		return {
			tabs:['posts','subjects','courses','institutes'],
			initialTab: 'posts',
			posts:[],
			subjects:[],
			courses:[],
			institutes:[],
			users:[],
		};
	},
	mounted(){
		if(this.AuthUser){
			this.tabs.splice(1,0, 'users');
		}
		this.searchPost();
	},
	methods:{
		changeTab(tabName){
			switch(tabName) {
			case 'posts':
				this.searchPost();
				break;
			case 'users':
				this.searchUser();
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
				this.posts = resp.data.success.posts.data;
			});
		},
		searchUser(){
			this.axios.get('/api/search-user?searchTerm='+this.searchQuery).then((resp)=>{
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
