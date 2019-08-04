export default {
    create_post(state,post){
      state.new_post = Object.assign(state.new_post,post)
    },
    get_posts(state,posts){
      state.posts = posts;
    },
    submitPost(state){
      axios({url: window.App.baseUrl+'/api/submit-post', data: state.new_post, method: 'POST' })
      .then(() => {

      })
      .catch(() => {
        
      })
  },
  }