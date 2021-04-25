<template>
  <div class="welcome_post_sec">
    <div
      v-for="(post,index) in posts"
      :key="index"
    >
      <div class="row">
        <div class="col-md-9">
          <div
            class="card-post"
            @click="redirectPostView(post)"
          >
            <div>
              <div class="d-flex mt-2">
                <profile-image
                  :user-name="post.user_name"
                  :avatar="post.profile_image"
                />
                <div class="info-post ml-2">
                  <p class="username mb-1">
                    {{ post.user_name }}
                  </p>
                  <p class="date text-muted mb-1">
                    {{ post.institute_name }}
                  </p>
                  <p class="mb-1">
                    {{ post.category_name }}
                  </p>
                  <p class="mb-1 post_cat_size">
                    {{ post.subject_name }}
                  </p>
                </div>
              </div>
              <h3 class="card-title mb-1  font-size-18">
                <router-link
                  :to="'/post/'+post.id"
                  class="weight-600 text-black"
                >
                  {{ post.heading }}
                </router-link>
              </h3>
              <h5 class="mb-1 post_des">
                {{ post.content }}
              </h5>
              <div class="wel_view">
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
        <div class="col-md-3">
          <img
            v-lazy="post.image_path"
            class="card-img-top wel_post_img"
            alt="Card image cap"
          >
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="divider" />
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
	.card-post h3 {
		margin-bottom:1px;
	}
	.post_cat_size
	{
		font-size:12px;
		color:#ccc;	
	}
	.welcome_post_sec .row{align-items: center;}
	
	.card-post h5 {
		font-size:12px !important;
		font-weight: 400;
		margin-bottom:10px !important;
		line-height: 22px;
	}

</style>
<script>
import {mapState} from 'vuex';

export default {
	computed:{
		...mapState({
			'posts': state=>state.guest.posts.HomePostContainer,
		}),
	},
};
</script>
