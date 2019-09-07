<template>
    <div class="interaction">
                <div class="container">
                    <a href="#" :class="like===1 ?'like-active' : 'like'"><span class="circle_box"> <i class="fas fa-thumbs-up"></i> </span> Liked </a> |
                <a href="#" :class="like===0 ?'like-active' : 'like'"><span class="circle_box"> <i class="fas fa-thumbs-down"></i> </span> Dislike </a>
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
	padding: 15px 0px 10px 0px;
    margin: 0;
    /* ATTENTION! The following elements below 
    can be set to whatever your heart desires */
     /* REMEMBER height = padding-bottom */
    background: #fff;
    border-top:1px solid #ccc;
}
</style>
<script>
export default {
    props:['like','total_likes','total_dislikes','total_views']
}
</script>
