<template>
  <div>
    <div class="bg-gray p-3 mb-2">
      <div class="row">
        <div class="col-md-12 latest-post">
          <h4 class="card-title weight-800 text-black mb-2 border-bottom  pb-2">
            Popular Post
          </h4>
        </div>
      </div>

      <div class="row">
        <div
          v-for="(post,index) in posts"
          :key="index"
          class="col-md-12 mt-2 mb-2"
        >
          <div
            class="card-post"
            @click="redirectPostView(post.id)"
          >
            <div class="d-flex align-items-center">
              <img
                v-lazy="post.image_path"
                class="card-img-top  side_bar_post_img"
                alt="Card image cap"
              >
							
              <div class="info-post ml-3">
                <h3 class="card-title side_bar_title font-size-12">
                  <a
                    href="#"
                    class="text-black"
                  >{{ post.heading }}</a>
                </h3>
                <p class="post_des">
                  {{ post.content }}
                </p>
                <p class="date text-muted side_bar_size">
                  {{ post.time }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="bg-gray p-3 mb-3">
      <div class="row">
        <div class="col-md-12 latest-post">
          <h4 class="card-title weight-800 text-black mb-2 border-bottom  pb-2">
            Latest Post
          </h4>
        </div>
      </div>

      <div class="row">
        <div
          v-for="(post,index) in posts"
          :key="index"
          class="col-md-12 mt-2 mb-2"
        >
          <div class="card-post">
            <div class="d-flex align-items-center">
              <img
                v-lazy="post.image_path"
                class="card-img-top  side_bar_post_img"
                alt="Card image cap"
              >
							
              <div class="info-post ml-3">
                <h3 class="card-title side_bar_title font-size-12">
                  <a
                    href="#"
                    class="text-black"
                  >{{ post.heading }}</a>
                </h3>
                <p class="post_des">
                  {{ post.content }}
                </p>
                <p class="date text-muted side_bar_size">
                  {{ post.time }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
	.bg-gray {
		background: #F7F7F7 !important;
	}
	.side_bar_size{padding:0;margin:0;font-size: 11px}

	img.card-img-top.side_bar_post_img {
		width: 40px;
		height: 40px;
		border-radius: 50px;
	}
	.side_bar_title{    margin: 0 0 5px;


		white-space: nowrap; 
		width: 230px; 
		overflow: hidden;
		text-overflow: ellipsis;
	}
	.post_des{
		margin:0;padding:0;

		white-space: nowrap; 
		width: 230px; 
		overflow: hidden;
		text-overflow: ellipsis; 
		font-size: 12px;


	}

</style>
<script>
import {mapState} from 'vuex';


export default {
	
	computed:{
		...mapState({
			'posts': state=>state.guest.posts.ExploreSidebar,
		}),
	},
	methods:{
	}
};
</script>