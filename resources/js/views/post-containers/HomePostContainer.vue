<template>
  <div>
    <div v-for="(post,index) in posts" :key="index">
      <div class="card mb-5">
        <div class="card-body">
          <div class="card-post">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-9">
                  <div class="d-flex">
                    <div class="avatar">
                      <profile-image :post="post" />
                    </div>
                    <div class="info-post ml-3">
                      <p class="username mb-0">{{post.user_name}}</p>
                      <p class="mb-0 date text-muted">{{post.institute_name}}</p>
                      <p class="mb-0 text-muted">{{post.category_name}}</p>
                      <p class="mb-1 text-muted">{{post.subject_name}}</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <p class="username mb-0">3 days ago</p>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <h3 class="card-title weight-600 text-black font-size-16">{{post.heading}}</h3>
            </div>
            <div class="col-md-12 mt-2">
              <div class="row">
                <div class="col-md-9">
                  <p>{{post.content}}</p>
                  <router-link :to="'/post/'+post.id" class="btn p-0 btn-link font-size-12">
                    Read Continue
                    <i class="fa fa-arrow-right"></i>
                  </router-link>
                </div>
                <div class="col-md-3">
                  <img class="card-img-top" v-lazy="post.image_path" alt="Card image cap" />
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-2">
                  <i class="fa fa-eye"></i>
                  <span class="badge-text">Views <span class="text-primary"> {{post.total_views}}</span></span>
                </div>
                <div class="col-md-2">
                  <i class="fa fa-thumbs-up"></i>
                  <span class="badge-text">Likes <span class="text-primary">{{post.total_likes}} </span></span>
                </div>
              </div>
            </div>
          </div>

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
