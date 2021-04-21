<template>
  <div>
    <div class="card" style="width: 30rem">
      <div class="card-header">
        <h4>ACCOUNT SETTINGS</h4>
      </div>
      <div class="card-body"></div>
    </div>
    <div class="card" style="width: 18rem">
      <div class="card-header">
        <h4>Profile Info</h4>
      </div>
      <div class="card-body">
        <form @submit.prevent="saveProfile">
          <div class="model_box_inner">
            <div class="edit_profile_head">
              <h4>Edit Your Profile</h4>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="user_edit_profile_img">
                  <div class="u_e_img">
                    <img v-if="AuthUser.avatar_url" :src="AuthUser.avatar_url" alt="" />
                    <img
                      v-else-if="profile_image_url"
                      :src="profile_image_url"
                      alt=""
                    />
                    <img v-else src="/images/default-avatar.png" alt="" />
                  </div>
                  <file-upload
                    id="documentUpload"
                    ref="upload"
                    class="edit_img_btn"
                    post-action="/upload/post"
                    extensions="jpg,jpeg,png"
                    accept="image/*"
                    :drop="true"
                    :size="1024 * 1024 * 10"
                    @input="inputUpdate"
                  >
                    UPLOAD
                  </file-upload>
                </div>
              </div>
              <div class="col-md-12">
                <div class="model_input">
                  <label>Introduction</label>
                  <textarea
                    id="introduction"
                    v-model="profile_data.intro"
                    name="introduction"
                    class="form-control"
                  />
                  <span class="text-danger">{{ errors.intro }}</span>
                </div>
              </div>
              <div class="col-md-12">
                <div class="model_input">
                  <label>Email Id</label>
                  <input
                    class="form-control"
                    type="text"
                    disabled
                    :value="AuthUser.email"
                  />
                </div>
              </div>
              <div class="col-md-12">
                <div class="model_input">
                  <label>Facebook Profile Url</label>
                  <input
                    v-model="profile_data.fb_url"
                    class="form-control"
                    type="text"
                    placeholder="http://facebook.com/profile-id"
                  />
                  <span class="text-danger">{{ errors.fb_url }}</span>
                </div>
              </div>
              <div class="col-md-12">
                <div class="model_input">
                  <label>Instagram Profile Url</label>
                  <input
                    v-model="profile_data.insta_url"
                    class="form-control"
                    type="text"
                    placeholder="http://instagram.com/username"
                  />
                  <span class="text-danger">{{ errors.insta_url }}</span>
                </div>
              </div>
              <div class="col-md-12">
                <div class="model_input">
                  <label>Linkedin Profile Url</label>
                  <input
                    v-model="profile_data.linked_url"
                    class="form-control"
                    type="text"
                    placeholder="http://linked.com/profile-id"
                  />
                  <span class="text-danger">{{ errors.linked_url }}</span>
                </div>
              </div>
              <div class="col-md-12">
                <div class="model_btn">
                  <button type="submit" class="save_profile_btn">Submit</button>
                  <button type="button" class="cancel_profile_btn">
                    Cancel
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="card" style="width: 18rem">
      <div class="card-header">
        <h4>Education Details</h4>
      </div>
      <div class="card-body"></div>
    </div>
  </div>
</template>

<script>
import FileUpload from 'vue-upload-component';
export default {
    components:{
        FileUpload
    },
    data() {
		return {
            profile_image_url:'',
            errors:{
				intro: '',
				profile_pic: '',
				fb_url: '',
				insta_url: '',
				linked_url: '',
			},
            profile_data: {
				profile_pic: '',
				intro: '',
				fb_url: '',
				insta_url: '',
				linked_url: '',
			}
        }
    },
    methods: {

        openProfileEditModal(){
			this.$modal.show('edit_profile_modal');
		},
		async saveProfile() {
			if(this.profile_data.fb_url && !this.profile_data.fb_url.includes('facebook.com')){
				this.errors.fb_url='This is not valid Facebook url.';
				return false;
			}
			if(this.profile_data.insta_url && !this.profile_data.insta_url.includes('instagram.com')){
				this.errors.insta_url='This is not valid Instagram url.';
				return false;
			}
			if(this.profile_data.linked_url &&!this.profile_data.linked_url.includes('linkedin.com')){
				this.errors.linked_url='This is not valid Linkedin url.';
				return false;
			}
			if(this.image.file){
				await this.getBase64(this.image.file).then(file=>{
					this.profile_data.profile_pic=file;
				});
			}

			await this.axios.post('/api/save-profile', this.profile_data).then((resp) => {
				this.setProfile(resp.data.success.profile);
				this.$modal.hide('edit_profile_modal');
			});

			this.errors={
				profile_pic: '',
				fb_url: '',
				insta_url: '',
				linked_url: '',
			};
		},
		setProfile(profile) {
			this.profile_data.fb_url = profile.fb_url ? profile.fb_url : '';
			this.profile_data.insta_url = profile.insta_url ? profile.insta_url : '';
			this.profile_data.linked_url = profile.linked_url ? profile.linked_url : '';
		},
		inputUpdate(files) {
			this.image = files[0];
			this.profile_image_url = URL.createObjectURL(files[0].file);
		},
        getBase64(file) {
			return new Promise((resolve, reject) => {
				const reader = new FileReader();
				reader.readAsDataURL(file);
				reader.onload = () => resolve(reader.result);
				reader.onerror = error => reject(error);
			});
		}
    }
};
</script>
