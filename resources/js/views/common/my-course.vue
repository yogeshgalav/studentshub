<template>
  <div class="row">
    <div class="col-md-12">
      <h1>My Course</h1>
    </div>
    <hr>
    <div class="col-md-12">
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
                  :href="'/subject/'+subject.subject_url" 
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
            <div class="col-md-5 center-col">
              <div class="sh_kn">
                <img src="/images/noun_knowledge.svg">
                <h4>Be the first person to share post for your course.</h4>
                <a href="/share-your-knowledge">Get Started</a>
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
	props:['courseId'],
	data() {
		return {
			posts: [],
			subjects: [],
			initialTab: 'posts',
			tabs: ['posts'],
			email: '',
			description: '',
			showLoader: false
		};
	},
	mounted() {
		this.axios
			.get('/api/get-course-details/' + this.courseId)
			.then(resp => {
				this.subjects = resp.data.success.subjects;
				this.posts = resp.data.success.posts.data;
			});
	},
	methods: {
	}
};
</script>
