<template>
  <section>
    <div class="row">
      <div class="col-md-10 col-sm-12">
        <div
          v-if="AuthUser"
          class="card mb-3 mt-2 pt-0 pb-0"
        >
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
          <img
            class="search-not-found"
            src="/images/search-not-found.png"
          >
          <p style="text-align: center">
            <slot name="empty">
              No post present yet
            </slot> 
          </p>
        </div>
      
        <div id="infinite-list">
          <div 
            v-for="(post,index) in posts_data"
            :key="index"
          >
            <post-card :post="post" />
          </div>
          
          <div
            class="card mb-0 mt-0 border-0 text-center"
          > 
            <p
              v-if="load_more"
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
          
          <modal
            id="reactionModal"
            ref="reactionModal"
            name="reactionModal"
            heading="People who viewd your post"
            :classes="'modal-lg'"
            :show-footer="false"
          >
            <template slot="modalBody">
              <div class="dashboard_post">
                <nav-tabs
                  :tabs="tabs"
                  :initial-tab="initialTab"
                >
                  <template slot="tab-heading-all">
                    {{ 'All' }}
                  </template>
                  <template slot="tab-panel-all">
                    <div
                      v-for="(reaction,index) in reactions"
                      :key="index"
                      class="d-flex"
                    >
                      <div class="avatar ml-2">
                        <profile-image
                          :user-name="reaction.full_name"
                          :avatar="reaction.profile_image"
                          :size="'small'"
                        />
                      </div>
                      <div class="ml-2 mb-1">
                        <p class="font-size-14 mb-0 ">
                          {{ reaction.full_name }}
                        </p>
                      </div>
                    </div>
                  </template>
                  <template slot="tab-heading-likes">
                    {{ 'Likes' }}
                  </template>
                  <template slot="tab-panel-likes">
                    <div
                      v-for="(like,index) in likes"
                      :key="index"
                    >
                      <div class="avatar ml-2">
                        <profile-image
                          :user-name="like.full_name"
                          :avatar="like.profile_image"
                        />
                      </div>
                      <div class="info-post ml-2 mb-1 dash_insititue_name">
                        <p class="font-size-14 mb-0 dash_user_date">
                          {{ like.full_name }}
                        </p>
                      </div>
                    </div>
                  </template>
                  <template slot="tab-heading-comments">
                    {{ 'Comments' }}
                  </template>
                  <template slot="tab-panel-comments">
                    <div
                      v-for="(comment,index) in comments"
                      :key="index"
                    >
                      <div class="avatar ml-2">
                        <profile-image
                          :user-name="comment.full_name"
                          :avatar="comment.profile_image"
                        />
                      </div>
                      <div class="info-post ml-2 mb-1 dash_insititue_name">
                        <p class="font-size-14 mb-0 dash_user_date">
                          {{ comment.full_name }}
                        </p>
                      </div>
                    </div>
                  </template>
                </nav-tabs>
              </div>
            </template>
          </modal>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import NavTabs from '../../components/NavTabs';
import PostCard from '../post/PostCard.vue';
import Modal from '../../components/VueNiceModal.vue';

export default {
	components: {
		NavTabs,
		PostCard,
		Modal
	},
	props:['postRoute', 'shareRoute'],
	data() {
		return {
			load_more:true,
			reactions: [],
			likes:[],
			comments:[],
			posts_data: [],
			showLoader: false,
			current_page: 1,
			initialTab: 'all',
			tabs: ['all', 'likes', 'comments'],
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
					if(!posts.data.length)
					{
						this.load_more=false;
					}
					
					this.posts_data = this.posts_data.concat(posts.data);
		            this.current_page = this.current_page;
					this.showLoader = false;
				})
				.catch(err => {
					this.showLoader = false;
				});
      
		},
    
		getViewsInfo(postId){
			let url = '/api/post-reactions/'+postId;
			this.axios.get(url).then((resp) => {
				this.reactions = resp.data.success.reactions;
				this.likes = resp.data.success.likes;
				this.comments = resp.data.success.comments;
				this.showLoader = false;
			});
		},
	}
};
</script>
