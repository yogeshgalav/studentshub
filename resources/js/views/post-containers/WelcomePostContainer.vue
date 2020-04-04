<template>
<div>

<div v-for="(post,index) in posts" :key="index">
    <div  class="row">
        <div class="col-md-9">
							<div class="card-post" @click="redirectPostView(post)">
						<div>
									<div class="d-flex mt-2">
										<profile-image :post="post"/>
										<div class="info-post ml-2">
											<p class="username mb-1">{{post.user_name}}</p>
											<p class="date text-muted mb-1">{{post.institute_name}}</p>
											<p class="mb-1">{{post.category_name}}</p>
											<p class="mb-1">{{post.subject_name}}</p>
                                            <h3 class="card-title  font-size-16">
										<router-link :to="'/post/'+post.id"  class="weight-600 text-black">
											{{post.heading}}
										</router-link>
									</h3>
									<h5 class="mb-1">{{post.content}}</h5>
										 <div class="row">
										<div class="col-md-4">
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
                        <div class="col-md-3">
                            <img class="card-img-top" v-lazy="post.image_path" alt="Card image cap">
                        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
<div class="divider"></div>
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
			'posts': state=>state.guest.posts.HomePostContainer,
		}),
	},
}
</script>
