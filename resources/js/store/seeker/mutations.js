export default {
    add_post_like(state,post_id){
      state.dashboardPosts.map(node=>{
        if(node.id===post_id){
          node.total_likes=node.total_likes+1
        };
        return node;
      });
    },
    add_post_dislike(state,post_id){
      state.dashboardPosts.map(node=>{
        if(node.id===post_id){
          node.total_likes=node.total_likes+1
        };
        return node;
      });
    },
}