<template>
  <div class=" card mb-2">
    <div class="card-body">
      <div class="dashboard_post">
        <div class="avatar">
          <profile-image
            :user-name="post.user_name"
            :avatar="post.profile_image"
          />
        </div>
        <div class="info-post ml-2 dash_insititue_name">
          <p class="font-size-14 mb-0 dash_user_date">
            {{ post.user_name }}  <span>  {{ post.time }}</span>
          </p>
          <p class="font-size-14 mb-0">
            {{ post.institute_name }}
          </p>
        </div>
      </div>
      <hr class="mb-1 mt-2">
      <div class="row">
        <div class="col-md-8">
          <p class="font-size-16 mt-2">
            {{ post.description }}
          </p>
          <div class="">
            <router-link
              :to="'/post/'+post.id"
              class="btn p-0 btn-link font-size-16"
              style="text-decoration: underline;"
            >
              Read Continue &nbsp;<i class="fa fa-arrow-right" />
            </router-link>
          </div>
        </div>
        <div
          class="col-md-4 post_width"
          @click="setPostView(post)"
        >
          <div
            v-if="post.image_path"
            class="post_img mt-2"
          >
            <img
              v-lazy="post.image_path"
              alt="Card image cap"
            >
          </div>
        </div>
      </div>
      <hr>
      <interaction-component
        :user-like="post.user_like ? true : false"
        :total-likes="post.total_likes"
        :likable-id="post.id"
        likable-type="post"
        :edit-access="post.user_id===AuthUser.id"
      />
    </div>
  </div>
</template>
<style scoped>
.post_img img{
  width: 100%;
  max-height: 200px !important;
  height: auto !important;
}
</style>
<script>

// import ImageSlider from './ImageSlider.vue';
import InteractionComponent from '../common/InteractionComponent.vue';

export default {
	components: {
		InteractionComponent,
		// ImageSlider
	},
	props:['post'],
	methods:{
		setPostView(post){
			document.title = post.heading;
			this.$store.commit('common/set_post_initial',post);
			this.$router.push({ path: `/post/${post.id}` });
		},
	},

};
</script>
