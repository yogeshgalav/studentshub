<template>
<div>

<div v-for="(post,index) in posts" :key="index" v-scroll="scrollFn">
    <div  class="row">
        <div class="col-md-9">
							<div class="card-post" @click="redirectPostView(post)">
						<div>
									<div class="d-flex mt-2">
										<div class="avatar">
                            <img class="card-img-top img-responsive" v-lazy="post.profile_image" alt="Card image cap">
										</div>
										<div class="info-post ml-2">
											<p class="username">{{post.user_name}}</p>
											<p class="date text-muted">{{post.institute_name}}</p>
											<h5>{{post.category_name}}</h5><br/>
											<h5>{{post.subject_name}}</h5><br/>
                                            <h3 class="card-title  font-size-16">
										<router-link :to="'/post/'+post.id"  class="weight-600 text-black">
											{{post.heading}}
										</router-link>
									</h3>
									<p v-if="post.article_content">{{post.article_content}}<p>
									<p v-if="post.video_content">{{post.video_content}}<p>
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
<script>
import vuescroll from 'vue-scroll'

export default {
	components:{vuescroll},
	props:['posts'],
	methods:{
		scrollFn(){
			this.$emit('loadPosts');
		}
	}
}
</script>
