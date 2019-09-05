<template>
<div>
    <div class="bg-gray p-2 mb-2">
        <div class="row">
    <div class="col-md-12 latest-post">
        <h2 class="card-title weight-800 text-black mb-2 border-bottom  pb-2">
            Popular Post
        </h2>
    </div>
</div>

    <div  class="row">
        <div class="col-md-12 mt-2 mb-2">
							<div class="card-post">
                                <h3>Rolling hills and natural beauty goes here </h3>
							<div class="d-flex">
										<div class="avatar">
											<img src="/images/4.jpg" alt="..." class="avatar-img rounded-circle">
										</div>
										<div class="info-post ml-2">
											<p class="username">Dowyan Jhonson</p>
											<p class="date text-muted">5th july 2019</p>
                                            <h3 class="card-title  font-size-12">
										<a href="#" class="text-black">
											Tag1 
										</a>
									</h3>
                                
										</div>
									</div>
							</div>
						</div>         
                      
    </div>
    
    </div>
    <div class="bg-gray p-2 mb-3">
        <div class="row">
    <div class="col-md-12 latest-post">
        <h2 class="card-title weight-800 text-black mb-2 border-bottom  pb-2">
            Recent Post
        </h2>
    </div>
</div>

    <div  class="row">
        <div class="col-md-12 mt-2 mb-2" v-for="post in posts" :key="post.id">
							<div class="card-post">
							<div class="d-flex">
										<div class="avatar">
											<img src="/images/4.jpg" alt="..." class="avatar-img rounded-circle">
										</div>
										<div class="info-post ml-2">
											<p class="username">{{post.user_name}}</p>
											<p class="date text-muted">{{post.created_at}}</p>
                                            <h3 class="card-title  font-size-12">
										<a href="#" class="text-black">
											Best Design Resources This Week
										</a>
									</h3>
                                
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
			'posts': state=>state.explore.posts.ExploreSidebar,
		}),
	},
	methods:{
		redirectPostView(post_id){
                this.$router.push({path:'/post/1'})
            }
	}
}
</script>

