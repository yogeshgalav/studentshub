export default {
    create_post(state,post){
      state.new_post = Object.assign(state.new_post,post)
    },
    submitPost(state){
      axios({url: window.App.baseUrl+'/api/submit-post', data: state.new_post, method: 'POST' })
      .then(() => {

      })
      .catch(() => {
        
      })
  },
  }