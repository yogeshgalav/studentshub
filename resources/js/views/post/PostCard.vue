<template>
  <div class=" card mb-2">
    <div class="card_post">
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
              {{ post.user_name }}  <span>  {{ post.time }}
                <div
                  class="dropdown d-inline"
                >
                  <button
                    id="dropdownMenuButton"
                    class="btn btn-secondary dropdown-toggle p-0"
                    type="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="fas fa-ellipsis-v" />
                  </button>
                  <div
                    class="dropdown-menu dropdown-menu-right"
                    style="min-width: max-content;"
                    aria-labelledby="dropdownMenuButton"
                  >
                    <button
                      type="button"
                      class="dropdown-item"
                      data-toggle="modal"
                      data-target="#addDoubtModal"
                      @click="copyLink(post.id)"
                    >Copy Link</button> 
                    <button
                      v-if="post.user_id===AuthUser.id"
                      type="button"
                      class="dropdown-item"
                      @click="editPost(post.id)"
                    >Edit</button> 
                    <button
                      v-if="post.user_id===AuthUser.id"
                      type="button"
                      class="dropdown-item"
                      @click="deletePost(post.id)"
                    >Delete</button>
                  </div>
                </div>
              </span>
            </p>
            <p class="font-size-14 mb-0">
              {{ post.institute_name }}
            </p>
          </div>
        </div>
        <hr class="mb-1 mt-2">
        <div class="row">
          <div class="col-md-8 col-12">
            <p class="text-muted font-size-16 mb-0">
              {{ post.category_name }}
            </p>
            <p class="font-size-24 weight-600 mb-0">
              {{ post.heading }}
            </p>
            <p class="font-size-16 mt-0 mb-0">
              {{ post.description }}
            </p>
            <p
              class="text-blue mt-0 mb-2"
            >
              <span 
                v-for="sub in post.subjects"
                :key="sub.id"
              >
                #{{ sub.subject_name }}
              </span>
            </p>
            <div class="">
              <div v-if="post.post_type==='video'">
                <router-link
                  :to="'/post/'+post.id"
                  class="btn p-0 btn-link font-size-16"
                  style="text-decoration: underline;"
                >
                  Watch Continue &nbsp;<i class="fa fa-arrow-right" />
                </router-link>
              </div>
              <div v-else>
                <router-link
                  :to="'/post/'+post.id"
                  class="btn p-0 btn-link font-size-16"
                  style="text-decoration: underline;"
                >
                  Read Continue &nbsp;<i class="fa fa-arrow-right" />
                </router-link>
              </div>
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
import ProfileImage from '../../components/ProfileImage';

export default {
	components: {
		ProfileImage,
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
		editPost(id){
			window.location.href ='/post/'+id+'/edit';
		},
		deletePost(id){
			this.axios.delete('api/post/'+this.post.id).then(()=>{
				window.location.reload();
			});
		},
	},

};
</script>
