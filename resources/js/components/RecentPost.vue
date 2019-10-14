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
        <div class="col-md-12 mb-2">
							<div class="card-post">
                                <h4 class="weight-600">Rolling hills and natural beauty goes here </h4>
							<div class="d-flex">
										<div class="avatar">
											<img v-lazy="'/images/4.jpg'" alt="..." class="avatar-img rounded-circle">
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
	}
}
</script>

