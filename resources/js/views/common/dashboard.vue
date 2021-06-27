<template>
  <main>
    <div>
      <div class="col-md-10 col-sm-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card mb-3 mt-2">
              <div class="card-body">
                <a
                  class="h-card"
                  :href="AuthUser.preferred_institute_id ? '/share-your-knowledge' : '/education-details'"
                > 
                  <img
                    src="/images/knowledge.svg"
                    alt=""
                  >&emsp;
                  Share Your Knowledge &emsp;<span><i
                    class="fa fa-arrow-right"
                    aria-hidden="true"
                  /></span>  
                </a>
              </div>
            </div>
            <div id="infinite-list">
              <div
                v-for="(post,index) in posts"
                :key="index"
              >
                <post-card :post="post" />
              </div>

              <div class=" card mb-1 border-0 text-center">
                <p
                  class="mb-0"
                  @click="loadPosts"
                >
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
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
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
