<template>
    <div class="interaction">
                <div class="container">
                    <a href="#" :class="post.like===1 ?'like-active' : 'like'" @click="likefunction"><span class="circle_box"> <i class="fas fa-thumbs-up"></i> </span> Liked </a> |
                    <!-- <span>{{post.total_likes}}</span> -->
                <a href="#" :class="post.like===0 ?'like-active' : 'like'"><span class="circle_box"> <i class="fas fa-thumbs-down"></i> </span> Dislike </a>
                    <!-- <span>{{post.total_dislikes}}</span> -->
                <a href="#" class="like"><span class="circle_box"> <i class="fas fa-comment"></i> </span> Reviews </a>
        <div class="btn-group pull-right">
                    <button type="button" class="btn btn-link" data-toggle="dropdown"> 
                      <i class="fas fa-ellipsis-h font-size-18 text-black"></i>
                
                    </button>
                    <ul class="dropdown-menu p-2">
                        <li>Share</li>
                        <li>Report</li> 
                    </ul>
                </div>
        </div>
    </div>
</template>
<style scoped>
.circle_box
{

    border-radius:50%;
    margin: 2px 2px 0px 2px;
    padding: 8px 10px;
    background:#fff;
    border:1px solid #ccc;
}
.interaction{
    position: fixed;
    width: 100%;
	clear: both;
    bottom: 0;
    z-index: 999;
    padding: 15px 0px 10px 0px;
    left: 0;
    right: 0;
    margin: 0;
    /* ATTENTION! The following elements below 
    can be set to whatever your heart desires */
     /* REMEMBER height = padding-bottom */
    background: #fff;
    border-top:1px solid #ccc;
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
