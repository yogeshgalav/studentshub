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
                    :src="postContent.content.video_link"></iframe>
                    <div>{{postContent.content.video_description}}</div>
            </div>
            </div>
            <div class="col-md-3">
                <recent-post></recent-post>
                </div>
        </div><div class="row">
                    <div class="col-md-12 text-center">
                 <post-interaction></post-interaction>
                    </div>
        </div>
  
    </div>

      </div>
    
</section> 
</template>
<script>
import {mapState} from 'vuex';

import CategoryFilter from '../category/CategoryFilter';
import RecentPost from '../post/RecentPost';
import SiteFooter from '../footer/SiteFooter';
import PostInteraction from '../post/PostInteraction';
import PostViewHeader from '../post/PostViewHeader';

export default {
    components: 
    {
        CategoryFilter, RecentPost, SiteFooter,PostInteraction, PostViewHeader
    },
    computed:{
		...mapState({
			'categories': state=>state.common.postView.categories,
			'postContent': state=>state.common.postView.post_content,
			'relatedPost': state=>state.common.postView.related_posts,
        }),
        postType(){
            return this.postContent.post_type ? this.postContent.post_type.toLowerCase() : '';
        }
	},
    mounted(){
        this.$store.dispatch('common/getPostContent',this.$route.params.id);
    }
}
</script>
