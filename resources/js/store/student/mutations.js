import state from "./state";

export default {
    get_posts(state,posts){
      state.dashboardPosts=state.dashboardPosts.concat(posts.data);
      state.currrent_page = posts.currrent_page;
    },
    increase_post_paginate_count(){
      state.current_page=state.current_page+1;
    },
    get_categories(state,data){
      state.categories = data.categories;
      state.AuthUserCategory = data.AuthUserCategory;
      state.new_post.subject_list=data.categories;
    },
  get_post_content(state,data){
    state.postView.categories = data.categories;
    state.postView.related_posts = data.related_posts;
    state.postView.post_content = data.post_content;
    },
  }