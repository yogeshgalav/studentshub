<template>
  <div>
    <div v-for="(post,index) in posts" :key="index">
      <div class="dash_card card mb-2">
        <div class="card_post">
          <div class="card_box">
            <div class="cat_sub_name">
                       <p class="mb-0 text-muted">{{post.category_name}}</p>
                       <p class="mb-1 text-muted">{{post.subject_name}}</p>
            </div>

              <div class="dashboard_post">
                  <div class="avatar">
                      <profile-image :post="post" />
                    </div>
                    <div class="info-post ml-2 dash_insititue_name">
                      
                      <p class="usernamedash mb-0 dash_user_date">  {{post.user_name}}  <span>  3 days ago</span></p>
                      <p class="usernamedash mb-0">{{post.institute_name}}</p>

                    </div>   
              </div> 
              <div class="dash_board_title">
                  <h3 class="card-title weight-600 text-black">{{post.heading}}</h3>
                  <!-- <h3 class="card-title weight-600 text-black">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit adipisci velit adipisci velit</h3> -->
              </div>     
                  <div class="row">
                    <div class="col-md-9 col-8">
                      <p class="dash_post_content">{{post.content}}</p>
                      <!-- <p class="dash_post_content">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p> -->
                       <router-link :to="'/post/'+post.id" class="btn p-0 btn-link font-size-12" style="text-decoration: underline;"> Read Continue<i class="fab fa-arrow-right"></i>
                  </router-link>
                    </div>
                    <div class="col-md-3 col-4">
                  <img class="card-img-top" v-lazy="post.image_path" alt="Card image cap" />
                
                </div>  
                 
                </div>
                                 
                <div class="dash_post_likes">
                <div class="post_like">
                  <i class="fab fa-eye"></i>
                  <span class="badge-text">Views <span class="text-primary"> {{post.total_views}}</span></span>
                </div>
                <div class="post_like">
                  <i class="fab fa-thumbs-up"></i>
                  <span class="badge-text">Likes <span class="text-primary">{{post.total_likes}} </span></span>
                </div>
              </div>
                </div>
                <!-- <div class="col-md-3">
                  <p class="username mb-0">3 days ago</p>
                </div> -->
                


          <div class="card border-0">
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
  </div>
</template>
<style  scoped>


</style>

<script>
import { mapState } from "vuex";
import ProfileImage from "../post/ProfileImage.vue";

export default {
  computed: {
    ...mapState({
      posts: state => state.common.dashboardPosts
    })
  },
  components: {
    ProfileImage
  },
  mounted() {
    this.showLoader = true;
    this.$store.dispatch("common/getDashboardPosts").then(() => {
      this.showLoader = true;
    });
    window.addEventListener("scroll", () => {
      if (this.bottomVisible()) {
        this.showLoader = true;
        this.$store.dispatch("common/getDashboardPosts").then(() => {
          this.showLoader = true;
        });
      }
    });
  },
  data() {
    return {
      showLoader: false
    };
  },
  methods: {}
};
</script>
