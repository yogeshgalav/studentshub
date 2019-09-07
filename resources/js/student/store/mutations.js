export default {
    create_post(state,post){
      state.new_post = Object.assign(state.new_post,post)
    },
    get_posts(state,posts){
      state.dashboardPosts = posts;
    },
    get_categories(state,categories){
      state.categories = categories;
    },
    get_subjects(state,subjects){
      state.subjects = subjects;
    },
    submitPost(state){
      axios({url: window.App.baseUrl+'/api/submit-post', data: state.new_post, method: 'POST' })
      .then(() => {

      })
      .catch(() => {
        
      })
  },
  get_post_content(state,data){
    state.postView.categories = data.categories;
    state.postView.related_posts = data.related_posts;
    state.postView.post_content = data.post_content;
    },
  }