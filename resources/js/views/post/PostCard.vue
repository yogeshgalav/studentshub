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
            <p class="usernamedash mb-0 dash_user_date">
              {{ post.user_name }}  <span>  {{ post.time }}</span>
            </p>
            <p class="usernamedash mb-0">
              {{ post.institute_name }}
            </p>
          </div>   
        </div> 
        <hr>
        <div class="row mb-1 mt-1">
          <div class="col-md-12 cat_sub_name mb-0">
            <p class="text-muted btn-category">
              {{ post.category_name }}
            </p>
            <p class="text-muted btn-category">
              {{ post.subject_name }}
            </p>
          </div>
          <div class="col-md-12 dash_board_title">
            <h3 class="card-title weight-600 text-black mb-2">
              {{ post.heading }}
            </h3>
          </div>
          <div @click="setPostView(post)">
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
              <p class="dash_post_content">
                {{ post.description }}
              </p>
              <div v-if="post.post_type==='document'">
                <a
                  :href="post.document_link"
                  target="_blank"
                  class="btn p-0 btn-link font-size-12"
                  style="text-decoration: underline;"
                >
                  Open Link &nbsp;<i class="fa fa-arrow-right" />
                </a>
              </div>
              <div v-else-if="post.post_type==='video'">
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
  height: 450px !important;
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