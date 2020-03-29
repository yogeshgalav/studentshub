<template>
    <div class="ptb-50">
        <div class="row">
        <div class="col-md-4" v-for="post in posts" :key="post.id">
							<div class="card-post">
								<img class="card-img-top" v-lazy="post.image_path" alt="Card image cap">
								<div>
									<div class="d-flex mt-2">
										<profile-image :post="post"/>
										<div class="info-post ml-2">
											<p class="username">{{post.user_name}}</p>
											<p class="date text-muted">{{post.created_at}}</p>
										</div>
									</div>
									<div class="separator-solid"></div>
									<p class="card-category text-info mb-1"><a href="#">{{post.Subject_name}}</a></p>
									<h3 class="card-title  font-size-16">
										<router-link :to="'/post/'+post.id"  class="weight-600 text-black">
											{{post.heading}}
										</router-link>
									</h3>
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
.card-text, .card-title, .card-post p
{
	font-family: 'Open Sans'  !important;
}
</style>
<script>
export default {
    
}
</script>
<script>
import {mapState} from 'vuex';
import ProfileImage from '../post/ProfileImage.vue';

export default {
	components:{
		ProfileImage
	},
	computed:{
		...mapState({
			'posts': state=>state.guest.posts.ExploreTopPost,
		}),
	},
	methods:{
	}
}
</script>
