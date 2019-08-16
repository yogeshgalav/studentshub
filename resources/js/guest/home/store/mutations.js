export default {
  get_explore_page_content(state,data){
      state.categories = data.categories;
      state.posts.Carousel = data.Carousel;
      state.posts.ExploreTopPost = data.ExploreTopPost;
      state.posts.HomePostContainer = data.HomePostContainer;
      state.posts.ExploreSidebar = data.ExploreSidebar;
      state.posts.ExploreBottomPost = data.ExploreBottomPost;
    },
    submitPost(state){
      axios({url: window.App.baseUrl+'/api/submit-post', data: state.new_post, method: 'POST' })
      .then(() => {

      })
      .catch(() => {
        
      })
  },
  }