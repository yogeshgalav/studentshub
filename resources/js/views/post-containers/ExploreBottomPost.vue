<template>
    <div class="exolpre-bottom-post">
        <div class="row">
    <div class="col-md-12 text-center">
        <h3 class="card-title weight-800 text-black  mb-3">
            Latest Post
        </h3>
    </div>
</div>

  <div class="row">
        <div class="col-md-4" v-for="post in posts" :key="post.id">
							<div class="card-post">
								
								<div>

									<div class="d-flex mt-2">
										<profile-image :post="post"/>
										<div class="info-post ml-2">
											<p class="username">{{post.user_name}}</p>
											<p class="date text-muted">{{post.created_at}}</p>
										</div>
									</div>
                                    <h3 class="card-title  font-size-16">
										<router-link :to="'/post/'+post.id"  class="weight-600 text-black">
											{{post.heading}}
										</router-link>
									</h3>
									<div class="separator-solid"></div>
							
									
									<p class="card-text">{{post.content}}</p>
									<div class="row">
										<div class="col-md-2">
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
                        
                                   
						
    </div>
        </div>
</template>
<style scoped>
.card-post h3,h5,p, h6 {
	font-family: 'Open Sans'  !important;
}
.card-post h3 {
	margin-bottom:1px;
	font-size:14px !important;
}
.card-post h5 {
	font-size:12px !important;
	font-weight: 400;
	margin-bottom:10px !important;
}
</style>
<script>
import {mapState} from 'vuex';
import ProfileImage from '../post/ProfileImage.vue';

export default {
	components:{
		ProfileImage
	},
	computed:{
		...mapState({
			'posts': state=>state.guest.posts.ExploreBottomPost,
		}),
	},
	methods:{
	}
}
</script>
