<template>
  <div>
    <h1>{{ course_name }}</h1>
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
          v-if="courseId"
          :post-route="'/course/'+courseId"
        >
          <template slot="empty">
            Currently no post have been shared in this course.
          </template>
        </PostContainer>
      </template>
    </nav-tabs>
  </div>
</template>
<style scoped></style>
<script>
import NavTabs from '../../components/NavTabs';
import PostContainer from '../common/post-container';

export default {
	components: {
		NavTabs, PostContainer
	},
	props:['courseId'],
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
			.get('/api/course/' + this.courseId)
			.then(resp => {
				this.courses_name = resp.data.success.category.courses.course_name;
			});
	},
	methods: {
	}
};
</script>
