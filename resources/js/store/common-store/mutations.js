export default {
    get_search_page_content(state,data){
      state.search_posts=data.posts.data;
    },
    get_posts(state,posts){
      state.dashboardPosts=state.dashboardPosts.concat(posts.data);
      state.current_page = posts.current_page;
    },
    increase_post_paginate_count(state){
      state.current_page=state.current_page+1;
    },
    get_post_content(state,data){
      state.postView.post_content = data.post_content;
      state.postView.most_viewed = data.most_viewed;
      state.postView.most_liked = data.most_liked;
      state.postView.latest = data.lates;
    },
  }