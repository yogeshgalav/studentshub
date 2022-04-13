<template>
  <section>
    <div class="row">
      <div class="col-md-10 col-sm-12">
        <div class="card mb-3 mt-2 pt-0 pb-0">
          <div class="card-body">
            <div class="row pl-3">
              <profile-image
                size="small"
                :user-name="AuthUser.full_name"
                :avatar="AuthUser.avatar_url"
              />&nbsp;&nbsp;
              {{ AuthUser.full_name }}
            </div>
            <a
              :href="shareRoute"
            > 
              <img
                src="/images/knowledge.svg"
                alt=""
              >&emsp;
              <slot name="share">Share Your Knowledge</slot> 
              &emsp;<span><i
                class="fa fa-arrow-right"
                aria-hidden="true"
              /></span>  
            </a>
          </div>
        </div>
        <div v-if="!posts_data.length">
          <slot name="empty">
            No post present yet
          </slot> 
        </div>
        <div id="infinite-list">
          <div
            v-for="(post,index) in posts_data"
            :key="index"
          >
            <post-card :post="post" />
          </div>

          <div class="card mb-0 mt-0 border-0 text-center">
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
  </section>
</template>
<script>
import PostCard from '../post/PostCard.vue';

export default {
	components: {
		PostCard
	},
	props:['postRoute', 'shareRoute'],
	data() {
		return {
			posts_data: [],
			showLoader: false,
			current_page: 1
		};
	},
	mounted() {
		this.loadPosts();
	},
	methods: {
		loadPosts(){
			const route= this.postRoute ? this.postRoute+'/posts' : '/posts';
			const url= new URL(this.baseUrl+'/api'+route);
			this.showLoader = true;

			url.searchParams.set('page', this.current_page);
			this.current_page=this.current_page+1;

			this.axios.get(url.toString())
				.then(resp => {
					const posts = resp.data.success.posts;
					this.posts_data = this.posts_data.concat(posts.data);
		            this.current_page = this.current_page;
					this.showLoader = false;
				})
				.catch(err => {
					this.showLoader = false;
				});
		}
	}
};
</script>
