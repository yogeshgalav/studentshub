<template>
  <div>
    <Head>
      <title>{{ category.name }}</title>
      <meta name="description" :content="category.name">
    </Head>
    <div class="row">
      <div class="col-md-10 col-12 text-center">
          <h1>{{ category.name }}</h1>
      </div>
      <div class="col-md-10 col-12">
        
        <nav-tabs
          :tabs="tabs"
          :initial-tab="initialTab"
        >
          <template slot="tab-heading-about">
            {{ 'About' }}
          </template>
          <template slot="tab-panel-about">
            <div id="about-html" />
            <div v-if="category.slug">
            <component v-bind:is="categoryBlog"></component>
            </div>
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
                :href="'/course/'+course.slug"
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
          <SubjectContainer
            v-if="categoryId"
            :subject-route="'/category/'+categoryId"
            :subjects="subjects"
          >
            <template slot="empty">
              <img
                class="search-not-found"
                src="/images/search-not-found.png"
              >
              <p style="text-align:center;">
                Currently no Subject have been shared in your course.
              </p>
            </template>
          </SubjectContainer>
        </template>
          <template slot="tab-heading-posts">
            {{ 'Posts' }}
          </template>
          <template slot="tab-panel-posts">
            <PostContainer
              v-if="categoryId"
              :post-route="'/category/'+categoryId"
              :share-route="'/share-your-knowledge?caId='+categoryId"
            >
              <template slot="empty">
                  <img class="search-not-found" src="/images/search-not-found.png"/>
                <p style="text-align:center;">
                Currently no post have been shared related to this category.
                </p>
              </template>
            </PostContainer>
          </template>
        </nav-tabs>
      </div>
    </div>
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
import NavTabs from '../../components/NavTabs';
import PostContainer from '../common/post-container';
import CommonLayout from '@/Layouts/CommonLayout';
import SubjectContainer from '@/Pages/common/subject-container.vue';
import { Head } from '@inertiajs/inertia-vue';

export default {
  layout: CommonLayout,
	components: {
		NavTabs, PostContainer,Head,SubjectContainer,
	},
	props:['categoryId'],
	data() {
		return {
			posts: [],
			initialTab: 'about',
			tabs: [ 'about', 'courses', 'subjects', 'posts'],
			category: '',
			email: '',
			description: '',
			showLoader: false,
			about: '',
			courses: [],
			subjects: [],
		};
	},

  computed:{
    categoryBlog(){
      if(this.category && this.category.slug){
        return () => import('@/Pages/category-blogs/'+this.category.slug);
      }
      return '';
    }
  },
	mounted() {
		this.axios
			.get('/api/category/' + this.categoryId)
			.then(resp => {
				this.category = resp.data.success.category;
				this.about = resp.data.success.category.about;
				this.courses = resp.data.success.category.courses;
				this.subjects = resp.data.success.category.subjects;
				// this.addRow();
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
