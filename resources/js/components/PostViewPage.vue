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
    <div class="row">
        <div class="col-md-9">
            <h3>{{postContent.heading}}</h3>
            <p>{{postContent.content}}</p>
            </div>
            <div class="col-md-3">
                <recent-post></recent-post>
                </div>
        </div><div class="row">
                 <post-interaction></post-interaction>
        </div>
    </div>
    
<site-footer></site-footer>
</section> 
</template>
<style scoped>

</style>
<script>
import {mapState} from 'vuex';

import CategoryFilter from '../components/CategoryFilter';
import RecentPost from '../components/RecentPost';
import SiteFooter from '../components/SiteFooter';
import PostInteraction from '../components/PostInteraction';
import PostViewHeader from '../components/PostViewHeader';

export default {
    components: 
    {
        CategoryFilter, RecentPost, SiteFooter,PostInteraction,
        PostViewHeader
    },
    computed:{
		...mapState({
			'categories': state=>state.explore.postView.categories,
			'postContent': state=>state.explore.postView.post_content,
			'relatedPost': state=>state.explore.postView.related_posts,
		}),
	},
    mounted(){
        this.$store.dispatch('explore/getPostContent',this.$route.params.id);
    }
}
</script>
