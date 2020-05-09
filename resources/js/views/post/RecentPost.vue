<template>
<div>
    <div class="bg-gray p-2 mb-2">
        <div class="row">
    <div class="col-md-12 latest-post">
        <h6 class="card-title">
            Popular Post
        </h6>
    </div>
</div>

    <div  class="row">
        <div class="col-md-12">
							<div class="recent_card_post">
                                <h5 class="weight-600">Rolling hills and natural beauty goes here </h5>
							<div class="d-flex">
										<div class="recent_post_img">
											<img v-lazy="'/images/4.jpg'" alt="...">
										</div>
										<div class="info-post ml-2">
											<p class="username">Dowyan Jhonson</p>
											<p class="date text-muted">5th july 2019</p>
                                            
                                
										</div>
									</div>
									<h6 class="card-title-tag  font-size-12">
										<a href="#">
											Important Talk ,Natural Vista 
										</a>
									</h6>
							</div>
						</div>   
						<div class="col-md-12 mb-2">
							<div class="recent_card_post">
                                <h5 class="weight-600">Rolling hills and natural beauty goes here </h5>
							<div class="d-flex">
										<div class="recent_post_img">
											<img v-lazy="'/images/4.jpg'" alt="...">
										</div>
										<div class="info-post ml-2">
											<p class="username">Dowyan Jhonson</p>
											<p class="date text-muted">5th july 2019</p>
                                            
                                
										</div>
									</div>
									<h6 class="card-title-tag  font-size-12">
										<a href="#">
											Important Talk ,Natural Vista 
										</a>
									</h6>
							</div>
						</div>
						<div class="col-md-12 mb-2">
							<div class="recent_card_post">
                                <h5 class="weight-600">Rolling hills and natural beauty goes here </h5>
							<div class="d-flex">
										<div class="recent_post_img">
											<img v-lazy="'/images/4.jpg'" alt="...">
										</div>
										<div class="info-post ml-2">
											<p class="username">Dowyan Jhonson</p>
											<p class="date text-muted">5th july 2019</p>
                                            
                                
										</div>
									</div>
									<h6 class="card-title-tag  font-size-12">
										<a href="#">
											Important Talk ,Natural Vista 
										</a>
									</h6>
							</div>
						</div>
						<div class="col-md-12 mb-2">
							<div class="recent_card_post">
                                <h5 class="weight-600">Rolling hills and natural beauty goes here </h5>
							<div class="d-flex">
										<div class="recent_post_img">
											<img v-lazy="'/images/4.jpg'" alt="...">
										</div>
										<div class="info-post ml-2">
											<p class="username">Dowyan Jhonson</p>
											<p class="date text-muted">5th july 2019</p>
                                            
                                
										</div>
									</div>
									<h6 class="card-title-tag  font-size-12">
										<a href="#">
											Important Talk ,Natural Vista 
										</a>
									</h6>
							</div>
						</div> 

                      
    </div>
    
    </div>
    
    </div>
</template>
<style  scoped>
.recent_post_img img {
    width: 40px;
    height: 40px;
    border-radius: 50px;
}
h6.card-title {
    margin: 0;
    padding: 10px 9px 0;
    color: #868686;
}
h6.card-title-tag.font-size-12 a {
    color: #868686;
}
.recent_card_post {
    padding: 12px 10px 0;
}
</style>
<script>
import {mapState} from 'vuex';

export default {
	computed:{
		...mapState({
			'posts': state=>state.guest.posts.ExploreSidebar,
		}),
	},
	methods:{
	}
}
</script>

