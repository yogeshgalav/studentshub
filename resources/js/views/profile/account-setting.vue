<template>
  <div class="row">
    <div
      class="col-md-8 col-12"
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
            
            <div class="form-group">
              <label> {{ ('Preferred Institute') }} </label>
              <div class="">
                <div class="">
                  <auto-complete
                    :key="'institute'"
                    v-model="selected_institute"
                    v-validate="'required'"
                    :items="institute_list"
                    :text="'name'"
                    name="institute_name"
                    :is-async="true"
                    :is-loading="instituteLoading"
                    @change="getInstitutes"
                  />
                </div>
                <span class="text-danger">{{ formErrors('student.institute_name') }}</span>
              </div>
            </div>
            <div class="form-group">
              <label> {{ 'Course name' }} </label>
              <div class="">
                <div class="">
                  <auto-complete
                    :key="'courseList'"
                    ref="courseList"
                    v-model="selected_course"
                    v-validate="'required'"
                    :items="course_list"
                    :text="'course_name'"
                    name="program_name"
                    :placeholder="'eg. Bachelor of Arts'"
                    :is-async="true"
                    :is-loading="courseLoading"
                    @change="getCourses"
                  />
                </div>
                <span class="error">{{ formErrors('student.program_name') }}</span>
              </div>
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
                  <span class="text-danger">{{ link_error.introduction }}</span>
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
                  <span class="text-danger">{{ link_error.fb_url }}</span>
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
                  <span class="text-danger">{{ link_error.insta_url }}</span>
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
                  <span class="text-danger">{{ link_error.linked_url }}</span>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- teacher details -->
      <div
        v-if="!['student','seeker'].includes(AuthUser.role_intended)"
        class="card mt-3 mb-6"
      >
        <div class="card-header">
          <h4>Teacher details</h4>
        </div>

        <div class="card-body">
          <div
            v-for="teacher in teacherDetails"
            :key="teacher.id"
            class="row my-auto"
          >
            <div class="col-sm-4 col-md-6">
              <h5>Course name</h5>
              <label>{{ teacher.courseName }}</label>
            </div>
            <div class="col-sm-4 col-md-6">
              <h5>Institute name</h5>
              <label>{{ teacher.instituteName }}</label>
            </div>
          </div>

          <div class="row">
            <button
              class="btn btn-link mt-3"
              data-toggle="modal"
              data-target="#addDetailsModal"
              @click="addTeacherDetails"
            >
              Add
            </button>
          </div>
        </div>
      </div>
      <!-- education details -->
      <div
        class="card mt-3 mb-6"
      >
        <div class="card-header">
          <h4>Education details</h4>
        </div>

        <div class="card-body">
          <div
            v-for="student in studentDetails"
            :key="student.id"
            class="row my-auto"
          >
            <div class="col-sm-4 col-md-6">
              <h5>Course name</h5>
              <label>{{ student.courseName }}</label>
            </div>
            <div class="col-sm-4 col-md-6">
              <h5>Institute name</h5>
              <label>{{ student.instituteName }}</label>
            </div>
          </div>

          <div class="row">
            <button
              class="btn btn-link mt-3"
              data-toggle="modal"
              data-target="#addDetailsModal"
              @click="addStudentDetails"
            >
              Add
            </button>
          </div>
        </div>
      </div>

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

    <!--the add/edit doubt modal -->
    <modal
      ref="addDetailsModal"
      name="addDetailsModal"
      :heading="add_details_heading"
      classes="modal-lg"
      @submit="submitDetails"
    >
      <template slot="modalBody">
        <form
          data-vv-scope="student"
          @submit.prevent="handleSubmit('student')"
        >
          <div class="form-group">
            <label> {{ ('Institute Name') }} </label>
            <div class="">
              <div class="">
                <auto-complete
                  :key="'institute'"
                  v-validate="'required'"
                  :items="institute_list"
                  :value="'name'"
                  name="institute_name"
                  :is-async="true"
                  :initial-value="selected_institute"
                  :is-loading="instituteLoading"
                  @input="getInstitutes"
                  @selected="setInstitute"
                />
              </div>
              <span class="text-danger">{{ formErrors('student.institute_name') }}</span>
            </div>
          </div>
          <div
            class="form-group"
          >
            <label> {{ 'Course name' }} </label>
            <div class="">
              <div class="">
                <auto-complete
                  :key="'courseList'"
                  ref="courseList"
                  v-validate="'required'"
                  :items="course_list"
                  :value="'course_name'"
                  name="program_name"
                  :placeholder="'eg. Bachelor of Arts'"
                  :is-async="true"
                  :initial-value="selected_course"
                  :is-loading="courseLoading"
                  @input="getCourses"
                  @selected="setCourse"
                  @selectNew="setNewCourse"
                />
              </div>
              <span v-if="no_course_found">Please enter your full course name
                followed by branch name(if any).Please make sure that program
                details you are entering is correct.</span>
              <span class="error">{{ formErrors('student.program_name') }}</span>
            </div>
          </div>
          <div class="row">
            <button
              type="submit"
              class="btn-primary btn-lg m-0-a"
            >
              {{ ('Submit') }}
            </button>
          </div>
        </form>
      </template>
    </modal>
  </div>
</template>

<style scoped>
.ml-280 {
	margin-left:300px !important;
}
</style>

<script>
import FileUpload from 'vue-upload-component';
import swal from '../../components/swal';
import FormMixin from '../../components/mixins/form-mixin.js';
import Modal from '../../components/VueNiceModal.vue';
import AutoComplete from '../../components/AutoComplete.vue';

export default {
	components:{
		FileUpload,
		Modal,
		AutoComplete
	},
	mixins:[FormMixin],
	props:['profile'],
	data() {
		return {
			image:{},
			profile_image_url:'',
			link_error:{
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

			teacherDetails:[],
			studentDetails:[],
			add_details_type:'student',

			course_list: [],
			courseLoading: false,
			no_course_found: false,
			institute_list: [],
			instituteLoading: false,
			selected_course: {
				'id': null,
				'course_name': '',
				'category_id': ''
			},
			selected_institute: {
				'id': null,
				'name': '',
				'place_id': '',
				'address': '',
				'description': ''
			},
			
		};
	},
	computed:{
		add_details_heading(){
			return this.add_details_type==='student' ? 'Add Educational Details':'Add Teacher Details';
		}
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
				this.link_error.fb_url='This is not valid Facebook url.';
				return false;
			}
			if(this.profile_data.insta_url && !this.profile_data.insta_url.includes('instagram.com')){
				this.link_error.insta_url='This is not valid Instagram url.';
				return false;
			}
			if(this.profile_data.linked_url &&!this.profile_data.linked_url.includes('linkedin.com')){
				this.link_error.linked_url='This is not valid Linkedin url.';
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
			});

			this.link_error={
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
		},
		submitDetails(){

		},
		addStudentDetails(){

		},
		addTeacherDetails(){
      
		},
		//
		getCourses(search) {
			this.selected_course = {
				'id': null,
				'course_name': search,
				'category_id': ''
			};
			this.courseLoading = true;
			this.$refs.courseList.$el.focus();
			this.axios
				.get(this.baseUrl + '/api/search-course?searchTerm='+search)
				.then(resp => {
					this.course_list = resp.data.success.courses;
					this.course_list.find(node => {
						if (node.course_name.toLowerCase() === this.selected_course.course_name
							.toLowerCase()) {
							this.selected_course = node;
							return true;
						}
					});
					this.no_course_found= this.course_list.length===0 ? true :false;
					this.courseLoading = false;
				}).catch(() => {
					this.courseLoading = false;
				});

		},
		setCourse(result) {
			this.selected_course = result;
		},
		setNewCourse(name) {
			this.selected_course = {
				'id': 0,
				'course_name': name,
				'category_id': 0
			};
		},
		getInstitutes(search) {
			this.selected_institute = {
				'id': null,
				'name': search,
			};
			this.instituteLoading = true;
			this.axios
				.get(this.baseUrl + '/api/search-institute?searchTerm='+search)
				.then(resp => {
					this.institute_list = resp.data.success.institutes;
					this.institute_list.find(node => {
						if (node.name.toLowerCase() === this.selected_institute.name.toLowerCase()) {
							this.selected_institute = node;
							return true;
						}
					});
					this.instituteLoading = false;
				}).catch(() => {
					this.instituteLoading = false;
				});

		},
		setInstitute(result) {
			this.selected_institute = result;
		},
	}
};
</script>
