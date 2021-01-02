<template>
  <div>
    <div class="row">
      <div
        v-if="posts.length===0"
        class="col-md-9"
      >
        <h3>Oops! we couldn't found any posts related to your search.</h3> 
      </div>
    </div>
    <div
      v-for="(post,index) in posts"
      :key="index"
    >
      <div class="dash_card card">
        <div class="card_post">
          <div
            class="card_box"
            @click="redirectPostView(post)"
          >
            <div class="cat_sub_name">
              <p class="mb-0 text-muted">
                {{ post.category_name }}
              </p>
              <p class="mb-1 text-muted">
                {{ post.subject_name }}
              </p>
            </div>
            <div class="dashboard_post">
              <div class="avatar">
                <profile-image :post="post" />
              </div>
              <div class="info-post ml-2 dash_insititue_name">
                <p class="usernamedash mb-0 dash_user_date">
                  {{ post.user_name }}  <span>  3 days ago</span>
                </p>
                <p class="usernamedash mb-0">
                  {{ post.institute_name }}
                </p>
              </div>   
            </div> 
            <div class="dash_board_title">
              <h3 class="card-title weight-600 text-black">
                {{ post.heading }}
              </h3>
              <!-- <h3 class="card-title weight-600 text-black">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit adipisci velit adipisci velit</h3> -->
            </div>

            <div class="row">
              <div class="col-md-9 col-8">
                <p class="dash_post_content">
                  {{ post.content }}
                </p>
                <!-- <p class="dash_post_content">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p> -->
                <router-link
                  :to="'/post/'+post.id"
                  class="btn p-0 btn-link font-size-12"
                  style="text-decoration: underline;"
                >
                  Read Continue<i class="fab fa-arrow-right" />
                </router-link>
              </div>
              <div class="col-md-3 col-4">
                <img
                  v-lazy="post.image_path"
                  class="card-img-top"
                  alt="Card image cap"
                >
              </div>
            </div>
            <div class="dash_post_likes">
              <div class="post_like">
                <i class="fab fa-eye" />
                <span class="badge-text">Views <span class="text-primary"> {{ post.total_views }}</span></span>
              </div>
              <div class="post_like">
                <i class="fab fa-thumbs-up" />
                <span class="badge-text">Likes <span class="text-primary">{{ post.total_likes }} </span></span>
              </div>
            </div>

            <!-- <div class="card-post" @click="redirectPostView(post)">
								<div>
									<div class="d-flex mt-2">
										<div class="avatar">
										<profile-image :post="post"/>
										</div>
										<div class="info-post ml-2">
											<p class="username">{{post.user_name}}</p>
											<p class="date text-muted">{{post.institute_name}}</p>
											<h5>{{post.category_name}}</h5><br/>
											<h5>{{post.subject_name}}</h5><br/>
                                            <h3 class="card-title  font-size-16">
										<p  class="weight-600 text-black">
											{{post.heading}}
										</p>
									</h3>
									<p>{{post.content}}<p><router-link :to="'/post/'+post.id" class="btn p-0 btn-link font-size-12">Read Continue <i class="fa fa-arrow-right"></i></router-link>
                                    <div class="row">
										<div class="col-md-4">
											<i class="fa fa-eye"></i>
											<span class="badge-text">{{post.total_views}}</span>
										</div>
										<div class="col-md-6">
											<i class="fa fa-thumbs-up"></i>
											<span class="badge-text">{{post.total_likes}}</span>
										</div>
									</div>
										</div>
									</div>

									
								
									

                                   
								</div>
							</div> -->
          </div>
          <!-- <div class="col-md-3">
                            <img class="card-img-top" v-lazy="post.image_path" alt="Card image cap">
                        </div> -->
        </div>
        <div class="card">
          <loading 
            :active.sync="showLoader"
            :color="'#10069F'"
            :loader="'bars'"
            :width="250"
            :is-full-page="false"
          />
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.card-post h3 {
	margin-bottom:1px;
	font-size:14px !important;
}
.card-post h5 {
	font-size:12px !important;
	font-weight: 400;
	margin-bottom:10px !important;
}
.text-muted {
    color: #6c757d !important;
}
</style>
<script>

import {mapState} from 'vuex';
import ProfileImage from '../post/ProfileImage.vue';

export default {
	computed:{
		...mapState({
			'posts': state=>state.common.search_posts,
		}),
	},
	components:{
		ProfileImage
	},
	data(){
		return {
			showLoader:false,
		};
	},
	methods:{
	}
};
</script>
