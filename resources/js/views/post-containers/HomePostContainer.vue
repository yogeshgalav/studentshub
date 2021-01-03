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
                  <div class="row mb-1 mt-1">
                    <hr>
                    <div class="col-md-3 col-4" v-if="post.image_path">
                  <img class="card-img-top" v-lazy="post.image_path" alt="Card image cap" />
                
                </div>  
                    <div class="col-md-9 col-8" @click="setPostView(post)">
                      <div class="dash_board_title">
                          <h3 class="card-title weight-600 text-black">{{post.heading}}</h3>
                      </div> 
                      <p class="dash_post_content">{{post.content}}</p>
                       <router-link :to="'/post/'+post.id" class="btn p-0 btn-link font-size-12" style="text-decoration: underline;"> Read Continue &nbsp;<i class="fa fa-arrow-right"></i>
                  </router-link>
                    </div>
                 <hr>
                </div>
                                 
                <div class="dash_post_likes">
                <div class="post_like">
                  <i class="fa fa-eye"></i>
                  <span class="badge-text"> <span> {{post.total_views}} Views</span></span>
                </div>
                <div class="post_like">
                  <i class="fa fa-thumbs-up"></i>
                  <span class="badge-text"> <span>{{post.total_likes}} Likes</span></span>
                </div>
                <div class="post_like">
                  <i class="fa fa-thumbs-down"></i>
                  <span class="badge-text"> <span>{{post.total_dislikes}} Dislikes</span></span>
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
a.btn.p-0.btn-link.font-size-12 {
    display: flex;
    align-items: center;
    margin: 4px 0;
}

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
    var route= '/get-posts';
    var params='';
    if(this.$route.name==='search'){
        params='query='+this.$route.query.query;
    }
    this.showLoader = true;
    this.$store.dispatch("common/getDashboardPosts",{route:route,params:params}).then(() => {
      this.showLoader = true;
    });
    window.addEventListener("scroll", () => {
      if (this.bottomVisible()) {
        this.showLoader = true;
        this.$store.dispatch("common/getDashboardPosts",{route:route,params:params}).then(() => {
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
  methods: {
    setPostView(post){
      document.title = post.heading;
      this.$store.commit("common/set_post_initial",post);
    },
  }
};
</script>
