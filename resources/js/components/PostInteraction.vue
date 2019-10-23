<template>
    <div class="interaction">
                <div class="container">
                    <div class="display_flex" >
                        <a href="#" :class="post.like===1 ?'like-active' : 'like'" @click="likefunction"><div class="circle_box"> 
                            <i class="fas fa-thumbs-up"></i>
                            <h4>345</h4>
                         </div>  </a>
                        <a href="#" :class="post.like===0 ?'like-active' : 'like'">
                            <div class="circle_box"> <i class="fas fa-thumbs-down"></i> 
                        <h4>215</h4>
                    
                        </div>
                         </a>
                    <!-- <span>{{post.total_likes}}</span> -->
                
                    <!-- <span>{{post.total_dislikes}}</span> -->
                <!-- <a href="#" class="like"><span class="circle_box"> <i class="fas fa-comment"></i> </span> Reviews </a>
        <div class="btn-group pull-right">
                    <button type="button" class="btn btn-link" data-toggle="dropdown"> 
                      <i class="fas fa-ellipsis-h font-size-18 text-black"></i>
                
                    </button>
                    <ul class="dropdown-menu p-2">
                        <li>Share</li>
                        <li>Report</li> 
                    </ul> 
                </div>-->
        </div>
         </div>
    </div>
</template>
<style scoped>
.circle_box
{

    border-radius:50%;
    margin: 2px 20px 0px 2px;
    padding: 20px;
    background:#eee;
    width: 100px;
    height: 100px;
    text-align:center;
}
.circle_box i
{
    
    font-size:30px;

}
circle_box i, h4
{
    color: #333;
   

}
.circle_box:hover i, .circle_box:hover h4, .circle_box:focus h4, .circle_box:focus i
{
    color: #3746c5;
   
}
.display_flex
{
    display:flex;
    justify-content: center;
    margin-top:30px;

}

</style>
<script>
import {mapState} from 'vuex';

export default {
    computed:{
		...mapState({
			'post': state=>state.postView.post_content,
        }),
        isLiked(){
            return this.post.like===1 ? true : false
        },
        isDisiked(){
            return this.post.like===0 ? true : false
        },
	},
    methods:{
        likefunction(){
            let data={
                'post_id':this.post.id,
                'method':this.isLiked===true? 'delete' :'add', 
                'type':'like'
            };
                    this.$store.dispatch('addPostLike',data);
        },
        dislikefunction(){
            let data={
                'post_id':this.post.id,
                'method':this.isDisliked===true? 'delete' :'add', 
                'type':'dislike'
            };
                    this.$store.dispatch('addPostDislike',data);
        }
    }
}
</script>
