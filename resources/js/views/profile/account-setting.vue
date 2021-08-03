<template>
  <div>
    <div
      style="width: 100%"
    >
      <div class="">
        <h3>Account Settings</h3>
      </div>

      <!-- general info -->
      <div class="card mt-3">
        <div class="card-header">
          <h4>General info</h4>
        </div>

        <div class="card-body">
          <div class="col-md-12">
            <div class="user_edit_profile_img">
              <div class="u_e_img">
                <img
                  v-if="AuthUser.avatar_url"
                  :src="AuthUser.avatar_url"
                  alt=""
                >
                <img
                  v-else-if="profile_image_url"
                  :src="profile_image_url"
                  alt=""
                >
                <img
                  v-else
                  src="/images/default-avatar.png"
                  alt=""
                >
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
              <label>Full Name</label>
              <input
                v-model="profile_data.full_name"
                class="form-control"
                type="text"
                @input="dataUpdated"
              >
            </div>
            <div class="model_input">
              <label>Email Id</label>
              <input
                class="form-control"
                type="text"
                disabled
                :value="AuthUser.email"
              >
            </div>
            <a href="/reset-password">
              <button
                type="button"
                class="btn btn-primary mt-3 my-auto"
              >
                Password reset
              </button>
            </a>
          </div>
        </div>
      </div>

      <!-- profile info -->
      <div class="card mt-3">
        <div class="card-header">
          <h4>Profile info</h4>
        </div>

        <div class="card-body">
          <form @submit.prevent="saveProfile">
            <div class="row">
              <div class="col-md-12">
                <div class="model_input">
                  <label>Introduction</label>
                  <textarea
                    id="introduction"
                    v-model="profile_data.introduction"
                    name="introduction"
                    class="form-control"
                    @input="dataUpdated"
                  />
                  <span class="text-danger">{{ errors.introduction }}</span>
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
                    @input="dataUpdated"
                  >
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
                    @input="dataUpdated"
                  >
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
                  >
                  <span class="text-danger">{{ errors.linked_url }}</span>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- education details -->
      <div
        v-if="AuthStudent"
        class="card mt-3 mb-6"
      >
        <div class="card-header">
          <h4>Education details</h4>
        </div>

        <div class="card-body">
          <div class="row my-auto">
            <div class="col-sm-4 col-md-6">
              <h5>Course name</h5>
              <label>{{ AuthStudent.courseName }}</label>
            </div>
            <div class="col-sm-4 col-md-6">
              <h5>Institute name</h5>
              <label>{{ AuthStudent.instituteName }}</label>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-sm-4 col-md-6">
              <h5>Start year</h5>
              <label>{{ AuthStudent.start_year }}</label>
            </div>
            <div class="col-sm-4 col-md-6">
              <h5>End year</h5>
              <label>{{ AuthStudent.end_year }}</label>
            </div>
          </div>

          <div class="row">
            <a
              class="btn btn-primary mt-3"
              href="\education-details"
            >
              Edit
            </a>
          </div>
        </div>
      </div>

      <!-- fotter for update chnges -->
      <div
        v-if="data_updated"
        class="habit-footer"
      >
        <div class="col-md-12">
          <div
            class="row habit-footer_1 mt-1 ml-280"
          >
            <div class="col-md-6   text-right">
              <div class="mr-3">
                <button
                  class="btn btn-primary"
                  type="button"
                  @click="saveProfile"
                >
                  Update
                </button>
                <button
                  type="button"
                  class="btn btn-secondary"
                  @click="discard"
                >
                  Discard
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.ml-280 {
	margin-left:300px !important;
}
@media only screen and (max-width: 1024px) {

  .habit-footer .btn-primary, .btn-white {
    padding: 15px 5%;
    margin: 20px 0px;
  }
  .habit-footer .btn-primary, .btn-white {
    padding: 9px 5%;

  }
}
@media only screen and (min-width: 768px) and (max-width: 1240px) {

  .habit-footer .btn-primary {
    padding: 15px 5%;
    margin: 20px 0px;
  }
   .habit-footer .btn-primary, .btn-white {
    padding: 15px 5%;

  }
  .habit-footer .offset-2 {
    margin-left: 30.6666666667% !important;
  }
}
@media (max-width: 1024px) and (min-width: 768px)
{
	.habit-footer .col-md-6 {
    flex: 0 0 50%;
    max-width: 50%;
}
}
@media only screen and (max-width: 991px) {
	.ml-280 {
	margin-left:30px !important;
}
}
@media only screen and (max-width: 768px) {
  .habit-footer .btn-primary {
    padding: 12px 5%;
    margin: 5px 19px;
    font-size: 0.7rem;
  }
  .habit-footer .btn-white {

    font-size: 0.7rem;
  }
  .habit-footer .text-right {
	  text-align: left !important;
  }

  .habit-footer .font-siz-16 {
    font-size: 13px;
  }
  .habit-footer {
    padding-bottom: 5px;
  }
}


@media only screen and (max-width: 374px) {
  .habit-footer {
    padding-bottom: 25px;
  }
}
</style>

<script>
import FileUpload from 'vue-upload-component';
import swal from '../../components/swal';
export default {
	components:{
		FileUpload
	},
	props:['profile'],
	data() {
		return {
			image:{},
			profile_image_url:'',
			errors:{
				introduction: '',
				profile_pic: '',
				fb_url: '',
				insta_url: '',
				linked_url: '',
			},
			profile_data: {
				full_name:'',
				profile_pic: '',
				introduction:'',
				fb_url: '',
				insta_url: '',
				linked_url: '',
			},
			data_updated:false,
		};
	},
	mounted(){
		this.initiateData();
	},
	methods: {
		dataUpdated(){
			this.data_updated = true;
		},
		initiateData(){
			if(this.profile){
			  this.profile_data = Object.assign({}, this.profile);
			}else{
				this.profile_data= {
					full_name:'',
					profile_pic: '',
					introduction:'',
					fb_url: '',
					insta_url: '',
					linked_url: '',
				};
			}

			this.profile_data.full_name = this.AuthUser.full_name;
		},
		discard(){
			this.initiateData();
			this.data_updated = false;
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
				swal.successDialog('Profile Updated', 'Successfully!', 'success');
				this.data_updated = false;
				console.log(resp);
			});

			this.errors={
				profile_pic: '',
				fb_url: '',
				insta_url: '',
				linked_url: '',
				introduction:'',
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
