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
								<img class="card-img-top" src="/images/4.jpg" alt="Card image cap">
								<div>
									<div class="d-flex mt-2">
										<div class="avatar">
											<img src="/images/4.jpg" alt="..." class="avatar-img rounded-circle">
										</div>
										<div class="info-post ml-2">
											<p class="username">{{post.post.user_name}}</p>
											<p class="date text-muted">{{post.post.created_at}}</p>
										</div>
									</div>
                                    <h3 class="card-title  font-size-16">
										<a href="#" class="weight-600 text-black">
											Best Design Resources This Week
										</a>
									</h3>
									<div class="separator-solid"></div>
							
									
									<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
									<div class="row">
										<div class="col-md-2">
											<i class="far fa-comment-alt"></i>
											<span class="badge-text">{{post.post.total_views}}</span>
										</div>
										<div class="col-md-6">
											<i class="fas fa-paperclip"></i>
											<span class="badge-text">{{post.post.total_likes}}</span>
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

export default {
	computed:{
		...mapState({
			'posts': state=>state.explore.posts.ExploreBottomPost,
		}),
	}
}
</script>
