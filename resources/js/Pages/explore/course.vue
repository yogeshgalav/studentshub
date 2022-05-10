<template>
  <div>
    <Head>
      <title>{{ course_name }}</title>
      <meta
        name="description"
        :content="course_name"
      >
    </Head>
    <h1>{{ course.course_name }}</h1>
    <hr>
    <nav-tabs
      :tabs="tabs"
      :initial-tab="initialTab"
    >
      <template slot="tab-heading-posts">
        {{ 'Posts' }}
      </template>
      <template slot="tab-panel-posts">
        <PostContainer
          v-if="course.id"
          :post-route="'/course/'+course.id"
          :share-route="'/share-your-knowledge?cId='+course.id"
        >
          <template slot="empty">
            Currently no post have been shared in this course.
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
            Currently no doubt have been shared in your course.
          </template>
        </DoubtContainer>
      </template>
    </nav-tabs>
  </div>
</template>
<style scoped></style>
<script>
import NavTabs from '../../components/NavTabs';
import PostContainer from '../common/post-container';
import DoubtContainer from '@/Pages/doubt/doubt-container.vue';
import { Head } from '@inertiajs/inertia-vue';

export default {
	components: {
		NavTabs, PostContainer, DoubtContainer, Head
	},
	props:['course'],
	data() {
		return {
			initialTab: 'posts',
			tabs: ['posts'],
			course_name: '',
			email: '',
			description: '',
			showLoader: false
		};
	},
	mounted() {
		this.axios
			.get('/api/course/' + this.course.id)
			.then(resp => {
				this.courses_name = resp.data.success.category.courses.course_name;
			});
	},
	methods: {
	}
};
</script>
