<template>
  <div>
    <div class="container pt-100">
      <div class="user_profile_page">
        <div class="row">
          <div class="col-md-8 center-col">
            <div class="row">
              <div class="col-md-3">
                <div class="user_profile_img">
                  <img
                    v-if="user.avatar_url"
                    :src="user.avatar_url"
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
              </div>
              <div class="col-md-9">
                <div class="user_des">
                  <h3 class="user_profile_name">
                    {{ user.full_name }} <a
                      v-if="user.id===AuthUser.id"
                      href="/account-settings"
                    ><i class="fas fa-edit" /></a>
                  </h3>
                  <p
                    v-if="user.role_intended==='student'"
                    class="text-grey"
                  >
                    Student at
                  </p>
                  <p
                    v-else-if="user.role_intended==='teacher'"
                    class="text-grey"
                  >
                    Teacher at
                  </p>
                  <p
                    v-else-if="user.role_intended==='institute_admin'"
                    class="text-grey"
                  >
                    Admin at
                  </p>
                  <p
                    v-if="user.preferred_institute_name"
                  >
                    {{ user.preferred_institute_name }}
                  </p>
                  <p
                    v-if="user.preferred_course_name"
                  >
                    {{ user.preferred_course_name }}
                  </p>
                </div>
                <div class="col-md-12 text-center mb-2 mt-2">
                  <ul class="social-network social-circle">
                    <li>
                      <a
                        target="_blank"
                        :href="user.insta_url ? ('https://instagram.com/'+user.insta_url) :'#'"
                        :disabled="user.insta_url ? false:true"
                        class="icoInstagram"
                        title="Instagram"
                      ><i class="fab fa-instagram" /></a>
                    </li>
                    <li>
                      <a
                        target="_blank"
                        :href="user.fb_url ? user.fb_url :'#'"
                        :disabled="user.fb_url ? false:true"
                        class="icoFacebook"
                        title="Facebook"
                      ><i class="fab fa-facebook-f" /></a>
                    </li>
                    <li>
                      <a
                        :href="user.linkedin_url ? user.linkedin_url :'#'"
                        :disabled="user.linkedin_url ? false:true"
                        target="_blank"
                        class="icoLinkedin"
                        title="Linkedin"
                      ><i class="fab fa-linkedin" /></a>
                    </li>
                    <li>
                      <a
                        target="_blank"
                        :href="user.email ? 'mailto:'+user.email :'#'"
                        :disabled="user.email ? false:true"
                        class="icoInstagram"
                        title="Email"
                      ><i class="fa fa-envelope" /></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

        <nav-tabs
          :tabs="tabs"
          :initial-tab="initialTab"
        >
          <template slot="tab-heading-posts">
            {{ 'Posts' }}
          </template>
          <template slot="tab-panel-posts">
            <div
              v-if="!posts.length"
              class="row"
            >
              <div class="col-md-5 center-col">
                <div class="sh_kn">
                  <img src="/images/noun_knowledge.svg">
                  <h4>Create your First Post.</h4>
                  <a href="/share-your-knowledge">Get Started</a>
                </div>
              </div>
            </div>
            <div
              v-else
              class="row"
            >
              <div class="col-md-10">
                <div
                  v-for="(post,index) in posts"
                  :key="index"
                >
                  <post-card :post="post" />
                </div>
              </div>
            </div>
          </template>
          <template slot="tab-heading-interests">
            {{ 'Interests' }}
          </template>
          <template slot="tab-panel-interests">
            <div
              v-if="!posts.length"
              class="row"
            >
              <div class="col-md-5 center-col">
                <div class="sh_kn">
                  <img src="/images/noun_knowledge.svg">
                  <h4>Want to find your Interest?</h4>
                  <a href="/share-your-knowledge">Get Started</a>
                </div>
              </div>
            </div>
            <div v-else>
              <h4>Your Interest</h4>
              <div class="">
                <div class="">
                  <p v-show="user.id===AuthUser.id">
                    This data is generated by your interaction with posts,hence the more you interect with
                    posts the more
                    precise this data is.
                  </p>

                  <div class="row">
                    <div class="col-md-10 col-sm-12">
                      <div
                        v-for="(interest,index) in interests"
                        :key="index"
                        class="interest card mb-2"
                      >
                        <div class="row">
                          <div class="text-center col-md-4">
                            <p class="font-size-60 weight-600 text-blue percentage">
                              {{ interest.percent }}%
                            </p>
                          </div>
                          <div class="col-md-7 mt-2 mb-1">
                            <p class="font-size-24 weight-400">
                              {{ interest.name }}
                            </p>
                            <p class="text-grey action-section">
                              <span>
                                <i
                                  class="fa fa-thumbs-up"
                                  aria-hidden="true"
                                />{{ interest.total_likes }} Like
                              </span>
                              <span> <i class="fas fa-eye" />{{ interest.total_views }} Views </span>
                              <span> <i class="fas fa-share" />{{ interest.total_posts }} Share </span>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </template>
        </nav-tabs>
      </div>
    </div>
  </div>
</template>
<style>
.percentage {
    border-right: 1px solid black;
}
.interest .card {
    padding: 20px 10px;
}
.interest .row {
    display: flex;
    align-items: center;
    justify-content: space-evenly;
}
.action-section span {
    margin: 0px 5px;
}
.action-section svg {
    margin-right: 2px;
}
@media only screen and (max-width: 1200px) {
    .percentage {
        border-right: none !important;                   
    }
    .interest p {
        text-align: center !important;
    }
}

h3.user_profile_name span {
    font-size: 14px;
    color: #868686;
    cursor: pointer;
}

h3.user_profile_name {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
button.save_profile_btn {
    border: navajowhite;
    background-color: blue;
    color: white;
    padding: 10px 40px;
    border-radius: 5px;
    margin-top: 10px;
    margin-bottom: 10px;
    font-weight: 500;
    font-size: 16px;
}
button.cancel_profile_btn {
    border: solid 1px #737171;
    background-color: transparent;
    color: black;
    padding: 10px 40px;
    border-radius: 5px;
    margin-top: 10px;
    margin-bottom: 10px;
    font-weight: 500;
    font-size: 16px;
    margin-left: 15px
}
.u_e_img img {
    width: 80px;
    height: 80px;
    border-radius: 50px;
        margin-right: 15px;
}
.user_edit_profile_img {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}
.user_edit_btn button {
    background-color: blue;
    border: none;
    color: white;
    padding: 5px 8px;
    font-size: 13px;
    border-radius: 5px;
}

.user_edit_btn {
    margin-left: 20px;
}
.user_social_link_left a {
    color: #868686;
}
.edit_profile_head {
    margin-bottom: 20px;
    border-bottom: solid 1px #ccc;
    margin-top: 10px;
}
.v--modal-box.v--modal {
    top: 130px !important;
}
.edit_img_btn {
    /* border: solid 1px #ccc; */
    padding: 8px;
    border-radius: 4px;
    background: #f0f0f0;
    cursor: pointer;
}
.sh_kn {
    margin-top: 30px;
    background: #F4F4F4 ;
    text-align: center;
    padding: 40px;
    box-shadow: 0 0 10px rgba(0,0,0,0.12);
    border-radius: 4px;
}
.sh_kn a {
    border: solid 1px #3746C5;
    padding: 10px 30px;
    margin-top: 8px;
    display: inline-block;
    border-radius: 1px;
}

.sh_kn h4 {
    color: black;
    margin: 20px 0;
}
</style>
<script>
import RadialProgressBar from 'vue-radial-progress';
import NavTabs from '../../components/NavTabs.vue';
import AnimateNumber from './animate-number.vue';
import PostCard from '../post/PostCard.vue';

export default {
	components: {
		NavTabs, PostCard
	},
	props: ['user'],
	data() {
		return {
			interests: [],
			posts: [],
			initialTab:'interests',
			tabs:['interests','posts'],
			interest_enable: false,
			image:'',
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
		};

	},
	watch: {
		user(val) {
			this.setProfile(val);
		}
	},
	mounted() {
		this.axios.get('/api/get-profile').then((resp) => {
			this.posts = resp.data.success.posts.data;

			let total = 0;
			this.interests = resp.data.success.interests.map(node=>{
				node.total=node.total_views+(node.total_likes*3)+(node.total_posts*7);
				total += node.total;
				return node;
			}).map(node=>{
				node.percent=total>0 ? parseInt((node.total/total)*100) : 0;
				return node;
			})
				.sort((a,b)=>a.percent>b.percent ? -1 : 1);

			setTimeout(()=>{ this.interest_enable=true; }, 1000);
		});
	},
};

</script>