<template>
  <div class="exolpre-bottom-post">
    <div class="row">
      <div class="col-md-12 text-center">
        <h3 class="card-title weight-800 text-black  mb-3">
          Latest Post
        </h3>
      </div>
    </div>

    <div class="row">
      <div
        v-for="post in posts"
        :key="post.id"
        class="col-md-4"
      >
        <div class="card-post">
          <img
            v-lazy="post.image_path"
            class="card-img-top post_img_height"
            alt="Card image cap"
          >
          <div>
            <div class=" mt-2">
              <div class="post_name_date">
                <div class="user_name">
                  <profile-image
                    :user-name="post.user_name"
                    :avatar="post.profile_image"
                  />
                  <p class="username">
                    {{ post.user_name }}
                  </p>
                </div>
                <div class="info-post ml-2">
                  <p class="date text-muted">
                    {{ post.time }}
                  </p>
                </div>
              </div>
            </div>
            <h3 class="card-title mb-1 font-size-16">
              <router-link
                :href="'/post/'+post.id"
                class="weight-600 text-black"
              >
                {{ post.heading }}
              </router-link>
            </h3>
            <div class="separator-solid" />
							
									
            <p class="card-text post_des">
              {{ post.content }}
            </p>
            <div class="wel_view post_views_sec">
              <div class="post_view">
                <i class="fa fa-eye" />
                <span class="badge-text">{{ post.total_views }}</span>
              </div>
              <div class="post_view">
                <i class="fa fa-thumbs-up" />
                <span class="badge-text">{{ post.total_likes }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
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
.row.post_views_sec
{
	bottom:-40px;
}
</style>
<script>
import {mapState} from 'vuex';


export default {
	computed:{
		...mapState({
			'posts': state=>state.guest.posts.ExploreBottomPost,
		}),
	},
	methods:{
	}
};
</script>
