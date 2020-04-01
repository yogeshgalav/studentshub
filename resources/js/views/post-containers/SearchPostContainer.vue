<template>
<div>
<div  class="row">
        <div class="col-md-9" v-if="posts.length===0">
			<h3>Oops! we couldn't found any posts related to your search.</h3> 
        </div>
</div>
<div v-for="(post,index) in posts" :key="index">
    <div class="card">
		<div  class="row">
        <div class="col-md-9">
							<div class="card-post" @click="redirectPostView(post)">
						<div>
									<div class="d-flex mt-2">
										<div class="avatar">
										<profile-image :post="post"/>
										</div>
										<div class="info-post ml-2">
											<p class="username">{{post.user_name}}</p>
											<p class="date text-muted">{{post.institute_name}}</p>
											<h5>{{post.category_name}}</h5><br/>
											<h5>{{post.subject_name}}</h5><br/>
                                            <h3 class="card-title  font-size-16">
										<p  class="weight-600 text-black">
											{{post.heading}}
										</p>
									</h3>
									<p>{{post.content}}<p><router-link :to="'/post/'+post.id" class="btn p-0 btn-link font-size-12">Read Continue <i class="fa fa-arrow-right"></i></router-link>
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
	<div class="card">
			<loading 
				:active.sync="showLoader"
				:color="'#10069F'"
				:loader="'bars'"
				:width="250"
				:is-full-page="false"
			/>
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
	computed:{
		...mapState({
			'posts': state=>state.common.search_posts,
		}),
	},
	components:{
		ProfileImage
	},
	data(){
		return {
			showLoader:false,
		};
	},
	methods:{
	}
}
</script>
