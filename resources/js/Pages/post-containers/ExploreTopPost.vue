<template>
  <div class="ptb-50 top_post">
    <div class="row">
      <div
        v-for="post in posts"
        :key="post.id"
        class="col-md-4"
      >
        <div class="card-post">
          <div class="d-flex  post_name_date">
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
              <p class="date text-muted post_date">
                {{ post.time }}
              </p>
            </div>
          </div>

          <img
            v-lazy="post.image_path"
            class="card-img-top post_img_height"
            alt="Card image cap"
          >
          <div>
            <div class="separator-solid" />
            <p class="card-category text-info mb-2">
              <a :href="post.slug">{{ post.subject_name }}</a>
            </p>
            <h3 class="card-title  font-size-16">
              <Link
                :href="'/post/'+post.id"
                class="weight-600 text-black"
              >
                {{ post.heading }}
              </Link>
            </h3>
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
<script>
export default {
    
};
</script>
<script>
import {mapState} from 'vuex';

export default {
	
	computed:{
		...mapState({
			'posts': state=>state.guest.posts.ExploreTopPost,
		}),
	},
	methods:{
	}
}
</script>
