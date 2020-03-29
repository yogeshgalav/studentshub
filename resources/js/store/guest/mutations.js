export default {
  get_welcome_page_content(state,data){
      state.categories = data.categories;
      state.posts.ExploreCarousalPost = data.ExploreCarousalPost;
      state.posts.ExploreTopPost = data.ExploreTopPost;
      state.posts.HomePostContainer = data.HomePostContainer;
      state.posts.ExploreSidebar = data.ExploreSidebar;
      state.posts.ExploreBottomPost = data.ExploreBottomPost;
    },
  }