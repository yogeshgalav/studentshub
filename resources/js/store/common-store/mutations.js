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
      state.postView.categories = data.categories;
      state.postView.related_posts = data.related_posts;
      state.postView.post_content = data.post_content;
      },
  }