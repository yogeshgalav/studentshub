<template>
  <div id="infinite-list">
    <div
      v-for="(post,index) in posts"
      :key="index"
    >
      <post-card :post="post" />
    </div>

    <div class="dash_card card mb-1 border-0 text-center">
      <p @click="loadPosts" class="mb-0">
        Load More...
      </p>
      <loading
        :active.sync="showLoader"
        :color="'#10069F'"
        :loader="'bars'"
        :width="250"
        :is-full-page="true"
      />
    </div>
  </div>
</template>
<style  scoped>
a.btn.p-0.btn-link.font-size-12 {
    display: flex;
    align-items: center;
    margin: 4px 0;
}

</style>

<script>
import { mapState } from 'vuex';
import PostCard from '../post/PostCard.vue';

export default {
	components: {
		PostCard
	},
	data() {
		return {
			showLoader: false
		};
	},
	computed: {
		...mapState({
			posts: state => state.common.dashboardPosts
		})
	},
	mounted() {
		this.loadPosts();
	},
	methods: {
		loadPosts(){
			var route= '/get-posts';
			var params='';
			if(this.$route.name==='search'){
				params='query='+this.$route.query.query;
			}
			this.showLoader = true;
			this.$store.dispatch('common/getDashboardPosts',{route:route,params:params}).then(() => {
				this.showLoader = false;
			});
		}
	}
};
</script>
