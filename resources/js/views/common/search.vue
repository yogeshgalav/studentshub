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
      <template slot="tab-panel-users" />
      <template slot="tab-heading-subjects">
        Subjects
      </template>
      <template slot="tab-panel-subjects" />
      <template slot="tab-heading-courses">
        Courses
      </template>
      <template slot="tab-panel-courses" />
      <template slot="tab-heading-institutes">
        Institutes
      </template>
      <template slot="tab-panel-institutes" />
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
			this.axios.get('/api/get-search-posts?search_query='+this.searchQuery).then((resp)=>{
				this.posts = resp.data.success.posts.data;
			});
		},
		searchUser(){

		},
		searchSubject(){

		},
		searchCourse(){

		},
		searchInstitute(){

		},
	}
};
</script>
