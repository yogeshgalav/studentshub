<template>
  <div class="row">
    <div class="">
      <div class="col-md-12">
        <h1>{{ subjectName }}</h1>
      </div>
    </div>
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
          :share-route="'/share-your-knowledge?sId='+subjectId"
        >
          <template slot="empty">
            Currently no post have been shared related to this subject.
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
            Currently no doubt have been shared in this subject.
          </template>
        </DoubtContainer>
      </template>
    </nav-tabs>
  </div>
</template>
<style scoped></style>
<script>
import NavTabs from '../../components/NavTabs';
import PostContainer from '../common/post-container.vue';
import DoubtContainer from '@/Pages/doubt/doubt-container.vue';

export default {
	components: {
		PostContainer,
		DoubtContainer,
		NavTabs,
	},
	props:['subjectId', 'subjectName'],
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
