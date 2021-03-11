<template>
  <section class="single_post">
    <div class="post_view_head back_btn ">
      <div class="back_bdtn ">
        <a
          class="btn btn-white btn-rounded btn-l"
          @click="$router.go(-1)"
        ><i class="fa fa-arrow-left" />
        </a>
      </div>
      <div 
        v-if="AuthUser"
        class="dropdown"
      >
        <button
          id="dropdownMenuButton"
          class="btn btn-white  dropdown-toggle"
          type="button"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >
          <i
            class="fa fa-ellipsis-v"
            aria-hidden="true"
          />
        </button>
        <div
          class="dropdown-menu"
          aria-labelledby="dropdownMenuButton"
        >
          <a
            class="dropdown-item"
            href="#"
            @click="postSave()"
          >Save</a>
          <a
            class="dropdown-item"
            href="#"
            @click="postReport()"
          >Report</a>
        </div>
      </div>
    </div>
    <div class="single_post_page">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="single_post_head">
              <h4 class="weight-400">
                {{ postContent.subject_name }}
              </h4>
              <h2 class="weight-600">
                {{ postContent.heading }}
              </h2>
            </div>

            <div class="info-post ml-2">
              <div class="user_img_singe">
                <profile-image :post="postContent" />
              </div>

              <h6 class="username weight-600">
                {{ postContent.user_name }} <span
                  class="date text-muted weight-400 text-light-gray1"
                >{{ postContent.created_at }}</span>
              </h6>
            </div>
          </div>
        </div>
        <div class="s_page_like">
          <div class="like_1">
            <i
              class="fa fa-thumbs-up"
              aria-hidden="true"
            />
            <span class="badge-text">{{ postContent.total_likes }}</span>
          </div>
          <div class="like_1">
            <i class="far fa-thumbs-down" />
            <span class="badge-text">{{ postContent.total_dislikes }}</span>
          </div>
          <div class="like_1">
            <i class="fas fa-eye" />
            <span class="badge-text">{{ postContent.total_views }}</span>
          </div>
        </div>
        <div class="social-network_singlepage">
          <h5 class="social_icon_text">
            Share
          </h5>
          <social-sharing
            :url="'http://www.studentshub.in/post/'+postContent.id"
            :title="postContent.heading"
            :description="postContent.heading"
            :quote="postContent.heading"
            :hashtags="postContent.category_name+', '+postContent.subject_name"
            twitter-user="studentshub"
            inline-template
          >
            <div class="post_content_social">
              <network network="facebook">
                <p class="post_content_social_icon">
                  <i class="fab fa-facebook-f" />
                </p>
              </network>
              <network network="twitter">
                <p><i class="fab fa-twitter" /> </p>
              </network>
              <network network="reddit">
                <p><i class="fab fa-reddit" /> </p>
              </network>
              <network network="email">
                <p><i class="fa fa-envelope" /></p>
              </network>
            </div>
          </social-sharing>
        </div>
      </div>
    </div>
    <div class="container ptb-50">
      <div class="col-md-12 col-12 center-col">
        <div class="row">
          <div class="col-md-8">
            <h3 class="post_main_title">
              {{ postContent.heading }}
            </h3>
            <div v-if="postContent.post_type==='video'">
              <div class="post_video">
                <iframe
                  width="620"
                  height="315"
                  :src="'https://www.youtube.com/embed/'+postContent.video_id"
                />
              </div>
            </div>

            <div v-if="postContent.post_type==='fact'">
              <div class="post_video">
                <img
                  width="620"
                  height="315"
                  :src="postContent.fact_image_path"
                >
              </div>
            </div>
            <div v-if="postContent.post_type==='article'">
              <div class="post_s_c">
                <div class="post_content">
                  <div v-html="postContent.article_content" />
                </div>
              </div>
            </div>
            <div 
              v-else
            >
              <div class="post_s_c">
                <div class="post_content">
                  <p>{{ postContent.description }}</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="bg-gray p-2 mb-2">
              <div class="row">
                <div class="col-md-12 latest-post">
                  <h6 class="card-title">
                    Popular Post
                  </h6>
                </div>
              </div>

              <div class="row">
                <div
                  v-for="(post,index) in most_viewed"
                  :key="index"
                  class="col-md-12"
                >
                  <div class="recent_card_post">
                    <h6 class="card-title-tag  font-size-12">
                      <a href="#">
                        {{ post.subject_name }}
                      </a>
                    </h6>
                    <h5 class="weight-600">
                      {{ post.heading }}
                    </h5>
                    <div class="d-flex">
                      <div class="recent_post_img">
                        <profile-image :post="post" />
                      </div>
                      <div class="info-post ml-2">
                        <p class="username">
                          {{ post.user_name }}
                        </p>
                        <p class="date text-muted">
                          {{ post.time }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      v-if="AuthUser"
      class="single_page_user_like"
    >
      <button
        :class="like_active===true ? 'like_active' : 'like_inactive'"
        @click="sendUserLike()"
      >
        <p><span><i class="fas fa-thumbs-up" /></span></p>
        <p>{{ like_active ? (postContent.total_likes + 1) : postContent.total_likes }}</p>
      </button>
      <button
        :class="dislike_active===true ? 'like_active' : 'like_inactive'"
        @click="sendUserDislike()"
      >
        <p>
          <span><i
            class="fa fa-thumbs-down"
            aria-hidden="true"
          /></span>
        </p>
        <p>{{ dislike_active ? (postContent.total_dislikes + 1) : postContent.total_dislikes }}</p>
      </button>
    </div>
    <div class="single_page_post_card">
      <div class="bg-gray s_p_c">
        <h3 class="post_like_head">
          You May Also Like
        </h3>
        <div class="container">
          <div class="row">
            <div
              v-for="(post,index) in most_liked"
              :key="index"
              class="col-md-4"
            >
              <div class="card-post">
                <img
                  alt="Card image cap"
                  class="card-img-top post_img_height"
                  :data-src="post.image_path"
                  :src="post.image_path"
                  lazy="loaded"
                >
                <div>
                  <div class=" mt-2">
                    <div class="post_name_date">
                      <div class="user_name">
                        <div />
                        <p class="username">
                          {{ post.user_name }}
                        </p>
                      </div>
                      <div class="info-post ml-2">
                        <p class="date text-muted">
                          {{ post.time }}
                        </p>
                      </div>
                    </div>
                  </div>
                  <h3 class="card-title mb-1 font-size-16">
                    <a
                      :href="'/post/'+post.id"
                      class="weight-600 text-black"
                    >
                      {{ post.heading }}
                    </a>
                  </h3>
                  <div class="separator-solid" />
                  <p class="card-text post_des">
                    {{ post.content }}
                  </p>
                  <div class="wel_view post_views_sec">
                    <div class="post_view">
                      <svg
                        class="svg-inline--fa fa-eye fa-w-18"
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="fa"
                        data-icon="eye"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 576 512"
                        data-fa-i2svg=""
                      >
                        <path
                          fill="currentColor"
                          d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"
                        />
                      </svg>
                      <!-- <i  class="fa fa-eye"></i> --><span
                        class="badge-text"
                      >{{ post.total_views }}</span>
                    </div>
                    <div class="post_view">
                      <svg
                        class="svg-inline--fa fa-thumbs-up fa-w-16"
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="fa"
                        data-icon="thumbs-up"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                        data-fa-i2svg=""
                      >
                        <path
                          fill="currentColor"
                          d="M104 224H24c-13.255 0-24 10.745-24 24v240c0 13.255 10.745 24 24 24h80c13.255 0 24-10.745 24-24V248c0-13.255-10.745-24-24-24zM64 472c-13.255 0-24-10.745-24-24s10.745-24 24-24 24 10.745 24 24-10.745 24-24 24zM384 81.452c0 42.416-25.97 66.208-33.277 94.548h101.723c33.397 0 59.397 27.746 59.553 58.098.084 17.938-7.546 37.249-19.439 49.197l-.11.11c9.836 23.337 8.237 56.037-9.308 79.469 8.681 25.895-.069 57.704-16.382 74.757 4.298 17.598 2.244 32.575-6.148 44.632C440.202 511.587 389.616 512 346.839 512l-2.845-.001c-48.287-.017-87.806-17.598-119.56-31.725-15.957-7.099-36.821-15.887-52.651-16.178-6.54-.12-11.783-5.457-11.783-11.998v-213.77c0-3.2 1.282-6.271 3.558-8.521 39.614-39.144 56.648-80.587 89.117-113.111 14.804-14.832 20.188-37.236 25.393-58.902C282.515 39.293 291.817 0 312 0c24 0 72 8 72 81.452z"
                        />
                      </svg>
                      <!-- <i  class="fa fa-thumbs-up"></i> --><span
                        class="badge-text"
                      >{{ post.total_likes }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <site-footer v-if="AuthUser===null" />
  </section>
</template>
<style scoped>
    .post_img {
        width: 100%;
    }

    .single_post_page .row {
        align-items: center;
    }

    .single_post_page {
        background-color: #f6f6f6;
        padding: 120px 0 80px;
        text-align: center;
    }

    section.single_post {
        padding: 65px 0;
    }



    .s_page_like {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 15px;
    }

    .like_1 {
        padding: 0px 10px;
        color: #868686;
    }

    .user_img_singe {
        margin-bottom: 15px;
            display: flex;
    justify-content: center;

    }

    .user_img_singe img {
        width: 50px;
        height: 50px;
        border-radius: 50px;
    }

    .post_video iframe {
        width: 100%;
    }

    .post_content {
        margin-top: 20px;
    }

    .post_content p {
        color: #868685;
        line-height: 27px;
        text-align: justify;
        position: relative;
        font-size: 20px;
    }

    .post_content p:before {
        position: absolute;
        content: '';
        background-color: black;
        height: 70px;
        width: 2px;
        left: -12px;
        top: 8px;
    }

    h3.post_main_title {
        /* font-size: 22px; */
        font-weight: 500;
        line-height: 34px;
        position: relative;
    }

    h3.post_main_title:before {
        position: absolute;
        content: '';
        /* background-color: red; */
        left: -36px;
        width: 15px;
        height: 15px;
        top: 16px;
        border: solid 1px #00c1d5;
    }

    h3.post_main_title:after {
        position: absolute;
        content: '';
        /* background-color: red; */
        left: -29px;
        width: 15px;
        height: 15px;
        top: 11px;
        border: solid 1px #00c1d5;

    }

    .post_like_head {
        text-align: center;
        margin-bottom: 20px;
    }


    .social_icon_text:before {
        position: absolute;
        content: '';
        background-color: #272727;
        width: 37px;
        height: 1px;
        right: -43px;
        bottom: 7px;
    }

    h5.social_icon_text {
        position: relative;
        font-weight: 500;
        color: #868686;
    }

    .recent_post_img img {
        width: 40px;
        height: 40px;
        border-radius: 50px;
    }

    h6.card-title {
        margin: 0;
        padding: 10px 9px 0;
        color: #868686;
    }

    h6.card-title-tag.font-size-12 a {
        color: #868686;
    }

    .recent_card_post {
        padding: 12px 10px 0;
    }

    .single_page_post_card .row .col-md-4 {
        display: flex;
    }

    .single_page_user_like {
        display: flex;
        justify-content: center;
    margin: 90px 0 40px;
    }

    .like_active p {
        margin: 0;
        color: blue;
        font-size: 18px;
    }

    .like_inactive p {
        margin: 0;
        color: #868686;
        font-size: 18px;
    }

        .single_page_user_like button:nth-child(1) {

        width: 100px;
        height: 100px;
        background-color: #f2f2f2;
        border-radius: 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
            border: none;
    }

    .single_page_user_like button:nth-child(2) {
        width: 100px;
        height: 100px;
        background-color: #f2f2f2;
        border-radius: 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin-left: 50px;
            border: none;
    }

    .post_view_head .dropdown-menu.show {
        display: block;
        left: -130px !important;
        transform: inherit !important;
        top: 37px !important;
    }

    .post_view_head .dropdown-menu {
        min-width: 10rem;
    }

    .post_view_head .dropdown-toggle::after {
        display: none;
    }
.bg-gray.s_p_c {
    padding: 50px 0;
}
@media only screen and (max-width: 600px) {
    
      section.single_post {
        padding: 0px 0;
    }

}
</style>
<script>
import {
	mapState
} from 'vuex';

import SocialSharing from 'vue-social-sharing';
import CategoryFilter from '../category/CategoryFilter';
import RecentPost from '../post/RecentPost';
import SiteFooter from '../footer/SiteFooter';
import PostInteraction from '../post/PostInteraction';
import PostViewHeader from '../post/PostViewHeader';
import ProfileImage from '../post/ProfileImage';
import swal from '../../components/swal';
import McqPostView from './McqPostView';
import TableRowVue from '../../components2/base/base-table/components/TableRow.vue';

export default {
	components: {
		CategoryFilter,
		RecentPost,
		SiteFooter,
		PostInteraction,
		PostViewHeader,
		SocialSharing,
		ProfileImage,
		McqPostView
	},
	props: ['role'],
	data() {
		return {
			user_like: '',
			post_save: '',
			post_report: '',
			like_active:false,
			dislike_active:false
		};
	},
	watch: {
		postContent(val) {
			if(val.user_like === 1){
				this.like_active = true;
			}
			else if(val.user_like === 0){
				this.dislike_active = true;
			}
			// this.user_like = this.postContent.user_like;
			this.post_save = this.postContent.post_save ? true : false;
			this.post_report = this.postContent.post_report ? true : false;
		}
	},
	computed: {
		...mapState({
			'postContent': state => state.common.postView.post_content,
			'most_viewed': state => state.common.postView.most_viewed,
			'most_liked': state => state.common.postView.most_liked,
		}),
	},
	mounted() {
		this.$store.dispatch('common/getPostContent', this.$route.params.id);
		window.scrollTo(0, 0);
	},
	methods: {
		sendUserLike() {
			let method = (this.like_active === true) ? 'delete' : 'add';
			// this.user_like = this.user_like === 1 ? null : 1;
			this.axios.post('/api/post-like', {
				post_id: this.postContent.id,
				type: 'like',
				method,
			}).then(resp => {
				this.like_active = resp.data.success.user_like===1 ? true : false;
				this.dislike_active = false;
			});
		},
		sendUserDislike() {
			let method = (this.dislike_active === true) ? 'delete' : 'add';
			// this.user_like = this.user_like === 0 ? null : 0;
			this.axios.post('/api/post-like', {
				post_id: this.postContent.id,
				type: 'dislike',
				method,
			}).then(resp => {
				this.dislike_active = resp.data.success.user_like===0 ? true : false;
				this.like_active = false;
			});
		},
		postSave() {
			this.post_save = this.post_save ? false : true;
			this.axios.post('/api/post-save', {
				post_id: this.postContent.id,
			}).then(resp => {
				swal.successDialog('Post Saved', 'Succesfully!', 'success');
				this.post_save = resp.data.success.post_save;
			});
		},
		postReport() {
			this.post_report = this.post_report ? false : true;
			this.axios.post('/api/post-report', {
				post_id: this.postContent.id,
			}).then(resp => {
				swal.successDialog('Post Reported', 'Succesfully!', 'success');
				this.post_report = resp.data.success.post_report;
			});
		}
	}

};

</script>
