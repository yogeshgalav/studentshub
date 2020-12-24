<template>
  <div>
    <div
      v-for="(post,index) in posts"
      :key="index"
    >
      <post-card :post="post" />
    </div>

    <div class="card border-0">
      <loading
        :active.sync="showLoader"
        :color="'#10069F'"
        :loader="'bars'"
        :width="250"
        :is-full-page="false"
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
	computed: {
		...mapState({
			posts: state => state.common.dashboardPosts
		})
	},
	mounted() {
		var route= '/get-posts';
		var params='';
		if(this.$route.name==='search'){
			params='query='+this.$route.query.query;
		}
		this.showLoader = true;
		this.$store.dispatch('common/getDashboardPosts',{route:route,params:params}).then(() => {
			this.showLoader = true;
		});
		window.addEventListener('scroll', () => {
			if (this.bottomVisible()) {
				this.showLoader = true;
				this.$store.dispatch('common/getDashboardPosts',{route:route,params:params}).then(() => {
					this.showLoader = true;
				});
			}
		});
	},
	data() {
		return {
			showLoader: false
		};
	},
	methods: {
		setPostView(post){
			document.title = post.heading;
			this.$store.commit('common/set_post_initial',post);
		},
	}
};
</script>
