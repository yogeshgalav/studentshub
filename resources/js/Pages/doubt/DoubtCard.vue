<template>
  <div class=" card mb-2">
    <div class="card_doubt">
      <div class="card-body">
        <div class="d-flex">
          <div class="avatar">
            <profile-image
              :user-name="doubt.user_name"
              :avatar="doubt.profile_image"
            />
          </div>
          <div class="info-doubt ml-2 dash_insititue_name">
            <p :class="[!doubt.institute_name ? 'mt-2' : '','font-size-14 mb-0 dash_user_date']">
              {{ doubt.user_name }}  <span>
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
                      @click="copyLink(doubt.id)"
                    >Copy Link</button> 
                    <button
                      v-if="doubt.user_id===AuthUser.id"
                      type="button"
                      class="dropdown-item"
                      @click="editDoubt(doubt.id)"
                    >Edit</button> 
                    <button
                      v-if="doubt.user_id===AuthUser.id"
                      type="button"
                      class="dropdown-item"
                      @click="deleteDoubt(doubt.id)"
                    >Delete</button>
                  </div>
                </div>
              </span>
            </p>
            <p class="font-size-14 mb-0">
              {{ doubt.institute_name }}
            </p>
          </div>
        </div>
        <hr class="mb-1 mt-2">
        <div class="row">
          <div class="col-md-8 col-12">
            <p
              class="text-muted font-size-16 mb-0"
            >
              {{ doubt.category_name }}
            </p>
            <p
              class="font-size-24 weight-600 mb-0"
            >
              {{ doubt.question }}
            </p>
            <p
              class="text-blue mt-0 mb-2"
            >
              <span 
                v-for="sub in doubt.subjects"
                :key="sub.id"
              >
                #{{ sub.subject_name }}
              </span>
            </p>
            <div class="">
              <div v-if="doubt.doubt_type==='video'">
                <router-link
                  :href="'/doubt/'+doubt.id"
                  class="btn p-0 btn-link font-size-16"
                  style="text-decoration: underline;"
                >
                  Watch Continue &nbsp;<i class="fa fa-arrow-right" />
                </router-link>
              </div>
              <div v-else>
                <router-link
                  :href="'/doubt/'+doubt.id"
                  class="btn p-0 btn-link font-size-16"
                  style="text-decoration: underline;"
                >
                  Read Continue &nbsp;<i class="fa fa-arrow-right" />
                </router-link>
              </div>
            </div>
          </div>
          <div
            class="col-md-4 doubt_width"
          >
            <router-link
              v-if="doubt.image_path"
              :href="'/doubt/'+doubt.id"
              class="doubt_img mt-2"
            >
              <img
                v-lazy="doubt.image_path"
                alt="Card image cap"
              >
            </router-link>
          </div>
        </div>
        <hr>
        <interaction-component
          :user-like="doubt.user_like ? true : false"
          :total-likes="doubt.total_likes"
          :likable-id="doubt.id"
          likable-type="doubt"
          :edit-access="doubt.user_id===AuthUser.id"
        />
      </div>
    </div>
  </div>
</template>
<style scoped>
.doubt_img img{
  width: 100%;
  max-height: 200px !important;
  height: auto !important;
}
</style>
<script>

// import ImageSlider from './ImageSlider.vue';
import InteractionComponent from '@/Pages/common/InteractionComponent.vue';
import ProfileImage from '@/components/ProfileImage';

export default {
	components: {
		ProfileImage,
		InteractionComponent,
		// ImageSlider
	},
	props:['doubt',],
	methods:{
		editDoubt(id){
			window.location.href ='/doubt/'+id+'/edit';
		},
		deleteDoubt(id){
			this.axios.delete('/api/doubt/'+this.doubt.id).then(()=>{
				window.location.reload();
			});
		},
		copyLink(){
			navigator.clipboard.writeText(this.baseUrl+'/doubt/'+this.doubt.id);
		}
	},

};
</script>
