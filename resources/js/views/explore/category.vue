<template>
  <div>
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
        <div id="about-html" />
      </template>
      <template slot="tab-heading-courses">
        {{ 'Courses' }}
      </template>
      <template slot="tab-panel-courses">
        <div
          v-for="(course,index) in courses"
          :key="index"
        >
          <router-link
            :to="'/course/'+course.slug"
            class="card mt-2"
          >
            <p class="mt-4 explore-name ml-2">
              {{ index+1 }}. &nbsp;{{ course.course_name }}
            </p>
            <p class="text-muted explore-content ml-4 pl-2">
              Duration: {{ course.duration ? course.duration : 'N/A' }}<br>
              Eligibility: {{ course.eligibility ? course.eligibility : 'N/A' }}
            </p>
          </router-link>
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
          <router-link
            :to="'/subject/'+subject.slug"
            class="card mt-2"
          >
            <p class="mt-4 explore-name ml-2">
              {{ index+1 }}. &nbsp;{{ subject.subject_name }}
            </p>
          </router-link>
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
<style>
.explore-name{
    line-height: 1;
    font-size: large;
    font-weight: 600;
}
.explore-content{
    font-size: larger;
}
.about-info-panel p{
    line-height: 30px;
    font-family: "Proxima Nova", sans-serif !important;
    margin-top: 24px;
    letter-spacing: -0.003em;
    font-size: 1.2rem;
    text-align:justify;
}
.about-info-panel .head{
    font-size: 1.7rem;
    line-height: 40px;
    font-weight: bold;
}
.about-info-panel .sub-head{
    font-size: 1.5rem;
    margin:20px 0px;
    font-weight:inherit;
}
</style>
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
				this.addRow();
			});
	},
	methods: {
		addRow() {
			const div = document.createElement('div');

			div.className = 'row';

			div.innerHTML =this.about;

			document.getElementById('about-html').appendChild(div);
		}

	}
};
</script>
