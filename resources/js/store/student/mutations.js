export default {
    get_posts(state,posts){
      state.dashboardPosts = posts;
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