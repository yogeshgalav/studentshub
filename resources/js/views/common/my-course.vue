<template>
  <div class="row">
    <div class="col-md-12">
      <h1>{{ course_name ? course_name : 'My Course' }}</h1>
    </div>
    <hr>
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
        <template slot="tab-heading-posts">
          {{ 'Posts' }}
        </template>
        <template slot="tab-panel-posts">
          <div
            v-if="!posts.length"
            class="row"
          >
            <div class="col-md-10">
              <div class="card">
                <p>Currently no post have been shared yet to this course.</p>
              </div>
            </div>
          </div>
          <div
            v-else
            class="row"
          >
            <div class="col-md-5 center-col">
              <div
                v-for="(post,index) in posts"
                :key="index"
              >
                <post-card :post="post" />
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
import PostCard from '../post/PostCard';
export default {
	components: {
		NavTabs, PostCard
	},
	data() {
		return {
			course_name: '',
			posts: [],
			subjects: [],
			initialTab: 'subjects',
			tabs: ['subjects','posts'],
			showLoader: false
		};
	},
	mounted() {
		let course_id = this.AuthUser.preferred_course_id;
		this.axios
			.get('/api/get-course-details/' + (course_id ? course_id : ''))
			.then(resp => {
				this.subjects = resp.data.success.subjects;
				this.course_name = resp.data.success.course.name;
				this.posts = resp.data.success.posts.data;
			});
	},
	methods: {
	}
};
</script>
