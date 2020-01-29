export default {
  get_explore_page_content(state,data){
      state.categories = data.categories;
      state.posts.ExploreCarousalPost = data.ExploreCarousalPost;
      state.posts.ExploreTopPost = data.ExploreTopPost;
      state.posts.HomePostContainer = data.HomePostContainer;
      state.posts.ExploreSidebar = data.ExploreSidebar;
      state.posts.ExploreBottomPost = data.ExploreBottomPost;
    },
    get_post_content(state,data){
      state.postView.categories = data.categories;
      state.postView.related_posts = data.related_posts;
      state.postView.post_content = data.post_content;
      },
    // submitPost(state){
    //   axios({url: window.App.baseUrl+'/api/submit-post', data: state.new_post, method: 'POST' })
    //   .then(() => {

    //   })
    //   .catch(() => {
        
    //   })
  // },
  }