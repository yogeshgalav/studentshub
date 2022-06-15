<template>
  <div class="row">
    <Head>
      <title>{{ institute ? institute.name : 'My Institute' }}</title>
    </Head>
    <!-- Header -->
    <header
      id="home"
      style="max-width:1200px;min-width:400px"
    >
      <div class="card">
        <div class="card-body">
          <img
            src="/images/institute.jpg"
            width="1000"
            height="450"
            style="margin-bottom: -50px;"
          >
          <router-link
            href="/"
          >
            <img
              src="/logo.png"
              alt="Student Hub"
              width="100"
              height="100"
              style=" margin-left:10px;"
            >
          </router-link>
          <h3>
            {{ institute ? institute.name : 'My Institute' }}
          </h3>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.<br>
            Aenean a urna non felis elementum varius.
          </p>
          <div>
            <div style="float:right">
              <ul class="social-network social-circle">
                <li>
                  <a
                    target="_blank"
                    :href="institute.fb_url ? institute.fb_url :'#'"
                    :disabled="institute.fb_url ? false:true"
                    :class="['icoFacebook', institute.fb_url ? '' :'disabled']"
                    title="Facebook"
                  ><i class="fab fa-facebook-f" /></a>
                </li>
                <li>
                  <a
                    target="_blank"
                    :href="institute.twitter_url ? institute.twitter_url :'#'"
                    :disabled="institute.twitter_url ? false:true"
                    :class="[icoTwitter, institute.twitter_url ? '' :'disabled']"
                    title="Twitter"
                  ><i class="fab fa-twitter" /></a>
                </li>
                <li>
                  <a
                    target="_blank"
                    :href="institute.insta_url ? institute.insta_url :'#'"
                    :disabled="institute.insta_url ? false:true"
                    :class="[icoInstagram, institute.insta_url ? '' :'disabled']"
                    title="Instagram"
                  ><i class="fab fa-instagram" /></a>
                </li>
                <li>
                  <a
                    target="_blank"
                    :href="institute.linkedin_url ? institute.linkedin_url :'#'"
                    :disabled="institute.linkedin_url ? false:true"
                    :class="[icoLinkedin, institute.linkedin_url ? '' :'disabled']"
                    title="Linkedin"
                  ><i class="fab fa-linkedin" /></a>
                </li>
                <li>
                  <a
                    :href="institute.youtube_vedio_url ? institute.youtube_vedio_url : '#'"
                    :disabled="institute.youtube_vedio_url ? false:true"
                    :class="[icoYoutube, institute.youtube_vedio_url ? '' :'disabled']"
                    target="_blank"
                    title="Youtube"
                  ><i class="fab fa-youtube" /></a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </header>
   
    <div
      v-if="!AuthUser.preferred_institute_id"
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
    </div>
    
 
  
    <div
      v-if="AuthUser.preferred_institute_id"
      class="col-md-12 mt-3"
    >
      <nav-tabs
        :tabs="tabs"
        :initial-tab="initialTab"
      >
        <template slot="tab-heading-teachers">
          {{ 'Teachers' }}
        </template>
        <template slot="tab-panel-teachers">
          <div class="col-md-3 col-12 mb-2 mt-2">
            <social-sharing
              :url="
                AuthUser.full_name + ' has invited you to join '+ institute.name+' on Students Hub. click the link below to join now \n '+ baseUrl + '/get-started?inId=' + institute.id
              "
              inline-template
            >
              <div class="">
                <network network="whatsapp">
                  <button
                    type="button"
                    class="btn btn-success btn-lg "
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
                  <p>Invite your teachers to join StudentsHub..</p>
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
                v-for="(teacher,index) in teachers"
                :key="index"
                class="card mb-2"
              >
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="text-center">
                        <div style="text-align: -webkit-center">
                          <profile-image
                            :user-name="teacher.full_name"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-10">
                      <p class="mb-0 font-weight-bold text-black">
                        <a :href="'/profile/'+teacher.id"> {{ teacher.full_name }}</a>
                      </p>
                      <span class="font-weight-normal">
                        {{ teacher.preferred_course ? teacher.preferred_course.course_name : '' }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
        <template slot="tab-heading-students">
          {{ 'Students' }}
        </template>
        <template slot="tab-panel-students">
          <div class="col-md-3 col-12 mb-2 mt-2">
            <social-sharing
              :url="
                AuthUser.full_name + ' has invited you to join '+ institute.name+' on Students Hub. click the link below to join now \n '+ baseUrl + '/get-started?inId=' + institute.id
              "
              inline-template
            >
              <div class="">
                <network network="whatsapp">
                  <button
                    type="button"
                    class="btn btn-success btn-lg "
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
                  <p>Invite your friends to join Student's Hub.</p>
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
                v-for="(student,index) in students"
                :key="index"
                class="card mb-2"
              >
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="text-center">
                        <div style="text-align: -webkit-center">
                          <profile-image
                            :user-name="student.full_name"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-10">
                      <p class="mb-0 font-weight-bold text-black">
                        <a :href="'/profile/'+student.id"> {{ student.full_name }}</a>
                      </p>
                      <span class="font-weight-normal">
                        {{ student.preferred_course ? student.preferred_course.course_name : '' }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
        <template slot="tab-heading-about">
          {{ 'About' }}
        </template>
        <template slot="tab-panel-about">
          <div id="about-html" />
          <div class="col-md-10">
            <div class="card">
              <div class="card-body">
                <p>
                  thanks! Your account is created. <br>
                  Our team will soon contact you on phone for account verification.<br>
                  Once account verified you will be able to promote your institute to thousands of students.
                </p>
                <div
                  v-if="AuthUser.role==='instituteAdmin'"
                  class="col-md-10 col-sm-12"
                >
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
                              <label>Facebook Profile Url</label>
                              <input
                                v-model="institute.fb_url"
                                class="form-control"
                                type="text"
                                placeholder="http://facebook.com/profile-id"
                                @input="dataUpdated"
                              > <span class="text-danger">{{ errors.fb_url }}</span>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="model_input">
                              <label>Twitter Url</label>
                              <input
                                v-model="institute.twitter_url"
                                class="form-control"
                                type="text"
                                placeholder="http://twitter.com/profile-id"
                                @input="dataUpdated"
                              ><span class="text-danger">{{ errors.twitter_url }}</span>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="model_input">
                              <label>Instagram Username</label>
                              <input
                                v-model="institute.insta_url"
                                class="form-control"
                                type="text"
                                placeholder="http://instagram.com/profile-id"
                                @input="dataUpdated"
                              ><span class="text-danger">{{ errors.insta_url }}</span>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="model_input">
                              <label>Linkedin Profile Url</label>
                              <input
                                v-model="institute.linkedin_url"
                                class="form-control"
                                type="text"
                                placeholder="http://linked.com/profile-id"
                                @input="dataUpdated"
                              ><span class="text-danger">{{ errors.linkedin_url }}</span>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="model_input">
                              <label>Youtube Vedio Url</label>
                              <input
                                v-model="institute.youtube_vedio_url"
                                class="form-control"
                                type="text"
                                placeholder="http://youtube.com/profile-id"
                                @input="dataUpdated"
                              ><span class="text-danger">{{ errors.youtube_vedio_url }}</span>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
        <template slot="tab-heading-posts">
          {{ 'Posts' }}
        </template>
        <template slot="tab-panel-posts">
          <PostContainer
            v-if="AuthUser.preferred_institute_id"
            :post-route="'/institute/'+AuthUser.preferred_institute_id"
          >
            <template slot="empty">
              <img
                class="search-not-found"
                src="/images/search-not-found.png"
              >
              <p style="text-align:center;">
                Currently no post have been shared in your institute.
              </p>
            </template>
          </PostContainer>
        </template>
        <template slot="tab-heading-doubts">
          {{ 'Doubts' }}
        </template>
        <template slot="tab-panel-doubts">
          <DoubtContainer
            v-if="AuthUser.preferred_course_id"
            :doubt-route="'/course/'+AuthUser.preferred_course_id"
          >
            <template slot="empty">
              <img
                class="search-not-found"
                src="/images/search-not-found.png"
              >
              <p style="text-align:center;">
                Currently no doubt have been shared in your institute.
              </p>
            </template>
          </DoubtContainer>
        </template>
      </nav-tabs>
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
</template>
<script>
import NavTabs from '../../components/NavTabs';
import SelectInstitute from '../../components/SelectInstitute.vue';
import PostContainer from './post-container.vue';
import DoubtContainer from '@/Pages/doubt/doubt-container.vue';
import SocialSharing from 'vue-social-sharing';
import swal from '../../components/swal';


export default {
	components: {
		NavTabs, PostContainer, DoubtContainer, SelectInstitute, SocialSharing
	},
	data() {
		return {
			institute: '',
			teachers: [],
			students: [],
			posts: [],
			errors:{	
				fb_url: '',
				twitter_url:'',
				insta_url: '',
				linkedin_url: '',
				youtube_vedio_url: '',
			},
			
			initialTab: 'posts',
			tabs: ['posts', 'doubts','students','teachers'],
			showLoader: false,
			selected_institute : {
				'id': null,
				'name':'',
			},
      	data_updated:false,
		};
	},
	computed:{
		isCourseValid(){
			if(this.selected_institute && this.selected_institute.name){
				return true;
			}
			return false;
		}
	},
	mounted() {
    
    	this.initiateData();

		if(this.AuthUser.role==='instituteAdmin'){

			this.tabs.unshift('about');
			this.initialTab ='about';
		}
		let institute_id = this.AuthUser.preferred_institute_id;

		if(!institute_id) return false;
    
		this.axios
			.get('/api/institute/' + (institute_id ? institute_id : ''))
			.then(resp => {
				this.teachers = resp.data.success.teachers;
				this.institute = resp.data.success.institute;
				this.students = resp.data.success.students;
				this.posts = resp.data.success.posts.data;
				this.$forceUpdate();
			});
	},
	methods: {
		dataUpdated(){
			this.data_updated = true;
		},
    	initiateData(){
			if(this.institute){
			  this.institute = Object.assign({}, this.institute.profile);
			}else{
				this.institute= {
					fb_url: '',
					twitter_url:'',
					insta_url: '',
					linkedin_url: '',
					youtube_vedio_url: '',
				};
			}

		},
		discard(){
			this.initiateData();
			this.data_updated = false;
		},
		async saveProfile() {
			if(this.institute.fb_url && !this.institute.fb_url.includes('facebook.com')){
				this.errors.fb_url='This is not valid Facebook url.';
				return false;
			}
			if(this.institute.twitter_url &&!this.institute.twitter_url.includes('twitter.com')){
				this.errors.twitter_url='This is not valid Twitter url.';
				return false;
			}
			if(this.institute.insta_url && !this.institute.insta_url.match(/^[a-zA-Z0-9_.]*$/g)){
				this.errors.insta_url='This is not valid Instagram username.';
				return false;
			}
			if(this.institute.linkedin_url &&!this.institute.linkedin_url.includes('linkedin.com')){
				this.errors.linkedin_url='This is not valid Linkedin url.';
				return false;
			}
			if(this.institute.youtube_vedio_url &&!this.institute.youtube_vedio_url.includes('youtube.com')){
				this.errors.youtube_vedio_url='This is not valid Youtube url.';
				return false;
			}

			await this.axios.post('/api/save-institute-profile', Object.assign({
			},this.institute)
			).then((resp) => {
				this.setProfile(resp.data.success.profile);
				swal.successDialog('Profile Updated', 'Successfully!', 'success');
				this.data_updated = false;
			});

			this.errors={
				fb_url: '',
				twitter_url:'',
				insta_url: '',
				linkedin_url: '',
				youtube_vedio_url: '',
			};
		},
		setProfile(profile) {
			this.institute.fb_url = profile.fb_url ? profile.fb_url : '';
			this.institute.twitter_url = profile.twitter_url ? profile.twitter_url : '';
			this.institute.insta_url = profile.insta_url ? profile.insta_url : '';
			this.institute.linkedin_url = profile.linkedin_url ? profile.linkedin_url : '';
			this.institute.youtube_vedio_url = profile.youtube_vedio_url ? profile.youtube_vedio_url : '';
		},
		submitCourse(){
			this.axios
				.put('/api/preferred-details',{
					preferred_institute:this.selected_institute,
				})
				.then(resp => {
					window.location.reload();
				});
		}
	}
};
</script>
