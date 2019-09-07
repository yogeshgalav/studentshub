<template>
    <div class="interaction">
                <a href="#" :class="like===1 ?'like-active' : 'like'"><i class="fas fa-thumbs-up"></i>Liked</a> |
                <a href="#" :class="like===0 ?'like-active' : 'like'"><i class="fas fa-thumbs-down"></i>Dislike</a>
                <a href="#" class="like"><i class="fas fa-comment"></i>Reviews</a>
        <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> 
                        <i class="glyphicon glyphicon-share"></i> 
                        <span class="caret"></span> 
                    </button>
                    <ul class="dropdown-menu">
                        <li>Share</li>
                        <li>Report</li>
                    </ul>
        </div>
    </div>
</template>
<script>
export default {
    props:['like','total_likes','total_dislikes','total_views']
}
</script>
