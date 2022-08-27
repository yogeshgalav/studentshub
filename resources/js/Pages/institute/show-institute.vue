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
              v-if="institute_banner_image"
              :src="institute_banner_image"
              style=" width: 100%; height: 185px; margin-bottom: -40px; border-radius: 15px;"
              alt=""
            >
            <img
              v-else-if="institute.banner_url"
              :src="institute.banner_url"
              style=" width: 100%; height: 185px; margin-bottom: -40px; border-radius: 15px "
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
            />
            <button
              v-if="isUpload"
              type="button"
              class="btn btn-secondary"
              @click="saveProfile"
            />
          </div>
          <div class="container">
            <img
              v-if="institute_logo_image"
              :src="institute_logo_image"
              alt=""
            >
            <img
              v-else-if="institute.logo_url"
              :src="institute.logo_url"
              alt=""
            >
            <img
              v-else
              class="institute-avatar" 
              src="/images/ins.png"
              alt="Student Hub"
              width="120 "
              height="120"
              style="margin-left: 15px;border-radius: 100px;border-color: white;"
            >
            <file-input
              id="documentUploadlogo"
              ref="upload"
              class="edit-avatar bottom-left"
              post-action="/upload/post"
              extensions="jpg,jpeg,png"
              accept="image/*"
              :drop="true"
              :size="1024 * 1024 * 10"
              @update="uploadlogo"
            />
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
          <h5>
            {{ institute.moto ? institute.moto : '' }}
          </h5>
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
                    :href=" institute.youtube_vedio_url ?institute.youtube_vedio_url : '#'"
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
      <edit-institute-modal v-model="edit_institute" />
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
      v-if="institute && institute.id"
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
            :post-route="'/institute/' + institute.id"
          >
            <template slot="empty">
              Currently no post have been shared in your institute.
            </template>
          </PostContainer>
        </template>
        <template slot="tab-heading-doubts">
          {{ "Doubts" }}
        </template>
        <template slot="tab-panel-doubts">
          <DoubtContainer
            :doubt-route="'/institute/'+ institute.id"
          >
            <template slot="empty">
              Currently no doubt have been shared in your institute.
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
import FileInput from '@/Shared/FileInput.vue';
import AboutInstitute from './about-institute.vue';
import EditInstituteModal from './edit-institute-modal.vue';

export default {
	components: {
		EditInstituteModal,
		AboutInstitute,
		NavTabs,
		PostContainer,
		DoubtContainer,
		SelectInstitute,
		SocialSharing,
		// FileUpload,
		FileInput
	},
	props:['institute', 'editPermission','instituteVerified'],
	data() {
		return {
			institute_banner_image: '',
			institute_logo_image: '',
			institute_users: [],
			institute_contacts: [],
			edit_institute_contact: {
				email: '',
				phone_no: '',
				phone_no2: '',
			},
			edit_institute: {
				youtube_vedio_url:'',
				insta_url:'',
				twitter_url:'',
				fb_url:'',
				linkedin_url:'',
				website: '',
				address: '',
				city:'',
				state:'',
				moto:'',
			},
			user_id: '',
			role: '',
			phone_no: '',
			name: '',
			teachers: [],
			students: [],
			posts: [],
			initialTab: 'about',
			tabs: ['about', 'students', 'teachers', 'posts', 'doubts'],
			showLoader: true,
			selected_institute: {
				id: null,
				name: '',
			},
			isEdit: true,
			new_blog: '',
			isUpload: false,
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
			this.initialTab = 'students';
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
		updatebanner(file) {
			this.isUpload = true;
			this.getBase64(file).then(file=>{
				this.institute_banner_image=file;
			});
			// this.institute_banner_url = URL.createObjectURL(file);
			this.data_updated = true;
		},
		getBase64(file) {
			return new Promise((resolve, reject) => {
				const reader = new FileReader();
				reader.readAsDataURL(file);
				reader.onload = () => resolve(reader.result);
				reader.onerror = error => reject(error);
			});
		},
		uploadlogo(file){
			this.isUpload = true;
			this.getBase64(file).then(file=>{
				this.institute_logo_image=file;
			});
			// this.institute_logo_url = URL.createObjectURL(file);
			this.data_updated = true;
		}
	
	},
};
</script>
