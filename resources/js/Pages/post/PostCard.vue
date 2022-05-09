<template>
  <div class="card mb-2">
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
              {{ post.user_name }}
              <span>
                {{ post.time }}
                <div class="dropdown d-inline">
                  <button
                    id="dropdownMenuButton"
                    class="btn btn-secondary dropdown-toggle p-0 border-0"
                    type="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="fas fa-ellipsis-v" />
                  </button>
                  <div
                    class="dropdown-menu dropdown-menu-right"
                    style="min-width: max-content"
                    aria-labelledby="dropdownMenuButton"
                  >
                    <button
                      type="button"
                      class="dropdown-item"
                      data-toggle="modal"
                      data-target="#addDoubtModal"
                      @click="copyLink(post.id)"
                    >
                      Copy Link
                    </button>
                    <button
<<<<<<< HEAD
                      v-if="post.user_id===AuthUserId"
=======
                      v-if="post.user_id === AuthUser.id"
>>>>>>> a3644d055c972897ef4f06a855b751d198894ca0
                      type="button"
                      class="dropdown-item"
                      @click="editPost(post.id)"
                    >
                      Edit
                    </button>
                    <button
<<<<<<< HEAD
                      v-if="post.user_id===AuthUserId"
=======
                      v-if="post.user_id === AuthUser.id"
>>>>>>> a3644d055c972897ef4f06a855b751d198894ca0
                      type="button"
                      class="dropdown-item"
                      @click="deletePost(post.id)"
                    >
                      Delete
                    </button>
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
            <p
              v-if="!doubtType"
              class="text-muted font-size-16 mb-0"
            >
              {{ post.category_name }}
            </p>
            <p
              v-if="!doubtType"
              class="font-size-24 weight-600 mb-0"
            >
              {{ post.heading }}
            </p>
            <p class="font-size-16 mt-0 mb-0">
              {{ post.description }}
            </p>
            <p
              v-if="!doubtType"
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
              <div v-if="post.post_type === 'video'">
                <router-link
                  :href="'/post/'+post.id"
                  class="btn p-0 btn-link font-size-16"
                  style="text-decoration: underline"
                >
                  Watch Continue &nbsp;<i class="fa fa-arrow-right" />
                </router-link>
              </div>
              <div v-else>
                <router-link
                  :href="'/post/'+post.id"
                  class="btn p-0 btn-link font-size-16"
                  style="text-decoration: underline"
                >
                  Read Continue &nbsp;<i class="fa fa-arrow-right" />
                </router-link>
              </div>
            </div>
          </div>
          <div
            class="col-md-4 post_width"
          >
            <router-link
              v-if="post.image_path"
              :href="'/post/'+post.id"
              class="post_img mt-2"
            >
              <img
                v-lazy="post.image_path"
                alt="Card image cap"
              >
            </router-link>
          </div>
          <p
            class="totalview text-grey mb-0 col-md-4 post_width"
            data-toggle="modal"
            data-target="#viewsModal"
            @click="getViewsInfo()"
          >
            {{ post.total_views }} people interacted with this post
          </p>
        </div>
        <hr>
        <interaction-component
          :user-like="post.user_like ? true : false"
          :total-likes="post.total_likes"
          :likable-id="post.id"
          likable-type="post"
<<<<<<< HEAD
          :edit-access="post.user_id===AuthUserId"
=======
          :edit-access="post.user_id === AuthUser.id"
>>>>>>> a3644d055c972897ef4f06a855b751d198894ca0
        />
      </div>
    </div>


    <div
      id="viewsModal"
      ref="viewsModal"
      class="modal fade"
      role="dialog"
      tabindex="-1"
      aria-labelledby="viewsModal"
      aria-hidden="true"
      name="viewsModal"
    >
      <div
        class="modal-fullscreen"
      >
        <div
          class="modal-dialog modal-lg"
        >
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header pt-3 pb-2">
              <h4 class="weight-800 font-size-18">
                People who viewd your post
              </h4>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body add-client">
              <template>
                <div class="dashboard_post">
                  <div class="avatar">
                    <profile-image
                      :user-name="post.user_name"
                      :avatar="post.profile_image"
                    />
                  </div>
                  <div class="info-post ml-2 dash_insititue_name">
                    <p class="font-size-14 mb-0 dash_user_date">
                      {{ post.user_name }}
                    </p>
                  </div>
                </div>
              </template>
            </div>
            <div class="modal-footer">
              <button
                ref="cancelButton"
                type="button"
                class="btn btn-white mt-3"
                data-dismiss="modal"
                @click="closeModal"
              >
                {{ 'Cancel' }}
              </button>
            </div>
          </div>
        </div>
      </div>



    <!-- <modal
      ref="viewsModal"
      name="viewsModal"
      heading="People who viewd your post"
      classes="modal-lg"
    >
      <template slot="modalBody">
        <div class="dashboard_post">
          <div class="avatar">
            <profile-image
              :user-name="post.user_name"
              :avatar="post.profile_image"
            />
          </div>
          <div class="info-post ml-2 dash_insititue_name">
            <p class="font-size-14 mb-0 dash_user_date">
              {{ post.user_name }}
            </p>
          </div>
        </div>
      </template>
    </modal> -->
    </div>
  </div>
</template>
<style scoped>
.totalview {
  cursor: pointer;
}
.modal-dialog{
  position: absolute;
    width: 90%;
    /* margin-top: 50%; */
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) !important;
    margin: 0 !important;
}
.post_img img {
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
	props:['post','doubtType'],
	computed:{
		AuthUserId(){
			return this.AuthUser ? this.AuthUser.id : null;
		}
	},
	methods:{
		editPost(){
			this.$gtag('event','editPost',{
				'post_id':this.post.id
			});
			window.location.href ='/post/'+this.post.id+'/edit';
		},
		deletePost(id){
			this.$gtag('event','deletePost',{
				'post_id':this.post.id
			});
			this.axios.delete('/api/post/'+this.post.id).then(()=>{
				window.location.reload();
			});
		},
		copyLink(){
			navigator.clipboard.writeText(this.baseUrl+'/post/'+this.post.id);
		}
	},
};
</script>
