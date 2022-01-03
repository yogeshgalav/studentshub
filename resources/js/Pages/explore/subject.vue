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
        <PostContainer
          v-if="subjectId"
          :post-route="'/subject/'+subjectId"
        >
          <template slot="empty">
            Currently no post have been shared related to this subject.
          </template>
        </PostContainer>
      </template>
    </nav-tabs>
  </div>
</template>
<style scoped></style>
<script>
import NavTabs from '../../components/NavTabs';
import PostContainer from '../common/post-container.vue';

export default {
	components: {
		PostContainer,
		NavTabs,
	},
	props:['subjectId'],
	data() {
		return {
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
			});
	},
	methods: {
	}
};
</script>
