<template>
<section class="pt-100">
   <post-view-header></post-view-header>
<div class="container ptb-50">
    <div class="row">
        <div class="col-md-12 text-center">
            <h4 class="weight-400">{{postContent.subject_name}}</h4>
            <h2 class="weight-600">{{postContent.heading}}</h2>
            <div class="avatar mt-3 mb-2">
											<img v-lazy="'/images/4.jpg'" alt="..." class="avatar-img rounded-circle">
										</div>
										<div class="info-post ml-2">
											<h5 class="username weight-600">{{postContent.user_name}}  | <span class="date text-muted weight-400 text-light-gray1">{{postContent.created_at}}</span> </h5>
										</div>
        </div>
        </div>
        <div class="col-md-12">
<div class="row justify-center">
    <div class="col-md-1">
        <i class="far fa-comment-alt"></i>
        <span class="badge-text">200</span>
    </div>
    <div class="col-md-1">
        <i class="fas fa-eye"></i>
        <span class="badge-text">{{postContent.total_views}}</span>
    </div>
    <div class="col-md-1">
        <i class="fas fa-heart"></i>
        <span class="badge-text">{{postContent.total_likes}}</span>
    </div>
</div>
        </div>
    </div>
    <category-filter :categories="categories"></category-filter>
<div class="container ptb-50">
    <div class="col-md-10 col-10 center-col">
        <div class="row">
        <div class="col-md-9">
            <h3>{{postContent.heading}}</h3>
            <div v-if="postType==='article'">
                <div v-html="postContent.content"></div>
            </div>
            <div v-if="postType==='video'">
                <iframe width="620" height="315"
                    :src="postContent.content.link"></iframe>
                    <div>{{postContent.content.description}}</div>
            </div>
            <social-sharing url="https://vuejs.org/"
                      title="The Progressive JavaScript Framework"
                      description="Intuitive, Fast and Composable MVVM for building interactive interfaces."
                      quote="Vue is a progressive framework for building user interfaces."
                      hashtags="vuejs,javascript,framework"
                      twitter-user="vuejs"
                      inline-template>
  <div>
      <network network="email">
          <i class="fa fa-envelope"></i> Email
      </network>
      <network network="facebook">
        <i class="fa fa-facebook"></i> Facebook
      </network>
      <network network="googleplus">
        <i class="fa fa-google-plus"></i> Google +
      </network>
      <network network="line">
        <i class="fa fa-line"></i> Line
      </network>
      <network network="linkedin">
        <i class="fa fa-linkedin"></i> LinkedIn
      </network>
      <network network="odnoklassniki">
        <i class="fa fa-odnoklassniki"></i> Odnoklassniki
      </network>
      <network network="pinterest">
        <i class="fa fa-pinterest"></i> Pinterest
      </network>
      <network network="reddit">
        <i class="fa fa-reddit"></i> Reddit
      </network>
      <network network="skype">
        <i class="fa fa-skype"></i> Skype
      </network>
      <network network="sms">
        <i class="fa fa-commenting-o"></i> SMS
      </network>
      <network network="telegram">
        <i class="fa fa-telegram"></i> Telegram
      </network>
      <network network="twitter">
        <i class="fa fa-twitter"></i> Twitter
      </network>
      <network network="vk">
        <i class="fa fa-vk"></i> VKontakte
      </network>
      <network network="weibo">
        <i class="fa fa-weibo"></i> Weibo
      </network> 
      <network network="whatsapp">
        <i class="fa fa-whatsapp"></i> Whatsapp
      </network>
  </div>
</social-sharing>
            </div>
            <div class="col-md-3">
                <recent-post></recent-post>
            </div>
        </div>
    </div>

      </div>
    
<site-footer></site-footer>
</section> 
</template>
<style scoped>

</style>
<script>
import {mapState} from 'vuex';

import SocialSharing from 'vue-social-sharing';
import CategoryFilter from '../components/CategoryFilter';
import RecentPost from '../components/RecentPost';
import SiteFooter from '../components/SiteFooter';
import PostInteraction from '../components/PostInteraction';
import PostViewHeader from '../components/PostViewHeader';

export default {
    components: 
    {
        CategoryFilter, RecentPost, SiteFooter,PostInteraction,
        PostViewHeader,SocialSharing
    },
    computed:{
		...mapState({
			'categories': state=>state.explore.postView.categories,
			'postContent': state=>state.explore.postView.post_content,
			'relatedPost': state=>state.explore.postView.related_posts,
        }),
        postType(){
            return this.postContent.post_type ? this.postContent.post_type.toLowerCase() : '';
        }
	},
    mounted(){
        this.$store.dispatch('explore/getPostContent',this.$route.params.id).then(resp=>
            document.title = resp.data.success.post_content.heading
            );
    }
}
</script>
