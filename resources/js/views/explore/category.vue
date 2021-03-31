<template>
  <div class="">
    <h1>{{ category_name }}</h1>
    <hr>
    <nav-tabs
      :tabs="tabs"
      :initial-tab="initialTab"
    >
      <template slot="tab-heading-about">
        {{ 'About' }}
      </template>
      <template slot="tab-panel-about">
        <div v-html="about" />
      </template>
      <template slot="tab-heading-courses">
        {{ 'Courses' }}
      </template>
      <template slot="tab-panel-courses">
        <div
          v-for="(course,index) in courses"
          :key="index"
        >
          <div class="card mt-2">
            {{ course.course_name }}<br>
            {{ course.duration }}<br>
            {{ course.eligibility }}
          </div>
        </div>
      </template>
      <template slot="tab-heading-subjects">
        {{ 'Subjects' }}
      </template>
      <template slot="tab-panel-subjects">
        <div
          v-for="(subject,index) in subjects"
          :key="index"
        >
          {{ subject.subject_name }}
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
              <h4>Share Your Knowledge</h4>
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
    <hr>
    <site-footer />
  </div>
</template>
<style scoped></style>
<script>
import SiteFooter from '../footer/SiteFooter';
import NavTabs from '../../components/NavTabs';
import PostCard from '../post/PostCard';
export default {
	components: {
		SiteFooter,
		NavTabs, PostCard
	},
	data() {
		return {
			posts: [],
			initialTab: 'about',
			tabs: [ 'about', 'courses', 'subjects', 'posts'],
			category_name: '',
			email: '',
			description: '',
			showLoader: false,
			about: '',
			courses: [],
			subjects: [],
		};
	},
	mounted() {
		console.log(this.$route.params.url);
		this.axios
			.get('/api/get-category-details/' + this.$route.params.url)
			.then(resp => {
				this.category_name = resp.data.success.category.name;
				this.posts = resp.data.success.posts.data;
				this.about = resp.data.success.category.about;
				this.courses = resp.data.success.category.courses;
				this.subjects = resp.data.success.category.subjects;
			});
	},
	methods: {
	}
};
</script>
