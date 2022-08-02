<template>
  <section class="row">
    <Head>
      <title>{{ institute ? institute.name : "My Institute" }}</title>
    </Head>
    <!-- Header -->
    <div
      v-if="institute"
      id="institute_header"
      class="col-md-12"
    >
      <div class="card">
        <div class="card-body p-4">
          <div class="">
            <img
              v-if="institute.profile_url"
              :src="institute.profile_url"
              style=" width: 100%; height: 185px; margin-bottom: -40px; border-radius: 15px "
              alt=""
            >

            <img
              v-else-if="institute_banner_url"
              :src="institute_banner_url"
              style=" width: 100%; height: 185px; margin-bottom: -40px; border-radius: 15px;"
              alt=""
            >

            <img
              v-else
              src="/images/banner.png"
              style=" width: 100%; height: 185px; margin-bottom: -40px; border-radius: 15px "
              alt=""
            >
            <file-input
              id="documentUploadbanner"
              ref="upload"
              class="EditBanner btn btn-light bottom-right"
              post-action="/upload/post"
              extensions="jpg,jpeg,png"
              accept="image/*"
              :drop="true"
              :size="102 * 1024 * 10"
              @update="updatebanner"
            >
              edit banner image
            </file-input>
          </div>
          <div class="container">
            <img
              v-if="institute.avatar_url"
              :src="institute.avatar_url"
              alt=""
            >
            <img
              v-else-if="logo_url"
              :src="logo_url"
              alt=""
            >
            <img
              v-else
              class="institute-avatar" 
              src="/images/ins.png"
              alt="Student Hub"
              width="120 "
              height="120"
              style="
                                margin-left: 15px;
                                border-radius: 100px;
                                border-color: white;
                            "
            ><file-upload
              id="documentUploadlogo"
              ref="upload"
              class="edit-avatar bottom-left"
              post-action="/upload/post"
              extensions="jpg,jpeg,png"
              accept="image/*"
              :drop="true"
              :size="1024 * 1024 * 10"
              @input="uploadlogo"
            >
              <file-input @update="uploadlogo" />
            </file-upload>
          </div>
          <h3 style="margin: 20px 0px 0px 20px">
            {{ institute ? institute.name : "My Institute" }}
            <button
              v-if="editPermission"
              type="button"
              class="btn btn-link"
              data-toggle="modal"
              data-target="#addEditInstituteModal"
            >
              <i
                class="fas fa-pencil-alt text-grey"
                style="color: white"
              />
            </button>
          </h3>
          <h5 style="margin: 5px 0px 0px 20px">
            {{ institute.moto ? institute.moto : "Institute Moto" }}
          </h5>
          <p style="margin-left: 20px">
            {{ institute.description }}
          </p>
          <div>
            <div style="float: right">
              <ul class="social-network social-circle">
                <li>
                  <a
                    target="_blank"
                    :href=" institute.fb_url ? institute.fb_url : '#'"
                    :disabled=" institute.fb_url ? false : true "
                    :class="['icoFacebook',institute.fb_url ? '' : 'disabled', ]"
                    title="Facebook"
                  >
                    <i class="fab fa-facebook-f" />
                  </a>
                </li>
                <li>
                  <a
                    target="_blank"
                    :href="institute.twitter_url ? 'https://twitframe.com/show?url='+institute.twitter_url : '#'"
                    :disabled=" institute.twitter_url ? false : true "
                    :class="['icoTwitter', institute.twitter_url ? '':'disabled',]"
                    title="Twitter"
                  >
                    <i class="fab fa-twitter" />
                  </a>
                </li>
                <li>
                  <a
                    target="_blank"
                    :href=" institute.insta_url ? institute.insta_url : '#' "
                    :disabled=" institute.insta_url ? false : true "
                    :class="['icoInstagram',institute.insta_url ? '' : 'disabled', ]"
                    title="Instagram"
                  >
                    <i class="fab fa-instagram" />
                  </a>
                </li>
                <li>
                  <a
                    target="_blank"
                    :href=" institute.linkedin_url ? institute.linkedin_url :'#'" 
                    :disabled=" institute.linkedin_url ? false: true"
                    :class="[ 'icoLinkedin', institute.linkedin_url ? '' : 'disabled',]"
                    title="Linkedin"
                  >
                    <i class="fab fa-linkedin" />
                  </a>
                </li>
                <li>
                  <a
                    target="blank"
                    :href=" institute.youtube_vedio_url ?'https://www.youtube.com/embed/'+ institute.youtube_vedio_url : '#'"
                    :disabled=" institute.youtube_vedio_url ? false : true"
                    :class="['icoYoutube', institute.youtube_vedio_url ? '': 'disabled',]"
                    title="Youtube"
                  >
                    <i class="fab fa-youtube" />
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <modal
        id="addEditInstituteModal"
        key="addEditInstituteModal"
        ref="addEditInstituteModal"
        name="addEditInstituteModal"
        class="model-md"
        heading="Profile Info"
        @submit="saveProfile()"
      >
        <template slot="modalBody">
          <form validationScope="add_institute_form">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="fb_url"> Facebook Profile Url</label>
                  <input
                    v-model="institute.fb_url"
                    class="form-control"
                    type="text"
                    placeholder="http://facebook.com/profile-id"
                  >
                  <span class="text-danger">{{ errors.fb_url }}</span>
                  <label>Twitter Url</label>
                  <input
                    v-model="institute.twitter_url"
                    class="form-control"
                    type="text"
                    placeholder="http://twitter.com/profile-id"
                  >
                  <span class="text-danger">{{ errors.twitter_url }}</span>
                  <label>Instagram Username</label>
                  <input
                    v-model="institute.insta_url"
                    class="form-control"
                    type="text"
                    placeholder="http://instagram.com/profile-id"
                  >
                  <span class="text-danger">{{ errors.insta_url }}</span>
                  <label>Linkedin Profile Url</label>
                  <input
                    v-model="institute.linkedin_url"
                    class="form-control"
                    type="text"
                    placeholder="http://linked.com/profile-id"
                  >
                  <span class="text-danger">{{ errors.linkedin_url }}</span>
                  <label>Youtube Vedio Url</label>
                  <input
                    v-model="institute.youtube_vedio_url"
                    class="form-control"
                    type="text"
                    placeholder="http://youtube.com/profile-id"
                  >
                  <span class="text-danger">{{ errors.youtube_vedio_url }}</span>
                  <label for="website">Website</label>
                  <input
                    id="website"
                    v-model=" institute.website"
                    name="website"
                    class="form-control"
                    placeholder="http://website.com"
                  >
                  <label for="address">Address</label>
                  <input
                    id="address"
                    v-model=" institute.address"
                    name="address"
                    class="form-control"
                    placeholder="write Address here"
                  >
                  <label for="city">City</label>
                  <input
                    id="city"
                    v-model="institute.city"
                    name="city"
                    class="form-control"
                    placeholder="write City here"
                  >
                  <label for="state">State</label>
                  <input
                    id="state"
                    v-model=" institute.state"
                    name="state"
                    class="form-control"
                    placeholder="write State here"
                  >
                  <label for="moto">Moto</label>
                  <input
                    id="state"
                    v-model="institute.moto"
                    name="moto"
                    class="form-control"
                    placeholder="write moto here"
                  >
                </div>
              </div>
            </div>
          </form>
        </template>
      </modal>
    </div>

    <section
      v-if="!institute"
      class="col-md-12"
    >
      <div class="row">
        <div class="col-md-8 col-12">
          <p class="text-blue weight-600 mb-2 mt-3">
            Enter your preferred institute name to see Teachers and Students.
          </p>
          <select-institute v-model="selected_institute" />
        </div>
        <div class="col-md-8 col-12">
          <button
            v-if="isCourseValid"
            type="button"
            class="btn btn-md btn-primary mt-1"
            @click="submitCourse"
          >
            Submit
          </button>
        </div>
      </div>
    </section>

    <div
      v-if="institute.id"
      class="col-md-12 mt-3"
    >
      <nav-tabs
        :tabs="tabs"
        :initial-tab="initialTab"
      >
        <template slot="tab-heading-teachers">
          {{ "Teachers" }}
        </template>
        <template slot="tab-panel-teachers">
          <div class="col-md-3 col-12 mb-2 mt-2">
            <social-sharing
              :url="
                AuthUser.full_name +
                  ' has invited you to join ' +
                  institute.name +
                  ' on Students Hub. click the link below to join now \n ' +
                  baseUrl +
                  '/get-started?inId=' +
                  institute.id
              "
              inline-template
            >
              <div class="">
                <network network="whatsapp">
                  <button
                    type="button"
                    class="btn btn-success btn-lg"
                  >
                    <i class="fab fa-whatsapp" />&nbsp;&nbsp;Invite
                  </button>
                </network>
              </div>
            </social-sharing>
          </div>
          <div
            v-if="!teachers.length"
            class="row"
          >
            <div class="col-md-10">
              <div class="card">
                <div class="card-body">
                  <p>
                    Invite your teachers to join
                    StudentsHub..
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div
            v-else
            class="row"
          >
            <div class="col-md-8 col-12">
              <div
                v-for="(teacher, index) in teachers"
                :key="index"
                class="card mb-2"
              >
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="text-center">
                        <div style=" text-align: -webkit-center;">
                          <profile-image :user-name=" teacher.full_name " />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-10">
                      <p class="mb-0 font-weight-bold text-black">
                        <a :href=" '/profile/' + teacher.id ">
                          {{ teacher.full_name }}</a>
                      </p>
                      <span class="font-weight-normal">
                        {{ teacher.preferred_course ? teacher.preferred_course .course_name: "" }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
        <template slot="tab-heading-students">
          {{ "Students" }}
        </template>
        <template slot="tab-panel-students">
          <div class="col-md-3 col-12 mb-2 mt-2">
            <social-sharing
              :url="
                AuthUser.full_name +
                  ' has invited you to join ' +
                  institute.name +
                  ' on Students Hub. click the link below to join now \n ' +
                  baseUrl +
                  '/get-started?inId=' +
                  institute.id
              "
              inline-template
            >
              <div class="">
                <network network="whatsapp">
                  <button
                    type="button"
                    class="btn btn-success btn-lg"
                  >
                    <i class="fab fa-whatsapp" />&nbsp;&nbsp;Invite
                  </button>
                </network>
              </div>
            </social-sharing>
          </div>
          <div
            v-if="!students.length"
            class="row"
          >
            <div class="col-md-10">
              <div class="card">
                <div class="card-body">
                  <p>
                    Invite your friends to join Student's Hub.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div
            v-else
            class="row"
          >
            <div class="col-md-8 col-12">
              <div
                v-for="(student, index) in students"
                :key="index"
                class="card mb-2"
              >
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="text-center">
                        <div style="text-align: -webkit-center">
                          <profile-image :user-name="student.full_name" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-10">
                      <p class="mb-0 font-weight-bold text-black">
                        <a :href="'/profile/' + student.id">
                          {{ student.full_name }}</a>
                      </p>
                      <span class="font-weight-normal">
                        {{ student.preferred_course ? student.preferred_course.course_name : "" }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
        <template slot="tab-heading-about">
          {{ "About" }}
        </template>
        <template slot="tab-panel-about">
          <div v-if="editPermission && !instituteVerified">
            <p>
              Thank you for creating account on Student's Hub! <br>
              Our team will soon contact you on phone for
              account verification.<br>
              Once account verified you will be able to
              promote your institute to thousands of
              students.
            </p>
          </div>
          <div v-if="instituteVerified">
            <AboutInstitute
              :institute="institute"
              :edit-permission="editPermission"
            />
          </div>
        </template>

        <template slot="tab-heading-posts">
          {{ "Posts" }}
        </template>
        <template slot="tab-panel-posts">
          <PostContainer
            v-if="AuthUser.preferred_institute_id"
            :post-route="'/institute/' + AuthUser.preferred_institute_id"
          >
            <template slot="empty">
              <img
                class="search-not-found"
                src="/images/search-not-found.png"
              >
              <p style="text-align: center">
                Currently no post have been shared in your institute.
              </p>
            </template>
          </PostContainer>
        </template>
        <template slot="tab-heading-doubts">
          {{ "Doubts" }}
        </template>
        <template slot="tab-panel-doubts">
          <DoubtContainer
            v-if="AuthUser.preferred_course_id"
            :doubt-route="'/course/' + AuthUser.preferred_course_id"
          >
            <template slot="empty">
              <img
                class="search-not-found"
                src="/images/search-not-found.png"
              >
              <p style="text-align: center">
                Currently no doubt have been shared in your institute.
              </p>
            </template>
          </DoubtContainer>
        </template>
      </nav-tabs>
    </div>
  </section>
</template>
<style scoped>
.bottom-right {
    position: absolute;
    background-color: white;
    bottom: 239px;
    right: 35px;
}
.container {
    position: relative;
}
.bottom-left {
    position: absolute;
    bottom: 10px;
    left: 115px;
}
.profile-form {
    margin-top: 20px;
}
.col-md-12 {
    margin-top: 10px;
}
.profile-info {
    margin-top: 30px;
}


/* .Administrator-profile {
  display: inline-flex;
  flex-direction: column;
  flex-wrap: nowrap;
  justify-content: flex-start;
  gap: 5px;
  text-align: center;
} */
/* .edit-btn-row {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  justify-content: flex-end;
  align-items: center;
  align-content: center;
} */
/* @media (max-width: 769px)  {
.addAdmin{
text-align: center;
}
} */
@media (max-width: 769px)  {
.EditBanner{
  height: 80px;
    width: 111px;
    position: absolute;
    background-color: white;
    bottom: 265px;
    right: 35px;
}
}
@media (max-width: 769px)  {
.institute-avatar{
    margin-left: 0px !important;
}
}
@media (max-width: 769px)  {
.edit-avatar{
    
    position: absolute;
    bottom: 5px;
    left: 100px;
}
}
</style>
<script>
// import Accordion from '@/components/accordion.vue';
import NavTabs from '../../components/NavTabs';
import SelectInstitute from '../../components/SelectInstitute.vue';
import PostContainer from '@/Pages/common/post-container.vue';
import DoubtContainer from '@/Pages/doubt/doubt-container.vue';
import SocialSharing from 'vue-social-sharing';
import swal from '../../components/swal';
import FileUpload from 'vue-upload-component';
import Modal from '../../components/VueNiceModal.vue';
import FileInput from '@/Shared/FileInput.vue';
import AboutInstitute from './about-institute.vue';

export default {
	components: {
		AboutInstitute,
		NavTabs,
		PostContainer,
		DoubtContainer,
		SelectInstitute,
		SocialSharing,
		FileUpload,
		Modal,
		FileInput
	},
	props:['institute', 'editPermission','instituteVerified'],
	data() {
		return {
			institute_banner_url: '',
			logo_url: '',
			institute_users: [],
			institute_contacts: [],
			edit_institute_contact: {
				email: '',
				phone_no: '',
				phone_no2: '',
			},
			edit_institute: {
				website: '',
				address: '',
				moto:'',
			},
			user_id: '',
			role: '',
			phone_no: '',
			name: '',
			teachers: [],
			students: [],
			posts: [],
			errors: {
				fb_url: '',
				twitter_url: '',
				insta_url: '',
				linkedin_url: '',
				youtube_vedio_url: '',
			},

			initialTab: 'about',
			tabs: ['about', 'posts', 'doubts', 'students', 'teachers'],
			showLoader: true,
			selected_institute: {
				id: null,
				name: '',
			},
			isEdit: true,
			new_blog: '',
		};
	},
	computed: {
		isCourseValid() {
			if (this.selected_institute && this.selected_institute.name) {
				return true;
			}
			return false;
		},
	},
	watch:{

		institute(oldVal, val){
			if(val){
				this.loadInstitute();
			}
		}
	},
	mounted() {
		this.loadInstitute();
		if (!this.editPermission && !this.instituteVerified) {
			this.tabs.shift();
			this.initialTab = 'posts';
		} 
	},
	methods: {
		loadInstitute() {
			this.axios
				.get('/api/institute/' + this.institute.id)
				.then((resp) => {
					this.institute_users = resp.data.success.institute_users;
			
					this.teachers = resp.data.success.teachers;
					// this.institute = resp.data.success.institute;
					this.students = resp.data.success.students;
				});
		},
		// addAdministrator() {
		// 	this.$modal.show('editAdminModal');
		// },
	
		async saveProfile() {
			this.showLoader = true;
			if (
				this.institute.fb_url &&
                !this.institute.fb_url.includes('facebook.com')
			) {
				this.errors.fb_url = 'This is not valid Facebook url.';
				return false;
			}
			if (
				this.institute.twitter_url &&
			          !this.institute.twitter_url.includes('twitter.com')
			) {
				this.errors.twitter_url = 'This is not valid Twitter url.';
				return false;
			}
			if (
				this.institute.insta_url &&
			          !this.institute.insta_url.match(/^[a-zA-Z0-9_.]*$/g)
			) {
				this.errors.insta_url = 'This is not valid Instagram username.';
				return false;
			}
			if (
				this.institute.linkedin_url &&
                !this.institute.linkedin_url.includes('linkedin.com')
			) {
				this.errors.linkedin_url = 'This is not valid Linkedin url.';
				return false;
			}
			// if (
			// 	this.institute.youtube_vedio_url &&
			//           !this.institute.youtube_vedio_url.includes('youtube.com')
			// ) {
			// 	this.errors.youtube_vedio_url = 'This is not valid Youtube url.';
			// 	return false;
			// }
			
			// if(this.image.file){
			// 	await this.getBase64(this.image.file).then(file=>{
			// 		this.institute.profile_pic=file;
			// 	});
			// }
			this.axios
				.post('/api/save-institute-profile',this.institute, {
					headers: {
						'Content-Type': 'multipart/form-data'
					}
				})
				.then((resp) => {
					this.showLoader = false;
					swal.successDialog(
						'Institute Page Updated',
						'Successfully!',
						'success'
					);
				});

			this.errors = {
				fb_url: '',
				twitter_url: '',
				insta_url: '',
				linkedin_url: '',
				youtube_vedio_url: '',
			};
		},
		inputUpdate(files) {
			console.log('xyz');
			this.image = files[0];
			this.institute_banner_url = URL.createObjectURL(files[0].file);
		},
		
		
		
		// set contact data in add edit modal
		
	
		submitCourse() {
			this.axios
				.put('/api/preferred-details', {
					preferred_institute: this.selected_institute,
				})
				.then((resp) => {
					window.location.reload();
				});
		},
		clearModalData() {
			this.name = '';
			this.role = '';
			this.id = '';
		},
		updatebanner(file){
			console.log('xyz',file);
			if (file) {
				var reader = new FileReader();

				reader.onload = function (e) {
					document.getElementById('#id').attr('src', e.target.result).width(150).height(200);
				};

				reader.readAsDataURL(file);
			}
		}
	
	},
};
</script>
