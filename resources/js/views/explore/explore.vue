<template>
  <div class="category_list_page">
    <div class="container">
      <div class="row">
        <div class="col-md-3 center-col">
                <div class="category_part">
                    <div class="cat_head">
                        <h6>Subjects</h6>
                    </div> 
                      <div class="cat_list">
                          <p v-for="(subject,index) in subjects" :key="index"><a :href="'/subject/'+subject.url">{{subject.name}}</a></p>
                          
                    </div>     
                </div>
                </div>
                <div class="col-md-6">
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
                       <router-link :to="'/post/'+post.id" class="btn p-0 btn-link font-size-12" style="text-decoration: underline;"> Read Continue &nbsp;<i class="fa fa-arrow-right"></i>
                  </router-link>
                    </div>
                       <div class="col-md-3 col-4">
                  <img class="card-img-top" v-lazy="post.image_path" alt="Card image cap" />
                
                </div>
                 
                </div>
                                 
                <div class="dash_post_likes">
                <div class="post_like">
                  <i class="fa fa-eye"></i>
                  <span class="badge-text"> <span> {{post.total_views}}</span></span>
                </div>
                <div class="post_like">
                  <i class="fa fa-thumbs-up"></i>
                  <span class="badge-text"> <span>{{post.total_likes}} </span></span>
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
                <div class="col-md-3 center-col">
                <div class="category_part">
                    <div class="cat_head">
                        <h6>Courses</h6>
                    </div> 
                      <div class="cat_list">
                          <p v-for="(course,index) in courses" :key="index"><a :href="'/subject/'+course.url">{{course.name}}</a></p>
                          
                    </div>     
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
.category_list_page {
    padding: 130px 0;
}

/* catergorry list css */

.cat_head {
    border-bottom: solid 1px #ccc;
    padding: 0px 0 5px;
    margin-bottom: 20px;
}

.cat_list a {
    color: black;
    font-weight: 600;
}
.cat_list a:hover
{
    text-decoration: none;
}
.cat_list {
    margin-left: 25px;
}
.cat_list p {
    /* margin: 0; */
    position: relative;
}

.cat_list p:before {
    position: absolute;
    content: '';
     background-color: #F2F2F2;
    width: 15px;
    height: 15px;
    border-radius: 50px;
    left: -25px;
    border: solid 1px #ccc;
    top: 3px;
}

</style>

<script>
import { mapState } from "vuex";
import ProfileImage from "../post/ProfileImage.vue";

export default {
  props:['query'],
  computed: {
    ...mapState({
      posts: state => state.common.dashboardPosts
    }),
    courses(){
      return this.posts.map(node=>{
        let new_node={};
        new_node.url=node.course_id;
        new_node.name=node.course_name;
        return new_node;
      });
    },
    subjects(){
      return this.posts.map(node=>{
        let new_node={};
        new_node.url=node.subject_url;
        new_node.name=node.subject_name;
        return new_node;
      });
    }
  },
  components: {
    ProfileImage
  },
  mounted() {
    var route= this.$route.path;
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
  methods: {}
};
</script>
