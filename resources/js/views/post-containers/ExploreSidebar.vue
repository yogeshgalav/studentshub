<template>
<div>
    <div class="bg-gray p-3 mb-2">
        <div class="row">
    <div class="col-md-12 latest-post">
        <h3 class="card-title weight-800 text-black mb-2 border-bottom  pb-2">
            Popular Post
        </h3>
    </div>
</div>

    <div  class="row">
        <div class="col-md-12 mt-2 mb-2" v-for="(post,index) in posts" :key="index">
							<div class="card-post" @click="redirectPostView(post.id)">
							<div class="d-flex">
										
										<profile-image :post="post"/>
										
										<div class="info-post ml-2">
											<p class="username">{{post.user_name}}</p>
											<p class="date text-muted">{{post.created_at}}</p>
                                            <h3 class="card-title  font-size-12">
										<a href="#" class="text-black">
											{{post.heading}}
										</a>
									</h3>
                                
										</div>
									</div>
							</div>
						</div>         
                      
    </div>
    
    </div>
    <div class="bg-gray p-3 mb-3">
        <div class="row">
    <div class="col-md-12 latest-post">
        <h3 class="card-title weight-800 text-black mb-2 border-bottom  pb-2">
            Latest Post
        </h3>
    </div>
</div>

    <div  class="row">
        <div class="col-md-12 mt-2 mb-2" v-for="(post,index) in posts" :key="index">
							<div class="card-post">
							<div class="d-flex">
										<profile-image :post="post"/>
										<div class="info-post ml-2">
											<p class="username">{{post.user_name}}</p>
											<p class="date text-muted">{{post.created_at}}</p>
                                            <h3 class="card-title  font-size-12">
										<router-link :to="'/post/'+post.id"  class="text-black">
											{{post.heading}}
										</router-link>
									</h3>
                                
										</div>
									</div>
							</div>
						</div>
                           
    </div>
    
    </div>
    </div>
</template>
<style scoped>
.card-title, .username, .text-muted {
  font-family: 'Open Sans'  !important;
}
.bg-gray {
	background: #F7F7F7 !important;
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
			'posts': state=>state.guest.posts.ExploreSidebar,
		}),
	},
	methods:{
	}
}
</script>

