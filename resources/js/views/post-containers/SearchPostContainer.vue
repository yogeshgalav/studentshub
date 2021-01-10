<template>
  <div>
    <div class="row">
      <div
        v-if="posts.length===0"
        class="col-md-9"
      >
        <h3>Oops! we couldn't found any posts related to your search.</h3> 
      </div>
    </div>
    <div
      v-for="(post,index) in posts"
      :key="index"
    >
      <post-card :post="post" />
    </div>

    <div
      v-if="posts.length" 
      class="dash_card card mb-1 border-0 text-center"
    >
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
</template>
<style scoped>
.card-post h3 {
	margin-bottom:1px;
	font-size:14px !important;
}
.card-post h5 {
	font-size:12px !important;
	font-weight: 400;
	margin-bottom:10px !important;
}
.text-muted {
    color: #6c757d !important;
}
</style>
<script>

import {mapState} from 'vuex';

export default {
	computed:{
		...mapState({
			'posts': state=>state.common.search_posts,
		}),
	},
	data(){
		return {
			showLoader:false,
		};
	},
	methods:{
	}
};
</script>
