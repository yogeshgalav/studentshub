<template>
  <div class="dash_card card mb-2">
    <div class="card_post">
      <div class="card_box">
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
          <div class="col-md-12 cat_sub_name font-size-12 mb-0">
            <p class="text-muted btn-category">
              {{ post.category_name }}
            </p>
            <p
              v-if="post.subject_name" 
              class="text-muted btn-category"
            >
              {{ post.subject_name }}
            </p>
          </div>
          <div class="col-md-12">
            <p class="font-size-24 weight-600 mb-0">
              {{ post.heading }}
            </p>
            <p class="font-size-16 mt-0">
              {{ post.description }}
            </p>
          </div>
          <div
            class="post_width"
            @click="setPostView(post)"
          >
            <div
              v-if="post.image_path"
              class="col-md-12 post_img mb-2"
            >
              <img
                v-lazy="post.image_path"
                alt="Card image cap"
              >
            </div>
            <div
              class="col-md-9 col-12"
            > 
              <div v-if="post.post_type==='video'">
                <router-link
                  :to="'/post/'+post.id"
                  class="btn p-0 btn-link font-size-12"
                  style="text-decoration: underline;"
                >
                  Watch Continue &nbsp;<i class="fa fa-arrow-right" />
                </router-link>
              </div>
              <div v-else>
                <router-link
                  :to="'/post/'+post.id"
                  class="btn p-0 btn-link font-size-12"
                  style="text-decoration: underline;"
                >
                  Read Continue &nbsp;<i class="fa fa-arrow-right" />
                </router-link>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <like-component
          :post="post"
          likable-type="post"
        />
      </div>
    </div>
  </div>
</template>
<style scoped>
.btn-category {
  background: #eee;
  border-radius: 20px;
  padding: 5px 15px;
}
.post_img img{
  width: 100%;
  height: 300px !important;
}
.cat_sub_name p {
    margin: 5px 5px 0px 2px;
}

.cat_sub_name {
    display: flex;
}
@media (max-width: 768px) {
  .post_img img{
  width: 100%;
  height: auto !important;
}
}
</style>
<script>

// import ImageSlider from './ImageSlider.vue';
import LikeComponent from '../common/LikeComponent.vue';
import ProfileImage from '../../components/ProfileImage';

export default {
	components: {
		ProfileImage,
		LikeComponent,
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
