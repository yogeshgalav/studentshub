<template>
  <div class="row">
    <div
      class="col-md-10"
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
              <div class="user_profile_img">
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
            <div class="form-group">
              <label>Full Name</label>
              <input
                v-model="profile_data.full_name"
                class="form-control"
                type="text"
                @input="dataUpdated"
              >
            </div>
            <div class="form-group">
              <label>Email Id</label>
              <input
                class="form-control"
                type="text"
                disabled
                :value="AuthUser.email"
              >
            </div>
            <div class="form-group">
              <select-institute
                v-model="preferred_institute"
                @change="dataUpdated"
              />
            </div>
            <div class="form-group">
              <select-course
                v-model="preferred_course"
                @change="dataUpdated"
              />
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
                  <label>Instagram Username</label>
                  <input
                    v-model="profile_data.insta_url"
                    class="form-control"
                    type="text"
                    placeholder="Instagram Username"
                    @input="dataUpdated"
                  >
                  <span class="text-danger">{{ errors.insta_url }}</span>
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
        v-if="AuthUser.role==='student'"
        class="card mt-3 mb-6"
      >
        <div class="card-header">
          <h4>Education details</h4>
        </div>

        <div class="card-body">
          <div class="row my-auto">
            <div class="col-sm-4 col-md-6">
              <h5>Course name</h5>
              <label>{{ AuthUser.courseName }}</label>
            </div>
            <div class="col-sm-4 col-md-6">
              <h5>Institute name</h5>
              <label>{{ AuthUser.instituteName }}</label>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-sm-4 col-md-6">
              <h5>Start year</h5>
              <label>{{ AuthUser.start_year }}</label>
            </div>
            <div class="col-sm-4 col-md-6">
              <h5>End year</h5>
              <label>{{ AuthUser.end_year }}</label>
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

      <!--teaching details -->
      <div
        v-if="AuthUser.role==='teacher'"
        class="card mt-3 mb-6"
      >
        <div class="card-header">
          <h4>Teaching details</h4>
        </div>
        <div>
          <div
            v-for="(teacher, index) in teachersDetails"
            :key="index"
            class="card-body"
          >
            <div class="row my-auto">
              <div class="col-sm-4 col-md-6">
                <h5>Institute name</h5>
                <label>{{ teachers.institute_name }}</label>
              </div>
            </div>
            <div class="row my-auto">
              <div class="col-sm-4 col-md-6">
                <h5>Course name</h5>
                <label>{{ teachers.course_name }}</label>
              </div>
            </div>
            <button
              class="btn btn-danger btn-sm rounded-0"
              type="button"
              data-toggle="tooltip"
              data-placement="top"
              title="Delete"
              @click="deleteTeacherDetails"
            >
              <i class="fa fa-trash" />
            </button>
            <hr>
          </div>
          <button
            type="add"
            class="btn btn-primary mt-3"
            data-toggle="modal"
            data-target="#addModal"
          >
            Add
          </button>
        </div>
        <modal
          ref="addModal"
          name="addModal"
          heading="Add Course Institute"
          classes="modal-md"
          @submit="addTeacherDetails"
        >
          <template slot="modalBody">
            <form>
              <div class="p-10">
                <div class="form-group">
                  <select-institute
                    v-model="edit_institute"
                  />
                </div>
                <div class="form-group">
                  <select-course
                    v-model="edit_course"
                  />
                </div>
              </div>
            </form>
          </template>
        </modal>
        <!-- fotter for update chnges -->
        <div
          v-if="data_updated"
          class="static-footer"
        >
          <div class="col-md-12 mt-2 mb-2">
            <div
              class="text-right"
            >
              <button
                class="btn btn-primary mr-2"
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
</template>

<style scoped>
.ml-280 {
	margin-left:300px !important;
}
</style>

<script>
import Modal from '../../components/VueNiceModal';
import FileUpload from 'vue-upload-component';
import SelectCourse from '../../components/SelectCourse.vue';
import SelectInstitute from '../../components/SelectInstitute.vue';
import swal from '../../components/swal';
export default {
	components:{
		FileUpload,
		Modal,
		SelectInstitute,
		SelectCourse
	},
	props:['user','teachers','teacher'],
	data() {
		return {
			teachersDetails:{},
			image:{},
			profile_image_url:'',
			errors:{
				profile_pic: '',
				fb_url: '',
				insta_url: '',
				linked_url: '',
			},
			profile_data: {
				full_name:'',
				profile_pic: '',
				fb_url: '',
				insta_url: '',
				linked_url: '',
			},
			preferred_institute:{
				id:null,
				name:'',
			},
			preferred_course:{
				id:null,
				course_name:'',
			},
			edit_institute:'',
			edit_course:'',
			data_updated:false,
		};
	},
	mounted(){
		 this.initiateData();
    	this.teachersDetails=this.teachers;
	},
	methods: {
		dataUpdated(){
			this.data_updated = true;
		},
		initiateData(){
			if(this.user){
			  this.profile_data = Object.assign({}, this.user.profile);
				this.preferred_institute = this.user.preferred_institute;
				this.preferred_course = this.user.preferred_course;
			}else{
				this.profile_data= {
					full_name:'',
					profile_pic: '',
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
    	addTeacherDetails()
		{
			let loader = this.$loading.show();
      	this.axios.post(this.baseUrl + '/api/add-teacherdetails',{
    			edit_institute:this.edit_institute,	
				  edit_course:this.edit_course,	
    		} )
    			.then(resp => {
    			window.location.reload;
    			});
		},
		deleteTeacherDetails(teacher){
			console.log(teacher.id);
		  	let loader = this.$loading.show();           
			this.axios.delete('/api/delete-teachersdetails/'+this.teacher.teacher_id)
				.then(resp=>{
					loader.hide();
					let index= this.teachersDetails.findIndex(el=>el.id===this.teacher.teacher_id);
					this.teachersDetails.splice(index,1);		
				});

		},
		async saveProfile() {
			if(this.profile_data.fb_url && !this.profile_data.fb_url.includes('facebook.com')){
				this.errors.fb_url='This is not valid Facebook url.';
				return false;
			}
			if(this.profile_data.insta_url && !this.profile_data.insta_url.match(/^[a-zA-Z0-9_.]*$/g)){
				this.errors.insta_url='This is not valid Instagram username.';
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

			await this.axios.post('/api/save-profile', Object.assign({
				preferred_institute:this.preferred_institute,
				preferred_course:this.preferred_course,
			},this.profile_data)
			).then((resp) => {
				this.setProfile(resp.data.success.profile);
				swal.successDialog('Profile Updated', 'Successfully!', 'success');
				this.data_updated = false;
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
