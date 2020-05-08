<template>
	<section class="pt-100">
		<post-view-header></post-view-header>
		<div class="contgainer single_post_page">
			<div class="row">
        <div class="col-md-6">
         <div class="avatar">
						<img v-lazy="'/images/4.jpg'" alt="..." class="avatar-img post_img">
					</div>
        </div>
        <div class="col-md-6">
          <div class="single_post_head">
              	<h4 class="weight-400">{{postContent.subject_name}}</h4>
				      	<h2 class="weight-600">{{postContent.heading}}</h2>
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
						<div v-if="postContent.post_type==='article'">
							<div v-html="postContent.article_content"></div>
						</div>
						<div v-if="postContent.post_type==='video'">
							<iframe width="620" height="315"
							:src="'https://www.youtube.com/embed/'+postContent.video_id"></iframe>
							<div>{{postContent.video_content}}</div>  
						</div>
						<social-sharing url="https://vuejs.org/"
						title="The Progressive JavaScript Framework"
						description="Intuitive, Fast and Composable MVVM for building interactive interfaces."
						quote="Vue is a progressive framework for building user interfaces."
						hashtags="vuejs,javascript,framework"
						twitter-user="vuejs"
						inline-template>
						<div>
							<network network="facebook">
								<i class="fa fa-facebook"></i> Facebook
							</network>
							<network network="twitter">
								<i class="fa fa-twitter"></i> Twitter
							</network>
							<network network="reddit">
								<i class="fa fa-reddit"></i> Reddit
							</network>
							<network network="email">
								<i class="fa fa-envelope"></i> Email
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
  .post_img{width:100%;}
.single_post_page .row {
    align-items: center;
}
</style>
<script>
	import {mapState} from 'vuex';

	import SocialSharing from 'vue-social-sharing';
	import CategoryFilter from '../category/CategoryFilter';
	import RecentPost from '../post/RecentPost';
	import SiteFooter from '../footer/SiteFooter';
	import PostInteraction from '../post/PostInteraction';
	import PostViewHeader from '../post/PostViewHeader';

	export default {
		components: 
		{
			CategoryFilter, RecentPost, SiteFooter,PostInteraction,
			PostViewHeader,SocialSharing
		},
		computed:{
			...mapState({
				'postContent': state=>state.common.postView.post_content,
				'most_viewed': state=>state.common.postView.most_viewed,
				'most_liked': state=>state.common.postView.most_liked,
				'latest': state=>state.common.postView.latest,
			}),
    },
    mounted(){
    	this.$store.dispatch('common/getPostContent',this.$route.params.id);
    }
}
</script>
