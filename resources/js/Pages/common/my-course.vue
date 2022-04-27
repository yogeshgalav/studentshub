<template>
  <div class="row">
    <div class="col-md-12  mt-3">
      <h1>{{ course_name ? course_name : 'My Course' }}</h1>
    </div>
    <hr>
    <div
      v-if="!AuthUser.preferred_course_id"
      class="col-md-12"
    >
      <div class="row">
        <div class="col-md-8 col-12">
          <p class="text-blue weight-600 mb-2 mt-3">
            Enter your preferred course name to see it's subject and posts.
          </p>
          <select-course v-model="selected_course" />
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
      </div>
    </div>
    <div
      v-if="AuthUser.preferred_course_id"
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
              <div v-if="!subjects.length">
              <img class="img-cs" src="/images/search-not-found.png" />
              <p style="text-align:center;">
                Currently no subject have been shared related to this category.
              </p>
              </div>
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
        <template slot="tab-heading-posts">
          {{ 'Posts' }}
        </template>
        <template slot="tab-panel-posts">
          <PostContainer
            v-if="AuthUser.preferred_course_id"
            :post-route="'/course/'+AuthUser.preferred_course_id"
            :share-route="'/share-your-knowledge?cId='+AuthUser.preferred_course_id"
          >
            <template slot="empty">
              <img class="img-cs" src="/images/search-not-found.png"/>
              <p style="text-align:center;">
              Currently no post have been shared in your course.
              </p>
            </template>
          </PostContainer>
        </template>
        <template slot="tab-heading-doubts">
          {{ 'Doubts' }}
        </template>
        <template slot="tab-panel-doubts">
          <DoubtContainer
            v-if="AuthUser.preferred_course_id"
            :doubt-route="'/course/'+AuthUser.preferred_course_id"
          >
            <template slot="empty">
              <div >
              <img class="img-cs" src="/images/search-not-found.png"/>
              </div>
              <p style="text-align:center;">
              Currently no doubt have been shared in your course.
              </p>
            </template>
          </DoubtContainer>
        </template>
      </nav-tabs>
    </div>
  </div>
</template>
<style scoped></style>
<script>
import NavTabs from '../../components/NavTabs';
import SelectCourse from '../../components/SelectCourse.vue';
import PostContainer from './post-container.vue';
import DoubtContainer from '@/Pages/doubt/doubt-container.vue';

export default {
	components: {
		NavTabs, PostContainer, DoubtContainer, SelectCourse
	},
	data() {
		return {
			course_name: '',
			posts: [],
			subjects: [],
			initialTab: 'posts',
			tabs: ['posts', 'doubts', 'subjects'],
			showLoader: false,
			selected_course : {
				'id': null,
				'course_name':'',
			}
		};
	},
	computed:{
		isCourseValid(){
			if(this.selected_course && this.selected_course.course_name){
				return true;
			}
			return false;
		}
	},
	mounted() {
		let course_id = this.AuthUser.preferred_course_id;

		if(!course_id) return false;
    
		this.axios
			.get('/api/course/' + (course_id ? course_id : ''))
			.then(resp => {
				this.subjects = resp.data.success.subjects;
				this.course_name = resp.data.success.course.course_name;
				this.posts = resp.data.success.posts.data;
			});
	},
	methods: {
		submitCourse(){
			this.axios
				.put('/api/preferred-course',{
					preferred_course:this.selected_course,
				})
				.then(resp => {
					window.location.reload();
				});
		}
	}
};
</script>
