<template>
  <div class="content">
    <h1>{{ subject_name }}</h1>
    <hr>
    <nav-tabs
      :tabs="tabs"
      :initial-tab="initialTab"
    >
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
              <a :href="'/share-your-knowledge?sId='+subjectId">Get Started</a>
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
	props:['subjectId'],
	data() {
		return {
			posts: [],
			initialTab: 'posts',
			tabs: ['posts'],
			subject_name: '',
			email: '',
			description: '',
			showLoader: false
		};
	},
	mounted() {
		this.axios
			.get('/api/subject/' + this.subjectId)
			.then(resp => {
				this.subject_name = resp.data.success.subject.subject_name;
				this.posts = resp.data.success.posts.data;
			});
	},
	methods: {
	}
};
</script>
