<template>
<div>

<div v-for="post in posts" :key="post.id">
	<div class="card">
		<div  class="row">
			   <div class="col-md-3">
				   <div class="item">
					   <span class="badge">{{post.subject_name}}

					   </span>
					   <span class="badge_like p-1 font-size-12">
						   <i class="fa fa-thumbs-up text-black">
					   </i> {{post.total_views}} |  <i class="fa fa-thumbs-down text-black">
					   </i>  {{post.total_likes}}
					   </span>
                            <img class="card-img-top img-responsive" v-lazy="post.profile_image" alt="Card image cap">
							</div>
                        </div>
        <div class="col-md-9">
							<div class="card-post">
						<div>
									<div class="d-flex mt-2">
										<div class="info-post">
											<h3 class="card-title pl-0 font-size-16">
										<router-link :to="'/post/'+post.id"  class="weight-600 text-black">
											{{post.heading}}
										</router-link>
									</h3>
										<div class="ml-1">
												<span class="username font-size-12">{{post.user_name}}</span> / 
											<span class="date text-muted font-size-12">{{post.created_at}}</span>
                    <p class="mb-0">fdsgsgh gfjgf</p>
					<a href="#" class="btn p-0 btn-link font-size-12">Read Continue <i class="fa fa-arrow-right"></i></a>
										</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
                     
    </div>
		</div>
</div>
      
    </div>
   
</template>
<style scoped>
.mb-0 
{
	margin-bottom: 0 !important;
}
.item
{
	position:relative;
}
.badge
{
	 position: absolute;
    left:0px;
    top:0px;
	background: rgba(0, 0, 0, 0.6);
  color:#fff;
  border:0px;
  margin-top:2px;
  margin-left:1px;

}
.badge_like
{
	 position: absolute;
    right:0px;
    bottom:0px;
	background: rgba(255, 255, 255, 0.8);
  border:0px;

}
.btn-link i
{
	color: #090355;
}
.btn-link 
{
	text-transform: uppercase !important;
}
</style>

<script>

import {mapState} from 'vuex';
export default {
	mounted(){
<<<<<<< HEAD
=======
		this.$store.dispatch('getStudentPosts');
>>>>>>> f7e0c3403301472490746cc016fe63581e6d065c
		window.addEventListener('scroll', () => {
      		if(this.bottomVisible()){
				  this.$store.dispatch('getStudentPosts');
			  }
    	});
	},
	computed:{
		...mapState({
			'posts': state=>state.dashboardPosts,
		}),
	},     
	methods:{
	}
}
</script>
