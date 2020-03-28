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
								<profile-image :post="post"/>
								<div>

									<div class="d-flex mt-2">
										<div class="avatar">
											<img v-lazy="'/images/4.jpg'" alt="..." class="avatar-img rounded-circle">
										</div>
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

<script>
import {mapState} from 'vuex';
import ProfileImage from '../post/ProfileImage.vue';

export default {
	components:{
		ProfileImage
	},
	computed:{
		...mapState({
			'posts': state=>state.explore.posts.ExploreBottomPost,
		}),
	},
	methods:{
	}
}
</script>
