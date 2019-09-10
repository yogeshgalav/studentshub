<template>
<div>

<div v-for="post in posts" :key="post.id">
    <div  class="row">
        <div class="col-md-9">
							<div class="card-post" @click="redirectPostView(post.id)">
						<div>
									<div class="d-flex mt-2">
										<div class="avatar">
											<img src="/images/4.jpg" alt="..." class="avatar-img rounded-circle">
										</div>
										<div class="info-post ml-2">
											<p class="username">{{post.user_name}}</p>
											<p class="date text-muted">{{post.created_at}}</p>
                                            <h3 class="card-title  font-size-16">
										<a href="#" class="weight-600 text-black">
											{{post.heading}}
										</a>
									</h3>
                                    <div class="row">
										<div class="col-md-2">
											<i class="far fa-comment-alt"></i>
											<span class="badge-text">{{post.total_views}}</span>
										</div>
										<div class="col-md-6">
											<i class="fas fa-paperclip"></i>
											<span class="badge-text">{{post.total_likes}}</span>
										</div>
									</div>
										</div>
									</div>

									
								
									

                                   
								</div>
							</div>
						</div>
                        <div class="col-md-3">
                            <img class="card-img-top" src="/images/blogpost.jpg" alt="Card image cap">
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
<script>
export default {
	props:['posts'],
	methods:{
		redirectPostView(post_id){
                this.$router.push({path:'/post/1'})
            }
	}
}
</script>
