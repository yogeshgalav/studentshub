<template>
<section class="pt-100">
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-6 ">
            <button class="btn btn-white btn-rounded btn-lg fixed-back"><i class="fa fa-arrow-left"></i> Back </button>
            </div>
            <div class="col-md-6 text-right">
            <button class="btn btn-white btn-rounded btn-lg"><i class="fa fa-share-alt"></i>  </button>
            </div>
        </div></div>
<div class="container ptb-50">
    <div class="row">
        <div class="col-md-12 text-center">
            <h4 class="weight-400">{{postContent.subject_name}}</h4>
            <h2 class="weight-600">{{postContent.heading}}</h2>
            <div class="avatar mt-3 mb-2">
											<img src="/images/4.jpg" alt="..." class="avatar-img rounded-circle">
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
        </div>
    </div>
    <div class="container ptb-50">
    <div class="row">
        <div class="col-md-9">
           
            </div>
        </div>
    </div>
     <post-interaction></post-interaction>
</section> 
</template>
<style scoped>
.fixed-back
{
    top:13.6%;
    position: fixed;
}
</style>
<script>
import {mapState} from 'vuex';

import CategoryFilter from '../../../components/CategoryFilter';
import RecentPost from '../../../components/RecentPost';
import SiteFooter from '../../../components/SiteFooter';
import PostInteraction from '../../../components/PostInteraction';
export default {
    components: 
    {
        CategoryFilter, RecentPost, SiteFooter,PostInteraction
    },
    computed:{
		...mapState({
			'categories': state=>state.postView.categories,
			'postContent': state=>state.postView.post_content,
			'relatedPost': state=>state.postView.related_posts,
		}),
	},
    mounted(){
        this.$store.dispatch('getPostContent',this.$route.params.id);
    }
}
</script>
